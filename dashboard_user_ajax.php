<?php
session_start();
require_once('resources/db_init.php');
require_once('resources/connect4.php');

// Remove ALL PHPMailer related code
// NO MORE: use PHPMailer\PHPMailer\PHPMailer;
// NO MORE: require 'phpmailer/src/Exception.php';

header('Content-Type: application/json');

if(isset($_POST['email_subject']) && isset($_POST['email_remarks'])) {
    
    // Get user info
    $user_id = $_SESSION['usr_id'];
    $subject = trim($_POST['email_subject']);
    $message = trim($_POST['email_remarks']);
    
    // Validation
    if(empty($subject) || empty($message)) {
        $response = array('status' => false, 'message' => 'Please fill in all fields');
        echo json_encode($response);
        exit;
    }
    
    try {
        // Insert feedback into database ONLY
        $insert_feedback = "INSERT INTO user_feedback (user_id, subject, message, status, date_submitted) VALUES (?, ?, ?, 'unread', NOW())";
        $stmt = $link->prepare($insert_feedback);
        $result = $stmt->execute(array($user_id, $subject, $message));
        
        if($result) {
            $response = array('status' => true, 'message' => 'Feedback submitted successfully');
        } else {
            $response = array('status' => false, 'message' => 'Failed to submit feedback. Please try again.');
        }
        
    } catch(Exception $e) {
        $response = array('status' => false, 'message' => 'Database error occurred. Please try again.');
        error_log("Feedback submission error: " . $e->getMessage());
    }
    
    echo json_encode($response);
    exit;
}

// Return error if no valid request
$response = array('status' => false, 'message' => 'Invalid request');
echo json_encode($response);
?>