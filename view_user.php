<?php
require "includes/cc_header.php";

// Check if user is desk staff
if($_SESSION['usertype'] != 'DSK') {
    header('Location: dashboard_user.php');
    exit;
}

// Get user ID from URL
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($user_id <= 0) {
    header('Location: users.php');
    exit;
}

// Fetch user details
try {
    $stmt = $link->prepare("SELECT * FROM mf_prog_users WHERE recid = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if(!$user) {
        header('Location: users.php');
        exit;
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Handle status updates
$success_message = '';
$error_message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['update_act_status'])) {
        $new_status = $_POST['act_status'];
        try {
            $stmt = $link->prepare("UPDATE mf_prog_users SET act_status = ? WHERE recid = ?");
            $stmt->execute([$new_status, $user_id]);
            $success_message = "Active Status updated successfully!";
            // Refresh user data
            $stmt = $link->prepare("SELECT * FROM mf_prog_users WHERE recid = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error_message = "Error updating status: " . $e->getMessage();
        }
    }
    
    if(isset($_POST['update_cert_status'])) {
        $new_cert_status = $_POST['cert_status'];
        try {
            $stmt = $link->prepare("UPDATE mf_prog_users SET cert_status = ? WHERE recid = ?");
            $stmt->execute([$new_cert_status, $user_id]);
            $success_message = "Certificate Status updated successfully!";
            // Refresh user data
            $stmt = $link->prepare("SELECT * FROM mf_prog_users WHERE recid = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error_message = "Error updating certificate status: " . $e->getMessage();
        }
    }
    
    if(isset($_POST['update_print_status'])) {
        $print_status = $_POST['print_status'];
        try {
            $stmt = $link->prepare("UPDATE mf_prog_users SET print_status = ? WHERE recid = ?");
            $stmt->execute([$print_status, $user_id]);
            $success_message = "Print Status updated successfully!";
            // Refresh user data
            $stmt = $link->prepare("SELECT * FROM mf_prog_users WHERE recid = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error_message = "Error updating print status: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details - <?php echo htmlspecialchars($user['username']); ?></title>
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
            max-width: 1200px;
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

        .success-message {
            background: #efe;
            color: #3c3;
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #3c3;
        }

        .error-message {
            background: #fee;
            color: #c33;
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .info-card.full-width {
            grid-column: 1 / -1;
        }

        .card-header {
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .card-header h2 {
            color: #333;
            font-size: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #f5f5f5;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #666;
            width: 180px;
            flex-shrink: 0;
        }

        .info-value {
            color: #333;
            flex: 1;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
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

        .print-yes {
            color: #2e7d32;
            font-weight: 600;
        }

        .print-no {
            color: #c62828;
            font-weight: 600;
        }

        .action-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .action-section h3 {
            color: #333;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group select {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            background: white;
            cursor: pointer;
        }

        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn-update {
            background: #667eea;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.3s;
        }

        .btn-update:hover {
            background: #5568d3;
        }

        .btn-danger {
            background: #dc3545;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .section-divider {
            height: 2px;
            background: linear-gradient(to right, #667eea, #764ba2);
            margin: 30px 0;
            border-radius: 2px;
        }

        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            
            .info-row {
                flex-direction: column;
                gap: 5px;
            }
            
            .info-label {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                <span>👤</span> User Details
            </h1>
            <a href="users.php" class="back-btn">← Back to Users</a>
        </div>

        <?php if($success_message): ?>
            <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>

        <?php if($error_message): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <div class="content-grid">
            <!-- Account Information -->
            <div class="info-card">
                <div class="card-header">
                    <h2>🔐 Account Information</h2>
                </div>
                <div class="info-row">
                    <span class="info-label">User ID:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['userid']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Username:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['username']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['email']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Secondary Email:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['secondary_email'] ?? 'N/A'); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">User Type:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['usertype'] ?? 'N/A'); ?></span>
                </div>
            </div>

            <!-- Status Information -->
            <div class="info-card">
                <div class="card-header">
                    <h2>📊 Status Information</h2>
                </div>
                <div class="info-row">
                    <span class="info-label">Active Status:</span>
                    <span class="info-value">
                        <?php
                        $act_status = strtolower($user['act_status'] ?? 'pending');
                        $status_class = 'status-' . $act_status;
                        ?>
                        <span class="status-badge <?php echo $status_class; ?>">
                            <?php echo ucfirst($act_status); ?>
                        </span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Certificate Status:</span>
                    <span class="info-value">
                        <?php
                        $cert_status = strtolower($user['cert_status'] ?? 'pending');
                        $cert_class = 'cert-' . $cert_status;
                        ?>
                        <span class="status-badge <?php echo $cert_class; ?>">
                            <?php echo ucfirst($cert_status); ?>
                        </span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Certificate Desc:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['cert_desc'] ?? 'N/A'); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Print Status:</span>
                    <span class="info-value">
                        <?php 
                        if ($user['print_status'] == 1) {
                            echo '<span class="print-yes">✓ Printed</span>';
                        } else {
                            echo '<span class="print-no">✗ Not Printed</span>';
                        }
                        ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date Requested:</span>
                    <span class="info-value">
                        <?php 
                        if ($user['date_requested']) {
                            echo date('F j, Y g:i A', strtotime($user['date_requested']));
                        } else {
                            echo 'N/A';
                        }
                        ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date Requested Desc:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['date_requested_desc'] ?? 'N/A'); ?></span>
                </div>
            </div>
        </div>

        <!-- Partner 1 Information -->
        <div class="info-card full-width">
            <div class="card-header">
                <h2>👤 Partner 1 Information</h2>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px;">
                <div class="info-row">
                    <span class="info-label">First Name:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['partner1_fname']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Middle Name:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['partner1_mname'] ?? 'N/A'); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Last Name:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['partner1_lname']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Sex:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['partner1_sex'] ?? 'N/A'); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Birthday:</span>
                    <span class="info-value">
                        <?php 
                        if ($user['partner1_bday']) {
                            echo date('F j, Y', strtotime($user['partner1_bday']));
                        } else {
                            echo 'N/A';
                        }
                        ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Country:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['partner1_country'] ?? 'N/A'); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Municipality:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['partner1_municipality'] ?? 'N/A'); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Occupation:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['partner1_occupation'] ?? 'N/A'); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Cellphone:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['partner1_cellphone'] ?? 'N/A'); ?></span>
                </div>
            </div>
        </div>

        <!-- Partner 2 Information -->
        <div class="info-card full-width">
            <div class="card-header">
                <h2>👤 Partner 2 Information</h2>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px;">
                <div class="info-row">
                    <span class="info-label">First Name:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['partner2_fname']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Middle Name:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['partner2_mname'] ?? 'N/A'); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Last Name:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['partner2_lname']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Sex:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['partner2_sex'] ?? 'N/A'); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Birthday:</span>
                    <span class="info-value">
                        <?php 
                        if ($user['partner2_bday']) {
                            echo date('F j, Y', strtotime($user['partner2_bday']));
                        } else {
                            echo 'N/A';
                        }
                        ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Country:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['partner2_country'] ?? 'N/A'); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Municipality:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['partner2_municipality'] ?? 'N/A'); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Occupation:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['partner2_occupation'] ?? 'N/A'); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Cellphone:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['partner2_cellphone'] ?? 'N/A'); ?></span>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="info-card full-width">
            <div class="card-header">
                <h2>📝 Additional Information</h2>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px;">
                <div class="info-row">
                    <span class="info-label">PMOC Online:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['pmoc_online'] ?? 'N/A'); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Document Link:</span>
                    <span class="info-value">
                        <?php if($user['doc_link']): ?>
                            <a href="<?php echo htmlspecialchars($user['doc_link']); ?>" target="_blank" style="color: #667eea;">View Document</a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">CRM Link:</span>
                    <span class="info-value">
                        <?php if($user['crm_link']): ?>
                            <a href="<?php echo htmlspecialchars($user['crm_link']); ?>" target="_blank" style="color: #667eea;">View CRM</a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Justification:</span>
                    <span class="info-value"><?php echo nl2br(htmlspecialchars($user['justification'] ?? 'N/A')); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Remarks:</span>
                    <span class="info-value"><?php echo nl2br(htmlspecialchars($user['remarks'] ?? 'N/A')); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Checked By:</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['chk_by'] ?? 'N/A'); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Last Cancellation:</span>
                    <span class="info-value">
                        <?php 
                        if ($user['last_cancellation_date']) {
                            echo date('F j, Y', strtotime($user['last_cancellation_date']));
                        } else {
                            echo 'N/A';
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Update Actions -->
        <div class="info-card full-width">
            <div class="card-header">
                <h2>⚙️ Update Status</h2>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <!-- Update ACL Status -->
                <div class="action-section">
                    <h3>Update Active Status</h3>
                    <form method="POST">
                        <div class="form-group">
                            <label>Active Status:</label>
                            <select name="act_status" required>
                                <option value="pending" <?php echo $user['act_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="active" <?php echo $user['act_status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                <option value="inactive" <?php echo $user['act_status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                        <button type="submit" name="update_act_status" class="btn-update">Update Active Status</button>
                    </form>
                </div>

                <!-- Update Certificate Status -->
                <div class="action-section">
                    <h3>Update Certificate Status</h3>
                    <form method="POST">
                        <div class="form-group">
                            <label>Certificate Status:</label>
                            <select name="cert_status" required>
                                <option value="pending" <?php echo $user['cert_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="processing" <?php echo $user['cert_status'] == 'processing' ? 'selected' : ''; ?>>Processing</option>
                                <option value="completed" <?php echo $user['cert_status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                            </select>
                        </div>
                        <button type="submit" name="update_cert_status" class="btn-update">Update Cert Status</button>
                    </form>
                </div>

                <!-- Update Print Status -->
                <div class="action-section">
                    <h3>Update Print Status</h3>
                    <form method="POST">
                        <div class="form-group">
                            <label>Print Status:</label>
                            <select name="print_status" required>
                                <option value="0" <?php echo $user['print_status'] == 0 ? 'selected' : ''; ?>>Not Printed</option>
                                <option value="1" <?php echo $user['print_status'] == 1 ? 'selected' : ''; ?>>Printed</option>
                            </select>
                        </div>
                        <button type="submit" name="update_print_status" class="btn-update">Update Print Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>