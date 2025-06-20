<?php
// reapply_handler.php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('resources/db_init.php');
require_once('resources/lx2.pdodb.php');
require_once('resources/connect4.php');

$recid = $_POST['recid'];
$ret = array();

// Update the account status back to pending (FA) for reapplication
$update_sql = "UPDATE mf_prog_users SET act_status = 'FA', remarks = 'Reapplied for approval' WHERE recid = ?";
$stmt = $link->prepare($update_sql);

if ($stmt->execute([$recid])) {
    $ret['status'] = true;
    $ret['msg'] = 'Your reapplication has been submitted successfully. Please wait for admin approval.';
} else {
    $ret['status'] = false;
    $ret['msg'] = 'Failed to submit reapplication. Please try again.';
}

header('Content-Type: application/json');
echo json_encode($ret);
?>