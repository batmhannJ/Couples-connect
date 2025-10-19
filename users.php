<?php
require "includes/cc_header.php";

// Check if user is desk staff (DSK or staff role) - UPDATED TO MATCH feedback_management.php
if($_SESSION['usertype'] != 'DSK') {
    header('Location: dashboard_user.php');
    exit;
}

$search_results = [];
$search_query = '';
$error_message = '';
$success_message = '';

// Handle search request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $search_query = trim($_POST['search_query']);
    
    if (!empty($search_query)) {
        try {
            $stmt = $link->prepare("
                SELECT * FROM mf_prog_users
                WHERE username LIKE :search 
                   OR email LIKE :search 
                   OR partner1_fname LIKE :search
                   OR partner1_lname LIKE :search
                   OR partner2_fname LIKE :search
                   OR partner2_lname LIKE :search
                ORDER BY date_requested DESC
            ");
            
            $search_param = "%{$search_query}%";
            $stmt->bindParam(':search', $search_param);
            $stmt->execute();
            $search_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            $error_message = "Search error: " . $e->getMessage();
        }
    } else {
        // If empty search, show all users
        try {
            $stmt = $link->query("SELECT * FROM mf_prog_users ORDER BY date_requested DESC");
            $search_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error_message = "Error loading users: " . $e->getMessage();
        }
    }
} else {
    // Load all users on initial page load
    try {
        $stmt = $link->query("SELECT * FROM mf_prog_users ORDER BY date_requested DESC");
        $search_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error_message = "Error loading users: " . $e->getMessage();
    }
}

// Get total user counts
$total_users = 0;
$active_users = 0;
$pending_users = 0;

