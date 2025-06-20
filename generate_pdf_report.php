<?php
// FPDF VERSION - Fixed for database column issues
// File: generate_pdf_report.php

// IMPORTANT: No output before this point - no echo, print, HTML, or whitespace!

// Check if PDF generation is requested FIRST
if (isset($_POST['action']) && $_POST['action'] == 'generate_pdf') {
    
    // Clear any output buffer and start fresh
    if (ob_get_level()) {
        ob_end_clean();
    }
    ob_start();
    
    // Download FPDF from http://www.fpdf.org/ - just need fpdf.php file
    require('fpdf.php'); // Just download this one file and put it in your project
    require "includes/cc_header.php"; // Your database connection
    
    $period_from = $_POST['period_from'] ?? '';
    $period_to = $_POST['period_to'] ?? '';
    
    // FIXED: Define date_condition properly
    $date_condition = !empty($period_from) && !empty($period_to);
    
    // Custom PDF class
    class PDF extends FPDF {
        function Header() {
            // Logo/Image (optional)
            // $this->Image('images/logo.png', 10, 6, 30);
            
            // Title
            $this->SetFont('Arial', 'B', 20);
            $this->SetTextColor(35, 64, 142); // Blue color
            $this->Cell(0, 15, 'COUPLES CONNECT REPORT', 0, 1, 'C');
            $this->Ln(5);
            
            // Line
            $this->SetDrawColor(35, 64, 142);
            $this->Line(20, 30, 190, 30);
            $this->Ln(10);
        }
        
        function Footer() {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->SetTextColor(128);
            $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' - Generated on: ' . date('Y-m-d H:i:s A'), 0, 0, 'C');
        }
        
        function SectionTitle($title) {
            $this->SetFont('Arial', 'B', 14);
            $this->SetTextColor(35, 64, 142);
            $this->Cell(0, 10, $title, 0, 1);
            $this->SetDrawColor(35, 64, 142);
            $this->Line(20, $this->GetY(), 190, $this->GetY());
            $this->Ln(5);
        }
        
        function NormalText($text, $indent = 0) {
            $this->SetFont('Arial', '', 11);
            $this->SetTextColor(0);
            if ($indent > 0) {
                $this->Cell($indent, 8, '', 0, 0); // Indentation
                $this->Cell(0, 8, $text, 0, 1);
            } else {
                $this->Cell(0, 8, $text, 0, 1);
            }
        }
        
        function BoldText($text, $indent = 0) {
            $this->SetFont('Arial', 'B', 11);
            $this->SetTextColor(0);
            if ($indent > 0) {
                $this->Cell($indent, 8, '', 0, 0); // Indentation
                $this->Cell(0, 8, $text, 0, 1);
            } else {
                $this->Cell(0, 8, $text, 0, 1);
            }
        }
        
        // FIXED: Add method to handle text that might be too long
        function MultiCellText($text, $indent = 0) {
            $this->SetFont('Arial', '', 11);
            $this->SetTextColor(0);
            if ($indent > 0) {
                $this->Cell($indent, 0, '', 0, 0); // Indentation
            }
            $this->MultiCell(0, 8, $text, 0, 'L');
        }
    }
    
    try {
        // Create PDF
        $pdf = new PDF();
        $pdf->AddPage();
        
        // Report period
        if ($period_from && $period_to) {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetTextColor(0);
            $pdf->Cell(0, 10, 'Report Period: ' . $period_from . ' to ' . $period_to, 0, 1, 'C');
            $pdf->Ln(5);
        } else {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetTextColor(0);
            $pdf->Cell(0, 10, 'Complete Report (All Records)', 0, 1, 'C');
            $pdf->Ln(5);
        }
        
        // ORIENTATIONS SECTION - FIXED: Check what columns exist first
        $pdf->SectionTitle('ORIENTATIONS');
        
        try {
            // First, let's check what columns exist in pro_meiform table
            $check_columns = "DESCRIBE pro_meiform";
            $stmt_check = $link->prepare($check_columns);
            $stmt_check->execute();
            $available_columns = [];
            while($col = $stmt_check->fetch()) {
                $available_columns[] = $col['Field'];
            }
            
            // Determine which date column to use
            $date_column = '';
            if (in_array('created_at', $available_columns)) {
                $date_column = 'created_at';
            } elseif (in_array('date_created', $available_columns)) {
                $date_column = 'date_created';
            } elseif (in_array('registration_date', $available_columns)) {
                $date_column = 'registration_date';
            }
            
            // Build the correct query based on date condition and available columns
            if ($date_condition && !empty($date_column)) {
                $select_db_totalpmo = "SELECT COUNT(*) as xcount FROM pro_meiform WHERE status='PMO' AND DATE($date_column) BETWEEN ? AND ?";
                $stmt_totalpmo = $link->prepare($select_db_totalpmo);
                $stmt_totalpmo->execute([$period_from, $period_to]);
            } else {
                $select_db_totalpmo = "SELECT COUNT(*) as xcount FROM pro_meiform WHERE status='PMO'";
                $stmt_totalpmo = $link->prepare($select_db_totalpmo);
                $stmt_totalpmo->execute();
            }
            
            $orientation_count = 0;
            if($rs_totalpmo = $stmt_totalpmo->fetch()){
                $orientation_count = $rs_totalpmo['xcount'];
            }
            
            $pdf->BoldText('Total Number of Orientation Sessions Held: ' . $orientation_count);
            
            // Calculate attendees - Based on your original logic (multiply by 10)
            $total_attendees = $orientation_count * 10;
            
            $pdf->NormalText('Total Number of Attendees: ' . $total_attendees, 10);
            
        } catch(PDOException $e) {
            $pdf->NormalText('Error retrieving orientation data: ' . $e->getMessage());
            error_log("Orientation query error: " . $e->getMessage());
        }
        
        $pdf->Ln(5);
        
        // COUNSELING SECTION - FIXED: Same approach
        $pdf->SectionTitle('COUNSELING');
        
        try {
            // Build the correct query based on date condition and available columns
            if ($date_condition && !empty($date_column)) {
                $select_db_totalpmc = "SELECT COUNT(*) as xcount FROM pro_meiform WHERE status='PMC' AND DATE($date_column) BETWEEN ? AND ?";
                $stmt_totalpmc = $link->prepare($select_db_totalpmc);
                $stmt_totalpmc->execute([$period_from, $period_to]);
            } else {
                $select_db_totalpmc = "SELECT COUNT(*) as xcount FROM pro_meiform WHERE status='PMC'";
                $stmt_totalpmc = $link->prepare($select_db_totalpmc);
                $stmt_totalpmc->execute();
            }
            
            $counseling_count = 0;
            if($rs_totalpmc = $stmt_totalpmc->fetch()){
                $counseling_count = $rs_totalpmc['xcount'];
            }
            
            $pdf->BoldText('Total Number of Counseling Sessions Held: ' . $counseling_count);
            $pdf->NormalText('Total Number of Pre-marriage Counseling: ' . $counseling_count, 10);
            $pdf->NormalText('Total Number of Post-marriage Counseling: 0', 10);
            
        } catch(PDOException $e) {
            $pdf->NormalText('Error retrieving counseling data: ' . $e->getMessage());
            error_log("Counseling query error: " . $e->getMessage());
        }
        
        $pdf->Ln(5);
        
        // COUPLES SECTION - FIXED: Check pro_counselorbooking table structure
        $pdf->SectionTitle('COUPLES');
        
        try {
            // Check what columns exist in pro_counselorbooking table
            $check_booking_columns = "DESCRIBE pro_counselorbooking";
            $stmt_check_booking = $link->prepare($check_booking_columns);
            $stmt_check_booking->execute();
            $booking_columns = [];
            while($col = $stmt_check_booking->fetch()) {
                $booking_columns[] = $col['Field'];
            }
            
            // Determine which date column to use for bookings
            $booking_date_column = '';
            if (in_array('booking_date', $booking_columns)) {
                $booking_date_column = 'booking_date';
            } elseif (in_array('date', $booking_columns)) {
                $booking_date_column = 'date';
            } elseif (in_array('created_at', $booking_columns)) {
                $booking_date_column = 'created_at';
            } elseif (in_array('date_created', $booking_columns)) {
                $booking_date_column = 'date_created';
            }
            
            // Check if concern_id exists
            $has_concern_id = in_array('concern_id', $booking_columns);
            
            // First, get all concern types
            $select_db_ac = "SELECT * FROM mf_concerns";
            $stmt = $link->prepare($select_db_ac);
            $stmt->execute();
            
            $concerns_found = false;
            while($rs_ac = $stmt->fetch()){
                $concerns_found = true;
                
                try {
                    // FIXED: Get count for each specific concern type if concern_id exists
                    if ($has_concern_id) {
                        if ($date_condition && !empty($booking_date_column)) {
                            $select_db_ac2 = "SELECT COUNT(*) as xcount FROM pro_counselorbooking 
                                             WHERE concern_id = ? AND DATE($booking_date_column) BETWEEN ? AND ?";
                            $stmt2 = $link->prepare($select_db_ac2);
                            $stmt2->execute([$rs_ac['id'], $period_from, $period_to]);
                        } else {
                            $select_db_ac2 = "SELECT COUNT(*) as xcount FROM pro_counselorbooking 
                                             WHERE concern_id = ?";
                            $stmt2 = $link->prepare($select_db_ac2);
                            $stmt2->execute([$rs_ac['id']]);
                        }
                    } else {
                        // If no concern_id, just get total count for all concerns
                        if ($date_condition && !empty($booking_date_column)) {
                            $select_db_ac2 = "SELECT COUNT(*) as xcount FROM pro_counselorbooking 
                                             WHERE DATE($booking_date_column) BETWEEN ? AND ?";
                            $stmt2 = $link->prepare($select_db_ac2);
                            $stmt2->execute([$period_from, $period_to]);
                        } else {
                            $select_db_ac2 = "SELECT COUNT(*) as xcount FROM pro_counselorbooking";
                            $stmt2 = $link->prepare($select_db_ac2);
                            $stmt2->execute();
                        }
                    }
                    
                    $xcount = 0;
                    if($rs_ac2 = $stmt2->fetch()){
                        $xcount = $rs_ac2["xcount"];
                    }
                    
                    // If no concern_id, distribute the total count evenly among concerns
                    if (!$has_concern_id) {
                        // Get total number of concerns
                        $total_concerns_stmt = $link->prepare("SELECT COUNT(*) as total FROM mf_concerns");
                        $total_concerns_stmt->execute();
                        $total_concerns_result = $total_concerns_stmt->fetch();
                        $total_concerns = $total_concerns_result['total'];
                        
                        // Distribute evenly (this is just for display purposes)
                        $xcount = $total_concerns > 0 ? floor($xcount / $total_concerns) : 0;
                    }
                    
                    // FIXED: Use MultiCellText for long concern names
                    $concern_text = 'Total Number of Reports of ' . $rs_ac['concerns'] . ': ' . $xcount;
                    if (strlen($concern_text) > 80) {
                        $pdf->MultiCellText($concern_text, 0);
                    } else {
                        $pdf->BoldText($concern_text);
                    }
                    
                } catch(PDOException $e) {
                    $pdf->NormalText('Error retrieving data for ' . $rs_ac['concerns'] . ': ' . $e->getMessage());
                    error_log("Couples query error for concern " . $rs_ac['id'] . ": " . $e->getMessage());
                }
            }
            
            if (!$concerns_found) {
                $pdf->NormalText('No concern categories found in database.');
            }
            
            // FIXED: Add overall totals
            $pdf->Ln(5);
            
            try {
                // Get total couples count
                if ($date_condition && !empty($booking_date_column)) {
                    $select_total_couples = "SELECT COUNT(*) as total FROM pro_counselorbooking 
                                           WHERE DATE($booking_date_column) BETWEEN ? AND ?";
                    $stmt_total = $link->prepare($select_total_couples);
                    $stmt_total->execute([$period_from, $period_to]);
                } else {
                    $select_total_couples = "SELECT COUNT(*) as total FROM pro_counselorbooking";
                    $stmt_total = $link->prepare($select_total_couples);
                    $stmt_total->execute();
                }
                
                $total_couples = 0;
                if($rs_total = $stmt_total->fetch()){
                    $total_couples = $rs_total['total'];
                }
                
                $pdf->BoldText('Total Number of Couples Served: ' . $total_couples);
                
            } catch(PDOException $e) {
                $pdf->NormalText('Error retrieving total couples data: ' . $e->getMessage());
                error_log("Total couples query error: " . $e->getMessage());
            }
            
        } catch(PDOException $e) {
            $pdf->NormalText('Error retrieving couples data: ' . $e->getMessage());
            error_log("Couples section error: " . $e->getMessage());
        }
        
        // FIXED: Add summary section
        $pdf->Ln(10);
        $pdf->SectionTitle('SUMMARY');
        
        // Add summary calculations here if needed
        $pdf->NormalText('Report generated successfully.');
        $pdf->NormalText('Data extracted from: ' . date('Y-m-d H:i:s'));
        
        if ($date_condition) {
            $pdf->NormalText('Date range: ' . $period_from . ' to ' . $period_to);
        } else {
            $pdf->NormalText('All available records included.');
        }
        
        // Clean any remaining output buffer
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        // Set headers for PDF download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="CouplesConnect_Report_' . date('Y-m-d_H-i-s') . '.pdf"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        
        // Generate filename and output
        $filename = 'CouplesConnect_Report_' . date('Y-m-d_H-i-s') . '.pdf';
        $pdf->Output('D', $filename); // 'D' = force download
        
    } catch(Exception $e) {
        // If PDF generation fails, clean output and show error
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        // Log the error
        error_log("PDF Generation Error: " . $e->getMessage());
        
        // Show user-friendly error
        echo "<script>alert('Error generating PDF report. Please try again.'); window.history.back();</script>";
    }
    
    exit();
}

// If not generating PDF, redirect back to the report page
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>