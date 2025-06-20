<?php
require "includes/cc_header.php";
require_once("resources/stdfunc100.php");

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

$select_db="SELECT * FROM mf_prog_users WHERE recid=?";
$stmt	= $link->prepare($select_db);
$stmt->execute(array($_SESSION['usr_recid']));
$row = $stmt->fetch();
$act_status = $row["act_status"];

$select_db_certcheck="SELECT * FROM pro_cert_table WHERE userid=? AND status!='RCV' ORDER BY date_claimed DESC LIMIT 1";
$stmt_certcheck	= $link->prepare($select_db_certcheck);
$stmt_certcheck->execute(array($_SESSION['usr_id']));
$row_certcheck = $stmt_certcheck->fetch();
if(isset($row_certcheck['control_number']) && !empty($row_certcheck['control_number'])){
    $requested_btn = true;
    $xcert_status = $row_certcheck['status'];
    $control_number = $row_certcheck['control_number'];
}else{
    $xcert_status = $row_certcheck['status'];
    $requested_btn = false;
}


$select_db_certcheck_count="SELECT * FROM pro_cert_table WHERE userid=?";
$stmt_certcheck_count	= $link->prepare($select_db_certcheck_count);
$stmt_certcheck_count->execute(array($_SESSION['usr_id']));
$row_certcheck_count = $stmt_certcheck_count->fetchAll();





$select_db_cert="SELECT * FROM pro_cert_table ORDER BY date_claimed DESC";
$stmt_cert	= $link->prepare($select_db_cert);
$stmt_cert->execute(array($row['userid']));
$row_cert = $stmt_cert->fetchAll();
if($requested_btn == false){
    if(count($row_cert) == 0){
        $control_number = '12261784';
    }else{

        $select_db_cert2="SELECT * FROM pro_cert_table ORDER BY control_number DESC LIMIT 1";
        $stmt_cert2	= $link->prepare($select_db_cert2);
        $stmt_cert2->execute(array($row['userid']));
        while($row_cert2 = $stmt_cert2->fetch()){
            $control_number = LNexts($row_cert2['control_number']);
        };
    }
}


$act_status2 = $act_status;



$partner1_name = '';
$partner2_name = '';

$select_db_users="SELECT ext_couples_accountinfo.first_name as 'first_name', ext_couples_accountinfo.middle_name as 'middle_name',
ext_couples_accountinfo.last_name as 'last_name'  FROM mf_prog_users RIGHT JOIN ext_couples_accountinfo ON mf_prog_users.userid = ext_couples_accountinfo.userid WHERE mf_prog_users.userid=? ORDER BY ext_couples_accountinfo.partnerno LIMIT 2";
$stmt_users	= $link->prepare($select_db_users);
$stmt_users->execute(array($_SESSION['usr_id']));

$xcounter_users = 0;
while($row_users = $stmt_users->fetch()){
    if($xcounter_users == 0){
        $partner1_name = $row_users['first_name'].' '.$row_users['middle_name'].' '.$row_users['last_name'];
    }else{
        $partner2_name = $row_users['first_name'].' '.$row_users['middle_name'].' '.$row_users['last_name'];
    }
    $xcounter_users++;
};


?>

<style>
    .has_hover:hover{
        cursor:pointer;
        opacity:0.5;
    }
</style>

