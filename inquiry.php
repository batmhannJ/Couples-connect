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
                <h1 style="font-size: 26px; font-weight: 700; color: #1a1a1a; margin: 0 0 10px 0;">Question List</h1>
                <div style="height: 3px; background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%); border-radius: 2px; width: 260px; margin: 0 auto;"></div>
            </div>

            <!-- Content Area -->
            <div style="flex: 1; padding: 24px 32px; overflow-y: auto; min-height: 0;">
                
                <!-- Add Question Button -->
                <div style="margin-bottom: 24px;">
                    <a href="new_question.php" style="background: linear-gradient(135deg, #9f9cd0ff 0%, #a99fbcff 100%); color: white; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-size: 15px; font-family: Inter; font-weight: 600; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3); cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px;" 
                       onmouseover='this.style.transform="translateY(-2px)"; this.style.boxShadow="0 6px 20px rgba(79, 70, 229, 0.4)";' 
                       onmouseout='this.style.transform="translateY(0)"; this.style.boxShadow="0 4px 12px rgba(79, 70, 229, 0.3)";'>
                        <span>➕</span> New Question
                    </a>
                </div>

                <div style="background: rgba(255, 255, 255, 0.7); border-radius: 16px; border: 1px solid rgba(0, 0, 0, 0.05); min-height: 100%; display: flex; flex-direction: column;">
                    
                    <!-- Table Header -->
                    <div style="padding: 24px 32px 16px 32px; border-bottom: 1px solid rgba(0, 0, 0, 0.08);">
                        <div style="display: grid; grid-template-columns: 80px 1fr 200px; gap: 24px; align-items: center;">
                            <div style="font-size: 18px; font-weight: 700; color: #4f46e5; text-align: center;">
                                #
                            </div>
                            <div style="font-size: 18px; font-weight: 700; color: #4f46e5;">
                                Questions
                            </div>
                            <div style="font-size: 18px; font-weight: 700; color: #4f46e5; text-align: center;">
                                Action
                            </div>
                        </div>
                    </div>

                    <!-- Table Body -->
                    <div style="flex: 1; padding: 0 32px 24px 32px; overflow-y: auto;">
                        <div style="display: flex; flex-direction: column; gap: 12px; padding-top: 16px;">
                            
                            <?php
                            $select_db = "SELECT * FROM tbl_questions ORDER BY questions_id DESC";
                            $stmt = $link->prepare($select_db);
                            $stmt->execute();
                            while ($rs = $stmt->fetch()) {
                                echo "<div style='background: rgba(255, 255, 255, 0.8); border-radius: 12px; padding: 20px; border: 1px solid rgba(0, 0, 0, 0.05); transition: all 0.2s ease; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);' onmouseover='this.style.boxShadow=\"0 4px 16px rgba(0, 0, 0, 0.08)\"; this.style.transform=\"translateY(-2px)\";' onmouseout='this.style.boxShadow=\"0 2px 8px rgba(0, 0, 0, 0.04)\"; this.style.transform=\"translateY(0)\";'>";
                                    echo "<div style='display: grid; grid-template-columns: 80px 1fr 200px; gap: 24px; align-items: center;'>";
                                        echo "<div style='font-size: 16px; font-weight: 600; color: #1f2937; text-align: center;'>";
                                            echo $rs['questions_id'];
                                        echo "</div>";
                                        echo "<div style='font-size: 16px; font-weight: 500; color: #374151; line-height: 1.5;'>";
                                            echo htmlspecialchars($rs['questions']);
                                        echo "</div>";
                                        echo "<div style='display: flex; justify-content: center; gap: 8px;'>";
                                            echo "<button class='btn-delete' data-id='{$rs['questions_id']}' type='button' style='background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-family: Inter; font-weight: 600; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3); cursor: pointer; transition: all 0.3s ease;' onmouseover='this.style.transform=\"translateY(-1px)\"; this.style.boxShadow=\"0 4px 12px rgba(239, 68, 68, 0.4)\";' onmouseout='this.style.transform=\"translateY(0)\"; this.style.boxShadow=\"0 2px 8px rgba(239, 68, 68, 0.3)\";'>";
                                                echo "Remove";
                                            echo "</button>";
                                            echo "<a href='new_question.php?edit={$rs['questions_id']}' style='background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; text-decoration: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-family: Inter; font-weight: 600; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3); cursor: pointer; transition: all 0.3s ease; display: inline-block;' onmouseover='this.style.transform=\"translateY(-1px)\"; this.style.boxShadow=\"0 4px 12px rgba(16, 185, 129, 0.4)\";' onmouseout='this.style.transform=\"translateY(0)\"; this.style.boxShadow=\"0 2px 8px rgba(16, 185, 129, 0.3)\";'>";
                                                echo "Edit";
                                            echo "</a>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            }
                            ?>

                        </div>
                    </div>
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
            
            /* Stack table columns on mobile */
            form > div > div:last-child > div:last-child > div > div:first-child > div,
            form > div > div:last-child > div:last-child > div > div:last-child > div > div > div {
                grid-template-columns: 1fr !important;
                gap: 12px !important;
                text-align: center !important;
            }
            
            h1 {
                font-size: 22px !important;
            }
            
            h2 {
                font-size: 20px !important;
            }
            
            /* Mobile table styling */
            form > div > div:last-child > div:last-child > div > div:last-child > div > div {
                padding: 16px !important;
                text-align: center !important;
            }
            
            form > div > div:last-child > div:last-child > div > div:first-child > div > div {
                display: none !important; /* Hide desktop headers on mobile */
            }
            
            /* Add mobile headers */
            form > div > div:last-child > div:last-child > div > div:last-child > div > div > div > div:first-child::before {
                content: "ID: ";
                font-weight: 700;
                color: #4f46e5;
                display: block;
                margin-bottom: 4px;
            }
            
            form > div > div:last-child > div:last-child > div > div:last-child > div > div > div > div:nth-child(2)::before {
                content: "Question: ";
                font-weight: 700;
                color: #4f46e5;
                display: block;
                margin-bottom: 8px;
            }
            
            /* Mobile action buttons */
            form > div > div:last-child > div:last-child > div > div:last-child > div > div > div > div:last-child {
                flex-direction: column !important;
                gap: 8px !important;
                margin-top: 12px !important;
            }
            
            form > div > div:last-child > div:last-child > div > div:last-child > div > div > div > div:last-child > button,
            form > div > div:last-child > div:last-child > div > div:last-child > div > div > div > div:last-child > a {
                width: 100% !important;
                text-align: center !important;
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
        
        /* Button Hover Effects */
        button:active, a:active {
            transform: translateY(0px) !important;
        }
        
        /* Smooth Animations */
        * {
            transition: all 0.3s ease;
        }
    </style>

    <!-- Modal for Delete Confirmation -->
    <div class="modal fade xerror_modal" data-bs-backdrop="static" id="xerror_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15); background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(20px);">
                <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 24px 32px;">
                    <h5 class="modal-title" style="font-weight: 700; color: #1f2937; font-size: 20px;">Couples Connect Says:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 24px 32px 32px 32px;">
                    <p class="error_msg" style="color: #6b7280; margin: 0; font-size: 14px; line-height: 1.5;">Modal body text goes here.</p>
                </div>
            </div>
        </div>
    </div>

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