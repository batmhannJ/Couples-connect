<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('resources/db_init.php');
require_once('resources/lx2.pdodb.php');
require_once('resources/connect4.php');

// Start the session to track the user
session_start();

// Get the actual user ID from the session or database
$user_id = null;
$usertype = $_SESSION['usertype'] ?? 'DSK';

// Try to get user_id from session first
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else if (isset($_SESSION['userid'])) {
    // Sometimes it might be stored as 'userid'
    $user_id = $_SESSION['userid'];
} else if (isset($_SESSION['username'])) {
    // If we have username, get the user_id from database
    try {
        $stmt = $link->prepare("SELECT userid FROM mf_prog_users WHERE username = ?");
        $stmt->execute([$_SESSION['username']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $user_id = $result['userid'];
            $_SESSION['user_id'] = $user_id; // Store it for future use
        }
    } catch (PDOException $e) {
        error_log("Error getting user_id from username: " . $e->getMessage());
    }
}

// If still no user_id, set as guest but log this issue
if (!$user_id) {
    $user_id = 'guest';
    error_log("Warning: No user_id found in session. Available session data: " . print_r($_SESSION, true));
}

// Generate or get session ID for this chat session
if (!isset($_SESSION['chat_session_id'])) {
    $_SESSION['chat_session_id'] = uniqid('chat_', true);
}
$session_id = $_SESSION['chat_session_id'];

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
        // Debug logging
        error_log("POST request received");
        error_log("POST data: " . print_r($_POST, true));
        error_log("Session data: " . print_r($_SESSION, true));
        
        $message = $_POST['message'] ?? '';
        $sender = $_POST['sender'] ?? '';  // 'user' or 'bot'

        // Debug logging
        error_log("Message: " . $message);
        error_log("Sender: " . $sender);
        error_log("User ID: " . $user_id);
        error_log("Session ID: " . $session_id);

        // Save the message in the session under the user_id
        $_SESSION['chat_history'][$user_id][] = ['sender' => $sender, 'message' => $message];

        // If this is a user message (personal question), save it to database for staff to respond
        if ($sender === 'user' && !empty($message)) {
            error_log("Attempting to save user message to database");
            
            try {
                // Check if user_messages table exists, if not create it
                $checkTable = $link->query("SHOW TABLES LIKE 'user_messages'");
                if ($checkTable->rowCount() == 0) {
                    error_log("Creating user_messages table");
                    // Create the table if it doesn't exist
                    $createTableSQL = "
                        CREATE TABLE user_messages (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            user_id VARCHAR(100) NOT NULL,
                            message TEXT NOT NULL,
                            sender ENUM('user', 'bot', 'staff') NOT NULL,
                            session_id VARCHAR(255),
                            usertype VARCHAR(10),
                            is_answered TINYINT(1) DEFAULT 0,
                            answered_by VARCHAR(100) NULL,
                            staff_response TEXT NULL,
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            answered_at TIMESTAMP NULL,
                            INDEX idx_user_id (user_id),
                            INDEX idx_session (session_id),
                            INDEX idx_unanswered (is_answered)
                        )
                    ";
                    $link->exec($createTableSQL);
                    error_log("user_messages table created successfully");
                }

                // Insert user message into database
                $insertStmt = $link->prepare("
                    INSERT INTO user_messages (user_id, message, sender, session_id, usertype, created_at) 
                    VALUES (?, ?, ?, ?, ?, NOW())
                ");
                $result = $insertStmt->execute([$user_id, $message, $sender, $session_id, $usertype]);
                
                if ($result) {
                    $insertId = $link->lastInsertId();
                    error_log("User message saved successfully to database with ID: " . $insertId);
                    
                    // Verify the insert by selecting it back
                    $verifyStmt = $link->prepare("SELECT * FROM user_messages WHERE id = ?");
                    $verifyStmt->execute([$insertId]);
                    $insertedData = $verifyStmt->fetch(PDO::FETCH_ASSOC);
                    error_log("Inserted data verification: " . print_r($insertedData, true));
                    
                } else {
                    error_log("Failed to save user message");
                    error_log("Error info: " . print_r($insertStmt->errorInfo(), true));
                }

                // Also create/update chat sessions table if it doesn't exist
                $checkSessionTable = $link->query("SHOW TABLES LIKE 'chat_sessions'");
                if ($checkSessionTable->rowCount() == 0) {
                    error_log("Creating chat_sessions table");
                    $createSessionTableSQL = "
                        CREATE TABLE chat_sessions (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            user_id VARCHAR(100) NOT NULL,
                            session_id VARCHAR(255) UNIQUE NOT NULL,
                            usertype VARCHAR(10) NOT NULL,
                            started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            INDEX idx_user_session (user_id, session_id)
                        )
                    ";
                    $link->exec($createSessionTableSQL);
                    error_log("chat_sessions table created successfully");
                }

                // Insert/Update chat session
                $sessionStmt = $link->prepare("
                    INSERT INTO chat_sessions (user_id, session_id, usertype, started_at, last_activity) 
                    VALUES (?, ?, ?, NOW(), NOW())
                    ON DUPLICATE KEY UPDATE last_activity = NOW()
                ");
                $sessionResult = $sessionStmt->execute([$user_id, $session_id, $usertype]);
                
                if ($sessionResult) {
                    error_log("Chat session saved/updated successfully");
                } else {
                    error_log("Failed to save/update chat session");
                    error_log("Session error info: " . print_r($sessionStmt->errorInfo(), true));
                }

            } catch (PDOException $e) {
                // Log error but don't stop the chat functionality
                error_log("Database error saving user message: " . $e->getMessage());
                error_log("Stack trace: " . $e->getTraceAsString());
            }
        }

        echo json_encode([
            'status' => 'success', 
            'debug' => [
                'message' => $message,
                'sender' => $sender,
                'user_id' => $user_id,
                'session_id' => $session_id,
                'usertype' => $usertype,
                'saved_to_db' => ($sender === 'user' && !empty($message)),
                'session_data' => $_SESSION
            ]
        ]);
        exit;
    }

    // For GET requests, also load any staff responses from database
    $staff_responses = [];
    try {
        // Check if table exists before querying
        $checkTable = $link->query("SHOW TABLES LIKE 'user_messages'");
        if ($checkTable->rowCount() > 0) {
            // Fetch ALL messages for this session (both user and staff responses)
            $responseStmt = $link->prepare("
                SELECT message, sender, staff_response, created_at, answered_at
                FROM user_messages 
                WHERE session_id = ? 
                ORDER BY created_at ASC
            ");
            $responseStmt->execute([$session_id]);
            $all_messages = $responseStmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Process messages and add staff responses to chat history
            foreach ($all_messages as $msg) {
                // Check if this user message already exists in session
                $user_msg_exists = false;
                if ($msg['sender'] === 'user') {
                    foreach ($_SESSION['chat_history'][$user_id] as $existing) {
                        if ($existing['message'] === $msg['message'] && $existing['sender'] === 'user') {
                            $user_msg_exists = true;
                            break;
                        }
                    }
                    
                    // Add user message if not exists
                    if (!$user_msg_exists) {
                        $_SESSION['chat_history'][$user_id][] = [
                            'sender' => 'user', 
                            'message' => $msg['message']
                        ];
                    }
                }
                
                // Add staff response if it exists and not already in chat history
                if (!empty($msg['staff_response'])) {
                    $staff_response_exists = false;
                    foreach ($_SESSION['chat_history'][$user_id] as $existing) {
                        if ($existing['message'] === $msg['staff_response'] && $existing['sender'] === 'staff') {
                            $staff_response_exists = true;
                            break;
                        }
                    }
                    
                    if (!$staff_response_exists) {
                        $_SESSION['chat_history'][$user_id][] = [
                            'sender' => 'staff', 
                            'message' => $msg['staff_response']
                        ];
                        
                        // Also add to staff_responses array for backward compatibility
                        $staff_responses[] = [
                            'message' => $msg['staff_response'],
                            'sender' => 'staff',
                            'created_at' => $msg['answered_at'] ?: $msg['created_at']
                        ];
                    }
                }
            }
        }
    } catch (PDOException $e) {
        error_log("Database error fetching staff responses: " . $e->getMessage());
    }

    echo json_encode([
        'questions' => $questions,
        'chat_history' => $_SESSION['chat_history'][$user_id], 
        'staff_responses' => $staff_responses,
        'debug_info' => [
            'user_id' => $user_id,
            'session_id' => $session_id,
            'usertype' => $usertype,
            'session_keys' => array_keys($_SESSION)
        ]
    ]);
} catch (PDOException $e) {
    error_log("Database connection error: " . $e->getMessage());
    echo json_encode(["error" => "Connection failed: " . $e->getMessage()]);
}
?>