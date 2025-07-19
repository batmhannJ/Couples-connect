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
$act_status2 = $act_status;
$partner1_name = '';
$partner2_name = '';
$xheader_top = "";

$select_db_users = "SELECT ext_couples_accountinfo.first_name as 'first_name', " .
                   "ext_couples_accountinfo.middle_name as 'middle_name', " .
                   "ext_couples_accountinfo.last_name as 'last_name' " .
                   "FROM mf_prog_users " .
                   "RIGHT JOIN ext_couples_accountinfo ON mf_prog_users.userid = ext_couples_accountinfo.userid " .
                   "WHERE mf_prog_users.userid=? " .
                   "ORDER BY ext_couples_accountinfo.partnerno LIMIT 2";

$stmt_users	= $link->prepare($select_db_users);
$stmt_users->execute(array($_SESSION['usr_id']));

$xcounter_users = 0;
while($row_users = $stmt_users->fetch()){
    if($xcounter_users == 0){
        $partner1_name = $row_users['first_name'].' '.$row_users['middle_name'].' '.$row_users['last_name'];
    }else{
        $partner2_name = $row_users['first_name'].' '.$row_users['middle_name'].' '.$row_users['last_name'];
    }
    $xcounter_users++;
};
?>

<style>
.checkout-wrap {
    font-family: 'PT Sans Caption', sans-serif;
    margin: 30px auto 100px;
    z-index: 0;
}
ul.checkout-bar li {
    color: #ccc;
    font-size: 16px;
    font-weight: 600;
    position: relative;
    display: inline-block;
    margin: 50px auto;
    padding: 0;
    text-align: center;
    width: 24.5%;
}
ul.checkout-bar li:before {
    -webkit-box-shadow: inset 2px 2px 2px 0px rgba(0, 0, 0, 0.2);
    box-shadow: inset 2px 2px 2px 0px rgba(0, 0, 0, 0.2);
    background: #ddd;
    border: 2px solid #FFF;
    border-radius: 50%;
    color: #fff;
    font-size: 16px;
    font-weight: 700;
    text-align: center;
    text-shadow: 1px 1px rgba(0, 0, 0, 0.2);
    height: 34px;
    left: 40%;
    line-height: 34px;
    position: absolute;
    top: -60px;
    width: 34px;
    z-index: 99999;
}
ul.checkout-bar li.active {
  color: #A6447A;
  font-weight: bold;
}
ul.checkout-bar li.active:before {
  background: #A6447A;
}
ul.checkout-bar li.visited {
  color: #036c99;
  z-index: 99999;    
  background: none;
}
ul.checkout-bar li.visited:before {
  background: #036c99;
  z-index: 99999;
}
ul.checkout-bar li:nth-child(1):before {
  content: "1";
  left: 114%;
}
ul.checkout-bar li:nth-child(2):before {
  content: "2";
  left: 166%;
}
ul.checkout-bar a {
  color: #ccc;
  font-size: 16px;
  font-weight: 600;
  text-decoration: none;
  display: none;
}
ul.checkout-bar li.active a {
  color: #A6447A;
}
ul.checkout-bar li.visited a {
  color: #036c99;
}
ul.checkout-bar {
    -webkit-box-shadow: inset 2px 2px 2px 0px rgba(0, 0, 0, 0.2);
    box-shadow: inset 2px 2px 2px 0px rgba(0, 0, 0, 0.2);
    background-size: 35px 35px;
    background-color: #EcEcEc;
    background-image: -webkit-linear-gradient(-45deg, rgba(255, 255, 255, 0.4) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.4) 50%, rgba(255, 255, 255, 0.4) 75%, transparent 75%, transparent);
    background-image: -moz-linear-gradient(-45deg, rgba(255, 255, 255, 0.4) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.4) 50%, rgba(255, 255, 255, 0.4) 75%, transparent 75%, transparent);
    border-radius: 15px;
    height: 15px;
    margin: 0 -15px 0;
    padding: 0;
    position: absolute;
    width: 100%;
  }
