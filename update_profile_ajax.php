<?php
// Start session and database connection WITHOUT including cc_header.php
session_start();

// Database connection (replace with your actual database connection details)
try {
    $link = new PDO("mysql:host=localhost;dbname=couplesconnect_db", "root", "");
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit();
}

// Set content type to JSON
header('Content-Type: application/json');

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['usr_recid'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

try {
    // Sanitize and validate input
    $fname = trim($_POST['fname'] ?? '');
    $mname = trim($_POST['mname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $sex = trim($_POST['sex'] ?? '');
    $bday = trim($_POST['bday'] ?? '');
    $cellphone = trim($_POST['cellphone'] ?? '');
    $municipality = trim($_POST['municipality'] ?? '');

    // Basic validation
    if (empty($fname)) {
        echo json_encode(["status" => "error", "message" => "First name is required"]);
        exit();
    }

    if (empty($lname)) {
        echo json_encode(["status" => "error", "message" => "Last name is required"]);
        exit();
    }

    if (empty($email)) {
        echo json_encode(["status" => "error", "message" => "Email is required"]);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Invalid email format"]);
        exit();
    }

    if (empty($sex)) {
        echo json_encode(["status" => "error", "message" => "Gender is required"]);
        exit();
    }

    // Update user profile
    $update_sql = "UPDATE mf_prog_users 
                   SET partner1_fname = :fname,
                       partner1_mname = :mname,
                       partner1_lname = :lname,
                       email = :email,
                       partner1_sex = :sex,
                       partner1_bday = :bday,
                       partner1_cellphone = :cellphone,
                       partner1_municipality = :municipality
                   WHERE recid = :recid";
    
    $stmt = $link->prepare($update_sql);
    $stmt->bindParam(':fname', $fname);
    $stmt->bindParam(':mname', $mname);
    $stmt->bindParam(':lname', $lname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':sex', $sex);
    $stmt->bindParam(':bday', $bday);
    $stmt->bindParam(':cellphone', $cellphone);
    $stmt->bindParam(':municipality', $municipality);
    $stmt->bindParam(':recid', $_SESSION['usr_recid'], PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success", 
            "message" => "Profile updated successfully!"
        ]);
    } else {
        echo json_encode([
            "status" => "error", 
            "message" => "Failed to update profile. Please try again."
        ]);
    }

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error", 
        "message" => "Database error occurred. Please try again later."
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error", 
        "message" => "An unexpected error occurred. Please try again."
    ]);
}

exit();
?>