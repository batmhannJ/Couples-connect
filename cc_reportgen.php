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

            <div class="col-3 offset-6" style="display:flex;flex-direction:row;justify-content:center;font-family:inter;font-size:21px;align-items:center"> 
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
                    <a href="http://localhost/couples-connect/logout_cc.php"  class='has_hover' style='color:black;text-decoration:none'>LOGOUT</a>
                </div>

            </div> 
        </div>
    </div>

   <form name='myforms' id="myforms" method="post" target="_self" style='min-height:100vh; background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #0ea5e9 100%); padding: 20px; font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;'>
    <div style="max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: 320px 1fr; gap: 24px; height: calc(100vh - 40px);">
        
        <!-- Left Sidebar -->
        <div style="background: rgba(255, 255, 255, 0.97); backdrop-filter: blur(10px); border-radius: 24px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2); padding: 24px 20px; height: fit-content; max-height: calc(100vh - 80px); border: 1px solid rgba(255, 255, 255, 0.3); overflow-y: auto;">
            <div style="text-align: center; margin-bottom: 24px;">
                <div style="display: inline-flex; align-items: center; justify-content: center; width: 56px; height: 56px; background: linear-gradient(135deg, #1e40af 0%, #0ea5e9 100%); border-radius: 16px; margin-bottom: 12px; box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);">
                    <i class="bi bi-folder-fill" style="font-size: 28px; color: white;"></i>
                </div>
                <h2 style="font-size: 24px; font-weight: 700; color: #0f172a; margin: 0 0 8px 0;">Options</h2>
                <div style="height: 3px; background: linear-gradient(90deg, #1e40af 0%, #0ea5e9 100%); border-radius: 2px; width: 80px; margin: 0 auto;"></div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px;">
                <?php
                    require 'cc_mf_menu.php';
                ?>
            </div>
        </div>

        <!-- Main Content -->
        <div style="background: rgba(255, 255, 255, 0.97); backdrop-filter: blur(10px); border-radius: 24px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2); display: flex; flex-direction: column; border: 1px solid rgba(255, 255, 255, 0.3); height: calc(100vh - 80px); overflow-y: auto;">

            <!-- Header -->
            <div style="padding: 24px 32px 20px 32px; text-align: center; border-bottom: 2px solid rgba(0, 0, 0, 0.06); flex-shrink: 0; background: linear-gradient(135deg, rgba(30, 64, 175, 0.05) 0%, rgba(14, 165, 233, 0.05) 100%);">
                <div style="display: inline-flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <i class="bi bi-file-earmark-bar-graph-fill" style="font-size: 32px; color: #1e40af;"></i>
                    <h1 style="font-size: 28px; font-weight: 700; color: #0f172a; margin: 0;">City Planning Office Report</h1>
                </div>
                <p style="color: #475569; font-size: 14px; margin: 8px 0 12px 0;">Generate comprehensive planning reports and statistics</p>
                <div style="height: 3px; background: linear-gradient(90deg, #1e40af 0%, #0ea5e9 100%); border-radius: 2px; width: 240px; margin: 0 auto;"></div>
            </div>

            <!-- Date Selection Section -->
            <div style="padding: 24px 32px; flex-shrink: 0;">
                <div style="background: linear-gradient(135deg, rgba(30, 64, 175, 0.05) 0%, rgba(14, 165, 233, 0.05) 100%); border-radius: 16px; padding: 28px; border: 2px solid rgba(30, 64, 175, 0.1); box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                        <i class="bi bi-calendar-range" style="font-size: 20px; color: #1e40af;"></i>
                        <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0;">Report Period</h3>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; align-items: end;">
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="font-weight: 600; color: #334155; font-size: 14px; display: flex; align-items: center; gap: 6px;">
                                <i class="bi bi-calendar-check" style="color: #1e40af;"></i>
                                Start Date:
                            </label>
                            <input type="date" class="form-control period_from" name="period_from" id='period_from' style="border: 2px solid #cbd5e1; border-radius: 12px; padding: 12px 16px; font-size: 14px; background: white; transition: all 0.2s ease; font-family: Inter;">
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="font-weight: 600; color: #334155; font-size: 14px; display: flex; align-items: center; gap: 6px;">
                                <i class="bi bi-calendar-x" style="color: #1e40af;"></i>
                                End Date:
                            </label>
                            <input type="date" class="form-control period_to" name="period_to" id='period_to' style="border: 2px solid #cbd5e1; border-radius: 12px; padding: 12px 16px; font-size: 14px; background: white; transition: all 0.2s ease; font-family: Inter;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Content -->
            <div style="flex: 1; padding: 0 32px 24px 32px; display: flex; flex-direction: column; gap: 20px; min-height: 0;">
                
                <!-- Planning Applications Section -->
                <div style="background: linear-gradient(135deg, rgba(30, 64, 175, 0.03) 0%, rgba(14, 165, 233, 0.03) 100%); border-radius: 16px; padding: 24px; border: 2px solid rgba(30, 64, 175, 0.1); box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);">
                    <h3 style="font-size: 20px; font-weight: 700; color: #0f172a; margin: 0 0 16px 0; display: flex; align-items: center; gap: 10px;">
                        <div style="width: 6px; height: 28px; background: linear-gradient(135deg, #1e40af 0%, #0ea5e9 100%); border-radius: 3px;"></div>
                        <i class="bi bi-file-text-fill" style="color: #1e40af; font-size: 22px;"></i>
                        Planning Applications
                    </h3>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <?php
                            $select_db_totalapps = "SELECT COUNT(*) as xcount FROM pro_meiform WHERE status='PMO'";
                            $stmt_totalapps = $link->prepare($select_db_totalapps);
                            $stmt_totalapps->execute();
                            while($rs_totalapps = $stmt_totalapps->fetch()){                                                
                                echo "<div style='background: rgba(30, 64, 175, 0.08); border-radius: 12px; padding: 16px; border-left: 4px solid #1e40af; transition: all 0.2s ease;'>";
                                echo "<span style='font-size: 16px; font-weight: 600; color: #1e293b; font-family: Inter;'>Total Approved Applications: <span style='color: #1e40af; font-weight: 700;'>".$rs_totalapps['xcount']."</span></span>";
                                echo "</div>";
                            }

                            $select_db_pending = "SELECT COUNT(*) as xcount FROM pro_meiform WHERE status='PMC'";
                            $stmt_pending = $link->prepare($select_db_pending);
                            $stmt_pending->execute();
                            while($rs_pending = $stmt_pending->fetch()){
                                echo "<div style='background: rgba(249, 115, 22, 0.08); border-radius: 12px; padding: 16px; border-left: 4px solid #f97316; transition: all 0.2s ease;'>";
                                echo "<span style='font-size: 15px; font-weight: 500; color: #334155; font-family: Inter;'>Pending Applications: <span style='color: #f97316; font-weight: 700;'>".$rs_pending['xcount']."</span></span>";
                                echo "</div>";
                            }
                        ?>
                    </div>
                </div>

                <!-- Building Permits Section -->
                <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.03) 0%, rgba(5, 150, 105, 0.03) 100%); border-radius: 16px; padding: 24px; border: 2px solid rgba(16, 185, 129, 0.1); box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);">
                    <h3 style="font-size: 20px; font-weight: 700; color: #0f172a; margin: 0 0 16px 0; display: flex; align-items: center; gap: 10px;">
                        <div style="width: 6px; height: 28px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 3px;"></div>
                        <i class="bi bi-building" style="color: #10b981; font-size: 22px;"></i>
                        Building Permits
                    </h3>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <?php
                            $select_db_permits = "SELECT COUNT(*) as xcount FROM pro_meiform WHERE status='PMC'";
                            $stmt_permits = $link->prepare($select_db_permits);
                            $stmt_permits->execute();
                            while($rs_permits = $stmt_permits->fetch()){
                                echo "<div style='background: rgba(16, 185, 129, 0.08); border-radius: 12px; padding: 16px; border-left: 4px solid #10b981; transition: all 0.2s ease;'>";
                                echo "<span style='font-size: 16px; font-weight: 600; color: #1e293b; font-family: Inter;'>Total Issued Permits: <span style='color: #10b981; font-weight: 700;'>".$rs_permits['xcount']."</span></span>";
                                echo "</div>";
                            }
                            
                            $total_residential = 0;
                            $stmt_permits->execute();
                            while($rs_permits = $stmt_permits->fetch()){
                                $total_residential += 5;
                            }
                        ?>
                        <div style="background: rgba(14, 165, 233, 0.08); border-radius: 12px; padding: 16px; border-left: 4px solid #0ea5e9; transition: all 0.2s ease;">
                            <span style="font-size: 15px; font-weight: 500; color: #334155; font-family: Inter;">Residential Permits: <span style="color: #0ea5e9; font-weight: 700;"><?php echo $total_residential; ?></span></span>
                        </div>
                        <div style="background: rgba(139, 92, 246, 0.08); border-radius: 12px; padding: 16px; border-left: 4px solid #8b5cf6; transition: all 0.2s ease;">
                            <span style="font-size: 15px; font-weight: 500; color: #334155; font-family: Inter;">Commercial Permits: <span style="color: #8b5cf6; font-weight: 700;">0</span></span>
                        </div>
                    </div>
                </div>

                <!-- Zoning & Land Use Section -->
                <div style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.03) 0%, rgba(217, 119, 6, 0.03) 100%); border-radius: 16px; padding: 24px; border: 2px solid rgba(245, 158, 11, 0.1); box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);">
                    <h3 style="font-size: 20px; font-weight: 700; color: #0f172a; margin: 0 0 16px 0; display: flex; align-items: center; gap: 10px;">
                        <div style="width: 6px; height: 28px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 3px;"></div>
                        <i class="bi bi-map-fill" style="color: #f59e0b; font-size: 22px;"></i>
                        Zoning & Land Use
                    </h3>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <?php
                            $select_db_ac = "SELECT * FROM mf_concerns";
                            $stmt = $link->prepare($select_db_ac);
                            $stmt->execute();
                            $zoning_colors = ['#0ea5e9', '#8b5cf6', '#10b981', '#f59e0b', '#ef4444'];
                            $color_index = 0;
                            
                            while($rs_ac = $stmt->fetch()){
                                try {
                                    $select_db_ac2 = "SELECT COUNT(*) as xcount FROM pro_counselorbooking";
                                    $stmt2 = $link->prepare($select_db_ac2);
                                    $stmt2->execute();
                                    $xcount = 0;
                                    while($rs_ac2 = $stmt2->fetch()){
                                        $xcount = $rs_ac2["xcount"];
                                    }
                                } catch(PDOException $e) {
                                    $xcount = 0;
                                }
                                
                                $current_color = $zoning_colors[$color_index % count($zoning_colors)];
                                $color_index++;
                                $r = hexdec(substr($current_color, 1, 2));
                                $g = hexdec(substr($current_color, 3, 2));
                                $b = hexdec(substr($current_color, 5, 2));
                                
                                echo "<div style='background: rgba({$r}, {$g}, {$b}, 0.08); border-radius: 12px; padding: 16px; border-left: 4px solid {$current_color}; transition: all 0.2s ease;'>";
                                echo "<span style='font-size: 15px; font-weight: 500; color: #334155; font-family: Inter;'>Zone Type - ".$rs_ac['concerns'].": <span style='color: {$current_color}; font-weight: 700;'>".$xcount."</span></span>";
                                echo "</div>";
                            }
                        ?>
                    </div>
                </div>

                <!-- Export Button -->
                <div style="display: flex; justify-content: center; padding: 20px 0;">
                    <button type="button" onclick="acc_choose('DEC')" style="background: linear-gradient(135deg, #1e40af 0%, #0ea5e9 100%); color: white; border: none; padding: 16px 48px; border-radius: 16px; font-size: 16px; font-family: Inter; font-weight: 700; box-shadow: 0 8px 24px rgba(30, 64, 175, 0.4); cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 12px;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 32px rgba(30, 64, 175, 0.5)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 24px rgba(30, 64, 175, 0.4)'">
                        <i class="bi bi-download" style="font-size: 20px;"></i>
                        Generate & Export Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Design -->
    <style>
        @media (max-width: 1200px) {
            form > div {
                grid-template-columns: 1fr !important;
                gap: 16px !important;
            }
            
            form > div > div:first-child {
                order: 2;
                height: auto !important;
                max-height: none !important;
            }
            
            form > div > div:last-child {
                order: 1;
                height: auto !important;
            }
        }
        
        @media (max-width: 768px) {
            form {
                padding: 12px !important;
            }
            
            form > div > div:nth-child(2) > div:nth-child(2) > div > div {
                grid-template-columns: 1fr !important;
                gap: 16px !important;
            }
            
            h1 {
                font-size: 24px !important;
            }
            
            h2 {
                font-size: 20px !important;
            }
            
            h3 {
                font-size: 18px !important;
            }
            
            .period_from, .period_to {
                padding: 10px 12px !important;
                font-size: 13px !important;
            }
        }
        
        .period_from:focus, .period_to:focus {
            border-color: #1e40af !important;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.15) !important;
            outline: none !important;
        }
        
        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #1e40af 0%, #0ea5e9 100%);
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #1e3a8a 0%, #0284c7 100%);
        }

        /* Hover effects for stat cards */
        [style*="border-left: 4px solid"]:hover {
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>

    <!-- Modal -->
    <div class="modal fade xerror_modal" data-bs-backdrop="static" id="xerror_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15); background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(20px);">
                <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 24px 32px; background: linear-gradient(135deg, rgba(30, 64, 175, 0.05) 0%, rgba(14, 165, 233, 0.05) 100%);">
                    <h5 class="modal-title" style="font-weight: 700; color: #0f172a; font-size: 20px; display: flex; align-items: center; gap: 10px;">
                        <i class="bi bi-info-circle-fill" style="color: #1e40af;"></i>
                        City Planning Office Says:
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 24px 32px 32px 32px;">
                    <p class="error_msg" style="color: #475569; margin: 0; font-size: 14px; line-height: 1.6;">Modal body text goes here.</p>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="ac_recid_hidden" id="ac_recid_hidden">
    
</form>


    <script>

function acc_choose(action) {
    if (action === 'DEC') {
        var period_from = $('#period_from').val();
        var period_to = $('#period_to').val();
        
        if (!period_from || !period_to) {
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
            // Update your CPO statistics here
            console.log('Report data updated');
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
    if(calendarEl){
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
    }
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