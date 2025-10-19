<?php
require "includes/cc_header.php";

$header_name = '';
if($_SESSION['usertype'] == 'DSK'){
    $header_name = "DESK";
}else if($_SESSION['usertype'] == 'CNR'){
    $header_name = "COUNSELOR";
}else if($_SESSION['usertype'] == 'HED'){
    $header_name = "HEAD";
}

$select_db_all="SELECT * FROM mf_prog_users WHERE recid=?";
$stmt = $link->prepare($select_db_all);
$stmt->execute(array($_POST['ac_recid_hidden']));
$rs_all = $stmt->fetch();

$userid = $rs_all['userid'];

$partner1_name = '';
$partner2_name = '';

$select_db_users = "SELECT ext_couples_accountinfo.first_name as 'first_name', ext_couples_accountinfo.middle_name as 'middle_name',
ext_couples_accountinfo.last_name as 'last_name' FROM mf_prog_users LEFT JOIN ext_couples_accountinfo ON mf_prog_users.userid = ext_couples_accountinfo.userid WHERE mf_prog_users.userid = ? 
ORDER BY ext_couples_accountinfo.partnerno LIMIT 2";
$stmt_users = $link->prepare($select_db_users);
$stmt_users->execute(array($userid));

$xcounter_users = 0;
while($row_users = $stmt_users->fetch()){
    if($xcounter_users == 0){
        $partner1_name = $row_users['first_name'].' '.$row_users['middle_name'].' '.$row_users['last_name'];
    }else{
        $partner2_name = $row_users['first_name'].' '.$row_users['middle_name'].' '.$row_users['last_name'];
    }
    $xcounter_users++;
}

// Get all questions with both partners' answers
$select_all_answers = "SELECT mf_meiform.meiformid, mf_meiform.questions,
                       MAX(CASE WHEN ext_mf_meiform.partnerid = '1' THEN ext_mf_meiform.answers END) as partner1_answer,
                       MAX(CASE WHEN ext_mf_meiform.partnerid = '2' THEN ext_mf_meiform.answers END) as partner2_answer,
                       MAX(CASE WHEN ext_mf_meiform.partnerid = '1' THEN ext_mf_meiform.reasons END) as partner1_reason,
                       MAX(CASE WHEN ext_mf_meiform.partnerid = '2' THEN ext_mf_meiform.reasons END) as partner2_reason
                       FROM mf_meiform 
                       LEFT JOIN ext_mf_meiform ON mf_meiform.meiformid = ext_mf_meiform.meiformid 
                       AND ext_mf_meiform.userid = ?
                       GROUP BY mf_meiform.meiformid, mf_meiform.questions
                       ORDER BY mf_meiform.meiformid";
$stmt_all = $link->prepare($select_all_answers);
$stmt_all->execute(array($userid));
$all_answers = $stmt_all->fetchAll(PDO::FETCH_ASSOC);

$total_answers = count($all_answers);
$disagree_count = 0;
$disagree_reasons = array();
$question_mismatches = array();

if($total_answers > 0) {
    foreach($all_answers as $answer) {
        // Check if partners disagree (one says Agree, other says Disagree)
        if($answer['partner1_answer'] != $answer['partner2_answer']) {
            $disagree_count++;
            $question_mismatches[] = $answer['questions'];
            
            // Get reasons from both partners
            $reasons = array();
            if(!empty($answer['partner1_reason'])) {
                $reasons[] = "Partner 1: " . $answer['partner1_reason'];
            }
            if(!empty($answer['partner2_reason'])) {
                $reasons[] = "Partner 2: " . $answer['partner2_reason'];
            }
            if(!empty($reasons)) {
                $disagree_reasons[] = implode(" | ", $reasons);
            } else {
                $disagree_reasons[] = "";
            }
        }
    }
}

$disagree_percentage = ($total_answers > 0) ? round(($disagree_count / $total_answers) * 100) : 0;
$agree_percentage = 100 - $disagree_percentage;

