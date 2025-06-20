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
                    <a href="http://localhost/couplesconnectprog/select_option.php" style='color:black;text-decoration:none' class='has_hover'>HOME</a>
                </div>

                <div style="flex:.1;text-align:center;padding-right:10px">
                    <a style='color:black;text-decoration:none'>|</a>
                </div>

                <div style="flex:.3;text-align:center;padding-right:15px">
                    <a style='color:black;text-decoration:none'><?php echo $header_name;?> </a>
                </div>

                <div style="flex:0.6;text-align:right;padding-right:35px">
                    <a href="http://localhost/couplesconnectprog/logout_cc.php"  class='has_hover' style='color:black;text-decoration:none'>LOGOUT</a>
                </div>

            </div> 
        </div>
    </div>

    <form name='myforms' id="myforms" method="post" target="_self" style='height:100%'> 
    <table style="width:100%;height:100%;background-color:#f2f2f2">
            <tr>
                <td style='width:30%'>
                    <div class="row h-100 justify-content-center align-items-center">
                        <div style='width:437px;height:700px;background-color:white;border-radius:30px;filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25))'>
                            <div class="m-3 pt-2 text-center login_form_header">
                                <p style="font-weight:bold;font-size:27px;font-family:inter;margin-bottom:0">Options</p>
                                <img src="images/Rectangle 11934.png" style='width:100%'>
                            </div>

                            <?php
                                require 'cc_mf_menu.php';
                            ?>

                         
                        </div>
                    </div>
                </td>

                <td style='width:70%'>
                    <div class="row h-100 justify-content-center align-items-center">
                        <div style='width:1025px;height:700px;background-color:white;border-radius:30px;filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25));display:flex;flex-direction:column'>
                            <div class="m-3 pt-2">
                                <br />
                                <br style='display:block;margin:16px 0;content:""'/>
                                <img src="images/Rectangle 11934.png" style='width:100%;height:4px'>
                            </div>

    
                            <div class="container d-flex align-items-top" style='width:100%;height:100%;overflow-y:auto'>
                                <div class="container">
                                    <div id="calendar" class="text-decoration-none" style="padding-bottom:50px"></div>
                                </div>

                            </div>
  
                        </div>
                    </div>
                </td>    
            </tr>
        
        </table>

        <div class="modal fade  xerror_modal" data-bs-backdrop="static" id="xerror_modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Couples Connect Says:</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="error_msg">Modal body text goes here.</p>
                    </div>
     
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="modal_calendar" name="modal_calendar">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title modal_title_calendar" style='font-size:30px'>Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="" class='fw-bold' style='font-size:25px'>Counselor's Email</label>
                    <div class='counselor_email' name='counselor_email' id='counselor_email' style='font-size:25px'></div>

                    <label for="" class='fw-bold pt-3' style='font-size:25px'>Date:</label>
                    <div class='modal_date' name='modal_date' id='modal_date' style='font-size:25px'></div>

                    <label for="" class='fw-bold pt-3' style='font-size:25px'>Venue:</label>
                    <div class='modal_venue' name='modal_venue' id='modal_venue' style='font-size:25px'></div>

                    <label for="" class='fw-bold pt-3' style='font-size:25px'>Time:</label>
                    <div class='modal_time' name='modal_time' id='modal_time' style='font-size:25px'></div>

                    <label for="" class='fw-bold pt-3' style='font-size:25px'>Schedule Type:</label>
                    <div class='modal_schedtype' name='modal_schedtype' id='modal_schedtype' style='font-size:25px'></div>


                    <span class='participants_pmo'>

                    </span>

                </div>
            </div>
        </div>        

        <!-- <footer style='height:100px;background-color:#23408E' class='footer'>
            <div class="container-fluid"  style='height:100px'>

                <div class="row"  style='height:100px'>
                    <div class="col-4">
                        <div class="row ms-3"  style='height:100px'>
                            <div class="col-2 d-flex align-items-center">
                                <img src="images/op office logo.png" style="height:77px;width:auto">
                            </div>

                            <div class="col-10 d-flex align-items-center">
                                <div class="container" style='font-family:inter;color:white'>
                                    <div class="col-12" style='font-size:15px;font-weight:bold'>
                                        City Population Office of Cabuyao
                                    </div>

                                    <div class="col-12" style='font-size:9px'>
                                        Brgy Dos. Cabuyao Retail Plaza, Cabuyao, Philippines
                                    </div>

                                    <div class="col-12" style='font-size:9px'>
                                        cpocabuyao@gmail.com
                                    </div>

                                </div>
          
                            </div>
                        </div>       
                    </div>

                    <div class="col-8 d-flex align-items-center justify-content-end">
                        <div>
                            <img src="images/pajamas_question.png" style='width:63px;height:auto;'>
                        </div>   
                    </div>
                </div>

            </div>
        </footer> -->
        
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

