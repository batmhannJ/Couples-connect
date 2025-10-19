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

        $('.btn-delete').click(function() {
            var dataId = $(this).data('id');

            let x = confirm("Are you sure do you want to remove?");

            if (x==true) {
                window.location = `?remove=${dataId}`
            }
        });

    });
</script>

<?php
if (isset($_GET['remove'])) {
    $deleted_db = "delete from tbl_questions where questions_id=:questions_id";
    $stmt = $link->prepare($deleted_db);
    $stmt->bindParam(':questions_id', $_GET['remove']);

    if ($stmt->execute()) {
        $msg = "Question deleted successfully.";
        $status = "Success";
        $bg = "success";
    } else {
        $msg = "Error deleted record.";
        $status = "Failed";
        $bg = "danger";
    }
}
?>


<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
<link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
<div class="container-fluid">
    <div class='row bg-white' style="height:99px">
        <div class="col-3 pe-0 d-flex align-items-center">
            <img src="images/350 x 88.png" style='height:76px;width:auto;'>
        </div>
        <div class="col-3 offset-6 d-none">
            <div style="flex:0.5;text-align:right;margin-right:10px">
                <a href="http://localhost/couples-connect/select_option.php" style='color:black;text-decoration:none' class='has_hover'>HOME</a>
            </div>
            <div style="flex:.1;text-align:center;padding-right:10px">
                <a style='color:black;text-decoration:none'>|</a>
            </div>
            <div style="flex:.3;text-align:center;padding-right:15px">
                <a style='color:black;text-decoration:none'><?php echo $header_name;?> </a>
            </div>
            <div style="flex:0.6;text-align:right;padding-right:35px">
                <a href="http://localhost/couples-connect/logout_cc.php" class='has_hover' style='color:black;text-decoration:none'>LOGOUT</a>
            </div>
        </div>
    </div>
</div>

