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
    </style>
</head>
<body class="bg-light">
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
<form name='myforms' id="myforms" method="post" target="_self" style='min-height:100vh; background: linear-gradient(135deg, rgb(215, 217, 225) 0%, rgb(162, 185, 231) 100%); padding: 20px; font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;'>
    <div style="max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: 320px 1fr; gap: 24px; height: calc(100vh - 40px);">
        
        <!-- Left Sidebar -->
        <div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 24px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); padding: 24px 20px; height: fit-content; max-height: calc(100vh - 80px); border: 1px solid rgba(255, 255, 255, 0.2); overflow-y: auto;">
            <div style="text-align: center; margin-bottom: 20px;">
                <h2 style="font-size: 24px; font-weight: 700; color: #1a1a1a; margin: 0 0 12px 0;">Options</h2>
                <div style="height: 3px; background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%); border-radius: 2px; width: 100%;"></div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px;">
                <?php
                require 'cc_mf_menu.php';
                ?>
            </div>
        </div>

        <!-- Main Content -->
        <div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 24px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; border: 1px solid rgba(255, 255, 255, 0.2); height: calc(100vh - 80px); overflow: hidden;">

            <!-- Header -->
            <div style="padding: 20px 32px 16px 32px; text-align: center; border-bottom: 1px solid rgba(0, 0, 0, 0.05); flex-shrink: 0;">
                <h1 style="font-size: 26px; font-weight: 700; color: #1a1a1a; margin: 0 0 10px 0;">Customer Inquiries</h1>
                <div style="height: 3px; background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%); border-radius: 2px; width: 260px; margin: 0 auto;"></div>
            </div>

            <!-- Content Area -->
            <div style="flex: 1; padding: 24px 32px; overflow-y: auto; min-height: 0;">
                
                <!-- Success Message -->
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
                                            <div style="margin-bottom: 16px;">
                                                <h4 style="font-size: 16px; font-weight: 700; color: #059669; margin: 0 0 12px 0; display: flex; align-items: center; gap: 8px;">
                                                    <span>↩️</span> Staff Response:
                                                </h4>
                                                <div style="background: rgba(16, 185, 129, 0.05); padding: 16px 20px; border-radius: 12px; border-left: 4px solid #10b981;">
                                                    <p style="color: #374151; margin: 0 0 8px 0; line-height: 1.6; white-space: pre-line; font-size: 16px; font-weight: 500;"><?php echo htmlspecialchars($inquiry['staff_response']); ?></p>
                                                    <small style="color: #6b7280; font-size: 13px;">
                                                        Responded on <?php echo date('F j, Y - g:i A', strtotime($inquiry['answered_at'])); ?>
                                                    </small>
                                                </div>
                                            </div>
                                        
                                        <!-- Response Form (if not answered and user is staff) -->
                                        <?php elseif (in_array($_SESSION['usertype'], ['DSK', 'CNR', 'HED'])): ?>
                                            <div style="margin-top: 20px;">
                                                <input type="hidden" name="message_id" value="<?php echo $inquiry['id']; ?>">
                                                <div style="margin-bottom: 16px;">
                                                    <label style="display: block; font-size: 16px; font-weight: 700; color: #059669; margin-bottom: 8px;">
                                                        <span style="margin-right: 8px;">↩️</span> Your Response:
                                                    </label>
                                                    <textarea name="staff_response" style="width: 100%; padding: 12px 16px; border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 12px; font-family: inherit; font-size: 14px; line-height: 1.5; resize: vertical; min-height: 120px; background: rgba(255, 255, 255, 0.8); transition: all 0.3s ease;" 
                                                            placeholder="Type your response here..." required 
                                                            onfocus='this.style.borderColor="#4f46e5"; this.style.boxShadow="0 0 0 3px rgba(79, 70, 229, 0.1)";'
                                                            onblur='this.style.borderColor="rgba(0, 0, 0, 0.1)"; this.style.boxShadow="none";'></textarea>
                                                </div>
                                                <button type="submit" name="respond" style="background: linear-gradient(135deg, #059669 0%, #047857 100%); color: white; border: none; padding: 12px 24px; border-radius: 12px; font-size: 15px; font-family: Inter; font-weight: 600; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3); cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px; width: 140px;" 
                                                       onmouseover='this.style.transform="translateY(-2px)"; this.style.boxShadow="0 6px 20px rgba(5, 150, 105, 0.4)";' 
                                                       onmouseout='this.style.transform="translateY(0)"; this.style.boxShadow="0 4px 12px rgba(5, 150, 105, 0.3)";'>
                                                    <span>📤</span> Send Response
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
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

    <!-- Responsive Design -->
    <style>
        @media (max-width: 1200px) {
            form > div {
                grid-template-columns: 1fr !important;
                gap: 16px !important;
            }
            
            form > div > div:first-child {
                order: 2;
                height: auto !important;
                max-height: none !important;
            }
            
            form > div > div:last-child {
                order: 1;
                height: auto !important;
            }
        }
        
        @media (max-width: 768px) {
            form {
                padding: 12px !important;
            }
            
            h1 {
                font-size: 22px !important;
            }
            
            h2 {
                font-size: 20px !important;
            }
            
            /* Mobile inquiry card styling */
            form > div > div:last-child > div:last-child > div > div:last-child > div > div {
                padding: 16px !important;
                margin: 0 -8px !important;
            }
        }
        
        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(79, 70, 229, 0.3);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(79, 70, 229, 0.5);
        }
        
        /* Form Focus States */
        textarea:focus {
            outline: none !important;
        }
        
        /* Button Hover Effects */
        button:active {
            transform: translateY(0px) !important;
        }
        
        /* Smooth Animations */
        * {
            transition: all 0.3s ease;
        }
    </style>

    <input type="hidden" name="ac_recid_hidden" id="ac_recid_hidden">
    
</form>

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