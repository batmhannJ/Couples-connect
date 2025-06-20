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
                    <a href="http://localhost/couplesconnectprog/login_cc.php"  class="has_hover" style='color:black;text-decoration:none'>HOME</a>
                </div>

                <div style="flex:1.1">
                    
                    <a href="http://localhost/couplesconnect_wp/about-us/"  class="has_hover" style='color:black;text-decoration:none'>ABOUT US</a>

                </div>

                <div style="flex:1.1">
                    <a href="http://localhost/couplesconnect_wp/contact-us/"  class="has_hover" style='color:black;text-decoration:none'>CONTACTS</a>
                </div>

                <div style="flex:1">
                    <a href="http://localhost/couplesconnectprog/login_cc.php" class="has_hover"  style='color:black;text-decoration:none'>| LOGIN</a>
                </div>
            </div> 
        </div>
    </div>

    <form name='myforms' id="myforms" method="post" target="_self" style='height:100%'> 
        <table style="width:100%;height:calc(100% - 100px);	filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25))">
            <tr style='height:100%;display:flex'>
                <td style='display:flex;justify-content:center;align-items:center;height:100%;flex:1'>
                    <div class="row justify-content-center align-items-center" style='width:80%;margin-top:10px'>
                        <div style='width:100%;background-color:white;border-radius:30px;height:560px'>
                            <div class="mx-3 px-3 pt-4 text-left login_form_header">
                                <p style="margin-bottom:0;font-weight:bold;font-size:28px;font-family:inter">Partner 1</p>
                            <p style="line-height:0.9;margin-bottom:0;font-weight:bold;font-size:25px;font-family:inter;font-size:21px;color:#9B9B9B">Personal Information</p>
                                <img src="images/Rectangle 11942.png" style='width:80%'/>
                            </div>

                            <div class="mx-3 px-3 form-group">
                                <label class='form-label'style="color:black;font-size:17px">First Name:<span style='color:red'>*</span></label>
                                <input type='text' name='first_name' id='first_name' placeholder='Enter your first name' style="height:45px;border:1px solid black;" class="form-control rounded input_sub;" autocomplete='off'>
                            </div>

                            <div class="row mx-3 pe-3 ps-1  form-group" style='padding-top:6px'>

                                <div class="col-6">
                                    <label class='form-label' style="color:black;font-size:17px">Middle Name:<span style='color:red'>*</span></label>
                                    <input type='text' name="middle_name" id='middle_name' placeholder='Enter your middle name' style="height:45px;border:1px solid black;" class="form-control roundedinput_sub" autocomplete='off'>
                                </div>

                                <div class="col-5">
                                    <label class='form-label' style="color:black;font-size:17px">Last Name:<span style='color:red'>*</span></label>
                                    <input type='text' name="last_name" id='last_name' placeholder='Enter your last name' style="height:45px;border:1px solid black;" class="form-control roundedinput_sub" autocomplete='off'>
                                </div>
                                
                            </div>

                            <div class="row mx-3 pe-3 ps-1  form-group" style='padding-top:6px'>

                                <div class="col-6">
                                    <label class='form-label' style="color:black;font-size:17px">Sex/Gender:<span style='color:red'>*</span></label>
                                    <!-- <input type='text' name="sex" id='sex' placeholder=' your sex/gender'  class="form-control "> -->
                                    <select style="height:45px;border:1px solid black;" class='form-control roundedinput_sub' name='sex' id='sex' placeholder='Select Your Gender'>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                        <option value="O">Others</option>
                                    </select>
                                </div>

                                <div class="col-6">
                                    <label class='form-label' style="color:black;font-size:17px">Birthday:<span style='color:red'>*</span></label>
                                    <input type='text' name="bday" class='form-control date_picker' id='bday' placeholder='Enter brithday' style="height:45px;border:1px solid black;" class="form-control roundedinput_sub" autocomplete='off'>
                                </div>

                            </div>

                            <div class="row mx-3 pe-3 ps-1  form-group" style='padding-top:6px'>

                                <div class="col-6">
                                    <label class='form-label' style="color:black;font-size:17px">Country:(You were born in)<span style='color:red'>*</span></label>
                                    <select name="country" id="country" class='form-control roundedinput_sub' style='height:45px;border:1px solid black;'>
                                        <?php
                                        
                                            $select_db="SELECT * FROM mf_country ORDER BY sortid";
                                            $stmt	= $link->prepare($select_db);
                                            $stmt->execute();
                                            while($rs = $stmt->fetch()){
                                                echo "<option>".$rs['country_name']."</option>";
                                            }

                                        ?>
                                        
                                    </select>
                                </div>

                                <div class="col-6">
                                    <label class='form-label' style="color:black;font-size:17px">Current Municipality: <span style='color:red'>*</span></label>
                                    <input type='text' name="municipality" id='municipality' placeholder='Enter Municipality' style="height:45px;border:1px solid black;" class="form-control roundedinput_sub" autocomplete='off'>
                                </div>

                            </div>

                            <div class="row mx-3 pe-3 ps-1  form-group" style='padding-top:6px'>

                                <div class="col-6">
                                    <label class='form-label' style="color:black;font-size:17px">Occupation:<span style='color:red'>*</span></label>
                                    <input type='text' name="occupation" id='occupation' placeholder='Enter your occupation' style="height:45px;border:1px solid black;" class="form-control roundedinput_sub" autocomplete='off'>
                                </div>

                                <div class="col-6">
                                    <label class='form-label' style="color:black;font-size:17px">Cellphone Number:<span style='color:red'>*</span> </label>
                                    <input type='text' name="cellphone_number" id='cellphone_number' placeholder='Enter your cellphone number' style="height:45px;border:1px solid black;" class="form-control roundedinput_sub" autocomplete='off'>
                                </div>
                            </div>

                        </div>
                    </div>
                </td>

                <td style='display:flex;justify-content:center;align-items:center;height:100%;flex:1'>
                    <div class="row justify-content-center align-items-center" style='width:80%;margin-top:10px'>
                        <div style='width:100%;background-color:white;border-radius:30px;height:560px'>
                            <div class="mx-3 px-3 pt-4 text-left login_form_header">
                                <p style="margin-bottom:0;font-weight:bold;font-size:28px;font-family:inter">Partner 2</p>
                                <p style="line-height:0.9;margin-bottom:0;font-weight:bold;font-family:inter;font-size:21px;color:#9B9B9B">Personal Information</p>
                                <img src="images/Rectangle 11942.png" style='width:80%'/>
                            </div>

                            <div class="mx-3 px-3 form-group">
                                <label class='form-label'style="color:black;font-size:17px">First Name:<span style='color:red'>*</span></label>
                                <input type='text' name='first_name2' id='first_name2' placeholder='Enter your first name' style="height:45px;border:1px solid black;" class="form-control rounded input_sub;" autocomplete='off'>
                            </div>

                            <div class="row mx-3 pe-3 ps-1  form-group" style='padding-top:6px'>

                                <div class="col-6">
                                    <label class='form-label' style="color:black;font-size:17px">Middle Name:<span style='color:red'>*</span></label>
                                    <input type='text' name="middle_name2" id='middle_name2' placeholder='Enter your middle name' style="height:45px;border:1px solid black;" class="form-control roundedinput_sub" autocomplete='off'>
                                </div>

                                <div class="col-5">
                                    <label class='form-label' style="color:black;font-size:17px">Last Name: <span style='color:red'>*</span></label>
                                    <input type='text' name="last_name2" id='last_name2' placeholder='Enter your last name' style="height:45px;border:1px solid black;" class="form-control roundedinput_sub" autocomplete='off'>
                                </div>
                                
                            </div>

                            <div class="row mx-3 pe-3 ps-1  form-group" style='padding-top:6px'>

                                <div class="col-6">
                                    <label class='form-label' style="color:black;font-size:17px">Sex/Gender:<span style='color:red'>*</span></label>
                                    <select style="height:45px;border:1px solid black;" class='form-control roundedinput_sub' name='sex2' id='sex2' placeholder='Select Your Gender'>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                        <option value="O">Others</option>
                                    </select>
                                </div>

                                <div class="col-6">
                                    <label class='form-label' style="color:black;font-size:17px">Birthday:<span style='color:red'>*</span> </label>
                                    <input type='text' name="bday2" id='bday2' class='form-control date_picker' placeholder='Enter your birthday' style="height:45px;border:1px solid black;" class="form-control roundedinput_sub" autocomplete='off'>
                                </div>

                            </div>

                            <div class="row mx-3 pe-3 ps-1  form-group" style='padding-top:6px'>

                                <div class="col-6">
                                    <label class='form-label' style="color:black;font-size:17px">Country:(You were born in)<span style='color:red'>*</span></label>
                                    <select name="country2" id="country2" class='form-control roundedinput_sub' style='height:45px;border:1px solid black;'>
                                        <?php
                                        
                                            $select_db="SELECT * FROM mf_country ORDER BY sortid";
                                            $stmt	= $link->prepare($select_db);
                                            $stmt->execute();
                                            while($rs = $stmt->fetch()){
                                                echo "<option>".$rs['country_name']."</option>";
                                            }

                                        ?>
                                        
                                    </select>
                                </div>

                                <div class="col-6">
                                    <label class='form-label' style="color:black;font-size:17px">Current Municipality:<span style='color:red'>*</span> </label>
                                    <input type='text' name="municipality2" id='municipality2' placeholder='Enter Municipality' style="height:45px;border:1px solid black;" class="form-control roundedinput_sub" autocomplete='off'>
                                </div>

                            </div>

                            <div class="row mx-3 pe-3 ps-1  form-group" style='padding-top:6px'>

                                <div class="col-6">
                                    <label class='form-label' style="color:black;font-size:17px">Occupation:<span style='color:red'>*</span></label>
                                    <input type='text' name="occupation2" id='occupation2' placeholder='Enter your occupation' style="height:45px;border:1px solid black;" class="form-control roundedinput_sub" autocomplete='off'>
                                </div>

                                <div class="col-6">
                                    <label class='form-label' style="color:black;font-size:17px">Cellphone Number:<span style='color:red'>*</span> </label>
                                    <input type='text' name="cellphone_number2" id='cellphone_number2' placeholder='Enter your cellphone number' style="height:45px;border:1px solid black;" class="form-control roundedinput_sub" autocomplete='off'>
                                </div>
                            </div>

                        </div>
                    </div>
                </td>

            </tr>
            <tr>
                <td colspan='2' style='height:15%'>
                    <div class="form-group d-flex align-items-center justify-content-center" style='height:100%'>
                        <button onclick="onContinue()" type="button" class="btn" style="background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:300px;height:50px;font-size:25px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Continue</button>
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
                        <p class="error_msg">Please fill up all required fields.</p>
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

        <!-- HIDDEN VARS -->
        <input type='hidden' id="reg_email_h" name="reg_email_h" value="<?php echo $_POST['reg_email']?>">
        <input type='hidden' name="confirm_email_h" id='confirm_email_h' value="<?php echo $_POST['confirm_email'];?>">
        <input type='hidden' name="reg_pwd_h" id='reg_pwd_h' value="<?php echo $_POST['reg_pwd']; ?>">
        <input type='hidden' name="confirm_pwd_h" id='confirm_pwd_h' value="<?php echo $_POST['confirm_pwd'] ?>">
    </form>

    <script>

        function onContinue(){



            let isValid = true;

            // Get all input fields
            let inputs = $('input[type="text"], select');

            // Loop through each input field
            inputs.each(function() {
                // If the input field is empty, set isValid to false and break the loop
                if ($(this).val().trim() === '') {
                    isValid = false;
                    return false;
                }
            });

            // If isValid is true, all input fields are not empty
            if (isValid) {
                // All input fields are not empty, you can continue with your logic here

                document.forms.myforms.method = "post";
                document.forms.myforms.target = "_self";
                document.forms.myforms.action = "reg_fileupload.php";
                document.forms.myforms.submit();

            } else {
                $(".xerror_modal").modal("show");
                // At least one input field is empty
            }
        }


    </script>



<?php 
require "includes/cc_footer.php";
?>