ul.checkout-bar:before {
    background-size: 35px 35px;
    background-color: #036c99;
    background-image: -webkit-linear-gradient(-45deg, rgba(255, 255, 255, 0.2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.2) 75%, transparent 75%, transparent);
    background-image: -moz-linear-gradient(-45deg, rgba(255, 255, 255, 0.2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.2) 75%, transparent 75%, transparent);
    -webkit-box-shadow: inset 2px 2px 2px 0px rgba(0, 0, 0, 0.2);
    box-shadow: inset 2px 2px 2px 0px rgba(0, 0, 0, 0.2);
    border-radius: 15px;
    content: " ";
    height: 15px;
    left: 0;
    position: absolute;
    width: 67%;
  }
  ul.checkout-bar li.visited:after {
    background-size: 35px 35px;
    background-color: #036c99;
    background-image: -webkit-linear-gradient(-45deg, rgba(255, 255, 255, 0.2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.2) 75%, transparent 75%, transparent);
    background-image: -moz-linear-gradient(-45deg, rgba(255, 255, 255, 0.2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.2) 75%, transparent 75%, transparent);
    -webkit-box-shadow: inset 2px 2px 2px 0px rgba(0, 0, 0, 0.2);
    box-shadow: inset 2px 2px 2px 0px rgba(0, 0, 0, 0.2);
    content: "";
    height: 15px;
    left: 172%;
    position: absolute;
    top: -50px;
    width: 375px;
    z-index: 99;
    border-bottom-right-radius: 8px;
    border-top-right-radius: 8px;
  }
  ul.checkout-bar {
    width: 96%;
    margin: auto;
  }
  .checkout-wrap {
    margin: 39px auto 46px !important;
   }
  .has_hover:hover{
    cursor:pointer;
    opacity:0.5;
  }
</style>

