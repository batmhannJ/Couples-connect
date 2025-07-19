<?php
require "includes/cc_header.php";
?>

<style>
    html.full-height{
        height: 140%;
    }
</style>

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

     <style>
        input[type="date"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    position: relative;
    cursor: pointer;
}

input[type="date"]::-webkit-calendar-picker-indicator {
    position: absolute;
    right: 8px;
    cursor: pointer;
    filter: invert(0.5);
    width: 20px;
    height: 20px;
}

input[type="date"]:focus {
    border-color: #23408E !important;
    box-shadow: 0 0 0 2px rgba(35, 64, 142, 0.1) !important;
    outline: none;
}

/* Ensure date inputs are clickable */
input[type="date"]::-webkit-inner-spin-button,
input[type="date"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox specific fixes */
input[type="date"]::-moz-focus-inner {
    border: 0;
}
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
                gap: 20px !important;
            }
            .partner-section {
                width: 100% !important;
                padding: 0 !important;
            }
            .partner-card {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 20px 15px !important;
                border-radius: 15px !important;
            }
            .partner-title {
                font-size: 22px !important;
            }
            .form-row {
                flex-direction: column !important;
                gap: 15px !important;
            }
            .form-row > div {
                width: 100% !important;
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
            .partner-card {
                padding: 18px 12px !important;
            }
            .partner-title {
                font-size: 20px !important;
            }
            footer img[src*="logo"] {
                height: 50px !important;
            }
            footer .office-name {
                font-size: 12px !important;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .partner-section {
                width: 50% !important;
            }
        }

        .form-control {
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            border-color: #23408E !important;
            box-shadow: 0 0 0 2px rgba(35, 64, 142, 0.1) !important;
        }

        .btn-continue {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-continue:hover {
            transform: translateY(-1px);
            box-shadow: 0px 6px 20px rgba(35, 64, 142, 0.4) !important;
        }
    </style>
</head>
<body>

    <form name='myforms' id="myforms" method="post" target="_self" style="min-height: 100vh; display: flex; flex-direction: column;">
        
        <!-- Main Content Container -->
        <div class="main-container" style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 20px; gap: 30px;">
            
            <!-- Partner 1 Section -->
            <div class="partner-section" style="width: 50%; display: flex; align-items: center; justify-content: center; padding: 10px;">
                <div class="partner-card" style="width: 100%; max-width: 550px; background-color: white; border-radius: 18px; padding: 30px; box-shadow: 0px 8px 32px rgba(0, 0, 0, 0.15);">
                    
                    <!-- Header -->
                    <div style="text-align: center; margin-bottom: 25px;">
                        <p class="partner-title" style="font-weight: bold; font-size: 28px; font-family: Inter; margin: 0; color: #333;">Partner 1</p>
                        <p style="font-size: 16px; font-family: Inter; margin: 3px 0 0 0; color: #9B9B9B;">Personal Information</p>
                        <div style="width: 80%; height: 3px; background: linear-gradient(90deg, #23408E 0%, #3C94C6 100%); margin: 15px auto; border-radius: 2px;"></div>
                    </div>

                    <!-- First Name -->
                    <div style="margin-bottom: 15px;">
                        <label style="color: black; font-size: 17px; font-weight: 500; margin-bottom: 6px; display: block;">First Name: <span style="color: red;">*</span></label>
                        <input type='text' name='first_name' id='first_name' placeholder='Enter your first name' 
                               class="form-control"
                               style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box;" 
                               autocomplete='off'>
                    </div>

                    <!-- Middle Name and Last Name Row -->
                    <div class="form-row" style="display: flex; gap: 10px; margin-bottom: 15px;">
                        <div style="flex: 1;">
                            <label style="color: black; font-size: 17px; font-weight: 500; margin-bottom: 6px; display: block;">Middle Name: <span style="color: red;">*</span></label>
                            <input type='text' name="middle_name" id='middle_name' placeholder='Enter your middle name' 
                                   class="form-control"
                                   style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box;" 
                                   autocomplete='off'>
                        </div>
                        <div style="flex: 1;">
                            <label style="color: black; font-size: 17px; font-weight: 500; margin-bottom: 6px; display: block;">Last Name: <span style="color: red;">*</span></label>
                            <input type='text' name="last_name" id='last_name' placeholder='Enter your last name' 
                                   class="form-control"
                                   style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box;" 
                                   autocomplete='off'>
                        </div>
                    </div>

                    <!-- Sex/Gender and Birthday Row -->
                    <div class="form-row" style="display: flex; gap: 10px; margin-bottom: 15px;">
                        <div style="flex: 1;">
                            <label style="color: black; font-size: 17px; font-weight: 500; margin-bottom: 6px; display: block;">Sex/Gender: <span style="color: red;">*</span></label>
                            <select name='sex' id='sex' class="form-control"
                                    style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box; background-color: white;">
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                                <option value="O">Others</option>
                            </select>
                        </div>
                        <div style="flex: 1;">
    <label style="color: black; font-size: 17px; font-weight: 500; margin-bottom: 6px; display: block;">Birthday: <span style="color: red;">*</span></label>
    <input type='date' name="bday" id='bday' 
           class="form-control"
           style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box; background-color: white; color: #333;" 
           autocomplete='off'
           max="<?php echo date('Y-m-d'); ?>">
</div>
                    </div>

                    <!-- Country and Municipality Row -->
                    <div class="form-row" style="display: flex; gap: 10px; margin-bottom: 15px;">
                        <div style="flex: 1;">
                            <label style="color: black; font-size: 17px; font-weight: 500; margin-bottom: 6px; display: block;">Country: (You were born in) <span style="color: red;">*</span></label>
                            <select name="country" id="country" class="form-control"
                                    style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box; background-color: white;">
                                <option value="">Select Country</option>
                                <option value="Philippines">Philippines</option>
                                <option value="United States">United States</option>
                                <option value="Canada">Canada</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="Australia">Australia</option>
                            </select>
                        </div>
                        <div style="flex: 1;">
                            <label style="color: black; font-size: 17px; font-weight: 500; margin-bottom: 6px; display: block;">Current Municipality: <span style="color: red;">*</span></label>
                            <input type='text' name="municipality" id='municipality' placeholder='Enter Municipality' 
                                   class="form-control"
                                   style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box;" 
                                   autocomplete='off'>
                        </div>
                    </div>

                    <!-- Occupation and Cellphone Row -->
                    <div class="form-row" style="display: flex; gap: 10px; margin-bottom: 20px;">
                        <div style="flex: 1;">
                            <label style="color: black; font-size: 17px; font-weight: 500; margin-bottom: 6px; display: block;">Occupation: <span style="color: red;">*</span></label>
                            <input type='text' name="occupation" id='occupation' placeholder='Enter your occupation' 
                                   class="form-control"
                                   style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box;" 
                                   autocomplete='off'>
                        </div>
                        <div style="flex: 1;">
                            <label style="color: black; font-size: 17px; font-weight: 500; margin-bottom: 6px; display: block;">Cellphone Number: <span style="color: red;">*</span></label>
                            <input type='text' name="cellphone_number" id='cellphone_number' placeholder='Enter your cellphone number' 
                                   class="form-control"
                                   style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box;" 
                                   autocomplete='off'>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Partner 2 Section -->
            <div class="partner-section" style="width: 50%; display: flex; align-items: center; justify-content: center; padding: 10px;">
                <div class="partner-card" style="width: 100%; max-width: 550px; background-color: white; border-radius: 18px; padding: 30px; box-shadow: 0px 8px 32px rgba(0, 0, 0, 0.15);">
                    
                    <!-- Header -->
                    <div style="text-align: center; margin-bottom: 25px;">
                        <p class="partner-title" style="font-weight: bold; font-size: 28px; font-family: Inter; margin: 0; color: #333;">Partner 2</p>
                        <p style="font-size: 16px; font-family: Inter; margin: 3px 0 0 0; color: #9B9B9B;">Personal Information</p>
                        <div style="width: 80%; height: 3px; background: linear-gradient(90deg, #23408E 0%, #3C94C6 100%); margin: 15px auto; border-radius: 2px;"></div>
                    </div>

                    <!-- First Name -->
                    <div style="margin-bottom: 15px;">
                        <label style="color: black; font-size: 17px; font-weight: 500; margin-bottom: 6px; display: block;">First Name: <span style="color: red;">*</span></label>
                        <input type='text' name='first_name2' id='first_name2' placeholder='Enter your first name' 
                               class="form-control"
                               style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box;" 
                               autocomplete='off'>
                    </div>

                    <!-- Middle Name and Last Name Row -->
                    <div class="form-row" style="display: flex; gap: 10px; margin-bottom: 15px;">
                        <div style="flex: 1;">
                            <label style="color: black; font-size: 17px; font-weight: 500; margin-bottom: 6px; display: block;">Middle Name: <span style="color: red;">*</span></label>
                            <input type='text' name="middle_name2" id='middle_name2' placeholder='Enter your middle name' 
                                   class="form-control"
                                   style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box;" 
                                   autocomplete='off'>
                        </div>
                        <div style="flex: 1;">
                            <label style="color: black; font-size: 17px; font-weight: 500; margin-bottom: 6px; display: block;">Last Name: <span style="color: red;">*</span></label>
                            <input type='text' name="last_name2" id='last_name2' placeholder='Enter your last name' 
                                   class="form-control"
                                   style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box;" 
                                   autocomplete='off'>
                        </div>
                    </div>

                    <!-- Sex/Gender and Birthday Row -->
                    <div class="form-row" style="display: flex; gap: 10px; margin-bottom: 15px;">
                        <div style="flex: 1;">
                            <label style="color: black; font-size: 17px; font-weight: 500; margin-bottom: 6px; display: block;">Sex/Gender: <span style="color: red;">*</span></label>
                            <select name='sex2' id='sex2' class="form-control"
                                    style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box; background-color: white;">
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                                <option value="O">Others</option>
                            </select>
                        </div>
                        <div style="flex: 1;">
    <label style="color: black; font-size: 17px; font-weight: 500; margin-bottom: 6px; display: block;">Birthday: <span style="color: red;">*</span></label>
    <input type='date' name="bday2" id='bday2' 
           class="form-control"
           style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box; background-color: white; color: #333;" 
           autocomplete='off'
           max="<?php echo date('Y-m-d'); ?>">
</div>
                    </div>

                    <!-- Country and Municipality Row -->
                    <div class="form-row" style="display: flex; gap: 10px; margin-bottom: 15px;">
                        <div style="flex: 1;">
                            <label style="color: black; font-size: 17px; font-weight: 500; margin-bottom: 6px; display: block;">Country: (You were born in) <span style="color: red;">*</span></label>
                            <select name="country2" id="country2" class="form-control"
                                    style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box; background-color: white;">
                                <option value="">Select Country</option>
                                <option value="Philippines">Philippines</option>
                                <option value="United States">United States</option>
                                <option value="Canada">Canada</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="Australia">Australia</option>
                            </select>
                        </div>
                        <div style="flex: 1;">
                            <label style="color: black; font-size: 17px; font-weight: 500; margin-bottom: 6px; display: block;">Current Municipality: <span style="color: red;">*</span></label>
                            <input type='text' name="municipality2" id='municipality2' placeholder='Enter Municipality' 
                                   class="form-control"
                                   style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box;" 
                                   autocomplete='off'>
                        </div>
                    </div>

                    <!-- Occupation and Cellphone Row -->
                    <div class="form-row" style="display: flex; gap: 10px; margin-bottom: 20px;">
                        <div style="flex: 1;">
                            <label style="color: black; font-size: 17px; font-weight: 500; margin-bottom: 6px; display: block;">Occupation: <span style="color: red;">*</span></label>
                            <input type='text' name="occupation2" id='occupation2' placeholder='Enter your occupation' 
                                   class="form-control"
                                   style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box;" 
                                   autocomplete='off'>
                        </div>
                        <div style="flex: 1;">
                            <label style="color: black; font-size: 17px; font-weight: 500; margin-bottom: 6px; display: block;">Cellphone Number: <span style="color: red;">*</span></label>
                            <input type='text' name="cellphone_number2" id='cellphone_number2' placeholder='Enter your cellphone number' 
                                   class="form-control"
                                   style="height: 45px; border: 1px solid #ddd; border-radius: 8px; width: 100%; padding: 0 12px; font-size: 14px; box-sizing: border-box;" 
                                   autocomplete='off'>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Continue Button Section -->
        <div style="text-align: center; padding: 20px 0 30px 0;">
            <button type="button" onclick="onContinue()" class="btn-continue"
                    style="background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%); color: white; width: 300px; height: 50px; font-size: 25px; font-family: Inter; font-weight: 700; border-radius: 10px; border: none; cursor: pointer; box-shadow: 0px 4px 11px rgba(0, 0, 0, 0.25);">
                Continue
            </button>
        </div>

        <!-- Modal -->
        <div style="display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: hidden; background-color: rgba(0,0,0,0.5);" id="xerror_modal">
            <div style="position: relative; width: auto; max-width: 500px; margin: 30px auto; display: flex; flex-direction: column; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); top: 50%; transform: translateY(-50%);">
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; border-bottom: 1px solid #dee2e6; border-radius: 10px 10px 0 0;">
                    <h5 style="margin: 0; font-size: 18px; font-weight: 600;">Couples Connect Says:</h5>
                    <button type="button" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #999;" onclick="document.getElementById('xerror_modal').style.display='none'">×</button>
                </div>
                <div style="padding: 20px;">
                    <p class="error_msg" style="margin: 0;">Please fill up all required fields.</p>
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
        
        <!-- Hidden Variables -->
        <input type='hidden' id="reg_email_h" name="reg_email_h" value="">
        <input type='hidden' name="confirm_email_h" id='confirm_email_h' value="">
        <input type='hidden' name="reg_pwd_h" id='reg_pwd_h' value="">
        <input type='hidden' name="confirm_pwd_h" id='confirm_pwd_h' value="">
        
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    // Get both birthday inputs
    const bday1 = document.getElementById('bday');
    const bday2 = document.getElementById('bday2');
    
    // Set max date to today
    const today = new Date().toISOString().split('T')[0];
    bday1.max = today;
    bday2.max = today;
    
    // Add event listeners to ensure the inputs work
    bday1.addEventListener('focus', function() {
        this.showPicker();
    });
    
    bday2.addEventListener('focus', function() {
        this.showPicker();
    });
    
    // Alternative click handler for better browser support
    bday1.addEventListener('click', function() {
        if (this.showPicker) {
            this.showPicker();
        }
    });
    
    bday2.addEventListener('click', function() {
        if (this.showPicker) {
            this.showPicker();
        }
    });
});
        // Keep the original onContinue function placeholder
        function onContinue() {
            // Add your form validation and submission logic here
            console.log('Continue button clicked');
            
            // Example validation (you can modify this based on your needs)
            var requiredFields = [
                'first_name', 'middle_name', 'last_name', 'sex', 'bday', 'country', 'municipality', 'occupation', 'cellphone_number',
                'first_name2', 'middle_name2', 'last_name2', 'sex2', 'bday2', 'country2', 'municipality2', 'occupation2', 'cellphone_number2'
            ];
            
            var isValid = true;
            var emptyFields = [];
            
            requiredFields.forEach(function(fieldId) {
                var field = document.getElementById(fieldId);
                if (!field || !field.value.trim()) {
                    isValid = false;
                    emptyFields.push(fieldId);
                }
            });
            
            if (!isValid) {
                document.querySelector('.error_msg').innerHTML = 'Please fill up all required fields.';
                document.getElementById('xerror_modal').style.display = 'block';
                return;
            }
            
            // If validation passes, submit the form or proceed to next step
            alert('Form validation passed! Add your submission logic here.');
        }
    </script>

</body>
</html>

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

