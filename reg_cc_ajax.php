<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();
require_once('resources/db_init.php');
require_once('resources/lx2.pdodb.php');

$email=$_POST['email'];
$password=$_POST['password'];

$ret=array();
$ret['msg']='';
$ret['user']='';
$ret["status"] = true;


require_once('resources/connect4.php');

$select_db="SELECT * FROM mf_prog_users WHERE username='".$email."'";
$stmt	= $link->prepare($select_db);
$stmt->execute();
$row = $stmt->fetchAll();

if (count($row) > 0) {

    $ret['msg']="Invalid username or password."; 
    $ret["status"] = false;
    $xactivity = "Login";
    $xremarks = "No such User";
    //PDO_UserActivityLog($link, $xusrcde, $xusrname, $xtrndte, $xprog_module, $xactivity, $xfullname, $xremarks , $linenum, $parameter, $trncde, $trndsc, $compname, $xusrnme);
    // PDO_UserActivityLog($link, '', '', '', '', $xactivity, , $xremarks , 0, '', '', '','',$username);
}



header('Content-Type: application/json');
echo json_encode($ret);
?>
