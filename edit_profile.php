<?php
require "includes/cc_header.php";

// Get user type header name
$header_name = '';
if($_SESSION['usertype'] == 'DSK'){
    $header_name = "DESK";
}else if($_SESSION['usertype'] == 'CNR'){
    $header_name = "COUNSELOR";
}else if($_SESSION['usertype'] == 'HED'){
    $header_name = "HEAD";
}else if($_SESSION['usertype'] == 'USR'){
    $header_name = "USER";
}

// Fetch current user information
try {
    $select_user_info = "SELECT partner1_fname, partner1_mname, partner1_lname, email, partner1_sex, partner1_cellphone, partner1_bday, partner1_municipality
                     FROM mf_prog_users WHERE recid = :recid LIMIT 1";
    $stmt_user_info = $link->prepare($select_user_info);
    $stmt_user_info->bindParam(':recid', $_SESSION['usr_recid'], PDO::PARAM_INT);
    $stmt_user_info->execute();
    $user_info = $stmt_user_info->fetch(PDO::FETCH_ASSOC);

    $fname = htmlspecialchars($user_info['partner1_fname'] ?? '', ENT_QUOTES, 'UTF-8');
    $mname = htmlspecialchars($user_info['partner1_mname'] ?? '', ENT_QUOTES, 'UTF-8');
    $lname = htmlspecialchars($user_info['partner1_lname'] ?? '', ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($user_info['email'] ?? '', ENT_QUOTES, 'UTF-8');
    $sex   = htmlspecialchars($user_info['partner1_sex'] ?? '', ENT_QUOTES, 'UTF-8');
    $bday = htmlspecialchars($user_info['partner1_bday'] ?? '', ENT_QUOTES, 'UTF-8');
    $cellphone = htmlspecialchars($user_info['partner1_cellphone'] ?? '', ENT_QUOTES, 'UTF-8');
    $municipality = htmlspecialchars($user_info['partner1_municipality'] ?? '', ENT_QUOTES, 'UTF-8');


    if (!$user_info) {
        header("Location: dashboard_user.php");
        exit();
    }

    $user_display_name = trim($user_info['partner1_fname'] . ' ' . $user_info['partner1_mname'] . ' ' . $user_info['partner1_lname']);
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<style>
    /* Reset and Background - KEPT THE SAME */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        background: url('https://i.pinimg.com/736x/f3/e9/10/f3e910d63d8733cfb20a6c0a6eb70b06.jpg') center/cover fixed;
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }

    /* Profile Container - WIDER */
    .profile-container {
        max-width: 1100px;
        margin: 40px auto;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        overflow: hidden;
        display: flex;
        min-height: 620px;
    }

    /* Left Side - Image/Header (WIDER) */
    .profile-image-side {
        flex: 2; 
        min-width: 250px;
        
        background: url('https://i.pinimg.com/1200x/02/b5/5a/02b55a0a6573a3b7c2417dec3c0098bf.jpg') no-repeat;
        
        background-position: bottom center; 
        background-size: 140%; 
        
        position: relative; 
        padding: 20px 20px; 
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start; 
        text-align: center;
    }
    
    /* Image Overlay for Text Readability */
    .profile-image-side::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(35, 64, 142, 0.65); 
        z-index: 1;
    }

    /* Divider and Content Positioning */
    .profile-image-side::after {
        content: '';
        position: absolute;
        right: 0;
        top: 10%;
        bottom: 10%;
        width: 1px;
        background: rgba(255, 255, 255, 0.3);
        z-index: 2; 
    }
    
    /* Ensure all text content is above the overlay */
    .profile-image-side > * {
        position: relative;
        z-index: 2;
    }
    
    .profile-avatar {
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.2); 
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        /* --- KEY CHANGE: Pinalaki ang top margin (dating 0, ngayon 50px) para bumaba ang buong text block --- */
        margin: 50px auto 8px; 
        border: 3px solid rgba(255,255,255,0.3);
    }
    
    .profile-image-side h2 {
        /* Inalis ang margin-top dito dahil ang avatar na ang nagbaba */
        margin: 10px 0 0; 
        font-size: 24px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5); 
    }
    
    .profile-image-side p {
        margin: 5px 0 0;
        opacity: 0.9;
        font-size: 14px;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5); 
    }


    /* Right Side - Form (NARROWER) */
    .profile-form-side {
        flex: 3;
        padding: 30px 40px;
        overflow-y: hidden;
    }

    /* Form Styles - KEPT THE SAME */
    .form-group {
        margin-bottom: 10px; 
    }

    .form-label {
        display: block;
        margin-bottom: 4px;
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 9px 12px; 
        border: 2px solid #e9ecef;
        border-radius: 6px;
        font-size: 16px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: #23408E;
        box-shadow: 0 0 0 2px rgba(35, 64, 142, 0.1);
    }
    
    textarea.form-control {
        height: 70px;
        resize: none !important;
    }

    .form-row {
        display: flex;
        gap: 15px;
    }

    .form-col {
        flex: 1;
    }

    .btn {
        padding: 9px 18px; 
        border: none;
        border-radius: 6px; 
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-primary {
        background: linear-gradient(90deg, #23408E, #3C94C6);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(35, 64, 142, 0.3);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
        margin-right: 10px;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    .alert {
        padding: 8px;
        margin-bottom: 10px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 13px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    /* Media Query - KEPT THE SAME FOR SMALL SCREENS */
    @media (max-width: 992px) {
        .profile-container {
            flex-direction: column;
            margin: 20px;
            border-radius: 15px;
            min-height: auto;
        }

        .profile-image-side {
            min-height: 180px;
            padding: 20px;
            background-position: center bottom;
        }
        
        .profile-image-side::after {
            content: none;
        }

        .profile-form-side {
            padding: 25px 20px;
        }

        .form-row {
            flex-direction: column;
            gap: 0;
        }
        
        .form-group {
            margin-bottom: 12px;
        }
    }
</style>
<div class="main-container">
    <!-- Navigation Header (same as dashboard) -->
    <div style="width: 100%; font-family: Inter, sans-serif;">
        <div style="width: 100%; background-color: white; height: 80px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: space-between; padding: 0 20px; box-sizing: border-box; position: relative;">
            
            <!-- Logo Section -->
            <div style="flex: 0 0 auto; display: flex; align-items: center;">
                <img src="images/350 x 88.png" style="height: 60px; width: auto;">
            </div>

            <!-- Desktop Navigation -->
            <div id="desktop-nav" style="display: flex; flex-direction: row; justify-content: center; font-family: Inter; font-size: 18px; align-items: center; gap: 30px;">
                <div>
                    <a href="dashboard_user.php" 
                       style="color: black; text-decoration: none; font-weight: 500; transition: all 0.3s ease; padding: 8px 12px; border-radius: 6px;"
                       onmouseover="this.style.color='#23408E'; this.style.backgroundColor='#f8f9fa'"
                       onmouseout="this.style.color='black'; this.style.backgroundColor='transparent'">SERVICES</a>
                </div>

                <div>
                    <a onclick="openFeedback()" 
                       style="color: black; text-decoration: none; font-weight: 500; transition: all 0.3s ease; padding: 8px 12px; border-radius: 6px; cursor: pointer;"
                       onmouseover="this.style.color='#23408E'; this.style.backgroundColor='#f8f9fa'"
                       onmouseout="this.style.color='black'; this.style.backgroundColor='transparent'">FEEDBACK</a>
                </div>

                <div style="height: 20px; width: 1px; background-color: #ddd; margin: 0 5px;"></div>

                <div style="position: relative;">
                    <div onclick="toggleUserDropdown()" style="cursor: pointer; display: flex; align-items: center; gap: 8px; padding: 8px 12px; border-radius: 6px; transition: background-color 0.3s ease;" 
                         onmouseover="this.style.backgroundColor='#f8f9fa'"
                         onmouseout="this.style.backgroundColor='transparent'">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" fill="#23408E"/>
                            <path d="M12 14C7.58172 14 4 17.5817 4 22H20C20 17.5817 16.4183 14 12 14Z" fill="#23408E"/>
                        </svg>
                        <span style="color: #23408E; font-weight: 600;"><?php echo $header_name; ?></span>
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 4.5L6 7.5L9 4.5" stroke="#23408E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    
                    <!-- User Dropdown -->
                    <div id="userDropdown" style="display: none; position: absolute; top: 100%; right: 0; background: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 250px; z-index: 1001; padding: 16px; margin-top: 8px;">
                        <div style="text-align: center; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #eee;">
                            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #23408E, #3C94C6); border-radius: 50%; margin: 0 auto 12px; display: flex; align-items: center; justify-content: center;">
                                <svg width="30" height="30" viewBox="0 0 24 24" fill="white">
                                    <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"/>
                                    <path d="M12 14C7.58172 14 4 17.5817 4 22H20C20 17.5817 16.4183 14 12 14Z"/>
                                </svg>
                            </div>
                            <div style="font-weight: 600; color: #333; font-size: 16px;"><?php echo $user_display_name; ?></div>
                            <div style="color: #666; font-size: 14px;"><?php echo $user_info['email']; ?></div>
                        </div>
                        
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <button onclick="window.location.href='edit_profile.php'" style="background: none; border: none; padding: 12px; text-align: left; border-radius: 6px; cursor: pointer; transition: background-color 0.3s; display: flex; align-items: center; gap: 12px; font-family: Inter; font-size: 14px;"
                                    onmouseover="this.style.backgroundColor='#f8f9fa'"
                                    onmouseout="this.style.backgroundColor='transparent'">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="#666">
                                    <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 13"/>
                                    <path d="M18.5 2.49998C18.8978 2.10216 19.4374 1.87866 20 1.87866C20.5626 1.87866 21.1022 2.10216 21.5 2.49998C21.8978 2.89781 22.1213 3.43737 22.1213 3.99998C22.1213 4.56259 21.8978 5.10216 21.5 5.49998L12 15L8 16L9 12L18.5 2.49998Z"/>
                                </svg>
                                Edit Profile
                            </button>
                            
                            <button onclick="logout()" style="background: none; border: none; padding: 12px; text-align: left; border-radius: 6px; cursor: pointer; transition: background-color 0.3s; display: flex; align-items: center; gap: 12px; font-family: Inter; font-size: 14px; color: #dc3545;"
                                    onmouseover="this.style.backgroundColor='#fff5f5'"
                                    onmouseout="this.style.backgroundColor='transparent'">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="#dc3545">
                                    <path d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9"/>
                                    <path d="M16 17L21 12L16 7"/>
                                    <path d="M21 12H9"/>
                                </svg>
                                Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Content -->
<div class="profile-container">

    <div class="profile-image-side">
        <div class="profile-avatar">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="white">
                <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"/>
                <path d="M12 14C7.58172 14 4 17.5817 4 22H20C20 17.5817 16.4183 14 12 14Z"/>
            </svg>
        </div>
        <h2><?php echo $user_display_name; ?></h2>
        <p><?php echo $header_name; ?> Account</p>
    </div>

    <div class="profile-form-side">
        <h3 style="margin-top: 0; margin-bottom: 30px; font-size: 24px; color: #23408E;">Edit Your Profile Information</h3>
        
        <div id="alertContainer"></div>
        
        <form id="profileForm" method="POST" action="">
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        <input type="text" name="fname" class="form-control" value="<?php echo $fname; ?>" required>
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Middle Name</label>
                        <input type="text" name="mname" class="form-control" value="<?php echo $mname; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Last Name</label>
                <input type="text" name="lname" class="form-control" value="<?php echo $lname; ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="cellphone" class="form-control" value="<?php echo $cellphone; ?>">
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Birth Date</label>
                        <input type="date" name="bday" class="form-control" value="<?php echo $bday; ?>">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <select name="sex" class="form-control" required>
                            <option value="Male" <?php echo ($sex == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($sex == 'Female') ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo ($sex == 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                </div>
                <div class="form-col"></div> </div>

            <div class="form-group">
                <label class="form-label">Address</label>
                <textarea name="municipality" class="form-control" rows="3" style="resize: vertical;"><?php echo $municipality; ?></textarea>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 40px;">
                <a href="dashboard_user.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>
        </form>
    </div>
</div>

<!-- Footer -->
<footer style="background-color:#23408E; height: 100px; margin-top: 40px;">
    <div class="container-fluid" style='height:100px'>
        <div class="row" style='height:100px'>
            <div class="col-4">
                <div class="row ms-3" style='height:100px'>
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

<script>
// Handle form submission
// Handle form submission
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('update_profile_ajax.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const alertContainer = document.getElementById('alertContainer');
        
        // Check for data.status instead of data.success
        if (data.status === 'success') {
            alertContainer.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
            // Scroll to top to show alert
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            alertContainer.innerHTML = '<div class="alert alert-error">Error: ' + (data.message || 'An error occurred') + '</div>';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const alertContainer = document.getElementById('alertContainer');
        alertContainer.innerHTML = '<div class="alert alert-error">An error occurred while updating your profile.</div>';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});

// Dropdown functions
function toggleUserDropdown() {
    const dropdown = document.getElementById('userDropdown');
    if (dropdown.style.display === 'none' || dropdown.style.display === '') {
        dropdown.style.display = 'block';
    } else {
        dropdown.style.display = 'none';
    }
}

function logout() {
    window.location.href = 'logout_cc.php';
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('userDropdown');
    const userMenu = event.target.closest('[onclick="toggleUserDropdown()"]');
    
    if (!userMenu && !dropdown.contains(event.target)) {
        dropdown.style.display = 'none';
    }
});

function openFeedback(){
    // You can implement feedback modal here or redirect
    alert('Feedback functionality - to be implemented');
}
</script>

<?php require "includes/cc_footer.php"; ?>