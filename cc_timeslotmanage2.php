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

?>

    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <style>
        .ellipsis {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
    </style>
    <div class="container-fluid">
        <div class='row bg-white' style="height:99px">
            <div class="col-3 pe-0 d-flex align-items-center">
                <img src="images/350 x 88.png" style='height:76px;width:auto;'>
            </div>

            <div class="col-3 offset-6" style="display:flex;flex-direction:row;justify-content:center;font-family:inter;font-size:21px;align-items:center"> 
                <div style="flex:0.5;text-align:right;margin-right:10px">
                    <a href="http://localhost/couplesconnectprog/select_option.php" style='color:black;text-decoration:none' class='has_hover'>HOME</a>
                </div>

                <div style="flex:.1;text-align:center;padding-right:10px">
                    <a style='color:black;text-decoration:none'>|</a>
                </div>

                <div style="flex:.3;text-align:center;padding-right:15px">
                    <a style='color:black;text-decoration:none'><?php echo $header_name;?> </a>
                </div>

                <div style="flex:0.6;text-align:right;padding-right:35px">
                    <a href="http://localhost/couplesconnectprog/logout_cc.php"  class='has_hover' style='color:black;text-decoration:none'>LOGOUT</a>
                </div>

            </div> 
        </div>
    </div>

    <form name='myforms' id="myforms" method="post" target="_self" style='height:100%'> 
    <table style="width:100%;height:100%;background-color:#f2f2f2">
            <tr>
                <td style='width:30%'>
                    <div class="row h-100 justify-content-center align-items-center">
                        <div style='width:437px;height:700px;background-color:white;border-radius:30px;filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25))'>
                            <div class="m-3 pt-2 text-center login_form_header">
                                <p style="font-weight:bold;font-size:22px;font-family:inter;margin-bottom:0">Options</p>
                                <img src="images/Rectangle 11934.png" style='width:100%'>
                            </div>

                            <?php
                                require 'cc_mf_menu.php';
                            ?>

                         
                        </div>
                    </div>
                </td>

                <td style='width:70%'>
                    <div class="row h-100 justify-content-center align-items-center">
                        <div style='width:1025px;height:700px;background-color:white;border-radius:30px;filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25));display:flex;flex-direction:column'>
                            <div class="m-3 pt-2">
                                <p class='text-center' style="font-weight:bold;font-size:27px;font-family:inter;margin-bottom:0">Timeslot Management</p>
                                <img src="images/Rectangle 11934.png" style='width:100%;height:4px'>
                            </div>
    
                            <div class="container px-5" style='width:100%;flex-direction:column'>
                                <div class="row">

                                    <div class="row d-flex justify-content-center mb-3 " style='font-size:27px;font-family:inter;font-weight:800;color:#385399'>
                                        Schedule Info
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-4 px-5" style='font-size:22px;font-family:inter;font-weight:700'>
                                            Select Service
                                        </div>

                                        <div class="col-4 px-5" style='font-size:22px;font-family:inter;font-weight:700'>
                                            Venue
                                        </div>

                                        <div class="col-4 px-5" style='font-size:22px;font-family:inter;font-weight:700'>
                                            No. Of Participants
                                        </div>                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-4 px-5">
                                            <select name="select_type" id="select_type" class='form-control'>
                                                
                                                <?php

                                                    $selected_pmo = '';
                                                    $selected_pmc = '';

                                                    if(isset($_POST['select_type'])){
                                                        if($_POST['select_type'] == "PMO"){
                                                            $selected_pmo = 'selected';
                                                            $selected_pmc = '';
                                                        }else{
                                                            $selected_pmc = 'selected';
                                                            $selected_pmo = '';;
                                                        }
                                                    }
  
                                                    echo "<option value='PMO' ".$selected_pmo.">(PMO) Pre-Marriage Orientation</option>";
                                                    echo "<option value='PMC' ".$selected_pmc.">(PMC) Pre-Marriage Counseling</option>";
                                          
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-4 px-5">
                        

                                            <select name="venue" id="venue" class="form-control" onchange="handleVenueChange(event)">
                                                <?php
                                          
                                                    $select_db_venue = "SELECT * FROM mf_venue WHERE userid=? ORDER BY recid";
                                                    $stmt_venue	= $link->prepare($select_db_venue);
                                                    $stmt_venue->execute(array($_SESSION['usr_id']));                                                    
                                                    while($row_venue = $stmt_venue->fetch()){
                                                        $selected_venue = '';
                                                        if(isset($_POST['venue']) && $_POST['venue'] == $row_venue['venue_id']){
                                                            $selected_venue = 'selected';
                                                        }

                                                        echo "<option id='".$row_venue['venue_id']."' value='".$row_venue['venue_id']."' ".$selected_venue.">".$row_venue['venue']."</option>";
                                                    }

                                                ?>
                                                <option id='add-zoom-option' style='color:#ff6633;font-weight:bold'><span style='font-size:14px'>+</span>Add zoom</option>
                                            </select>
                                        </div>

                                        <?php
                                            $disabled_num = false;
                                            $xval_num = '';
                                            $xplaceholder = '';
                                            if(isset($_POST['select_type']) && isset($_POST['num_part']) ){

                                                if($_POST['select_type'] == "PMC"){
                                                    $xval_num = '';
                                                    $xplaceholder = '';  
                                                }else{
                                                    $xval_num = $_POST['num_part'];
                                                    $xplaceholder = '1-15';
                                                }
                                       
                                            }else{

                                                $xval_num = '';
                                                $xplaceholder = '1-15';
                                            }
                                        ?>

                                        <div class="col-4 px-5">
                                            <input type="number" min="1" max="15" class="form-control" id="num_part" name="num_part" placeholder="<?php echo $xplaceholder;?>"
                                            value="<?php if(isset($_POST['num_part'])){ echo $xval_num;}?>" oninput="validateNumber()">
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-4 px-5" style='font-size:22px;font-family:inter;font-weight:700'>
                                            Date:
                                        </div>

                                        <div class="col-3 px-5" style='font-size:22px;font-family:inter;font-weight:700'>
                                            Time From:
                                        </div>

                                        
                                        <div class="col-3 px-5" style='font-size:22px;font-family:inter;font-weight:700'>
                                            Time To:
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-4 px-5">
                                            <input type='text' name="date_select" id='date_select' class='form-control date_picker' class="form-control" autocomplete='off' value="<?php if(isset($_POST['date_select'])){ echo $_POST['date_select'];}?>">
                                        </div>

                                        <div class="col-3 px-5">
                                            <select name="sched_from" id="sched_from" class="form-control">

                                                <?php

                                                    $one_am2 = '';
                                                    $one_thirtyam2 = '';
                                                    $twoam2 = '';
                                                    $two_thirtyam2 = '';
                                                    $threeam2 = '';
                                                    $three_thirtyam2 = '';
                                                    $fouram2 = '';
                                                    $four_thirtyam2 = '';
                                                    $fiveam2 = '';
                                                    $five_thirtyam2 = '';
                                                    $sixam2 = '';
                                                    $six_thirtyam2 = '';
                                                    $sevenam2 = '';
                                                    $seven_thirtyam2 = '';
                                                    $eightam2 = '';
                                                    $eight_thirtyam2 = '';
                                                    $nineam2 = '';
                                                    $nine_thirtyam2 = '';
                                                    $tenam2 = '';
                                                    $ten_thirtyam2 = '';
                                                    $elevenam2= '';
                                                    $eleven_thirtyam2= '';
                                                    $twelvepm2= '';
                                                    $twelve_thirtypm2= '';

                                                    $onepm2= '';
                                                    $one_thirtypm2= '';
                                                    $twopm2= '';
                                                    $two_thirtypm2= '';
                                                    $threepm2= '';
                                                    $three_thirtypm2= '';
                                                    $fourpm2= '';
                                                    $four_thirtypm2= '';
                                                    $fivepm2= '';
                                                    $five_thirtypm2= '';
                                                    $sixpm2= '';
                                                    $six_thirtypm2= '';
                                                    $sevenpm2= '';
                                                    $seven_thirtypm2= '';
                                                    $eightpm2= '';
                                                    $eight_thirtypm2= '';
                                                    $ninepm2= '';
                                                    $nine_thirtypm2= '';
                                                    $tenpm2= '';
                                                    $ten_thirtypm2= '';
                                                    $elevenpm2= '';
                                                    $eleven_thirtypm2= '';
                                                    $twelveam2= '';
                                                    $twelve_thirtyam2= '';
                                                    $one_am2 = '';

                                                if(isset($_POST['sched_from'])){

                                                    $one_am2 = '';
                                                    $one_thirtyam2 = '';
                                                    $twoam2 = '';
                                                    $two_thirtyam2 = '';
                                                    $threeam2 = '';
                                                    $three_thirtyam2 = '';
                                                    $fouram2 = '';
                                                    $four_thirtyam2 = '';
                                                    $fiveam2 = '';
                                                    $five_thirtyam2 = '';
                                                    $sixam2 = '';
                                                    $six_thirtyam2 = '';
                                                    $sevenam2 = '';
                                                    $seven_thirtyam2 = '';
                                                    $eightam2 = '';
                                                    $eight_thirtyam2 = '';
                                                    $nineam2 = '';
                                                    $nine_thirtyam2 = '';
                                                    $tenam2 = '';
                                                    $ten_thirtyam2 = '';
                                                    $elevenam2= '';
                                                    $eleven_thirtyam2= '';
                                                    $twelvepm2= '';
                                                    $twelve_thirtypm2= '';
    
                                                    $onepm2= '';
                                                    $one_thirtypm2= '';
                                                    $twopm2= '';
                                                    $two_thirtypm2= '';
                                                    $threepm2= '';
                                                    $three_thirtypm2= '';
                                                    $fourpm2= '';
                                                    $four_thirtypm2= '';
                                                    $fivepm2= '';
                                                    $five_thirtypm2= '';
                                                    $sixpm2= '';
                                                    $six_thirtypm2= '';
                                                    $sevenpm2= '';
                                                    $seven_thirtypm2= '';
                                                    $eightpm2= '';
                                                    $eight_thirtypm2= '';
                                                    $ninepm2= '';
                                                    $nine_thirtypm2= '';
                                                    $tenpm2= '';
                                                    $ten_thirtypm2= '';
                                                    $elevenpm2= '';
                                                    $eleven_thirtypm2= '';
                                                    $twelveam2= '';
                                                    $twelve_thirtyam2= '';
                                                    $one_am2 = '';

                                                    if($_POST['sched_from'] == "1:00AM"){
                                                        $one_am2 = "selected";
                                                    }else if($_POST['sched_from'] == "1:30AM"){
                                                        $one_thirtyam2 = "selected";
                                                    }else if($_POST['sched_from'] == "2:00AM"){
                                                        $twoam2 = "selected";
                                                    }else if($_POST['sched_from'] == "2:30AM"){
                                                        $two_thirtyam2 = "selected";
                                                    }else if($_POST['sched_from'] == "3:00AM"){
                                                        $threeam2 = "selected";
                                                    }else if($_POST['sched_from'] == "3:30AM"){
                                                        $three_thirtyam2 = "selected";
                                                    }else if($_POST['sched_from'] == "4:00AM"){
                                                        $fouram2 = "selected";
                                                    }else if($_POST['sched_from'] == "4:30AM"){
                                                        $four_thirtyam2 = "selected";
                                                    }else if($_POST['sched_from'] == "5:00AM"){
                                                        $fiveam2 = "selected";
                                                    }else if($_POST['sched_from'] == "5:30AM"){
                                                        $five_thirtyam2 = "selected";
                                                    }else if($_POST['sched_from'] == "6:00AM"){
                                                        $sixam2 = "selected";
                                                    }else if($_POST['sched_from'] == "6:30AM"){
                                                        $six_thirtyam2 = "selected";
                                                    }else if($_POST['sched_from'] == "7:00AM"){
                                                        $sevenam2 = "selected";
                                                    }else if($_POST['sched_from'] == "7:30AM"){
                                                        $seven_thirtyam2 = "selected";
                                                    }else if($_POST['sched_from'] == "8:00AM"){
                                                        $eightam2 = "selected";
                                                    }else if($_POST['sched_from'] == "8:30AM"){
                                                        $eight_thirtyam2 = "selected";
                                                    }else if($_POST['sched_from'] == "9:00AM"){
                                                        $nineam2 = "selected";
                                                    }else if($_POST['sched_from'] == "9:30AM"){
                                                        $nine_thirtyam2 = "selected";
                                                    }else if($_POST['sched_from'] == "10:00AM"){
                                                        $tenam2 = "selected";
                                                    }else if($_POST['sched_from'] == "10:30AM"){
                                                        $ten_thirtyam2 = "selected";
                                                    }else if($_POST['sched_from'] == "11:00AM"){
                                                        $elevenam2 = "selected";
                                                    }else if($_POST['sched_from'] == "11:30AM"){
                                                        $eleven_thirtyam2 = "selected";
                                                    }else if($_POST['sched_from'] == "12:00PM"){
                                                        $twelvepm2 = "selected";
                                                    }else if($_POST['sched_from'] == "12:30PM"){
                                                        $twelve_thirtypm2 = "selected";
                                                    }else if($_POST['sched_from'] == "1:00PM"){
                                                        $onepm2 = "selected";
                                                    }else if($_POST['sched_from'] == "1:30PM"){
                                                        $one_thirtypm2 = "selected";
                                                    }else if($_POST['sched_from'] == "2:00PM"){
                                                        $twopm2 = "selected";
                                                    }else if($_POST['sched_from'] == "2:30PM"){
                                                        $two_thirtypm2 = "selected";
                                                    }else if($_POST['sched_from'] == "3:00PM"){
                                                        $threepm2 = "selected";
                                                    }else if($_POST['sched_from'] == "3:30PM"){
                                                        $three_thirtypm2 = "selected";
                                                    }else if($_POST['sched_from'] == "4:00PM"){
                                                        $fourpm2 = "selected";
                                                    }else if($_POST['sched_from'] == "4:30PM"){
                                                        $four_thirtypm2 = "selected";
                                                    }else if($_POST['sched_from'] == "5:00PM"){
                                                        $fivepm2 = "selected";
                                                    }else if($_POST['sched_from'] == "6:00PM"){
                                                        $sixpm2 = "selected";
                                                    }else if($_POST['sched_from'] == "6:30PM"){
                                                        $six_thirtypm2 = "selected";
                                                    }else if($_POST['sched_from'] == "7:00PM"){
                                                        $sevenpm2 = "selected";
                                                    }else if($_POST['sched_from'] == "7:30PM"){
                                                        $seven_thirtypm2 = "selected";
                                                    }else if($_POST['sched_from'] == "8:00PM"){
                                                        $eightpm2 = "selected";
                                                    }else if($_POST['sched_from'] == "8:30PM"){
                                                        $eight_thirtypm2 = "selected";
                                                    }else if($_POST['sched_from'] == "9:00PM"){
                                                        $ninepm2 = "selected";
                                                    }else if($_POST['sched_from'] == "9:30PM"){
                                                        $nine_thirtypm2 = "selected";
                                                    }else if($_POST['sched_from'] == "10:00PM"){
                                                        $tenpm2 = "selected";
                                                    }else if($_POST['sched_from'] == "10:30PM"){
                                                        $ten_thirtypm2 = "selected";
                                                    }else if($_POST['sched_from'] == "11:00PM"){
                                                        $elevenpm2 = "selected";
                                                    }else if($_POST['sched_from'] == "11:30PM"){
                                                        $eleven_thirtypm2 = "selected";
                                                    }else if($_POST['sched_from'] == "12:00AM"){
                                                        $twelveam2 = "selected";
                                                    }else if($_POST['sched_from'] == "12:30AM"){
                                                        $twelve_thirtyam2 = "selected";
                                                    }else if($_POST['sched_from'] == "1:00AM"){
                                                        $one_am2 = "selected";
                                                    }
                                                }


                                                echo"<option ".$one_am2.">1:00AM</option>";
                                                echo"<option ".$one_thirtyam2.">1:30AM</option>";
                                                echo"<option ".$twoam2.">2:00AM</option>";
                                                echo"<option ".$two_thirtyam2.">2:30AM</option>";
                                                echo"<option ".$threeam2.">3:00AM</option>";
                                                echo"<option ".$three_thirtyam2.">3:30AM</option>";
                                                echo"<option ".$fouram2.">4:00AM</option>";
                                                echo"<option ".$four_thirtyam2.">4:30AM</option>";
                                                echo"<option ".$fiveam2.">5:00AM</option>";
                                                echo"<option ".$five_thirtyam2.">5:30AM</option>";
                                                echo"<option ".$sixam2.">6:00AM</option>";
                                                echo"<option ".$six_thirtyam2.">6:30AM</option>";
                                                echo"<option ".$sevenam2.">7:00AM</option>";
                                                echo"<option ".$seven_thirtyam2.">7:30AM</option>";
                                                echo"<option ".$eightam2.">8:00AM</option>";
                                                echo"<option ".$eight_thirtyam2.">8:30AM</option>";
                                                echo"<option ".$nineam2.">9:00AM</option>";
                                                echo"<option ".$nine_thirtyam2.">9:30AM</option>";
                                                echo"<option ".$tenam2.">10:00AM</option>";
                                                echo"<option ".$ten_thirtyam2.">10:30AM</option>";
                                                echo"<option ".$elevenam2.">11:00AM</option>";
                                                echo"<option ".$eleven_thirtyam2.">11:30AM</option>";
                                                echo"<option ".$twelvepm2.">12:00PM</option>";
                                                echo"<option ".$twelve_thirtypm2.">12:30PM</option>";
                                                echo"<option ".$onepm2.">1:00PM</option>";
                                                echo"<option ".$one_thirtypm2.">1:30PM</option>";
                                                echo"<option ".$twopm2.">2:00PM</option>";
                                                echo"<option ".$two_thirtypm2.">2:30PM</option>";
                                                echo"<option ".$threepm2.">3:00PM</option>";
                                                echo"<option ".$three_thirtypm2.">3:30PM</option>";
                                                echo"<option ".$fourpm2.">4:00PM</option>";
                                                echo"<option ".$four_thirtypm2.">4:30PM</option>";
                                                echo"<option ".$fivepm2.">5:00PM</option>";
                                                echo"<option ".$five_thirtypm2.">5:30PM</option>";
                                                echo"<option ".$sixpm2.">6:00PM</option>";
                                                echo"<option ".$six_thirtypm2.">6:30PM</option>";
                                                echo"<option ".$sevenpm2.">7:00PM</option>";
                                                echo"<option ".$seven_thirtypm2.">7:30PM</option>";
                                                echo"<option ".$eightpm2.">8:00PM</option>";
                                                echo"<option ".$eight_thirtypm2.">8:30PM</option>";
                                                echo"<option ".$ninepm2.">9:00PM</option>";
                                                echo"<option ".$nine_thirtypm2.">9:30PM</option>";
                                                echo"<option ".$tenpm2.">10:00PM</option>";
                                                echo"<option ".$ten_thirtypm2.">10:30PM</option>";
                                                echo"<option ".$elevenpm2.">11:00PM</option>";
                                                echo"<option ".$eleven_thirtypm2.">11:30PM</option>";
                                                echo"<option ".$twelveam2.">12:00AM</option>";

                                                ?>                                                

                                            </select>
                                        </div>

                                        <div class="col-3 px-5">
                                            <input name="sched_to" id="sched_to" class="form-control" type='text 'readonly value="<?php if(isset($_POST['sched_to'])){ echo $_POST['sched_to'];}?>">
                                        </div>

                                        <div class="col-2">
                                            <button type="button" onclick="schedule_func('add_sched')" class="btn" style="background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:178px;height:37px;font-size:18px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Add Schedule</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center mt-4" style='font-size:22px;font-family:inter;font-weight:800;color:#385399'>
                                Schedule Table
                            </div>

                            <div class="container" id="div_table" style='padding-top:20px;max-height:800px'>
                                <table style='width:100%;height:100%'>

                                <tr style='font-size:21px;font-family:inter;font-weight:700;color:#797979'>
                                    <td style='width:80px'>
                                        Service
                                    </td>

                                    <td style='width:140px'>
                                        Venue
                                    </td>

                                    <td style='width:60px'>
                                        Participants
                                    </td>

                                    <td style='width:110px'>
                                        Date
                                    </td>

                                    <td style='width:110px'>
                                        Time From:
                                    </td>

                                    <td style='width:110px'>
                                        Time To:
                                    </td>

                                    <td style='width:110px' class='text-center'>
                                        Action
                                    </td>
                                </tr>

                                    <?php

                                        $select_db_email="SELECT * FROM mf_prog_users WHERE userid=? LIMIT 1";
                                        $stmt_email	= $link->prepare($select_db_email);
                                        $stmt_email->execute(array($_SESSION['usr_id']));
                                        $rs_email = $stmt_email->fetch();

                                        $select_db_ac="SELECT mf_venue.is_online as 'is_online', mf_venue.venue_link as 'venue_link',ext_appointment_info.clinic_date as 'clinic_date', ext_appointment_info.time_from as 'time_from',
                                        ext_appointment_info.time_to as 'time_to', ext_appointment_info.appointment_info_id as 'app_id',mf_venue.venue as 'venue',
                                        ext_appointment_info.slots_avail as 'slots_avail', mf_appointment_info.sched_type as 'sched_type', ext_appointment_info.recid as 'ext_recid'
                                        FROM ext_appointment_info LEFT JOIN mf_appointment_info ON
                                        ext_appointment_info.appointment_info_id = mf_appointment_info.appointment_info_id LEFT JOIN mf_venue ON ext_appointment_info.venue_id = mf_venue.venue_id WHERE ext_appointment_info.counseloremail = '".$rs_email['email']."'";
                                        $stmt	= $link->prepare($select_db_ac);
                                        $stmt->execute();
                                        while($rs_ac = $stmt->fetch()){

                                            $service = $rs_ac['sched_type'];

                                            // if($rs_ac['sched_type'] == "PMO"){
                                            //     $service = "Pre-Marriage Orientation";
                                            // }else{
                                            //     $service = "Pre-Marriage Counseling";
                                            // }
                                            
                                            echo "<tr style='font-size:20px;font-family:inter;font-weight:500;color:black'>";
                                                    echo "<td class='pt-1' style='width:80px'>";
                                                        echo "".$service."";
                                                    echo "</td>";

                                                    echo "<td class='pt-1' style='width:140px;max-width:135px'>";
                                                        if($rs_ac['is_online'] == 'Y'){
                                                            echo "<div class='ellipsis' style='max-width:135px'>
                                                            <a target='_blank' href='".$rs_ac['venue_link']."' style='color:blue!important;text-decoration:underline!important'>
                                                            ".$rs_ac['venue']."
                                                            </a>
                                                            </div>";
                                                        }else{
                                                            echo "<div class='ellipsis' style='max-width:135px'>".$rs_ac['venue']."</div>";
                                                        }
                                                        
                                                    echo "</td>";

                                                    echo "<td class='pt-1' style='width:60px'>";
                                                        echo "".$rs_ac['slots_avail']."";
                                                    echo "</td>";

                                                    // Create a DateTime object from the input date
                                                    $dateObject = new DateTime($rs_ac['clinic_date']);

                                                    // Format the date into mm/dd/yyyy format
                                                    $formattedDate = $dateObject->format('m/d/Y');

                                                    echo "<td class='pt-1' style='width:110px;font-size:19px'>";
                                                        echo "".$formattedDate."";
                                                    echo "</td>";

                                                    echo "<td class='pt-1' style='width:110px'>";
                                                        echo "".$rs_ac['time_from']."";
                                                    echo "</td>";

                                                    echo "<td class='pt-1' style='width:110px'>";
                                                        echo "".$rs_ac['time_to']."";
                                                    echo "</td>";                                                    
                                       
                                                    echo "<td class='pt-1 d-flex justify-content-center'>";
                                                        echo "<div class='dropdown'>";
                                                            echo "<button class='dropdown-toggle' data-bs-toggle='dropdown' type='button' style='border:none;background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:120px;padding-top:5px;padding-bottom:5px;height:auto;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>";
                                                                echo "Review";
                                                            echo "</button>";

                                                            echo"<ul class='dropdown-menu'>";
                                                                echo"<li onclick=\"schedule_func('get_sched',".$rs_ac['ext_recid'].")\"><a class='dropdown-item dd_action' style='color:#4d4dff!important;font-weight:bold;'><i class='fas fa-pencil-alt'></i><span style='margin-left:7px;font-size:17px;font-family:arial'>Edit</span></a></li>";
                                                                echo"<li onclick=\"schedule_func('delete_sched',".$rs_ac['ext_recid'].")\"><a class='dropdown-item dd_action' style='color:#cc0000!important;font-weight:bold;'><i class='fas fa-trash-alt'></i><span style='margin-left:7px;font-size:17px;font-family:arial'>Delete</span></a></li>";
                                                            echo"</ul>";
                                                        echo "</div>";
                                                    echo "</td>";
                                            echo "</tr>";

                                        }

                                    ?>

                                </table>
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

        <div class="modal fade xedit_modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Schedule:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="col-12 p-2" style='font-family:inter;font-size:25px'>
                            <label for="">Service</label>
                            <select name="modal_service" id="modal_service" class='form-control'>
                                <option value="PMO">(PMO) Pre-Marriage Orientation</option>
                                <option value="PMC">(PMC) Pre-Marriage Counselling</option>
                            </select>
                        </div>

                        <div class="col-12 p-2"  style='font-family:inter;font-size:25px'>
                            <label for="">Venue</label>
                            <select name="modal_venue" id="modal_venue" class='form-control'>
                                <?php
                                    
                                    $select_db_venue2 = "SELECT * FROM mf_venue WHERE userid=? ORDER BY recid";
                                    $stmt_venue2	= $link->prepare($select_db_venue2);
                                    $stmt_venue2->execute(array($_SESSION['usr_id']));                                                    
                                    while($row_venue2 = $stmt_venue2->fetch()){
                                        $selected_venue2 = '';
                                        if(isset($_POST['modal_venue']) && $_POST['modal_venue'] == $row_venue2['venue_id']){
                                            $selected_venue2 = 'selected';
                                        }

                                        echo "<option value='".$row_venue2['venue_id']."' ".$selected_venue.">".$row_venue2['venue']."</option>";
                                    }
                        

                                ?>
                            </select>
                        </div>

                        <div class="col-12 p-2"  style='font-family:inter;font-size:25px'>
                            <label for="">Participants</label>
                            <input type="number" class='form-control' name='modal_participants' id="modal_participants"  min="1" max="15" oninput="validateNumber()">
                        </div>

                        <div class="col-12 p-2"  style='font-family:inter;font-size:25px'>
                            <label for="">Date</label>
                            <input type="text" class="form-control date_picker" name="modal_clinicdate" id="modal_clinicdate">
                        </div>

                        <div class="col-12 p-2"  style='font-family:inter;font-size:25px'>
                            <label for="">Time From:</label>
                            <select class='form-control' name="modal_schedfrom" id="modal_schedfrom">
                                    <option>1:00AM</option>
                                    <option>1:30AM</option>
                                    <option>2:00AM</option>
                                    <option>2:30AM</option>
                                    <option>3:00AM</option>
                                    <option>3:30AM</option>
                                    <option>4:00AM</option>
                                    <option>4:30AM</option>
                                    <option>5:00AM</option>
                                    <option>5:30AM</option>
                                    <option>6:00AM</option>
                                    <option>6:30AM</option>
                                    <option>7:00AM</option>
                                    <option>7:30AM</option>
                                    <option>8:00AM</option>
                                    <option>8:30AM</option>
                                    <option>9:00AM</option>
                                    <option>9:30AM</option>
                                    <option>10:00AM</option>
                                    <option>10:30AM</option>
                                    <option>11:00AM</option>
                                    <option>11:30AM</option>
                                    <option>12:00PM</option>
                                    <option>12:30PM</option>
                                    <option>1:00PM</option>
                                    <option>1:30PM</option>
                                    <option>2:00PM</option>
                                    <option>2:30PM</option>
                                    <option>3:00PM</option>
                                    <option>3:30PM</option>
                                    <option>4:00PM</option>
                                    <option>4:30PM</option>
                                    <option>5:00PM</option>
                                    <option>5:30PM</option>
                                    <option>6:00PM</option>
                                    <option>6:30PM</option>
                                    <option>7:00PM</option>
                                    <option>7:30PM</option>
                                    <option>8:00PM</option>
                                    <option>8:30PM</option>
                                    <option>9:00PM</option>
                                    <option>9:30PM</option>
                                    <option>10:00PM</option>
                                    <option>10:30PM</option>
                                    <option>11:00PM</option>
                                    <option>11:30PM</option>
                                    <option>12:00AM</option>
                                    <option>12:30AM</option>
                            </select>
                        </div>

                        <div class="col-12 p-2"  style='font-family:inter;font-size:25px'>
                            <label for="">Time To:</label>
                            <select class='form-control' name="modal_schedto" id="modal_schedto">
                                    <option>1:00AM</option>
                                    <option>1:30AM</option>
                                    <option>2:00AM</option>
                                    <option>2:30AM</option>
                                    <option>3:00AM</option>
                                    <option>3:30AM</option>
                                    <option>4:00AM</option>
                                    <option>4:30AM</option>
                                    <option>5:00AM</option>
                                    <option>5:30AM</option>
                                    <option>6:00AM</option>
                                    <option>6:30AM</option>
                                    <option>7:00AM</option>
                                    <option>7:30AM</option>
                                    <option>8:00AM</option>
                                    <option>8:30AM</option>
                                    <option>9:00AM</option>
                                    <option>9:30AM</option>
                                    <option>10:00AM</option>
                                    <option>10:30AM</option>
                                    <option>11:00AM</option>
                                    <option>11:30AM</option>
                                    <option>12:00PM</option>
                                    <option>12:30PM</option>
                                    <option>1:00PM</option>
                                    <option>1:30PM</option>
                                    <option>2:00PM</option>
                                    <option>2:30PM</option>
                                    <option>3:00PM</option>
                                    <option>3:30PM</option>
                                    <option>4:00PM</option>
                                    <option>4:30PM</option>
                                    <option>5:00PM</option>
                                    <option>5:30PM</option>
                                    <option>6:00PM</option>
                                    <option>6:30PM</option>
                                    <option>7:00PM</option>
                                    <option>7:30PM</option>
                                    <option>8:00PM</option>
                                    <option>8:30PM</option>
                                    <option>9:00PM</option>
                                    <option>9:30PM</option>
                                    <option>10:00PM</option>
                                    <option>10:30PM</option>
                                    <option>11:00PM</option>
                                    <option>11:30PM</option>
                                    <option>12:00AM</option>
                                    <option>12:30AM</option>
                            </select>
                        </div>          
                        
                        <div class="p-2 xerror_alert">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <span class='innerhtml_btn'><button type="button" class="btn btn-primary">Save</button></span>
                </div>
                </div>
            </div>
        </div>
        
        <div class="modal zoom_modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Enter Zoom Link:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        Link Title:
                        <input type="text" class="form-control" name="zoomLinkTitle" id="zoomLinkTitle" placeholder="eg: Mark's Online Meeting" autocomplete="off">

                    </div>

                    <div class='mt-3'>
                        Zoom Link
                        <input type="text" class="form-control" name="zoomLinkInput" id="zoomLinkInput" placeholder="eg: https://www.zoom.com?userid=69" autocomplete="off">
                    </div>
                    

                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button onclick="add_zoom_link()" type="button" class="btn btn-primary fw-bold">Add Zoom Link</button>
                </div>

                </div>
            </div>
        </div>

        <!-- <footer style='height:100px;background-color:#23408E' class='footer'>
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
        </footer> -->
        
    </form>

    <script>

        function validateNumber() {
            const input = document.getElementById('num_part');
            const value = input.value;

            // Remove any non-numeric characters
            input.value = value.replace(/[^0-9]/g, '');

            // Ensure the number is within the range 0-15
            if (input.value < 0) {
                input.value = 0;
            }
            if (input.value > 15) {
                input.value = 15;
            }
        }


        $("#sched_from").on("change", function(event) { 
            var select_type_val = $('#select_type').find(":selected").val();

            if(select_type_val == "PMO"){
                var hours_add = 4
            }else{
                var hours_add = 1
            }

            var xtime_input = $(this).val();
            let time_result = addHoursToTime(xtime_input, hours_add);
            $("#sched_to").val(time_result)
        });

        $("#select_type").on("change", function(event) { 
            var select_type_val = $('#select_type').find(":selected").val();

            if(select_type_val == "PMO"){
                var hours_add = 4
            }else{
                var hours_add = 1
            }

            var xtime_input = $("#sched_from").val();
            let time_result = addHoursToTime(xtime_input, hours_add);
            $("#sched_to").val(time_result)
        });


        function addHoursToTime(timeString, hoursToAdd) {
            // Parse the input time string
            let [time, modifier] = timeString.split(/(AM|PM)/);
            let [hours, minutes] = time.split(':').map(Number);
            
            // Convert to 24-hour format
            if (modifier === 'PM' && hours !== 12) {
                hours += 12;
            }
            if (modifier === 'AM' && hours === 12) {
                hours = 0;
            }

            // Create a new Date object with today's date and the parsed time
            let date = new Date();
            date.setHours(hours, minutes);

            // Add the specified number of hours
            date.setHours(date.getHours() + hoursToAdd);

            // Format the new time string
            let newHours = date.getHours();
            let newMinutes = date.getMinutes();
            let newModifier = newHours >= 12 ? 'PM' : 'AM';

            newHours = newHours % 12;
            newHours = newHours ? newHours : 12; // handle case for 12:00 AM/PM
            newMinutes = newMinutes < 10 ? '0' + newMinutes : newMinutes;

            return `${newHours}:${newMinutes}${newModifier}`;
        }



        function handleVenueChange(event) {
            const selectedOption = event.target.options[event.target.selectedIndex];
            if (selectedOption.id === 'add-zoom-option') {
                openZoomModal();
                // Reset the select element to prevent auto-selecting the "Add zoom" option
                event.target.selectedIndex = 0;
            }
        }

        function openZoomModal() {
            
            $(".zoom_modal").modal('show');
        }


    $(document).ready(function() {
        var maxHeight = 200; // Maximum height in pixels after which overflow-y:auto will be applied

        // Check the height of the div
        if ($('#div_table').height() > maxHeight) {
            $('#div_table').css('overflow-y', 'auto');
        }
    });

    // $('').click(function(e){
    //     var abra = $(e.target).val();
    //     alert(abra);
    // });

    $('#select_type').on('change', function() {
    
        var dd_val = this.value;

        if(dd_val == "PMC"){
            $("#num_part").prop('disabled', true);
            $("#num_part").attr('Placeholder', '');
            $("#num_part").val('');
        }else{
            $("#num_part").prop('disabled', false);
            $("#num_part").attr('Placeholder', '1-15');
        }
    })



    $('#modal_service').on('change', function() {
    
        var dd_val = this.value;

        if(dd_val == "PMC"){
            $("#modal_participants").prop('disabled', true);
            $("#modal_participants").attr('Placeholder', '');
            $("#modal_participants").val('');
        }else{
            $("#modal_participants").prop('disabled', false);
            $("#modal_participants").attr('Placeholder', '1-15');
        }
    })

    function schedule_func(xevent,xrecid){

        if(xrecid !== undefined){
            new_xrecid = xrecid;
        }else{
            new_xrecid = "";
        }

        var xdata = $("#myforms *").serialize()+"&event_action="+xevent+"&xrecid="+new_xrecid;

        jQuery.ajax({    
            data:xdata,
            dataType:"json",
            type:"post",
            url:"cc_timeslotmanage2_ajax.php", 
            success: function(xdata){

                if(xevent == 'add_sched'){

                    if(xdata['status'] == false){
                        $('.error_msg').html(xdata['msg']);
                        $(".xerror_modal").modal("show");
                    }else{

                        document.forms.myforms.method = "post";
                        document.forms.myforms.target = "_self";
                        document.forms.myforms.action = "cc_timeslotmanage2.php";
                        document.forms.myforms.submit();                          
                    }
    
                }else if(xevent == 'get_sched'){

                    var sched_type = xdata['retEdit']['sched_type'];
                    var clinic_date = xdata['retEdit']['clinic_date'];
                    var time_from = xdata['retEdit']['time_from'];
                    var time_to = xdata['retEdit']['time_to'];
                    var ext_recid = xdata['retEdit']['recid'];

                    if(sched_type ==  "PMC"){
                        $("#modal_participants").prop('disabled', true);
                    }

                    $("#modal_clinicdate").val(clinic_date)

                    // alert(sched_type)

                    //$("#modal_weekday option[value='"+week_day+"']").prop('selected', true);
                    $("#modal_service option[value='"+sched_type+"']").prop('selected', true);

                    // $("#modal_schedfrom option[value='" + time_from + "']").attr('selected', 'selected');
                    // $("#modal_schedto option[value='" + time_to + "']").attr('selected', 'selected');

                    $("#modal_schedfrom option").filter(function() {
                    return $(this).val() === time_from;
                    }).attr('selected', 'selected');

                    $("#modal_schedto option").filter(function() {
                    return $(this).val() === time_to;
                    }).attr('selected', 'selected');

                    $("#modal_venue option").filter(function() {
                    return $(this).val() === xdata['retEdit']['venue_id'];
                    }).attr('selected', 'selected');

                    // $('#modal_schedto option:contains(\"'xdata['retEdit']['time_to']'\"');
                    $("#modal_participants").val(xdata['retEdit']['slots_avail']);

                    $(".innerhtml_btn").html("<button type='button' class='btn btn-primary' onclick='schedule_func(\"setEdit\",\""+ext_recid+"\")'>Save</button>");

                    $(".xedit_modal").modal("show");
                }else if(xevent == 'setEdit'){
                    if(xdata['status'] == false){

                        var xerror_msg = xdata['msg'];

                        $(".xerror_alert").html(`
                            <div class='alert alert-danger' role="alert">
                                ${xerror_msg}
                            </div>
                        `);
                    }else{
                        $(".xedit_modal").modal("hide");
                        document.forms.myforms.method = "post";
                        document.forms.myforms.target = "_self";
                        document.forms.myforms.action = "cc_timeslotmanage2.php";
                        document.forms.myforms.submit();  
                    }
                }else if(xevent == 'delete_sched'){
                    document.forms.myforms.method = "post";
                    document.forms.myforms.target = "_self";
                    document.forms.myforms.action = "cc_timeslotmanage2.php";
                    document.forms.myforms.submit();  
                }

            },
            error: function (request, status, error) {
            }
            
        })
    }

    function add_zoom_link(){

        var zoom_link = $("#zoomLinkInput").val();
        var zoom_link_title = $("#zoomLinkTitle").val();

        xdata="event_action=add_zoom_link&zoom_link="+zoom_link+"&zoom_link_title="+zoom_link_title;

        jQuery.ajax({    
            data:xdata,
            dataType:"json",
            type:"post",
            url:"cc_timeslotmanage2_ajax.php", 
            success: function(xdata){

                if(xdata['status'] == true){
                    document.forms.myforms.method = "post";
                    document.forms.myforms.target = "_self";
                    document.forms.myforms.action = "cc_timeslotmanage2.php";
                    document.forms.myforms.submit();   
                }else{
                    alert(xdata['msg'])
                }
                
            },
            error: function (request, status, error) {
            }
            
        })         
    }

    

    </script>

<?php 
require "includes/cc_footer.php";
?>

