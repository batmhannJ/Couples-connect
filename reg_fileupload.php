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

<!-- header.php -->
<div style="width: 100%; font-family: Inter, sans-serif;">
    <div style="width: 100%; background-color: white; height: 80px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: space-between; padding: 0 20px; box-sizing: border-box; position: relative;">

        <!-- Logo Section -->
        <div style="flex: 0 0 auto; display: flex; align-items: center;">
            <img src="images/350 x 88.png" style="height: 60px; width: auto;">
        </div>

        <!-- Navigation Links -->
        <div id="desktop-nav" style="display: flex; flex-direction: row; justify-content: center; font-family: Inter; font-size: 18px; align-items: center; gap: 30px;">
            <a href="http://localhost/couples-connect/login_cc.php" class="nav-link-custom">HOME</a>
            <a href="http://localhost/couples-connect/about-us/" class="nav-link-custom">ABOUT US</a>
            <a href="http://localhost/couples-connect/contact-us/" class="nav-link-custom">CONTACTS</a>
            <div style="height: 20px; width: 1px; background-color: #ddd; margin: 0 5px;"></div>
            <a href="http://localhost/couples-connect/login_cc.php" class="login-btn">LOGOUT</a>
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobile-btn" onclick="toggleMenu()" 
                style="display: none; background: none; border: none; font-size: 24px; cursor: pointer; padding: 8px; border-radius: 6px; color: #333;">
            <span id="menu-icon">☰</span>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" style="display: none; background-color: white; box-shadow: 0 4px 12px rgba(0,0,0,0.15); position: absolute; top: 80px; left: 0; right: 0; z-index: 1000; padding: 20px;">
        <div style="display: flex; flex-direction: column; gap: 15px;">
            <a href="http://localhost/couples-connect/login_cc.php" class="nav-link-mobile">HOME</a>
            <a href="http://localhost/couples-connect/about-us/" class="nav-link-mobile">ABOUT US</a>
            <a href="http://localhost/couples-connect/contact-us/" class="nav-link-mobile">CONTACTS</a>
            <a href="http://localhost/couples-connect/login_cc.php" class="login-btn-mobile">LOGIN</a>
        </div>
    </div>
</div>

<style>
    .nav-link-custom {
        color: black;
        text-decoration: none;
        font-weight: 500;
        padding: 8px 12px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .nav-link-custom:hover {
        color: #23408E;
        background-color: #f8f9fa;
    }

    .login-btn {
        color: #23408E;
        text-decoration: none;
        font-weight: 600;
        padding: 10px 16px;
        border: 2px solid #23408E;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .login-btn:hover {
        background-color: #23408E;
        color: white;
    }

    .nav-link-mobile {
        color: black;
        text-decoration: none;
        font-weight: 500;
        padding: 12px 16px;
        border-radius: 8px;
        transition: background-color 0.3s ease;
        font-family: Inter;
    }

    .nav-link-mobile:hover {
        background-color: #f8f9fa;
    }

    .login-btn-mobile {
        color: white;
        text-decoration: none;
        font-weight: 600;
        padding: 12px 16px;
        background: linear-gradient(90deg, rgb(35, 64, 142) 35%, rgb(60, 148, 198) 100%);
        border-radius: 8px;
        text-align: center;
        transition: all 0.3s ease;
        font-family: Inter;
    }

    .login-btn-mobile:hover {
        background: linear-gradient(90deg, rgb(30, 58, 122) 35%, rgb(50, 128, 178) 100%);
    }

    @media (min-width: 768px) {
        #desktop-nav {
            display: flex !important;
        }
        #mobile-btn {
            display: none !important;
        }
    }

    @media (max-width: 767px) {
        #desktop-nav {
            display: none !important;
        }
        #mobile-btn {
            display: block !important;
        }

        img[src*="350 x 88.png"] {
            height: 45px !important;
        }

        div[style*="height: 80px"] {
            height: 70px !important;
        }

        #mobile-menu {
            top: 70px !important;
        }
    }

    @media (max-width: 480px) {
        img[src*="350 x 88.png"] {
            height: 40px !important;
        }

        div[style*="height: 80px"], div[style*="height: 70px"] {
            height: 65px !important;
        }

        #mobile-menu {
            top: 65px !important;
            padding: 15px !important;
        }
    }
</style>