$trend_message = "";
$trend_color = "";
if($disagree_percentage <= 20) {
    $trend_message = "Excellent compatibility! The couple has strong agreement on expectations.";
    $trend_color = "#2eb82e";
} else if($disagree_percentage <= 40) {
    $trend_message = "Good compatibility with some areas needing discussion. Consider counseling on these topics.";
    $trend_color = "#ffa500";
} else if($disagree_percentage <= 60) {
    $trend_message = "Moderate disagreement. It's recommended to address these differences through counseling.";
    $trend_color = "#ff8c00";
} else {
    $trend_message = "Significant differences in expectations. Professional counseling is strongly recommended.";
    $trend_color = "#e62e00";
}
?>

<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
<link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>

<style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
        font-family: 'Inter', sans-serif;
        min-height: 100vh;
    }
    
    .compatibility-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        padding: 30px;
        margin-bottom: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .compatibility-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.12);
    }
    
    .stat-box {
        background: white;
        border-radius: 12px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .stat-box.green {
        border-top: 4px solid #2eb82e;
    }
    
    .stat-box.red {
        border-top: 4px solid #e62e00;
    }
    
    .stat-number {
        font-size: 56px;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 10px;
    }
    
    .progress-modern {
        height: 10px;
        background: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .progress-bar-modern {
        height: 100%;
        border-radius: 10px;
        transition: width 1s ease;
        background: linear-gradient(90deg, #2eb82e 0%, #4ecb71 100%);
    }
    
    .meiform-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
    }
    
    .meiform-table thead th {
        background: linear-gradient(135deg, #23408E 0%, #3c94c6 100%);
        color: white;
        padding: 15px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 14px;
    }
    
    .meiform-table tbody tr {
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .meiform-table tbody tr:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .meiform-table tbody td {
        padding: 15px;
        vertical-align: middle;
    }
    
    .answer-badge {
        padding: 8px 16px;
        border-radius: 20px;
        color: white;
        font-weight: 600;
        font-size: 13px;
        display: inline-block;
        min-width: 90px;
        text-align: center;
    }
    
    .answer-badge.agree {
        background: #2eb82e;
    }
    
    .answer-badge.disagree {
        background: #e62e00;
    }
    
    .reason-text {
        background: #f8f9fa;
        border-left: 3px solid #6c757d;
        padding: 10px;
        border-radius: 4px;
        font-size: 13px;
        color: #495057;
        max-height: 60px;
        overflow-y: auto;
    }
    
    .btn-modern {
        background: linear-gradient(135deg, #23408E 0%, #3c94c6 100%);
        color: white;
        border: none;
        padding: 14px 32px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(35,64,142,0.3);
    }
    
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(35,64,142,0.4);
        color: white;
    }
    
    .header-modern {
        background: white;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        padding: 20px 40px;
        margin-bottom: 30px;
        border-radius: 0 0 20px 20px;
    }
    
    .recommendation-box {
        background: linear-gradient(135deg, rgba(35,64,142,0.05) 0%, rgba(60,148,198,0.05) 100%);
        border-left: 5px solid <?php echo $trend_color; ?>;
        padding: 20px;
        border-radius: 12px;
        margin: 20px 0;
    }
    
    .disagreement-item {
        background: #fff5f5;
        border-left: 4px solid #e62e00;
        padding: 15px;
        margin-bottom: 12px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .disagreement-item:hover {
        background: #ffe5e5;
        transform: translateX(4px);
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="header-modern">
        <div class="row align-items-center">
            <div class="col-3">
                <img src="images/350 x 88.png" style='height:76px;width:auto;'>
            </div>
            <div class="col-9 text-end">
                <a href="http://localhost/couples-connect/select_option.php" class='btn btn-link text-dark text-decoration-none me-3'>
                    <i class="bi bi-house-door-fill"></i> HOME
                </a>
                <span class="text-muted">|</span>
                <span class="mx-3 fw-bold text-primary"><?php echo $header_name;?></span>
                <span class="text-muted">|</span>
                <a href="http://localhost/couples-connect/logout_cc.php" class='btn btn-link text-dark text-decoration-none ms-3'>
                    <i class="bi bi-box-arrow-right"></i> LOGOUT
                </a>
            </div>
        </div>
    </div>

    <div class="container" style="max-width: 1400px;">
        <!-- Page Title -->
        <div class="text-center mb-4">
            <h1 class="fw-bold" style="color: #23408E; font-size: 36px;">
                <i class="bi bi-clipboard-check"></i> Compatibility Analysis Report
            </h1>
            <p class="text-muted">Based on Marriage Expectation Inventory Form responses</p>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="stat-box green">
                    <div class="stat-number" style="color: #2eb82e;">
                        <?php echo $agree_percentage; ?>%
                    </div>
                    <h5 class="fw-bold mb-2">Agreement Rate</h5>
                    <p class="text-muted mb-0">
                        <span class="fw-bold" style="color: #2eb82e;"><?php echo ($total_answers - $disagree_count); ?></span> 
                        out of <?php echo $total_answers; ?> statements
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-box red">
                    <div class="stat-number" style="color: #e62e00;">
                        <?php echo $disagree_percentage; ?>%
                    </div>
                    <h5 class="fw-bold mb-2">Disagreement Rate</h5>
                    <p class="text-muted mb-0">
                        <span class="fw-bold" style="color: #e62e00;"><?php echo $disagree_count; ?></span> 
                        out of <?php echo $total_answers; ?> statements
                    </p>
                </div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="compatibility-card">
            <div class="d-flex justify-content-between mb-3">
                <h6 class="fw-bold mb-0">Overall Compatibility Score</h6>
                <span class="fw-bold" style="color: #23408E;"><?php echo $agree_percentage; ?>/100</span>
            </div>
            <div class="progress-modern">
                <div class="progress-bar-modern" style="width: <?php echo $agree_percentage; ?>%; background: linear-gradient(90deg, <?php echo $trend_color; ?>, <?php echo $trend_color; ?>dd);"></div>
            </div>
        </div>

        <!-- Recommendation -->
        <div class="recommendation-box">
            <h6 class="fw-bold mb-2" style="color: <?php echo $trend_color; ?>; text-transform: uppercase;">
                <i class="bi bi-lightbulb-fill"></i> Recommendation
            </h6>
            <p class="mb-0"><?php echo $trend_message; ?></p>
        </div>

        <!-- Disagreement Details -->
        <?php if($disagree_count > 0): ?>
        <div class="compatibility-card">
            <h5 class="fw-bold mb-3" style="color: #e62e00;">
                <i class="bi bi-exclamation-triangle-fill"></i> Areas Requiring Discussion
            </h5>
            <div style="max-height: 300px; overflow-y: auto;">
                <?php foreach($question_mismatches as $index => $question): ?>
                <div class="disagreement-item">
                    <div class="fw-bold mb-2" style="color: #333;">
                        <?php echo ($index + 1) . ". " . htmlspecialchars($question); ?>
                    </div>
                    <?php if(isset($disagree_reasons[$index]) && !empty($disagree_reasons[$index])): ?>
                        <div class="text-muted" style="font-size: 13px; font-style: italic;">
                            <i class="bi bi-chat-left-text"></i> Reason: <?php echo htmlspecialchars($disagree_reasons[$index]); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Form Responses Table -->
        <div class="compatibility-card">
            <h4 class="fw-bold mb-4" style="color: #23408E;">
                <i class="bi bi-file-text-fill"></i> Marriage Expectation Inventory Form
            </h4>
            
            <div style="overflow-x: auto;">
                <table class="meiform-table">
                    <thead>
                        <tr>
                            <th style="width: 40%; border-radius: 8px 0 0 8px;">Statement</th>
                            <th style="width: 15%;">Partner 1<br><small><?php echo $partner1_name; ?></small></th>
                            <th style="width: 15%;">Reason</th>
                            <th style="width: 15%;">Partner 2<br><small><?php echo $partner2_name; ?></small></th>
                            <th style="width: 15%; border-radius: 0 8px 8px 0;">Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $meiform_count = 1;
                        $select_db_meiform = "SELECT * FROM mf_meiform ORDER BY meiformid";
                        $stmt_meiform = $link->prepare($select_db_meiform);
                        $stmt_meiform->execute();
                        
                        while($row_meiform = $stmt_meiform->fetch()){
                            echo "<tr>";
                            
                            echo "<td class='fw-medium'>";
                            echo "<div style='padding: 5px;'><span class='badge bg-secondary me-2'>".$meiform_count."</span>".$row_meiform['questions']."</div>";
                            echo "</td>";

                            // Partner 1
                            $select_db_meiform_1 = "SELECT answers, reasons FROM ext_mf_meiform 
                                                    WHERE meiformid=? AND partnerid='1' AND userid=?";
                            $stmt_meiform_1 = $link->prepare($select_db_meiform_1);
                            $stmt_meiform_1->execute(array($row_meiform['meiformid'], $userid));
                            $row_meiform_1 = $stmt_meiform_1->fetch();

                            if($row_meiform_1){
                                $badge_class = ($row_meiform_1['answers'] == "Agree") ? "agree" : "disagree";
                                
                                echo "<td class='text-center'>";
                                echo "<span class='answer-badge ".$badge_class."'>".$row_meiform_1['answers']."</span>";
                                echo "</td>";

                                echo "<td>";
                                if(!empty($row_meiform_1['reasons'])){
                                    echo "<div class='reason-text'>".$row_meiform_1['reasons']."</div>";
                                } else {
                                    echo "<div class='text-muted text-center'>-</div>";
                                }
                                echo "</td>";
                            } else {
                                echo "<td class='text-center'><span class='text-muted'>No answer</span></td>";
                                echo "<td class='text-center'><span class='text-muted'>-</span></td>";
                            }

                            // Partner 2
                            $select_db_meiform_2 = "SELECT answers, reasons FROM ext_mf_meiform 
                                                    WHERE meiformid=? AND partnerid='2' AND userid=?";
                            $stmt_meiform_2 = $link->prepare($select_db_meiform_2);
                            $stmt_meiform_2->execute(array($row_meiform['meiformid'], $userid));
                            $row_meiform_2 = $stmt_meiform_2->fetch();

                            if($row_meiform_2){
                                $badge_class = ($row_meiform_2['answers'] == "Agree") ? "agree" : "disagree";
                                
                                echo "<td class='text-center'>";
                                echo "<span class='answer-badge ".$badge_class."'>".$row_meiform_2['answers']."</span>";
                                echo "</td>";

                                echo "<td>";
                                if(!empty($row_meiform_2['reasons'])){
                                    echo "<div class='reason-text'>".$row_meiform_2['reasons']."</div>";
                                } else {
                                    echo "<div class='text-muted text-center'>-</div>";
                                }
                                echo "</td>";
                            } else {
                                echo "<td class='text-center'><span class='text-muted'>No answer</span></td>";
                                echo "<td class='text-center'><span class='text-muted'>-</span></td>";
                            }
                            
                            echo "</tr>";
                            $meiform_count++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center my-5">
            <button type="button" onclick="onSubmit('PMC')" class="btn btn-modern me-3">
                <i class="bi bi-arrow-right-circle"></i> Proceed to PMC
            </button>
            <button type="button" onclick="onSubmit('CRT')" class="btn btn-modern">
                <i class="bi bi-file-earmark-check"></i> Proceed to Cert
            </button>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade xerror_modal" data-bs-backdrop="static" id="xerror_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Couples Connect Says:</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="error_msg mb-0"></p>
            </div>
        </div>
    </div>
</div>

<form name='myforms' id="myforms" method="post" target="_self">
    <input type="hidden" name="ac_recid_hidden" id="ac_recid_hidden" value="<?php echo $_POST['ac_recid_hidden'];?>">
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function onSubmit(xevent_action){
    var ac_recid_hidden = $("#ac_recid_hidden").val();

    jQuery.ajax({    
        data:{
            event_action: xevent_action,
            ac_recid_hidden: ac_recid_hidden
        },
        dataType: "json",
        type: "post",
        url: "cc_meiformapproval2_ajax.php", 
        success: function(xdata){
            if(xdata['status'] == false){
                $('.error_msg').html(xdata['msg']);
                $(".xerror_modal").modal("show");
            }else{
                document.forms.myforms.method = "post";
                document.forms.myforms.target = "_self";
                document.forms.myforms.action = "cc_meiformapproval.php";
                document.forms.myforms.submit();
            }
        },
        error: function (request, status, error) {
            console.error("AJAX Error:", error);
        }
    });
}
</script>

<?php 
require "includes/cc_footer.php";
?>