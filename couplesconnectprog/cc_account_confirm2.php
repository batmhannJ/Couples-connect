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

$select_db_partnerinfo="SELECT mf_prog_users.username as 'mf_username', mf_prog_users.secondary_email as 'ext_secondary_email', mf_prog_users.email as 'mf_email', mf_prog_users.secondary_email as 'mf_secondary_email', ext_couples_accountinfo.cellphone_number as 'ext_cellphone',
ext_couples_accountinfo.first_name as 'ext_firstname', ext_couples_accountinfo.middle_name as 'ext_middlename', ext_couples_accountinfo.last_name as 'ext_last_name', ext_couples_accountinfo.sex as 'ext_sex',   ext_couples_accountinfo.occupation as 'ext_occupation',ext_couples_accountinfo.municipality as 'ext_municipality', 
mf_prog_users.date_requested as 'mf_date_requested', mf_prog_users.doc_link as 'mf_doc_link', mf_prog_users.crm_link as 'mf_crm_link',
mf_prog_users.doc_link as 'mf_doc_link', mf_prog_users.crm_link as 'mf_crm_link', mf_prog_users.justification as 'mf_justification'  FROM mf_prog_users LEFT JOIN ext_couples_accountinfo ON mf_prog_users.userid 
=ext_couples_accountinfo.userid WHERE mf_prog_users.usertype='USR' AND mf_prog_users.act_status ='RVW' AND mf_prog_users.userid=?";
$stmt_partnerinfo	= $link->prepare($select_db_partnerinfo);
$stmt_partnerinfo->execute(array($userid));
while($rs_partnerinfo = $stmt_partnerinfo->fetch())
{
    $email = $rs_partnerinfo['mf_email'];
    $secondary_email = $rs_partnerinfo['mf_secondary_email'];

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






    $justification = $rs_partnerinfo['mf_justification'];
 
    if($xcount == 0){
        $username = $rs_partnerinfo['mf_username'];
        $second_email= $rs_partnerinfo['ext_secondary_email'];
        $full_name = $rs_partnerinfo['ext_firstname'].' '.$rs_partnerinfo['ext_middlename'].' '.$rs_partnerinfo['ext_last_name'];
        $birthdate = date('F d, Y', strtotime($rs_partnerinfo['mf_date_requested']));
        $contact = $rs_partnerinfo['ext_cellphone'];
        $occupation = $rs_partnerinfo['ext_occupation'];
        $address = $rs_partnerinfo['ext_municipality'];
        $gender = $rs_partnerinfo['ext_sex'];
    }else{
        $username2 = $rs_partnerinfo['mf_username'];
        $second_email2 = $rs_partnerinfo['ext_secondary_email'];
        $full_name2 = $rs_partnerinfo['ext_firstname'].' '.$rs_partnerinfo['ext_middlename'].' '.$rs_partnerinfo['ext_last_name'];
        $birthdate2 = date('F d, Y', strtotime($rs_partnerinfo['mf_date_requested']));
        $contact2 = $rs_partnerinfo['ext_cellphone'];
        $occupation2 = $rs_partnerinfo['ext_occupation'];
        $address2 = $rs_partnerinfo['ext_municipality'];
        $gender2 = $rs_partnerinfo['ext_sex'];
    }


    // ($xcount==0) ? ;
    // ($xcount==0) ? $full_name : $full_name2 = $rs_partnerinfo['first_name'].' '.$rs_partnerinfo['middle_name'].' '.$rs_partnerinfo['last_name'];
    
    $xcount = 1;  

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
                    <a href="http://localhost/couplesconnectprog/select_option.php" style='color:black;text-decoration:none' class='has_hover'>HOME</a>
                </div>

                <div style="flex:.1;text-align:center;padding-right:10px">
                    <a style='color:black;text-decoration:none'>|</a>
                </div>

                <div style="flex:.3;text-align:center;padding-right:15px">
                    <a style='color:black;text-decoration:none'><?php echo $header_name;?> </a>
                </div>

                <div style="flex:0.6;text-align:right;padding-right:35px">
                    <a href="http://localhost/couplesconnectprog/logout_cc.php"  class='has_hover' style='color:black;text-decoration:none'>LOGOUT</a>
                </div>

            </div> 
        </div>
    </div>

    <form name='myforms' id="myforms" method="post" target="_self" style='height:100%'> 
    <table style="width:100%;height:100%;background-color:#f2f2f2">
            <tr>
                <td style='width:100%'>
                    <div class="row h-100 justify-content-center align-items-center">
                        <div style='width:1400px;height:700px;background-color:white;border-radius:30px;filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.21));display:flex;flex-direction:column'>

                            <div class="m-3 pt-2">

                                <div class="row">
                                    <div class="col-2">
                                        <a href="http://localhost/couplesconnectprog/cc_account_confirm.php"><img src="images/Vector (1).png" style='height:30px;width:20px'></a>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center" style='padding-right:240px'>
                                        <p style="font-weight:bold;font-size:24px;font-family:inter;margin-bottom:0">Account Confirmation</p>
                                    </div>

                                </div>
                         
                                    
                                <img src="images/Rectangle 11934.png" style='width:100%;height:4px'>
                                    
                            </div>

        
                            <div class="m-3 px-4">
                                <div class="row">
                                    <div class="col-12 text-left" style='font-size:19px;font-weight:700;font-family:inter'>
                                     Account Information   
                                    </div>

                                    <div class="col-12 text-left mt-3" style='font-size:19px;font-weight:500;font-family:inter'>
                                        Email Address: 
                                        <span style='margin-left:20px;font-weight:700'>
                                        <?php echo $email;?>                                      
                                        </span>
                                    </div>

                                    
                                    <div class="col-12 text-left mt-2" style='font-size:19px;font-weight:500;font-family:inter'>
                                        Secondary Email Address: 
                                        <span style='margin-left:20px;font-weight:700'>
                                        <?php echo $secondary_email;?>                                      
                                        </span>
                                    </div>
                                </div>

                                <div class="row pt-4">
                                    <div class="col-8 text-left" style='font-size:19px;font-family:inter'>

                                        <span style='font-weight:700'>
                                            Personal Information:       
                                        </span>
                                
                                        <div class="row pt-3">
                                            <div class="col-6">
                                                Partner 1
                                            </div>
                                            <div class="col-6">
                                                Partner 2
                                            </div>

                                            <div class="col-6 pt-3">
                                                Name: 
                                                <span style='margin-left:20px;font-weight:700'>
                                                    <?php echo $full_name;?>                                      
                                                </span>
                                            </div>

                                            <div class="col-6 pt-3">
                                                Name: 
                                                <span style='margin-left:20px;font-weight:700'>
                                                    <?php echo $full_name2;?>                                      
                                                </span>
                                            </div>


                                            <div class="col-6 pt-3">
                                                Brithdate: 
                                                <span style='margin-left:20px;font-weight:700'>
                                                    <?php echo $birthdate;?>                                      
                                                </span>
                                            </div>

                                            <div class="col-6 pt-3">
                                                Birthdate: 
                                                <span style='margin-left:20px;font-weight:700'>
                                                    <?php echo $birthdate2;?>                                      
                                                </span>
                                            </div>

                                            <div class="col-6 pt-3">
                                                Gender: 
                                                <span style='margin-left:20px;font-weight:700'>
                                                    <?php echo $gender;?>                                      
                                                </span>
                                            </div>

                                            <div class="col-6 pt-3">
                                                Gender: 
                                                <span style='margin-left:20px;font-weight:700'>
                                                    <?php echo $gender2;?>                                      
                                                </span>
                                            </div>

                                            <div class="col-6 pt-3">
                                                Contact: 
                                                <span style='margin-left:20px;font-weight:700'>
                                                    <?php echo $contact;?>                                      
                                                </span>
                                            </div>

                                            <div class="col-6 pt-3">
                                                Contact: 
                                                <span style='margin-left:20px;font-weight:700'>
                                                    <?php echo $contact2;?>                                      
                                                </span>
                                            </div>

                                            <div class="col-6 pt-3">
                                                Occupation: 
                                                <span style='margin-left:20px;font-weight:700'>
                                                    <?php echo $occupation;?>                                      
                                                </span>
                                            </div>

                                            <div class="col-6 pt-3">
                                                Occupation: 
                                                <span style='margin-left:20px;font-weight:700'>
                                                    <?php echo $occupation2;?>                                      
                                                </span>
                                            </div>

                                            <div class="col-6 pt-3">
                                                Address: 
                                                <span style='margin-left:20px;font-weight:700'>
                                                    <?php echo $address;?>                                      
                                                </span>
                                            </div>

                                            <div class="col-6 pt-3">
                                            Address: 
                                                <span style='margin-left:20px;font-weight:700'>
                                                    <?php echo $address2;?>                                      
                                                </span>
                                            </div>                                            
                                        </div>   
                                    </div>

                                    <div class="col-4 text-left" style='font-size:19px;font-weight:700;font-family:inter'>
                                     Personal Documents:   
                                        <div class="row">
                                                <div class="col-12 mt-3">
                                                    <div style='font-weight:500'>
                                                    Proof of residency       
                                                    </div>
                                                    <div class='ellipsis'>
                                                        <a href="<?php echo $doc_link; ?>" style='color:blue!important;text-decoration:underline!important' download="<?php echo $doc_link_filename;?>"> <?php echo $doc_link_filename; ?> <i class="fas fa-download"></i></a>
                                                    </div>
                                                
                                                </div>

                                                <div class="col-12 mt-3">
                                                    <div style='font-weight:700;font-size:19px'>
                                                    Application for PMOC       
                                                    </div>
                                                    <div>
                                                        <label class='mt-2' style='font-weight:500'>Justification</label>

                                                        <textarea rows='3' readonly class='form-control' style='font-weight:500;font-size:20px;'><?php echo $justification; ?></textarea>
                                                    </div>

                                                    <div style='display:flex;flex-direction:column' class='pt-3 ellipsis'>
                                                        <label style='font-weight:500'>Evidence</label>
                                                        
                                                        <div>
                                                            <?php

                                                            if(empty($crm_link)){
                                                                echo "User Did not apply for PMOC";
                                                            }else{
                                                                // echo $crm_link."<i class='fas fa-download'></i>";
                                                                echo "<a href='".$crm_link."' style='color:blue!important;text-decoration:underline!important' download='".$crm_link_filename."'> ".$crm_link_filename."<i class='fas fa-download'></i></a>";
                                                            }
                                                            ?>
                                     
                                                        </div>
                                                    </div>
                                                
                                                </div>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-center">
                                        <div class="container d-flex justify-content-center align-items-center">
                                            <div class="m-3 pt-1 form-group d-flex align-items-center justify-content-center">
                                                <button type="button" onclick="decline()" class="btn" style="background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Decline</button>
                                            </div>

                                            <div class="m-3 pt-1 form-group d-flex align-items-center justify-content-center">
                                                <button type="button" onclick="acc_choose('APR')" class="btn" style="background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Approve</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

        <!-- <footer style='height:100px;background-color:#23408E' class='footer'>
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
        </footer> -->

        <div class="modal fade modal_dec_cert_reason" id="modal_dec_cert_reason" style="display: none;" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style='border-radius:25px'>
                <div class="modal-header">
                    <div class="modal-title">
                        <div style="color:black;font-family:inter;color:#252733;font-size:33px;font-weight:600">Certification</div>
                        <div style="color:black;font-family:inter;color:#9B9B9B;font-size:21px;margin-top:-5px">Request</div>
                    </div>
          
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mx-3">
                    <label for="" style='font-size:21px;color:252733;font-weight:600;font-family:inter'>Reason for declination:</label>
                    <textarea id="dec_reason" class="form-control" cols="30" rows="10" placeholder="Enter reason" style='font-size: 18px;'></textarea>
                    <div style='display:flex;justify-content:center;padding-top:25px;padding-bottom:20px'>
                        <button type="button" id="decReasonBtn" class="btn" style=";background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:250px;height:45px;font-size:25px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">SUBMIT</button>
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

