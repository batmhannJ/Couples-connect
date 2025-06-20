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


$select_db_userid="SELECT * FROM pro_counselorbooking WHERE
userid='".$_POST['userid_hidden']."' LIMIT 1";
$stmt_userid	= $link->prepare($select_db_userid);
$stmt_userid->execute();
while($rs_userid = $stmt_userid->fetch()){
    $date_desc = $rs_userid['date_desc'];
}

// var_dump($header_name);


?>

    <style>
        textarea:focus{
            outline:none;
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
                <td style='width:30%'>
                    <div class="row h-100 justify-content-center align-items-center">
                        <div style='width:437px;height:700px;background-color:white;border-radius:30px;filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25))'>
                            <div class="m-3 pt-2 text-center login_form_header">
                                <p style="font-weight:bold;font-size:27px;font-family:inter;margin-bottom:0">Options</p>
                                <img src="images/Rectangle 11934.png" style='width:100%'>
                            </div>

                            <?php
                                require 'cc_mf_menu.php';
                            ?>

                         
                        </div>
                    </div>
                </td>

                <td style='width:70%'>
                    <div class="row h-100 justify-content-center align-items-center">
                        <div style='width:1025px;height:700px;;background-color:white;border-radius:30px;filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25));display:flex;flex-direction:column'>

                            <div class="m-3 pt-2">

                                <div class="row">
                                    <div class="col-2">
                                        <a href="http://localhost/couples-connectprog/cc_couplesrecord.php"><img src="images/Vector (1).png" style='height:30px;width:20px'></a>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center" style='padding-right:375px'>
                                        <p style="font-weight:bold;font-size:27px;font-family:inter;margin-bottom:0;margin-left:70px">Documentation Report</p>
                                    </div>
                                </div>

                                    
                                <img src="images/Rectangle 11934.png" style='width:100%;height:4px'>
                                
                            </div>
                            <div class="mb-2 mx-2 px-2 mt-0">
                                <div style='font-size:21px;font-family:inter;font-weight:500'>
                                    Counseling/PM Counseling Session
                                </div>

                                <div style='font-size:18px;font-family:inter;font-weight:500' class='mt-3'>
                                    Date of Session: <?php 

                                                                                
                                    
                                            echo "<span style='font-weight:700'>".$date_desc."<span>";
                                        

                                    ?>
                                </div>

                                <div class='container mt-3 mx-0 px-0' style='max-height:200px;overflow-y:auto'>
                                        <table style='width:800px' id='change_table' name='change_table'>

                                            <thead>     
                                                <tr style='font-size:16px;font-family:inter;font-weight:700'>
                                                    <td class='text-center'>
                                                        Concerns
                                                    </td>
                                                    <td class='text-center'>
                                                        Detailed Description
                                                    </td>
                                                    <td class='text-center'>
                                                        Recommendations
                                                    </td>

                                                    <td class='text-center'>
                                                        Future Actions
                                                    </td>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                <?php


                                                $xcounter_desc = 0;
                                                $select_db_ac = "SELECT ext_pro_counselorbooking.reccomendation as 'reccomendation',
                                                ext_pro_counselorbooking.description as 'description',
                                                mf_concerns.concerns as 'concerns',
                                                ext_pro_counselorbooking.future_actions as 'future_actions',
                                                pro_counselorbooking.reccomendation_future as 'future_rec',
                                                pro_counselorbooking.status as 'status',
                                                pro_counselorbooking.prepared_by as 'prepared_by' FROM ext_pro_counselorbooking LEFT JOIN pro_counselorbooking ON 
                                                ext_pro_counselorbooking.pro_crbookingid = pro_counselorbooking.pro_crbookingid LEFT JOIN mf_concerns ON
                                                mf_concerns.concern_id = ext_pro_counselorbooking.concern_id WHERE
                                                pro_counselorbooking.userid='".$_POST['userid_hidden']."'";
                                                $stmt	= $link->prepare($select_db_ac);
                                                $stmt->execute();

                                                $future_rec = "";
                                                $prepared_by = "";
                                                $book_status = "";
                                                $remove_top_border = "";

                                                while($rs_ac = $stmt->fetch()){


                                                    if($xcounter_desc !== 0){
                                                        $remove_top_border = 'border-top:none;';
                                                    }else{
                                                        $remove_top_border = 'border-top:1px solid black;';
                                                    }


                                                    $future_rec = $rs_ac['future_rec'];
                                                    $book_status = $rs_ac['status'];
                                                    $prepared_by = $rs_ac['prepared_by'];

                                                    echo"<tr>";
                                                        echo"<td style='height:80px;width:25%'>";
                                                            echo"<div style='".$remove_top_border."
                                                                border-left:1px solid black; 
                                                                border-bottom:1px solid black;                                                    
                                                                width:100%;height:100%'>
                                                                <select 
                                                                    readonly
                                                                    name='text_submit[1][concern]' 
                                                                    id='text_submit[1][concern]' 
                                                                    style='width:100%;height:100%;border:none;border-radius:none;'>
                                                                        <option>
                                                                        ".$rs_ac['concerns']."
                                                                        </option>
                                                                </select>
                                                            </div>";
                                                    
                                                        echo "</td>";

                                                        echo"<td style='height:80px;width:25%'>";
                                                            echo"<div style='".$remove_top_border."
                                                                border-bottom:1px solid black;
                                                                border-left:1px solid black;
                                                                border-right:1px solid black;
                                                                width:100%;height:100%'>
                                                                <textarea 
                                                                    readonly
                                                                    name='text_submit[1][description]' 
                                                                    id='text_submit[1][description]' 
                                                                    style='width:100%;height:100%;border:none;border-radius:15px;'>".$rs_ac['description']."</textarea>
                                                            </div>";
                                        
                                                        echo"</td>";

                                                        echo"<td style='height:80px;width:25%'>";
                                                            echo"<div style='".$remove_top_border."
                                                                border-bottom:1px solid black;
                                                                border-right:1px solid black;                        
                                                                width:100%;height:100%'>
                                                                <textarea 
                                                                readonly
                                                                name='text_submit[1][reccomendation]' 
                                                                id='text_submit[1][reccomendation]' 
                                                                style='width:100%;height:100%;border:none;border-radius:15px;'>".$rs_ac['reccomendation']."</textarea>
                                                            </div>";
                                        
                                                        echo"</td>";

                                                        echo"<td style='height:80px;width:25%'>";
                                                            echo"<div style='".$remove_top_border."
                                                                border-bottom:1px solid black;
                                                                border-right:1px solid black;                        
                                                                width:100%;height:100%'>
                                                                <textarea 
                                                                readonly
                                                                name='text_submit[1][future_actions]' 
                                                                id='text_submit[1][future_actions]' 
                                                                style='width:100%;height:100%;border:none;border-radius:15px;'>".$rs_ac['future_actions']."</textarea>
                                                            </div>";
                                                        echo"</td>";
                                                    echo"</tr>";        
                                                    
                                                    $xcounter_desc++;
                                                }

                                                ?>
                                            </tbody>
                                        </table>
                                </div>


            

                                <div style='margin-top:20px'>
                                    <div style='font-size:18px;font-family:inter;font-weight:500'>
                                        General Evaluation
                                    </div>

                                    <select readonly disabled name="select_status" id="select_status" class='form-control' style='width:260px;font-size:18px'>
                                        <?php

                                            $dar_selected = "";
                                            $apr_selected = "";

                                            if($book_status == "DAR"){
                                                $dar_selected = "selected";
                                            }else if($book_status == "APR"){
                                                $apr_selected = "selected";
                                            }

                                            echo "<option ".$apr_selected." value='APR'>Approved</option>";
                                            echo "<option ".$dar_selected." value='DAR'>Disapproved</option>";
                                 

                                        ?>
                                    </select>
                                </div>

                                <div style='font-size:18px;font-family:inter;font-weight:500;flex-direction:row' class='d-flex mt-3'>
                                    <div>
                                        Prepared By: <?php echo "<span style='font-weight:700'>".$prepared_by."</span>";?></br>
                                    </div>

                                    <div style='margin-left:50px;'>
                                        Noted By: <?php echo "<span style='font-weight:700'>".$prepared_by."</span>";?>
                                    </div>
                                </div>

                                <div style='font-size:20px;font-family:inter;font-weight:500;flex-direction:row' class='d-flex mt-3'>
                                    <div>
                                        <button type="button" class="btn" onclick="viewMei('PMO')" style="background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:185px;height:auto;font-size:18px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">View MEI form</button>
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

        <div class="modal fade" id="modal_meiform" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" style='max-width:80vw'>
                <div class="modal-content" style='border-radius:20px'>
                    <div class="modal-header pb-0 mb-0">
                        <div class="modal-title" style='margin-left:18px'>
                            <div class="modal-title" id="exampleModalLabel" style='font-size:33px;font-family:inter;font-weight:600'>Marriage Expectatiton Form</div>
                            <div class="modal-title" id="exampleModalLabel" style='font-size:21px;font-family:inter'>Fill-up Form</div>
                        </div>
                        
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size:30px"></button>
                    </div>
                    <div class="modal-body">
                        <table style='width:100%;max-height:100px'>
                            <tr>
                                <td style='width:40%'>
                                    &nbsp;
                                </td>

                                <td style='width:30%' colspan="2">
                                    <div style='margin-left:18px'>

                                        <div style='font-family:inter;font-size:24px;font-weight:500;'>Partner 1</div>
                                        <?php
                                        echo "<div style='font-family:inter;font-size:23px;font-weight:300;color:#3D3D3D' id='meiform_p1_name'></div>";
                                        ?>
                                    </div>
                                </td>

                                <td style='width:30%' colspan="2">
                                    <div style='margin-left:18px'>

                                        <div style='font-family:inter;font-size:24px;font-weight:500;'>Partner 2</div>
                                        <?php
                                        echo "<div style='font-family:inter;font-size:23px;font-weight:300;color:#3D3D3D' id='meiform_p2_name'></div>";
                                        ?>
                                    </div>
                                </td>

                            </tr>

                            <tr>
                                <td style='font-size:23px;font-family:inter;font-weight:500;color:#797979;width:50%;padding-left:20px;padding-top:10px;width:40%'>
                                    Statement
                                </td>

                                <td style='font-size:23px;font-family:inter;font-weight:500;color:#797979;width:10%;margin-left:18px' class='px-3'>
                                    Answer
                                </td>

                                <td style='font-size:23px;font-family:inter;font-weight:500;color:#797979;width:10%;margin-left:18px' class='px-3'>
                                    Reason/s
                                </td>

                                <td style='font-size:23px;font-family:inter;font-weight:500;color:#797979;width:10%;margin-left:18px' class='px-3'>
                                    Answer
                                </td>

                                <td style='font-size:23px;font-family:inter;font-weight:500;color:#797979;width:15%;margin-left:18px' class='px-3'>
                                    Reason/s
                                </td>                                
                            </tr>

                            <?php
                                $meiform_count = 1;
                                $select_db_meiform = "SELECT  * FROM mf_meiform";
                                // $select_db_meiform = "SELECT mf_meiform.questions as 'questions',  FROM ext_mf_meiform LEFT JOIN mf_meiform ON ext_mf_meiform.meiformid =  mf_meiform .meiformid WHERE ext_mf_meiform.meiformid=?";
                                $stmt_meiform	= $link->prepare($select_db_meiform);
                                $stmt_meiform->execute();
                                while($row_meiform = $stmt_meiform->fetch()){
                                    echo "<tr>";

                                        echo "<td style='width:50%;font-weight:500;font-family:inter;font-size:16px;padding-left:20px;padding-top:10px'>";
                                            echo "<div style='width:90%'>".$meiform_count.". ".$row_meiform['questions']."</div>";
                                        echo "</td>";

                                        $select_db_meiform_1 = "SELECT ext_mf_meiform.answers as 'answers', ext_mf_meiform.reasons as 'reasons'  FROM ext_mf_meiform LEFT JOIN mf_meiform ON ext_mf_meiform.meiformid =  mf_meiform .meiformid WHERE ext_mf_meiform.meiformid='".$row_meiform['meiformid']."' AND ext_mf_meiform.partnerid='1' LIMIT 1";
                                        $stmt_meiform_1	= $link->prepare($select_db_meiform_1);
                                        $stmt_meiform_1->execute();

                                        while($row_meiform_1 = $stmt_meiform_1->fetch()){

                                            echo "<td class='px-3' style='width:10%'>";
                                                echo "<select  style='color:white' name='ans_1[".$meiform_count."]' class='form_control' id='ans_1[".$meiform_count."]' disabled>";
                                                    echo "<option>Agree</option>";
                                                    echo "<option>Disagree</option>";
                                                echo "</select>";
                                            echo "</td>";

                                            echo "<td class='px-3' style='width:15%'>";
                                                echo "<textarea style='width:100%;border-radius:5px' disabled name='reason_1[".$meiform_count."]' id='reason_1[".$meiform_count."]'>".$row_meiform_1['reasons']."</textarea>";
                                            echo "</td>";
                                        }

                                        $select_db_meiform_2 = "SELECT ext_mf_meiform.answers as 'answers', ext_mf_meiform.reasons as 'reasons'  FROM ext_mf_meiform LEFT JOIN mf_meiform ON ext_mf_meiform.meiformid =  mf_meiform .meiformid WHERE ext_mf_meiform.meiformid='".$row_meiform['meiformid']."' AND ext_mf_meiform.partnerid='2' LIMIT 1";
                                        $stmt_meiform_2	= $link->prepare($select_db_meiform_2);
                                        $stmt_meiform_2->execute();

                                        $meiform_count2 = $meiform_count+10;

                                        while($row_meiform_2 = $stmt_meiform_2->fetch()){

                                            echo "<td class='px-3' style='width:10%'>";
                                                echo "<select  style='color:white' disabled name='ans_2[".$meiform_count2."]' class='form_control' id='ans_2[".$meiform_count2."]'>";
                                                    echo "<option>Agree</option>";
                                                    echo "<option>Disagree</option>";
                                                echo "</select>";
                                            echo "</td>";

                                            echo "<td class='px-3' style='width:20%'>";
                                                echo "<textarea style='width:100%;border-radius:5px'  name='reason_2[".$meiform_count2."]' id='reason_2[".$meiform_count2."]' disabled>".$row_meiform_2['reasons']."</textarea>";
                                            echo "</td>";
                                        }
                                    echo "</tr>";

                                
                                    $meiform_count++;
                                }

                            ?>
                        </table>
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> -->
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
        <input type="hidden" name="current_rows" id="current_rows">
        <input type="hidden" name="username_hidden" id="username_hidden" value="<?php echo $_POST['username_hidden'];?>">
    <input type="hidden" name="pro_booking_recid_hidden" id="pro_booking_recid_hidden" value="<?php echo $_POST['pro_booking_recid_hidden'];?>">
        <input type="hidden" name="userid_hidden" id="userid_hidden" value="<?php echo $_POST['userid_hidden'];?>">

    </form>

    <script>

    function add_new(xevent_action){


        var current_rows = $("#current_rows").val();
        var ac_recid_hidden = $("#ac_recid_hidden").val();


        if(current_rows == "" || current_rows == null){
            current_rows = 1;
        }

      
        if(xevent_action == 'add_new'){
            var xallData = `event_action=${xevent_action}&current_rows=${current_rows}`;
        } else if (xevent_action == 'submit_data'){
            var xallData = $("#myforms *").serialize() + `&event_action=${xevent_action}&current_rows=${current_rows}&ac_recid_hidden=${ac_recid_hidden}`;
        }
       
        $.ajax({                                      
            url: 'cc_counseling2_ajax.php',              
            type: "post",          
            data: xallData,               
            success: function(xdata){

                if(xevent_action == "add_new"){
                    $("#current_rows").val(xdata['new_row']);
                    $("#change_table").append(xdata['html']);
                }else if(xevent_action == "submit_data"){
                    document.forms.myforms.method = "post";
                    document.forms.myforms.target = "_self";
                    document.forms.myforms.action = "cc_counseling.php";
                    document.forms.myforms.submit();
                }

                
            },
            error: function (request, status, error) {
            }
        });
    }

    function viewMei(){

        var username_hidden2 = $("#username_hidden").val();

        $.ajax({                                      
            url: 'cc_counseling_ajax.php',              
            type: "post",          
            data: {
                xevent_action: "view_meiform",
                xusername:username_hidden2},               
            success: function(xdata){

                var counter_cert = 1;
                $.each(xdata, function(index, value) {
        
                    if(value.hasOwnProperty('p1')) {

                        $(`[id="ans_1[${counter_cert}]"]`).val(function() {
                            return $(this).find("option").filter(function() {
                            return $(this).text() === value.p1.answer;
                            }).val();
                        });

                        if(value.p1.answer =='Agree'){
                            $(`[id="ans_1[${counter_cert}]"]`).css('background-color','#2eb82e')
                        }else{
                            $(`[id="ans_1[${counter_cert}]"]`).css('background-color','#e62e00')
                        }

                        $(`[id="reason_1[${counter_cert}]"]`).html(value.p1.reason);

                        // console.log('p1 answer: ' + value.p1.answer);
                        // console.log('p1 reason: ' + value.p1.reason);
                        // console.log('p1 reason: ' + value.p1.counter);

                    } else if(value.hasOwnProperty('p2')) {

                        $(`[id="ans_2[${counter_cert}]"]`).val(function() {
                            return $(this).find("option").filter(function() {
                            return $(this).text() === value.p2.answer;
                            }).val();
                        });

                        if(value.p2.answer =='Agree'){
                            $(`[id="ans_2[${counter_cert}]"]`).css('background-color','#2eb82e')
                        }else{
                            $(`[id="ans_2[${counter_cert}]"]`).css('background-color','#e62e00')
                        }

                        $(`[id="reason_2[${counter_cert}]"]`).html(value.p2.reason);


                    }

                    counter_cert++;

                });

                $("#meiform_p1_name").html(xdata['partner1_name']);
                $("#meiform_p2_name").html(xdata['partner2_name']);
            },
            error: function (request, status, error) {
            }
        });
        $("#modal_meiform").modal("show");
    }    




    </script>

<?php 
require "includes/cc_footer.php";
?>

