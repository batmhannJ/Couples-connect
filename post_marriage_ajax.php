<?php
require "includes/cc_header.php";

$response = array();

if(isset($_POST['event_action'])) {
    $event_action = $_POST['event_action'];
    
    switch($event_action) {
        case 'changeDate':
            $date = $_POST['date'];
            $counselorid = $_POST['counselorid'];
            $ext_recid = $_POST['ext_recid'];
            
            // Get available times for the selected date
            $select_times = "SELECT ext_appointment_info.time_from, ext_appointment_info.time_to, 
                           ext_appointment_info.slots_avail, ext_appointment_info.recid
                           FROM ext_appointment_info 
                           LEFT JOIN mf_appointment_info ON ext_appointment_info.appointment_info_id = mf_appointment_info.appointment_info_id 
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
                    'text' => $time_display
                );
                
                $slots_available = $row_times['slots_avail'];
            }
            
            $response['success'] = true;
            $response['times'] = $times;
            $response['slots_available'] = $slots_available;
            break;
            
        case 'book_now':
            $date = $_POST['date'];
            $counselorid = $_POST['counselorid'];
            $ext_recid = $_POST['ext_recid'];
            $timeline = $_POST['timeline'];
            $venue = $_POST['venue_hidden'];
            $userid = $_SESSION['usr_id'];
            
            try {
                // Start transaction
                $link->beginTransaction();
                
                // Insert into pro_meiform with status 'PMC' (corrected from 'POST')
                $insert_meiform = "INSERT INTO pro_meiform (userid, counselorid, status, date_added) VALUES (?, ?, 'PST', NOW())";
                $stmt_insert = $link->prepare($insert_meiform);
                $stmt_insert->execute(array($userid, $counselorid));
                
                $meiform_id = $link->lastInsertId();
                
                // Insert into ext_mf_meiform  
                $insert_ext_meiform = "INSERT INTO ext_mf_meiform (meiformid, date, venue, from_to, date_added) VALUES (?, ?, ?, ?, NOW())";
                $stmt_ext = $link->prepare($insert_ext_meiform);
                $stmt_ext->execute(array($meiform_id, $date, $venue, $timeline));
                
                // Update slots available - make sure slots don't go below 0
                $update_slots = "UPDATE ext_appointment_info SET slots_avail = GREATEST(slots_avail - 1, 0) WHERE recid = ?";
                $stmt_update = $link->prepare($update_slots);
                $stmt_update->execute(array($ext_recid));
                
                // Check if update was successful
                if($stmt_update->rowCount() > 0) {
                    // Commit transaction
                    $link->commit();
                    
                    $response['success'] = true;
                    $response['message'] = 'Post Marriage Counseling booking successful!';
                    $response['meiform_id'] = $meiform_id;
                } else {
                    throw new Exception("Failed to update appointment slots");
                }
                
            } catch(Exception $e) {
                // Rollback transaction on error
                $link->rollback();
                
                $response['success'] = false;
                $response['message'] = 'Booking failed: ' . $e->getMessage();
                
                // Log the error for debugging
                error_log("Booking error: " . $e->getMessage());
            }
            break;
            
        case 'cancel_booking':
            $meiformid = $_POST['meiformid_post'];
            
            try {
                // Start transaction
                $link->beginTransaction();
                
                // Get booking details before deletion
                $select_booking = "SELECT pro_meiform.counselorid, ext_mf_meiform.date, ext_mf_meiform.venue, ext_mf_meiform.from_to
                                 FROM pro_meiform 
                                 LEFT JOIN ext_mf_meiform ON pro_meiform.usermeiformid = ext_mf_meiform.meiformid 
                                 WHERE pro_meiform.usermeiformid = ? AND pro_meiform.status = 'PMC'";
                $stmt_booking = $link->prepare($select_booking);
                $stmt_booking->execute(array($meiformid));
                $booking_details = $stmt_booking->fetch();
                
                if($booking_details) {
                    // Find the corresponding appointment to restore slots
                    $find_appointment = "SELECT ext_appointment_info.recid 
                                       FROM ext_appointment_info 
                                       LEFT JOIN mf_appointment_info ON ext_appointment_info.appointment_info_id = mf_appointment_info.appointment_info_id 
                                       LEFT JOIN mf_venue ON ext_appointment_info.venue_id = mf_venue.venue_id
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
                    
                    if($appointment) {
                        // Restore the slot
                        $restore_slot = "UPDATE ext_appointment_info SET slots_avail = slots_avail + 1 WHERE recid = ?";
                        $stmt_restore = $link->prepare($restore_slot);
                        $stmt_restore->execute(array($appointment['recid']));
                    }
                    
                    // Delete from ext_mf_meiform
                    $delete_ext = "DELETE FROM ext_mf_meiform WHERE meiformid = ?";
                    $stmt_delete_ext = $link->prepare($delete_ext);
                    $stmt_delete_ext->execute(array($meiformid));
                    
                    // Delete from pro_meiform
                    $delete_pro = "DELETE FROM pro_meiform WHERE usermeiformid = ? AND status = 'PMC'";
                    $stmt_delete_pro = $link->prepare($delete_pro);
                    $stmt_delete_pro->execute(array($meiformid));
                    
                    // Commit transaction
                    $link->commit();
                    
                    $response['success'] = true;
                    $response['message'] = 'Booking cancelled successfully!';
                } else {
                    throw new Exception("Booking not found or already cancelled");
                }
                
            } catch(Exception $e) {
                // Rollback transaction on error
                $link->rollback();
                
                $response['success'] = false;
                $response['message'] = 'Cancellation failed: ' . $e->getMessage();
                
                // Log the error for debugging
                error_log("Cancellation error: " . $e->getMessage());
            }
            break;
            
        default:
            $response['success'] = false;
            $response['message'] = 'Invalid action: ' . $event_action;
            break;
    }
} else {
    $response['success'] = false;
    $response['message'] = 'No action specified';
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>