<script>
    let menuOpen = false;

    function toggleMenu() {
        const menu = document.getElementById('mobile-menu');
        const icon = document.getElementById('menu-icon');

        menuOpen = !menuOpen;

        if (menuOpen) {
            menu.style.display = 'block';
            icon.innerHTML = '✕';
        } else {
            menu.style.display = 'none';
            icon.innerHTML = '☰';
        }
    }

    document.addEventListener('click', function (e) {
        const menu = document.getElementById('mobile-menu');
        const btn = document.getElementById('mobile-btn');

        if (menuOpen && !menu.contains(e.target) && !btn.contains(e.target)) {
            toggleMenu();
        }
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 768 && menuOpen) {
            toggleMenu();
        }
    });
</script>

    
<div style="display: flex; justify-content: center; align-items: flex-start; padding: 40px 12px; background-color: #f9fafb; font-family: 'Inter', sans-serif;">
  <form name="myforms" id="myforms" method="post" target="_self" style="width: 100%; max-width: 880px;">
    <table class="main-table" style="width: 100%; filter: drop-shadow(0px 2px 10px rgba(0, 0, 0, 0.06));">
      <tr>
        <td>
          <div style="background-color: #ffffff; border-radius: 16px; padding: 24px; border: 1px solid #e5e7eb; box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);">

            <!-- Header -->
            <div style="margin-bottom: 20px;">
              <p style="font-size: 22px; font-weight: 600; color: #1f2937; margin: 0;">Confirmation</p>
              <p style="font-size: 15px; font-weight: 500; color: #6b7280; margin: 4px 0 12px;">Personal Information</p>
              <img src="images/Rectangle 11942.png" style="width: 100%; margin: 12px 0; border-radius: 6px;" />
            </div>

            <!-- File Upload -->
            <div style="margin-bottom: 20px;">
              <label style="font-size: 14px; font-weight: 500; color: #374151; display: block; margin-bottom: 6px;">
                Please attach proof that one partner is from/ is a resident of Cabuyao City
              </label>
              <input type="file" name="file_1" id="file_1" style="padding: 8px 10px; font-size: 14px; width: 100%; border: 1px solid #d1d5db; border-radius: 6px;">
            </div>

            <!-- Image Divider -->
            <div style="margin: 16px 0;">
              <img src="images/Rectangle 11942.png" style="width: 100%; border-radius: 6px;" />
            </div>

            <!-- Checkbox -->
            <div style="margin-bottom: 20px;">
              <label style="font-size: 14px; font-weight: 500; color: #374151; display: block; margin-bottom: 6px;">
                (Available only for special cases)
              </label>
              <div style="display: flex; align-items: center; gap: 10px;">
                <input type="checkbox" name="chk_pmoc" id="chk_pmoc" value="0" style="width: 18px; height: 18px; accent-color: #2563eb;" />
                <label for="chk_pmoc" style="font-size: 14px; color: #374151;">Do you wish to apply for Online PMOC?</label>
              </div>
            </div>

            <!-- PMOC Section -->
            <div class="pmoc_tab" style="display: none; margin-top: 20px;">
              <div style="margin-bottom: 20px;">
                <p style="font-size: 20px; font-weight: 600; color: #1f2937; margin: 0;">PMOC Application</p>
                <p style="font-size: 15px; font-weight: 500; color: #6b7280; margin: 4px 0 12px;">Personal Information</p>
                <img src="images/Rectangle 11942.png" style="width: 100%; margin-top: 12px; border-radius: 6px;" />
              </div>

              <label style="font-size: 14px; font-weight: 500; color: #374151; display: block; margin-bottom: 6px;">Justification</label>
              <textarea name="justification" id="justification" rows="3" style="font-size: 14px; padding: 10px; resize: vertical; border: 1px solid #d1d5db; border-radius: 6px; width: 100%;"></textarea>

              <label style="font-size: 14px; font-weight: 500; color: #374151; margin-top: 16px; margin-bottom: 6px; display: block;">Please attach evidence:</label>
              <input type="file" name="file_2" id="file_2" style="padding: 8px 10px; font-size: 14px; width: 100%; border: 1px solid #d1d5db; border-radius: 6px;">
            </div>

            <!-- Submit Button -->
            <div style="display: flex; justify-content: center; margin-top: 24px;">
              <button onclick="submit_user()" type="button" style="background: linear-gradient(90deg, #233f8e 35%, #3c94c6 100%); color: white; width: 220px; height: 42px; font-size: 15px; font-weight: 600; border: none; border-radius: 6px; transition: 0.3s ease; box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.15); cursor: pointer;">
                Submit
              </button>
            </div>

          </div>
        </td>
      </tr>
    </table>

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

        <!-- index.php INFO -->
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

            //index.php info
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