<form name='myforms' id="myforms" method="post" target="_self" style='min-height:100vh; background: linear-gradient(135deg, rgb(215, 217, 225) 0%, rgb(162, 185, 231) 100%); padding: 20px; font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;'>

    <div id="main-grid" class="dashboard-grid" style="max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: 320px 1fr; gap: 24px; height: calc(100vh - 40px);">

        <div class="cc-sidebar" style=" 
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 0;
            height: calc(100vh - 80px); 
            max-height: 650px; 
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow-y: auto;
            transition: width 0.3s ease;
        ">
            <div style="display: flex; flex-direction: column; gap: 0;">
                <?php require 'cc_mf_menu.php'; ?>
            </div>
        </div>

        <div class="main-content" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 24px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; border: 1px solid rgba(255, 255, 255, 0.2); height: calc(100vh - 80px); overflow: hidden;">

            <div style="padding: 20px 32px 16px 32px; text-align: center; border-bottom: 1px solid rgba(0, 0, 0, 0.05); flex-shrink: 0;">
                <h1 style="font-size: 26px; font-weight: 700; color: #1a1a1a; margin: 0 0 10px 0;">Question List</h1>
                <div style="height: 3px; background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%); border-radius: 2px; width: 260px; margin: 0 auto;"></div>
            </div>

            <div style="flex: 1; padding: 24px 32px; overflow-y: auto; min-height: 0;">
                
                <div style="margin-bottom: 24px;">
                    <a href="new_question.php" class="btn-new-question" style="background: linear-gradient(135deg, #a6a2f4ff 0%, #7c3aed 100%); color: white; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-size: 15px; font-family: Inter; font-weight: 600; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3); cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px;" 
                        onmouseover='this.style.transform="translateY(-2px)"; this.style.boxShadow="0 6px 20px rgba(79, 70, 229, 0.4)";' 
                        onmouseout='this.style.transform="translateY(0)"; this.style.boxShadow="0 4px 12px rgba(79, 70, 229, 0.3)";'>
                        <span>➕</span> New Question
                    </a>
                </div>

                <div class="question-container" style="background: rgba(255, 255, 255, 0.7); border-radius: 16px; border: 1px solid rgba(0, 0, 0, 0.05); min-height: 100%; display: flex; flex-direction: column;">
                    
                    <div class="table-header-row" style="padding: 24px 32px 16px 32px; border-bottom: 1px solid rgba(0, 0, 0, 0.08);">
                        <div class="table-grid-header" style="display: grid; grid-template-columns: 80px 1fr 200px; gap: 24px; align-items: center;">
                            <div class="header-col" style="font-size: 18px; font-weight: 700; color: #4f46e5; text-align: center;">
                                #
                            </div>
                            <div class="header-col" style="font-size: 18px; font-weight: 700; color: #4f46e5;">
                                Questions
                            </div>
                            <div class="header-col" style="font-size: 18px; font-weight: 700; color: #4f46e5; text-align: center;">
                                Action
                            </div>
                        </div>
                    </div>

                    <div style="flex: 1; padding: 0 32px 24px 32px; overflow-y: auto;">
                        <div class="question-list" style="display: flex; flex-direction: column; gap: 12px; padding-top: 16px;">
                            
                            <?php
                            $select_db = "SELECT * FROM tbl_questions ORDER BY questions_id DESC";
                            $stmt = $link->prepare($select_db);
                            $stmt->execute();
                            while ($rs = $stmt->fetch()) {
                                echo "<div class='question-row-item' style='background: rgba(255, 255, 255, 0.8); border-radius: 12px; padding: 20px; border: 1px solid rgba(0, 0, 0, 0.05); transition: all 0.2s ease; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);' onmouseover='this.style.boxShadow=\"0 4px 16px rgba(0, 0, 0, 0.08)\"; this.style.transform=\"translateY(-2px)\";' onmouseout='this.style.boxShadow=\"0 2px 8px rgba(0, 0, 0, 0.04)\"; this.style.transform=\"translateY(0)\";'>";
                                    echo "<div class='table-grid-row' style='display: grid; grid-template-columns: 80px 1fr 200px; gap: 24px; align-items: center;'>";
                                        echo "<div class='col-id' style='font-size: 16px; font-weight: 600; color: #1f2937; text-align: center;'>";
                                            echo $rs['questions_id'];
                                        echo "</div>";
                                        echo "<div class='col-question' style='font-size: 16px; font-weight: 500; color: #374151; line-height: 1.5;'>";
                                            echo htmlspecialchars($rs['questions']);
                                        echo "</div>";
                                        echo "<div class='col-actions' style='display: flex; justify-content: center; gap: 8px;'>";
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

    <style>
    /* Global Styles (unchanged) */
    #search_text:focus { outline: none; }
    .has_hover:hover { color: #4f46e5 !important; transition: color 0.2s ease; }
    input[type="date"]:focus { border-color: #4f46e5 !important; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important; outline: none !important; }
    .btn-filter:hover { transform: translateY(-2px) !important; box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4) !important; }
    /* Adjusted to target .question-item, since there's no tbody here */
    .question-item:hover .question-actions button,
    .question-item:hover .question-actions a { 
         transform: translateY(-1px) !important; 
    }

    /* ======================================================= */
    /* RESPONSIVE LAYOUT & SIDEBAR COLLAPSE STYLES             */
    /* ======================================================= */

    /* 1. Default (Desktop/Tablet Grid) - RETAINED */
    .dashboard-grid {
        grid-template-columns: 320px 1fr; 
        gap: 24px;
        height: auto; 
        max-width: 1400px; 
        display: grid; 
    }
    .cc-sidebar { height: calc(100vh - 80px); max-height: 650px; }
    .main-content { height: calc(100vh - 80px); } /* Original height constraint */

    /* 2. Medium Screen Collapse (1200px) - Shrinks Sidebar to ONLY ICONS */
    @media (max-width: 1200px) {
        .dashboard-grid { 
            grid-template-columns: 80px 1fr !important; 
            gap: 16px !important; 
        }
        .dashboard-grid > div:first-child { width: 80px; }
        
        /* Sidebar collapse styles remain the same */
        .sidebar-label, .cc-profile-info, .cc-search-bar input { 
            display: none !important; 
            opacity: 0 !important;
            width: 0 !important;
            overflow: hidden !important;
            max-width: 0 !important; 
        } 
        
        .cc-menu-link { 
            display: flex !important; 
            flex-direction: column !important; 
            justify-content: center !important; 
            align-items: center !important;
            padding: 10px 0 !important; 
            width: 100% !important; 
            overflow: hidden !important; 
            text-align: center !important; 
            max-width: 80px !important; 
        } 
        
        .cc-menu-link .cc-icon-wrap { margin: 0 !important; }
        .cc-sidebar li {
            padding: 0 !important;
            margin: 0 !important;
        }
        
        .cc-menu-link > *:not(.cc-icon-wrap) {
            display: none !important;
        }
        
        /* Table layout on smaller screens (1200px) */
        .question-list-header, .question-row {
             /* Adjust grid columns for slightly less space */
             grid-template-columns: 50px 1fr 150px !important; 
             gap: 16px !important;
        }
        .main-content > div:first-child {
            padding: 20px 24px 16px 24px !important; /* Slightly reduce padding */
        }
        .main-content > div:last-child {
             padding: 20px 24px !important;
        }
    }

    /* 3. Small Screen (768px and below) - SIDEBAR MOVED TO TOP (FLEX COLUMN) */
    @media (max-width: 768px) {
        /* HEADER FIX */
        .container-fluid { padding: 0 !important; max-width: 100% !important; }
        .container-fluid > .row { margin: 0 !important; padding: 0 !important; }

        /* FORM AND OUTER BODY FIX */
        form { 
            padding: 5px !important; 
            min-height: auto !important; 
            overflow-x: hidden; 
        }
        
        /* DASHBOARD GRID FIX (Parent Container - Changed to Flex Column) */
        #main-grid.dashboard-grid { 
            display: flex !important; 
            flex-direction: column !important; 
            gap: 8px !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important; 
            height: auto !important; 
        }
        
        /* SIDEBAR CONTAINER (Icons Container - Now Horizontal and First) */
        .cc-sidebar {
            order: 1 !important; /* *** CRITICAL: Puts sidebar first (at the top) *** */
            width: 100% !important;
            max-width: 100% !important;
            height: auto !important;
            max-height: none !important;
            margin: 0 !important;
            padding: 8px 5px !important; 
            border-radius: 12px !important;
            overflow-y: hidden !important; 
            
            /* Horizontal Icon Display */
            display: flex;
            flex-direction: row !important;
            justify-content: space-around; 
            align-items: center;
            overflow-x: auto; 
            white-space: nowrap; 
        }

        /* Hide the text labels in the horizontal menu */
        .sidebar-label { 
            display: none !important; 
            opacity: 0 !important; 
            width: 0 !important; 
            overflow: hidden !important; 
        } 
        
        /* MAIN CONTENT CONTAINER (Question List - Second) */
        .main-content { 
            order: 2 !important; /* *** CRITICAL: Puts main content second (below the sidebar) *** */
            width: 100% !important;
            max-width: 100% !important;
            /* Height is NOT overridden, it remains calc(100vh - 80px) */
            overflow-y: auto !important; 
        }
        
        /* Question List Table Row Collapse */
        .question-list-header, .question-row {
             /* Stack the ID and Question, put Action on the next line */
             grid-template-columns: 1fr !important; 
             gap: 8px !important;
        }
        
        /* Table Header Titles */
        .question-list-header div:nth-child(1), /* # */
        .question-list-header div:nth-child(3) /* Action */ {
            display: none !important; /* Hide titles that don't make sense when stacked */
        }
        .question-list-header div:nth-child(2) {
             font-size: 16px !important;
        }

        /* Question Item adjustments */
        .question-item {
             padding: 16px !important;
        }
        .question-id {
            display: none !important; /* Hide ID number on smallest screen */
        }
        .question-actions {
             justify-content: flex-start !important; /* Align buttons to the left */
        }
        .question-actions button, .question-actions a {
             flex: 1;
             text-align: center;
             max-width: 120px;
        }

        /* Button spacing */
        a[href="new_question.php"] {
             font-size: 14px !important;
             padding: 10px 20px !important;
        }

        /* Font size/spacing adjustments */
        h1 { font-size: 22px !important; }
        
        /* Reduced main content padding */
        .main-content > div:first-child { 
             padding: 16px 16px 12px 16px !important; 
        }
        .main-content > div:last-child {
             padding: 16px !important;
        }
        .main-content > div:last-child > div:last-child {
             padding: 0 16px 16px 16px !important;
        }
    }
</style>
</form>

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



    <?php
    require "includes/cc_footer.php";
    ?>