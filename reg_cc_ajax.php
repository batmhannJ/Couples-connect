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

if ($_POST) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => false, 'msg' => 'Invalid email format']);
        exit;
    }
    
    // Check if email already exists
    $check_email = "SELECT COUNT(*) as count FROM mf_prog_users WHERE email = ?";
    $stmt = $link->prepare($check_email);
    $stmt->execute([$email]);
    $result = $stmt->fetch();
    
    if ($result['count'] > 0) {
        echo json_encode(['status' => false, 'msg' => 'Email already exists']);
        exit;
    }
    
    // Email is available, proceed to next step
    echo json_encode(['status' => true, 'msg' => 'Email available']);
}
?>
