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

$select_db_all="SELECT * FROM mf_prog_users WHERE recid=?";
$stmt	= $link->prepare($select_db_all);
$stmt->execute(array($_POST['ac_recid_hidden']));
$rs_all = $stmt->fetch();

$userid = $rs_all['userid'];


$xcount = 0;
$email = '';
$select_db_partnerinfo="SELECT 
    username as 'mf_username', 
    secondary_email as 'mf_secondary_email', 
    email as 'mf_email', 
    partner1_fname as 'partner1_firstname',
    partner1_mname as 'partner1_middlename', 
    partner1_lname as 'partner1_lastname',
    partner1_sex as 'partner1_sex',
    partner1_bday as 'partner1_bday',
    partner1_cellphone as 'partner1_cellphone',
    partner1_occupation as 'partner1_occupation',
    partner1_municipality as 'partner1_municipality',
    partner2_fname as 'partner2_firstname',
    partner2_mname as 'partner2_middlename', 
    partner2_lname as 'partner2_lastname',
    partner2_sex as 'partner2_sex',
    partner2_bday as 'partner2_bday',
    partner2_cellphone as 'partner2_cellphone',
    partner2_occupation as 'partner2_occupation',
    partner2_municipality as 'partner2_municipality',
    date_requested as 'mf_date_requested', 
    doc_link as 'mf_doc_link', 
    crm_link as 'mf_crm_link',
    justification as 'mf_justification'  
FROM mf_prog_users 
WHERE usertype='USR' AND act_status='FA' AND userid=?";
$stmt_partnerinfo = $link->prepare($select_db_partnerinfo);
$stmt_partnerinfo->execute(array($userid));
$rs_partnerinfo = $stmt_partnerinfo->fetch();

