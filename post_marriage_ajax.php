<?php
ob_start(); // Start output buffering
require "includes/cc_header.php";
session_start();

$response = array('success' => false, 'message' => 'Unknown error');

try {
    // Check if user is logged in
    if (!isset($_SESSION['usr_id'])) {
        throw new Exception('User not logged in');
    }

    if (!isset($_POST['event_action'])) {
        throw new Exception('No action specified');
    }
    
    $event_action = $_POST['event_action'];
    
    switch($event_action) {
        case 'changeDate':
            $date = $_POST['date'] ?? '';
            $counselorid = $_POST['counselorid'] ?? '';
            $ext_recid = $_POST['ext_recid'] ?? '';
            
            if (empty($date) || empty($counselorid)) {
                throw new Exception('Missing date or counselor information');
            }
            
            // Get available times for the selected date
            $select_times = "SELECT ext_appointment_info.time_from, ext_appointment_info.time_to, 
                           ext_appointment_info.slots_avail, ext_appointment_info.recid
                           FROM ext_appointment_info 
                           INNER JOIN mf_appointment_info ON ext_appointment_info.appointment_info_id = mf_appointment_info.appointment_info_id 
                           WHERE ext_appointment_info.clinic_date = ? 
                           AND mf_appointment_info.sched_type = 'PMC'
                           AND mf_appointment_info.userid = ?";
            
            $stmt_times = $link->prepare($select_times);
            $stmt_times->execute(array($date, $counselorid));
            
            $times = array();
            $slots_available = 0;
            
            while($row_times = $stmt_times->fetch()) {
                $time_display = $row_times['time_from'] . ' - ' . $row_times['time_to'];
                $times[] = array(
                    'value' => $time_display,
                    'text' => $time_display,
                    'recid' => $row_times['recid']
                );
                $slots_available = $row_times['slots_avail'];
            }
            
            $response = array(
                'success' => true,
                'times' => $times,
                'slots_available' => $slots_available
            );
            break;
            
        case 'book_now':
    $date = trim($_POST['date'] ?? '');
    $counselorid = trim($_POST['counselorid'] ?? '');
    $ext_recid = trim($_POST['ext_recid'] ?? '');
    $timeline = trim($_POST['timeline'] ?? '');
    $venue = trim($_POST['venue_hidden'] ?? '');
    $userid = $_SESSION['usr_id'];
    
    // Validate all required fields
    if (empty($date)) throw new Exception('Date is required');
    if (empty($counselorid)) throw new Exception('Counselor ID is required');
    if (empty($ext_recid)) throw new Exception('Appointment record ID is required');
    if (empty($timeline)) throw new Exception('Timeline is required');
    if (empty($venue)) throw new Exception('Venue is required');
    
    // Start transaction
    $link->beginTransaction();
    
    // Check if slots are still available
    $check_slots = "SELECT slots_avail FROM ext_appointment_info WHERE recid = ?";
    $stmt_slots = $link->prepare($check_slots);
    $stmt_slots->execute(array($ext_recid));
    $current_slots = $stmt_slots->fetch();
    
    if (!$current_slots || $current_slots['slots_avail'] <= 0) {
        throw new Exception("No slots available for this time");
    }
    
    // Check if user already has a PMC booking to update
    $check_pmc = "SELECT recid, usermeiformid FROM pro_meiform WHERE userid = ? AND status = 'PMC'";
    $stmt_pmc = $link->prepare($check_pmc);
    $stmt_pmc->execute(array($userid));
    $pmc_result = $stmt_pmc->fetch();
    
    if ($pmc_result) {
        // User has PMC booking, update it to POST
        $existing_usermeiformid = $pmc_result['usermeiformid'];
        $existing_recid = $pmc_result['recid'];
        
        // Update status to POST and counselorid
        $update_meiform = "UPDATE pro_meiform SET status = 'POST', counselorid = ? WHERE recid = ?";
        $stmt_update_meiform = $link->prepare($update_meiform);
        
        if (!$stmt_update_meiform->execute(array($counselorid, $existing_recid))) {
            throw new Exception("Failed to update booking record");
        }
        
        // Insert into ext_mf_meiform using existing usermeiformid
        $insert_ext_meiform = "INSERT INTO ext_mf_meiform (meiformid, date, venue, from_to) VALUES (?, ?, ?, ?)";
        $stmt_ext = $link->prepare($insert_ext_meiform);
        
        if (!$stmt_ext->execute(array($existing_usermeiformid, $date, $venue, $timeline))) {
            throw new Exception("Failed to create extended booking record");
        }
        
        $next_usermeiformid = $existing_usermeiformid;
        
    } else {
        // Check if user already has an active POST booking
        $check_existing = "SELECT COUNT(*) as count FROM pro_meiform WHERE userid = ? AND status = 'POST'";
        $stmt_check = $link->prepare($check_existing);
        $stmt_check->execute(array($userid));
        $existing_result = $stmt_check->fetch();
        
        if ($existing_result['count'] > 0) {
            throw new Exception("You already have an active POST booking");
        }
        
        // Get the next usermeiformid
        $get_max_usermeiformid = "SELECT MAX(CAST(SUBSTRING(usermeiformid, 5) AS UNSIGNED)) as max_id FROM pro_meiform WHERE usermeiformid LIKE 'UMF-%'";
        $stmt_max = $link->prepare($get_max_usermeiformid);
        $stmt_max->execute();
        $max_result = $stmt_max->fetch();
        
        $next_number = 1;
        if ($max_result && $max_result['max_id']) {
            $next_number = $max_result['max_id'] + 1;
        }
        
        $next_usermeiformid = 'UMF-' . str_pad($next_number, 5, '0', STR_PAD_LEFT);
        
        // Insert into pro_meiform with generated usermeiformid
        $insert_meiform = "INSERT INTO pro_meiform (userid, counselorid, status, usermeiformid) VALUES (?, ?, 'POST', ?)";
        $stmt_insert = $link->prepare($insert_meiform);
        
        if (!$stmt_insert->execute(array($userid, $counselorid, $next_usermeiformid))) {
            throw new Exception("Failed to create booking record");
        }
        
        $recid = $link->lastInsertId();
        
        if (!$recid) {
            throw new Exception("Failed to get booking ID");
        }
        
        // Insert into ext_mf_meiform using the generated usermeiformid
        $insert_ext_meiform = "INSERT INTO ext_mf_meiform (meiformid, date, venue, from_to) VALUES (?, ?, ?, ?)";
        $stmt_ext = $link->prepare($insert_ext_meiform);
        
        if (!$stmt_ext->execute(array($next_usermeiformid, $date, $venue, $timeline))) {
            throw new Exception("Failed to create extended booking record");
        }
    }
    
    // Decrease available slots
    $update_slots = "UPDATE ext_appointment_info SET slots_avail = GREATEST(slots_avail - 1, 0) WHERE recid = ?";
    $stmt_update = $link->prepare($update_slots);
    
    if (!$stmt_update->execute(array($ext_recid))) {
        throw new Exception("Failed to update appointment slots");
    }
    
    // Update act_status to POST in mf_prog_users
    $update_act_status = "UPDATE mf_prog_users SET act_status = 'POST' WHERE userid = ?";
    $stmt_act_status = $link->prepare($update_act_status);
    
    if (!$stmt_act_status->execute(array($userid))) {
        throw new Exception("Failed to update user progress status");
    }
    
    // Commit transaction
    $link->commit();
    
    $response = array(
        'success' => true,
        'message' => 'Post Marriage Counseling booking successful!',
        'usermeiformid' => $next_usermeiformid
    );
    break;
            
        case 'cancel_booking':
            $usermeiformid = trim($_POST['meiformid_post'] ?? '');
            $userid = $_SESSION['usr_id'];
            
            if (empty($usermeiformid)) {
                throw new Exception('Missing booking ID');
            }
            
            // Start transaction
            $link->beginTransaction();
            
            // Get booking details
            $select_booking = "SELECT pro_meiform.counselorid, ext_mf_meiform.date, ext_mf_meiform.venue, ext_mf_meiform.from_to
                             FROM pro_meiform 
                             INNER JOIN ext_mf_meiform ON pro_meiform.usermeiformid = ext_mf_meiform.meiformid 
                             WHERE pro_meiform.usermeiformid = ? AND pro_meiform.status = 'POST' AND pro_meiform.userid = ?";
            $stmt_booking = $link->prepare($select_booking);
            $stmt_booking->execute(array($usermeiformid, $userid));
            $booking_details = $stmt_booking->fetch();
            
            if (!$booking_details) {
                throw new Exception("Booking not found or access denied");
            }
            
            // Find the corresponding appointment to restore slots
            $find_appointment = "SELECT ext_appointment_info.recid 
                               FROM ext_appointment_info 
                               INNER JOIN mf_appointment_info ON ext_appointment_info.appointment_info_id = mf_appointment_info.appointment_info_id 
                               INNER JOIN mf_venue ON ext_appointment_info.venue_id = mf_venue.venue_id
                               WHERE ext_appointment_info.clinic_date = ? 
                               AND mf_appointment_info.userid = ? 
                               AND mf_appointment_info.sched_type = 'PMC'
                               AND mf_venue.venue = ?
                               AND CONCAT(ext_appointment_info.time_from, ' - ', ext_appointment_info.time_to) = ?";
            
            $stmt_find = $link->prepare($find_appointment);
            $stmt_find->execute(array(
                $booking_details['date'], 
                $booking_details['counselorid'], 
                $booking_details['venue'],
                $booking_details['from_to']
            ));
            $appointment = $stmt_find->fetch();
            
            // Restore the slot if appointment found
            if ($appointment) {
                $restore_slot = "UPDATE ext_appointment_info SET slots_avail = slots_avail + 1 WHERE recid = ?";
                $stmt_restore = $link->prepare($restore_slot);
                $stmt_restore->execute(array($appointment['recid']));
            }
            
            // Delete extended booking record
            $delete_ext = "DELETE FROM ext_mf_meiform WHERE meiformid = ?";
            $stmt_delete_ext = $link->prepare($delete_ext);
            $stmt_delete_ext->execute(array($usermeiformid));
            
            // Delete main booking record
            $delete_pro = "DELETE FROM pro_meiform WHERE usermeiformid = ? AND status = 'POST' AND userid = ?";
            $stmt_delete_pro = $link->prepare($delete_pro);
            $stmt_delete_pro->execute(array($usermeiformid, $userid));
            
            // Commit transaction
            $link->commit();
            
            $response = array(
                'success' => true,
                'message' => 'Booking cancelled successfully!'
            );
            break;
            
        default:
            throw new Exception('Invalid action: ' . $event_action);
    }
    
} catch (Exception $e) {
    // Rollback transaction if active
    if ($link && $link->inTransaction()) {
        $link->rollback();
    }
    
    $response = array(
        'success' => false,
        'message' => $e->getMessage()
    );
    
    // Log error for debugging
    error_log("Post Marriage AJAX Error: " . $e->getMessage());
}

// Clean any output buffer
ob_clean();

// Set proper JSON header
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');

// Output JSON response
echo json_encode($response, JSON_UNESCAPED_UNICODE);

// Ensure no additional output
exit;
?>