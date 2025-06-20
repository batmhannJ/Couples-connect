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
$ret=array();
$ret['status']= true;

require_once('resources/connect4.php');


$xemail_title = "From user";
$xemail_body = "User has sent an email";

if(isset($_POST['email_subject']) && !empty($_POST['email_subject'])){
    $xemail_title = $_SESSION["username"]." says: ".$_POST['email_subject'];
}
if(isset($_POST['email_remarks']) && !empty($_POST['email_remarks'])){
    $xemail_body = $_POST['email_remarks'];
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
$mail->addAddress('lennardleework@gmail.com');
$mail->isHTML(true);
$mail->Subject = $xemail_title;
$mail->Body = $xemail_body;
$mail->send();



header('Content-Type: application/json');
echo json_encode($ret);
?>