try {
    $stmt = $link->query("SELECT COUNT(*) as total FROM mf_prog_users");
    $total_users = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    $stmt = $link->query("SELECT COUNT(*) as active FROM mf_prog_users WHERE acl_status = 'active'");
    $active_users = $stmt->fetch(PDO::FETCH_ASSOC)['active'];
    
    $stmt = $link->query("SELECT COUNT(*) as pending FROM mf_prog_users WHERE acl_status = 'pending'");
    $pending_users = $stmt->fetch(PDO::FETCH_ASSOC)['pending'];
} catch (PDOException $e) {
    // Handle error silently
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Couples Connect</title>
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

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .stat-icon.total {
            background: #e3f2fd;
            color: #2196f3;
        }

        .stat-icon.active {
            background: #e8f5e9;
            color: #4caf50;
        }

        .stat-icon.pending {
            background: #fff3e0;
            color: #ff9800;
        }

        .stat-info h3 {
            font-size: 14px;
            color: #666;
            font-weight: 500;
        }

        .stat-info p {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-top: 5px;
        }

        /* Search Box */
        .search-box {
            background: white;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .search-form {
            display: flex;
            gap: 10px;
        }

        .search-input {
            flex: 1;
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
        }

        .search-btn {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
            font-weight: 500;
        }

        .search-btn:hover {
            background: #5568d3;
        }

        .clear-btn {
            background: #6c757d;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .clear-btn:hover {
            background: #5a6268;
        }

        /* Messages */
        .error-message {
            background: #fee;
            color: #c33;
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
        }

        .success-message {
            background: #efe;
            color: #3c3;
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #3c3;
        }

        /* Results Container */
        .results-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .results-header h2 {
            color: #333;
            font-size: 20px;
        }

        .results-count {
            color: #666;
            font-size: 14px;
        }

        .no-results {
            text-align: center;
            color: #666;
            padding: 60px 20px;
            font-size: 18px;
        }

        /* Table Styles */
        .users-table {
            width: 100%;
            border-collapse: collapse;
            overflow-x: auto;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .users-table th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #e0e0e0;
            font-size: 14px;
            white-space: nowrap;
        }

        .users-table td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            color: #555;
            font-size: 14px;
        }

        .users-table tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }

        .status-active {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-pending {
            background: #fff3e0;
            color: #e65100;
        }

        .status-inactive {
            background: #ffebee;
            color: #c62828;
        }

        .cert-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }

        .cert-completed {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .cert-pending {
            background: #e3f2fd;
            color: #1565c0;
        }

        .cert-processing {
            background: #fff3e0;
            color: #e65100;
        }

        .action-btn {
            background: #667eea;
            color: white;
            padding: 6px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s;
        }

        .action-btn:hover {
            background: #5568d3;
        }

        .action-btn.danger {
            background: #dc3545;
        }

        .action-btn.danger:hover {
            background: #c82333;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .user-name {
            font-weight: 600;
            color: #333;
        }

        .user-email {
            color: #666;
            font-size: 12px;
        }

        .date-text {
            color: #666;
            font-size: 13px;
        }

        .print-status {
            font-size: 12px;
            color: #666;
        }

        .print-yes {
            color: #2e7d32;
            font-weight: 600;
        }

        .print-no {
            color: #c62828;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>
                <span>👥</span> User Management
            </h1>
            <a href="select_option.php" class="back-btn">← Back to Dashboard</a>
        </div>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon total">
                    <span>👥</span>
                </div>
                <div class="stat-info">
                    <h3>Total Users</h3>
                    <p><?php echo $total_users; ?></p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon active">
                    <span>✓</span>
                </div>
                <div class="stat-info">
                    <h3>Active Users</h3>
                    <p><?php echo $active_users; ?></p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon pending">
                    <span>⏳</span>
                </div>
                <div class="stat-info">
                    <h3>Pending Users</h3>
                    <p><?php echo $pending_users; ?></p>
                </div>
            </div>
        </div>

        <!-- Search Box -->
        <div class="search-box">
            <form method="POST" class="search-form">
                <input 
                    type="text" 
                    name="search_query" 
                    class="search-input" 
                    placeholder="Search by username, email, or partner names..."
                    value="<?php echo htmlspecialchars($search_query); ?>"
                >
                <button type="submit" name="search" class="search-btn">🔍 Search</button>
                <button type="button" class="clear-btn" onclick="window.location.href='users.php'">Clear</button>
            </form>
        </div>

        <!-- Messages -->
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>

        <!-- Results Container -->
        <div class="results-container">
            <div class="results-header">
                <h2>User Records</h2>
                <span class="results-count">
                    <?php echo count($search_results); ?> user(s) found
                </span>
            </div>

            <?php if (empty($search_results)): ?>
                <div class="no-results">
                    <p>📋 No users found</p>
                    <p style="font-size: 14px; margin-top: 10px; color: #999;">
                        <?php echo $search_query ? 'Try a different search term' : 'No users registered yet'; ?>
                    </p>
                </div>
            <?php else: ?>
                <div class="table-wrapper">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Info</th>
                                <th>Partner 1</th>
                                <th>Partner 2</th>
                                <th>Country</th>
                                <th>ACL Status</th>
                                <th>Cert Status</th>
                                <th>Date Requested</th>
                                <th>Print Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($search_results as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['recid']); ?></td>
                                    <td>
                                        <div class="user-info">
                                            <span class="user-name">
                                                <?php echo htmlspecialchars($user['username']); ?>
                                            </span>
                                            <span class="user-email">
                                                <?php echo htmlspecialchars($user['email']); ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-info">
                                            <span class="user-name">
                                                <?php echo htmlspecialchars($user['partner1_fname'] . ' ' . $user['partner1_lname']); ?>
                                            </span>
                                            <span class="user-email">
                                                <?php echo htmlspecialchars($user['partner1_sex'] ?? 'N/A'); ?> • 
                                                <?php echo htmlspecialchars($user['partner1_bday'] ?? 'N/A'); ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-info">
                                            <span class="user-name">
                                                <?php echo htmlspecialchars($user['partner2_fname'] . ' ' . $user['partner2_lname']); ?>
                                            </span>
                                            <span class="user-email">
                                                <?php echo htmlspecialchars($user['partner2_sex'] ?? 'N/A'); ?> • 
                                                <?php echo htmlspecialchars($user['partner2_bday'] ?? 'N/A'); ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($user['partner1_country'] ?? 'N/A'); ?></td>
                                    <td>
                                        <?php
                                        $acl_status = strtolower($user['acl_status'] ?? 'pending');
                                        $status_class = 'status-' . $acl_status;
                                        ?>
                                        <span class="status-badge <?php echo $status_class; ?>">
                                            <?php echo ucfirst($acl_status); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                        $cert_status = strtolower($user['cert_status'] ?? 'pending');
                                        $cert_class = 'cert-' . $cert_status;
                                        ?>
                                        <span class="cert-badge <?php echo $cert_class; ?>">
                                            <?php echo ucfirst($cert_status); ?>
                                        </span>
                                    </td>
                                    <td class="date-text">
                                        <?php 
                                        if ($user['date_requested']) {
                                            echo date('M d, Y', strtotime($user['date_requested']));
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </td>
                                    <td class="print-status">
                                        <?php 
                                        $print_status = $user['print_status'] ?? 0;
                                        if ($print_status == 1) {
                                            echo '<span class="print-yes">✓ Printed</span>';
                                        } else {
                                            echo '<span class="print-no">✗ Not Printed</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="view_user.php?id=<?php echo $user['recid']; ?>" class="action-btn">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>