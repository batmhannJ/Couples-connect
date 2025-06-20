<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('resources/db_init.php');
require_once('resources/lx2.pdodb.php');
require_once('resources/connect4.php');

// Get question id from request
$questionId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Create a PDO connection
try {
    // Query to fetch the answer for the question with the given ID
    $stmt = $link->prepare("SELECT answers FROM tbl_answers WHERE question_id = :question_id");
    $stmt->bindParam(':question_id', $questionId, PDO::PARAM_INT);
    $stmt->execute();
    
    // Fetch the answer
    $answer = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Return the answer as JSON
    if ($answer) {
        echo json_encode(['answer' => $answer['answer']]);
    } else {
        echo json_encode(['answer' => 'Sorry, I don\'t have an answer for that.']);
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

header('Content-Type: application/json');
?>
