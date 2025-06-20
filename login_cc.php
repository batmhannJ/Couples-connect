<?php
require "includes/cc_header.php";
?>

    <div class="container-fluid">
        <div class='row bg-white' style="height:99px">
            <div class="col-3 pe-0 d-flex align-items-center">
                <img src="images/350 x 88.png" style='height:76px;width:auto;'>
            </div>

            <div class="col-4 offset-5" style="display:flex;flex-direction:row;justify-content:center;font-family:inter;font-size:21px;align-items:center"> 
                <div style="flex:0.8">
                    <a href="http://localhost/couples-connect/login_cc.php" class="has_hover" style='color:black;text-decoration:none'>HOME</a>
                </div>

                <div style="flex:1.1">
                    
                    <a href="http://localhost/couples-connect/about-us/" class="has_hover" style='color:black;text-decoration:none'>ABOUT US</a>

                </div>

                <div style="flex:1.1">
                    <a href="http://localhost/couples-connect/contact-us/" class="has_hover" style='color:black;text-decoration:none'>CONTACTS</a>
                </div>

                <div style="flex:1">
                    <a href="http://localhost/couples-connect/login_cc.php" class="has_hover" style='color:black;text-decoration:none'>| LOGIN</a>
                </div>

            </div> 
        </div>
    </div>

    <form name='myforms' id="myforms" method="post" target="_self" style='height:100%'> 
        <table style="width:100%;height:calc(100% - 100px);	filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25))">
            <tr>
                <td>
                    <div class="row h-100 justify-content-center align-items-center">
                        <div style='width:554px;height:572px;background-color:white;border-radius:30px'>
                            <div class="m-3 pt-2 text-center login_form_header">
                                <p style="font-weight:bold;font-size:25px;font-family:inter;font-size:33px">Login</p>
                            </div>

                            <div class="m-3 px-3 form-group">
                                <label class='form-label'style="color:black;font-size:21px">Email:</label>
                                <input type='text' name='email_login' id='email_login' placeholder='Enter your email' style="height:63px;border:1px solid black;" class="form-control rounded input_sub;" autocomplete='off'>
                            </div>

                            <div class="m-3 px-3  form-group">
                                <label class='form-label' style="color:black;font-size:21px">Password: </label>
                                <input type='password' name="pwd_login" placeholder='Enter your password' id='pwd_login' style="height:63px;border:1px solid black;" class="form-control roundedinput_sub" autocomplete='off'>
                            </div>

                            <div class="m-3 pt-3 form-group d-flex align-items-center justify-content-center">
                                <button type="button" onclick="onLogin()" class="btn" style="background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:329px;height:63px;font-size:30px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Log in</button>
                            </div>

                            <div class="container">
                                <div class="row d-flex justify-content-center" style="align-items: stretch;">
                                    <div class="col-3">
                                        <img src="images/Rectangle 31.png" style='width:100px' alt="">
                                    </div>

                                    <div class="col-5 text-center" style='font-family:inter;color:#9FA2B4;font-size:18px'>
                                        Forgot Password
                                    </div>

                                    <div class="col-3">
                                        <img src="images/Rectangle 30.png"  style='width:100px' alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="m-3 pt-3 form-group d-flex align-items-center justify-content-center">
                                <button type="button" onclick="onReg()" class="btn" style="background-color:#3DCF26;color:white;width:329px;height:63px;font-size:23px;font-family:inter;font-weight:700;border-radius:10px;  box-shadow: inset 7px -2px 4px rgba(0, 0, 0, 0.25);filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Create new account</button>
                            </div>

                            <div class="alert alert-danger text-center m-3"  style="display:none" id="div_msg" role="alert">
                                <span class='span_msg' id='span_msg'></span>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        
        </table>

        <div class="modal fade xerror_modal" data-bs-backdrop="static" id="xerror_modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Couples Connect Says:</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="error_msg">Modal body text goes here.</p>
                        
                        <!-- Add this reapply section -->
                        <div id="reapply-section" style="display: none; margin-top: 15px;">
                            <hr>
                            <p class="text-info" style="font-size: 16px; margin-bottom: 10px;">You can reapply for account approval:</p>
                            <button type="button" id="reapply-btn" class="btn btn-success" style="width: 100%; padding: 10px;">
                                <i class="fas fa-redo"></i> Click to Reapply
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer style='height:100px;background-color:#23408E' class='footer'>
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
        </footer>
        
    </form>

    <script>
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
            var xemail = $("#email_login").val();
            var xerror = true;

            if(!xpassword || !xemail){
                $(".error_msg").html("Empty password or Email");
                $("#reapply-section").hide(); // Hide reapply section
                $(".xerror_modal").modal("show");

            }else if(validateEmail(xemail_input) == false){
                $(".error_msg").html("Invalid Email");
                $("#reapply-section").hide(); // Hide reapply section
                $(".xerror_modal").modal("show");
            }else{

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
                            
                            // Check if reapply button should be shown
                            if(xdata['show_reapply'] === true){
                                $('#reapply-section').show();
                                $('#reapply-btn').data('recid', xdata['recid']); // Store recid for reapply
                            } else {
                                $('#reapply-section').hide();
                            }
                            
                            $(".xerror_modal").modal("show");
                        }else{

                            var login_after = "select_option.php";

                            if(xdata["userlvl"] == "USR"){
                                login_after = "dashboard_user.php"
                            }
                            document.forms.myforms.method = "post";
                            document.forms.myforms.target = "_self";
                            document.forms.myforms.action = login_after;
                            document.forms.myforms.submit();
                        }
                    },
                    error: function (request, status, error) {
                    }
                })
            }
        }

        // Handle reapply button click
        $(document).ready(function() {
            $('#reapply-btn').click(function() {
                var recid = $(this).data('recid');
                
                // Show loading state
                $(this).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
                $(this).prop('disabled', true);
                
                $.ajax({
                    url: 'reapply_handler.php',
                    type: 'POST',
                    data: { recid: recid },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            $('.error_msg').html(response.msg);
                            $('#reapply-section').hide();
                        } else {
                            $('.error_msg').html('Error: ' + response.msg);
                        }
                        
                        // Reset button
                        $('#reapply-btn').html('<i class="fas fa-redo"></i> Click to Reapply');
                        $('#reapply-btn').prop('disabled', false);
                    },
                    error: function() {
                        $('.error_msg').html('An error occurred. Please try again.');
                        $('#reapply-btn').html('<i class="fas fa-redo"></i> Click to Reapply');
                        $('#reapply-btn').prop('disabled', false);
                    }
                });
            });
        });
    </script>

<?php 
require "includes/cc_footer.php";
?>