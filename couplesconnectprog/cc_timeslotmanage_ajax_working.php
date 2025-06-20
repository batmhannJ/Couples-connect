<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('resources/db_init.php');
require_once('resources/lx2.pdodb.php');
require_once("resources/stdfunc100.php");

session_start();

$ret=array();
$ret['msg']='';
$ret['user']='';
$ret['userlvl']='';
$ret['recid']='';
$ret['status']=true;
$ret['updatedData']=array();



require_once('resources/connect4.php');

    // function getMondays($year,$xweekday,$date_added,$fromtime,$totime,$email,$weekday) {

    //     $ret["retEdit"] = array();
        
    //     $start = new DateTime($date_added);
    //     $end = new DateTime("$year-12-31");
    //     $interval = new DateInterval('P1W'); // one week interval
    //     $mondays = array();

    //     $xevent_key = 0;

    //     for ($date = $start; $date <= $end; $date->add($interval)) {
    //         if ($date->format('w') == $xweekday) { // w is the day of the week (0 = Sunday, 1 = Monday, ...)
    //             // $mondays[] = $date->format('Y-m-d');
    //             $xdate = $date->format('Y-m-d');
    //             $fromtimefull = $xdate."T".$fromtime;
    //             $fromtimeto = $xdate."T".$totime;

    //             $ret["retEdit"][$xevent_key]["title"] = $email."'s ".$weekday." schedule";
    //             $ret["retEdit"][$xevent_key]["start"] = $fromtimefull;
    //             $ret["retEdit"][$xevent_key]["end"] = $fromtimeto;
    //             $ret["retEdit"][$xevent_key]["key"] = $xevent_key;

    //             $xevent_key++;
    //         }
    //     }

    //     return $ret["retEdit"];
    // }


    $select_db = "SELECT ext_appointment_info.time_from as 'time_from', ext_appointment_info.time_to as 'time_to', ext_appointment_info.date_added as 'date_added',
    mf_prog_users.email as 'username',  ext_appointment_info.week_day as 'weekday'
    FROM ext_appointment_info LEFT JOIN mf_appointment_info ON 
    ext_appointment_info.appointment_info_id = mf_appointment_info.appointment_info_id LEFT JOIN mf_prog_users ON
    mf_appointment_info.userid = mf_prog_users.userid WHERE mf_prog_users.userid='".$_SESSION['usr_id']."'";
    $stmt	= $link->prepare($select_db);
    $stmt->execute();
    $xevent_key = 0;
    while($row_xid = $stmt->fetch()){

        $from_military = date("H:i:s", strtotime($row_xid["time_from"]));
        $to_military = date("H:i:s", strtotime($row_xid["time_to"]));

        if($row_xid['weekday'] == 'monday'){
            $xweekday = 1;
        }else if($row_xid['weekday'] == 'tuesday'){
            $xweekday = 2;
        }else if($row_xid['weekday'] == 'wednesday'){
            $xweekday = 3;
        }else if($row_xid['weekday'] == 'thursday'){
            $xweekday = 4;
        }else if($row_xid['weekday'] == 'friday'){
            $xweekday = 5;
        }else if($row_xid['weekday'] == 'saturday'){
            $xweekday = 6;
        }else if($row_xid['weekday'] == 'sunday'){
            $xweekday = 0;
        }
        date_default_timezone_set('Asia/Manila');
        $current_year = date("Y");

        $start = new DateTime($row_xid['date_added']);
        $end = new DateTime("$current_year-12-31");

        for ($date = $start; $date <= $end; $date->add(new DateInterval('P1D'))) {
            if ($date->format('w') == $xweekday) {

                $xdate = $date->format('Y-m-d');
                $fromtimefull = $xdate."T".$from_military;
                $fromtimeto = $xdate."T".$to_military;

                $ret["retEdit"][$xevent_key]["title"] = $row_xid["time_from"]."-".$row_xid["time_to"];
                $ret["retEdit"][$xevent_key]["start"] = $fromtimefull;
                $ret["retEdit"][$xevent_key]["end"] = $fromtimeto;
                $ret["retEdit"][$xevent_key]["key"] = $xevent_key;

                $xevent_key++;
            }
        }

    }



header('Content-Type: application/json');
echo json_encode($ret);
?>
