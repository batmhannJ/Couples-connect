<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('resources/db_init.php');
require_once('resources/lx2.pdodb.php');
require_once('resources/connect4.php');

// Start the session to track the user
session_start();

// Assuming the user_id is passed or already set (in a real app, this would come from the login system)
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'guest';  // Replace 'guest' if user_id is not set

// Initialize chat history for the user if it doesn't exist
if (!isset($_SESSION['chat_history'][$user_id])) {
    $_SESSION['chat_history'][$user_id] = [];
}

// Fetch questions from the database
try {
    $stmt = $link->query("SELECT * FROM tbl_questions");
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Check if a message is posted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $message = $_POST['message'];
        $sender = $_POST['sender'];  // 'user' or 'bot'

        // Save the message in the session under the user_id
        $_SESSION['chat_history'][$user_id][] = ['sender' => $sender, 'message' => $message];

        echo json_encode(['status' => 'success']);
        exit;
    }

    // Return the chat history and questions
    echo json_encode([
        'questions' => $questions,
        'chat_history' => $_SESSION['chat_history'][$user_id]  // Send chat history specific to the user
    ]);
} catch (PDOException $e) {
    echo json_encode(["error" => "Connection failed: " . $e->getMessage()]);
}
?>
