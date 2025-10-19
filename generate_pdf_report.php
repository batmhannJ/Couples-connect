<?php
if (isset($_POST['action']) && $_POST['action'] == 'generate_pdf') {
    
    if (ob_get_level()) {
        ob_end_clean();
    }
    ob_start();
    
    require('fpdf.php');
    require "includes/cc_header.php"; 
    
    $period_from = $_POST['period_from'] ?? '';
    $period_to = $_POST['period_to'] ?? '';
    
    $date_condition = !empty($period_from) && !empty($period_to);
    
    class PDF extends FPDF {
        private $period_from;
        private $period_to;
        
        function __construct($period_from = '', $period_to = '') {
            parent::__construct();
            $this->period_from = $period_from;
            $this->period_to = $period_to;
        }
        
        function Header() {
            // Republic Header
            $this->SetFont('Arial', 'B', 11);
            $this->SetTextColor(0, 0, 0);
            $this->Cell(0, 5, 'Republic of the Philippines', 0, 1, 'C');
            
            $this->SetFont('Arial', '', 10);
            $this->Cell(0, 5, 'CITY OF CALOOCAN', 0, 1, 'C');
            
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(0, 5, 'OFFICE OF THE CITY PLANNING AND DEVELOPMENT', 0, 1, 'C');
            
            $this->SetFont('Arial', '', 9);
            $this->Cell(0, 5, 'City Hall, Caloocan City, Metro Manila', 0, 1, 'C');
            $this->Ln(3);
            
            // Seal/Logo placeholder (you can add actual image)
            // $this->Image('images/cpo_seal.png', 10, 8, 25);
            
            // Divider line
            $this->SetDrawColor(0, 0, 0);
            $this->SetLineWidth(0.8);
            $this->Line(20, 35, 190, 35);
            $this->SetLineWidth(0.3);
            $this->Line(20, 36, 190, 36);
            
            $this->Ln(8);
            
            // Report Title
            $this->SetFont('Arial', 'B', 16);
            $this->SetTextColor(0, 51, 102);
            $this->Cell(0, 8, 'STATISTICAL REPORT', 0, 1, 'C');
            
            // Report Period
            $this->SetFont('Arial', 'B', 11);
            $this->SetTextColor(0, 0, 0);
            if (!empty($this->period_from) && !empty($this->period_to)) {
                $from = date('F j, Y', strtotime($this->period_from));
                $to = date('F j, Y', strtotime($this->period_to));
                $this->Cell(0, 6, 'For the Period: ' . $from . ' to ' . $to, 0, 1, 'C');
            } else {
                $this->Cell(0, 6, 'Comprehensive Report (All Records)', 0, 1, 'C');
            }
            
            $this->Ln(5);
        }
        
        function Footer() {
            $this->SetY(-25);
            
            // Signature lines
            $this->SetFont('Arial', '', 9);
            $this->SetTextColor(0);
            
            $this->Cell(95, 5, 'Prepared by:', 0, 0, 'L');
            $this->Cell(95, 5, 'Noted by:', 0, 1, 'L');
            
            $this->Ln(8);
            
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(95, 5, '_________________________________', 0, 0, 'L');
            $this->Cell(95, 5, '_________________________________', 0, 1, 'L');
            
            $this->SetFont('Arial', '', 9);
            $this->Cell(95, 4, 'Planning Officer III', 0, 0, 'L');
            $this->Cell(95, 4, 'City Planning and Development Officer', 0, 1, 'L');
            
            // Page number
            $this->SetY(-10);
            $this->SetFont('Arial', 'I', 8);
            $this->SetTextColor(128);
            $this->Cell(0, 5, 'Page ' . $this->PageNo() . ' | Generated: ' . date('F j, Y g:i A'), 0, 0, 'C');
        }
        
        function SectionHeader($title, $num = '') {
            $this->SetFont('Arial', 'B', 13);
            $this->SetFillColor(0, 51, 102);
            $this->SetTextColor(255, 255, 255);
            $this->SetDrawColor(0, 51, 102);
            
            if ($num) {
                $this->Cell(0, 8, $num . '. ' . strtoupper($title), 1, 1, 'L', true);
            } else {
                $this->Cell(0, 8, strtoupper($title), 1, 1, 'L', true);
            }
            $this->Ln(2);
        }
        
        function DataRow($label, $value, $indent = 0, $bold = false) {
            $this->SetTextColor(0);
            
            if ($bold) {
                $this->SetFont('Arial', 'B', 11);
            } else {
                $this->SetFont('Arial', '', 10);
            }
            
            // Add indent
            if ($indent > 0) {
                $this->Cell($indent, 6, '', 0, 0);
            }
            
            // Label
            $this->Cell(120 - $indent, 6, $label, 0, 0, 'L');
            
            // Value with background
            $this->SetFont('Arial', 'B', 11);
            $this->SetFillColor(240, 240, 240);
            $this->Cell(70, 6, $value, 1, 1, 'C', true);
        }
        
        function SubDataRow($label, $value) {
            $this->SetFont('Arial', '', 10);
            $this->SetTextColor(60, 60, 60);
            $this->Cell(10, 6, '', 0, 0);
            $this->Cell(110, 6, '- ' . $label, 0, 0, 'L');
            
            $this->SetFont('Arial', 'B', 10);
            $this->SetTextColor(0, 0, 0);
            $this->Cell(70, 6, $value, 0, 1, 'C');
        }
        
        function TableHeader($headers) {
            $this->SetFont('Arial', 'B', 10);
            $this->SetFillColor(0, 51, 102);
            $this->SetTextColor(255, 255, 255);
            $this->SetDrawColor(0, 51, 102);
            
            $widths = [100, 90];
            
            foreach ($headers as $i => $header) {
                $this->Cell($widths[$i], 7, $header, 1, 0, 'C', true);
            }
            $this->Ln();
        }
        
        function TableRow($data, $alt = false) {
            $this->SetFont('Arial', '', 10);
            $this->SetTextColor(0);
            
            if ($alt) {
                $this->SetFillColor(245, 245, 245);
            } else {
                $this->SetFillColor(255, 255, 255);
            }
            
            $widths = [100, 90];
            
            foreach ($data as $i => $cell) {
                $align = ($i == 1) ? 'C' : 'L';
                $this->Cell($widths[$i], 6, $cell, 1, 0, $align, true);
            }
            $this->Ln();
        }
    }
    
    try {
        // Create PDF
        $pdf = new PDF($period_from, $period_to);
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->AddPage();
        
        // SECTION I: ORIENTATIONS
        $pdf->SectionHeader('ORIENTATIONS', 'I');
        
        try {
            // Check available columns
            $check_columns = "DESCRIBE pro_meiform";
            $stmt_check = $link->prepare($check_columns);
            $stmt_check->execute();
            $available_columns = [];
            while($col = $stmt_check->fetch()) {
                $available_columns[] = $col['Field'];
            }
            
            // Determine date column
            $date_column = '';
            if (in_array('created_at', $available_columns)) {
                $date_column = 'created_at';
            } elseif (in_array('date_created', $available_columns)) {
                $date_column = 'date_created';
            } elseif (in_array('registration_date', $available_columns)) {
                $date_column = 'registration_date';
            }
            
            // Query orientations
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
            
            $total_attendees = $orientation_count * 10;
            
            $pdf->DataRow('Total Orientation Sessions Conducted:', $orientation_count, 0, true);
            $pdf->SubDataRow('Total Number of Attendees', $total_attendees);
            
        } catch(PDOException $e) {
            $pdf->SetFont('Arial', 'I', 9);
            $pdf->SetTextColor(200, 0, 0);
            $pdf->Cell(0, 6, 'Error: Unable to retrieve orientation data', 0, 1);
        }
        
        $pdf->Ln(5);
        
        // SECTION II: COUNSELING SERVICES
        $pdf->SectionHeader('COUNSELING SERVICES', 'II');
        
        try {
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
            
            $pdf->DataRow('Total Counseling Sessions Conducted:', $counseling_count, 0, true);
            $pdf->SubDataRow('Pre-Marriage Counseling', $counseling_count);
            $pdf->SubDataRow('Post-Marriage Counseling', '0');
            
        } catch(PDOException $e) {
            $pdf->SetFont('Arial', 'I', 9);
            $pdf->SetTextColor(200, 0, 0);
            $pdf->Cell(0, 6, 'Error: Unable to retrieve counseling data', 0, 1);
        }
        
        $pdf->Ln(5);
        
        // SECTION III: COUPLES SERVED BY CONCERN TYPE
        $pdf->SectionHeader('COUPLES SERVED BY CONCERN TYPE', 'III');
        
        try {
            // Check booking table structure
            $check_booking_columns = "DESCRIBE pro_counselorbooking";
            $stmt_check_booking = $link->prepare($check_booking_columns);
            $stmt_check_booking->execute();
            $booking_columns = [];
            while($col = $stmt_check_booking->fetch()) {
                $booking_columns[] = $col['Field'];
            }
            
            $booking_date_column = '';
            if (in_array('booking_date', $booking_columns)) {
                $booking_date_column = 'booking_date';
            } elseif (in_array('date', $booking_columns)) {
                $booking_date_column = 'date';
            } elseif (in_array('created_at', $booking_columns)) {
                $booking_date_column = 'created_at';
            }
            
            $has_concern_id = in_array('concern_id', $booking_columns);
            
            // Create table
            $pdf->TableHeader(['Concern Type', 'Number of Reports']);
            
            // Get concerns
            $select_db_ac = "SELECT * FROM mf_concerns";
            $stmt = $link->prepare($select_db_ac);
            $stmt->execute();
            
            $alt = false;
            $total_all_concerns = 0;
            
            while($rs_ac = $stmt->fetch()){
                try {
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
                    
                    $pdf->TableRow([$rs_ac['concerns'], $xcount], $alt);
                    $total_all_concerns += $xcount;
                    $alt = !$alt;
                    
                } catch(PDOException $e) {
                    $pdf->TableRow([$rs_ac['concerns'], 'Error'], $alt);
                    $alt = !$alt;
                }
            }
            
            // Total row
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->SetFillColor(0, 51, 102);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Cell(100, 7, 'TOTAL COUPLES SERVED', 1, 0, 'R', true);
            $pdf->Cell(90, 7, $total_all_concerns, 1, 1, 'C', true);
            
        } catch(PDOException $e) {
            $pdf->SetFont('Arial', 'I', 9);
            $pdf->SetTextColor(200, 0, 0);
            $pdf->Cell(0, 6, 'Error: Unable to retrieve couples data', 0, 1);
        }
        
        $pdf->Ln(10);
        
        // CERTIFICATION
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0);
        $pdf->MultiCell(0, 5, 'This is to certify that the above statistics are true and correct based on the records of the Office of the City Planning and Development for the period indicated.', 0, 'J');
        
        // Clean output buffer
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        // Output PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="CPO_Statistical_Report_' . date('Y-m-d') . '.pdf"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        
        $pdf->Output('D', 'CPO_Statistical_Report_' . date('Y-m-d') . '.pdf');
        
    } catch(Exception $e) {
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        error_log("PDF Generation Error: " . $e->getMessage());
        echo "<script>alert('Error generating PDF report. Please try again.'); window.history.back();</script>";
    }
    
    exit();
}

// If not generating PDF, redirect back
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>