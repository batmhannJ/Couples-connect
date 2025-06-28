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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Couples Connect</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, rgb(215, 217, 225) 0%, rgb(162, 185, 231) 100%);
            min-height: 100vh;
            font-family: Inter, sans-serif;
        }
        
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column !important;
                padding: 20px !important;
                gap: 0 !important;
            }
            .form-section {
                width: 100% !important;
                padding: 10px !important;
            }
            .image-section {
                display: none !important;
            }
        }
        
        @media (min-width: 769px) and (max-width: 1024px) {
            .form-section {
                width: 50% !important;
            }
            .image-section {
                width: 50% !important;
            }
        }
        
        @media (max-width: 768px) {
            .main-container > .form-section > div {
                max-width: 100% !important;
                margin: 10px !important;
                padding: 20px 15px !important;
                border-radius: 15px !important;
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
            .main-container > .form-section > div {
                padding: 18px 12px !important;
            }
            
            .form-title {
                font-size: 22px !important;
            }
            
            footer img[src*="logo"] {
                height: 50px !important;
            }
            
            footer .office-name {
                font-size: 12px !important;
            }
        }

        /* New styles for closer positioning */
        .image-section img {
            object-position: left center !important;
        }
    </style>
</head>
<body>

    <form name='myforms' id="myforms" method="post" target="_self" style="min-height: 100vh; display: flex; flex-direction: column;">
        
        <!-- Main Content Container -->
        <div class="main-container" style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 10px 10px; gap: 20px;">
            
            <!-- Form Section -->
            <div class="form-section" style="width: 50%; display: flex; align-items: center; justify-content: flex-end; padding: 10px 90px 20px 20px;">
                <div style="width: 100%; max-width: 550px; background-color: white; border-radius: 18px; padding: 25px; box-shadow: 0px 8px 32px rgba(0, 0, 0, 0.15);">
                    
                    <!-- Header -->
                    <div style="text-align: center; margin-bottom: 18px;">
                        <p class="form-title" style="font-weight: bold; font-size: 26px; font-family: Inter; margin: 0; color: #333;">Login</p>
                        <p style="font-size: 14px; font-family: Inter; margin: 3px 0 0 0; color: #9B9B9B;">Welcome Back</p>
                    </div>

                    <!-- Email Field -->
                    <div style="margin-bottom: 15px;">
                        <label style="color: black; font-size: 15px; font-weight: 500; margin-bottom: 6px; display: block;">Email: <span style="color: red;">*</span></label>
                        <input type='text' name='email_login' id='email_login' placeholder='Enter your email' 
                               style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box; transition: border-color 0.3s;" 
                               autocomplete='off'
                               onfocus="this.style.borderColor='#23408E'"
                               onblur="this.style.borderColor='#ddd'">
                    </div>

                    <!-- Password Field -->
                    <div style="margin-bottom: 20px;">
                        <label style="color: black; font-size: 15px; font-weight: 500; margin-bottom: 6px; display: block;">Password: <span style="color: red;">*</span></label>
                        <div style="position: relative; width: 100%;">
                            <input type='password' name="pwd_login" id='pwd_login' placeholder='Enter your password' 
                                   style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 35px 0 12px; font-size: 14px; box-sizing: border-box; transition: border-color 0.3s;" 
                                   autocomplete='off'
                                   onfocus="this.style.borderColor='#23408E'"
                                   onblur="this.style.borderColor='#ddd'">
                            <button type="button" id="togglePassword" onclick="togglePasswordVisibility()" 
                                    style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 14px; color: #666; padding: 0; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Login Button -->
                    <div style="text-align: center; margin-bottom: 10px;">
                        <button type="button" onclick="onLogin()" 
                                style="background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%); color: white; width: 100%; height: 45px; font-size: 16px; font-family: Inter; font-weight: 700; border-radius: 8px; border: none; cursor: pointer; box-shadow: 0px 4px 15px rgba(35, 64, 142, 0.3); transition: transform 0.2s, box-shadow 0.2s;"
                                onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0px 6px 20px rgba(35, 64, 142, 0.4)'"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0px 4px 15px rgba(35, 64, 142, 0.3)'">
                            Log in
                        </button>
                    </div>

                    <!-- Create Account Button -->
                    <div style="text-align: center; margin-bottom: 15px;">
                        <button type="button" onclick="onReg()" 
                                style="background-color: #3DCF26; color: white; width: 100%; height: 45px; font-size: 16px; font-family: Inter; font-weight: 700; border-radius: 8px; border: none; cursor: pointer; box-shadow: 0px 4px 15px rgba(61, 207, 38, 0.3); transition: transform 0.2s, box-shadow 0.2s;"
                                onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0px 6px 20px rgba(61, 207, 38, 0.4)'"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0px 4px 15px rgba(61, 207, 38, 0.3)'">
                            Create new account
                        </button>
                    </div>

                    <!-- Alert Message -->
                    <div style="display: none; background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 8px; text-align: center; margin-top: 15px; border: 1px solid #f5c6cb;" id="div_msg" role="alert">
                        <span id='span_msg'></span>
                    </div>
                </div>
            </div>
            
            <!-- Image Section -->
            <div class="image-section" style="width: 40%; height: 67vh; position: relative; overflow: hidden;">
                <img src="images/bgg.png" style="width: 100%; height: 100%; object-fit: cover; object-position: left center; border-radius: 18px;">
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
                    <p class="error_msg" style="margin: 0 0 15px 0;">Modal body text goes here.</p>
                    
                    <div id="reapply-section" style="display: none; margin-top: 15px;">
                        <hr style="margin: 15px 0; border: none; border-top: 1px solid #dee2e6;">
                        <p style="font-size: 16px; margin-bottom: 10px; color: #17a2b8;">You can reapply for account approval:</p>
                        <button type="button" id="reapply-btn" style="width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">
                            <i class="fas fa-redo" style="margin-right: 8px;"></i> Click to Reapply
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer style="background-color: #23408E; padding: 15px 0; margin-top: auto;">
            <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
                    
                    <!-- Left Side - Office Info -->
                    <div style="display: flex; align-items: center; gap: 15px; flex: 1; min-width: 300px;">
                        <img src="images/op office logo.png" style="height: 60px; width: auto;">
                        <div style="font-family: Inter; color: white;">
                            <div class="office-name" style="font-size: 14px; font-weight: bold; margin-bottom: 4px;">
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

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('pwd_login');
            const toggleButton = document.getElementById('togglePassword');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';
            } else {
                passwordInput.type = 'password';
                toggleButton.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
            }
        }

        function onReg() {
            document.forms.myforms.method = "post";
            document.forms.myforms.target = "_self";
            document.forms.myforms.action = "register_cc.php";
            document.forms.myforms.submit();
        }

        function validateEmail(input) {
            var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            return input.value.match(validRegex) ? true : false;
        }

        function onLogin() {
            var xemail_input = document.getElementById("email_login");
            var xpassword = document.getElementById("pwd_login").value;
            var xemail = document.getElementById("email_login").value;

            if (!xpassword || !xemail) {
                document.querySelector('.error_msg').innerHTML = "Empty password or Email";
                document.getElementById("xerror_modal").style.display = 'block';
            } else if (validateEmail(xemail_input) == false) {
                document.querySelector('.error_msg').innerHTML = "Invalid Email";
                document.getElementById("xerror_modal").style.display = 'block';
            } else {
                // Simulate jQuery AJAX with fetch API
                fetch("login_cc_ajax.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: "email=" + encodeURIComponent(xemail) + "&password=" + encodeURIComponent(xpassword)
                })
                .then(response => response.json())
                .then(xdata => {
                    if (xdata['status'] == false) {
                        document.querySelector('.error_msg').innerHTML = xdata['msg'];
                        document.getElementById("xerror_modal").style.display = 'block';
                    } else {
                        var login_after = "select_option.php";

                        if (xdata["userlvl"] == "USR") {
                            login_after = "dashboard_user.php";
                        }
                        document.forms.myforms.method = "post";
                        document.forms.myforms.target = "_self";
                        document.forms.myforms.action = login_after;
                        document.forms.myforms.submit();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        }
    </script>

</body>
</html>