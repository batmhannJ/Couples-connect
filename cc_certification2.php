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

$select_db_partnerinfo="SELECT pro_cert_table.reason as 'reason', pro_cert_table.status as 'mf_cert_status', mf_prog_users.date_requested_desc as 'mf_date_requested_desc', mf_prog_users.username as 'mf_username', mf_prog_users.secondary_email as 'ext_secondary_email', mf_prog_users.email as 'mf_email', mf_prog_users.secondary_email as 'mf_secondary_email', ext_couples_accountinfo.cellphone_number as 'ext_cellphone',
ext_couples_accountinfo.first_name as 'ext_firstname', ext_couples_accountinfo.middle_name as 'ext_middlename', ext_couples_accountinfo.last_name as 'ext_last_name', ext_couples_accountinfo.sex as 'ext_sex',   ext_couples_accountinfo.occupation as 'ext_occupation',ext_couples_accountinfo.municipality as 'ext_municipality', 
mf_prog_users.date_requested as 'mf_date_requested', mf_prog_users.doc_link as 'mf_doc_link', mf_prog_users.crm_link as 'mf_crm_link',
mf_prog_users.doc_link as 'mf_doc_link', mf_prog_users.crm_link as 'mf_crm_link', mf_prog_users.justification as 'mf_justification'  FROM mf_prog_users LEFT JOIN ext_couples_accountinfo ON mf_prog_users.userid 
=ext_couples_accountinfo.userid LEFT JOIN pro_cert_table ON pro_cert_table.userid = mf_prog_users.userid WHERE mf_prog_users.userid=?";
$stmt_partnerinfo	= $link->prepare($select_db_partnerinfo);
$stmt_partnerinfo->execute(array($userid));