<div class="container-fluid">
        <div class='row bg-white' style="height:99px">
            <div class="col-3 pe-0 d-flex align-items-center">
                <img src="images/350 x 88.png" style='height:76px;width:auto;'>
            </div>

            <div class="col-3 offset-6" style="display:flex;flex-direction:row;justify-content:center;font-family:inter;font-size:21px;align-items:center"> 
                <div style="flex:1.6;text-align:right;margin-right:25px">
                    <a href="http://localhost/couples-connect/dashboard_user.php" style='color:black;text-decoration:none' class='has_hover'>SERVICES</a>
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
                    <a href="http://localhost/couples-connect/logout_cc.php" style='color:black;text-decoration:none' class='has_hover'>LOGOUT</a>
                </div>
            </div> 
        </div>
    </div>
    
    <form name='myforms' id="myforms" method="post" target="_self" style='height:100%'> 
        <table style="width:100%;height:calc(100% - 100px);	filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25))">
            <tr style='height:175px'>
                <td class="d-flex align-items-top mx-0 px-0">
                    <div class="d-flex" style="display:flex;flex-direction:row;width:200%">
                    </div>
                </td>
            </tr>

            <tr style='height:500px;max-height:500px'>
                <td class="d-flex align-items-top mx-0 px-0">
                    <div class="container-fluid pt-4 d-flex justify-content-center" style="width:100%;">
                        <table id="table_data" name="table_data" style='background-color:white;border-radius:15px;width:92%'>
                            <?php

                            $xheader_top = "Post Marriage Counseling Schedules";

                            echo "<tr>";
                                echo "<td colspan='5' style='height:100px'>";

                                echo '<div class="p-3"><div class="alert alert-primary alert-dismissible fade show " role="alert">
                                          <strong>ATTENTION!</strong> Before booking a schedule for your Post Marriage Counseling, please ensure that you have completed the necessary forms. This step is required to proceed with your booking.
                                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div></div>';

                                    echo "<div class='container d-flex text-center align-items-center' style='font-family:inter;font-weight:700;font-size:27px;flex-direction:column'>";    
                                        echo $xheader_top;    
                                        echo "<img src='images/Rectangle 11934.png' style='width:784px; height:6px;margin-top:10px'>";    
                                    echo "</div>";    
                                echo "</td>";    
                            echo "</tr>";

                                echo "<tr>";
                                echo "<td style='padding-top:15px;padding-left:20px'>";
                                    echo "<div class='container text-left' style='font-family:inter;font-weight:700;font-size:25px;color:#797979'>";    
                                        echo "Venue";    
                                    echo "</div>";    
                                echo "</td>";

                                echo "<td>";
                                    echo "<div class='container text-left' style='font-family:inter;font-weight:700;font-size:25px;color:#797979''>";    
                                        echo "Date";    
                                    echo "</div>";    
                                echo "</td>";

                                echo "<td>";
                                    echo "<div class='container text-left' style='font-family:inter;font-weight:700;font-size:25px;color:#797979''>";    
                                        echo "Time";    
                                    echo "</div>";    
                                echo "</td>";

                                echo "<td>";
                                    echo "<div class='container text-center' style='font-family:inter;font-weight:700;font-size:25px;color:#797979''>";    
                                        echo "Slots Available";    
                                    echo "</div>";    
                                echo "</td>";   

                                echo "<td>";
                                        echo " ";    
                                echo "</td>";           
                            echo "</tr>";
                            $select_db_xid = "SELECT mf_venue.venue_link, mf_venue.is_online, mf_venue.venue, mf_venue.venue_id, 
                                                    mf_appointment_info.userid, ext_appointment_info.clinic_date, ext_appointment_info.time_from, ext_appointment_info.slots_avail, ext_appointment_info.recid
                                                FROM mf_venue 
                                                LEFT JOIN ext_appointment_info ON mf_venue.venue_id = ext_appointment_info.venue_id 
                                                LEFT JOIN mf_appointment_info ON ext_appointment_info.appointment_info_id = mf_appointment_info.appointment_info_id 
                                                    AND mf_appointment_info.sched_type = 'PMC'
                                                WHERE mf_venue.venue != ''
                                                GROUP BY mf_venue.venue_id";

                            $stmt = $link->prepare($select_db_xid);
                            $stmt->execute();
                        $xcounterx = 0;

                            while($row_xid = $stmt->fetch()){
    // Check if user has completed forms
    $select_db_checker = "SELECT * FROM pro_meiform 
                        LEFT JOIN mf_prog_users ON pro_meiform.userid = mf_prog_users.userid 
                        WHERE pro_meiform.userid=? AND pro_meiform.status='POST'";
    $stmt_checker = $link->prepare($select_db_checker);
    $stmt_checker->execute(array($_SESSION['usr_id']));
    $row_checker = $stmt_checker->fetchAll();
    
    if(count($row_checker) == 0){
        echo "<tr>";
        echo "<td style='padding-bottom:15px;padding-top:10px'>";
        echo "<div class='container text-start' style='font-family:inter;font-weight:700;font-size:25px;color:black;padding-left:25px'>";                                    
        echo $row_xid["venue"];                                                    
        echo "</div>";   
        echo "</td>";

        echo "<td>";
        echo "<select class='form-control w-75 ms-2 select_date'>";
        
        // FIXED QUERY: Proper JOIN and filtering
        $select_2 = "SELECT DISTINCT ext_appointment_info.clinic_date, 
                            ext_appointment_info.time_from, 
                            ext_appointment_info.time_to, 
                            ext_appointment_info.date_added,
                            ext_appointment_info.week_day, 
                            ext_appointment_info.slots_avail,
                            ext_appointment_info.recid,
                            mf_venue.venue,
                            mf_appointment_info.userid
                        FROM ext_appointment_info 
                        INNER JOIN mf_appointment_info ON ext_appointment_info.appointment_info_id = mf_appointment_info.appointment_info_id 
                        INNER JOIN mf_venue ON ext_appointment_info.venue_id = mf_venue.venue_id  
                        WHERE mf_venue.venue_id = ? 
                        AND ext_appointment_info.clinic_date";
        
        $stmt_2 = $link->prepare($select_2);
        $stmt_2->execute(array($row_xid['venue_id'])); // Use venue_id instead of venue name

        echo "<option disabled selected>Select a Date...</option>"; 

        while($row_xid2 = $stmt_2->fetch()){
            echo "<option 
                    data-xslotsavail='".$row_xid2['slots_avail']."' 
                    data-xdate='" . $row_xid2["clinic_date"] . "' 
                    data-xcounselorid='".$row_xid2["userid"]."' 
                    data-xrecid='".$row_xid2["recid"]."'
                    data-xvenue='".$row_xid2["venue"]."'
                    data-xtimefrom='".$row_xid2["time_from"]."'
                    data-xtimeto='".$row_xid2["time_to"]."'
                    >" . date('M d, Y', strtotime($row_xid2["clinic_date"])) . "</option>"; 
        }         
        echo "</select>";    
        echo "</td>";

        echo "<td>";
        echo "<select class='form-control w-75 ms-2 select_time'>";   
        echo "<option disabled selected>Select a Time...</option>"; 
        echo "</select>";
        echo "</td>";

        echo "<td class='text-center slots-cell'>";
        echo $row_xid['slots_avail'] ?? '0';    
        echo "</td>";

        echo "<td class='text-center'>";
            echo "<button type='button' disabled class='btn book-btn' onclick='bookAppointment(this)' style='background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>Book now</button>";
        echo "</td>";

        echo "</tr>";
    } else {
        // FIXED: Check if user has POST status appointments before proceeding
        $select_db_times2 = "SELECT pro_meiform.userid as 'userid', ext_mf_meiform.date as 'date', ext_mf_meiform.venue as 'venue', pro_meiform.counselorid as 'counselorid'  FROM pro_meiform LEFT JOIN ext_mf_meiform ON pro_meiform.usermeiformid = ext_mf_meiform.meiformid WHERE pro_meiform.userid='".$_SESSION['usr_id']."' AND pro_meiform.status='POST' LIMIT 1";
        $stmt_times2 = $link->prepare($select_db_times2);
        $stmt_times2->execute();
        $row_times2 = $stmt_times2->fetch();
        
        echo "<tr>";
            echo "<td style='padding-bottom:15px;padding-top:10px'>";
                echo "<div class='container text-start' style='font-family:inter;font-weight:700;font-size:25px;color:black;padding-left:25px'>";    

                // FIXED: Check if $row_times2 is not false before accessing array elements
                if($row_times2 && $row_xid['is_online'] == "Y" && ($row_times2['venue'] == $row_xid['venue'])){
                    echo "<a target='_blank' style='color:blue!important;text-decoration:underline!important' href='".$row_xid["venue_link"]."'>".$row_xid["venue"]."</a>";   
                } else {
                    echo $row_xid["venue"];  
                }
                echo "</div>";   
            echo "</td>";

            // FIXED: Check if $row_times2 exists and has data before comparing venue
            if($row_times2 && $row_times2['venue'] == $row_xid['venue']){

                $givendate = $row_times2['date'];
    
                $dateObject = DateTime::createFromFormat('Y-m-d', $givendate);
                $weekday = strtolower($dateObject->format('l'));
                    
                $select_db_times = "SELECT ext_mf_meiform.date as 'date', ext_mf_meiform.from_to as 'from_to', pro_meiform.usermeiformid as 'usermeiformid'  FROM pro_meiform LEFT JOIN ext_mf_meiform ON pro_meiform.usermeiformid = ext_mf_meiform.meiformid WHERE pro_meiform.userid='".$_SESSION['usr_id']."'  AND pro_meiform.status='POST' LIMIT 1";
                $stmt_times = $link->prepare($select_db_times);
                $stmt_times->execute();
                $selected_timeline = '';
                while($row_times = $stmt_times->fetch()){

                    $meiformuid = $row_times['usermeiformid'];

                    echo "<td>";
                        echo "<select class='form-control w-75 ms-2 select_time' disabled>"; 
                            echo "<option>"; 
                                echo $row_times['date']; 
                            echo "</option>"; 
                        echo "</select>";

                    echo "</td>";

                    echo "<td>";
                        echo "<select class='form-control w-75 ms-2 select_date' disabled>";
                            echo "<option>"; 
                                echo $row_times['from_to']; 
                            echo "</option>"; 
                        echo "</select>";
                    echo "</td>";

                    echo "<td class='text-center'>";
                        echo $row_xid['slots_avail'];    
                    echo "</td>";
                    
                    echo "<td class='text-center'>";
                        echo "<button type='button' onclick='ajaxNew(\"cancel_booking\",\"\",\"\",\"\",\"".$meiformuid."\")' class='btn' style='background: rgb(35,64,142);background: linear-gradient(90deg, #e60000 35%, #990000 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>Cancel</button>";    
                    echo "</td>";

                    $xcounterx++;
                }
            } else {
                echo "<td>";
                    echo "<select class='form-control w-75 ms-2'' disabled>";   
                        echo "<option disabled selected>"; 
                            echo "Select a Date..."; 
                        echo "</option>"; 
                    echo "</select>";
                echo "</td>";

                echo "<td class='text-center'>";
                    echo "<select class='form-control w-75 ms-2'' disabled>";   
                        echo "<option disabled selected>"; 
                            echo "Select a Time..."; 
                        echo "</option>"; 
                    echo "</select>";
                echo "</td>";

                echo "<td class='text-center'>";
                    echo $row_xid['slots_avail'];    
                echo "</td>";

                echo "<td class='text-center'>";
                    echo "<button type='button' disabled class='btn book-btn' onclick='bookAppointment(this)' style='background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>Book now</button>";
                echo "</td>";
            }

        echo "</tr>";                       
    } 
}                         
                            ?>
                        </table>

                    </div>
                </td>
            </tr>

        </table>

        <input type="hidden" name="act_status_hidden" id="act_status_hidden" value="<?php echo $act_status;?>">

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

        <div class="modal fade  proceed_modal" data-bs-backdrop="static" id="proceed_modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style='border-radius:15px'>
                    <div class="modal-header">
                        <h5 class="modal-title error_msg_title" style="font-size:38px;font-family:inter;font-weight:bold">Notice</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="error_msg" style='font-family:inter;font-size:24px;font-weight:300'>Before applying for Post Marriage Counseling, please ensure both partners have completed any required forms.</p>
                    </div>

                    <div class="container-fluid d-flex justify-content-center pb-4">
                        <button type='button' onclick='proceed_func()' class='btn' style='background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>Proceed</button>
                    </div>
                </div>
            </div>
        </div>        

        <div class="modal fade modal_feedback" id="modal_feedback" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style='border-radius:25px'>
                <div class="modal-header">
                    <div class="modal-title">
                        <div style="color:black;font-family:inter;color:#252733;font-size:33px;font-weight:600">Feedback</div>
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
                        <button type="button" onclick="ajaxSubmit()" class="btn" style="background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:250px;height:45px;font-size:25px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Submit</button>
                    </div>
                </div>
                </div>
            </div>
        </div>           

        <input type="hidden" name="venue_hidden" id="venue_hidden">
        <input type="hidden" name="date_hidden" id="date_hidden">
        <input type="hidden" name="timeline_hidden" id="timeline_hidden">
        <input type="hidden" name="counselor_hidden" id="counselor_hidden">
        <input type="hidden" name="recid_hidden" id="recid_hidden">
        <input type="hidden" name="act_status_hidden" id="act_status_hidden" value="PMC">

        <footer style="height:100px;background-color:#23408E">
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
    </form>

