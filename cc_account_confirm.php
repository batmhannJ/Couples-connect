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

    <form name='myforms' id="myforms" method="post" target="_self" style='min-height:100vh; background: linear-gradient(135deg, rgb(215, 217, 225) 0%, rgb(162, 185, 231) 100%); padding: 20px; font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;'>
    <div style="max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: 320px 1fr; gap: 24px; height: calc(100vh - 40px);">
        
        <!-- Left Sidebar -->
        <div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 24px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); padding: 24px 20px; height: fit-content; max-height: calc(100vh - 80px); border: 1px solid rgba(255, 255, 255, 0.2); overflow-y: auto;">
            <div style="text-align: center; margin-bottom: 20px;">
                <h2 style="font-size: 24px; font-weight: 700; color: #1a1a1a; margin: 0 0 12px 0;">Options</h2>
                <div style="height: 3px; background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%); border-radius: 2px; width: 100%;"></div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px;">
                <?php
                    require 'cc_mf_menu.php';
                ?>
            </div>
        </div>

        <!-- Main Content -->
        <div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 24px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; border: 1px solid rgba(255, 255, 255, 0.2); height: calc(100vh - 80px); overflow: hidden;">

            <!-- Header -->
            <div style="padding: 20px 32px 16px 32px; text-align: center; border-bottom: 1px solid rgba(0, 0, 0, 0.05); flex-shrink: 0;">
                <h1 style="font-size: 26px; font-weight: 700; color: #1a1a1a; margin: 0 0 10px 0;">Account Confirmation</h1>
                <div style="height: 3px; background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%); border-radius: 2px; width: 260px; margin: 0 auto;"></div>
            </div>

            <!-- Table Content -->
            <div style="flex: 1; padding: 24px 32px; overflow-y: auto; min-height: 0;">
                <div style="background: rgba(255, 255, 255, 0.7); border-radius: 16px; border: 1px solid rgba(0, 0, 0, 0.05); min-height: 100%; display: flex; flex-direction: column;">
                    
                    <!-- Table Header -->
                    <div style="padding: 24px 32px 16px 32px; border-bottom: 1px solid rgba(0, 0, 0, 0.08);">
                        <div style="display: grid; grid-template-columns: 1fr 1fr 200px; gap: 24px; align-items: center;">
                            <div style="font-size: 18px; font-weight: 700; color: #4f46e5;">
                                Email
                            </div>
                            <div style="font-size: 18px; font-weight: 700; color: #4f46e5;">
                                Date Requested
                            </div>
                            <div style="font-size: 18px; font-weight: 700; color: #4f46e5; text-align: center;">
                                Action
                            </div>
                        </div>
                    </div>

                    <!-- Table Body -->
                    <div style="flex: 1; padding: 0 32px 24px 32px; overflow-y: auto;">
                        <div style="display: flex; flex-direction: column; gap: 12px; padding-top: 16px;">
                            
                            <?php
                                $select_db_ac="SELECT * FROM mf_prog_users WHERE usertype = 'USR' AND act_status = 'FA' ORDER BY date_requested DESC";
                                $stmt	= $link->prepare($select_db_ac);
                                $stmt->execute();
                                while($rs_ac = $stmt->fetch()) {
                                    
                                    echo "<div style='background: rgba(255, 255, 255, 0.8); border-radius: 12px; padding: 20px; border: 1px solid rgba(0, 0, 0, 0.05); transition: all 0.2s ease; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);' onmouseover='this.style.boxShadow=\"0 4px 16px rgba(0, 0, 0, 0.08)\"; this.style.transform=\"translateY(-2px)\";' onmouseout='this.style.boxShadow=\"0 2px 8px rgba(0, 0, 0, 0.04)\"; this.style.transform=\"translateY(0)\";'>";
                                        echo "<div style='display: grid; grid-template-columns: 1fr 1fr 200px; gap: 24px; align-items: center;'>";
                                            echo "<div style='font-size: 16px; font-weight: 600; color: #1f2937; word-break: break-word;'>";
                                                echo "".$rs_ac['username']."";
                                            echo "</div>";
                                            echo "<div style='font-size: 16px; font-weight: 500; color: #6b7280;'>";
                                                echo "".date('F d, Y', strtotime($rs_ac['date_requested']))."";
                                            echo "</div>";
                                            echo "<div style='display: flex; justify-content: center;'>";
                                                echo "<button onclick='review(\"{$rs_ac['recid']}\")' type='button' style='background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: white; border: none; padding: 12px 24px; border-radius: 12px; font-size: 15px; font-family: Inter; font-weight: 600; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3); cursor: pointer; transition: all 0.3s ease; width: 140px;' onmouseover='this.style.transform=\"translateY(-2px)\"; this.style.boxShadow=\"0 6px 20px rgba(79, 70, 229, 0.4)\";' onmouseout='this.style.transform=\"translateY(0)\"; this.style.boxShadow=\"0 4px 12px rgba(79, 70, 229, 0.3)\";'>";
                                                    echo "Review";
                                                echo "</button>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</div>";
                                }
                            ?>

                        </div>
                    </div>
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
            
            /* Stack table columns on mobile */
            form > div > div:last-child > div:last-child > div > div:first-child > div,
            form > div > div:last-child > div:last-child > div > div:last-child > div > div > div {
                grid-template-columns: 1fr !important;
                gap: 12px !important;
                text-align: center !important;
            }
            
            h1 {
                font-size: 22px !important;
            }
            
            h2 {
                font-size: 20px !important;
            }
            
            /* Mobile table styling */
            form > div > div:last-child > div:last-child > div > div:last-child > div > div {
                padding: 16px !important;
                text-align: center !important;
            }
            
            form > div > div:last-child > div:last-child > div > div:first-child > div > div {
                display: none !important; /* Hide desktop headers on mobile */
            }
            
            /* Add mobile headers */
            form > div > div:last-child > div:last-child > div > div:last-child > div > div > div > div:first-child::before {
                content: "Email: ";
                font-weight: 700;
                color: #4f46e5;
                display: block;
                margin-bottom: 4px;
            }
            
            form > div > div:last-child > div:last-child > div > div:last-child > div > div > div > div:nth-child(2)::before {
                content: "Date Requested: ";
                font-weight: 700;
                color: #4f46e5;
                display: block;
                margin-bottom: 4px;
            }
        }
        
        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(79, 70, 229, 0.3);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(79, 70, 229, 0.5);
        }
    </style>

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

