<?php
require "includes/cc_header.php";

// Check if user is office head (HED)
if($_SESSION['usertype'] != 'HED') {
    header('Location: dashboard_user.php');
    exit;
}

// Get date range filter (default: last 30 days)
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : date('Y-m-d', strtotime('-30 days'));
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : date('Y-m-d');

// 1. Get total registered couples
try {
    $stmt = $link->prepare("
        SELECT COUNT(*) as total,
               SUM(CASE WHEN acl_status = 'active' THEN 1 ELSE 0 END) as active,
               SUM(CASE WHEN acl_status = 'pending' THEN 1 ELSE 0 END) as pending,
               SUM(CASE WHEN cert_status = 'completed' THEN 1 ELSE 0 END) as completed_certs
        FROM mf_prog_users
        WHERE date_requested BETWEEN ? AND ?
    ");
    $stmt->execute([$date_from, $date_to]);
    $couples_stats = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $couples_stats = ['total' => 0, 'active' => 0, 'pending' => 0, 'completed_certs' => 0];
}

// 2. Get couples by country (demographics)
try {
    $stmt = $link->prepare("
        SELECT partner1_country, COUNT(*) as count
        FROM mf_prog_users
        WHERE date_requested BETWEEN ? AND ?
        AND partner1_country IS NOT NULL
        AND partner1_country != ''
        GROUP BY partner1_country
        ORDER BY count DESC
        LIMIT 10
    ");
    $stmt->execute([$date_from, $date_to]);
    $country_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $country_stats = [];
}

// 3. Get registration trends by month
try {
    $stmt = $link->prepare("
        SELECT DATE_FORMAT(date_requested, '%Y-%m') as month,
               COUNT(*) as count
        FROM mf_prog_users
        WHERE date_requested >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
        GROUP BY month
        ORDER BY month ASC
    ");
    $stmt->execute();
    $monthly_trends = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $monthly_trends = [];
}

// 4. Get feedback/counseling concerns statistics
try {
    $stmt = $link->prepare("
        SELECT 
            COUNT(*) as total_feedback,
            SUM(CASE WHEN status = 'unread' THEN 1 ELSE 0 END) as unread,
            SUM(CASE WHEN status = 'read' THEN 1 ELSE 0 END) as read
        FROM user_feedback
        WHERE date_submitted BETWEEN ? AND ?
    ");
    $stmt->execute([$date_from, $date_to]);
    $feedback_stats = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $feedback_stats = ['total_feedback' => 0, 'unread' => 0, 'read' => 0];
}

// 5. Get recent feedback subjects/concerns
try {
    $stmt = $link->prepare("
        SELECT subject, COUNT(*) as count
        FROM user_feedback
        WHERE date_submitted BETWEEN ? AND ?
        GROUP BY subject
        ORDER BY count DESC
        LIMIT 5
    ");
    $stmt->execute([$date_from, $date_to]);
    $top_concerns = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $top_concerns = [];
}

// 6. Get certificate status breakdown
try {
    $stmt = $link->prepare("
        SELECT cert_status, COUNT(*) as count
        FROM mf_prog_users
        WHERE date_requested BETWEEN ? AND ?
        GROUP BY cert_status
    ");
    $stmt->execute([$date_from, $date_to]);
    $cert_breakdown = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $cert_breakdown = [];
}

// 7. Get print statistics
try {
    $stmt = $link->prepare("
        SELECT 
            SUM(CASE WHEN print_status = 1 THEN 1 ELSE 0 END) as printed,
            SUM(CASE WHEN print_status = 0 THEN 1 ELSE 0 END) as not_printed
        FROM mf_prog_users
        WHERE date_requested BETWEEN ? AND ?
    ");
    $stmt->execute([$date_from, $date_to]);
    $print_stats = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $print_stats = ['printed' => 0, 'not_printed' => 0];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard - Couples Connect</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 25px 30px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #667eea;
            font-size: 28px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .back-btn {
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 14px;
        }

        .back-btn:hover {
            background: #5568d3;
        }

        .filter-section {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .filter-form {
            display: flex;
            gap: 15px;
            align-items: end;
        }

        .form-group {
            flex: 1;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }

        .filter-btn {
            background: #667eea;
            color: white;
            padding: 10px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.3s;
        }

        .filter-btn:hover {
            background: #5568d3;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .stat-card h3 {
            color: #666;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #333;
        }

        .stat-card.primary .stat-number {
            color: #667eea;
        }

        .stat-card.success .stat-number {
            color: #4caf50;
        }

        .stat-card.warning .stat-number {
            color: #ff9800;
        }

        .stat-card.info .stat-number {
            color: #2196f3;
        }

        .chart-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .chart-container h2 {
            color: #333;
            font-size: 20px;
            margin-bottom: 20px;
        }

        .chart-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .table-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: #f8f9fa;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #e0e0e0;
            font-size: 14px;
        }

        .data-table td {
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
            color: #555;
            font-size: 14px;
        }

        .data-table tr:hover {
            background: #f8f9fa;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e0e0e0;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #667eea;
            transition: width 0.3s;
        }

        @media (max-width: 768px) {
            .chart-grid {
                grid-template-columns: 1fr;
            }
            
            .filter-form {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                <span>📊</span> Analytics Dashboard
            </h1>
            <a href="select_option.php" class="back-btn">← Back to Dashboard</a>
        </div>

        <!-- Date Filter -->
        <div class="filter-section">
            <form method="GET" class="filter-form">
                <div class="form-group">
                    <label>From Date:</label>
                    <input type="date" name="date_from" value="<?php echo $date_from; ?>" required>
                </div>
                <div class="form-group">
                    <label>To Date:</label>
                    <input type="date" name="date_to" value="<?php echo $date_to; ?>" required>
                </div>
                <button type="submit" class="filter-btn">Apply Filter</button>
            </form>
        </div>

        <!-- Key Statistics -->
        <div class="stats-grid">
            <div class="stat-card primary">
                <h3>Total Registered Couples</h3>
                <div class="stat-number"><?php echo number_format($couples_stats['total']); ?></div>
            </div>
            <div class="stat-card success">
                <h3>Active Accounts</h3>
                <div class="stat-number"><?php echo number_format($couples_stats['active']); ?></div>
            </div>
            <div class="stat-card warning">
                <h3>Pending Accounts</h3>
                <div class="stat-number"><?php echo number_format($couples_stats['pending']); ?></div>
            </div>
            <div class="stat-card info">
                <h3>Completed Certificates</h3>
                <div class="stat-number"><?php echo number_format($couples_stats['completed_certs']); ?></div>
            </div>
        </div>

        <!-- Feedback Statistics -->
        <div class="stats-grid">
            <div class="stat-card primary">
                <h3>Total Feedback/Concerns</h3>
                <div class="stat-number"><?php echo number_format($feedback_stats['total_feedback']); ?></div>
            </div>
            <div class="stat-card warning">
                <h3>Unread Feedback</h3>
                <div class="stat-number"><?php echo number_format($feedback_stats['unread']); ?></div>
            </div>
            <div class="stat-card success">
                <h3>Resolved Feedback</h3>
                <div class="stat-number"><?php echo number_format($feedback_stats['read']); ?></div>
            </div>
            <div class="stat-card info">
                <h3>Response Rate</h3>
                <div class="stat-number">
                    <?php 
                    if($feedback_stats['total_feedback'] > 0) {
                        echo round(($feedback_stats['read'] / $feedback_stats['total_feedback']) * 100);
                    } else {
                        echo '0';
                    }
                    ?>%
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="chart-grid">
            <div class="chart-container">
                <h2>Registration Trend (Last 6 Months)</h2>
                <canvas id="trendChart"></canvas>
            </div>
            <div class="chart-container">
                <h2>Certificate Status Breakdown</h2>
                <canvas id="certChart"></canvas>
            </div>
        </div>

        <!-- Demographics Table -->
        <div class="table-container">
            <h2 style="margin-bottom: 20px; color: #333;">Couples by Country (Top 10)</h2>
            <?php if(!empty($country_stats)): ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Country</th>
                            <th>Number of Couples</th>
                            <th>Percentage</th>
                            <th>Distribution</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_countries = array_sum(array_column($country_stats, 'count'));
                        foreach($country_stats as $country): 
                            $percentage = round(($country['count'] / $total_countries) * 100, 1);
                        ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($country['partner1_country']); ?></strong></td>
                                <td><?php echo number_format($country['count']); ?></td>
                                <td><?php echo $percentage; ?>%</td>
                                <td>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: <?php echo $percentage; ?>%"></div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="text-align: center; color: #666; padding: 40px;">No data available for the selected period</p>
            <?php endif; ?>
        </div>

        <!-- Top Concerns Table -->
        <div class="table-container">
            <h2 style="margin-bottom: 20px; color: #333;">Top Counseling Concerns</h2>
            <?php if(!empty($top_concerns)): ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Concern/Subject</th>
                            <th>Frequency</th>
                            <th>Distribution</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_concerns = array_sum(array_column($top_concerns, 'count'));
                        foreach($top_concerns as $concern): 
                            $percentage = round(($concern['count'] / $total_concerns) * 100, 1);
                        ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($concern['subject']); ?></strong></td>
                                <td><?php echo number_format($concern['count']); ?></td>
                                <td>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: <?php echo $percentage; ?>%"></div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="text-align: center; color: #666; padding: 40px;">No feedback data available for the selected period</p>
            <?php endif; ?>
        </div>

        <!-- Print Statistics -->
        <div class="stats-grid">
            <div class="stat-card success">
                <h3>Certificates Printed</h3>
                <div class="stat-number"><?php echo number_format($print_stats['printed']); ?></div>
            </div>
            <div class="stat-card warning">
                <h3>Pending Print</h3>
                <div class="stat-number"><?php echo number_format($print_stats['not_printed']); ?></div>
            </div>
        </div>
    </div>

    <script>
        // Registration Trend Chart
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        const trendChart = new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($monthly_trends, 'month')); ?>,
                datasets: [{
                    label: 'Registrations',
                    data: <?php echo json_encode(array_column($monthly_trends, 'count')); ?>,
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Certificate Status Chart
        const certCtx = document.getElementById('certChart').getContext('2d');
        const certLabels = <?php echo json_encode(array_column($cert_breakdown, 'cert_status')); ?>;
        const certData = <?php echo json_encode(array_column($cert_breakdown, 'count')); ?>;
        
        const certChart = new Chart(certCtx, {
            type: 'doughnut',
            data: {
                labels: certLabels.map(label => label.charAt(0).toUpperCase() + label.slice(1)),
                datasets: [{
                    data: certData,
                    backgroundColor: [
                        '#667eea',
                        '#ff9800',
                        '#4caf50',
                        '#f44336'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>