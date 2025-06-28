<?php
require "includes/cc_header.php";
?>

    <div style="width: 100%; font-family: Inter, sans-serif;">
    <div style="width: 100%; background-color: white; height: 80px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: space-between; padding: 0 20px; box-sizing: border-box; position: relative;">
        
        <!-- Logo Section -->
        <div style="flex: 0 0 auto; display: flex; align-items: center;">
            <img src="images/350 x 88.png" style="height: 60px; width: auto;">
        </div>

        <!-- Desktop Navigation -->
        <div id="desktop-nav" style="display: flex; flex-direction: row; justify-content: center; font-family: Inter; font-size: 18px; align-items: center; gap: 30px;">
            <div>
                <a href="http://localhost/couples-connect/login_cc.php" 
                   style="color: black; text-decoration: none; font-weight: 500; transition: all 0.3s ease; padding: 8px 12px; border-radius: 6px;"
                   onmouseover="this.style.color='#23408E'; this.style.backgroundColor='#f8f9fa'"
                   onmouseout="this.style.color='black'; this.style.backgroundColor='transparent'">HOME</a>
            </div>

            <div>
                <a href="http://localhost/couples-connect/about-us/" 
                   style="color: black; text-decoration: none; font-weight: 500; transition: all 0.3s ease; padding: 8px 12px; border-radius: 6px;"
                   onmouseover="this.style.color='#23408E'; this.style.backgroundColor='#f8f9fa'"
                   onmouseout="this.style.color='black'; this.style.backgroundColor='transparent'">ABOUT US</a>
            </div>

            <div>
                <a href="http://localhost/couples-connect/contact-us/" 
                   style="color: black; text-decoration: none; font-weight: 500; transition: all 0.3s ease; padding: 8px 12px; border-radius: 6px;"
                   onmouseover="this.style.color='#23408E'; this.style.backgroundColor='#f8f9fa'"
                   onmouseout="this.style.color='black'; this.style.backgroundColor='transparent'">CONTACTS</a>
            </div>

            <div style="height: 20px; width: 1px; background-color: #ddd; margin: 0 5px;"></div>

            <div>
                <a href="http://localhost/couples-connect/login_cc.php" 
                   style="color: #23408E; text-decoration: none; font-weight: 600; padding: 10px 16px; border: 2px solid #23408E; border-radius: 8px; transition: all 0.3s ease;"
                   onmouseover="this.style.backgroundColor='#23408E'; this.style.color='white'"
                   onmouseout="this.style.backgroundColor='transparent'; this.style.color='#23408E'">LOGIN</a>
            </div>
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
            <a href="http://localhost/couples-connect/login_cc.php" 
               style="color: black; text-decoration: none; font-weight: 500; padding: 12px 16px; border-radius: 8px; transition: background-color 0.3s ease; font-family: Inter;"
               onmouseover="this.style.backgroundColor='#f8f9fa'"
               onmouseout="this.style.backgroundColor='transparent'">HOME</a>

            <a href="http://localhost/couples-connect/about-us/" 
               style="color: black; text-decoration: none; font-weight: 500; padding: 12px 16px; border-radius: 8px; transition: background-color 0.3s ease; font-family: Inter;"
               onmouseover="this.style.backgroundColor='#f8f9fa'"
               onmouseout="this.style.backgroundColor='transparent'">ABOUT US</a>

            <a href="http://localhost/couples-connect/contact-us/" 
               style="color: black; text-decoration: none; font-weight: 500; padding: 12px 16px; border-radius: 8px; transition: background-color 0.3s ease; font-family: Inter;"
               onmouseover="this.style.backgroundColor='#f8f9fa'"
               onmouseout="this.style.backgroundColor='transparent'">CONTACTS</a>

            <a href="http://localhost/couples-connect/login_cc.php" 
               style="color: white; text-decoration: none; font-weight: 600; padding: 12px 16px; background: linear-gradient(90deg, rgb(35, 64, 142) 35%, rgb(60, 148, 198) 100%); border-radius: 8px; text-align: center; margin-top: 10px; transition: all 0.3s ease; font-family: Inter;"
               onmouseover="this.style.background='linear-gradient(90deg, rgb(30, 58, 122) 35%, rgb(50, 128, 178) 100%)'"
               onmouseout="this.style.background='linear-gradient(90deg, rgb(35, 64, 142) 35%, rgb(60, 148, 198) 100%)'">LOGIN</a>
        </div>
    </div>
</div>

<style>
    /* Desktop - show desktop nav, hide mobile button */
    @media (min-width: 768px) {
        #desktop-nav {
            display: flex !important;
        }
        #mobile-btn {
            display: none !important;
        }
    }

    /* Mobile - hide desktop nav, show mobile button */
    @media (max-width: 767px) {
        #desktop-nav {
            display: none !important;
        }
        #mobile-btn {
            display: block !important;
        }
        
        /* Adjust logo size on mobile */
        img[src*="350 x 88.png"] {
            height: 45px !important;
        }
        
        /* Adjust container height on mobile */
        div[style*="height: 80px"] {
            height: 70px !important;
        }
        
        #mobile-menu {
            top: 70px !important;
        }
    }

    /* Extra small screens */
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

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        const menu = document.getElementById('mobile-menu');
        const btn = document.getElementById('mobile-btn');
        
        if (menuOpen && !menu.contains(e.target) && !btn.contains(e.target)) {
            toggleMenu();
        }
    });

    // Close menu on window resize to desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768 && menuOpen) {
            toggleMenu();
        }
    });
