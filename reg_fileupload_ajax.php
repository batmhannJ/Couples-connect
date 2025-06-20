<?php
// reg_fileupload_ajax.php - Final step: Save all data to mf_prog_users
require "includes/cc_header.php";

if ($_POST) {
    try {
        // Start transaction
        $link->beginTransaction();
        
        // Get the next userid by finding the last one and incrementing
        $last_userid_query = "SELECT userid FROM mf_prog_users WHERE userid LIKE 'USR-%' ORDER BY userid DESC LIMIT 1";
        $last_result = $link->query($last_userid_query);
        
        if ($last_result && $last_result->rowCount() > 0) {
            $last_row = $last_result->fetch(PDO::FETCH_ASSOC);
            $last_userid = $last_row['userid'];
            // Extract number part (e.g., USR-00064 -> 00064)
            $last_number = intval(substr($last_userid, 4));
            $new_number = $last_number + 1;
            $userid = 'USR-' . str_pad($new_number, 5, '0', STR_PAD_LEFT);
        } else {
            // If no existing records, start with USR-00001
            $userid = 'USR-00001';
        }
        
        // Get all form data
        $reg_email = trim($_POST['reg_email_h']);
        $reg_password = $_POST['reg_pwd_h']; // Plain text password, no encryption
        $secondary_email = trim($_POST['confirm_email_h']);
        
        // Partner 1 data
        $first_name = trim($_POST['first_name_h']);
        $middle_name = trim($_POST['middle_name_h']);
        $last_name = trim($_POST['last_name_h']);
        $sex = $_POST['sex_h'];
        $birthday = $_POST['bday_h'];
        $country = $_POST['country_h'];
        $municipality = $_POST['municipality_h'];
        $occupation = $_POST['occupation_h'];
        $cellphone = $_POST['cellphone_number_h'];
        
        // Partner 2 data
        $first_name2 = trim($_POST['first_name2_h']);
        $middle_name2 = trim($_POST['middle_name2_h']);
        $last_name2 = trim($_POST['last_name2_h']);
        $sex2 = $_POST['sex2_h'];
        $birthday2 = $_POST['bday2_h'];
        $country2 = $_POST['country2_h'];
        $municipality2 = $_POST['municipality2_h'];
        $occupation2 = $_POST['occupation2_h'];
        $cellphone2 = $_POST['cellphone_number2_h'];
        
        // PMOC data
        $is_pmoc = $_POST['is_pmoc'];
        $justification = trim($_POST['justification']);
        
        // Handle file uploads
        $doc_link = '';
        $crm_link = '';
        
        if (isset($_FILES['file_1']) && $_FILES['file_1']['error'] == 0) {
            $upload_dir = 'uploads/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_extension = pathinfo($_FILES['file_1']['name'], PATHINFO_EXTENSION);
            $doc_filename = $userid . '_doc_' . time() . '.' . $file_extension;
            $doc_path = $upload_dir . $doc_filename;
            
            if (move_uploaded_file($_FILES['file_1']['tmp_name'], $doc_path)) {
                $doc_link = $doc_path;
            }
        }
        
        if (isset($_FILES['file_2']) && $_FILES['file_2']['error'] == 0 && $is_pmoc == 'Y') {
            $upload_dir = 'uploads/pmoc/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_extension = pathinfo($_FILES['file_2']['name'], PATHINFO_EXTENSION);
            $crm_filename = $userid . '_pmoc_' . time() . '.' . $file_extension;
            $crm_path = $upload_dir . $crm_filename;
            
            if (move_uploaded_file($_FILES['file_2']['tmp_name'], $crm_path)) {
                $crm_link = $crm_path;
            }
        }
        
        // Prepare SQL statement for insertion
        $insert_sql = "INSERT INTO mf_prog_users (
            userid, username, email, secondary_email, usertype, password, 
            act_status, cert_status, cert_desc, date_requested, date_requested_desc,
            pmoc_online, doc_link, crm_link, justification, remarks, chk_by, print_status,
            partner1_fname, partner1_mname, partner1_lname, partner1_sex, partner1_bday,
            partner1_country, partner1_municipality, partner1_occupation, partner1_cellphone,
            partner2_fname, partner2_mname, partner2_lname, partner2_sex, partner2_bday,
            partner2_country, partner2_municipality, partner2_occupation, partner2_cellphone
        ) VALUES (
            ?, ?, ?, ?, ?, ?, 
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?
        )";
        
        $stmt = $link->prepare($insert_sql);
        
        // Create username from partner 1's name
        $username = $reg_email;
        
        // Execute the statement
        $stmt->execute([
            $userid,                           // userid (auto-incremented format)
            $username,                         // username
            $reg_email,                       // email
            $secondary_email,                 // secondary_email
            'USR',                           // usertype
            $reg_password,                    // password (plain text)
            'FA',                             // act_status (For Approval)
            '',                        // cert_status
            'Pending verification',           // cert_desc
            date('Y-m-d'),                   // date_requested
            date('Y-m-d H:i:s'),             // date_requested_desc
            $is_pmoc,                        // pmoc_online
            $doc_link,                       // doc_link
            $crm_link,                       // crm_link
            $justification,                  // justification
            'New registration pending approval', // remarks
            '',                              // chk_by
            0,                               // print_status
            // Partner 1 data
            $first_name,                     // partner1_fname
            $middle_name,                    // partner1_mname
            $last_name,                      // partner1_lname
            $sex,                            // partner1_sex
            $birthday,                       // partner1_bday
            $country,                        // partner1_country
            $municipality,                   // partner1_municipality
            $occupation,                     // partner1_occupation
            $cellphone,                      // partner1_cellphone
            // Partner 2 data
            $first_name2,                    // partner2_fname
            $middle_name2,                   // partner2_mname
            $last_name2,                     // partner2_lname
            $sex2,                           // partner2_sex
            $birthday2,                      // partner2_bday
            $country2,                       // partner2_country
            $municipality2,                  // partner2_municipality
            $occupation2,                    // partner2_occupation
            $cellphone2                      // partner2_cellphone
        ]);
        
        // Commit transaction
        $link->commit();
        
        // Send success response
        echo json_encode([
            'status' => true, 
            'msg' => 'Registration successful! Your application is pending approval.',
            'userid' => $userid
        ]);
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $link->rollback();
        
        echo json_encode([
            'status' => false, 
            'msg' => 'Registration failed: ' . $e->getMessage()
        ]);
    }
}
?>