<script>
// Fixed JavaScript for Post Marriage Booking
$(document).on('change', '.select_date', function(e) {
    console.log('DEBUG: Date dropdown changed');
    
    var selectedOption = $(this).find('option:selected');
    var xdate = selectedOption.data('xdate');
    var xrecid = selectedOption.data('xrecid');
    var xvenue = selectedOption.data('xvenue');
    var xtimefrom = selectedOption.data('xtimefrom');
    var xtimeto = selectedOption.data('xtimeto');
    var xslotsavail = selectedOption.data('xslotsavail');
    var xcounselorid = selectedOption.data('xcounselorid');
    
    console.log('DEBUG: Selected data:', {
        date: xdate,
        recid: xrecid,
        venue: xvenue,
        timeFrom: xtimefrom,
        timeTo: xtimeto,
        slots: xslotsavail,
        counselorId: xcounselorid
    });
    
    // Store values in hidden fields
    $("#venue_hidden").val(xvenue);
    $("#date_hidden").val(xdate);
    $("#recid_hidden").val(xrecid);
    $("#counselor_hidden").val(xcounselorid);
    
    var timeDropdown = $(this).closest('tr').find('.select_time');
    var slotsCell = $(this).closest('tr').find('.slots-cell');
    var bookBtn = $(this).closest('tr').find('.book-btn');
    
    // Clear and populate time dropdown
    timeDropdown.html('<option disabled selected>Select Time...</option>');
    
    if(xtimefrom && xtimeto && xtimefrom !== '' && xtimeto !== '') {
        console.log('DEBUG: Adding time option:', xtimefrom + ' - ' + xtimeto);
        var timeText = xtimefrom + ' - ' + xtimeto;
        timeDropdown.append('<option value="' + timeText + '">' + timeText + '</option>');
        timeDropdown.prop('disabled', false);
        
        // Update slots
        slotsCell.text(xslotsavail || '0');
        
        console.log('DEBUG: Time dropdown populated successfully');
    } else {
        console.log('DEBUG: No time data found');
        timeDropdown.html('<option disabled selected>No times available</option>');
    }
});