if($rs_partnerinfo) {
    $email = $rs_partnerinfo['mf_email'];
    $secondary_email = $rs_partnerinfo['mf_secondary_email'];
    $justification = $rs_partnerinfo['mf_justification'];
    
    // Handle document links
    if(isset($rs_partnerinfo['mf_doc_link']) && !empty($rs_partnerinfo['mf_doc_link'])){
        $doc_link = $rs_partnerinfo['mf_doc_link'];
        $doc_link_arr = explode("/",$rs_partnerinfo['mf_doc_link']);
        $doc_link_filename = $doc_link_arr[1];
    }else{
        $doc_link_filename = '';
    }

    if(isset($rs_partnerinfo['mf_crm_link']) && !empty($rs_partnerinfo['mf_crm_link'])){
        $crm_link = $rs_partnerinfo['mf_crm_link'];
        $crm_link_arr = explode("/",$rs_partnerinfo['mf_crm_link']);
        $crm_link_filename = $crm_link_arr[1];
    }else{
        $crm_link_filename = '';
    }
    
    // Partner 1 information
    $username = $rs_partnerinfo['mf_username'];
    $full_name = $rs_partnerinfo['partner1_firstname'].' '.$rs_partnerinfo['partner1_middlename'].' '.$rs_partnerinfo['partner1_lastname'];
    $birthdate = date('F d, Y', strtotime($rs_partnerinfo['partner1_bday']));
    $contact = $rs_partnerinfo['partner1_cellphone'];
    $occupation = $rs_partnerinfo['partner1_occupation'];
    $address = $rs_partnerinfo['partner1_municipality'];
    $gender = $rs_partnerinfo['partner1_sex'];
    
    // Partner 2 information
    $full_name2 = $rs_partnerinfo['partner2_firstname'].' '.$rs_partnerinfo['partner2_middlename'].' '.$rs_partnerinfo['partner2_lastname'];
    $birthdate2 = date('F d, Y', strtotime($rs_partnerinfo['partner2_bday']));
    $contact2 = $rs_partnerinfo['partner2_cellphone'];
    $occupation2 = $rs_partnerinfo['partner2_occupation'];
    $address2 = $rs_partnerinfo['partner2_municipality'];
    $gender2 = $rs_partnerinfo['partner2_sex'];
}
?>
    <style>

        .ellipsis {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
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
                    <a href="http://localhost/couples-connect/select_option.php" style='color:black;text-decoration:none' class='has_hover'>HOME</a>
                </div>

                <div style="flex:.1;text-align:center;padding-right:10px">
                    <a style='color:black;text-decoration:none'>|</a>
                </div>

                <div style="flex:.3;text-align:center;padding-right:15px">
                    <a style='color:black;text-decoration:none'><?php echo $header_name;?> </a>
                </div>

                <div style="flex:0.6;text-align:right;padding-right:35px">
                    <a href="http://localhost/couples-connect/logout_cc.php"  class='has_hover' style='color:black;text-decoration:none'>LOGOUT</a>
                </div>

            </div> 
        </div>
    </div>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Confirmation Review</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<form name='myforms' id="myforms" method="post" target="_self" style='min-height:100vh; background: linear-gradient(135deg, rgb(215, 217, 225) 0%, rgb(162, 185, 231) 100%); padding: 20px; font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;'>
    <div style="max-width: 1400px; margin: 0 auto; height: calc(100vh - 40px);">
        
        <!-- Main Content Card -->
        <div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 24px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; border: 1px solid rgba(255, 255, 255, 0.2); height: 100%; overflow: hidden;">

            <!-- Header with Back Button -->
            <div style="padding: 20px 32px 16px 32px; border-bottom: 1px solid rgba(0, 0, 0, 0.05); flex-shrink: 0;">
                <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 12px;">
                    <a href="http://localhost/couples-connect/cc_account_confirm.php" style="background: rgba(79, 70, 229, 0.1); padding: 12px; border-radius: 12px; text-decoration: none; transition: all 0.2s ease;" onmouseover="this.style.background='rgba(79, 70, 229, 0.2)'" onmouseout="this.style.background='rgba(79, 70, 229, 0.1)'">
                        <i class="fas fa-arrow-left" style="color: #4f46e5; font-size: 18px;"></i>
                    </a>
                    <h1 style="font-size: 26px; font-weight: 700; color: #1a1a1a; margin: 0; flex: 1; text-align: center; padding-right: 50px;">Account Confirmation</h1>
                </div>
                <div style="height: 3px; background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%); border-radius: 2px; width: 100%;"></div>
            </div>

            <!-- Content Area -->
            <div style="flex: 1; overflow-y: auto; padding: 24px 32px;">
                
                <!-- Account Information Section -->
                <div style="background: rgba(255, 255, 255, 0.7); border-radius: 16px; padding: 24px; margin-bottom: 24px; border: 1px solid rgba(0, 0, 0, 0.05);">
                    <h3 style="font-size: 20px; font-weight: 700; color: #1a1a1a; margin: 0 0 20px 0; display: flex; align-items: center; gap: 8px;">
                        <div style="width: 6px; height: 24px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); border-radius: 3px;"></div>
                        Account Information
                    </h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div style="background: rgba(79, 70, 229, 0.05); border-radius: 12px; padding: 16px; border-left: 4px solid #4f46e5;">
                            <span style="font-size: 16px; font-weight: 500; color: #374151;">Email Address: </span>
                            <span style="font-weight: 700; color: #1f2937;"><?php echo $email;?></span>
                        </div>
                        <div style="background: rgba(16, 185, 129, 0.05); border-radius: 12px; padding: 16px; border-left: 4px solid #10b981;">
                            <span style="font-size: 16px; font-weight: 500; color: #374151;">Secondary Email: </span>
                            <span style="font-weight: 700; color: #1f2937;"><?php echo $secondary_email;?></span>
                        </div>
                    </div>
                </div>

                <!-- Personal Information Section -->
                <div style="background: rgba(255, 255, 255, 0.7); border-radius: 16px; padding: 24px; margin-bottom: 24px; border: 1px solid rgba(0, 0, 0, 0.05);">
                    <h3 style="font-size: 20px; font-weight: 700; color: #1a1a1a; margin: 0 0 20px 0; display: flex; align-items: center; gap: 8px;">
                        <div style="width: 6px; height: 24px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 3px;"></div>
                        Personal Information
                    </h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">
                        <!-- Partner 1 -->
                        <div style="background: rgba(255, 255, 255, 0.8); border-radius: 12px; padding: 20px; border: 1px solid rgba(0, 0, 0, 0.05);">
                            <h4 style="font-size: 18px; font-weight: 700; color: #4f46e5; margin: 0 0 16px 0; text-align: center; padding-bottom: 8px; border-bottom: 2px solid rgba(79, 70, 229, 0.2);">Partner 1</h4>
                            
                            <div style="display: flex; flex-direction: column; gap: 12px;">
                                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
                                    <span style="font-weight: 500; color: #6b7280;">Name:</span>
                                    <span style="font-weight: 700; color: #1f2937;"><?php echo $full_name;?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
                                    <span style="font-weight: 500; color: #6b7280;">Birthdate:</span>
                                    <span style="font-weight: 700; color: #1f2937;"><?php echo $birthdate;?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
                                    <span style="font-weight: 500; color: #6b7280;">Gender:</span>
                                    <span style="font-weight: 700; color: #1f2937;"><?php echo $gender;?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
                                    <span style="font-weight: 500; color: #6b7280;">Contact:</span>
                                    <span style="font-weight: 700; color: #1f2937;"><?php echo $contact;?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
                                    <span style="font-weight: 500; color: #6b7280;">Occupation:</span>
                                    <span style="font-weight: 700; color: #1f2937;"><?php echo $occupation;?></span>
                                </div>
                                <div style="padding: 8px 0;">
                                    <span style="font-weight: 500; color: #6b7280; display: block; margin-bottom: 4px;">Address:</span>
                                    <span style="font-weight: 700; color: #1f2937;"><?php echo $address;?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Partner 2 -->
                        <div style="background: rgba(255, 255, 255, 0.8); border-radius: 12px; padding: 20px; border: 1px solid rgba(0, 0, 0, 0.05);">
                            <h4 style="font-size: 18px; font-weight: 700; color: #7c3aed; margin: 0 0 16px 0; text-align: center; padding-bottom: 8px; border-bottom: 2px solid rgba(124, 58, 237, 0.2);">Partner 2</h4>
                            
                            <div style="display: flex; flex-direction: column; gap: 12px;">
                                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
                                    <span style="font-weight: 500; color: #6b7280;">Name:</span>
                                    <span style="font-weight: 700; color: #1f2937;"><?php echo $full_name2;?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
                                    <span style="font-weight: 500; color: #6b7280;">Birthdate:</span>
                                    <span style="font-weight: 700; color: #1f2937;"><?php echo $birthdate2;?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
                                    <span style="font-weight: 500; color: #6b7280;">Gender:</span>
                                    <span style="font-weight: 700; color: #1f2937;"><?php echo $gender2;?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
                                    <span style="font-weight: 500; color: #6b7280;">Contact:</span>
                                    <span style="font-weight: 700; color: #1f2937;"><?php echo $contact2;?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
                                    <span style="font-weight: 500; color: #6b7280;">Occupation:</span>
                                    <span style="font-weight: 700; color: #1f2937;"><?php echo $occupation2;?></span>
                                </div>
                                <div style="padding: 8px 0;">
                                    <span style="font-weight: 500; color: #6b7280; display: block; margin-bottom: 4px;">Address:</span>
                                    <span style="font-weight: 700; color: #1f2937;"><?php echo $address2;?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents Section -->
                <div style="background: rgba(255, 255, 255, 0.7); border-radius: 16px; padding: 24px; margin-bottom: 24px; border: 1px solid rgba(0, 0, 0, 0.05);">
                    <h3 style="font-size: 20px; font-weight: 700; color: #1a1a1a; margin: 0 0 20px 0; display: flex; align-items: center; gap: 8px;">
                        <div style="width: 6px; height: 24px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 3px;"></div>
                        Personal Documents
                    </h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <!-- Proof of Residency -->
                        <div style="background: rgba(249, 115, 22, 0.05); border-radius: 12px; padding: 16px; border-left: 4px solid #f97316;">
                            <div style="font-weight: 600; color: #1f2937; margin-bottom: 8px;">Proof of Residency</div>
                            <a href="<?php echo $doc_link; ?>" style="color: #4f46e5; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: rgba(79, 70, 229, 0.1); border-radius: 8px; transition: all 0.2s ease;" download="<?php echo $doc_link_filename;?>" onmouseover="this.style.background='rgba(79, 70, 229, 0.2)'" onmouseout="this.style.background='rgba(79, 70, 229, 0.1)'">
                                <i class="fas fa-download"></i>
                                <?php echo $doc_link_filename; ?>
                            </a>
                        </div>

                        <!-- PMOC Application -->
                        <div style="background: rgba(239, 68, 68, 0.05); border-radius: 12px; padding: 16px; border-left: 4px solid #ef4444;">
                            <div style="font-weight: 700; color: #1f2937; margin-bottom: 12px;">Application for PMOC</div>
                            
                            <div style="margin-bottom: 16px;">
                                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 8px;">Justification</label>
                                <textarea readonly style="width: 100%; border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 12px; font-size: 14px; font-weight: 500; background: rgba(255, 255, 255, 0.8); resize: none; min-height: 80px;"><?php echo $justification; ?></textarea>
                            </div>

                            <div>
                                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 8px;">Evidence</label>
                                <div>
                                    <?php
                                    if(empty($crm_link)){
                                        echo "<span style='color: #6b7280; font-style: italic;'>User did not apply for PMOC</span>";
                                    }else{
                                        echo "<a href='".$crm_link."' style='color: #4f46e5; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: rgba(79, 70, 229, 0.1); border-radius: 8px; transition: all 0.2s ease;' download='".$crm_link_filename."' onmouseover='this.style.background=\"rgba(79, 70, 229, 0.2)\"' onmouseout='this.style.background=\"rgba(79, 70, 229, 0.1)\"'>";
                                        echo "<i class='fas fa-download'></i>";
                                        echo $crm_link_filename;
                                        echo "</a>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; justify-content: center; gap: 20px; padding: 20px 0;">
                    <button type="button" onclick="decline()" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; padding: 16px 32px; border-radius: 12px; font-size: 16px; font-family: Inter; font-weight: 700; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); cursor: pointer; transition: all 0.3s ease; min-width: 160px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(239, 68, 68, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(239, 68, 68, 0.3)'">
                        <i class="fas fa-times" style="margin-right: 8px;"></i>
                        Decline
                    </button>
                    <button type="button" onclick="acc_choose('PMO')" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; padding: 16px 32px; border-radius: 12px; font-size: 16px; font-family: Inter; font-weight: 700; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); cursor: pointer; transition: all 0.3s ease; min-width: 160px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(16, 185, 129, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(16, 185, 129, 0.3)'">
                        <i class="fas fa-check" style="margin-right: 8px;"></i>
                        Approve
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Design -->
    <style>
        @media (max-width: 1024px) {
            form > div > div > div:nth-child(3) > div:nth-child(2) > div {
                grid-template-columns: 1fr !important;
                gap: 16px !important;
            }
            
            form > div > div > div:nth-child(2) > div > div {
                grid-template-columns: 1fr !important;
                gap: 16px !important;
            }
        }
        
        @media (max-width: 768px) {
            form {
                padding: 12px !important;
            }
            
            h1 {
                font-size: 22px !important;
                padding-right: 0 !important;
            }
            
            h3 {
                font-size: 18px !important;
            }
            
            h4 {
                font-size: 16px !important;
            }
            
            /* Stack action buttons on mobile */
            form > div > div > div:last-child > div {
                flex-direction: column !important;
                gap: 12px !important;
            }
            
            form > div > div > div:last-child > div > button {
                width: 100% !important;
                min-width: auto !important;
            }
            
            /* Adjust partner cards spacing */
            div[style*="Partner 1"], div[style*="Partner 2"] {
                padding: 16px !important;
            }
            
            /* Make download links more mobile friendly */
            a[download] {
                word-break: break-all !important;
                font-size: 13px !important;
            }
        }
        
        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(79, 70, 229, 0.3);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(79, 70, 229, 0.5);
        }

        .ellipsis {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>

    <!-- Error Modal -->
    <div class="modal fade xerror_modal" data-bs-backdrop="static" id="xerror_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15); background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(20px);">
                <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 24px 32px;">
                    <h5 class="modal-title" style="font-weight: 700; color: #1f2937; font-size: 20px;">Couples Connect Says:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 24px 32px 32px 32px;">
                    <p class="error_msg" style="color: #6b7280; margin: 0; font-size: 14px; line-height: 1.5;">Modal body text goes here.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Decline Reason Modal -->
    <div class="modal fade modal_dec_cert_reason" id="modal_dec_cert_reason" style="display: none;" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15); background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(20px);">
                <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 24px 32px;">
                    <div class="modal-title">
                        <div style="color: #1f2937; font-family: Inter; font-size: 24px; font-weight: 700;">Certification</div>
                        <div style="color: #9b9b9b; font-family: Inter; font-size: 16px; margin-top: -2px;">Request</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 24px 32px 32px 32px;">
                    <label style="font-size: 16px; color: #1f2937; font-weight: 600; font-family: Inter; display: block; margin-bottom: 12px;">Reason for declination:</label>
                    <textarea id="dec_reason" class="form-control" cols="30" rows="6" placeholder="Enter reason" style="font-size: 14px; border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 12px; padding: 16px; resize: vertical; font-family: Inter;"></textarea>
                    <div style="display: flex; justify-content: center; padding-top: 24px;">
                        <button type="button" id="decReasonBtn" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: white; border: none; padding: 16px 48px; border-radius: 12px; font-size: 16px; font-family: Inter; font-weight: 700; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3); cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(79, 70, 229, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(79, 70, 229, 0.3)'">
                            SUBMIT
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="ac_recid_hidden" id="ac_recid_hidden" value="<?php echo $_POST['ac_recid_hidden']; ?>">
    
</form>

    <script>
    
    function review(recid){

        alert(recid)
        
        // document.forms.myforms.method = "post";
        // document.forms.myforms.target = "_self";
        // document.forms.myforms.action = "register_cc.php";
        // document.forms.myforms.submit();
    }

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          height:650,
          initialView: 'dayGridMonth',
          header: {
            left: '',
            center: '',
            right: ''
          }
        });

        calendar.addEvent({
            title: 'Second Event',
            start: '2024-03-08T12:30:00',
            end: '2024-03-08T13:30:00'
        });

        calendar.render();
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

        const decline = () => {
            $('#modal_dec_cert_reason').modal('show');
            $('#decReasonBtn').click(() => acc_choose('DEC'));
        }

        function acc_choose(xeventaction){

            var ac_recid_hidden = $("#ac_recid_hidden").val();

            jQuery.ajax({    
                data:{
                    event_action:xeventaction,
                    ac_recid_hidden:ac_recid_hidden,
                    remarks: $('#dec_reason').val()
                },
                dataType:"json",
                type:"post",
                url:"cc_account_confirm2_ajax.php", 
                success: function(xdata){

                    if(xdata['status'] == false){
                        // $('.error_msg').html(xdata['msg']);
                        // $(".xerror_modal").modal("show");
                    }else{
                        document.forms.myforms.method = "post";
                        document.forms.myforms.target = "_self";
                        document.forms.myforms.action = "cc_account_confirm.php";
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

