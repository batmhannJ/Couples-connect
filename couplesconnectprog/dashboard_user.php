<?php
require "includes/cc_header.php";
$header_name = '';
if($_SESSION['usertype'] == 'DSK'){
    $header_name = "DESK";
}else if($_SESSION['usertype'] == 'CNR'){
    $header_name = "COUNSELOR";
}else if($_SESSION['usertype'] == 'HED'){
    $header_name = "HEAD";
}else if($_SESSION['usertype'] == 'USR'){
    $header_name = "USER";
}


$select_db="SELECT * FROM mf_prog_users WHERE recid=?";
$stmt	= $link->prepare($select_db);
$stmt->execute(array($_SESSION['usr_recid']));
$row = $stmt->fetch();
$act_status = $row["act_status"];
$prnt_status = $row["print_status"];
$remarks = $row["remarks"];

?>

<?php
try {
    // Get user activity status
    $select_db = "SELECT * FROM mf_prog_users WHERE recid = :recid";
    $stmt = $link->prepare($select_db);
    $stmt->bindParam(':recid', $_SESSION['usr_recid'], PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $act_status = $row["act_status"];

    // Get the most recent certificate that isn't "RCV" (received)
    $select_db_certcheck = "SELECT * FROM pro_cert_table WHERE userid = :userid AND status != 'RCV' ORDER BY date_created desc LIMIT 1";
    $stmt_certcheck = $link->prepare($select_db_certcheck);
    $stmt_certcheck->bindParam(':userid', $_SESSION['usr_id'], PDO::PARAM_INT);
    $stmt_certcheck->execute();
    $row_certcheck = $stmt_certcheck->fetch(PDO::FETCH_ASSOC);

    // Determine if certificate has been requested
    if ($row_certcheck && isset($row_certcheck['control_number']) && !empty($row_certcheck['control_number'])) {
        $requested_btn = true;
        $xcert_status = $row_certcheck['status'];
        $xcertremarks = $row_certcheck['reason'];
        $control_number = $row_certcheck['control_number'];
    } else {
        $xcert_status = $row_certcheck['status'] ?? '';
        $requested_btn = false;
    }

    // Get the total number of certificates for the user
    $select_db_certcheck_count = "SELECT COUNT(*) FROM pro_cert_table WHERE userid = :userid";
    $stmt_certcheck_count = $link->prepare($select_db_certcheck_count);
    $stmt_certcheck_count->bindParam(':userid', $_SESSION['usr_id'], PDO::PARAM_INT);
    $stmt_certcheck_count->execute();
    $certificate_count = $stmt_certcheck_count->fetchColumn();

    // Retrieve certificates ordered by date_claimed
    $select_db_cert = "SELECT * FROM pro_cert_table WHERE userid = :userid ORDER BY date_claimed DESC";
    $stmt_cert = $link->prepare($select_db_cert);
    $stmt_cert->bindParam(':userid', $_SESSION['usr_id'], PDO::PARAM_INT);
    $stmt_cert->execute();
    $row_cert = $stmt_cert->fetchAll(PDO::FETCH_ASSOC);

    // Handle the case where the certificate isn't requested
    if (!$requested_btn) {
        if ($certificate_count == 0) {
            // Default control_number if no certificate exists
            $control_number = '12261784';
        } else {
            // Get the latest control_number and increment it
            $select_db_cert2 = "SELECT control_number FROM pro_cert_table WHERE userid = :userid ORDER BY control_number DESC LIMIT 1";
            $stmt_cert2 = $link->prepare($select_db_cert2);
            $stmt_cert2->bindParam(':userid', $_SESSION['usr_id'], PDO::PARAM_INT);
            $stmt_cert2->execute();
            $row_cert2 = $stmt_cert2->fetch(PDO::FETCH_ASSOC);

            if ($row_cert2 && isset($row_cert2['control_number'])) {
                $control_number = LNexts($row_cert2['control_number']);
            }
        }
    }

    // Get partner names from the external couples account info
    $partner1_name = '';
    $partner2_name = '';

    $select_db_users = "SELECT ext_couples_accountinfo.first_name, ext_couples_accountinfo.middle_name, ext_couples_accountinfo.last_name 
                        FROM mf_prog_users 
                        RIGHT JOIN ext_couples_accountinfo ON mf_prog_users.userid = ext_couples_accountinfo.userid 
                        WHERE mf_prog_users.userid = :userid 
                        ORDER BY ext_couples_accountinfo.partnerno LIMIT 2";
    $stmt_users = $link->prepare($select_db_users);
    $stmt_users->bindParam(':userid', $_SESSION['usr_id'], PDO::PARAM_INT);
    $stmt_users->execute();

    $xcounter_users = 0;
    while ($row_users = $stmt_users->fetch(PDO::FETCH_ASSOC)) {
        if ($xcounter_users == 0) {
            $partner1_name = $row_users['first_name'] . ' ' . $row_users['middle_name'] . ' ' . $row_users['last_name'];
        } else {
            $partner2_name = $row_users['first_name'] . ' ' . $row_users['middle_name'] . ' ' . $row_users['last_name'];
        }
        $xcounter_users++;
    }

} catch (PDOException $e) {
    // Handle errors and return a failure message
    $ret['status'] = false;
    $ret['msg'] = 'Error: ' . $e->getMessage();
    echo json_encode($ret);
    exit();
}


?>

<style>
    .has_hover:hover{
        cursor:pointer;
        opacity:0.5;
    }

    .floating-btn {
            position: fixed;
            bottom: 120px;
            right: 50px;
            width: 60px;
            height: 60px;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 60px;
            font-size: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .floating-btn:hover {
            background-color: #0056b3;
        }
</style>

<div class="container-fluid">
        <div class='row bg-white' style="height:99px">
            <div class="col-3 pe-0 d-flex align-items-center">
                <img src="images/350 x 88.png" style='height:76px;width:auto;'>
            </div>

            <div class="col-3 offset-6" style="display:flex;flex-direction:row;justify-content:center;font-family:inter;font-size:21px;align-items:center"> 
                <div style="flex:1.6;text-align:right;margin-right:25px">
                    <a href="http://localhost/couplesconnectprog/dashboard_user.php" style='color:black;text-decoration:none' class='has_hover'>SERVICES</a>
                </div>

                <div style="flex:1.8;text-align:center;margin-right:10px">
                    <a style='color:black;text-decoration:none' class='has_hover' onclick="openFeedback()">FEEDBACK</a>
                </div>

                <div style="flex:0.3;text-align:center;padding-right:10px">
                    <a href="" style='color:black;text-decoration:none'>|</a>
                </div>

                <div style="flex:1;text-align:center;margin-right:20px">
                    <a style='color:black;text-decoration:none'><?php echo $header_name;?> </a>
                </div>

                <div style="flex:0.6;text-align:right;padding-right:145px">
                    <a href="http://localhost/couplesconnectprog/logout_cc.php" style='color:black;text-decoration:none' class='has_hover'>LOGOUT</a>
                </div>
            </div> 
        </div>
    </div>
    
    <form name='myforms' id="myforms" method="post" target="_self" style='height:100%'> 
        <table style="width:100%;height:calc(100% - 100px);	filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25))">
            <tr>
                <td class="d-flex align-items-top mx-0 px-0">
                    <div class="d-flex" style="display:flex;flex-direction:row;width:200%">
                        <div style="width:50%;display:flex;justify-content:center;flex-direction:column;align-items:center">

                            <div style='width:80%;height:40%;background-color:white;border-radius:15px' class="mt-4">
                                <div class="pt-3" style='font-size:22px;font-family:inter;font-weight:700;text-align:center'>Status</div>
                                <div style='width:100%;display:flex;justify-content:center'>
                                    <img src="images/Rectangle 11934.png" style='width:80%;height:4px'>
                                </div>
                                <div>
                                    <?php   

                                    $book_now_disbaled = "";
                                    $req_now_disabled = "";
                                    if($act_status == "APR"){
                                        echo "<div class='text-center' style='font-family:inter;font-size:22px;font-weight:700;margin-top:20px'>";
                                            echo "<img src='images/Group.png'>";
                                            echo "<span style='margin-left:10px'>Account is approved.</span>";
                                        echo "</div>";

                                        $req_now_disabled = "";
                                        $book_now_disbaled = "disabled";

                                    }else if($act_status == "PMO"){
                                        echo "<div class='text-center' style='font-family:inter;font-size:22px;font-weight:700;margin-top:20px'>";
                                            echo "<img src='images/Group.png'>";
                                            echo "<span style='margin-left:10px'>Waiting for Approval</span>";
                                        echo "</div>";

                                        // $book_now_disbaled = "disabled";
                                        $req_now_disabled = "disabled";
                                    } else if($act_status == "PMC"){
                                        if($xcert_status == "PRP"){
                                        echo "<div class='text-center' style='font-family:inter;font-size:28px;font-weight:700;margin-top:20px'>";
                                            echo "<span style='margin-left:10px'>Our staff is preparing your document</span>";
                                        echo "</div>";
                                    } else if($xcert_status == "PUP"){

                                        echo "<div class='text-center' style='font-family:inter;font-size:28px;font-weight:700;margin-top:20px'>";
                                            echo "<span style='margin-left:10px'>Your certificate is ready for pickup</span>";
                                        echo "</div>";
                                        
                                    } else if($xcert_status == "RCV"){

                                        echo "<div class='text-center' style='font-family:inter;font-size:28px;font-weight:700;margin-top:20px'>";
                                            echo "<span style='margin-left:10px'>Your certificate has been received</span>";
                                        echo "</div>";
                                        
                                    } else if ($xcert_status === "APRV") {
                                        echo "<div class='text-center' style='font-family:inter;font-size:22px;font-weight:700;margin-top:20px'>";
                                            echo "<span style='margin-left:10px'>Certificate Approved</span>";
                                        echo "</div>";
                                    } else if ($xcert_status === "DEC") {
                                        echo "<div class='text-center' style='font-family:inter;font-size:22px;font-weight:700;margin-top:20px'>";
                                            echo "<span style='margin-left:10px'>Certificate Declined.</span>";
                                        echo "</div>";
                                        echo "<div class='text-center'>" . $xcertremarks ."</div>";
                                    } else {
                                        echo "<div class='text-center' style='font-family:inter;font-size:22px;font-weight:700;margin-top:20px'>";
                                            echo "<img src='images/Group.png'>";
                                            echo "<span style='margin-left:10px'>Eligible for Post Marriage Counseling</span>";
                                        echo "</div>";
                                    }

                                        $req_now_disabled = "";
                                    } else if($act_status == "NCT"){
                                        echo "<div class='text-center' style='font-family:inter;font-size:22px;font-weight:700;margin-top:20px'>";
                                            echo "<img src='images/red_x.png' style='width:20px;height:20px;'>";
                                            echo "<span style='margin-left:10px'>Certification Declined</span>";
                                        echo "</div>";

                                        $book_now_disbaled = "disabled";
                                        $req_now_disabled = "disabled";
                                    }else if($act_status == "RVW"){
                                        echo "<div class='text-center' style='font-family:inter;font-size:22px;font-weight:700;margin-top:20px'>";
                                            echo "<img src='images/Group.png'>";
                                            echo "<span style='margin-left:10px'>Account application for review</span>";
                                        echo "</div>";

                                        $book_now_disbaled = "disabled";
                                        $req_now_disabled = "disabled";

                                    }else if($act_status == "DEC"){
                                        echo "<div class='text-center' style='font-family:inter;font-size:22px;font-weight:700;margin-top:20px'>";
                                            echo "<img src='images/red_x.png' style='width:20px;height:20px;'>";
                                            echo "<span style='margin-left:10px; color: #ff0000;'>Account Declined</span>";
                                        echo "</div>";

                                        echo "<div class='text-center'>" . $remarks ."</div>";

                                        $book_now_disbaled = "disabled";
                                        $req_now_disabled = "disabled";
                                    }else if($act_status == "PCT"){
                                        echo "<div class='text-center' style='font-family:inter;font-size:22px;font-weight:700;margin-top:20px'>";
                                            echo "<img src='images/Group.png'>";
                                            echo "<span style='margin-left:10px'>Move on to Certification</span>";
                                        echo "</div>";

                                        $book_now_disbaled = "disabled";
                                    } else {
                                        
                                        echo "<div class='text-center' style='font-family:inter;font-size:22px;font-weight:700;margin-top:20px'>";
                                            echo "<img src='images/Group.png'>";
                                            echo "<span style='margin-left:10px'>No Status</span>";
                                        echo "</div>";
                                    }


                                    ?>

                                </div>
                                
                            </div>

                            <div style='width:80%;height:40%;background-color:white;border-radius:15px' class="mt-4">
                                    <div class="pt-3" style='font-size:22px;font-family:inter;font-weight:700;text-align:center'>Appointment</div>
                                    <div style='width:100%;display:flex;justify-content:center'>
                                        <img src="images/Rectangle 11934.png" style='width:80%;height:4px'>
                                    </div>

                                    <div style='width:100%;display:flex;justify-content:center'>

                                        <?php

                                            if($act_status == "PMO"){

                                                $select_db2="SELECT ext_mf_meiform.date as 'mf_date', ext_mf_meiform.from_to as 'from_to'  FROM ext_mf_meiform LEFT JOIN pro_meiform ON ext_mf_meiform.usermeiformid = pro_meiform.usermeiformid  WHERE ext_mf_meiform.userid=? AND pro_meiform.status = 'PMO' LIMIT 1";
                                                $stmt2	= $link->prepare($select_db2);
                                                $stmt2->execute(array($_SESSION['usr_id']));
                                                $row2 = $stmt2->fetch();

                                                $from_to = $row2["from_to"];
                                                $date_formatted = date('F d, Y', strtotime($row2["mf_date"]));

                                                if(!empty($from_to) && !empty($date_formatted)){
                                                    echo "<div style='font-family:inter;font-size:22px;font-weight:700;margin-top:20px;display:flex;flex-direction:row'>";
                                                        echo "<img src='images/calendar_yellow.png' style='width:35px;height:35px;margin-top:15px'>";
                                                        echo "<div style='display:flex;flex-direction:column'>";
                                                            echo "<span style='margin-left:10px'>".$date_formatted."(".$from_to.")</span>";
                                                            echo "<span style='margin-left:10px;font-size:11px;color:#616161;font-weight:400'>Pre-Marriage Orientation</span>";
                                                        echo "</div>";
                                                        
                                                    echo "</div>";

                                                }
                                                $req_now_disabled = "disabled";


                                            } else if($act_status == "PMC"){

                                                $select_db2="SELECT ext_mf_meiform.date as 'mf_date', ext_mf_meiform.from_to as 'from_to'  FROM ext_mf_meiform RIGHT JOIN pro_meiform ON ext_mf_meiform.usermeiformid = pro_meiform.usermeiformid  WHERE ext_mf_meiform.userid=? AND pro_meiform.status = 'PMC' LIMIT 1";
                                                $stmt2	= $link->prepare($select_db2);
                                                $stmt2->execute(array($_SESSION['usr_id']));
                                                $row2 = $stmt2->fetch();

                                                $from_to = $row2["from_to"];
                                                $date_formatted = date('F d, Y', strtotime($row2["mf_date"]));

                                                if(!empty($from_to) && !empty($date_formatted)){
                                                    echo "<div style='font-family:inter;font-size:22px;font-weight:700;margin-top:20px;display:flex;flex-direction:row'>";
                                                        echo "<img src='images/calendar_yellow.png' style='width:35px;height:35px;margin-top:15px'>";
                                                        echo "<div style='display:flex;flex-direction:column'>";
                                                            echo "<span style='margin-left:10px'>".$date_formatted."(".$from_to.")</span>";
                                                            echo "<span style='margin-left:10px;font-size:11px;color:#616161;font-weight:400'>Post Marriage Counseling</span>";
                                                        echo "</div>";
                                                        
                                                    echo "</div>";

                                                    $book_now_disbaled = "";
                                                    $req_now_disabled = "disabled";
                                                }else{
                                                    $book_now_disbaled = "";
                                                    //$req_now_disabled = "disabled";
                                                }
                                            } else {

                                                echo "<div class='text-center' style='font-family:inter;font-size:22px;font-weight:700;margin-top:20px'>";
                                                    echo "<span style='margin-left:10px'>No Appointment.</span>";
                                                echo "</div>";

                                            }

                                        ?>
                                    </div>
                                <div>

                                </div>
                                
                            </div>
       

                        </div>
                        <div style="width:50%">
                           <img src="images/Intro.png" style='width:100%' alt="">
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="d-flex align-items-top mx-0 px-0">
                    <div class="container-fluid pt-2" style="width:100%">
                        <div class="row d-flex justify-content-center">
                            <div style='width:25%;display:flex;justify-content:center;flex-direction:column;align-items:center'>
                                    <div class='text-center' style='font-size:22px;font-family:inter;font-weight:700'>SERVICES OFFERED</div>
                                    <img style='display:block;width:80%' src="images/blue_line.png" alt="">
                            </div>
                        </div>

                        <div class="row pt-2">
                            <div class="col-6 d-flex justify-content-center">
                                <div style='width:80%;background-color:white;border-radius:15px' class="mt-2">
                                    <div class="pt-3 d-flex align-items-end justify-content-center" style='font-size:28px;font-family:inter;font-weight:800;text-align:center;height:60px;
                                            background-color:#385399;color:#FFFFFF;
                                            border-top-left-radius:15px;
                                            border-top-right-radius:15px'>
                                        <span style='filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.63))'>BOOKING</span>
                                    </div>
                 
                                    <div>
                                        <div>
                                            <div class="col-12 text-center m-3" style='font-size:15px;font-family:inter;color:black;font-weight:800'>
                                            Pre-Marriage Orientation and Counseling (PMOC) Booking
                                            </div>

                                            <div class="col-12 text-center mx-3 mb-2 d-flex justify-content-center" style='font-size:14px;font-family:inter;color:black;font-weight:500' >
                                                <div style='width:70%'>Book your PMOC session now and invest in the well-being of your relationship. Start your married life with confidence, communication, and a deeper connection.</div>
                                            </div>

                                            <div class="d-flex justify-content-center mb-2">
                                                <button type="button" <?php echo $book_now_disbaled; ?> onclick="onBooking()" class="btn" style="background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:200px;height:36px;font-size:17px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">
                                                    Book Now
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                    
                                </div>
                            </div>
                            
                            <div class="col-6 d-flex justify-content-center">
                                <div style='width:80%;background-color:white;border-radius:15px' class="mt-2">
                                    <div class="pt-3 d-flex align-items-end justify-content-center" style='font-size:28px;font-family:inter;font-weight:800;text-align:center;height:60px;
                                            background-color:#385399;color:#FFFFFF;
                                            border-top-left-radius:15px;
                                            border-top-right-radius:15px'>
                                        <span style='filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.63))'>CERTIFICATION</span>
                                    </div>
                 
                                    <div>
                                        <div>
                                            <div class="col-12 text-center m-3" style='font-size:15px;font-family:inter;color:black;font-weight:800'>
                                            Pre-Marriage Orientation and Counseling (PMOC) Certificate
                                            </div>

                                            <div class="col-12 text-center mx-3 mb-2 d-flex justify-content-center" style='font-size:14px;font-family:inter;color:black;font-weight:500' >
                                                <div style='width:70%'>Celebrate your accomplishment and the journey to a fulfilling marriage by proudly displaying your PMOC certification.</div>
                                            </div>

                                            <div class="d-flex justify-content-center">
                                                <button type="button"  <?php echo $req_now_disabled; ?> class="btn" <?php

                                                    if($xcert_status==="PMC") {
                                                        if ($prnt_status === "1") {
                                                            echo "data-bs-toggle='modal data-bs-target='#modal_cert_reason'";
                                                        } else {
                                                            echo "onclick='onRequesting()'";
                                                        }
                                                    } else if ($xcert_status==="DEC") { 
                                                        echo "data-bs-toggle='modal' data-bs-target='#modal_cert_reason'";
                                                    } else if ($xcert_status === "APRV") {
                                                        if ($prnt_status === "1") {
                                                            echo "data-bs-toggle='modal' data-bs-target='#modal_cert_reason'";
                                                        } else {
                                                            echo "onclick='onRequesting()'";
                                                        }
                                                    } else if ($requested_btn === true || $prnt_status === "1") { 
                                                        echo "data-bs-toggle='modal' data-bs-target='#modal_cert_reason'";  
                                                    } else if ($act_status === "PMC") {
                                                        echo "onclick='onRequesting()'";
                                                    }

                                                  ?>style="background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:200px;height:36px;font-size:17px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">

                                                <?php

                                                    $print = "Print Now"; $requests = "Request To Print";

                                                    if($xcert_status==="PMC") { 
                                                        if ($prnt_status === "1") {
                                                            echo $requests;
                                                        } else {
                                                            echo $print;
                                                        }
                                                    } else if($xcert_status==="DEC") { 
                                                        echo $requests;
                                                    } else if ($xcert_status === "APRV") { 
                                                        if ($prnt_status === "1") {
                                                            echo $requests;
                                                        } else {
                                                            echo $print;
                                                        }
                                                    } else if($requested_btn === false) {
                                                        echo $requests;
                                                    } else if ($prnt_status === "1") {
                                                        echo $requests;
                                                    }

                                                ?>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </td>
            </tr>

        
        </table>

        <div class="modal fade  xerror_modal" data-bs-backdrop="static" id="xerror_modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Couples Connect Says:</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="error_msg">Modal body text goes here.</p>
                    </div>
     
                </div>
            </div>
        </div>

        <div class="modal fade modal_feedback" id="modal_feedback" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style='border-radius:25px'>
                <div class="modal-header">
                    <div class="modal-title">
                        <div style="color:black;font-family:inter;color:#252733;font-size:33px;font-weight:600">Feeback</div>
                        <div style="color:black;font-family:inter;color:#9B9B9B;font-size:21px;margin-top:-5px">Fill Up Form</div>
                    </div>
          
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mx-3">

                    <label for="" style='font-size:21px;color:252733;font-weight:600;font-family:inter'>Subject:</label>
                    <input type="text" class='form-control' style='border-radius:5px;height:50px;border:1px solid black' placeholder='Enter your subject' name="feedback_subject" id="feedback_subject">


                    <label for="" style='font-size:21px;color:252733;font-weight:600;font-family:inter;margin-top:20px'>Feedback:</label>
                    <textarea class="form-control" name="feedback_remarks" id="feedback_remarks" cols="30" rows="7" style='border-radius:5px;border:1px solid black' placeholder='Enter remarks'></textarea>
                    <div style='display:flex;justify-content:center;padding-top:25px;padding-bottom:20px'>
                        <button type="button" onclick="ajaxSubmit()" class="btn" style=";background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:250px;height:45px;font-size:25px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Submit</button>
                    </div>
                    
                </div>
          
                </div>
            </div>
        </div> 

        <div class="modal fade modal_cert_reason" id="modal_cert_reason" style="display: none;" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style='border-radius:25px'>
                <div class="modal-header">
                    <div class="modal-title">
                        <div style="color:black;font-family:inter;color:#252733;font-size:33px;font-weight:600">Certification</div>
                        <div style="color:black;font-family:inter;color:#9B9B9B;font-size:21px;margin-top:-5px">Fill Up Form</div>
                    </div>
          
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mx-3">
                    <label for="" style='font-size:21px;color:252733;font-weight:600;font-family:inter'>Reason for request:</label>
                    <textarea class="form-control" name="textarea_reason" id="textarea_reason" cols="30" rows="10" style='border-radius:5px;border: 1px solid black' placeholder='Enter Your Request'></textarea>
                    <div style='display:flex;justify-content:center;padding-top:25px;padding-bottom:20px'>
                        <button type="button" onclick="ajaxNew()" class="btn" style=";background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:250px;height:45px;font-size:25px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Submit</button>
                    </div>
                    
                </div>
          
                </div>
            </div>
        </div>  

        <footer style='height:100px;background-color:#23408E' class='footer'>
            <div class="container-fluid"  style='height:100px'>

                <div class="row"  style='height:100px'>
                    <div class="col-4">
                        <div class="row ms-3"  style='height:100px'>
                            <div class="col-2 d-flex align-items-center">
                                <img src="images/op office logo.png" style="height:77px;width:auto">
                            </div>

                            <div class="col-10 d-flex align-items-center">
                                <div class="container" style='font-family:inter;color:white'>
                                    <div class="col-12" style='font-size:15px;font-weight:bold'>
                                        City Population Office of Cabuyao
                                    </div>

                                    <div class="col-12" style='font-size:9px'>
                                        Brgy Dos. Cabuyao Retail Plaza, Cabuyao, Philippines
                                    </div>

                                    <div class="col-12" style='font-size:9px'>
                                        cpocabuyao@gmail.com
                                    </div>

                                </div>
          
                            </div>
                        </div>       
                    </div>

                    <div class="col-8 d-flex align-items-center justify-content-end">
                        <div>
                            <img src="images/pajamas_question.png" style='width:63px;height:auto;'>
                        </div>   
                    </div>
                </div>

            </div>
        </footer>

        <div class="floating-btn" onclick="window.location.href='./chat.php'">+</div>

        <input type="hidden" name="control_number_hidden" id="control_number_hidden" value="<?php echo $control_number;?>">
        
    </form>

    <script>

        function openFeedback(){
            $("#modal_feedback").modal("show");
        }

        function ajaxSubmit(){

            var email_subject = $("#feedback_subject").val();
            var email_remarks = $("#feedback_remarks").val();


            jQuery.ajax({    
                data:{
                    email_subject:email_subject,
                    email_remarks:email_remarks
                },
                dataType:"json",
                type:"post",
                url:"dashboard_user_ajax.php", 
                success: function(xdata){
                    $("#modal_feedback").modal("hide");
                },
                error: function (request, status, error) {
                }

            })

        }

        function onBooking(){
            document.forms.myforms.method = "post";
            document.forms.myforms.target = "_self";
            document.forms.myforms.action = "booking.php";
            document.forms.myforms.submit();
        }

        function onRequesting(){
            jQuery.ajax({
                data: {
                    userId: <?php echo $_SESSION['usr_recid']; ?>
                },
                type: "post",
                url: "update_print_status.php", // URL to the PHP handler
                success: function(xdata) {
                    window.print();
                },
                error: function(request, status, error) {
                    console.log("Error: " + error);
                }
            });
        }

        function validateEmail(input) {
            var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

            if (input.value.match(validRegex)) {
                return true;
            } else {
                return false;
            }

        }


        function ajaxNew(xevent_action){

        var control_number = $("#control_number_hidden").val();
        var textarea_reason = $("#textarea_reason").val();

        $.ajax({                                      
            url: 'cc_usr_certification_ajax.php',              
            type: "post",          
            data: {
                reason_req:textarea_reason,
                control_number:control_number
            },               
            success: function(xdata){
                $(".modal_cert_reason").modal("hide");
                $(".xerror_modal").modal("show");

            },
            error: function (request, status, error) {
                console.log(request)
            }
        });
    }



    </script>



<?php 
require "includes/cc_footer.php";
?>

