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
                    <a href="http://localhost/couplesconnectprog/login_cc.php" class="has_hover" style='color:black;text-decoration:none'>HOME</a>
                </div>

                <div style="flex:1.1">
                    
                    <a href="http://localhost/couplesconnect_wp/about-us/" class="has_hover" style='color:black;text-decoration:none'>ABOUT US</a>

                </div>

                <div style="flex:1.1">
                    <a href="http://localhost/couplesconnect_wp/contact-us/"  class="has_hover" style='color:black;text-decoration:none'>CONTACTS</a>
                </div>

                <div style="flex:1">
                    <a href="http://localhost/couplesconnectprog/login_cc.php" class="has_hover" style='color:black;text-decoration:none'>| LOGIN</a>
                </div>

            </div> 
        </div>
    </div>
    
    <form name='myforms' id="myforms" method="post" target="_self" style='height:100%'> 
        <table style="width:100%;height:calc(100% - 100px);	filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25))">
            <tr>
                <td>
                    <div class="row justify-content-center align-items-center">
                        <div style='width:500px;height:525px;background-color:white;border-radius:30px'>
                            <div class="mx-3 px-3 pt-4 text-left login_form_header">
                                <p style="margin-bottom:0;font-weight:bold;font-size:23px;font-family:inter;font-size:26px">Register</p>
                                <p style="line-height:0.9;margin-bottom:0;font-weight:bold;font-size:19px;font-family:inter;color:#9B9B9B">Account Information</p>
                                <img src="images/Rectangle 11942.png"/>
                            </div>

                       

                            <div class="mx-3 px-3 form-group">
                                <label class='form-label'style="color:black;font-size:19px">Email:<span style='color:red'>*</span></label>
                                <input type='text' name='reg_email' id='reg_email' placeholder='Enter your email' style="height:55px;border:1px solid black;" class="form-control rounded input_sub;" autocomplete='off'>
                            </div>

                            <div class="mx-3 px-3  form-group" style='padding-top:5px'>
                                <label class='form-label' style="color:black;font-size:19px">Secondary Email: <span style='font-size:16px;color:#9B9B9B'>optional*</span></label>
                                <input type='text' name="confirm_email" id='confirm_email' placeholder='Enter your email' style="height:55px;border:1px solid black;" class="form-control roundedinput_sub" autocomplete='off'>
                            </div>

                            <div class="mx-3 px-3  form-group" style='padding-top:5px'>
                                <label class='form-label' style="color:black;font-size:19px">Password:<span style='color:red'>*</span> </label>
                                <input type='password' name="reg_pwd" id='reg_pwd' placeholder='Enter your password' style="height:55px;border:1px solid black;" class="form-control roundedinput_sub" autocomplete='off'>
                            </div>

                            <div class="mx-3 px-3  form-group" style='padding-top:5px'>
                                <label class='form-label' style="color:black;font-size:19px">Confirm Password:<span style='color:red'>*</span> </label>
                                <input type='password' name="confirm_pwd" id='confirm_pwd' placeholder='Confirm your password' style="height:55px;border:1px solid black;" class="form-control roundedinput_sub" autocomplete='off'>
                            </div>

                        </div>
                    </div>

                    <div class="pt-4 mt-1 form-group d-flex align-items-center justify-content-center">
                        <button onclick="onMeiForm()" type="button" class="btn" style="background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:300px;height:50px;font-size:25px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Continue</button>
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

        function validateEmail(input) {
            var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

            if (input.value.match(validRegex)) {
                return true;
            } else {
                return false;
            }

        }

        function onMeiForm(){

            var reg_email_input = document.getElementById("reg_email");
            var confirm_email_input = document.getElementById("confirm_email");

            var reg_email = $("#reg_email").val();
            var reg_pwd = $("#reg_pwd").val();

            var confirm_pwd = $("#confirm_pwd").val();
            var confirm_email = $("#confirm_email").val();

            var xcheck = true;
            var error_msg_val = '';


            if(!reg_email || !reg_pwd || !confirm_pwd){
                error_msg_val = 'Fill out required fields'
                xcheck = false;
            }

            console.log((reg_email!== '' && validateEmail(confirm_email_input) == false));

            if(validateEmail(reg_email_input) == false || (confirm_email !== '' && validateEmail(confirm_email_input) == false)){

                if(xcheck == true){
                    error_msg_val+='Invalid Email';
                }else{
                    error_msg_val+='</br>Invalid Email';
                }

                xcheck = false;
            }

            if(reg_pwd !== confirm_pwd){
                if(xcheck == true){
                    error_msg_val+='Passwords Dont Match';
                }else{
                    error_msg_val+='</br>Passwords Dont Match';
                }

                xcheck = false;
            }

            if(xcheck == true){
                jQuery.ajax({    
                    data:{
                        email:reg_email,
                        password:reg_pwd
                    },
                    dataType:"json",
                    type:"post",
                    url:"reg_cc_ajax.php", 
                    success: function(xdata){

                        if(xdata['status'] == false){
                            $('.error_msg').html(xdata['msg']);
                            $(".xerror_modal").modal("show");
                        }else{
                            document.forms.myforms.method = "post";
                            document.forms.myforms.target = "_self";
                            document.forms.myforms.action = "reg_meiform.php";
                            document.forms.myforms.submit();
                        }

   
                    },
                    error: function (request, status, error) {
                    }
                
                })
            }else{
                $('.error_msg').html(error_msg_val);
                $(".xerror_modal").modal("show");
            }

            
        }

    </script>



<?php 
require "includes/cc_footer.php";
?>