// Time selection handler
$(document).on('change', '.select_time', function(e) {
    var selected_time = $(this).val();
    console.log('DEBUG: Time selected:', selected_time);
    
    $("#timeline_hidden").val(selected_time);
    
    var bookButton = $(this).closest('tr').find('.book-btn');
    if (selected_time && selected_time !== 'Select Time...' && selected_time !== 'No times available') {
        bookButton.prop('disabled', false);
        console.log('DEBUG: Book button enabled');
    } else {
        bookButton.prop('disabled', true);
        console.log('DEBUG: Book button disabled');
    }
});

$(document).ready(function() {
    console.log('DEBUG: Document ready');
    
    // Check if dropdowns have data on page load
    $('.select_date').each(function() {
        var optionCount = $(this).find('option').length;
        console.log('DEBUG: Date dropdown has', optionCount, 'options');
    });
});

function bookAppointment(button) {
    console.log('DEBUG: Book now button clicked');
    
    var venue = $("#venue_hidden").val();
    var date = $("#date_hidden").val();
    var timeline = $("#timeline_hidden").val();
    var counselor = $("#counselor_hidden").val();
    var recid = $("#recid_hidden").val();
    
    console.log('DEBUG: Booking data:', {
        venue: venue,
        date: date,
        timeline: timeline,
        counselor: counselor,
        recid: recid
    });
    
    // Improved validation
    if (!venue || venue === '') {
        alert('Please select a venue.');
        return;
    }
    if (!date || date === '') {
        alert('Please select a date.');
        return;
    }
    if (!timeline || timeline === '' || timeline === 'Select Time...') {
        alert('Please select a time.');
        return;
    }
    if (!counselor || counselor === '') {
        alert('Counselor information is missing. Please try selecting the date again.');
        return;
    }
    if (!recid || recid === '') {
        alert('Appointment record ID is missing. Please try selecting the date again.');
        return;
    }

    // Disable button to prevent double-clicking
    $(button).prop('disabled', true).text('Booking...');
    
    $.ajax({
        url: 'post_marriage_ajax.php',
        type: 'POST',
        dataType: 'text', // Changed to text first to debug
        data: {
            event_action: 'book_now',
            date: date,
            counselorid: counselor,
            ext_recid: recid,
            timeline: timeline,
            venue_hidden: venue
        },
        success: function(response) {
            console.log('DEBUG: Raw response:', response);
            
            try {
                // Try to parse JSON
                var jsonResponse = JSON.parse(response);
                console.log('DEBUG: Parsed JSON response:', jsonResponse);
                
                if (jsonResponse.success) {
                    alert('Booking successful!');
                    location.reload();
                } else {
                    alert('Booking failed: ' + (jsonResponse.message || 'Unknown error'));
                    $(button).prop('disabled', false).text('Book now');
                }
            } catch (parseError) {
                console.error('DEBUG: JSON parse error:', parseError);
                console.log('DEBUG: Response that failed to parse:', response);
                alert('Server error: Invalid response format');
                $(button).prop('disabled', false).text('Book now');
            }
        },
        error: function(xhr, status, error) {
            console.error('DEBUG: Booking AJAX error:', error);
            console.error('DEBUG: Status:', status);
            console.error('DEBUG: Response text:', xhr.responseText);
            console.error('DEBUG: Status code:', xhr.status);
            
            alert('Error occurred while booking. Please try again. (Status: ' + xhr.status + ')');
            $(button).prop('disabled', false).text('Book now');
        }
    });
}

