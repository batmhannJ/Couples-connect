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
<table>
            <tr>
                <td style='width:30%'>
                <div class="row h-100 justify-content-center align-items-center">
                    <div style='width:437px;height:700px;background-color:white;border-radius:30px;filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25))'>
                        <div class="m-3 pt-2 text-center login_form_header">
                            <p style="font-weight:bold;font-size:27px;font-family:inter;margin-bottom:0">Options</p>
                            <img src="images/Rectangle 11934.png" style='width:100%'>
                        </div>

                        <?php
                        require 'cc_mf_menu.php';
                        ?>


                    </div>
                </div>
            </td>
      <td style='width:70%'>
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4"><i class="fas fa-comments"></i> Customer Inquiries</h2>
                
                <?php if ($success_message): ?>
                    <div class="alert alert-success"><?php echo $success_message; ?></div>
                <?php endif; ?>
                
                <?php if ($error_message): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>

                <?php if (!empty($inquiries)): ?>
                    <?php foreach ($inquiries as $inquiry): ?>
                        <div class="inquiry-card <?php echo $inquiry['is_answered'] ? 'answered' : 'unanswered'; ?>">
                            <div class="card-header bg-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">
                                            <i class="fas fa-user"></i> 
                                            <?php 
                                            $name = $inquiry['partner1_fname'] ? $inquiry['partner1_fname'] . ' ' . $inquiry['partner1_lname'] : $inquiry['username'];
                                            echo htmlspecialchars($name ?: 'Unknown User'); 
                                            ?>
                                        </h6>
                                        <small class="text-muted">
                                            <?php echo date('F j, Y - g:i A', strtotime($inquiry['created_at'])); ?>
                                        </small>
                                    </div>
                                    <div>
                                        <?php if ($inquiry['is_answered']): ?>
                                            <span class="badge bg-success">Answered</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Pending</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                <!-- Customer Question -->
                                <div class="customer-message">
                                    <h6><i class="fas fa-question-circle text-primary"></i> Customer Question:</h6>
                                    <p class="mb-0"><?php echo nl2br(htmlspecialchars($inquiry['message'])); ?></p>
                                </div>

                                <!-- Staff Response (if answered) -->
                                <?php if ($inquiry['is_answered'] && $inquiry['staff_response']): ?>
                                    <div class="staff-response">
                                        <h6><i class="fas fa-reply text-success"></i> Staff Response:</h6>
                                        <p class="mb-0"><?php echo nl2br(htmlspecialchars($inquiry['staff_response'])); ?></p>
                                        <small class="text-muted">
                                            Responded on 
                                            <?php echo date('F j, Y - g:i A', strtotime($inquiry['answered_at'])); ?>
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
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No Inquiries Found</h4>
                        <p class="text-muted">There are no customer inquiries at this time.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
                </td>
                </tr>
                </table>

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