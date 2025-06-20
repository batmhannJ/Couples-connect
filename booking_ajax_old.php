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
$ret["retEdit"] = array();

if($_POST['event_action'] == "first_load" || $_POST['event_action'] == "changeDate"){


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

        $ret['html'].= "<td>";
            $ret['html'].= "<div class='container text-center' style='font-family:inter;font-weight:700;font-size:25px;color:#797979''>";    
                $ret['html'].= "Slots Available";    
            $ret['html'].= "</div>";    
        $ret['html'].= "</td>";        

        $ret['html'].= "<td>";
                $ret['html'].= "&nbsp;";    
        $ret['html'].= "</td>";           
    $ret['html'].= "</tr>";

    $select_db_xid = "SELECT ext_appointment_info.venue as 'venue', mf_appointment_info.userid as 'userid',ext_appointment_info.slots_avail as 'slots_avail',
    ext_appointment_info.recid as 'ext_recid' FROM ext_appointment_info LEFT JOIN mf_appointment_info ON 
    ext_appointment_info.appointment_info_id   = mf_appointment_info.appointment_info_id WHERE ext_appointment_info.venue!='' GROUP BY ext_appointment_info.venue ";
    $stmt	= $link->prepare($select_db_xid);
    $stmt->execute();
    $xevent_key=0;
    $xchecker_time = 0;
    while($row_xid = $stmt->fetch()){

        if(isset($_POST['ext_recid'])){
            $select_db_timeline = "SELECT ext_appointment_info.time_from as 'time_from', ext_appointment_info.time_to as 'time_to'  FROM ext_appointment_info LEFT JOIN mf_appointment_info ON
            ext_appointment_info.appointment_info_id = mf_appointment_info.appointment_info_id
            WHERE ext_appointment_info.venue='".$row_xid['venue']."' AND ext_appointment_info.recid='".$_POST['ext_recid']."' ORDER BY ext_appointment_info.time_from ASC LIMIT 1";
            $stmt_timeline	= $link->prepare($select_db_timeline);
            $stmt_timeline->execute();
            $row_timeline = $stmt_timeline->fetch();
            $ret['time_fromto'] = $row_timeline['time_from']." - ".$row_timeline['time_to'];
        }



        $ret['html'].= "<tr>";
            $ret['html'].= "<td style='padding-bottom:15px;padding-top:10px'>";
                $ret['html'].= "<div class='container text-start' style='font-family:inter;font-weight:700;font-size:25px;color:black;padding-left:25px'>";    
                    $ret['html'].= $row_xid["venue"];    
                $ret['html'].= "</div>";   
            $ret['html'].= "</td>";

            $ret['html'].= "<td>";
                $ret['html'].= "<select class='form-control w-75 ms-2 select_date'>";
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

                        if((isset($_POST['date'])) && $_POST['date'] == $key['date']){
                            $xseleted = 'selected';
                        }

                        $ret['html'] .= "<option ".$xseleted." 
                        data-xslotsavail='".$row_xid['slots_avail']."' 
                        data-xdate='" . $key['date'] . "' 
                        data-xcounselorid='".$key['userid']."' 
                        data-xrecid='".$key['ext_recid']."'
                        data-xvenue='".$key['venue']."'
                        >" . $key['date'] . "</option>"; 
                        $xseleted = '';
                    }

                    unset($ret["retEdit"]);


                $ret['html'].= "<select>";    
            $ret['html'].= "</td>";

            if($_POST['event_action'] == 'first_load'){
                $ret['html'].= "<td>";
                    $ret['html'].= "<select class='form-control w-75 ms-2''>";   
                        $ret['html'].= "<option disabled selected>"; 
                            $ret['html'].= "Select a Date..."; 
                        $ret['html'].= "</option>"; 
                    $ret['html'].= "</select>";
                $ret['html'].= "</td>";

                $ret['html'].= "<td class='text-center'>";
                    $ret['html'].= "Select a Date...";    
                $ret['html'].= "</td>";

                $ret['html'].= "<td class='text-center'>";
                    $ret['html'].= " <button type='button' disabled class='btn' style='background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>Book now</button>";    
                $ret['html'].= "</td>";
            }else if($_POST['event_action'] == 'changeDate'){

                if($_POST['ext_recid'] == $row_xid['ext_recid']){

                    $givendate = $_POST['date'];
        
                    $dateObject = DateTime::createFromFormat('Y-m-d', $givendate);
                    $weekday = strtolower($dateObject->format('l'));
                    
                    $ret['html'].= "<td>";
                        $ret['html'].= "<select class='form-control w-75 ms-2'>"; 
                        
                        $select_db_times = "SELECT ext_appointment_info.time_from as 'time_from', ext_appointment_info.time_to as 'time_to'  FROM ext_appointment_info LEFT JOIN mf_appointment_info ON
                        ext_appointment_info.appointment_info_id = mf_appointment_info.appointment_info_id
                        WHERE ext_appointment_info.week_day='".$weekday."' AND mf_appointment_info.userid='".$_POST['counselorid']."' AND ext_appointment_info.venue='".$row_xid['venue']."' ORDER BY time_from ASC";
                        $stmt_times	= $link->prepare($select_db_times);
                        $stmt_times->execute();

                        while($row_times = $stmt_times->fetch()){

                            if($xchecker_time == 0){
                                $ret['time_fromto'] = $row_times['time_from']." - ".$row_times['time_to'];
                            }

                            $ret['html'].= "<option>"; 
                                $ret['html'].= $row_times['time_from']." ".$row_times['time_to']; 
                            $ret['html'].= "</option>"; 

                            $xchecker_time++;
                        }
            
                        $ret['html'].= "</select>";
                    $ret['html'].= "</td>";


                    $ret['html'].= "<td class='text-center'>";
                        $ret['html'].= $row_xid['slots_avail'];    
                    $ret['html'].= "</td>";


                    $ret['html'].= "<td class='text-center'>";
                        $ret['html'].= " <button type='button' onclick='book_func()' class='btn' style='background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>Book now</button>";    
                    $ret['html'].= "</td>";

                }else{
                    $ret['html'].= "<td>";
                        $ret['html'].= "<select class='form-control w-75 ms-2''>";   
                            $ret['html'].= "<option disabled selected>"; 
                                $ret['html'].= "Select a Date..."; 
                            $ret['html'].= "</option>"; 
                        $ret['html'].= "</select>";
                    $ret['html'].= "</td>";

                    $ret['html'].= "<td class='text-center'>";
                        $ret['html'].= "Select a Date...";    
                    $ret['html'].= "</td>";

                    $ret['html'].= "<td class='text-center'>";
                        $ret['html'].= " <button type='button' disabled class='btn' style='background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>Book now</button>";    
                    $ret['html'].= "</td>";
                }

        
        

            }

        $ret['html'].= "</tr>";
    }









}else if($_POST['event_action'] == "submitAll"){



    $mf_users1 = array();
    $mei_formid1 = "MEI-00000";
    foreach($_POST['form_1'] as $form1_e => $key) {

        $mf_users1["userid"] = $_SESSION['usr_id'];
        $mf_users1["partnerid"] = 1;
        $mf_users1["meiformid"] = lnexts($mei_formid1);
        $mf_users1["answers"] = $key['option'];
        $mf_users1["reasons"] = $key['input'];
        $mf_users1["venue"] = $_POST['venue_hidden'];
        $mf_users1["from_to"] = $_POST['timeline_hidden'];
        $mf_users1["date"] = $_POST['date_hidden'];
        PDO_InsertRecord($link,'ext_mf_meiform',$mf_users1,$debug=false);
    }

    $mf_users2 = array();
    $mei_formid2 = "MEI-00000";
    foreach($_POST['form_2'] as $form2_e => $key) {

        $mf_users2["userid"] = $_SESSION['usr_id'];
        $mf_users2["partnerid"] = 2;
        $mf_users2["meiformid"] = lnexts($mei_formid2);
        $mf_users2["answers"] = $key['option'];
        $mf_users2["reasons"] = $key['input'];
        $mf_users2["venue"] = $_POST['venue_hidden'];
        $mf_users2["from_to"] = $_POST['timeline_hidden'];
        $mf_users2["date"] = $_POST['date_hidden'];
        PDO_InsertRecord($link,'ext_mf_meiform',$mf_users2,$debug=false);
    }


}



header('Content-Type: application/json');
echo json_encode($ret);
?>
