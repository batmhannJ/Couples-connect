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
$ret['show_reapply'] = false; // Add flag for reapply button

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
        $remarks = $rs['remarks']; // Get remarks

        if($password !== $password_select){
            $ret['msg']="Invalid username or password.";        
            $ret['status'] = false;
        }
        else if($password == $password_select){
            
            // Check account status
            if($act_status == 'FA'){
                $ret['msg']="Your account is under pending approval. Wait for the admin to approve your account.";
                $ret['status'] = false;
            }
            else if($act_status == 'DEC'){
                // Account has been declined, show remarks and enable reapply
                $decline_reason = !empty($remarks) ? $remarks : "No reason provided.";
                $ret['msg']="Your account has been declined. Reason: " . $decline_reason;
                $ret['status'] = false;
                $ret['show_reapply'] = true; // Enable reapply button
                $ret['recid'] = $recid_select; // Pass recid for reapply functionality
            }
            else {
                // Account is approved (APR status), proceed with index.php
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
