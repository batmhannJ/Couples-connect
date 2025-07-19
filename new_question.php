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

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#tbl_list').DataTable();
    });
</script>


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

            <?php
            if (isset($_POST['crf_true'])) {

                if (isset($_GET['edit'])) {
                    $insert_db = "update tbl_questions set questions=:questions, answers=:answers where questions_id=:questions_id";
                    $stmt = $link->prepare($insert_db);
                    $stmt->bindParam(':questions', $_POST['question']);
                    $stmt->bindParam(':answers', $_POST['answer']);
                    $stmt->bindParam(':questions_id', $_GET['edit']);

                    if ($stmt->execute()) {
                        $msg = "Question updated successfully.";
                        $status = "Success";
                        $bg = "success";
                    } else {
                        $msg = "Error updated record.";
                        $status = "Failed";
                        $bg = "danger";
                    }
                } else {
                    $insert_db = "INSERT INTO tbl_questions (questions, answers) VALUES (:questions, :answers)";
                    $stmt = $link->prepare($insert_db);
                    $stmt->bindParam(':questions', $_POST['question']);
                    $stmt->bindParam(':answers', $_POST['answer']);

                    if ($stmt->execute()) {
                        $msg = "Question inserted successfully.";
                        $status = "Success";
                        $bg = "success";
                    } else {
                        $msg = "Error inserting record.";
                        $status = "Failed";
                        $bg = "danger";
                    }
                }
            }
            ?>

            <!-- Header -->
            <div style="padding: 20px 32px 16px 32px; text-align: center; border-bottom: 1px solid rgba(0, 0, 0, 0.05); flex-shrink: 0;">
                <h1 style="font-size: 26px; font-weight: 700; color: #1a1a1a; margin: 0 0 10px 0;">Question Form</h1>
                <div style="height: 3px; background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%); border-radius: 2px; width: 200px; margin: 0 auto;"></div>
            </div>

            <!-- Form Content -->
            <div style="flex: 1; padding: 24px 32px; overflow-y: auto; min-height: 0;">
                <div style="background: rgba(255, 255, 255, 0.7); border-radius: 16px; border: 1px solid rgba(0, 0, 0, 0.05); height: 100%; display: flex; flex-direction: column;">
                    <div style="flex: 1; padding: 24px; overflow-y: auto;">
                        
                        <!-- Alert Messages -->
                        <?php if (isset($_POST['crf_true'])): ?>
                            <div style="padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; border: 1px solid; <?= $bg == 'success' ? 'background: rgba(34, 197, 94, 0.1); border-color: rgba(34, 197, 94, 0.3); color: #15803d;' : 'background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.3); color: #dc2626;' ?>">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <strong><?= $status ?></strong> <?= $msg ?>
                                    </div>
                                    <button type="button" style="background: none; border: none; font-size: 18px; cursor: pointer; color: inherit; opacity: 0.7;" onclick="this.parentElement.parentElement.style.display='none';">&times;</button>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Question Form -->
                        <form action="" method="post">
                            <?php
                            $value = "";
                            $ans = "";
                            if (isset($_GET['edit'])) {
                                $select_edit = "SELECT * FROM tbl_questions where questions_id=" . $_GET['edit'];
                                $stmt    = $link->prepare($select_edit);
                                $stmt->execute();
                                if ($rs = $stmt->fetch()) {
                                    $value = $rs['questions'];
                                    $ans = $rs['answers'];
                                }
                            }
                            ?>

                            <div style="margin-bottom: 24px;">
                                <label style="font-weight: 700; font-size: 18px; color: #4f46e5; display: block; margin-bottom: 12px;">Question</label>
                                <textarea name="question" style="width: 100%; min-height: 60px; padding: 16px 20px; border-radius: 12px; border: 1px solid rgba(0, 0, 0, 0.1); background: rgba(243, 244, 246, 0.8); font-size: 16px; color: #374151; resize: vertical; font-family: inherit;" placeholder="Type Here..." rows="2"><?= $value ?></textarea>
                            </div>

                            <div style="margin-bottom: 32px;">
                                <label style="font-weight: 700; font-size: 18px; color: #4f46e5; display: block; margin-bottom: 12px;">Answer</label>
                                <textarea name="answer" style="width: 100%; min-height: 300px; padding: 16px 20px; border-radius: 12px; border: 1px solid rgba(0, 0, 0, 0.1); background: rgba(243, 244, 246, 0.8); font-size: 16px; color: #374151; resize: vertical; font-family: inherit;" placeholder="Type Here..." rows="12"><?= $ans ?></textarea>
                            </div>

                            <input type="hidden" value="crf_true" name="crf_true">
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 24px;">
                                <a href="add_questions.php" style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #e02626ff 0%, #c53f3fff 100%); color: white; text-decoration: none; padding: 14px 24px; border-radius: 12px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(224, 38, 38, 0.3); border: none; font-family: inherit;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(224, 38, 38, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(224, 38, 38, 0.3)';">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                                    </svg>
                                    Back
                                </a>
                                <button type="submit" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: white; border: none; padding: 14px 32px; border-radius: 12px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(79, 70, 229, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(79, 70, 229, 0.3)';">
                                    <?= isset($_GET['edit']) ? "Update" : "Submit"; ?>
                                </button>
                            </div>
                        </form>

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
            
            h1 {
                font-size: 22px !important;
            }
            
            h2 {
                font-size: 20px !important;
            }
            
            form > div > div:last-child > div:last-child > div > div {
                padding: 16px !important;
            }
            
            textarea {
                min-height: 50px !important;
            }
            
            textarea[name="answer"] {
                min-height: 200px !important;
            }
            
            div[style*="justify-content: space-between"] {
                flex-direction: column !important;
                gap: 12px !important;
            }
            
            div[style*="justify-content: space-between"] a,
            div[style*="justify-content: space-between"] button {
                width: 100% !important;
                justify-content: center !important;
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
        
        /* Focus states for form elements */
        textarea:focus {
            outline: none;
            border-color: rgba(79, 70, 229, 0.5);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
    </style>
    
</form>
</div>
</div>
</div>
</div>
</td>
</tr>

</table>


<?php
require "includes/cc_footer.php";
?>