function ajaxNew(action, param1, param2, param3, meiformid) {
    console.log('DEBUG: Cancel booking called with meiformid:', meiformid);
    
    if (action === 'cancel_booking') {
        if (confirm('Are you sure you want to cancel this booking?')) {
            $.ajax({
                url: 'post_marriage_ajax.php',
                type: 'POST',
                dataType: 'text', // Changed to text first to debug
                data: {
                    event_action: 'cancel_booking',
                    meiformid_post: meiformid
                },
                success: function(response) {
                    console.log('DEBUG: Raw cancel response:', response);
                    
                    try {
                        var jsonResponse = JSON.parse(response);
                        console.log('DEBUG: Parsed cancel response:', jsonResponse);
                        
                        if (jsonResponse.success) {
                            alert('Booking cancelled successfully!');
                            location.reload();
                        } else {
                            alert('Cancellation failed: ' + (jsonResponse.message || 'Unknown error'));
                        }
                    } catch (parseError) {
                        console.error('DEBUG: JSON parse error:', parseError);
                        console.log('DEBUG: Response that failed to parse:', response);
                        alert('Server error: Invalid response format');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('DEBUG: Cancel AJAX error:', error);
                    console.error('DEBUG: Response text:', xhr.responseText);
                    alert('Error occurred while cancelling. Please try again.');
                }
            });
        }
    }
}

// Add feedback functions
function openFeedback() {
    $('#modal_feedback').modal('show');
}

function ajaxSubmit() {
    var subject = $('#feedback_subject').val();
    var remarks = $('#feedback_remarks').val();
    
    if (!subject.trim()) {
        alert('Please enter a subject.');
        return;
    }
    
    if (!remarks.trim()) {
        alert('Please enter your feedback.');
        return;
    }
    
    // You can implement the feedback submission AJAX call here
    alert('Feedback submitted successfully!');
    $('#modal_feedback').modal('hide');
    $('#feedback_subject').val('');
    $('#feedback_remarks').val('');
}

function proceed_func() {
    $('#proceed_modal').modal('hide');
}
</script>
<?php 
require "includes/cc_footer.php";
?>