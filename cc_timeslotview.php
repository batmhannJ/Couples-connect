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
    <style>
        .fc-event:hover{
            cursor:pointer;
        }

        .fc .fc-event-title {
            font-size: 12px;
            font-weight:500;
        }
    </style>

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
                <h1 style="font-size: 26px; font-weight: 700; color: #1a1a1a; margin: 0 0 10px 0;">Calendar</h1>
                <div style="height: 3px; background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%); border-radius: 2px; width: 200px; margin: 0 auto;"></div>
            </div>

            <!-- Calendar Content -->
            <div style="flex: 1; padding: 24px 32px; overflow-y: auto; min-height: 0;">
                <div style="background: rgba(255, 255, 255, 0.7); border-radius: 16px; border: 1px solid rgba(0, 0, 0, 0.05); height: 100%; display: flex; flex-direction: column;">
                    <div style="flex: 1; padding: 24px; overflow-y: auto;">
                        <div id="calendar" class="text-decoration-none" style="height: 100%; min-height: 500px;"></div>
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
            
            h1 {
                font-size: 22px !important;
            }
            
            h2 {
                font-size: 20px !important;
            }
            
            form > div > div:last-child > div:last-child > div > div {
                padding: 16px !important;
            }
            
            #calendar {
                min-height: 400px !important;
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

    <!-- Error Modal -->
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

    <!-- Calendar Modal -->
    <div class="modal fade" tabindex="-1" id="modal_calendar" name="modal_calendar">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15); background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(20px);">
                <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 24px 32px;">
                    <h5 class="modal-title modal_title_calendar" style="font-weight: 700; color: #1f2937; font-size: 24px;">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 24px 32px 32px 32px;">
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <div>
                            <label style="font-weight: 700; font-size: 16px; color: #4f46e5; display: block; margin-bottom: 8px;">Counselor's Email</label>
                            <div class='counselor_email' name='counselor_email' id='counselor_email' style='font-size: 16px; color: #6b7280; background: rgba(243, 244, 246, 0.8); padding: 12px 16px; border-radius: 12px; border: 1px solid rgba(0, 0, 0, 0.05);'></div>
                        </div>

                        <div>
                            <label style="font-weight: 700; font-size: 16px; color: #4f46e5; display: block; margin-bottom: 8px;">Date:</label>
                            <div class='modal_date' name='modal_date' id='modal_date' style='font-size: 16px; color: #6b7280; background: rgba(243, 244, 246, 0.8); padding: 12px 16px; border-radius: 12px; border: 1px solid rgba(0, 0, 0, 0.05);'></div>
                        </div>

                        <div>
                            <label style="font-weight: 700; font-size: 16px; color: #4f46e5; display: block; margin-bottom: 8px;">Venue:</label>
                            <div class='modal_venue' name='modal_venue' id='modal_venue' style='font-size: 16px; color: #6b7280; background: rgba(243, 244, 246, 0.8); padding: 12px 16px; border-radius: 12px; border: 1px solid rgba(0, 0, 0, 0.05);'></div>
                        </div>

                        <div>
                            <label style="font-weight: 700; font-size: 16px; color: #4f46e5; display: block; margin-bottom: 8px;">Time:</label>
                            <div class='modal_time' name='modal_time' id='modal_time' style='font-size: 16px; color: #6b7280; background: rgba(243, 244, 246, 0.8); padding: 12px 16px; border-radius: 12px; border: 1px solid rgba(0, 0, 0, 0.05);'></div>
                        </div>

                        <div>
                            <label style="font-weight: 700; font-size: 16px; color: #4f46e5; display: block; margin-bottom: 8px;">Schedule Type:</label>
                            <div class='modal_schedtype' name='modal_schedtype' id='modal_schedtype' style='font-size: 16px; color: #6b7280; background: rgba(243, 244, 246, 0.8); padding: 12px 16px; border-radius: 12px; border: 1px solid rgba(0, 0, 0, 0.05);'></div>
                        </div>

                        <div class='participants_pmo' style="margin-top: 8px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>        
    
</form>

    <script>

    // document.addEventListener('DOMContentLoaded', function() {
    //     var calendarEl = document.getElementById('calendar');
    //     var calendar = new FullCalendar.Calendar(calendarEl, {
    //       height:650,
    //       initialView: 'dayGridMonth',
    //       header: {
    //         left: '',
    //         center: '',
    //         right: ''
    //       }
    //     });

    //     calendar.addEvent({
    //         title: 'Second Event',
    //         start: '2024-03-08T12:30:00',
    //         end: '2024-03-08T13:30:00'
    //     });

    //     calendar.render();
    // });

        jQuery(document).ready(function() {

            xdata = 'halo';
            jQuery.ajax({    
                data:xdata,
                dataType:"json",
                type:"post",
                url:"cc_timeslotview_ajax.php", 
                success: function(xdata){

                    console.log(xdata);

                        var calendarEl = document.getElementById('calendar');
                        var calendar = new FullCalendar.Calendar(calendarEl, {
                        height:1000,
                        contentHeight:"auto",
                        initialView: 'dayGridMonth',
                        displayEventTime: false,
                        header: {
                            left: '',
                            center: '',
                            right: ''
                        },
                        eventClick: function(info) {

                            var email_date = info.event.id.split(","); 
                            var new_schedtype = "";

                            if(email_date[2] == "PMO"){
                                new_schedtype = "(PMO) Pre-Marriage Orientation";
                            }else{
                                new_schedtype = "(PMC) Pre-Marriage Counseling";
                            }

                            $(".modal_title_calendar").html(email_date[0]+'s schedule');
                            $(".counselor_email").html(email_date[0]);
                            $(".modal_date").html(email_date[1]);
                            $(".modal_venue").html(email_date[4]);
                            $(".modal_schedtype").html(new_schedtype);
               
                            $(".modal_time").html(info.event.title);

                            if(email_date[2] == "PMO"){
                                $(".participants_pmo").html(`
                                <label for="" class='fw-bold pt-3' style='font-size:25px'>Participants:</label>
                                <div class='modal_schedtype' name='modal_schedtype' id='modal_schedtype' style='font-size:25px'>${email_date[3]}</div>
                                `);
                            }else{
                                $(".participants_pmo").html('');
                            }

                            $("#modal_calendar").modal("show");

                            info.el.style.borderColor = 'red';
                        }
                        });

                        var simplified_xdata = ['retEdit'];
                        var xcounter = 0;

                        for (var key in xdata.retEdit) {
                            var c_event = xdata.retEdit[key];

                            calendar.addEvent({
                                id: c_event.email_date,
                                title: c_event.title,
                                start: c_event.start,
                                end: c_event.end,
                                allDay: false,
                                meridiem: false
                            });
                            xcounter++;
                        }

                        // for (var key in xdata.retEdit) {
                        //     var event = xdata.retEdit[key];
                        //     console.log("Title: " + event.title);
                        //     console.log("Start: " + event.start);
                        //     console.log("End: " + event.end);
                        //     console.log("Key: " + event.key);
                        // }

                        calendar.render();
            
                },
                error: function (request, status, error) {
                }
                
            })

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

