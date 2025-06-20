<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('resources/db_init.php');
require_once('resources/lx2.pdodb.php');
require_once("resources/stdfunc100.php");
require_once('resources/connect4.php');

session_start();

$ret=array();
$ret['msg']='';
$ret['user']='';
$ret['userlvl']='';
$ret['recid']='';
$ret['status']=true;
$ret['html']='';
$ret['html2']='';
$ret['time_fromto']='';
$ret['first_time'] = '';
$ret["retEdit"] = array();


$select_db="SELECT * FROM mf_prog_users WHERE recid=?";
$stmt	= $link->prepare($select_db);
$stmt->execute(array($_SESSION['usr_recid']));
$row = $stmt->fetch();
$act_status = $row["act_status"];
$act_status2 = $act_status;

if($act_status == "APR"){
    $act_status2 = "PMO";
}



if($_POST['event_action'] == "first_load" || $_POST['event_action'] == "changeDate" ||  $_POST['event_action'] == "cancel_booking"){


    if(isset($_POST['event_action']) &&  $_POST['event_action'] == "cancel_booking"){

        $select_db_select = "SELECT * FROM pro_meiform WHERE usermeiformid='".$_POST['meiformid_post']."' LIMIT 1";
        $stmt_select	= $link->prepare($select_db_select);
        $stmt_select->execute();
        $row_select = $stmt_select->fetch();

        $act_remove = "";
        if($act_status2 == "PMO"){
            $act_remove = "APR";
        }else if($act_status2 == "PMC"){
            $act_remove = "PMC";
        }

        $pro_users4 = array();
        $pro_users4["act_status"] = $act_remove;
        PDO_UpdateRecord($link,"mf_prog_users",$pro_users4,"userid = ?",array($_SESSION['usr_id']),false);  


        $xqry_del = "DELETE FROM pro_meiform WHERE usermeiformid='".$_POST['meiformid_post']."'";
        $xstmt_del = $link->prepare($xqry_del);
        $xstmt_del->execute();

        $xqry_del2 = "DELETE FROM ext_mf_meiform WHERE usermeiformid='".$_POST['meiformid_post']."'";
        $xstmt_del2 = $link->prepare($xqry_del2);
        $xstmt_del2->execute();

    }

                         
    if($act_status == "PMC"){
        $xheader_top = "Pre-Marriage Counseling Schedules";
    }else if($act_status == "PMO" || $act_status == "APR"){
        $xheader_top = "Pre-Marriage Orientation Schedules";
    }

    $ret['html'].= "<tr>";
        $ret['html'].= "<td colspan='5' style='height:100px'>";
            $ret['html'].= "<div class='container d-flex text-center align-items-center' style='font-family:inter;font-weight:700;font-size:27px;flex-direction:column'>";    
                $ret['html'].= $xheader_top;    
                $ret['html'].= "<img src='images/Rectangle 11934.png' style='width:784px; height:6px;margin-top:10px'>";    
            $ret['html'].= "</div>";    
        $ret['html'].= "</td>";    
    $ret['html'].= "</tr>";

    $ret['html'].= "<tr>";
        $ret['html'].= "<td style='padding-top:15px;padding-left:20px'>";
            $ret['html'].= "<div class='container text-left' style='font-family:inter;font-weight:700;font-size:25px;color:#797979'>";    
                $ret['html'].= "Venue";    
            $ret['html'].= "</div>";    
        $ret['html'].= "</td>";

        $ret['html'].= "<td>";
            $ret['html'].= "<div class='container text-left' style='font-family:inter;font-weight:700;font-size:25px;color:#797979''>";    
                $ret['html'].= "Date";    
            $ret['html'].= "</div>";    
        $ret['html'].= "</td>";

        $ret['html'].= "<td>";
            $ret['html'].= "<div class='container text-left' style='font-family:inter;font-weight:700;font-size:25px;color:#797979''>";    
                $ret['html'].= "Time";    
            $ret['html'].= "</div>";    
        $ret['html'].= "</td>";

        if($act_status == "PMO" || $act_status == "APR"){
            $ret['html'].= "<td>";
                $ret['html'].= "<div class='container text-center' style='font-family:inter;font-weight:700;font-size:25px;color:#797979''>";    
                    $ret['html'].= "Slots Available";    
                $ret['html'].= "</div>";    
            $ret['html'].= "</td>"; 
        }

       
        $ret['html'].= "<td>";
                $ret['html'].= "&nbsp;";    
        $ret['html'].= "</td>";           
    $ret['html'].= "</tr>";

    $select_db_xid = "SELECT ext_appointment_info.clinic_date as 'clinic_date', mf_venue.venue as 'venue', mf_venue.venue_id as 'venue_id', mf_appointment_info.userid as 'userid',ext_appointment_info.slots_avail as 'slots_avail',
    ext_appointment_info.recid as 'ext_recid' FROM ext_appointment_info LEFT JOIN mf_appointment_info ON 
    ext_appointment_info.appointment_info_id   = mf_appointment_info.appointment_info_id LEFT JOIN mf_venue ON ext_appointment_info.venue_id = mf_venue.venue_id WHERE mf_appointment_info.sched_type='".$act_status2."' GROUP BY mf_venue.venue_id ";
    $stmt	= $link->prepare($select_db_xid);
    $stmt->execute();
    $xevent_key=0;
    $xchecker_time = 0;

    if(isset($_POST['ext_recid'])){
        $select_db_timeline = "SELECT ext_appointment_info.time_from as 'time_from', ext_appointment_info.time_to as 'time_to'  FROM ext_appointment_info LEFT JOIN mf_appointment_info ON
        ext_appointment_info.appointment_info_id = mf_appointment_info.appointment_info_id
        WHERE ext_appointment_info.recid='".$_POST['ext_recid']."' ORDER BY ext_appointment_info.time_from ASC LIMIT 1";
        $stmt_timeline	= $link->prepare($select_db_timeline);
        $stmt_timeline->execute();
        $row_timeline = $stmt_timeline->fetch();
        $ret['time_fromto'] = $row_timeline['time_from']." - ".$row_timeline['time_to'];
    }

    while($row_xid = $stmt->fetch()){

        $ret['html'].= "<tr>";
            $ret['html'].= "<td style='padding-bottom:15px;padding-top:10px'>";
                $ret['html'].= "<div class='container text-start' style='font-family:inter;font-weight:700;font-size:25px;color:black;padding-left:25px'>";    
                    $ret['html'].= $row_xid["venue"];    
                $ret['html'].= "</div>";   
            $ret['html'].= "</td>";

            $ret['html'].= "<td>";
                $ret['html'].= "<select class='form-control w-75 ms-2 select_date'>";
                    $select_2 = "SELECT ext_appointment_info.clinic_date as 'clinic_date', ext_appointment_info.time_from as 'time_from', ext_appointment_info.time_to as 'time_to', ext_appointment_info.date_added as 'date_added',
                    mf_prog_users.email as 'username',  ext_appointment_info.week_day as 'weekday', mf_venue.venue as 'venue' 
                    FROM ext_appointment_info LEFT JOIN mf_appointment_info ON 
                    ext_appointment_info.appointment_info_id = mf_appointment_info.appointment_info_id LEFT JOIN mf_prog_users ON
                    mf_appointment_info.userid = mf_prog_users.userid LEFT JOIN mf_venue ON ext_appointment_info.venue_id = mf_venue.venue_id WHERE mf_prog_users.userid='".$row_xid['userid']."'  AND ext_appointment_info.venue_id='".$row_xid['venue_id']."' GROUP BY ext_appointment_info.clinic_date";
                    $stmt_2	= $link->prepare($select_2);
                    $stmt_2->execute();

                    if($_POST['ext_recid'] !== $row_xid['ext_recid']){
                        $ret['html'].= "<option disabled selected>"; 
                            $ret['html'].= "Select a Date..."; 
                        $ret['html'].= "</option>"; 
                    }

                    while($row_xid2 = $stmt_2->fetch()){

                        $xselected = '';

                        if(($_POST['date'] == $row_xid2["clinic_date"]) && ($_POST['ext_recid'] == $row_xid['ext_recid'])){
                            $xselected = 'selected';
                        }

             
                        $ret['html'].="<option ".$xselected." 
                        data-xslotsavail='".$row_xid['slots_avail']."' 
                        data-xdate='" . $row_xid2["clinic_date"] . "' 
                        data-xcounselorid='".$row_xid["userid"]."' 
                        data-xrecid='".$row_xid["ext_recid"]."'
                        data-xvenue='".$row_xid["venue"]."'
                        >" . $row_xid2["clinic_date"] . "</option>"; 
                   
                
                    }            

                $ret['html'].= "</select>";    
            $ret['html'].= "</td>";

            if($_POST['event_action'] == 'first_load'){
                $ret['html'].= "<td>";
                    $ret['html'].= "<select class='form-control w-75 ms-2''>";   
                        $ret['html'].= "<option disabled selected>"; 
                            $ret['html'].= "Select a Date..."; 
                        $ret['html'].= "</option>"; 
                    $ret['html'].= "</select>";
                $ret['html'].= "</td>";

                if($act_status2 == "PMO"){
                    $ret['html'].= "<td class='text-center'>";
                        $ret['html'].= "Select a Date...";    
                    $ret['html'].= "</td>";
                }

                $ret['html'].= "<td class='text-center'>";
                    $ret['html'].= " <button type='button' disabled class='btn' style='background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>Book now</button>";    
                $ret['html'].= "</td>";
            }else if($_POST['event_action'] == 'changeDate' || $_POST['event_action'] == 'cancel_booking'){


                if($_POST['event_action'] == 'changeDate'){
                    $select_db_times2 = "SELECT ext_appointment_info.recid as 'recid', ext_appointment_info.time_from as 'time_from', ext_appointment_info.time_to as 'time_to'  FROM ext_appointment_info LEFT JOIN mf_appointment_info ON
                    ext_appointment_info.appointment_info_id = mf_appointment_info.appointment_info_id LEFT JOIN mf_venue ON ext_appointment_info.venue_id = mf_venue.venue_id
                    WHERE mf_appointment_info.userid='".$_POST['counselorid']."' AND ext_appointment_info.venue_id='".$row_xid['venue_id']."'  AND mf_appointment_info.sched_type='".$act_status2."' AND ext_appointment_info.clinic_date='".$_POST['date']."'  ORDER BY time_from ASC LIMIT 1";
                    $stmt_times2	= $link->prepare($select_db_times2);
                    $stmt_times2->execute();
                    $xchecker = 0;
                    while($row_times2 = $stmt_times2->fetch()){

                        $timeline2 =  $row_times2['time_from']." - ".$row_times2['time_to'];

                        if($xchecker == 0 && $_POST['venue_hidden'] == $row_xid['venue']){

                            $ret['first_time'] = $timeline2;
                        }

                        $xchecker++;
                    }
                }

                if($_POST['ext_recid'] == $row_xid['ext_recid']){

                    $givendate = $_POST['date'];
        
                    $dateObject = DateTime::createFromFormat('Y-m-d', $givendate);
                    $weekday = strtolower($dateObject->format('l'));
                    
                    $ret['html'].= "<td>";
                        $ret['html'].= "<select class='form-control w-75 ms-2 select_time'>"; 
                        
                        $select_db_times = "SELECT ext_appointment_info.time_from as 'time_from', ext_appointment_info.time_to as 'time_to'  FROM ext_appointment_info LEFT JOIN mf_appointment_info ON
                        ext_appointment_info.appointment_info_id = mf_appointment_info.appointment_info_id LEFT JOIN mf_venue ON ext_appointment_info.venue_id = mf_venue.venue_id
                        WHERE mf_appointment_info.userid='".$_POST['counselorid']."' AND ext_appointment_info.venue_id='".$row_xid['venue_id']."'  AND mf_appointment_info.sched_type='".$act_status2."' AND ext_appointment_info.clinic_date='".$_POST['date']."'  ORDER BY time_from ASC";
                        $stmt_times	= $link->prepare($select_db_times);
                        $stmt_times->execute();
                        $selected_timeline = '';
                        while($row_times = $stmt_times->fetch()){

                            $timeline =  $row_times['time_from']." - ".$row_times['time_to'];

                            if($_POST['timeline'] == $timeline){
                                $selected_timeline = 'selected';
                            }
    
                            $ret['html'].= "<option ".$selected_timeline.">"; 
                                $ret['html'].= $row_times['time_from']." - ".$row_times['time_to']; 
                            $ret['html'].= "</option>"; 
    
                            $selected_timeline = '';

                        }

                        $select_db_slots = " SELECT ext_appointment_info.slots_avail as 'slots_avail' FROM ext_appointment_info LEFT JOIN mf_venue ON ext_appointment_info.venue_id = mf_venue.venue_id WHERE ext_appointment_info.venue_id = '".$row_xid['venue_id']."' AND clinic_date='".$_POST['date_hidden']."' LIMIT 1";
                        $stmt_slots	= $link->prepare($select_db_slots);
                        $stmt_slots->execute();
                        $row_slots = $stmt_slots->fetch();

                        
            
                        $ret['html'].= "</select>";
                    $ret['html'].= "</td>";

                    if($act_status2 == "PMO"){
                        $ret['html'].= "<td class='text-center'>";
                            $ret['html'].= $row_slots['slots_avail'];    
                        $ret['html'].= "</td>";

                        $ret['html'].= "<td class='text-center'>";
                            $ret['html'].= " <button type='button' onclick='book_func()' class='btn' style='background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>Book now</button>";    
                        $ret['html'].= "</td>";
                    }else{
                        $ret['html'].= "<td class='text-center'>";
                            $ret['html'].= " <button type='button' onclick='ajaxNew(\"submitAll\",\"\",\"\",\"\",\"\")' class='btn' style='background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>Book now</button>";    
                        $ret['html'].= "</td>";
                    }


                }else{
                    $ret['html'].= "<td>";
                        $ret['html'].= "<select class='form-control w-75 ms-2''>";   
                            $ret['html'].= "<option disabled selected>"; 
                                $ret['html'].= "Select a Date..."; 
                            $ret['html'].= "</option>"; 
                        $ret['html'].= "</select>";
                    $ret['html'].= "</td>";

                    if($act_status2 == "PMO"){

                        $ret['html'].= "<td class='text-center'>";
                            $ret['html'].= "Select a Date...";    
                        $ret['html'].= "</td>";
                    }


                    $ret['html'].= "<td class='text-center'>";
                        $ret['html'].= " <button type='button' disabled class='btn' style='background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>Book now</button>";    
                    $ret['html'].= "</td>";
                }
            }

        $ret['html'].= "</tr>";
    }

}else if($_POST['event_action'] == "submitAll"){


    $select_db_meiformcount = "SELECT * FROM pro_meiform ORDER BY usermeiformid DESC LIMIT 1";
    $stmt_meiformcount	= $link->prepare($select_db_meiformcount);
    $stmt_meiformcount->execute();
    $row_countAll = $stmt_meiformcount->fetchAll();

    $select_db_meiformcount2 = "SELECT * FROM pro_meiform ORDER BY usermeiformid DESC LIMIT 1";
    $stmt_meiformcount2	= $link->prepare($select_db_meiformcount2);
    $stmt_meiformcount2->execute();
    $row_countAll2 = $stmt_meiformcount2->fetch();

    $meiformuid = '';

    if(count($row_countAll) == 0){
        $meiformuid = "UMF-00001";
    }else{
        $meiformuid = lNexts($row_countAll2['usermeiformid']);
    }

    $pro_users = array();
    $pro_users["usermeiformid"] = $meiformuid;
    $pro_users["status"] = $act_status2;
    $pro_users["userid"] = $_SESSION["usr_id"];
    $pro_users["counselorid"] = $_POST["counselorid"];
    PDO_InsertRecord($link,'pro_meiform',$pro_users,$debug=false);


    $pro_users2 = array();
    $pro_users2["act_status"] = $act_status2;
    PDO_UpdateRecord($link,"mf_prog_users",$pro_users2,"userid = ?",array($_SESSION["usr_id"]),false);  




    $mf_users1 = array();
    $new_meiformid1 = "MEI-00000";
    foreach($_POST['form_1'] as $form1_e => $key) {

        $new_meiformid1 = lNexts($new_meiformid1);

        if($act_status2 == "PMO"){
            $mf_users1["userid"] = $_SESSION['usr_id'];
            $mf_users1["partnerid"] = 1;
            $mf_users1["meiformid"] = $new_meiformid1;
            $mf_users1["answers"] = $key['option'];
            $mf_users1["reasons"] = $key['input'];
            $mf_users1["venue"] = $_POST['venue_hidden'];
            $mf_users1["from_to"] = $_POST['timeline_hidden'];
            $mf_users1["date"] = $_POST['date_hidden'];
            $mf_users1["usermeiformid"] = $meiformuid;
        }else{
            $mf_users1["userid"] = $_SESSION['usr_id'];
            $mf_users1["partnerid"] = 1;
            $mf_users1["meiformid"] = $new_meiformid1;
            $mf_users1["answers"] = 'Agree';
            $mf_users1["reasons"] = '';
            $mf_users1["venue"] = $_POST['venue_hidden'];
            $mf_users1["from_to"] = $_POST['timeline_hidden'];
            $mf_users1["date"] = $_POST['date_hidden'];
            $mf_users1["usermeiformid"] = $meiformuid;
        }


        PDO_InsertRecord($link,'ext_mf_meiform',$mf_users1,$debug=false);
    }

    $mf_users2 = array();
    $new_meiformid2 = "MEI-00000";
    foreach($_POST['form_2'] as $form2_e => $key) {

        $new_meiformid2 = lNexts($new_meiformid2);

        if($act_status2 == "PMO"){
            $mf_users2["userid"] = $_SESSION['usr_id'];
            $mf_users2["partnerid"] = 2;
            $mf_users2["meiformid"] = $new_meiformid2;
            $mf_users2["answers"] = $key['option'];
            $mf_users2["reasons"] = $key['input'];
            $mf_users2["venue"] = $_POST['venue_hidden'];
            $mf_users2["from_to"] = $_POST['timeline_hidden'];
            $mf_users2["date"] = $_POST['date_hidden'];
            $mf_users2["usermeiformid"] = $meiformuid;
        }else{
            $mf_users2["userid"] = $_SESSION['usr_id'];
            $mf_users2["partnerid"] = 2;
            $mf_users2["meiformid"] = $new_meiformid2;
            $mf_users2["answers"] = "Agree";
            $mf_users2["reasons"] = "";
            $mf_users2["venue"] = $_POST['venue_hidden'];
            $mf_users2["from_to"] = $_POST['timeline_hidden'];
            $mf_users2["date"] = $_POST['date_hidden'];
            $mf_users2["usermeiformid"] = $meiformuid;
        }

        PDO_InsertRecord($link,'ext_mf_meiform',$mf_users2,$debug=false);
    }



    $ret['html'].= "<tr>";
        $ret['html'].= "<td colspan='5' style='height:100px'>";
            $ret['html'].= "<div class='container d-flex text-center align-items-center' style='font-family:inter;font-weight:700;font-size:27px;flex-direction:column'>";    
                $ret['html'].= "Pre-Marriage Orientation Schedules";    
                $ret['html'].= "<img src='images/Rectangle 11934.png' style='width:784px; height:6px;margin-top:10px'>";    
            $ret['html'].= "</div>";    
        $ret['html'].= "</td>";    
    $ret['html'].= "</tr>";

    $ret['html'].= "<tr>";
        $ret['html'].= "<td style='padding-top:15px;padding-left:20px'>";
            $ret['html'].= "<div class='container text-left' style='font-family:inter;font-weight:700;font-size:25px;color:#797979'>";    
                $ret['html'].= "Venue";    
            $ret['html'].= "</div>";    
        $ret['html'].= "</td>";

        $ret['html'].= "<td>";
            $ret['html'].= "<div class='container text-left' style='font-family:inter;font-weight:700;font-size:25px;color:#797979''>";    
                $ret['html'].= "Date";    
            $ret['html'].= "</div>";    
        $ret['html'].= "</td>";

        $ret['html'].= "<td>";
            $ret['html'].= "<div class='container text-left' style='font-family:inter;font-weight:700;font-size:25px;color:#797979''>";    
                $ret['html'].= "Time";    
            $ret['html'].= "</div>";    
        $ret['html'].= "</td>";


        if($act_status2=="PMO" || $act_status2=="APR"){
            $ret['html'].= "<td>";
                $ret['html'].= "<div class='container text-center' style='font-family:inter;font-weight:700;font-size:25px;color:#797979''>";    
                    $ret['html'].= "Slots Available";    
                $ret['html'].= "</div>";    
            $ret['html'].= "</td>";   
        }
     

        $ret['html'].= "<td>";
                $ret['html'].= "&nbsp;";    
        $ret['html'].= "</td>";           
    $ret['html'].= "</tr>";

    $select_db_xid = "SELECT mf_venue.venue as 'venue', mf_venue.venue_id as 'venue_id', mf_appointment_info.userid as 'userid',ext_appointment_info.slots_avail as 'slots_avail',
    ext_appointment_info.recid as 'ext_recid' FROM ext_appointment_info LEFT JOIN mf_appointment_info ON 
    ext_appointment_info.appointment_info_id   = mf_appointment_info.appointment_info_id LEFT JOIN mf_venue ON ext_appointment_info.venue_id = mf_venue.venue_id
    WHERE mf_venue.venue!='' AND mf_appointment_info.sched_type='".$act_status2."' GROUP BY mf_venue.venue_id";
    $stmt	= $link->prepare($select_db_xid);
    $stmt->execute();
    $xevent_key=0;
    $xchecker_time = 0;

    if(isset($_POST['ext_recid'])){
        $select_db_timeline = "SELECT ext_appointment_info.time_from as 'time_from', ext_appointment_info.time_to as 'time_to'  FROM ext_appointment_info LEFT JOIN mf_appointment_info ON
        ext_appointment_info.appointment_info_id = mf_appointment_info.appointment_info_id
        WHERE ext_appointment_info.recid='".$_POST['ext_recid']."'  AND mf_appointment_info.sched_type='".$act_status2."' ORDER BY ext_appointment_info.time_from ASC LIMIT 1";
        $stmt_timeline	= $link->prepare($select_db_timeline);
        $stmt_timeline->execute();
        $row_timeline = $stmt_timeline->fetch();
        $ret['time_fromto'] = $row_timeline['time_from']." - ".$row_timeline['time_to'];
    }

    while($row_xid = $stmt->fetch()){

        $ret['html'].= "<tr>";
            $ret['html'].= "<td style='padding-bottom:15px;padding-top:10px'>";
                $ret['html'].= "<div class='container text-start' style='font-family:inter;font-weight:700;font-size:25px;color:black;padding-left:25px'>";    
                    $ret['html'].= $row_xid["venue"];    
                $ret['html'].= "</div>";   
            $ret['html'].= "</td>";

            $ret['html'].= "<td>";
                $ret['html'].= "<select class='form-control w-75 ms-2 select_date' disabled>";
                    $select_2 = "SELECT ext_appointment_info.clinic_date as 'clinic_date', ext_appointment_info.time_from as 'time_from', ext_appointment_info.time_to as 'time_to', ext_appointment_info.date_added as 'date_added',
                    mf_prog_users.email as 'username',  ext_appointment_info.week_day as 'weekday', mf_venue.venue as 'venue' 
                    FROM ext_appointment_info LEFT JOIN mf_appointment_info ON 
                    ext_appointment_info.appointment_info_id = mf_appointment_info.appointment_info_id LEFT JOIN mf_prog_users ON
                    mf_appointment_info.userid = mf_prog_users.userid LEFT JOIN mf_venue ON ext_appointment_info.venue_id = mf_venue.venue_id
                    WHERE mf_prog_users.userid='".$row_xid['userid']."'  AND ext_appointment_info.venue_id='".$row_xid['venue_id']."'";
                    $stmt_2	= $link->prepare($select_2);
                    $stmt_2->execute();

                    if($_POST['ext_recid'] !== $row_xid['ext_recid']){
                        $ret['html'].= "<option disabled selected>"; 
                            $ret['html'].= "Select a Date..."; 
                        $ret['html'].= "</option>"; 
                    }


                    while($row_xid2 = $stmt_2->fetch()){
                    

                        $xselected = '';
                        
                        if(($_POST['date'] == $row_xid2["clinic_date"]) && ($_POST['ext_recid'] == $row_xid['ext_recid'])){
                            $xselected = 'selected';
                        }
             
                        $ret['html'].="<option ".$xselected." 
                        data-xslotsavail='".$row_xid['slots_avail']."' 
                        data-xdate='" . $row_xid2["clinic_date"] . "' 
                        data-xcounselorid='".$row_xid["userid"]."' 
                        data-xrecid='".$row_xid["ext_recid"]."'
                        data-xvenue='".$row_xid["venue"]."'
                        >" . $row_xid2["clinic_date"] . "</option>"; 

                    }


                $ret['html'].= "</select>";    
            $ret['html'].= "</td>";


            if($_POST['ext_recid'] == $row_xid['ext_recid']){

                $givendate = $_POST['date'];
    
                $dateObject = DateTime::createFromFormat('Y-m-d', $givendate);
                $weekday = strtolower($dateObject->format('l'));
                
                $ret['html'].= "<td>";
                    $ret['html'].= "<select class='form-control w-75 ms-2 select_time' disabled>"; 
                    
                    $select_db_times = "SELECT ext_appointment_info.time_from as 'time_from', ext_appointment_info.time_to as 'time_to'  FROM ext_appointment_info LEFT JOIN mf_appointment_info ON
                    ext_appointment_info.appointment_info_id = mf_appointment_info.appointment_info_id
                    WHERE mf_appointment_info.userid='".$_POST['counselorid']."' AND ext_appointment_info.venue_id='".$row_xid['venue_id']."' ORDER BY time_from ASC";                    
                    $stmt_times	= $link->prepare($select_db_times);
                    $stmt_times->execute();
                    $selected_timeline = '';


                    while($row_times = $stmt_times->fetch()){

                        $timeline =  $row_times['time_from']." - ".$row_times['time_to'];

                        if($_POST['timeline'] == $timeline){
                            $selected_timeline = 'selected';
                        }

                        $ret['html'].= "<option disabled ".$selected_timeline.">"; 
                            $ret['html'].= $row_times['time_from']." - ".$row_times['time_to']; 
                        $ret['html'].= "</option>"; 

                        $selected_timeline = '';

                    }
        
                    $ret['html'].= "</select>";
                $ret['html'].= "</td>";

                if($act_status2 == "PMO"){
                    $ret['html'].= "<td class='text-center'>";
                        $ret['html'].= $row_xid['slots_avail'];    
                    $ret['html'].= "</td>";
                }
   


                $ret['html'].= "<td class='text-center'>";
                    $ret['html'] .= " <button type='button' onclick='ajaxNew(\"cancel_booking\",\"\",\"\",\"\",\"".$meiformuid."\")' class='btn' style='background: rgb(35,64,142);background: linear-gradient(90deg, #e60000 35%, #990000 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>Cancel</button>";
                $ret['html'].= "</td>";

            }else{
                $ret['html'].= "<td>";
                    $ret['html'].= "<select class='form-control w-75 ms-2' disabled>";   
                        $ret['html'].= "<option disabled selected>"; 
                            $ret['html'].= "Select a Date..."; 
                        $ret['html'].= "</option>"; 
                    $ret['html'].= "</select>";
                $ret['html'].= "</td>";

                if($act_status2 == "PMO"){
                    $ret['html'].= "<td class='text-center'>";
                        $ret['html'].= "Select a Date...";    
                    $ret['html'].= "</td>";
                }



                $ret['html'].= "<td class='text-center'>";
                    $ret['html'].= " <button type='button' disabled class='btn' style='background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>Book now</button>";    
                $ret['html'].= "</td>";
            }

        
        $ret['html'].= "</tr>";

    }


}    





header('Content-Type: application/json');
echo json_encode($ret);
?>
