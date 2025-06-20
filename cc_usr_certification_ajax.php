<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('resources/db_init.php');
require_once('resources/lx2.pdodb.php');
require_once("resources/stdfunc100.php");
require_once('resources/connect4.php');

session_start();

// Initialize response array
$ret = array(
    'msg' => '',
    'user' => '',
    'userlvl' => '',
    'recid' => '',
    'status' => true,
    'html' => '',
    'html2' => '',
    'time_fromto' => '',
    'retEdit' => array()
);

// Get today's date
$date_today = date('Y-m-d');
$date_today_desc = date('F d, Y', strtotime($date_today));

// Prepare the data for insertion
$pro_cert = array(
    "userid" => $_SESSION['usr_id'],
    "reason" => $_POST['reason_req'],
    "status" => "PRP",
    "status_desc" => "Preparing",
    "control_number" => $_POST['control_number'],
    'date_claimed' => $date_today,
    'date_claimed_desc' => $date_today_desc
);

try {


    $sql = "INSERT INTO pro_cert_table (userid, reason, status, status_desc, control_number, date_claimed, date_claimed_desc)
            VALUES (:userid, :reason, :status, :status_desc, :control_number, :date_claimed, :date_claimed_desc)";
    
    $stmt = $link->prepare($sql);

    // Bind the parameters to the SQL statement
    $stmt->bindParam(':userid', $pro_cert['userid']);
    $stmt->bindParam(':reason', $pro_cert['reason']);
    $stmt->bindParam(':status', $pro_cert['status']);
    $stmt->bindParam(':status_desc', $pro_cert['status_desc']);
    $stmt->bindParam(':control_number', $pro_cert['control_number']);
    $stmt->bindParam(':date_claimed', $pro_cert['date_claimed']);
    $stmt->bindParam(':date_claimed_desc', $pro_cert['date_claimed_desc']);

    // Execute the query
    $stmt->execute();

    // Optionally handle success or return the last inserted ID
    $ret['msg'] = 'Record successfully inserted.';
} catch (PDOException $e) {
    // Handle error if the query fails
    $ret['status'] = false;
    $ret['msg'] = 'Error: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($ret);
?>
