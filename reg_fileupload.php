<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation - Document Upload</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .instruction-box {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-left: 4px solid #667eea;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .requirement-item {
            display: flex;
            align-items: start;
            padding: 12px;
            background: white;
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .requirement-item i {
            color: #667eea;
            font-size: 20px;
            margin-right: 12px;
            margin-top: 2px;
        }
        
        .file-upload-zone {
            border: 3px dashed #cbd5e1;
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            background: #f8fafc;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .file-upload-zone:hover {
            border-color: #667eea;
            background: #f1f5ff;
        }
        
        .file-upload-zone.active {
            border-color: #10b981;
            background: #ecfdf5;
        }
        
        .accepted-formats {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 15px;
        }
        
        .format-badge {
            background: #667eea;
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .warning-box {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            border-radius: 12px;
            padding: 16px;
            margin-top: 15px;
        }
        
        .success-box {
            background: #d1fae5;
            border-left: 4px solid #10b981;
            border-radius: 12px;
            padding: 16px;
            margin-top: 15px;
        }
        
        .example-docs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            margin-top: 15px;
        }
        
        .example-doc-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border: 2px solid #e2e8f0;
        }
        
        .example-doc-card i {
            font-size: 32px;
            color: #667eea;
            margin-bottom: 8px;
        }
        
        .example-doc-card .doc-name {
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
        }
        
        .pmoc-info-card {
            background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 20px;
            border: 2px solid #f59e0b;
        }
        
        .pmoc-criteria {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-top: 15px;
        }
        
        .criteria-item {
            display: flex;
            align-items: center;
            padding: 12px;
            margin-bottom: 10px;
            background: #fef3c7;
            border-radius: 8px;
        }
        
        .criteria-item i {
            color: #f59e0b;
            font-size: 24px;
            margin-right: 15px;
        }
        
        .file-name-display {
            background: #10b981;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            margin-top: 15px;
            display: none;
            align-items: center;
            justify-content: space-between;
        }
        
        .file-name-display.show {
            display: flex;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0" style="border-radius: 24px; overflow: hidden;">
                    <!-- Header -->
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px;">
                        <h2 class="mb-2" style="font-weight: 700; font-size: 32px;">
                            <i class="bi bi-shield-check"></i> Document Verification
                        </h2>
                        <p class="mb-0" style="font-size: 16px; opacity: 0.95;">
                            Please provide the required documents to complete your application
                        </p>
                    </div>
                    
                    <div class="card-body p-4 p-md-5">
                        
                        <!-- SECTION 1: Proof of Residency -->
                        <div class="mb-5">
                            <h3 class="mb-4" style="font-weight: 700; color: #1e293b; font-size: 24px;">
                                <i class="bi bi-geo-alt-fill text-primary"></i> 
                                Proof of Residency Requirement
                            </h3>
                            
                            <div class="instruction-box">
                                <div class="d-flex align-items-start mb-3">
                                    <i class="bi bi-info-circle-fill" style="font-size: 24px; color: #667eea; margin-right: 12px;"></i>
                                    <div>
                                        <h5 style="font-weight: 700; color: #1e293b; margin-bottom: 8px;">Why do we need this?</h5>
                                        <p style="color: #475569; margin: 0; line-height: 1.6;">
                                            At least ONE partner must be a resident of Cabuyao City. Please submit valid proof of residency from either partner.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <h5 style="font-weight: 700; color: #1e293b; margin-bottom: 15px;">
                                ✅ Acceptable Documents (choose ONE):
                            </h5>
                            
                            <div class="example-docs">
                                <div class="example-doc-card">
                                    <i class="bi bi-person-badge"></i>
                                    <div class="doc-name">Valid Government ID</div>
                                    <small style="color: #64748b;">with Cabuyao address</small>
                                </div>
                                
                                <div class="example-doc-card">
                                    <i class="bi bi-file-earmark-text"></i>
                                    <div class="doc-name">Birth Certificate</div>
                                    <small style="color: #64748b;">PSA certified</small>
                                </div>
                                
                                <div class="example-doc-card">
                                    <i class="bi bi-file-earmark-ruled"></i>
                                    <div class="doc-name">Barangay Certificate</div>
                                    <small style="color: #64748b;">of Residency</small>
                                </div>
                                
                                <div class="example-doc-card">
                                    <i class="bi bi-house-door"></i>
                                    <div class="doc-name">Utility Bill</div>
                                    <small style="color: #64748b;">recent (3 months)</small>
                                </div>
                                
                                <div class="example-doc-card">
                                    <i class="bi bi-envelope-paper"></i>
                                    <div class="doc-name">Letter of Recommendation</div>
                                    <small style="color: #64748b;">from Barangay</small>
                                </div>
                            </div>
                            
                            <div class="requirement-item mt-4">
                                <i class="bi bi-check-circle-fill"></i>
                                <div>
                                    <strong>Valid Government IDs include:</strong>
                                    <div style="color: #64748b; margin-top: 4px;">
                                        Driver's License, Passport, UMID, SSS ID, PhilHealth ID, Postal ID, Voter's ID, Senior Citizen ID, PWD ID
                                    </div>
                                </div>
                            </div>
                            
                            <div class="requirement-item">
                                <i class="bi bi-file-earmark-check-fill"></i>
                                <div>
                                    <strong>Document must be:</strong>
                                    <div style="color: #64748b; margin-top: 4px;">
                                        Clear, readable, not expired, and shows complete name matching your application
                                    </div>
                                </div>
                            </div>
                            
                            <div class="requirement-item">
                                <i class="bi bi-image-fill"></i>
                                <div>
                                    <strong>Image Requirements:</strong>
                                    <div style="color: #64748b; margin-top: 4px;">
                                        High quality photo/scan • Max 5MB • JPG, PNG, or PDF format
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Upload Zone -->
                            <div class="mt-4">
                                <label class="form-label" style="font-weight: 700; color: #1e293b; font-size: 16px;">
                                    Upload Your Document:
                                </label>
                                
                                <div class="file-upload-zone" id="uploadZone1" onclick="document.getElementById('file_1').click()">
                                    <i class="bi bi-cloud-upload" style="font-size: 48px; color: #667eea;"></i>
                                    <h5 style="margin-top: 15px; font-weight: 600; color: #1e293b;">Click to Upload or Drag & Drop</h5>
                                    <p style="color: #64748b; margin: 8px 0 0 0;">Choose your proof of residency document</p>
                                    
                                    <div class="accepted-formats">
                                        <span class="format-badge">JPG</span>
                                        <span class="format-badge">PNG</span>
                                        <span class="format-badge">PDF</span>
                                        <span class="format-badge">Max 5MB</span>
                                    </div>
                                </div>
                                
                                <input type="file" id="file_1" name="file_1" class="d-none" accept=".jpg,.jpeg,.png,.pdf">
                                
                                <div class="file-name-display" id="fileName1">
                                    <div>
                                        <i class="bi bi-file-earmark-check"></i>
                                        <span id="fileNameText1">No file selected</span>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light" onclick="removeFile(1)">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="warning-box">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-exclamation-triangle-fill" style="font-size: 20px; color: #f59e0b; margin-right: 10px;"></i>
                                    <div>
                                        <strong style="color: #92400e;">Important:</strong>
                                        <span style="color: #78350f;"> Make sure all information is clearly visible. Blurry or unclear documents will be rejected.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr style="border-top: 2px dashed #cbd5e1; margin: 40px 0;">
                        
                        <!-- SECTION 2: Online PMOC Application -->
                        <div class="mb-5">
                            <h3 class="mb-4" style="font-weight: 700; color: #1e293b; font-size: 24px;">
                                <i class="bi bi-laptop text-warning"></i> 
                                Online PMOC Application (Optional)
                            </h3>
                            
                            <div class="pmoc-info-card">
                                <div class="d-flex align-items-start mb-3">
                                    <i class="bi bi-info-circle-fill" style="font-size: 28px; color: #f59e0b; margin-right: 15px;"></i>
                                    <div>
                                        <h4 style="font-weight: 700; color: #78350f; margin-bottom: 10px;">
                                            What is Online PMOC?
                                        </h4>
                                        <p style="color: #92400e; margin: 0; line-height: 1.6;">
                                            Pre-Marriage Orientation and Counseling (PMOC) is normally conducted in-person. However, we offer online sessions for couples in special circumstances who cannot attend physically.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-check mb-4" style="padding: 20px; background: #f8fafc; border-radius: 12px;">
                                <input class="form-check-input" type="checkbox" id="chk_pmoc" style="width: 24px; height: 24px; margin-top: 0;">
                                <label class="form-check-label" for="chk_pmoc" style="margin-left: 15px; font-size: 18px; font-weight: 600; color: #1e293b; cursor: pointer;">
                                    Yes, I wish to apply for Online PMOC
                                </label>
                            </div>
                            
                            <!-- PMOC Details (Hidden initially) -->
                            <div id="pmocDetails" style="display: none;">
                                
                                <h5 style="font-weight: 700; color: #1e293b; margin-bottom: 15px;">
                                    📋 Eligibility Criteria (Must meet ONE of the following):
                                </h5>
                                
                                <div class="pmoc-criteria">
                                    <div class="criteria-item">
                                        <i class="bi bi-airplane"></i>
                                        <div>
                                            <strong>Partner Living Overseas</strong>
                                            <div style="color: #64748b; font-size: 14px; margin-top: 4px;">
                                                One partner is currently working or residing abroad (OFW, immigrant, etc.)
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="criteria-item">
                                        <i class="bi bi-heart-pulse"></i>
                                        <div>
                                            <strong>Pregnant Bride</strong>
                                            <div style="color: #64748b; font-size: 14px; margin-top: 4px;">
                                                Bride is pregnant and has medical restrictions for travel
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="criteria-item">
                                        <i class="bi bi-universal-access"></i>
                                        <div>
                                            <strong>Person with Disability (PWD)</strong>
                                            <div style="color: #64748b; font-size: 14px; margin-top: 4px;">
                                                Either partner has physical limitations preventing in-person attendance
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="criteria-item">
                                        <i class="bi bi-briefcase"></i>
                                        <div>
                                            <strong>Critical Work Commitment</strong>
                                            <div style="color: #64748b; font-size: 14px; margin-top: 4px;">
                                                Cannot take leave due to urgent work obligations (healthcare workers, etc.)
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Justification -->
                                <div class="mt-4">
                                    <label class="form-label" style="font-weight: 700; color: #1e293b; font-size: 16px;">
                                        <i class="bi bi-pencil-square"></i> Explain Your Situation:
                                    </label>
                                    <p style="color: #64748b; font-size: 14px; margin-bottom: 10px;">
                                        Please provide a detailed explanation of why you need online PMOC. Be specific about your circumstances.
                                    </p>
                                    <textarea 
                                        class="form-control" 
                                        id="justification" 
                                        name="justification" 
                                        rows="5"
                                        placeholder="Example: My fiancé is currently working as a nurse in Dubai, UAE and cannot return to the Philippines until December 2024 due to contract obligations. We are planning our wedding for January 2025..."
                                        style="border: 2px solid #cbd5e1; border-radius: 12px; padding: 15px; font-size: 14px;"
                                    ></textarea>
                                </div>
                                
                                <!-- Supporting Documents -->
                                <div class="mt-4">
                                    <label class="form-label" style="font-weight: 700; color: #1e293b; font-size: 16px;">
                                        <i class="bi bi-file-earmark-medical"></i> Upload Supporting Evidence:
                                    </label>
                                    
                                    <div class="instruction-box mb-3">
                                        <p style="margin: 0; color: #475569; font-size: 14px;">
                                            <strong>Required documents based on your situation:</strong>
                                        </p>
                                        <ul style="margin: 10px 0 0 0; color: #64748b;">
                                            <li><strong>Overseas:</strong> Passport, visa, employment contract, or OEC</li>
                                            <li><strong>Pregnant:</strong> Medical certificate or ultrasound result</li>
                                            <li><strong>PWD:</strong> PWD ID or medical certificate</li>
                                            <li><strong>Work:</strong> Employment certificate or company letter</li>
                                        </ul>
                                    </div>
                                    
                                    <div class="file-upload-zone" id="uploadZone2" onclick="document.getElementById('file_2').click()">
                                        <i class="bi bi-cloud-upload" style="font-size: 48px; color: #f59e0b;"></i>
                                        <h5 style="margin-top: 15px; font-weight: 600; color: #1e293b;">Click to Upload Supporting Document</h5>
                                        <p style="color: #64748b; margin: 8px 0 0 0;">Medical certificate, passport copy, PWD ID, etc.</p>
                                        
                                        <div class="accepted-formats">
                                            <span class="format-badge" style="background: #f59e0b;">JPG</span>
                                            <span class="format-badge" style="background: #f59e0b;">PNG</span>
                                            <span class="format-badge" style="background: #f59e0b;">PDF</span>
                                            <span class="format-badge" style="background: #f59e0b;">Max 5MB</span>
                                        </div>
                                    </div>
                                    
                                    <input type="file" id="file_2" name="file_2" class="d-none" accept=".jpg,.jpeg,.png,.pdf">
                                    
                                    <div class="file-name-display" id="fileName2">
                                        <div>
                                            <i class="bi bi-file-earmark-check"></i>
                                            <span id="fileNameText2">No file selected</span>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-light" onclick="removeFile(2)">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="success-box mt-3">
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-check-circle-fill" style="font-size: 20px; color: #10b981; margin-right: 10px;"></i>
                                        <div style="color: #065f46;">
                                            <strong>Note:</strong> Your online PMOC application will be reviewed within 3-5 business days. You will receive an email notification regarding approval status.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="text-center mt-5">
                            <button 
                                type="button" 
                                onclick="submit_user()" 
                                class="btn btn-lg px-5"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-weight: 700; font-size: 18px; border-radius: 12px; padding: 15px 60px; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);"
                            >
                                <i class="bi bi-check-circle me-2"></i>
                                Submit Application
                            </button>
                            
                            <p class="mt-3" style="color: #64748b; font-size: 14px;">
                                By submitting, you confirm that all information provided is accurate and complete.
                            </p>
                        </div>
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
        
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    
    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <div class="modal-body text-center p-5">
                    <div style="width: 80px; height: 80px; background: #d1fae5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="bi bi-check-lg" style="font-size: 48px; color: #10b981;"></i>
                    </div>
                    <h3 style="font-weight: 700; color: #1e293b; margin-bottom: 15px;">Application Submitted!</h3>
                    <p style="color: #64748b; line-height: 1.6;">
                        Thank you for providing the information. Your account details are currently under review for verification. 
                        <strong>Please anticipate an email update within the next 2-3 business days.</strong>
                    </p>
                    <button type="button" class="btn btn-primary mt-3" onclick="window.location.href='index.php'">
                        Return to Home
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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
const file1 = document.getElementById('file_1').files[0];
            if (!file1) {
                alert('Please upload your proof of residency document!');
                return;
            }
            
            // If PMOC is checked, validate requirements
            const pmocChecked = document.getElementById('chk_pmoc').checked;
            if (pmocChecked) {
                const justification = document.getElementById('justification').value.trim();
                const file2 = document.getElementById('file_2').files[0];
                
                if (!justification) {
                    alert('Please provide a justification for your online PMOC application!');
                    return;
                }
                
                if (justification.length < 50) {
                    alert('Please provide a more detailed justification (at least 50 characters)!');
                    return;
                }
                
                if (!file2) {
                    alert('Please upload supporting evidence for your online PMOC application!');
                    return;
                }
            }
            
            // Show success modal
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            
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
        // File upload handling
        document.getElementById('file_1').addEventListener('change', function(e) {
            handleFileSelect(e, 1);
        });
        
        document.getElementById('file_2').addEventListener('change', function(e) {
            handleFileSelect(e, 2);
        });
        
        function handleFileSelect(e, fileNum) {
            const file = e.target.files[0];
            if (file) {
                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB!');
                    e.target.value = '';
                    return;
                }
                
                // Validate file type
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                if (!validTypes.includes(file.type)) {
                    alert('Please upload JPG, PNG, or PDF files only!');
                    e.target.value = '';
                    return;
                }
                
                // Show file name
                document.getElementById('fileNameText' + fileNum).textContent = file.name;
                document.getElementById('fileName' + fileNum).classList.add('show');
                document.getElementById('uploadZone' + fileNum).classList.add('active');
            }
        }
        
        function removeFile(fileNum) {
            document.getElementById('file_' + fileNum).value = '';
            document.getElementById('fileName' + fileNum).classList.remove('show');
            document.getElementById('uploadZone' + fileNum).classList.remove('active');
        }
        
        // Show/hide PMOC section
        document.getElementById('chk_pmoc').addEventListener('change', function() {
            const pmocDetails = document.getElementById('pmocDetails');
            if (this.checked) {
                pmocDetails.style.display = 'block';
                pmocDetails.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } else {
                pmocDetails.style.display = 'none';
            }
        });
        
        // Form submission
        function submitForm() {
            // Validate file 1 is uploaded
            const file1 = document.getElementById('file_1').files[0];
            if (!file1) {
                alert('Please upload your proof of residency document!');
                return;
            }
            
            // If PMOC is checked, validate requirements
            const pmocChecked = document.getElementById('chk_pmoc').checked;
            if (pmocChecked) {
                const justification = document.getElementById('justification').value.trim();
                const file2 = document.getElementById('file_2').files[0];
                
                if (!justification) {
                    alert('Please provide a justification for your online PMOC application!');
                    return;
                }
                
                if (justification.length < 50) {
                    alert('Please provide a more detailed justification (at least 50 characters)!');
                    return;
                }
                
                if (!file2) {
                    alert('Please upload supporting evidence for your online PMOC application!');
                    return;
                }
            }
            
            // Show success modal
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            
            // Here you would normally submit the form via AJAX
            // For demonstration, we're just showing the modal
        }
        
        // Drag and drop functionality
        ['uploadZone1', 'uploadZone2'].forEach((zoneId, index) => {
            const zone = document.getElementById(zoneId);
            const fileNum = index + 1;
            
            zone.addEventListener('dragover', (e) => {
                e.preventDefault();
                zone.style.borderColor = '#667eea';
                zone.style.background = '#f1f5ff';
            });
            
            zone.addEventListener('dragleave', (e) => {
                e.preventDefault();
                if (!zone.classList.contains('active')) {
                    zone.style.borderColor = '#cbd5e1';
                    zone.style.background = '#f8fafc';
                }
            });
            
            zone.addEventListener('drop', (e) => {
                e.preventDefault();
                const fileInput = document.getElementById('file_' + fileNum);
                fileInput.files = e.dataTransfer.files;
                handleFileSelect({ target: fileInput }, fileNum);
            });
        });
    </script>
</body>
</html>