while($rs_partnerinfo = $stmt_partnerinfo->fetch())
{
    $email = $rs_partnerinfo['mf_email'];
    $secondary_email = $rs_partnerinfo['mf_secondary_email'];
    $doc_link = $rs_partnerinfo['mf_doc_link'];
    $crm_link = $rs_partnerinfo['mf_crm_link'];
    $justification = $rs_partnerinfo['mf_justification'];
    $date_requested = $rs_partnerinfo['mf_date_requested_desc'];
    $cert_status = $rs_partnerinfo['mf_cert_status'];
    $reason_cert = $rs_partnerinfo['reason'];
 
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

    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <div class="container-fluid">
        <div class='row bg-white' style="height:99px">
            <div class="col-3 pe-0 d-flex align-items-center">
                <img src="images/350 x 88.png" style='height:76px;width:auto;'>
            </div>

            <div class="col-3 offset-6" style="display:flex;flex-direction:row;justify-content:center;font-family:inter;font-size:21px;align-items:center"> 
                <div style="flex:0.5;text-align:right;margin-right:10px">
                    <a href="http://localhost/couples-connectprog/select_option.php" style='color:black;text-decoration:none' class='has_hover'>HOME</a>
                </div>

                <div style="flex:.1;text-align:center;padding-right:10px">
                    <a style='color:black;text-decoration:none'>|</a>
                </div>

                <div style="flex:.3;text-align:center;padding-right:15px">
                    <a style='color:black;text-decoration:none'><?php echo $header_name;?> </a>
                </div>

                <div style="flex:0.6;text-align:right;padding-right:35px">
                    <a href="http://localhost/couples-connectprog/logout_cc.php"  class='has_hover' style='color:black;text-decoration:none'>LOGOUT</a>
                </div>

            </div> 
        </div>
    </div>

    <form name='myforms' id="myforms" method="post" target="_self" style='height:100%'> 
    <table style="width:100%;height:100%;background-color:#f2f2f2">
            <tr>
                <td style='width:100%'>
                    <div class="row h-100 justify-content-center align-items-center">
                        <div style='width:1400px;height:700px;background-color:white;border-radius:30px;filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25));display:flex;flex-direction:column'>

                            <div class="m-3 pt-2">

                                <div class="row">
                                    <div class="col-2">
                                        <a href="http://localhost/couples-connectprog/cc_certification.php"><img src="images/Vector (1).png" style='height:30px;width:20px'></a>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center" style='padding-right:280px'>
                                        <p style="font-weight:bold;font-size:24px;font-family:inter;margin-bottom:0">Certificates</p>
                                    </div>

                                </div>
                         
                                    
                                <img src="images/Rectangle 11934.png" style='width:100%;height:4px'>
                                    
                            </div>

        
                            <div class="m-3 mt-0  px-4">

                                <div class="row">

                                    <div class="col-12 text-left" style='font-size:21px;font-weight:700;font-family:inter'>
                                     Certificate Status
                                    </div>
                                    <div class="col-12 text-left mt-3">
                                        <select name="select_cert_status" id="select_cert_status" style='width:328px;height:45px;border-radius:15px;font-size:20px' class="form-control date_picker">

                                            <?php
                                            $prp_selected = '';
                                            $pup_selected = '';
                                            $rcv_selected = '';


                                            if($cert_status == "PRP"){
                                                $prp_selected = 'selected';
                                            }else if($cert_status == "PUP"){
                                                $pup_selected = 'selected';
                                            }else if($cert_status == "RCV"){
                                                $rcv_selected = 'selected';
                                            }
                                            
                                            echo "<option ".$prp_selected." value='PRP'>Preparing</option>";
                                            echo "<option ".$pup_selected." value='PUP'>For Pickup</option>";
                                            echo "<option ".$rcv_selected." value='RCV'>Received</option>";

                                            ?>
                                        </select>
                                    </div>

                                
                                </div>


                                <div class="row mt-4">
                                    <div class="col-12 text-left" style='font-size:21px;font-weight:700;font-family:inter'>
                                    Information   
                                    </div>

                                    <div class="col-12 d-flex">
                                        <div class="text-left mt-3" style='font-size:18px;font-weight:500;font-family:inter'>
                                            Email Address: 
                                            <span style='margin-left:20px;font-weight:700'>
                                            <?php echo $email;?>                                      
                                            </span>
                                        </div> 
                                        <div class="text-left mt-3" style='font-size:18px;font-weight:500;font-family:inter;margin-left:50px;'>
                                            Secondary Email Address: 
                                            <span style='margin-left:20px;font-weight:700'>
                                            <?php echo $secondary_email;?>                                      
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="text-left mt-3" style='font-size:18px;font-weight:500;font-family:inter'>
                                            Date Requested: 
                                            <span style='margin-left:20px;font-weight:700'>
                                            <?php echo $date_requested;?>                                      
                                            </span>
                                        </div> 
                                    </div>

                                    <div class="col-12">
                                        <div class="text-left mt-3" style='font-size:18px;font-weight:500;font-family:inter'>
                                            Reason: 
                                            <span style='margin-left:20px;font-weight:700'>
                                            <?php
                                                echo $reason_cert;
                                            ?>
                                            </span>
                                        </div> 
                                    </div>


                                </div>

                                <div class="row pt-4">
                                    <div class="col-8 text-left" style='font-size:18px;font-family:inter'>

                                        <span style='font-size:21px;font-weight:700;font-family:inter'>
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

                                                                                
                                        </div>   
                                    </div>


                                    <div class="col-12 d-flex justify-content-center">
                                        <div class="container d-flex justify-content-center align-items-center">
                                            <div class="m-3 pt-3 form-group d-flex align-items-center justify-content-center">
                                                <button type="button" onclick="save_cert('save_status')" class="btn" style="background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:170px;height:42px;font-size:22px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Save</button>
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

        <input type="hidden" name="ac_recid_hidden" id="ac_recid_hidden" value="<?php echo $_POST['ac_recid_hidden']; ?>">
        <input type="hidden" name="cert_recid_hidden" id="cert_recid_hidden" value="<?php echo $_POST['cert_recid_hidden']; ?>">
        
    </form>

    <script>
    


        function save_cert(xeventaction){

            var ac_recid_hidden = $("#ac_recid_hidden").val();
            var cert_status = $("#select_cert_status").val();
            var cert_recid_hidden = $("#cert_recid_hidden").val();
            jQuery.ajax({    
                data:{
                    event_action:xeventaction,
                    ac_recid_hidden:ac_recid_hidden,
                    cert_recid_hidden:cert_recid_hidden,
                    cert_status:cert_status
                },
                dataType:"json",
                type:"post",
                url:"cc_certification2_ajax.php", 
                success: function(xdata){
                    
                    if(xdata['status'] == false){
                        // $('.error_msg').html(xdata['msg']);
                        // $(".xerror_modal").modal("show");
                    }else{


                        document.forms.myforms.method = "post";
                        document.forms.myforms.target = "_self";
                        document.forms.myforms.action = "cc_certification.php";
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

