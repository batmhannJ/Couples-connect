<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('resources/db_init.php');
require_once('resources/lx2.pdodb.php');

$username=$_POST['email'];
$password=$_POST['password'];
session_start();

$ret=array();
$ret['msg']='';
$ret['user']='';
$ret['userlvl']='';
$ret['recid']='';
$ret['status']=true;

require_once('resources/connect4.php');

$select_db="SELECT * FROM mf_prog_users WHERE username='".$username."'";
$stmt	= $link->prepare($select_db);
$stmt->execute();
$row = $stmt->fetchAll();

if (count($row) == 0) {
    $ret['msg']="Invalid username or password."; 
    $ret['status'] = false;
}
else {
    $select_db="SELECT * FROM mf_prog_users WHERE username='".$username."'";
    $stmt	= $link->prepare($select_db);
    $stmt->execute();
    while($rs = $stmt->fetch()){
        
        $recid_select=$rs['recid'];
        $password_select=$rs['password'];
        $act_status = $rs['act_status']; // Get account status

        if($password !== $password_select){
            $ret['msg']="Invalid username or password.";        
            $ret['status'] = false;
        }
        else if($password == $password_select){
            
            // Check if account status is FA (For Approval)
            if($act_status == 'FA'){
                $ret['msg']="Your account is under pending approval. Wait for the admin to approve your account.";
                $ret['status'] = false;
            }
            else {
                // Account is approved, proceed with login
                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;
                $_SESSION["usertype"] = $rs['usertype'];
                $_SESSION["usr_recid"] = $rs['recid'];
                $_SESSION["usr_id"] = $rs['userid'];
                $ret['msg']="successful";
                $ret['userlvl']=$rs["usertype"];
                $ret['status'] = true;
            }
        }
    }
}

header('Content-Type: application/json');
echo json_encode($ret);
?>