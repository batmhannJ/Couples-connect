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


$partner1_name = '';
$partner2_name = '';

$select_db_users="SELECT  ext_couples_accountinfo.first_name as 'first_name', ext_couples_accountinfo.middle_name as 'middle_name',
ext_couples_accountinfo.last_name as 'last_name' FROM mf_prog_users LEFT JOIN ext_couples_accountinfo ON mf_prog_users.userid = ext_couples_accountinfo.userid WHERE mf_prog_users.userid='".$userid."' 
 ORDER BY ext_couples_accountinfo.partnerno LIMIT 2";
$stmt_users	= $link->prepare($select_db_users);
$stmt_users->execute();

$xcounter_users = 0;
while($row_users = $stmt_users->fetch()){
    if($xcounter_users == 0){
        $partner1_name = $row_users['first_name'].' '.$row_users['middle_name'].' '.$row_users['last_name'];
    }else{
        $partner2_name = $row_users['first_name'].' '.$row_users['middle_name'].' '.$row_users['last_name'];
    }
    $xcounter_users++;
};



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
    $doc_link = $rs_partnerinfo['mf_doc_link'];
    $crm_link = $rs_partnerinfo['mf_crm_link'];
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
                                    <div class="col-12 d-flex justify-content-left" style='padding-right:375px;flex-direction:column;margin-left:25px'>
                                        <div style="font-weight:bold;font-size:33px;font-family:inter;margin-bottom:0;text-align:left">Marriage Expectation Inventory Form</div>
                                        <div style="font-weight:bold;font-size:27px;font-family:inter;margin-bottom:0;text-align:left">Fill Up Form</div>
                                    </div>

                                </div>
                         
                                    
                                <img src="images/Rectangle 11934.png" style='width:100%;height:4px'>
                                    
                            </div>

        
                            <div class="m-3 px-4" style='max-height:600px;overflow-y:scroll'>

                                <table style='width:100%;max-height:100px'>
                                    <tr>
                                        <td style='width:40%'>
                                            &nbsp;
                                        </td>

                                        <td style='width:30%' colspan="2">
                                            <div style='margin-left:18px'>

                                                <div style='font-family:inter;font-size:32px;font-weight:500;'>Partner 1</div>
                                                <?php
                                                echo "<div style='font-family:inter;font-size:27px;font-weight:300;color:#3D3D3D'>".$partner1_name."</div>";
                                                ?>
                                            </div>
                                        </td>

                                        <td style='width:30%' colspan="2">
                                            <div style='margin-left:18px'>

                                                <div style='font-family:inter;font-size:32px;font-weight:500;'>Partner 2</div>
                                                <?php
                                                echo "<div style='font-family:inter;font-size:27px;font-weight:300;color:#3D3D3D'>".$partner2_name."</div>";
                                                ?>
                                            </div>
                                        </td>

                                    </tr>


                                    <tr>
                                        <td style='font-size:25px;font-family:inter;font-weight:500;color:#797979;width:50%;padding-left:20px;padding-top:10px;width:40%'>
                                            Statement
                                        </td>

                                        <td colspan='2' style='font-size:25px;font-family:inter;font-weight:500;color:#797979;width:30%;margin-left:18px' class='px-3'>
                                            Answer
                                        </td>

                                        <td  colspan='2'style='font-size:25px;font-family:inter;font-weight:500;color:#797979;width:30%;margin-left:18px' class='px-3'>
                                            Reason/s
                                        </td>
                                    </tr>

                                    <?php
                                        $meiform_count = 1;
                                        $select_db_meiform = "SELECT  * FROM mf_meiform";
                                        // $select_db_meiform = "SELECT mf_meiform.questions as 'questions',  FROM ext_mf_meiform LEFT JOIN mf_meiform ON ext_mf_meiform.meiformid =  mf_meiform .meiformid WHERE ext_mf_meiform.meiformid=?";
                                        $stmt_meiform	= $link->prepare($select_db_meiform);
                                        $stmt_meiform->execute(array($_POST['cus_recid_hidden']));
                                        while($row_meiform = $stmt_meiform->fetch()){
                                            echo "<tr>";

                                                echo "<td style='width:50%;font-weight:500;font-family:inter;font-size:16px;padding-left:20px;padding-top:10px'>";
                                                    echo "<div style='width:90%'>".$meiform_count.".".$row_meiform['questions']."</div>";
                                                echo "</td>";

                                                $select_db_meiform_1 = "SELECT ext_mf_meiform.answers as 'answers', ext_mf_meiform.reasons as 'reasons'  FROM ext_mf_meiform LEFT JOIN mf_meiform ON ext_mf_meiform.meiformid =  mf_meiform .meiformid WHERE ext_mf_meiform.meiformid='".$row_meiform['meiformid']."' AND ext_mf_meiform.partnerid='1' AND ext_mf_meiform.userid='".$userid."'";
                                                $stmt_meiform_1	= $link->prepare($select_db_meiform_1);
                                                $stmt_meiform_1->execute();

                                                $xcolor = "";

                                                while($row_meiform_1 = $stmt_meiform_1->fetch()){

                                                    if($row_meiform_1['answers'] == "Agree"){
                                                        $xcolor = "#2eb82e";
                                                    }else{
                                                        $xcolor = "#e62e00";
                                                    }


                                                    echo "<td class='px-3' style='width:10%'>";
                                                        echo "<select class='form-control' disabled style='background-color:".$xcolor.";color:white' style='background-color:".$xcolor.";color:white'>";
                                
                                                            echo "<option>".$row_meiform_1['answers']."</option>";
                                                        echo "</select>";
                                                    echo "</td>";

                                                    echo "<td class='px-3' style='width:15%'>";
                                                        echo "<textarea style='width:100%' disabled>".$row_meiform_1['reasons']."</textarea>";
                                                    echo "</td>";
                                                }

                                                $select_db_meiform_2 = "SELECT ext_mf_meiform.answers as 'answers', ext_mf_meiform.reasons as 'reasons'  FROM ext_mf_meiform LEFT JOIN mf_meiform ON ext_mf_meiform.meiformid =  mf_meiform .meiformid WHERE ext_mf_meiform.meiformid='".$row_meiform['meiformid']."' AND ext_mf_meiform.partnerid='2' AND ext_mf_meiform.userid='".$userid."'";
                                                $stmt_meiform_2	= $link->prepare($select_db_meiform_2);
                                                $stmt_meiform_2->execute();

                                                while($row_meiform_2 = $stmt_meiform_2->fetch()){

                                                    if($row_meiform_2['answers'] == "Agree"){
                                                        $xcolor = "#2eb82e";
                                                    }else{
                                                        $xcolor = "#e62e00";
                                                    }

                                                    echo "<td class='px-3' style='width:10%'>";
                                                        echo "<select class='form-control' disabled style='background-color:".$xcolor.";color:white'>";
                                                            echo "<option>".$row_meiform_2['answers']."</option>";
                                                        echo "</select>";
                                                    echo "</td>";

                                                    echo "<td class='px-3' style='width:20%'>";
                                                        echo "<textarea style='width:100%' disabled>".$row_meiform_2['reasons']."</textarea>";
                                                    echo "</td>";
                                                }
                                            echo "</tr>";


                                            $meiform_count++;

                                        
                                            
                                        }

                                    ?>
                                </table>
                         
                            </div>

                            <div class="col-12 d-flex justify-content-center">
                                    <div class="container d-flex justify-content-center align-items-center">
                                        <div class="m-3 pt-3 form-group d-flex align-items-center justify-content-center">
                                            <button type="button" onclick="onSubmit('PMC')" class="btn" style="background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:200px;height:50px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Proceed to PMC</button>
                                        </div>

                                        <div class="m-3 pt-3 form-group d-flex align-items-center justify-content-center">
                                            <button type="button" onclick="onSubmit('CRT')" class="btn" style="background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:200px;height:50px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Proceed to Cert</button>
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

        <input type="hidden" name="ac_recid_hidden" id="ac_recid_hidden" value="<?php echo $_POST['ac_recid_hidden'];?>">
        
    </form>

    <script>
    



        function onSubmit(xevent_action){

            var ac_recid_hidden = $("#ac_recid_hidden").val();

            jQuery.ajax({    
                data:{
                    event_action:xevent_action,
                    ac_recid_hidden:ac_recid_hidden
                },
                dataType:"json",
                type:"post",
                url:"cc_meiformapproval2_ajax.php", 
                success: function(xdata){

                    if(xdata['status'] == false){
                        // $('.error_msg').html(xdata['msg']);
                        // $(".xerror_modal").modal("show");
                    }else{
                        document.forms.myforms.method = "post";
                        document.forms.myforms.target = "_self";
                        document.forms.myforms.action = "cc_meiformapproval.php";
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

