<?php
require "includes/cc_header.php";

$header_name = '';
if ($_SESSION['usertype'] == 'DSK') {
    $header_name = "DESK";
} else if ($_SESSION['usertype'] == 'CNR') {
    $header_name = "COUNSELOR";
} else if ($_SESSION['usertype'] == 'HED') {
    $header_name = "HEAD";
}

$success_message = '';
$error_message = '';

// Handle response submission
if ($_POST && isset($_POST['respond'])) {
    $message_id = (int)$_POST['message_id'];
    $response = trim($_POST['staff_response']);
    
    // Get staff info from mf_prog_users table based on session user_id
    $staff_info = $header_name; // Default fallback
    if (isset($_SESSION['user_id'])) {
        $staff_sql = "SELECT partner1_fname, partner1_lname, username FROM mf_prog_users WHERE recid = ?";
        $staff_stmt = $link->prepare($staff_sql);
        $staff_stmt->bindParam(1, $_SESSION['user_id'], PDO::PARAM_INT);
        $staff_stmt->execute();
        $staff_data = $staff_stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($staff_data) {
            if ($staff_data['partner1_fname'] && $staff_data['partner1_lname']) {
                $staff_info = $staff_data['partner1_fname'] . ' ' . $staff_data['partner1_lname'];
            } else if ($staff_data['username']) {
                $staff_info = $staff_data['username'];
            }
        }
    }
    
    if (!empty($response) && $message_id > 0) {
        $update_sql = "UPDATE user_messages SET staff_response = ?, is_answered = 1, answered_at = NOW(), answered_by = ? WHERE id = ?";
        $stmt = $link->prepare($update_sql);
        $stmt->bindParam(1, $response, PDO::PARAM_STR);
        $stmt->bindParam(2, $staff_info, PDO::PARAM_STR);
        $stmt->bindParam(3, $message_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $success_message = "Response sent successfully!";
        } else {
            $error_message = "Error sending response.";
        }
    }
}

// Get all inquiries - PDO version
$sql = "SELECT um.*, mpu.partner1_fname, mpu.partner1_lname, mpu.username 
        FROM user_messages um 
        LEFT JOIN mf_prog_users mpu ON um.user_id = mpu.recid 
        ORDER BY um.created_at DESC";
$stmt = $link->prepare($sql);
$stmt->execute();
$inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Inquiries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }
        
        .main-container {
            display: flex;
            min-height: calc(100vh - 99px);
        }
        
        .sidebar-container {
            width: 30%;
            min-width: 350px;
            position: sticky;
            top: 0;
            align-self: flex-start;
            padding: 20px;
        }
        
        .content-container {
            width: 70%;
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }
        
        .sidebar-card {
            width: 100%;
            max-width: 437px;
            height: 700px;
            background-color: white;
            border-radius: 30px;
            filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25));
            position: sticky;
            top: 20px;
        }
        
        .inquiry-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .unanswered {
            border-left: 4px solid #dc3545;
        }
        
        .answered {
            border-left: 4px solid #28a745;
        }
        
        .customer-message {
            background-color: #f8f9fa;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border-left: 3px solid #007bff;
        }
        
        .staff-response {
            background-color: #e8f5e8;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border-left: 3px solid #28a745;
        }
        
        @media (max-width: 992px) {
            .main-container {
                flex-direction: column;
            }
            
            .sidebar-container,
            .content-container {
                width: 100%;
            }
            
            .sidebar-container {
                position: relative;
                min-height: auto;
            }
            
            .sidebar-card {
                position: relative;
                height: auto;
                min-height: 400px;
            }
        }
    </style>
