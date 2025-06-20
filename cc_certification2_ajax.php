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
$ret['time_fromto']='';
$ret["retEdit"] = array();

$cert_status_desc = "";
if($_POST['cert_status'] == "PRP"){
    $cert_status_desc = "Preparing";
}else if($_POST['cert_status'] == "PUP"){
    $cert_status_desc = "For Pickup";
}else if($_POST['cert_status'] == "RCV"){
    $cert_status_desc = "Received";
}

$date_today = date('Y-m-d');
$date_today_desc = date('F d, Y', strtotime($date_today));

$mf_prog_users = array();
$mf_prog_users["status"] = $_POST['cert_status'];
$mf_prog_users["status_desc"] = $cert_status_desc;
$mf_prog_users['date_claimed'] 	= $date_today;
$mf_prog_users['date_claimed_desc'] 	= $date_today_desc;

$userId = isset($_POST['userid']) ? (int)$_POST['userid'] : 0;

$status = $_POST['cert_status'] === "DEC" ? 1 : 0;


try { 
    // Prepare the UPDATE SQL statement
    $st = $link->prepare("UPDATE pro_cert_table SET status = :status, reason = :reason WHERE recid = :recid");
    
    // Assign a default value to 'reason' if it's not provided in POST
    $reason = $_POST['reason'] ?? "No reason provided.";
    
    // Bind the parameters with explicit data types
    $st->bindParam(':status', $_POST['cert_status'], PDO::PARAM_STR);
    $st->bindParam(':reason', $reason, PDO::PARAM_STR);
    $st->bindParam(':recid', $_POST['cert_recid_hidden'], PDO::PARAM_INT);
    
    $st->execute();

    // Output the number of affected rows
    $o = $st->rowCount();

    $st1 = $link->prepare("UPDATE mf_prog_users SET print_status = :print_status WHERE recid=:recid");
    $st1->bindParam(':print_status', $status, PDO::PARAM_STR);
    $st1->bindParam(':recid', $userId, PDO::PARAM_INT);

    $st1->execute();
} 
catch (Exception $e) {
    // Catch and display any exceptions
    echo 'Error: ' . $e->getMessage();
}


die();


// PDO_UpdateRecord($link,"pro_cert_table",$mf_prog_users,"recid = ?",array($_POST['cert_recid_hidden']),false);  


$select_db="SELECT * FROM mf_prog_users WHERE recid=?";
$stmt	= $link->prepare($select_db);
$stmt->execute(array($_POST["ac_recid_hidden"]));
$rs = $stmt->fetch();
$useremail = $rs['username'];


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if($_POST['cert_status'] == "PRP"){
    $xemail_title = "Couples Connect User, Certification Status!";
    $xemail_body = "Good Day!,".$useremail.". This is ".$_SESSION['username']." from <b>Couples Connect</b> our staff is currently preparing your certification document!";
}else if($_POST['cert_status'] == "PUP"){
    $xemail_title = "Couples Connect User, Certification Status!";
    $xemail_body = "Good Day!,".$useremail.". This is ".$_SESSION['username']." from <b>Couples Connect</b>, your certification is ready for pickup!";
}else if($_POST['cert_status'] == "RCV"){
    $xemail_title = "Couples Connect User, Certification Status!";
    $xemail_body = "Good Day!,".$useremail.". This is ".$_SESSION['username']." from <b>Couples Connect</b>, your certification has been received, take care!";
}

// EMAIL SEDING
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host='smtp.gmail.com';
$mail->SMTPAuth=true;
$mail->Username='lennardleework@gmail.com';
$mail->Password='dsfs xoai msta xgrh';
$mail->SMTPSecure='ssl';
$mail->Port=465;

$mail->setFrom('lennardleework@gmail.com');
$mail->addAddress($useremail);
$mail->isHTML(true);
$mail->Subject = $xemail_title;
$mail->Body = $xemail_body;
$mail->send();



//header('Content-Type: application/json');
echo json_encode($ret);
?>
