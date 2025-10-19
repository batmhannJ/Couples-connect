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

// Get user information before deleting/archiving
$select_sql = "SELECT userid, email FROM mf_prog_users WHERE recid = ?";
$stmt_select = $link->prepare($select_sql);
$stmt_select->execute([$recid]);
$user_data = $stmt_select->fetch(PDO::FETCH_ASSOC);

if ($user_data) {
    // Option 1: Delete the declined record completely
    // This allows them to register fresh with the same email
    $delete_sql = "DELETE FROM mf_prog_users WHERE recid = ?";
    $stmt_delete = $link->prepare($delete_sql);
    
    if ($stmt_delete->execute([$recid])) {
        // Also delete related records if any (couples info, etc.)
        $delete_couples = "DELETE FROM ext_couples_accountinfo WHERE userid = ?";
        $stmt_couples = $link->prepare($delete_couples);
        $stmt_couples->execute([$user_data['userid']]);
        
        $ret['status'] = true;
        $ret['msg'] = 'Your previous application has been cleared. You will be redirected to registration.';
        $ret['redirect'] = true;
        $ret['redirect_url'] = 'register_cc.php';
    } else {
        $ret['status'] = false;
        $ret['msg'] = 'Failed to process reapplication. Please try again.';
        $ret['redirect'] = false;
    }
} else {
    $ret['status'] = false;
    $ret['msg'] = 'User record not found.';
    $ret['redirect'] = false;
}

header('Content-Type: application/json');
echo json_encode($ret);
?>