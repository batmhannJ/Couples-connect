<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('resources/db_init.php');
require_once('resources/lx2.pdodb.php');
require_once('resources/stdfunc100.php');

session_start();

$ret=array();
$ret['msg']='';
$ret['user']='';
$ret['recid']='';
$ret['status']=true;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


require_once('resources/connect4.php');


//mf_prog_users
//ext_couples_accountinfo
//check file upload
//email




// $select_db_uid="SELECT * FROM mf_prog_users ORDER BY userid DESC LIMIT 1";
// $stmt	= $link->prepare($select_db_uid);
// $stmt->execute();
// $row_uid = $stmt->fetch();
// if (count($row) == 0) {

//     $ret['msg']="Invalid username or password."; 
//     $ret['status'] = false;
// }

// else {

//     $select_db="SELECT * FROM mf_prog_users WHERE username='".$username."'";
//     $stmt	= $link->prepare($select_db);
//     $stmt->execute();
//     while($rs = $stmt->fetch()){
        
//         $recid_select=$rs['recid'];
//         $password_select=$rs['password'];  

//         if($password !== $password_select){

//             $ret['msg']="Invalid username or password.";        
//             $ret['status'] = false;
//         }

//         else if($password == $password_select){

//             $_SESSION["username"] = $username;
//             $_SESSION["password"] = $password;
//             $_SESSION["usertype"] = $rs['usertype'];
//             $ret['msg']="successful";
//             $ret['status'] = true;
//         }

//     }
// }

//add file location


date_default_timezone_set('Asia/Manila');
$date_today = date('Y-m-d');
$date_today_desc = date('F d, Y', strtotime($date_today));

$select_db_uid="SELECT * FROM mf_prog_users ORDER BY userid DESC LIMIT 1";
$stmt	= $link->prepare($select_db_uid);
$stmt->execute();
$row_uid = $stmt->fetch();

$new_id = lNexts($row_uid['userid']);

if(isset($_FILES['file_1'])){
    $doc_link = "uploads/".$_FILES['file_1']['name'];
}else{
    $doc_link = "";
}

if(isset($_FILES['file_2'])){
    $crm_link = "uploads/".$_FILES['file_2']['name'];
}else{
    $crm_link = "";
}

$mf_users = array();
$mf_users["username"] = $_POST["reg_email_h"];
$mf_users["userid"] = $new_id;
$mf_users["email"] = $_POST['reg_email_h'];
$mf_users["secondary_email"] = $_POST['confirm_email_h'];
$mf_users["usertype"] = "USR";
$mf_users["password"] = $_POST['reg_pwd_h'];
$mf_users["act_status"] = 'RVW';
$mf_users["date_requested"] = $date_today;
$mf_users["date_requested_desc"] = $date_today_desc;
$mf_users["pmoc_online"] = $_POST["is_pmoc"];
$mf_users["justification"] = $_POST["justification"];
$mf_users["doc_link"] = $doc_link;
$mf_users["crm_link"] = $crm_link;
PDO_InsertRecord($link,'mf_prog_users',$mf_users,$debug=false);

$mf_accountinfo = array();
$mf_accountinfo["userid"] = $new_id;
$mf_accountinfo["partnerno"] = 1;
$mf_accountinfo["first_name"] = $_POST['first_name_h'];
$mf_accountinfo["middle_name"] = $_POST['middle_name_h'];
$mf_accountinfo["last_name"] = $_POST['last_name_h'];
$mf_accountinfo["sex"] = $_POST['sex_h'];
$mf_accountinfo["bday"] = date("Y-m-d", strtotime($_POST['bday_h']));
$mf_accountinfo["country"] = $_POST['country_h'];
$mf_accountinfo["municipality"] = $_POST['municipality_h'];
$mf_accountinfo["cellphone_number"] = $_POST['cellphone_number_h'];
$mf_accountinfo["occupation"] = $_POST["occupation_h"];
PDO_InsertRecord($link,'ext_couples_accountinfo',$mf_accountinfo,$debug=false);

$mf_accountinfo2 = array();
$mf_accountinfo2["userid"] = $new_id;
$mf_accountinfo2["partnerno"] = 2;
$mf_accountinfo2["first_name"] = $_POST['first_name2_h'];
$mf_accountinfo2["middle_name"] = $_POST['middle_name2_h'];
$mf_accountinfo2["last_name"] = $_POST['last_name2_h'];
$mf_accountinfo2["sex"] = $_POST['sex2_h'];
$mf_accountinfo2["bday"] = date("Y-m-d", strtotime($_POST['bday2_h']));
$mf_accountinfo2["country"] = $_POST['country2_h'];
$mf_accountinfo2["municipality"] = $_POST['municipality2_h'];
$mf_accountinfo2["cellphone_number"] = $_POST['cellphone_number2_h'];
$mf_accountinfo2["occupation"] = $_POST["occupation2_h"];
PDO_InsertRecord($link,'ext_couples_accountinfo',$mf_accountinfo2,$debug=false);


$target_path ="uploads/";


if(isset($_FILES['file_1'])){
    $target_path_1 = $target_path . basename( $_FILES['file_1']['name']); 
    $xfilename_1 = basename( $_FILES['file_1']['name']); 
    move_uploaded_file($_FILES['file_1']['tmp_name'], $target_path_1);
}

if(isset($_FILES['file_2'])){
$target_path_2 = $target_path . basename( $_FILES['file_2']['name']); 
$xfilename_2 = basename( $_FILES['file_2']['name']); 
move_uploaded_file($_FILES['file_2']['tmp_name'], $target_path_2);
}





header('Content-Type: application/json');
echo json_encode($ret);
?>
