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


$cert_status = '';
$cert_desc = '';
if($_POST['event_action'] == 'CRT'){
    $cert_status = 'PCT';
    $cert_desc = 'Preparing';  
}else{
    $cert_status = $_POST['event_action'];
}

$pro_users2 = array();
$pro_users2["act_status"] = $cert_status;
PDO_UpdateRecord($link,"mf_prog_users",$pro_users2,"recid = ?",array($_POST["ac_recid_hidden"]),false);  




header('Content-Type: application/json');
echo json_encode($ret);
?>
