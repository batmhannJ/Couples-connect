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

require_once('resources/connect4.php');


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
        $xdata_add["venue"] = $_POST["venue"];
        $xdata_add["userid"] = $_SESSION["usr_id"];
        $xdata_add["slots_avail"] = $num_part;
        $xdata_add["appointment_info_id"] = $app_id;
        $xdata_add["sched_type"] = $_POST['select_type'];
        
        PDO_InsertRecord($link,'mf_appointment_info',$xdata_add,$debug=false,$ignore_errors=false);
    
    }

    $ext_arr = array();
    $ext_arr["appointment_info_id"] = $app_id;
    $ext_arr["week_day"] = $_POST['day_select'];
    $ext_arr["time_from"] = $_POST['sched_from'];
    $ext_arr["time_to"] = $_POST['sched_to'];
    $ext_arr["date_added"] = $date_today;
    PDO_InsertRecord($link,'ext_appointment_info',$ext_arr,$debug=false,$ignore_errors=false);


    $xdata_update = array();
    $xdata_update["venue"] = $_POST["venue"];
    $xdata_update["slots_avail"] = $num_part;
    $xdata_update["sched_type"] = $_POST['select_type'];
    PDO_UpdateRecord($link,'mf_appointment_info',$xdata_update,$condition=' appointment_info_id = ?',array($app_id),$debug=false);
}

header('Content-Type: application/json');
echo json_encode($ret);
?>
