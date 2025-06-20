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

$select_db_users="SELECT ext_couples_accountinfo.first_name as 'first_name', ext_couples_accountinfo.middle_name as 'middle_name',
ext_couples_accountinfo.last_name as 'last_name'  FROM mf_prog_users RIGHT JOIN ext_couples_accountinfo ON mf_prog_users.userid = ext_couples_accountinfo.userid WHERE mf_prog_users.userid=? ORDER BY ext_couples_accountinfo.partnerno LIMIT 2";
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
                    <a href="http://localhost/couples-connectprog/dashboard_user.php" style='color:black;text-decoration:none' class='has_hover'>SERVICES</a>
                </div>

                <div style="flex:1.8;text-align:center;margin-right:10px">
                    <a style='color:black;text-decoration:none' class='has_hover' onclick="openFeedback()">FEEDBACK</a>
                </div>

                <div style="flex:0.3;text-align:center">
                    <a href="" style='color:black;text-decoration:none'>|</a>
                </div>

                <div style="flex:1;text-align:center;margin-right:10px">
                    <a href="" style='color:black;text-decoration:none'><?php echo $header_name;?> </a>
                </div>

                <div style="flex:0.6;text-align:right;padding-right:25px">
                    <a href="http://localhost/couples-connectprog/logout_cc.php" style='color:black;text-decoration:none' class='has_hover'>LOGOUT</a>
                </div>

            </div> 
        </div>
    </div>
    
    <form name='myforms' id="myforms" method="post" target="_self" style='height:100%'> 
        <table style="width:100%;height:calc(100% - 100px);	filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25))">
            <tr style='height:175px'>
                <td class="d-flex align-items-top mx-0 px-0">
                    <div class="d-flex" style="display:flex;flex-direction:row;width:200%">
                        <div style="width:50%;display:flex;justify-content:center;flex-direction:column;align-items:center">
                            <div style='width:80%;height:150px;background-color:white;border-radius:15px' class="mt-4">
                                <div class="pt-3" style='font-size:27px;font-family:inter;font-weight:700;text-align:center'>Status</div>
                                <div style='width:100%;display:flex;justify-content:center'>
                                    <img src="images/Rectangle 11934.png" style='width:80%;height:4px'>
                                </div>
                                <div>
                                    <?php   
                                    if($act_status == "APR"){
                                        echo "<div class='text-center' style='font-family:inter;font-size:28px;font-weight:700;margin-top:20px'>";
                                            echo "<img src='images/Group.png'>";
                                            echo "<span style='margin-left:10px'>Requires Pre-Marriage Orientation</span>";
                                        echo "</div>";
                                    }else if($act_status == "PMO"){
                                        echo "<div class='text-center' style='font-family:inter;font-size:28px;font-weight:700;margin-top:20px'>";
                                            echo "<img src='images/Group.png'>";
                                            echo "<span style='margin-left:10px'>Waiting for Approval</span>";
                                        echo "</div>";
                                    }else if($act_status == "PMC"){
                                        echo "<div class='text-center' style='font-family:inter;font-size:28px;font-weight:700;margin-top:20px'>";
                                            echo "<img src='images/Group.png'>";
                                            echo "<span style='margin-left:10px'>Requires Pre-Marriage Counseling</span>";
                                        echo "</div>";
                                    }
                                    ?>

                                </div>
                                
                            </div>
                        </div>
                    </div>
                </td>
            </tr>

            <tr style='height:500px;max-height:500px'>
                <td class="d-flex align-items-top mx-0 px-0">
                    <div class="container-fluid pt-4 d-flex justify-content-center" style="width:100%;">
                        <table id="table_data" name="table_data" style='background-color:white;border-radius:15px;width:92%'>
                            <?php

                      
                            if($act_status == "PMC"){
                                $xheader_top = "Pre-Marriage Counseling Schedules";
                            }else if($act_status == "PMO" || $act_status == "APR"){
                                $xheader_top = "Pre-Marriage Orientation Schedules";
                            }




                            echo "<tr>";
                                echo "<td colspan='5' style='height:100px'>";
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

                            if($act_status == "PMO" || $act_status == "APR"){
                                echo "<td>";
                                    echo "<div class='container text-center' style='font-family:inter;font-weight:700;font-size:25px;color:#797979''>";    
                                        echo "Slots Available";    
                                    echo "</div>";    
                                echo "</td>";   

                                $act_status2 = "PMO";
                            }

     

                                echo "<td>";
                                        echo "&nbsp;";    
                                echo "</td>";           
                            echo "</tr>";

                            

                            $select_db_xid = "SELECT ext_appointment_info.venue as 'venue', mf_appointment_info.userid as 'userid',ext_appointment_info.slots_avail as 'slots_avail',
                            ext_appointment_info.recid as 'ext_recid'  FROM ext_appointment_info LEFT JOIN mf_appointment_info ON 
                            ext_appointment_info.appointment_info_id   = mf_appointment_info.appointment_info_id WHERE ext_appointment_info.venue!='' AND mf_appointment_info.sched_type='".$act_status2."'  GROUP BY ext_appointment_info.venue ";
                            $stmt	= $link->prepare($select_db_xid);
                            $stmt->execute();
                            $xevent_key=0;
                            $xchecker_time = 0;
                            $xcounterx = 0;
                        
                            while($row_xid = $stmt->fetch()){

                                $select_db_checker = "SELECT * FROM pro_meiform LEFT JOIN mf_prog_users ON pro_meiform.userid = mf_prog_users.userid WHERE pro_meiform.userid='".$_SESSION['usr_id']."' AND pro_meiform.status='".$act_status2."'";
                                $stmt_checker	= $link->prepare($select_db_checker);
                                $stmt_checker->execute();
                                $row_checker = $stmt_checker->fetchAll();
                                
                               if(count($row_checker) == 0 ){
   
                                echo "<tr>";
                                        echo "<td style='padding-bottom:15px;padding-top:10px'>";
                                            echo "<div class='container text-start' style='font-family:inter;font-weight:700;font-size:25px;color:black;padding-left:25px'>";    
                                                echo $row_xid["venue"];    
                                            echo "</div>";   
                                        echo "</td>";
                            
                                        echo "<td>";
                                            echo "<select class='form-control w-75 ms-2 select_date'>";
                                                $select_2 = "SELECT ext_appointment_info.time_from as 'time_from', ext_appointment_info.time_to as 'time_to', ext_appointment_info.date_added as 'date_added',
                                                mf_prog_users.email as 'username',  ext_appointment_info.week_day as 'weekday', ext_appointment_info.venue as 'venue' 
                                                FROM ext_appointment_info LEFT JOIN mf_appointment_info ON 
                                                ext_appointment_info.appointment_info_id = mf_appointment_info.appointment_info_id LEFT JOIN mf_prog_users ON
                                                mf_appointment_info.userid = mf_prog_users.userid WHERE mf_prog_users.userid='".$row_xid['userid']."'  AND ext_appointment_info.venue='".$row_xid['venue']."'";
                                                $stmt_2	= $link->prepare($select_2);
                                                $stmt_2->execute();
                            
                                                while($row_xid2 = $stmt_2->fetch()){
                                        
                                                    if($row_xid2['weekday'] == 'monday'){
                                                        $xweekday = 1;
                                                    }else if($row_xid2['weekday'] == 'tuesday'){
                                                        $xweekday = 2;
                                                    }else if($row_xid2['weekday'] == 'wednesday'){
                                                        $xweekday = 3;
                                                    }else if($row_xid2['weekday'] == 'thursday'){
                                                        $xweekday = 4;
                                                    }else if($row_xid2['weekday'] == 'friday'){
                                                        $xweekday = 5;
                                                    }else if($row_xid2['weekday'] == 'saturday'){
                                                        $xweekday = 6;
                                                    }else if($row_xid2['weekday'] == 'sunday'){
                                                        $xweekday = 0;
                                                    }
                            
                            
                                                    date_default_timezone_set('Asia/Manila');
                                                    $current_year = date("Y");
                            
                                                    $startingDate = date("Y-m-d");
                                                    $targetDayOfWeek = $xweekday; // 1 represents Monday
                                                    
                                                    $date = new DateTime($startingDate);
                                                    $nextWeekday = $date->modify('next Monday');
                                            
                                                    $start = new DateTime($nextWeekday->format('Y-m-d'));
                                                    $end = new DateTime("$current_year-12-31");
                                            
                                                    for ($date = $start; $date <= $end; $date->add(new DateInterval('P1D'))) {
                                                        if ($date->format('w') == $xweekday) {
                                            
                                                            $xdate = $date->format('Y-m-d');
                                            
                                                            $ret["retEdit"][$xevent_key]["date"] = $xdate;
                                                            $ret["retEdit"][$xevent_key]["userid"] = $row_xid["userid"];
                                                            $ret["retEdit"][$xevent_key]["ext_recid"] = $row_xid["ext_recid"];
                                                            $ret["retEdit"][$xevent_key]["venue"] = $row_xid["venue"];
                                            
                                                            // $ret['html'] .= "<option timeline='" . $xtimeline. "'>" . $xdate . "</option>"; 
                                                            
                                                            $xevent_key++;
                                                        }
                                                    }
                                            
                                                }            
                            
                                                usort($ret["retEdit"], function ($a, $b) {
                                                    $dateA = new DateTime($a["date"]);
                                                    $dateB = new DateTime($b["date"]);
                                                    return $dateA <=> $dateB;
                                                });
                            
                                                $xseleted = '';
                                                
                                                foreach ($ret['retEdit'] as $event => $key) {
                
                            
                                                    echo "<option ".$xseleted." 
                                                    data-xslotsavail='".$row_xid['slots_avail']."' 
                                                    data-xdate='" . $key['date'] . "' 
                                                    data-xcounselorid='".$key['userid']."' 
                                                    data-xrecid='".$key['ext_recid']."'
                                                    data-xvenue='".$key['venue']."'
                                                    >" . $key['date'] . "</option>"; 
                                                    $xseleted = '';
                                                }
                            
                                                unset($ret["retEdit"]);
                            
                            
                                            echo "<select>";    
                                        echo "</td>";

                                        echo "<td>";
                                            echo "<select class='form-control w-75 ms-2''>";   
                                                echo "<option disabled selected>"; 
                                                    echo "Select a Date..."; 
                                                echo "</option>"; 
                                            echo "</select>";
                                        echo "</td>";


                                        if($act_status2 == "PMO"){
                                            echo "<td class='text-center'>";
                                                echo "Select a Date...";    
                                            echo "</td>";
                                        }
                        
                                        
                        
                                        echo "<td class='text-center'>";
                                            echo " <button type='button' disabled class='btn' style='background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>Book now</button>";    
                                        echo "</td>";

                            
                                echo "</tr>";

                               }else{
                                
                                echo "<tr>";
                                    echo "<td style='padding-bottom:15px;padding-top:10px'>";
                                        echo "<div class='container text-start' style='font-family:inter;font-weight:700;font-size:25px;color:black;padding-left:25px'>";    
                                            echo $row_xid["venue"];    
                                        echo "</div>";   
                                    echo "</td>";
                    
                      
               
                                    $select_db_times2 = "SELECT pro_meiform.userid as 'userid', ext_mf_meiform.date as 'date', ext_mf_meiform.venue as 'venue', pro_meiform.counselorid as 'counselorid'  FROM pro_meiform LEFT JOIN ext_mf_meiform ON pro_meiform.usermeiformid = ext_mf_meiform.usermeiformid WHERE pro_meiform.userid='".$_SESSION['usr_id']."' AND pro_meiform.status='".$act_status2."' LIMIT 1";
                                    $stmt_times2	= $link->prepare($select_db_times2);
                                    $stmt_times2->execute();
                                    $row_times2 = $stmt_times2->fetch();

                                    if($row_times2['venue'] == $row_xid['venue']){
                    
                                        $givendate = $row_times2['date'];
                            
                                        $dateObject = DateTime::createFromFormat('Y-m-d', $givendate);
                                        $weekday = strtolower($dateObject->format('l'));
                                        
                                      
                                            
                                            $select_db_times = "SELECT ext_mf_meiform.date as 'date', ext_mf_meiform.from_to as 'from_to', pro_meiform.usermeiformid as 'usermeiformid'  FROM pro_meiform LEFT JOIN ext_mf_meiform ON pro_meiform.usermeiformid = ext_mf_meiform.usermeiformid WHERE pro_meiform.userid='".$_SESSION['usr_id']."'  AND pro_meiform.status='".$act_status2."' LIMIT 1";
                                            $stmt_times	= $link->prepare($select_db_times);
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
                                            }
                                
                             
                             
                    
                                        if($act_status2 == "PMO"){
                                            echo "<td class='text-center'>";
                                                echo $row_xid['slots_avail'];    
                                            echo "</td>";
                                        }
                                        
                    
                    
                                        echo "<td class='text-center'>";
                                            echo "<button type='button' onclick='ajaxNew(\"cancel_booking\",\"\",\"\",\"\",\"".$meiformuid."\")' class='btn' style='background: rgb(35,64,142);background: linear-gradient(90deg, #e60000 35%, #990000 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>Cancel</button>";    
                                        echo "</td>";

                                        $xcounterx++;
                    
                                    }else{
                                        echo "<td>";
                                            echo "<select class='form-control w-75 ms-2''>";   
                                                echo "<option disabled selected>"; 
                                                    echo "Select a Date..."; 
                                                echo "</option>"; 
                                            echo "</select>";
                                        echo "</td>";
                    
                                        echo "<td class='text-center'>";
                                            echo "Select a Date...";    
                                        echo "</td>";


                                        if($act_status2 == "PMO"){
                                            echo "<td class='text-center'>";
                                                echo "Select a Date...";    
                                            echo "</td>";
                                        }

                                     
                    
                                        echo "<td class='text-center'>";
                                            echo " <button type='button' disabled class='btn' style='background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>Book now</button>";    
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
                        <p class="error_msg" style='font-family:inter;font-size:24px;font-weight:300'>Before applying for Pre-marriage Orientation, it's necessary for both partners to complete the Marriage Expectation Form. Partner 1 will start by answering the form, followed by Partner 2 once Partner 1 has finished.</p>
                    </div>

                    <div class="container-fluid d-flex justify-content-center pb-4">
                        <button type='button' onclick='proceed_func()' class='btn' style='background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>Proceed</button>
                    </div>
     
                </div>
            </div>
        </div>        

        <div class="modal fade meiform_modal" id="meiform_modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog modal-xl  modal-dialog-scrollable">
                <div class="modal-content modal">
                <div class="modal-header">
                    <div class="container">
                        <h5 class="modal-title text-start" id="exampleModalToggleLabel2" style="font-size:33px;font-family:inter;font-weight:500">Marriage Expectation Form</h5>
                        <h7 class="modal-title text-left" id="exampleModalToggleLabel2" style="color:#9B9B9B">Fill Up Form</h7>
                    </div>
                    
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="container-fluid">

                        <div class="container" style='font-family:inter;font-size:20px;'>

                            <span style='font-size:32px;font-weight:400px;'>Partner 1</span>
                            <?php
                               echo $partner1_name;
                            ?>

                        </div>
                        

                        <div class="container">
                            <div style='width:400px'>
                                Please answer based on who is assigned as Partner 1 or 2 from the initial registration to avoid any confusion.*
                            </div>
                            
                        </div>

                    </div>
                    
                    <table>
                        <tr>
                            <td style='font-size:25px;font-family:inter;font-weight:500;color:#797979;width:70%;padding-left:20px;padding-top:10px'>
                                Statement
                            </td>

                            <td style='font-size:25px;font-family:inter;font-weight:500;color:#797979' class='px-3'>
                                Answer
                            </td>

                            <td style='font-size:25px;font-family:inter;font-weight:500;color:#797979'>
                                Reason/s
                            </td>
                        </tr>

                        <?php


                            $select_db_meiform = "SELECT * FROM mf_meiform";
                            $stmt_meiform	= $link->prepare($select_db_meiform);
                            $stmt_meiform->execute();
                            $mei_form1_counter = 1;
                            while($row_meiform = $stmt_meiform->fetch()){
                                echo "<tr>";

                                    echo "<td style='width:70%;font-weight:500;font-family:inter;font-size:16px;padding-left:20px;padding-top:10px'>";
                                        echo "<div style='width:90%'>".$mei_form1_counter.". ".$row_meiform["questions"]."</div>";
                                    echo "</td>";

                                    echo "<td class='px-3'>";
                                        echo "<select class='form-control' name='form_1[".$mei_form1_counter."][option]' id='form_1[".$mei_form1_counter."][option]'>";
                                            echo "<option>Agree</option>";
                                            echo "<option>Disagree</option>";
                                        echo "</select>";
                                    echo "</td>";

                                    echo "<td>";
                                        echo "<input type='text' class='form-control' name='form_1[".$mei_form1_counter."][input]' id='form_1[".$mei_form1_counter."][input]'>";
                                    echo "</td>";                                    

                                echo "</tr>";

                                $mei_form1_counter++;
                                
                            }

                        ?>
                    </table>

                    <div class="container-fluid" style='margin-top:50px'>

                        <div class="container" style='font-family:inter;font-size:20px;'>

                            <span style='font-size:32px;font-weight:400px;'>Partner 2</span>
                            <?php
                               echo $partner2_name;
                            ?>
                        </div>
                        

                        <div class="container">
                            <div style='width:400px'>
                                Please answer based on who is assigned as Partner 1 or 2 from the initial registration to avoid any confusion.*
                            </div>
                            
                        </div>

                    </div>
                    
                    <table>
                        <tr>
                            <td style='font-size:25px;font-family:inter;font-weight:500;color:#797979;width:70%;padding-left:20px;padding-top:10px'>
                                Statement
                            </td>

                            <td style='font-size:25px;font-family:inter;font-weight:500;color:#797979' class='px-3'>
                                Answer
                            </td>

                            <td style='font-size:25px;font-family:inter;font-weight:500;color:#797979'>
                                Reason/s
                            </td>
                        </tr>

                        <?php


                            $select_db_meiform2 = "SELECT * FROM mf_meiform";
                            $stmt_meiform2	= $link->prepare($select_db_meiform2);
                            $stmt_meiform2->execute();
                            $mei_form2_counter = 1;
                            while($row_meiform2 = $stmt_meiform2->fetch()){
                                echo "<tr>";

                                    echo "<td style='width:70%;font-weight:500;font-family:inter;font-size:16px;padding-left:20px;padding-top:10px'>";
                                        echo "<div style='width:90%'>".$mei_form2_counter.". ".$row_meiform2["questions"]."</div>";
                                    echo "</td>";

                                    echo "<td class='px-3'>";
                                        echo "<select class='form-control' name='form_2[".$mei_form2_counter."][option]' id='form_2[".$mei_form2_counter."][option]' >";
                                            echo "<option>Agree</option>";
                                            echo "<option>Disagree</option>";
                                        echo "</select>";
                                    echo "</td>";

                                    echo "<td>";
                                        echo "<input type='text' class='form-control'  name='form_2[".$mei_form2_counter."][input]' id='form_2[".$mei_form2_counter."][input]'>";
                                    echo "</td>";                                    

                                echo "</tr>";

                                $mei_form2_counter++;
                                
                            }

                        ?>
                    </table>                    
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type='button' onclick="ajaxNew('submitAll','','','','')" class='btn' style='background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>Submit</button>
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

        <input type="hidden" name="venue_hidden" id="venue_hidden">
        <input type="hidden" name="date_hidden" id="date_hidden">
        <input type="hidden" name="timeline_hidden" id="timeline_hidden">
        <input type="hidden" name="counselor_hidden" id="counselor_hidden">
        <input type="hidden" name="recid_hidden" id="recid_hidden">

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


        $('.select_date').on('change', function(e) {
            var selectedOption = $(this).find('option:selected');
            var xdate = selectedOption.data('xdate');
            var xcounselorid = selectedOption.data('xcounselorid');
            var xrecid = selectedOption.data('xrecid');
            var xvenue = selectedOption.data('xvenue');

            $("#venue_hidden").val(xvenue);
            $("#date_hidden").val(xdate);
            $("#counselor_hidden").val(xcounselorid);
            $("#recid_hidden").val(xrecid);

            ajaxNew("changeDate",xdate, xcounselorid, xrecid, '');
        });


        $('.select_time').on('change', function(e) {
            var selected_time = $('.select_time').find(":selected").val();
            $("#timeline_hidden").val(selected_time);
        });

    function ajaxNew(xevent_action,xdate,xcounselorid,xrecid,xmeiformid){

        var act_status_hidden = $("#act_status_hidden").val();
        var timeline_hidden_val = $("#timeline_hidden").val();

        if(xevent_action == "submitAll" || xevent_action == "cancel_booking"){

            var date_hidden_val = $("#date_hidden").val();
            var counselor_hidden_val = $("#counselor_hidden").val();
            var recid_hidden_val = $("#recid_hidden").val();

            xdate = date_hidden_val;
            xcounselorid = counselor_hidden_val;
            xrecid = recid_hidden_val;
        }


        var serializedData = $("#myforms *").serialize()+"&event_action="+xevent_action+"&date="+xdate+"&counselorid="+xcounselorid+"&ext_recid="+xrecid+"&timeline="+timeline_hidden_val+"&meiformid_post="+xmeiformid;

        $.ajax({                                      
            url: 'booking_ajax.php',              
            type: "post",          
            data: serializedData,               
            success: function(xdata){
                $("#table_data").html(xdata["html"]);


                if(xevent_action == 'submitAll'){
                    $("#meiform_modal").modal("hide");
                }

                var xtimeline = xdata["time_fromto"];
                $("#timeline_hidden").val(xtimeline);

                $('.select_date').on('change', function(e) {
                    var selectedOption = $(this).find('option:selected');
                    var xdate = selectedOption.data('xdate');
                    var xcounselorid = selectedOption.data('xcounselorid');
                    var xrecid = selectedOption.data('xrecid');

                    var xvenue = selectedOption.data('xvenue');


                    $("#venue_hidden").val(xvenue);
                    $("#date_hidden").val(xdate);
                    $("#counselor_hidden").val(xcounselorid);
                    $("#recid_hidden").val(xrecid);

                    ajaxNew("changeDate",xdate, xcounselorid, xrecid,'');
                });



            },
            error: function (request, status, error) {
            }
        });
    }

    function book_func(){
        $("#proceed_modal").modal("show");
    }

    function proceed_func(){
        $("#proceed_modal").modal("hide");
        $("#meiform_modal").modal("show");
    }


    </script>



<?php 
require "includes/cc_footer.php";
?>

