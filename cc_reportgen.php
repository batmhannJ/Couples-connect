<?php
require "includes/cc_header.php";

$header_name = '';
if($_SESSION['usertype'] == 'DSK'){
    $header_name = "DESK";
}else if($_SESSION['usertype'] == 'CNR'){
    $header_name = "COUNSELOR";
}else if($_SESSION['usertype'] == 'HED'){
    $header_name = "HEAD";
}


?>

<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
<link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
<div class="container-fluid">
    <div class='row bg-white' style="height:99px">
        <div class="col-3 pe-0 d-flex align-items-center">
            <img src="images/350 x 88.png" style='height:76px;width:auto;'>
        </div>
        <div class="col-3 offset-6 d-none">
            <div style="flex:0.5;text-align:right;margin-right:10px">
                <a href="http://localhost/couples-connect/select_option.php" style='color:black;text-decoration:none' class='has_hover'>HOME</a>
            </div>
            <div style="flex:.1;text-align:center;padding-right:10px">
                <a style='color:black;text-decoration:none'>|</a>
            </div>
            <div style="flex:.3;text-align:center;padding-right:15px">
                <a style='color:black;text-decoration:none'><?php echo $header_name;?> </a>
            </div>
            <div style="flex:0.6;text-align:right;padding-right:35px">
                <a href="http://localhost/couples-connect/logout_cc.php" class='has_hover' style='color:black;text-decoration:none'>LOGOUT</a>
            </div>
        </div>
    </div>
</div>