<div class="container-fluid">
        <div class='row bg-white' style="height:99px">
            <div class="col-3 pe-0 d-flex align-items-center">
                <img src="images/350 x 88.png" style='height:76px;width:auto;'>
            </div>

            <div class="col-3 offset-6" style="display:flex;flex-direction:row;justify-content:center;font-family:inter;font-size:21px;align-items:center"> 
                <div style="flex:1.6;text-align:right;margin-right:25px">
                    <a href="http://localhost/couplesconnectprog/dashboard_user.php" style='color:black;text-decoration:none' class='has_hover'>SERVICES</a>
                </div>

                <div style="flex:1.8;text-align:center;margin-right:10px">
                    <a style='color:black;text-decoration:none' class='has_hover' onclick="openFeedback()">FEEDBACK</a>
                </div>

                <div style="flex:0.3;text-align:center;padding-right:10px">
                    <a href="" style='color:black;text-decoration:none'>|</a>
                </div>

                <div style="flex:1;text-align:center;margin-right:20px">
                    <a style='color:black;text-decoration:none'><?php echo $header_name;?> </a>
                </div>

                <div style="flex:0.6;text-align:right;padding-right:145px">
                    <a href="http://localhost/couplesconnectprog/logout_cc.php" style='color:black;text-decoration:none' class='has_hover'>LOGOUT</a>
                </div>
            </div> 
        </div>
    </div>
    
    <form name='myforms' id="myforms" method="post" target="_self" style='height:100%'> 

        <div class="container-fluid">
            <div class="row">
                <div class="col-5 d-flex align-items-center" style='flex-direction:column'>
                    <div style='width:90%;height:150px;background-color:white;border-radius:15px' class="mt-4">
                        <div class="pt-3" style='font-size:27px;font-family:inter;font-weight:700;text-align:center'>Status</div>
                        <div style='width:100%;display:flex;justify-content:center'>
                            <img src="images/Rectangle 11934.png" style='width:80%;height:4px'>
                        </div>
                        <div>
                            <?php   
                            if($act_status == "APR"){
                                echo "<div class='text-center' style='font-family:inter;font-size:28px;font-weight:700;margin-top:20px'>";
                                    echo "<img src='images/Group.png'>";
                                    echo "<span style='margin-left:10px'>Requires Pre-Marriage Orientation</span>";
                                echo "</div>";
                            }else if($act_status == "PMO"){
                                echo "<div class='text-center' style='font-family:inter;font-size:28px;font-weight:700;margin-top:20px'>";
                                    echo "<img src='images/Group.png'>";
                                    echo "<span style='margin-left:10px'>Waiting for Approval</span>";
                                echo "</div>";
                            }else if($act_status == "PMC"){
                                echo "<div class='text-center' style='font-family:inter;font-size:28px;font-weight:700;margin-top:20px'>";
                                    echo "<img src='images/Group.png'>";
                                    echo "<span style='margin-left:10px'>Waiting for Counselor's approval</span>";
                                echo "</div>";
                            }else if($act_status == "PCT"){
                                echo "<div class='text-center' style='font-family:inter;font-size:28px;font-weight:700;margin-top:20px'>";
                                    echo "<img src='images/Group.png'>";
                                    echo "<span style='margin-left:10px'>Request For a Certificate</span>";
                                echo "</div>";
                            }

                            ?>

                        </div>
                    </div>

                    <div style='width:90%;height:150px;background-color:white;border-radius:15px' class="mt-4">
                        <div class="pt-3" style='font-size:27px;font-family:inter;font-weight:700;text-align:center'>Certificate Status</div>
                        <div style='width:100%;display:flex;justify-content:center'>
                            <img src="images/Rectangle 11934.png" style='width:80%;height:4px'>
                        </div>
                        <div>
                            <?php   

                            if(count($row_certcheck_count) == 0){
                                echo "<div class='text-center' style='font-family:inter;font-size:28px;font-weight:700;margin-top:20px'>";
                                    echo "N/A";
                                echo "</div>";
                            }else{

                                
                                    if($xcert_status == "PRP"){
                                        echo "<div class='text-center' style='font-family:inter;font-size:28px;font-weight:700;margin-top:20px'>";
                                            echo "<span style='margin-left:10px'>Our staff is preparing your document</span>";
                                        echo "</div>";
                                    }else if($xcert_status == "PUP"){

                                        echo "<div class='text-center' style='font-family:inter;font-size:28px;font-weight:700;margin-top:20px'>";
                                            echo "<span style='margin-left:10px'>Your certificate is ready for pickup</span>";
                                        echo "</div>";
                                        
                                    }else if($xcert_status == "RCV"){

                                        echo "<div class='text-center' style='font-family:inter;font-size:28px;font-weight:700;margin-top:20px'>";
                                            echo "<span style='margin-left:10px'>Your certificate has been received</span>";
                                        echo "</div>";
                                        
                                    }else{
                                        echo "<div class='text-center' style='font-family:inter;font-size:22px;font-weight:700;margin-top:20px'>";
                                            echo "<span style='margin-left:10px'>Certification Complete,</br> you may request another one</span>";
                                        echo "</div>";
                                        
                                    }
                                    
                        
                            }
                      
                            ?>

                        </div>
                    </div>
                    
                    <div style='width:90%;height:150px;background-color:white;border-radius:15px' class="mt-4">
                        <div class="pt-3" style='font-size:27px;font-family:inter;font-weight:700;text-align:center'>Request Control Number</div>
                        <div style='width:100%;display:flex;justify-content:center'>
                            <img src="images/Rectangle 11934.png" style='width:80%;height:4px'>
                        </div>
                        <div>
                            <?php   
                    
                                echo "<div class='text-center' style='font-family:inter;font-size:28px;font-weight:700;margin-top:20px'>";
                                    echo "<span style='margin-left:10px'>".$control_number."</span>";
                                echo "</div>";
                            ?>

                        </div>
                    </div>                    
                </div>

                <div class="col-7 d-flex align-items-center justify-content-center" style='height:calc(100vh - 199px)'>
                    <div class='w-100' style='background-color:white;border-radius:15px;height:95%'>
                        <div class="m-3 pt-2 text-center">
                                <p style="font-weight:bold;font-size:27px;font-family:inter;margin-bottom:0">Certification</p>
                                <img src="images/Rectangle 11934.png" style='width:100%;height:4px'>
                        </div>
                        
                        <div style='font-size:27px;font-family:inter;font-weight:700;margin-left:40px'>
                            This will only provide an downloadable version of the PMOC Certification.
                        </div>

                        <div class="d-flex mt-4 justify-content-start request_now_div" id="request_now_div" style="margin-left:40px">

                            <?php

                                if($requested_btn == false){
                                    echo "<button type='button' data-bs-toggle='modal' data-bs-target='#modal_cert_reason' class='btn' style='background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:253px;height:41px;font-size:22px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>";
                                        echo "Request Now";
                                    echo "</button>";
                                }else if($requested_btn == true){
                                    echo"<button type='button' data-bs-toggle='modal' data-bs-target='#modal_cert_reason' disabled class='btn' style='background-color:#3F3F3F;color:white;width:253px;height:41px;font-size:22px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>";
                                        echo"Requested";
                                    echo"</button>";
                                }
                            ?>
                        </div>

                        <div style='margin-top:150px;margin-left:40px'>

                            <div style='font-family:inter;font-size:32px;font-weight:700;display:flex;flex-direction:column;'>
                                History
                                <img src="images/blue_line.png" style='width:300px;height:5px' alt="">
                            </div>

                            <div style="max-height:140px;overflow:auto">
                                <table style='margin-top:30px'>
                                    <thead>
                                        <tr>
                                            <td style='font-size:25px;color:#797979;font-family:inter;width:400px'>
                                                Date Claimed
                                            </td>

                                            <td style='font-size:25px;color:#797979;font-family:inter;width:400px'>
                                                Control Number
                                            </td>
                                        </tr>

                                        <?php

                                            $select_db_history="SELECT * FROM pro_cert_table WHERE userid=? AND status = 'RCV' ";
                                            $stmt_history	= $link->prepare($select_db_history);
                                            $stmt_history->execute(array($_SESSION['usr_id']));
                                            while($row_history = $stmt_history->fetch()){
                                                echo "<tr>";

                                                    echo "<td style='padding-top:15px;font-size:23px;font-weight:600;font-family:inter;color:#373737'>";
                                                        echo $row_history['date_claimed_desc'];
                                                    echo "</td>";

                                                    echo "<td style='padding-top:15px;font-size:23px;font-weight:600;font-family:inter;color:#373737'>";
                                                        echo $row_history['control_number'];
                                                    echo "</td>";

                                                echo "<tr/>";
                                            }
                                        ?>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
 





        <input type="hidden" name="act_status_hidden" id="act_status_hidden" value="<?php echo $act_status;?>">


        <div class="modal fade  proceed_modal" data-bs-backdrop="static" id="proceed_modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style='border-radius:15px'>
                    <div class="modal-header">
                        <h5 class="modal-title error_msg_title" style="font-size:38px;font-family:inter;font-weight:bold">Notice</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="error_msg" style='font-family:inter;font-size:24px;font-weight:300'>Before applying for Pre-marriage Orientation, it's necessary for both partners to complete the Marriage Expectation Form. Partner 1 will start by answering the form, followed by Partner 2 once Partner 1 has finished.</p>
                    </div>

                    <div class="container-fluid d-flex justify-content-center pb-4">
                        <button type='button' onclick='proceed_func()' class='btn' style='background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>Proceed</button>
                    </div>
     
                </div>
            </div>
        </div>        

        <div class="modal fade meiform_modal" id="meiform_modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog modal-xl  modal-dialog-scrollable">
                <div class="modal-content modal">
                <div class="modal-header">
                    <div class="container">
                        <h5 class="modal-title text-start" id="exampleModalToggleLabel2" style="font-size:33px;font-family:inter;font-weight:500">Marriage Expectation Form</h5>
                        <h7 class="modal-title text-left" id="exampleModalToggleLabel2" style="color:#9B9B9B">Fill Up Form</h7>
                    </div>
                    
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="container-fluid">

                        <div class="container" style='font-family:inter;font-size:20px;'>

                            <span style='font-size:32px;font-weight:400px;'>Partner 1</span>
                            <?php
                               echo $partner1_name;
                            ?>

                        </div>
                        

                        <div class="container">
                            <div style='width:400px'>
                                Please answer based on who is assigned as Partner 1 or 2 from the initial registration to avoid any confusion.*
                            </div>
                            
                        </div>

                    </div>
                    
                    <table>
                        <tr>
                            <td style='font-size:25px;font-family:inter;font-weight:500;color:#797979;width:70%;padding-left:20px;padding-top:10px'>
                                Statement
                            </td>

                            <td style='font-size:25px;font-family:inter;font-weight:500;color:#797979' class='px-3'>
                                Answer
                            </td>

                            <td style='font-size:25px;font-family:inter;font-weight:500;color:#797979'>
                                Reason/s
                            </td>
                        </tr>

                        <?php


                            $select_db_meiform = "SELECT * FROM mf_meiform";
                            $stmt_meiform	= $link->prepare($select_db_meiform);
                            $stmt_meiform->execute();
                            $mei_form1_counter = 1;
                            while($row_meiform = $stmt_meiform->fetch()){
                                echo "<tr>";

                                    echo "<td style='width:70%;font-weight:500;font-family:inter;font-size:16px;padding-left:20px;padding-top:10px'>";
                                        echo "<div style='width:90%'>".$mei_form1_counter.". ".$row_meiform["questions"]."</div>";
                                    echo "</td>";

                                    echo "<td class='px-3'>";
                                        echo "<select class='form-control' name='form_1[".$mei_form1_counter."][option]' id='form_1[".$mei_form1_counter."][option]'>";
                                            echo "<option>Agree</option>";
                                            echo "<option>Disagree</option>";
                                        echo "</select>";
                                    echo "</td>";

                                    echo "<td>";
                                        echo "<input type='text' class='form-control' name='form_1[".$mei_form1_counter."][input]' id='form_1[".$mei_form1_counter."][input]'>";
                                    echo "</td>";                                    

                                echo "</tr>";

                                $mei_form1_counter++;
                                
                            }

                        ?>
                    </table>

                    <div class="container-fluid" style='margin-top:50px'>

                        <div class="container" style='font-family:inter;font-size:20px;'>

                            <span style='font-size:32px;font-weight:400px;'>Partner 2</span>
                            <?php
                               echo $partner2_name;
                            ?>
                        </div>
                        

                        <div class="container">
                            <div style='width:400px'>
                                Please answer based on who is assigned as Partner 1 or 2 from the initial registration to avoid any confusion.*
                            </div>
                            
                        </div>

                    </div>
                    
                    <table>
                        <tr>
                            <td style='font-size:25px;font-family:inter;font-weight:500;color:#797979;width:70%;padding-left:20px;padding-top:10px'>
                                Statement
                            </td>

                            <td style='font-size:25px;font-family:inter;font-weight:500;color:#797979' class='px-3'>
                                Answer
                            </td>

                            <td style='font-size:25px;font-family:inter;font-weight:500;color:#797979'>
                                Reason/s
                            </td>
                        </tr>

                        <?php


                            $select_db_meiform2 = "SELECT * FROM mf_meiform";
                            $stmt_meiform2	= $link->prepare($select_db_meiform2);
                            $stmt_meiform2->execute();
                            $mei_form2_counter = 1;
                            while($row_meiform2 = $stmt_meiform2->fetch()){
                                echo "<tr>";

                                    echo "<td style='width:70%;font-weight:500;font-family:inter;font-size:16px;padding-left:20px;padding-top:10px'>";
                                        echo "<div style='width:90%'>".$mei_form2_counter.". ".$row_meiform2["questions"]."</div>";
                                    echo "</td>";

                                    echo "<td class='px-3'>";
                                        echo "<select class='form-control' name='form_2[".$mei_form2_counter."][option]' id='form_2[".$mei_form2_counter."][option]' >";
                                            echo "<option>Agree</option>";
                                            echo "<option>Disagree</option>";
                                        echo "</select>";
                                    echo "</td>";

                                    echo "<td>";
                                        echo "<input type='text' class='form-control'  name='form_2[".$mei_form2_counter."][input]' id='form_2[".$mei_form2_counter."][input]'>";
                                    echo "</td>";                                    

                                echo "</tr>";

                                $mei_form2_counter++;
                                
                            }

                        ?>
                    </table>                    
                </div>
       
                </div>
            </div>
        </div>

        <div class="modal fade modal_cert_reason" id="modal_cert_reason" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style='border-radius:25px'>
                <div class="modal-header">
                    <div class="modal-title">
                        <div style="color:black;font-family:inter;color:#252733;font-size:33px;font-weight:600">Certification</div>
                        <div style="color:black;font-family:inter;color:#9B9B9B;font-size:21px;margin-top:-5px">Fill Up Form</div>
                    </div>
          
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mx-3">
                    <label for="" style='font-size:21px;color:252733;font-weight:600;font-family:inter'>Reason for request:</label>
                    <textarea class="form-control" name="textarea_reason" id="textarea_reason" cols="30" rows="10" style='border-radius:5px;border: 1px solid black' placeholder='Enter Your Request'></textarea>
                    <div style='display:flex;justify-content:center;padding-top:25px;padding-bottom:20px'>
                        <button type="button" onclick="ajaxNew()" class="btn" style=";background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:250px;height:45px;font-size:25px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Submit</button>
                    </div>
                    
                </div>
          
                </div>
            </div>
        </div>
        
        <div class="modal fade  xerror_modal" data-bs-backdrop="static" id="xerror_modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style='border-radius:15px'>
                    <div class="modal-header">
                        <h5 class="modal-title error_msg_title" style="font-size:38px;font-family:inter;font-weight:bold">Confirmation!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="error_msg" style='font-family:inter;font-size:24px;font-weight:300'>Thank you for providing the information. Your account details are currently under review for verification. Please anticipate an email update within the next 2-3 days.</p>
                    </div>
     
                </div>
            </div>
        </div>

        <div class="modal fade modal_feedback" id="modal_feedback" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style='border-radius:25px'>
                <div class="modal-header">
                    <div class="modal-title">
                        <div style="color:black;font-family:inter;color:#252733;font-size:33px;font-weight:600">Feeback</div>
                        <div style="color:black;font-family:inter;color:#9B9B9B;font-size:21px;margin-top:-5px">Fill Up Form</div>
                    </div>
          
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mx-3">

                    <label for="" style='font-size:21px;color:252733;font-weight:600;font-family:inter'>Subject:</label>
                    <input type="text" class='form-control' style='border-radius:5px;height:50px;border:1px solid black' placeholder='Enter your subject' name="feedback_subject" id="feedback_subject">


                    <label for="" style='font-size:21px;color:252733;font-weight:600;font-family:inter;margin-top:20px'>Feedback:</label>
                    <textarea class="form-control" name="feedback_remarks" id="feedback_remarks" cols="30" rows="7" style='border-radius:5px;border:1px solid black' placeholder='Enter remarks'></textarea>
                    <div style='display:flex;justify-content:center;padding-top:25px;padding-bottom:20px'>
                        <button type="button" onclick="ajaxSubmit()" class="btn" style=";background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:250px;height:45px;font-size:25px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Submit</button>
                    </div>
                    
                </div>
          
                </div>
            </div>
        </div>                

        <input type="hidden" name="control_number_hidden" id="control_number_hidden" value="<?php echo $control_number;?>">

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
        
    </form>

    <script>

        function openFeedback(){
            $("#modal_feedback").modal("show");
        }

        function ajaxSubmit(){

            var email_subject = $("#feedback_subject").val();
            var email_remarks = $("#feedback_remarks").val();


            jQuery.ajax({    
                data:{
                    email_subject:email_subject,
                    email_remarks:email_remarks
                },
                dataType:"json",
                type:"post",
                url:"dashboard_user_ajax.php", 
                success: function(xdata){
                    $("#modal_feedback").modal("hide");
                },
                error: function (request, status, error) {
                }

            })

        }        

    function ajaxNew(xevent_action){

        var control_number = $("#control_number_hidden").val();
        var textarea_reason = $("#textarea_reason").val();

        $.ajax({                                      
            url: 'cc_usr_certification_ajax.php',              
            type: "post",          
            data: {
                reason_req:textarea_reason,
                control_number:control_number
            },               
            success: function(xdata){
                $("#request_now_div").html(`
                <button type="button" data-bs-toggle="modal" data-bs-target="#modal_cert_reason" disabled class="btn" style="background-color:#3F3F3F;color:white;width:253px;height:41px;font-size:22px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">
                    Requested
                </button>
                `);

                $(".modal_cert_reason").modal("hide");
                $(".xerror_modal").modal("show");


            },
            error: function (request, status, error) {
            }
        });
    }

    function book_func(){
        $("#proceed_modal").modal("show");
    }

    function proceed_func(){
        $("#proceed_modal").modal("hide");
        $("#meiform_modal").modal("show");
    }




    </script>



<?php 
require "includes/cc_footer.php";
?>

