<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();
require_once('resources/db_init.php');
require_once('resources/lx2.pdodb.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$chkusertype = $_SESSION["username"];
$ret = array();
$ret['status'] = true;

require_once('resources/connect4.php');

$select_db = "SELECT * FROM mf_prog_users WHERE recid = :recid";
$stmt = $link->prepare($select_db);
$stmt->bindParam(':recid', $_POST["ac_recid_hidden"], PDO::PARAM_INT);
$stmt->execute();
$rs = $stmt->fetch(PDO::FETCH_ASSOC);
$useremail = $rs['username'];

$date_today = date('Y-m-d');
$date_today_desc = date('F d, Y', strtotime($date_today));

$arr_record_data = array(
    'act_status' => $_POST['event_action'],
    'chk_by' => $chkusertype,
    'date_requested' => $date_today,
    'date_requested_desc' => $date_today_desc,
    'remarks' => $_POST['remarks'] ?? "Please reapply again."
);


$update_sql = "UPDATE mf_prog_users SET act_status = :act_status, chk_by = :chk_by, 
                date_requested = :date_requested, date_requested_desc = :date_requested_desc,
                remarks = :remarks 
                WHERE recid = :recid";
$stmt = $link->prepare($update_sql);
$stmt->bindParam(':act_status', $arr_record_data['act_status'], PDO::PARAM_STR);
$stmt->bindParam(':chk_by', $arr_record_data['chk_by'], PDO::PARAM_STR);
$stmt->bindParam(':date_requested', $arr_record_data['date_requested'], PDO::PARAM_STR);
$stmt->bindParam(':date_requested_desc', $arr_record_data['date_requested_desc'], PDO::PARAM_STR);
$stmt->bindParam(':remarks', $arr_record_data['remarks'], PDO::PARAM_STR);
$stmt->bindParam(':recid', $_POST["ac_recid_hidden"], PDO::PARAM_INT);
$stmt->execute();

// Prepare email subject and body
if ($_POST['event_action'] == "DEC") {
    $xemail_title = "Couples Connect User, Declined";
    $xemail_body = "Good Day! $useremail. This is $chkusertype from <b>Couples Connect</b>. Unfortunately, we have reviewed your approval and deemed that you do not need further counselling. Take care!";
} else {
    $xemail_title = "Couples Connect User, Approved";
    $xemail_body = "Good Day! $useremail. This is $chkusertype from <b>Couples Connect</b>. Your request for approval has been <b>approved</b>. Kindly log in to the website to proceed with the next step. Take care!";
}

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'lennardleework@gmail.com';
$mail->Password = 'dsfs xoai msta xgrh';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

$mail->setFrom('lennardleework@gmail.com');
$mail->addAddress($useremail);
$mail->isHTML(true);
$mail->Subject = $xemail_title;
$mail->Body = $xemail_body;
$mail->send();

header('Content-Type: application/json');
echo json_encode($ret);
?>