<form name='myforms' id="myforms" method="post" target="_self" style='min-height:100vh; background: linear-gradient(135deg, rgb(215, 217, 225) 0%, rgb(162, 185, 231) 100%); padding: 20px; font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;'>

    <div id="main-grid" class="dashboard-grid" style="max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: 320px 1fr; gap: 24px; height: calc(100vh - 40px);">

        <div class="cc-sidebar" style=" 
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 0;
            height: calc(100vh - 80px); 
            max-height: 650px; 
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow-y: auto;
            transition: width 0.3s ease;
        ">
            <div style="display: flex; flex-direction: column; gap: 0;">
                <?php require 'cc_mf_menu.php'; ?>
            </div>
        </div>


        <div class="main-content" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 24px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; border: 1px solid rgba(255, 255, 255, 0.2); height: calc(100vh - 80px); overflow-y: auto;">

            <div style="padding: 20px 32px 16px 32px; text-align: center; border-bottom: 1px solid rgba(0, 0, 0, 0.05); flex-shrink: 0;">
                <h1 style="font-size: 26px; font-weight: 700; color: #1a1a1a; margin: 0 0 10px 0;">Report Generation</h1>
                <div style="height: 3px; background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%); border-radius: 2px; width: 200px; margin: 0 auto;"></div>
            </div>

            <div style="padding: 24px 32px; flex-shrink: 0;">
                <div style="background: rgba(255, 255, 255, 0.7); border-radius: 16px; padding: 24px; border: 1px solid rgba(0, 0, 0, 0.05);">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; align-items: end;">
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Select Period From:</label>
                            <input type="date" class="form-control period_from" name="period_from" id='period_from' style="border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 12px; padding: 12px 16px; font-size: 14px; background: white; transition: all 0.2s ease; font-family: Inter;">
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="font-weight: 600; color: #374151; font-size: 14px;">Select Period To:</label>
                            <input type="date" class="form-control period_to" name="period_to" id='period_to' style="border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 12px; padding: 12px 16px; font-size: 14px; background: white; transition: all 0.2s ease; font-family: Inter;">
                        </div>
                    </div>
                </div>
            </div>

            <div style="flex: 1; padding: 0 32px 24px 32px; display: flex; flex-direction: column; gap: 20px; min-height: 0;">

                <div style="background: rgba(255, 255, 255, 0.7); border-radius: 16px; padding: 24px; border: 1px solid rgba(0, 0, 0, 0.05);">
                    <h3 style="font-size: 20px; font-weight: 700; color: #1a1a1a; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                        <div style="width: 6px; height: 24px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); border-radius: 3px;"></div>
                        Orientations
                    </h3>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <?php
                            // PHP logic for Orientations
                            $select_db_totalpmo = "SELECT COUNT(*) as xcount FROM pro_meiform WHERE status='PMO'";
                            $stmt_totalpmo = $link->prepare($select_db_totalpmo);
                            $stmt_totalpmo->execute();
                            while($rs_totalpmo = $stmt_totalpmo->fetch()){                                                    
                                echo "<div style='background: rgba(79, 70, 229, 0.05); border-radius: 12px; padding: 16px; border-left: 4px solid #4f46e5;'>";
                                echo "<span style='font-size: 16px; font-weight: 600; color: #1f2937; font-family: Inter;'>Total Number of Orientations Sessions Held: <span style='color: #4f46e5; font-weight: 700;'>".$rs_totalpmo['xcount']."</span></span>";
                                echo "</div>";
                            }

                            $select_db_totalpmo2 = "SELECT * FROM pro_meiform WHERE status='PMO'";
                            $stmt_totalpmo2 = $link->prepare($select_db_totalpmo2);
                            $stmt_totalpmo2->execute();
                            $total_attendees = 0;
                            
                            while($rs_totalpmo2 = $stmt_totalpmo2->fetch()){
                                $total_attendees += 10; // or get this from another field in pro_meiform
                            }
                        ?>
                        <div style="background: rgba(16, 185, 129, 0.05); border-radius: 12px; padding: 16px; border-left: 4px solid #10b981;">
                            <span style="font-size: 15px; font-weight: 500; color: #374151; font-family: Inter;">Total Number of Attendees: <span style="color: #10b981; font-weight: 700;"><?php echo $total_attendees; ?></span></span>
                        </div>
                    </div>
                </div>

                <div style="background: rgba(255, 255, 255, 0.7); border-radius: 16px; padding: 24px; border: 1px solid rgba(0, 0, 0, 0.05);">
                    <h3 style="font-size: 20px; font-weight: 700; color: #1a1a1a; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                        <div style="width: 6px; height: 24px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 3px;"></div>
                        Counseling
                    </h3>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <?php
                            // PHP logic for Counseling Sessions Held
                            $select_db_totalpmc = "SELECT COUNT(*) as xcount FROM pro_meiform WHERE status='PMC'";
                            $stmt_totalpmc = $link->prepare($select_db_totalpmc);
                            $stmt_totalpmc->execute();
                            $pmc_count = 0; // Initialize counter for use below
                            while($rs_totalpmc = $stmt_totalpmc->fetch()){
                                $pmc_count = $rs_totalpmc['xcount'];
                                echo "<div style='background: rgba(16, 185, 129, 0.05); border-radius: 12px; padding: 16px; border-left: 4px solid #10b981;'>";
                                echo "<span style='font-size: 16px; font-weight: 600; color: #1f2937; font-family: Inter;'>Total Number of Counseling Sessions Held: <span style='color: #10b981; font-weight: 700;'>".$pmc_count."</span></span>";
                                echo "</div>";
                            }
                        ?>
                        <div style="background: rgba(239, 68, 68, 0.05); border-radius: 12px; padding: 16px; border-left: 4px solid #ef4444;">
                            <span style="font-size: 15px; font-weight: 500; color: #374151; font-family: Inter;">Total Number of Pre-marriage Counseling: 
                                <span style="color: #ef4444; font-weight: 700;">
                                    <?php
                                        // Re-running query (or using $pmc_count if available)
                                        $select_db_totalpmc = "SELECT COUNT(*) as xcount FROM pro_meiform WHERE status='PMC'";
                                        $stmt_totalpmc = $link->prepare($select_db_totalpmc);
                                        $stmt_totalpmc->execute();
                                        while($rs_totalpmc = $stmt_totalpmc->fetch()){
                                            echo $rs_totalpmc['xcount'];
                                        }
                                    ?>
                                </span>
                            </span>
                        </div>
                        <div style="background: rgba(249, 115, 22, 0.05); border-radius: 12px; padding: 16px; border-left: 4px solid #f97316;">
                            <span style="font-size: 15px; font-weight: 500; color: #374151; font-family: Inter;">Total Number of Post-marriage Counseling: <span style="color: #f97316; font-weight: 700;">0</span></span>
                        </div>
                    </div>
                </div>

                <div style="background: rgba(255, 255, 255, 0.7); border-radius: 16px; padding: 24px; border: 1px solid rgba(0, 0, 0, 0.05);">
                    <h3 style="font-size: 20px; font-weight: 700; color: #1a1a1a; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                        <div style="width: 6px; height: 24px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 3px;"></div>
                        Couples
                    </h3>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <?php
                            // PHP logic for Couples/Concerns
                            $select_db_ac = "SELECT * FROM mf_concerns";
                            $stmt = $link->prepare($select_db_ac);
                            $stmt->execute();
                            $concern_colors = ['#8b5cf6', '#06b6d4', '#10b981', '#f59e0b', '#ef4444'];
                            $color_index = 0;
                            
                            while($rs_ac = $stmt->fetch()){
                                try {
                                    $select_db_ac2 = "SELECT COUNT(*) as xcount FROM pro_counselorbooking"; // NOTE: This query counts ALL bookings, not bookings specific to $rs_ac['concerns']
                                    $stmt2 = $link->prepare($select_db_ac2);
                                    $stmt2->execute();
                                    $xcount = 0;
                                    while($rs_ac2 = $stmt2->fetch()){
                                        $xcount = $rs_ac2["xcount"];
                                    }
                                } catch(PDOException $e) {
                                    echo "Error: " . $e->getMessage() . "<br>";
                                    $xcount = 0;
                                }
                                
                                $current_color = $concern_colors[$color_index % count($concern_colors)];
                                $color_index++;

                                // Helper function to convert HEX to RGB for the rgba background
                                $hex = ltrim($current_color, '#');
                                $r = hexdec(substr($hex, 0, 2));
                                $g = hexdec(substr($hex, 2, 2));
                                $b = hexdec(substr($hex, 4, 2));
                                $rgba_bg = "rgba($r, $g, $b, 0.05)";
                                
                                echo "<div style='background: {$rgba_bg}; border-radius: 12px; padding: 16px; border-left: 4px solid {$current_color};'>";
                                echo "<span style='font-size: 15px; font-weight: 500; color: #374151; font-family: Inter;'>Total Number of Reports of ".$rs_ac['concerns'].": <span style='color: {$current_color}; font-weight: 700;'>".$xcount."</span></span>";
                                echo "</div>";
                            }
                        ?>
                    </div>
                </div>

                <div style="display: flex; justify-content: center; padding: 20px 0;">
                    <button type="button" onclick="acc_choose('DEC')" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: white; border: none; padding: 16px 48px; border-radius: 16px; font-size: 16px; font-family: Inter; font-weight: 700; box-shadow: 0 8px 24px rgba(79, 70, 229, 0.3); cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 12px;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 32px rgba(79, 70, 229, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 24px rgba(79, 70, 229, 0.3)'">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                        </svg>
                        Export File
                    </button>
                </div>
            </div>
        </div>
    </div>

<style>
    /* Global Styles (unchanged) */
    #search_text:focus { outline: none; }
    .has_hover:hover { color: #4f46e5 !important; transition: color 0.2s ease; }
    input[type="date"]:focus { border-color: #4f46e5 !important; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important; outline: none !important; }
    .btn-filter:hover { transform: translateY(-2px) !important; box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4) !important; }
    tbody tr:hover button { transform: scale(1.05) !important; }

    /* ======================================================= */
    /* RESPONSIVE LAYOUT & SIDEBAR COLLAPSE STYLES             */
    /* ======================================================= */

    /* 1. Default (Desktop/Tablet Grid) - RETAINED */
    .dashboard-grid {
        grid-template-columns: 320px 1fr; /* Default Grid: Sidebar and Content side-by-side */
        gap: 24px;
        height: auto; 
        max-width: 1400px; 
        display: grid; 
    }
    .cc-sidebar { height: calc(100vh - 80px); max-height: 650px; }
    /* Corrected to main-content for consistency with HTML structure, though it's not strictly needed here */
    .main-content { height: calc(100vh - 80px); max-height: 650px; } 

    /* 2. Medium Screen Collapse (1200px) - Shrinks Sidebar to ONLY ICONS */
    @media (max-width: 1200px) {
        .dashboard-grid { 
            grid-template-columns: 80px 1fr !important; /* Sidebar width is 80px */
            gap: 16px !important; 
        }
        .dashboard-grid > div:first-child { width: 80px; }
        
        /* *** CRITICAL FIX ENFORCEMENT *** */
        
        /* Force-hide the text label and related elements (Primary target) */
        .sidebar-label { 
            display: none !important; 
            opacity: 0 !important;
            width: 0 !important;
            overflow: hidden !important;
            max-width: 0 !important; /* Ensure it collapses fully */
        } 
        
        /* Hide Profile/Search elements that may contain text */
        .cc-profile-info, .cc-search-bar input { 
            display: none !important; 
        }
        
        /* Force menu link to collapse and center the icon */
        .cc-menu-link { 
            display: flex !important; 
            flex-direction: column !important; /* Stack icon and text label (which is hidden above) */
            justify-content: center !important; 
            align-items: center !important;
            padding: 10px 0 !important; /* Vertical padding only */
            width: 100% !important; /* Takes full 80px width */
            overflow: hidden !important; /* Hides anything that overflows */
            text-align: center !important; /* Centers any remaining text/element */
            max-width: 80px !important; /* Ensures the link does not exceed 80px */
        } 
        
        /* Ensure the icon wrapper itself has no margin and the list item is clean */
        .cc-menu-link .cc-icon-wrap { margin: 0 !important; }
        .cc-sidebar li {
            padding: 0 !important;
            margin: 0 !important;
        }
        
        /* Prevent text wrapping and ensure no space is taken by hidden text */
        .cc-menu-link > *:not(.cc-icon-wrap) {
            display: none !important;
        }
    }

    /* 3. Small Screen (768px and below) - SIDEBAR MOVED TO TOP (FLEX COLUMN) */
    @media (max-width: 768px) {
        /* HEADER FIX */
        .container-fluid { padding: 0 !important; max-width: 100% !important; }
        .container-fluid > .row { margin: 0 !important; padding: 0 !important; }

        /* FORM AND OUTER BODY FIX */
        form { 
            padding: 5px !important; /* Add a little padding to the overall form for edges */
            min-height: auto !important; 
            overflow-x: hidden; /* Prevent horizontal scroll on body */
        }
        
        /* DASHBOARD GRID FIX (Parent Container - Changed to Flex Column) */
        #main-grid.dashboard-grid { /* Target by ID for higher specificity */
            display: flex !important; 
            flex-direction: column !important; 
            gap: 8px !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important; /* Padding is now on the form */
            height: auto !important; /* Allow content to dictate height */
        }
        
        /* SIDEBAR CONTAINER (Icons Container - Now Horizontal and First) */
        .cc-sidebar {
            order: 1 !important; /* *** THIS IS THE CRITICAL CHANGE: Put the sidebar first *** */
            width: 100% !important;
            max-width: 100% !important;
            height: auto !important;
            max-height: none !important;
            margin: 0 !important;
            padding: 8px 5px !important; 
            border-radius: 12px !important;
            overflow-y: hidden !important; /* Disable vertical scroll */
            
            /* Horizontal Icon Display */
            display: flex;
            flex-direction: row !important;
            justify-content: space-around; 
            align-items: center;
            overflow-x: auto; 
            white-space: nowrap; 
        }

        /* Hide the text labels in the horizontal menu */
        .sidebar-label { 
            display: none !important; 
            opacity: 0 !important; 
            width: 0 !important; 
            overflow: hidden !important; 
        } 
        
        /* Ensure the menu links stack icon and (hidden) text */
        .cc-menu-link { 
             flex-direction: column; 
             align-items: center; 
             justify-content: center; 
             padding: 4px; 
        }
        .cc-menu-link .cc-icon-wrap { margin: 0 !important; }

        
        /* MAIN CONTENT CONTAINER (Report Generation Content - Second) */
        .main-content { /* *** TARGETING THE CORRECT CLASS: .main-content *** */
            order: 2 !important; 
            width: 100% !important;
            max-width: 100% !important;
            height: auto !important; 
            max-height: none !important;
            margin: 0 !important;
            padding: 0 !important; /* Remove container padding, manage within children */
            overflow-y: visible !important; /* Allow the content to scroll if needed */
        }

        /* Content Padding Adjustments */
        .main-content > div:first-child { padding: 16px 16px 12px 16px !important; } /* Header */
        .main-content > div:nth-child(2) { padding: 12px 16px !important; } /* Period Filter */
        .main-content > div:nth-child(3) { padding: 0 16px 16px 16px !important; } /* Stats and Button */
        
        /* Inner box padding adjustment */
        .main-content > div > div { padding: 16px !important; } 
        
        /* Date Picker Grid Adjustment */
        .main-content > div:nth-child(2) > div > div {
            grid-template-columns: 1fr !important; /* Stack date pickers */
            gap: 16px !important;
        }

        /* Font size/spacing adjustments */
        h1 { font-size: 22px !important; }
        h3 { font-size: 18px !important; }
        .main-content button {
             padding: 12px 32px !important;
             font-size: 14px !important;
        }
    }
</style>
</form>

    <!-- Modal -->
    <div class="modal fade xerror_modal" data-bs-backdrop="static" id="xerror_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15); background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(20px);">
                <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 24px 32px;">
                    <h5 class="modal-title" style="font-weight: 700; color: #1f2937; font-size: 20px;">Couples Connect Says:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 24px 32px 32px 32px;">
                    <p class="error_msg" style="color: #6b7280; margin: 0; font-size: 14px; line-height: 1.5;">Modal body text goes here.</p>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="ac_recid_hidden" id="ac_recid_hidden">
    
</form>


    <script>

function acc_choose(action) {
    if (action === 'DEC') {
        // Get the period values
        var period_from = $('#period_from').val();
        var period_to = $('#period_to').val();
        
        // Optional: Remove validation if you want to allow reports without date range
        if (!period_from || !period_to) {
            // Show confirmation dialog instead of error
            if (!confirm('No date range selected. Generate report for all records?')) {
                return;
            }
        }
        
        // Create and submit form
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = 'generate_pdf_report.php';
        form.target = '_blank';
        
        // Add form fields
        var inputs = [
            {name: 'period_from', value: period_from || ''},
            {name: 'period_to', value: period_to || ''},
            {name: 'action', value: 'generate_pdf'}
        ];
        
        inputs.forEach(function(input) {
            var element = document.createElement('input');
            element.type = 'hidden';
            element.name = input.name;
            element.value = input.value;
            form.appendChild(element);
        });
        
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
}

$('.period_from, .period_to').on('change',function(e){

    var xdata = $("#myforms *").serialize();
    jQuery.ajax({    
        data:xdata,
        dataType:"json",
        type:"post",
        url:"cc_reportgen_ajax.php", 
        success: function(xdata2){

            $(".totalnum_orientation_participants").html("Total Number of Attendees: "+ xdata2['totalOrientationAttendees'])
            $(".totalnum_orientation").html("Total Number of Orientations Sessions Held: "+xdata2['totalOrientations']);
        },
        error: function (request, status, error) {
        }
    })
});

function review(recid){

    $("#ac_recid_hidden").val(recid);
    
    document.forms.myforms.method = "post";
    document.forms.myforms.target = "_self";
    document.forms.myforms.action = "cc_account_confirm2.php";
    document.forms.myforms.submit();
}

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      height:650,
      initialView: 'dayGridMonth',
      header: {
        left: '',
        center: '',
        right: ''
      }
    });

    calendar.addEvent({
        title: 'Second Event',
        start: '2024-03-08T12:30:00',
        end: '2024-03-08T13:30:00'
    });

    calendar.render();
});


    function onReg(){

        document.forms.myforms.method = "post";
        document.forms.myforms.target = "_self";
        document.forms.myforms.action = "register_cc.php";
        document.forms.myforms.submit();
    }

    function validateEmail(input) {
        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

        if (input.value.match(validRegex)) {
            return true;
        } else {
            return false;
        }

    }

    function onLogin(){

        var xemail_input = document.getElementById("email_login");
        var xpassword = $("#pwd_login").val();
        var xemail = $("#pwd_login").val();

        if(!xpassword || !xemail){
            $(".error_msg").html("Empty password or Email");
            $(".xerror_modal").modal("show");
        }else if(validateEmail(xemail_input) == false){
            $(".error_msg").html("Invalid Email");
            $(".xerror_modal").modal("show");
        }

        jQuery.ajax({    
            data:{
                email:xemail,
                password:xpassword
            },
            dataType:"json",
            type:"post",
            url:"login_cc_ajax.php", 
            success: function(xdata){

                if(xdata['status'] == false){
                    $('.error_msg').html(xdata['msg']);
                    $(".xerror_modal").modal("show");
                }else{
                    document.forms.myforms.method = "post";
                    document.forms.myforms.target = "_self";
                    document.forms.myforms.action = "select_option.php";
                    document.forms.myforms.submit();
                }

                

            },
            error: function (request, status, error) {
            }
            
        })
    }
    </script>
    

<?php 
require "includes/cc_footer.php";
?>