</script>

     <body style="margin: 0; padding: 0; min-height: 100vh; background: linear-gradient(135deg,rgb(215, 217, 225) 0%,rgb(162, 185, 231) 100%);"></body>
    
    <form name='myforms' id="myforms" method="post" target="_self" style="min-height: 100vh; display: flex; flex-direction: column;">
    
    <!-- Main Content Container -->
    <div style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 20px;">
        <div style="width: 100%; max-width: 600px; background-color: white; border-radius: 18px; padding: 25px; box-shadow: 0px 8px 32px rgba(0, 0, 0, 0.15); margin: 15px;">
            
            <!-- Header -->
            <div style="text-align: center; margin-bottom: 18px;">
                <p style="font-weight: bold; font-size: 26px; font-family: Inter; margin: 0; color: #333;">Register</p>
                <p style="font-size: 14px; font-family: Inter; margin: 3px 0 0 0; color: #9B9B9B;">Account Information</p>
            </div>

            <!-- Email Field -->
            <div style="margin-bottom: 15px;">
                <label style="color: black; font-size: 15px; font-weight: 500; margin-bottom: 6px; display: block;">Email: <span style="color: red;">*</span></label>
                <input type='text' name='reg_email' id='reg_email' placeholder='Enter your email' 
                       style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box; transition: border-color 0.3s;" 
                       autocomplete='off'
                       onfocus="this.style.borderColor='#23408E'"
                       onblur="this.style.borderColor='#ddd'">
            </div>

            <!-- Secondary Email Field -->
            <div style="margin-bottom: 15px;">
                <label style="color: black; font-size: 15px; font-weight: 500; margin-bottom: 6px; display: block;">Secondary Email: <span style="font-size: 13px; color: #9B9B9B;">optional</span></label>
                <input type='text' name="confirm_email" id='confirm_email' placeholder='Enter secondary email' 
                       style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box; transition: border-color 0.3s;" 
                       autocomplete='off'
                       onfocus="this.style.borderColor='#23408E'"
                       onblur="this.style.borderColor='#ddd'">
            </div>

            <!-- Two-Column Layout for Passwords -->
            <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                <!-- Password Field -->
                <div style="flex: 1;">
                    <label style="color: black; font-size: 15px; font-weight: 500; margin-bottom: 6px; display: block;">Password: <span style="color: red;">*</span></label>
                    <div style="position: relative; width: 100%;">
                        <input type='password' name="reg_pwd" id='reg_pwd' placeholder='Enter password' 
                               style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 35px 0 12px; font-size: 14px; box-sizing: border-box; transition: border-color 0.3s;" 
                               autocomplete='off'
                               onfocus="this.style.borderColor='#23408E'"
                               onblur="this.style.borderColor='#ddd'">
                        <button type="button" id="togglePassword1" onclick="togglePasswordVisibility('reg_pwd', 'togglePassword1')" 
                                style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 14px; color: #666; padding: 0; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password Field -->
                <div style="flex: 1;">
                    <label style="color: black; font-size: 15px; font-weight: 500; margin-bottom: 6px; display: block;">Confirm: <span style="color: red;">*</span></label>
                    <div style="position: relative; width: 100%;">
                        <input type='password' name="confirm_pwd" id='confirm_pwd' placeholder='Confirm password' 
                               style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 35px 0 12px; font-size: 14px; box-sizing: border-box; transition: border-color 0.3s;" 
                               autocomplete='off'
                               onfocus="this.style.borderColor='#23408E'"
                               onblur="this.style.borderColor='#ddd'">
                        <button type="button" id="togglePassword2" onclick="togglePasswordVisibility('confirm_pwd', 'togglePassword2')" 
                                style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 14px; color: #666; padding: 0; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Continue Button -->
            <div style="text-align: center; margin-bottom: 10px;">
                <button type="button" onclick="onMeiForm()" 
                        style="background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%); color: white; width: 100%; height: 45px; font-size: 16px; font-family: Inter; font-weight: 700; border-radius: 8px; border: none; cursor: pointer; box-shadow: 0px 4px 15px rgba(35, 64, 142, 0.3); transition: transform 0.2s, box-shadow 0.2s;"
                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0px 6px 20px rgba(35, 64, 142, 0.4)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0px 4px 15px rgba(35, 64, 142, 0.3)'">
                    Continue
                </button>
            </div>

            <!-- Alert Message -->
            <div style="display: none; background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 8px; text-align: center; margin-top: 15px; border: 1px solid #f5c6cb;" id="div_msg" role="alert">
                <span id='span_msg'></span>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div style="display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: hidden; background-color: rgba(0,0,0,0.5);" id="xerror_modal">
        <div style="position: relative; width: auto; max-width: 500px; margin: 30px auto; display: flex; flex-direction: column; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); top: 50%; transform: translateY(-50%);">
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; border-bottom: 1px solid #dee2e6; border-radius: 10px 10px 0 0;">
                <h5 style="margin: 0; font-size: 18px; font-weight: 600;">Couples Connect Says:</h5>
                <button type="button" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #999;" onclick="document.getElementById('xerror_modal').style.display='none'">×</button>
            </div>
            <div style="padding: 20px;">
                <p class="error_msg" style="margin: 0;">Modal body text goes here.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer style="background-color: #23408E; padding: 20px 0; margin-top: auto;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
                
                <!-- Left Side - Office Info -->
                <div style="display: flex; align-items: center; gap: 15px; flex: 1; min-width: 300px;">
                    <img src="images/op office logo.png" style="height: 60px; width: auto;">
                    <div style="font-family: Inter; color: white;">
                        <div style="font-size: 14px; font-weight: bold; margin-bottom: 4px;">
                            City Population Office of Cabuyao
                        </div>
                        <div style="font-size: 11px; margin-bottom: 2px;">
                            Brgy Dos. Cabuyao Retail Plaza, Cabuyao, Philippines
                        </div>
                        <div style="font-size: 11px;">
                            cpocabuyao@gmail.com
                        </div>
                    </div>
                </div>

                <!-- Right Side - Help Icon -->
                <div>
                    <img src="images/pajamas_question.png" style="width: 50px; height: auto;">
                </div>
            </div>
        </div>
    </footer>
    
