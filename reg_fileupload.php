<?php
require "includes/cc_header.php";
?>
    <style>
        .overflowYScroll{
            overflow-y:scroll;
        }
    </style>

    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" />
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

    <div class="container-fluid">
        <div class='row bg-white' style="height:99px">
            <div class="col-3 pe-0 d-flex align-items-center">
                <img src="images/350 x 88.png" style='height:76px;width:auto;'>
            </div>

            <div class="col-4 offset-5" style="display:flex;flex-direction:row;justify-content:center;font-family:inter;font-size:21px;align-items:center"> 
                <div style="flex:0.8">
                    <a href="http://localhost/couples-connect/login_cc.php"  class="has_hover" style='color:black;text-decoration:none'>HOME</a>
                </div>

                <div style="flex:1.1">
                    
                    <a href="http://localhost/couples-connect_wp/about-us/"  class="has_hover" style='color:black;text-decoration:none'>ABOUT US</a>

                </div>

                <div style="flex:1.1">
                    <a href="http://localhost/couples-connect_wp/contact-us/"  class="has_hover" style='color:black;text-decoration:none'>CONTACTS</a>
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
                    <div class="row justify-content-center align-items-center">
                        <div class='confirm_main_div' style='width:1400px;height:500px;background-color:white;border-radius:30px'>
                            <div class="mx-5 px-3 pt-4 text-left login_form_header">
                                <p style="margin-bottom:0;font-weight:bold;font-family:inter;font-size:33px">Confirmation</p>
                                <p style="line-height:0.9;margin-bottom:0;font-weight:bold;font-size:25px;font-family:inter;font-size:21px;color:#9B9B9B">Personal Information</p>
                                <img src="images/Rectangle 11942.png"/>
                            </div>

                            <div class="mx-5 px-3 pt-3 form-group">
                                <label class='form-label'style="color:black;font-size:21px;font-family:inter">Please attach proof that one partner is from/ is a resident of Cabuyao City (i.e. Government ID, Birth Certificate, other government documents, letter of recommendation)</label>
                                <div class="container mt-3 mx-0 px-0">
                                    <input type="file"  name="file_1" id="file_1" class="form-control">
                                </div>
                            </div>
                            <div class="mx-5 px-3 pt-2">
                                <img src="images/Rectangle 11942.png" style="width:100%"/>
                            </div>

                            <div class="mt-3 mx-5 px-3 form-group" style="color:black;font-size:21px;font-family:inter">
                                <label class='form-label'>(Available only for special cases i.e. partner living overseas, partner is pregnant, persons with disabilities)</label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group input-group-sm" style='height:100%'>
                                            <div style='height:100%;display:flex;align-items:center'>
                                                <input type="checkbox" name="chk_pmoc" id="chk_pmoc" style="width:30px;height:auto" value="0" />
                                            </div>
    
                                            <label class="checkbox-inline mt-2" aria-describedby="ProcessingConsultantYN" id="lbProcessingConsultant" for="ProcessingConsultantYN">Do you wish to apply for Online PMOC? </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mx-5 mb-5 px-3 pmoc_tab" style='display:none'>

                                <div class="pt-4 text-left login_form_header">
                                    <p style="margin-bottom:0;font-weight:bold;font-size:25px;font-family:inter;font-size:33px">PMOC Application</p>
                                    <p style="line-height:0.9;margin-bottom:0;font-weight:bold;font-size:25px;font-family:inter;font-size:21px;color:#9B9B9B">Personal Information</p>
                                    <img src="images/Rectangle 11942.png" style='width:100%'/>
                                </div>

                                <label class='form-label' style="color:black;font-size:21px;font-family:inter">
                                    Justification
                                </label>

                                <textarea class="form-control" rows="3" name="justification" id="justification"></textarea>
                                
                                <label class='form-label mt-3' style="color:black;font-size:21px;font-family:inter">
                                    Please attach evidence (Official government documents or medical certificate:)
                                </label>

                                <div class="container mx-0 px-0">
                                    <input type="file" name="file_2" id="file_2" class="form-control">
                                </div>
                        </div>

                        </div>
                    </div>

                                

                    <div class="pt-4 mt-1 form-group d-flex align-items-center justify-content-center">
                        <button onclick="submit_user()" type="button" class="btn" style="background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:300px;height:50px;font-size:25px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Submit</button>
                    </div>
                </td>
            </tr>

        
        </table>

        <div class="modal fade  xerror_modal" data-bs-backdrop="static" id="xerror_modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style='border-radius:15px'>
                    <div class="modal-header">
                        <h5 class="modal-title error_msg_title" style="font-size:38px;font-family:inter;font-weight:bold">Confirmation!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="error_msg" style='font-family:inter;font-size:24px;font-weight:300'>Modal body text goes here.</p>
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
        <input type="hidden" name="hdn_mode" id="hdn_mode">



        <!-- FIRST PARTNER -->
        <input type="hidden" name="first_name_h" id="first_name_h" value="<?php echo $_POST['first_name'];?>">
        <input type="hidden" name="middle_name_h" id="middle_name_h" value="<?php echo $_POST['middle_name'];?>">
        <input type="hidden" name="last_name_h" id="last_name_h" value="<?php echo $_POST['last_name'];?>">
        <input type="hidden" name="sex_h" id="sex_h" value="<?php echo $_POST['sex'];?>">
        <input type="hidden" name="bday_h" id="bday_h" value="<?php echo $_POST['bday'];?>">
        <input type="hidden" name="country_h" id="country_h" value="<?php echo $_POST['country'];?>">
        <input type="hidden" name="municipality_h" id="municipality_h" value="<?php echo $_POST['municipality'];?>">
        <input type="hidden" name="occupation_h" id="occupation_h" value="<?php echo $_POST['occupation'];?>">
        <input type="hidden" name="cellphone_number_h" id="cellphone_number_h" value="<?php echo $_POST['cellphone_number'];?>">

        <!-- SECOND PARTNER -->
        <input type="hidden" name="first_name2_h" id="first_name2_h" value="<?php echo $_POST['first_name2'];?>">
        <input type="hidden" name="middle_name2_h" id="middle_name2_h" value="<?php echo $_POST['middle_name2'];?>">
        <input type="hidden" name="last_name2_h" id="last_name2_h" value="<?php echo $_POST['last_name2'];?>">
        <input type="hidden" name="sex2_h" id="sex2_h" value="<?php echo $_POST['sex2'];?>">
        <input type="hidden" name="bday2_h" id="bday2_h" value="<?php echo $_POST['bday2'];?>">
        <input type="hidden" name="country2_h" id="country2_h" value="<?php echo $_POST['country2'];?>">
        <input type="hidden" name="municipality2_h" id="municipality2_h" value="<?php echo $_POST['municipality2'];?>">
        <input type="hidden" name="occupation2_h" id="occupation2_h" value="<?php echo $_POST['occupation2'];?>">
        <input type="hidden" name="cellphone_number2_h" id="cellphone_number2_h" value="<?php echo $_POST['cellphone_number2'];?>">

        <!-- LOGIN INFO -->
        <input type="hidden" name="reg_email_h" id="reg_email_h" value ="<?php echo $_POST['reg_email_h'];?>">
        <input type="hidden" name="confirm_email_h" id="confirm_email_h" value ="<?php echo $_POST['confirm_email_h'];?>">
        <input type="hidden" name="reg_pwd_h" id="reg_pwd_h" value ="<?php echo $_POST['reg_pwd_h'];?>">
        
    </form>

    <script>

        $("#xerror_modal").on("hidden.bs.modal", function () {
            $(location).prop('href', 'http://localhost/couples-connect/index.php')
        });

       
        function onMeiForm(){
            document.forms.myforms.method = "post";
            document.forms.myforms.target = "_self";
            document.forms.myforms.action = "reg_meiform.php";
            document.forms.myforms.submit();
        }

        $("#chk_pmoc").on('change', function() {

            if(this.checked) {
                $(".confirm_main_div").addClass('overflowYScroll');
                $(".pmoc_tab").css({"display":"block"});
            }else{
                $(".confirm_main_div").removeClass('overflowYScroll');
                $(".pmoc_tab").css({"display":"none"});
            }
        });

        function submit_user(){

            var is_pmoc = "N";

            if (document.getElementById('chk_pmoc').checked) {
                is_pmoc = "Y";
            } else {
                is_pmoc = "N";
            }


            //partner 1
            var first_name_h = $("#first_name_h").val();
            var middle_name_h = $("#middle_name_h").val();
            var last_name_h = $("#last_name_h").val();
            var sex_h = $("#sex_h").val();
            var bday_h = $("#bday_h").val();
            var country_h = $("#country_h").val();
            var municipality_h = $("#municipality_h").val();
            var occupation_h = $("#occupation_h").val();
            var cellphone_number_h = $("#cellphone_number_h").val();


            //partner 2
            var first_name2_h = $("#first_name2_h").val();
            var middle_name2_h = $("#middle_name2_h").val();
            var last_name2_h = $("#last_name2_h").val();
            var sex2_h = $("#sex2_h").val();
            var bday2_h = $("#bday2_h").val();
            var country2_h = $("#country2_h").val();
            var municipality2_h = $("#municipality2_h").val();
            var occupation2_h = $("#occupation2_h").val();
            var cellphone_number2_h = $("#cellphone_number2_h").val();

            //login info
            var reg_email_h = $("#reg_email_h").val();
            var confirm_email_h = $("#confirm_email_h").val();
            var confirm_pwd_h = $("#confirm_pwd_h").val();
            var reg_pwd_h = $("#reg_pwd_h").val();

            //justification
            var justification = $("#justification").val();

            var xdata = new FormData();

            xdata.append('first_name_h',first_name_h);
            xdata.append('middle_name_h',middle_name_h);
            xdata.append('last_name_h',last_name_h);
            xdata.append('sex_h',sex_h);
            xdata.append('bday_h',bday_h);
            xdata.append('country_h',country_h);
            xdata.append('municipality_h',municipality_h);
            xdata.append('occupation_h',occupation_h);
            xdata.append('cellphone_number_h',cellphone_number_h);
            
            xdata.append('first_name2_h',first_name2_h);
            xdata.append('middle_name2_h',middle_name2_h);
            xdata.append('last_name2_h',last_name2_h);
            xdata.append('sex2_h',sex2_h);
            xdata.append('bday2_h',bday2_h);
            xdata.append('country2_h',country2_h);
            xdata.append('municipality2_h',municipality2_h);
            xdata.append('occupation2_h',occupation2_h);
            xdata.append('cellphone_number2_h',cellphone_number2_h);

            xdata.append('reg_email_h',reg_email_h);
            xdata.append('confirm_email_h',confirm_email_h);
            xdata.append('confirm_pwd_h',confirm_pwd_h);
            xdata.append('reg_pwd_h',reg_pwd_h);
            xdata.append('is_pmoc',is_pmoc);
            xdata.append('justification',justification);
  
            var files_1 = $('#file_1')[0].files;
            xdata.append('file_1',files_1[0]);

            var files_2 = $('#file_2')[0].files;
            xdata.append('file_2',files_2[0]);

            jQuery.ajax({    
            data:xdata,
            contentType: false,
            processData: false,
            type:"post",
            url:"reg_fileupload_ajax.php", 
                success: function(xret){ 

                    $(".error_msg").html("Thank you for providing the information. Your account details are currently under review for verification. Please anticipate an email update within the next 2-3 days.");
                    $("#xerror_modal").modal("show");
                }
            })
        }
                


    </script>


    



<?php 
require "includes/cc_footer.php";
?>