</head>
<body class="bg-light">
    <!-- Header -->
    <div class="container-fluid">
        <div class='row bg-white' style="height:99px">
            <div class="col-3 pe-0 d-flex align-items-center">
                <img src="images/350 x 88.png" style='height:76px;width:auto;'>
            </div>

            <div class="col-3 offset-6" style="display:flex;flex-direction:row;justify-content:center;font-family:inter;font-size:21px;align-items:center">
                <div style="flex:0.5;text-align:right;margin-right:10px">
                    <a href="http://localhost/couples-connect/select_option.php" style='color:black;text-decoration:none' class='has_hover'>HOME</a>
                </div>

                <div style="flex:.1;text-align:center;padding-right:10px">
                    <a style='color:black;text-decoration:none'>|</a>
                </div>

                <div style="flex:.3;text-align:center;padding-right:15px">
                    <a style='color:black;text-decoration:none'><?php echo $header_name; ?> </a>
                </div>

                <div style="flex:0.6;text-align:right;padding-right:35px">
                    <a href="http://localhost/couples-connect/logout_cc.php" class='has_hover' style='color:black;text-decoration:none'>LOGOUT</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar-container">
            <div class="d-flex justify-content-center">
                <div class="sidebar-card">
                    <div class="m-3 pt-2 text-center login_form_header">
                        <p style="font-weight:bold;font-size:27px;font-family:inter;margin-bottom:0">Options</p>
                        <img src="images/Rectangle 11934.png" style='width:100%'>
                    </div>

                    <?php
                    require 'cc_mf_menu.php';
                    ?>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-container">
            <div class="container-fluid">
                <h2 class="mb-4"><i class="fas fa-comments"></i> Customer Inquiries</h2>
                
                <?php if ($success_message): ?>
                    <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 16px 20px; border-radius: 16px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); border: 1px solid rgba(255, 255, 255, 0.2);">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Error Message -->
                <?php if ($error_message): ?>
                    <div style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 16px 20px; border-radius: 16px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); border: 1px solid rgba(255, 255, 255, 0.2);">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <div style="background: rgba(255, 255, 255, 0.7); border-radius: 16px; border: 1px solid rgba(0, 0, 0, 0.05); min-height: 100%; display: flex; flex-direction: column;">
                    
                    <!-- Inquiries List -->
                    <?php if (!empty($inquiries)): ?>
                        <div style="flex: 1; padding: 0 32px 24px 32px; overflow-y: auto;">
                            <div style="display: flex; flex-direction: column; gap: 20px; padding-top: 24px;">
                                <?php foreach ($inquiries as $inquiry): ?>
                                    <div style="background: rgba(255, 255, 255, 0.8); border-radius: 12px; padding: 20px; border: 1px solid rgba(0, 0, 0, 0.05); transition: all 0.2s ease; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);" onmouseover='this.style.boxShadow="0 4px 16px rgba(0, 0, 0, 0.08)"; this.style.transform="translateY(-2px)";' onmouseout='this.style.boxShadow="0 2px 8px rgba(0, 0, 0, 0.04)"; this.style.transform="translateY(0)";'>
                                        
                                        <!-- Card Header -->
                                        <div style="margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid rgba(0, 0, 0, 0.08);">
                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                                <h3 style="font-size: 16px; font-weight: 600; color: #1f2937; margin: 0; display: flex; align-items: center; gap: 8px;">
                                                    <span style="color: #4f46e5;">👤</span>
                                                    <?php 
                                                    $name = $inquiry['partner1_fname'] ? $inquiry['partner1_fname'] . ' ' . $inquiry['partner1_lname'] : $inquiry['username'];
                                                    echo htmlspecialchars($name ?: 'Unknown User'); 
                                                    ?>
                                                </h3>
                                                <div>
                                                    <?php if ($inquiry['is_answered']): ?>
                                                        <span style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                                            Answered
                                                        </span>
                                                    <?php else: ?>
                                                        <span style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                                            Pending
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <p style="font-size: 14px; color: #6b7280; margin: 0;">
                                                <?php echo date('F j, Y - g:i A', strtotime($inquiry['created_at'])); ?>
                                            </p>
                                        </div>
                                        
                                        <!-- Customer Question -->
                                        <div style="margin-bottom: 20px;">
                                            <h4 style="font-size: 16px; font-weight: 700; color: #4f46e5; margin: 0 0 12px 0; display: flex; align-items: center; gap: 8px;">
                                                <span>❓</span> Customer Question:
                                            </h4>
                                            <div style="background: rgba(79, 70, 229, 0.05); padding: 16px 20px; border-radius: 12px; border-left: 4px solid #4f46e5;">
                                                <p style="color: #374151; margin: 0; line-height: 1.6; white-space: pre-line; font-size: 16px; font-weight: 500;"><?php echo htmlspecialchars($inquiry['message']); ?></p>
                                            </div>
                                        </div>

                                <!-- Staff Response (if answered) -->
                                <?php if ($inquiry['is_answered'] && $inquiry['staff_response']): ?>
                                    <div class="staff-response">
                                        <h6><i class="fas fa-reply text-success"></i> Staff Response:</h6>
                                        <p class="mb-0"><?php echo nl2br(htmlspecialchars($inquiry['staff_response'])); ?></p>
                                        <small class="text-muted">
                                            Responded on 
                                            <?php echo date('F j, Y - g:i A', strtotime($inquiry['answered_at'])); ?>
                                            <?php if ($inquiry['answered_by']): ?>
                                                by <?php echo htmlspecialchars($inquiry['answered_by']); ?>
                                            <?php endif; ?>
                                        </small>
                                    </div>
                                
                                <!-- Response Form (if not answered and user is staff) -->
                                <?php elseif (in_array($_SESSION['usertype'], ['DSK', 'CNR', 'HED'])): ?>
                                    <form method="POST" class="mt-3">
                                        <input type="hidden" name="message_id" value="<?php echo $inquiry['id']; ?>">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                <i class="fas fa-reply text-success"></i> Your Response:
                                            </label>
                                            <textarea name="staff_response" class="form-control" rows="4" 
                                                    placeholder="Type your response here..." required></textarea>
                                        </div>
                                        <button type="submit" name="respond" class="btn btn-success">
                                            <i class="fas fa-paper-plane"></i> Send Response
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    
                    <!-- No Inquiries State -->
                    <?php else: ?>
                        <div style="text-align: center; padding: 80px 20px; color: #6b7280; flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <div style="font-size: 64px; margin-bottom: 20px; opacity: 0.5;">📥</div>
                            <h3 style="font-size: 24px; font-weight: 600; color: #9ca3af; margin: 0 0 12px 0;">No Inquiries Found</h3>
                            <p style="font-size: 16px; margin: 0; opacity: 0.8;">There are no customer inquiries at this time.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Confirm before sending response
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                const response = form.querySelector('textarea[name="staff_response"]').value.trim();
                if (!response) {
                    alert('Please enter a response before submitting.');
                    e.preventDefault();
                    return;
                }
                
                if (!confirm('Are you sure you want to send this response?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>