</form>

<!-- Responsive CSS -->
<style>
    @media (max-width: 768px) {
        form > div:first-child {
            padding: 10px !important;
        }
        
        form > div:first-child > div {
            max-width: 100% !important;
            margin: 10px !important;
            padding: 20px 15px !important;
            border-radius: 15px !important;
        }
        
        /* Stack password fields on mobile */
        form > div:first-child > div > div:nth-child(4) {
            flex-direction: column !important;
            gap: 15px !important;
        }
        
        footer > div {
            padding: 0 15px !important;
        }
        
        footer > div > div {
            flex-direction: column !important;
            text-align: center !important;
            gap: 15px !important;
        }
        
        footer > div > div > div:first-child {
            min-width: auto !important;
            justify-content: center !important;
        }
    }
    
    @media (max-width: 480px) {
        form > div:first-child > div {
            padding: 18px 12px !important;
        }
        
        form > div:first-child > div > div:first-child > p {
            font-size: 22px !important;
        }
        
        footer img[src*="logo"] {
            height: 50px !important;
        }
        
        footer > div > div > div:first-child > div > div:first-child {
            font-size: 12px !important;
        }
    }
</style>

<script>
    function togglePasswordVisibility(inputId, buttonId) {
        const passwordInput = document.getElementById(inputId);
        const toggleButton = document.getElementById(buttonId);
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleButton.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';
        } else {
            passwordInput.type = 'password';
            toggleButton.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
        }
    }

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

        var reg_email = document.getElementById("reg_email").value;
        var reg_pwd = document.getElementById("reg_pwd").value;
        var confirm_pwd = document.getElementById("confirm_pwd").value;
        var confirm_email = document.getElementById("confirm_email").value;

        var xcheck = true;
        var error_msg_val = '';

        if(!reg_email || !reg_pwd || !confirm_pwd){
            error_msg_val = 'Fill out required fields'
            xcheck = false;
        }

        if(validateEmail(reg_email_input) == false || (confirm_email !== '' && validateEmail(confirm_email_input) == false)){
            if(xcheck == true){
                error_msg_val+='Invalid Email';
            }else{
                error_msg_val+='<br>Invalid Email';
            }
            xcheck = false;
        }

        if(reg_pwd !== confirm_pwd){
            if(xcheck == true){
                error_msg_val+='Passwords Dont Match';
            }else{
                error_msg_val+='<br>Passwords Dont Match';
            }
            xcheck = false;
        }

        if(xcheck == true){
            // Simulate jQuery AJAX with fetch API
            fetch("reg_cc_ajax.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: "email=" + encodeURIComponent(reg_email) + "&password=" + encodeURIComponent(reg_pwd)
            })
            .then(response => response.json())
            .then(xdata => {
                if(xdata['status'] == false){
                    document.querySelector('.error_msg').innerHTML = xdata['msg'];
                    document.getElementById("xerror_modal").style.display = 'block';
                }else{
                    document.forms.myforms.method = "post";
                    document.forms.myforms.target = "_self";
                    document.forms.myforms.action = "reg_meiform.php";
                    document.forms.myforms.submit();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }else{
            document.querySelector('.error_msg').innerHTML = error_msg_val;
            document.getElementById("xerror_modal").style.display = 'block';
        }
    }
</script>



<?php 
require "includes/cc_footer.php";
?>

