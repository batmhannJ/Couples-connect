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
$ret["retEdit"] = array();

$xfalse = array();
$xfalse["1"] = false;

require_once('resources/connect4.php');

if(isset($_POST['event_action']) && $_POST['event_action'] == "add_sched"){
    $from_military = date("H:i:s", strtotime($_POST["sched_from"]));
    $to_military = date("H:i:s", strtotime($_POST["sched_to"]));

    $from_time = new DateTime($from_military);
    $to_time = new DateTime($to_military);
    $resultTime = date_diff($from_time, $to_time);
    $hour_diff = $resultTime->format('%r%H:%i:%s');

    date_default_timezone_set('Asia/Manila');
    $date_today = date('Y-m-d');

    $search_negative = "-";

    if($hour_diff == "00:0:0" || strpos($hour_diff, '-') !== false){
        $ret["msg"] = "Time from <b>cannot be greater than or equal to</b> than Time to";
        $ret["status"] = false;
    }else{

        $select_db_check = "SELECT * FROM mf_appointment_info WHERE sched_type='".$_POST['select_type']."' AND userid='".$_SESSION['usr_id']."'";
        $stmt	= $link->prepare($select_db_check);
        $stmt->execute();
        $row_check = $stmt->fetchAll();

        $select_db_xid = "SELECT * FROM mf_appointment_info ORDER BY recid DESC limit 1";
        $stmt	= $link->prepare($select_db_xid);
        $stmt->execute();
        $row_xid = $stmt->fetch();

        if($row_xid['userid'] == "" || empty($row_xid['userid'])){
            $app_id = "APP-00001";
        }else{
            if(count($row_check)  == 0){
                $app_id = lNexts($row_xid['appointment_info_id']);
            }else{
                $app_id = $row_xid['appointment_info_id'];
            }

        }

        $num_part = '';
        if(isset($_POST["num_part"])){
            $num_part = $_POST["num_part"];
        }

        if(count($row_check)  == 0 ){
            $xdata_add = array();

            $xdata_add["userid"] = $_SESSION["usr_id"];
            $xdata_add["appointment_info_id"] = $app_id;
            $xdata_add["sched_type"] = $_POST['select_type'];
            PDO_InsertRecord($link,'mf_appointment_info',$xdata_add,$debug=false,$ignore_errors=false);
        
        }

        $_POST['date_select'] = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['date_select'])));

        $ext_arr = array();
        $ext_arr["appointment_info_id"] = $app_id;
        // $ext_arr["week_day"] = $_POST['day_select'];
        $ext_arr["clinic_date"] = $_POST['date_select'];
        $ext_arr["time_from"] = $_POST['sched_from'];
        $ext_arr["time_to"] = $_POST['sched_to'];
        $ext_arr["date_added"] = $date_today;
        $ext_arr["slots_avail"] = $num_part;
        $ext_arr["venue_id"] = $_POST["venue"];
        $ext_arr["counseloremail"] = $_SESSION["username"];
        PDO_InsertRecord($link,'ext_appointment_info',$ext_arr,$debug=false,$ignore_errors=false);

        $xdata_update = array();
        $xdata_update["sched_type"] = $_POST['select_type'];
        $xdata_update["userid"] = $_SESSION["usr_id"];
        PDO_UpdateRecord($link,'mf_appointment_info',$xdata_update,$condition=' appointment_info_id = ?',array($app_id),$debug=false);
    }

}else if(isset($_POST['event_action']) && $_POST['event_action'] == "get_sched"){

    $select_db2="SELECT ext_appointment_info.clinic_date as 'clinic_date', ext_appointment_info.week_day as 'week_day', ext_appointment_info.time_from as 'time_from',
    ext_appointment_info.time_to as 'time_to', ext_appointment_info.appointment_info_id as 'app_id',mf_venue.venue_id as 'venue_id',
    ext_appointment_info.slots_avail as 'slots_avail', mf_appointment_info.sched_type as 'sched_type', ext_appointment_info.recid as 'ext_recid'
    FROM ext_appointment_info RIGHT JOIN mf_appointment_info ON
    ext_appointment_info.appointment_info_id = mf_appointment_info.appointment_info_id LEFT JOIN mf_venue ON ext_appointment_info.venue_id = mf_venue.venue_id WHERE ext_appointment_info.recid=?";
	$stmt2	= $link->prepare($select_db2);
	$stmt2->execute(array($_POST['xrecid']));
    $rs = $stmt2->fetch();

    // Create a DateTime object from the input date
    $dateObject = new DateTime($rs['clinic_date']);

    // Format the date into mm/dd/yyyy format
    $formattedDate = $dateObject->format('m/d/Y');

    $ret["retEdit"] = [
        "week_day" => $rs["week_day"],
        "clinic_date" => $formattedDate,
        "time_from" => $rs["time_from"],
        "time_to" => $rs["time_to"],
        "sched_type" => $rs["sched_type"],
        "slots_avail" => $rs["slots_avail"],
        "venue_id" => $rs["venue_id"],
        "recid" => $rs["ext_recid"]
    ];

    $xret["status"] = "retEdit";
}else if(isset($_POST['event_action']) && $_POST['event_action'] == "setEdit"){

    $from_military = date("H:i:s", strtotime($_POST["modal_schedfrom"]));
    $to_military = date("H:i:s", strtotime($_POST["modal_schedto"]));

    $from_time = new DateTime($from_military);
    $to_time = new DateTime($to_military);
    $resultTime = date_diff($from_time, $to_time);
    $hour_diff = $resultTime->format('%r%H:%i:%s');

    date_default_timezone_set('Asia/Manila');
    $date_today = date('Y-m-d');

    $search_negative = "-";

    if($hour_diff == "00:0:0" || strpos($hour_diff, '-') !== false){
        $ret["msg"] = "Time from <b>cannot be greater than or equal to</b> than Time to";
        $ret["status"] = false;
    }else{

        $modal_part = '';
        if(isset($_POST["modal_participants"])){
            $modal_part = $_POST["modal_participants"];
        }


        $select_db_xid = "SELECT * FROM ext_appointment_info WHERE recid=?";
        $stmt	= $link->prepare($select_db_xid);
        $stmt->execute(array($_POST['xrecid']));
        $row_xid = $stmt->fetch();


        $xdata_update = array();
        $xdata_update["sched_type"] = $_POST['modal_service'];
        PDO_UpdateRecord($link,'mf_appointment_info',$xdata_update,$condition=' appointment_info_id = ?',array($row_xid['appointment_info_id']),$debug=false);

 
        // Create a DateTime object from the input date
        $dateObject2 = DateTime::createFromFormat('m/d/Y', $_POST['modal_clinicdate']);

        // Format the date into Y-m-d format
        $newFormattedDate = $dateObject2->format('Y-m-d');


        $ext_arr = array();
        // $ext_arr["week_day"] = $_POST['modal_weekday'];
        $ext_arr["clinic_date"] = $newFormattedDate;
        $ext_arr["venue_id"] = $_POST["modal_venue"];
        $ext_arr["time_from"] = $_POST['modal_schedfrom'];
        $ext_arr["time_to"] = $_POST['modal_schedto'];
        $ext_arr["slots_avail"] = $modal_part;
        PDO_UpdateRecord($link,'ext_appointment_info',$ext_arr,$condition=' recid = ?',array($_POST['xrecid']),$debug=false);
    }
}else if(isset($_POST['event_action']) && $_POST['event_action'] == "delete_sched"){

	$delete_id=$_POST['xrecid'];
	$delete_query="DELETE  FROM ext_appointment_info WHERE recid=?";
	$xstmt=$link->prepare($delete_query);
	$xstmt->execute(array($delete_id));

}else if(isset($_POST['event_action']) && $_POST['event_action'] == "add_zoom_link"){


    $select_db_zoom = "SELECT * FROM mf_venue WHERE userid=? AND venue_link=?";
    $stmt_zoom	= $link->prepare($select_db_zoom);
    $stmt_zoom->execute(array($_SESSION['usr_id'],$_POST['zoom_link']));
    $row_zoom = $stmt_zoom->fetchAll();

    $select_db_zoom2 = "SELECT * FROM mf_venue WHERE userid=? AND venue=?";
    $stmt_zoom2	= $link->prepare($select_db_zoom2);
    $stmt_zoom2->execute(array($_SESSION['usr_id'],$_POST['zoom_link_title']));
    $row_zoom2 = $stmt_zoom2->fetchAll();

    if(count($row_zoom) !== 0){
        
        $ret['msg']='Zoom link already in use, try a different one';

        $xfalse['1'] = true;
        $ret['status']=false;
    }

    if(count($row_zoom2) !== 0){

        if($xfalse['1'] == true){
            $ret['msg'].=' and title is in use';
        }else{
            $ret['msg'].='Title in use';
        }

        $ret['status']=false;
    }

    if($ret['status'] == true){

        $select_db_xid = "SELECT * FROM mf_venue ORDER BY recid DESC limit 1";
        $stmt	= $link->prepare($select_db_xid);
        $stmt->execute();
        $row_xid = $stmt->fetch();
        $new_venue_id = LNexts($row_xid['venue_id']);
    
        $xzoom_arr = array();
        $xzoom_arr["venue_id"] = $new_venue_id;
        $xzoom_arr["is_online"] = "Y";
        $xzoom_arr["venue_link"] = $_POST['zoom_link'];
        $xzoom_arr["venue"] = $_POST['zoom_link_title'];
        $xzoom_arr["userid"] = $_SESSION["usr_id"];
        PDO_InsertRecord($link,'mf_venue',$xzoom_arr,$debug=false,$ignore_errors=false);

        $ret['status']=true;
    }


}
header('Content-Type: application/json');
echo json_encode($ret);
?>
