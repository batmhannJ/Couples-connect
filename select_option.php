<?php
require "includes/cc_header.php";

$header_name = '';
if ($_SESSION['usertype'] == 'DSK') {
    $header_name = "DESK";
} else if ($_SESSION['usertype'] == 'CNR') {
    $header_name = "COUNSELOR";
} else if ($_SESSION['usertype'] == 'HED') {
    $header_name = "HEAD";
}


?>

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
    
    <div class="dashboard-grid" style="max-width: 1400px; margin: 0 auto; display: grid;">
        
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
                <?php
                    // IMPORTANT: Ensure cc_mf_menu.php uses the required classes: 
                    // .cc-menu-link, .sidebar-label, .cc-icon-wrap, .cc-profile-info, .cc-search-bar
                    require 'cc_mf_menu.php'; 
                ?>
            </div>
        </div>

        <div class="main-content-box" style=" 
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(255, 255, 255, 0.2);
            height: calc(100vh - 80px); 
            max-height: 650px; 
        ">

            <div style="padding: 20px 32px 16px 32px; text-align: center; border-bottom: 1px solid rgba(0, 0, 0, 0.05); flex-shrink: 0;">
                <h1 style="font-size: 26px; font-weight: 700; color: #1a1a1a; margin: 0 0 10px 0;">Please Select an Option</h1>
                <div style="height: 3px; background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%); border-radius: 2px; width: 300px; margin: 0 auto;"></div>
            </div>

            <div style="flex: 1; padding: 24px 32px; overflow-y: auto; min-height: 0; display: flex; align-items: center; justify-content: center;">
                <div style="background: rgba(255, 255, 255, 0.7); border-radius: 16px; border: 1px solid rgba(0, 0, 0, 0.05); width: 100%; max-width: 800px; padding: 40px; text-align: center;">
                    <div class="select-option-content" style="display: flex; justify-content: center; align-items: center; gap: 40px; flex-wrap: wrap;">
                        
                        <div style="flex: 0 0 auto;">
                            <img src="images/Rectangle 31.png" style='width:120px; height: auto; border-radius: 12px; box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);' alt="">
                        </div>

                        <div style='font-family:inter; color:#1a1a1a; font-size:28px; font-weight:600; flex: 1; min-width: 250px; text-align: center; background: linear-gradient(135deg, #4f46e5, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;'>
                            Please Select an Option
                        </div>

                        <div style="flex: 0 0 auto;">
                            <img src="images/Rectangle 30.png" style='width:120px; height: auto; border-radius: 12px; box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);' alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Global Styles (Retained) */
        .has_hover:hover { color: #4f46e5 !important; transition: color 0.2s ease; }
        
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
        .main-content-box { height: calc(100vh - 80px); max-height: 650px; }

        /* 2. Medium Screen Collapse (1200px) - Shrinks Sidebar to ONLY ICONS */
        @media (max-width: 1200px) {
            .dashboard-grid { 
                grid-template-columns: 80px 1fr !important; /* Sidebar width is 80px */
                gap: 16px !important; 
            }
            /* The following CSS assumes the structure inside cc_mf_menu.php has classes like .cc-menu-link, .sidebar-label, .cc-profile-info */
            .cc-sidebar { width: 80px !important; }
            
            /* *** CRITICAL FIX ENFORCEMENT *** */
            
            /* Force-hide the text label and related elements (Primary target) */
            .sidebar-label { 
                display: none !important; 
                opacity: 0 !important;
                width: 0 !important;
                overflow: hidden !important;
                max-width: 0 !important; /* Ensure it collapses fully */
            } 
            
            /* Hide Profile/Search elements that may contain text (Adjust if needed for your menu) */
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
            form { padding: 5px !important; min-height: auto !important; } /* Adjusted padding */
            
            /* DASHBOARD GRID FIX (Parent Container - Changed to Flex Column) */
            .dashboard-grid {
                 display: flex !important; 
                 flex-direction: column !important; 
                 gap: 8px !important;
                 width: 100% !important;
                 max-width: 100% !important;
                 margin: 0 !important;
                 padding: 0 !important; 
            }
            
            /* SIDEBAR CONTAINER (Icons Container - Now Horizontal) */
            .cc-sidebar {
                order: 1; 
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
                max-height: none !important;
                margin: 0 !important;
                padding: 8px 5px !important; 
                border-radius: 12px !important;
                
                /* Horizontal Icon Display */
                display: flex;
                flex-direction: row !important;
                justify-content: space-around; 
                align-items: center;
                overflow-x: auto; 
                white-space: nowrap; 
            }
            
            /* Small screen menu link adjustments to show icons */
            .cc-sidebar li { display: inline-block; } /* Forces list items horizontal */
            .sidebar-label { opacity: 1 !important; width: auto !important; overflow: visible !important; display: block; font-size: 10px; margin-top: 4px; } /* Re-enable labels small screens */
            .cc-menu-link { 
                 flex-direction: column; 
                 align-items: center; 
                 justify-content: center; 
                 padding: 4px;
                 width: auto !important; /* Let links take space needed for icon+label */
                 max-width: none !important;
            }
            
            /* MAIN CONTENT CONTAINER (Full Width) */
            .main-content-box {
                order: 2; 
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important; 
                max-height: none !important;
                margin: 0 !important;
                padding: 8px !important; 
            }

            /* Content Adjustments for Select Option */
            .main-content-box > div:first-child { padding: 12px !important; } /* Header padding */
            h1 { font-size: 20px !important; } /* Adjust Header size */
            
            /* Main Content Area Padding */
            .main-content-box > div:nth-child(2) { padding: 12px !important; } 

            /* Select Option Content Adjustments */
            .select-option-content {
                flex-direction: column !important;
                gap: 20px !important;
                padding: 20px !important; 
            }
             .select-option-content > div:nth-child(2) {
                font-size: 24px !important;
            }
            .select-option-content img {
                width: 100px !important;
            }
        }
        
        /* Scrollbar Styling (Kept) */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.05); border-radius: 4px; }
        ::-webkit-scrollbar-thumb { background: rgba(79, 70, 229, 0.3); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(79, 70, 229, 0.5); }
        
        /* Hover effects for images (Kept) */
        img { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        img:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important; }
    </style>

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
</form>

<script>
    function onReg() {

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

    function onLogin() {

        var xemail_input = document.getElementById("email_login");
        var xpassword = $("#pwd_login").val();
        var xemail = $("#pwd_login").val();

        if (!xpassword || !xemail) {
            $(".error_msg").html("Empty password or Email");
            $(".xerror_modal").modal("show");
        } else if (validateEmail(xemail_input) == false) {
            $(".error_msg").html("Invalid Email");
            $(".xerror_modal").modal("show");
        }

        jQuery.ajax({
            data: {
                email: xemail,
                password: xpassword
            },
            dataType: "json",
            type: "post",
            url: "login_cc_ajax.php",
            success: function(xdata) {

                if (xdata['status'] == false) {
                    $('.error_msg').html(xdata['msg']);
                    $(".xerror_modal").modal("show");
                } else {
                    document.forms.myforms.method = "post";
                    document.forms.myforms.target = "_self";
                    document.forms.myforms.action = "select_option.php";
                    document.forms.myforms.submit();
                }



            },
            error: function(request, status, error) {}

        })
    }
</script>

<?php
require "includes/cc_footer.php";
?>