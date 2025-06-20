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
                        <div style='overflow-y:auto;width:1025px;height:700px;background-color:white;border-radius:30px;filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25));display:flex;flex-direction:column'>

                            <div class="m-3 pt-2 text-center">
                                <p style="font-weight:bold;font-size:27px;font-family:inter;margin-bottom:0">Report Generation</p>
                                <img src="images/Rectangle 11934.png" style='width:100%;height:4px'>
                            </div>
                            <div class="m-3 px-4 d-flex justify-content-center">
                                <div class="col-6" style="margin-left:50px!important">
                                    <label style='font-weight:700;font-size:27px;font-faily:inter'>Select Period From:</label>
                                    <input type="text" style='width:328px;height:37px;border-radius:15px;' class="form-control date_picker period_from" name="period_from" id='period_from'>
                                </div>

                                <div class="col-6">
                                    <label style='font-weight:700;font-size:27px;font-faily:inter'>Select Period To:</label>
                                    <input type="text" style='width:328px;height:37px;border-radius:15px' class="form-control date_picker period_to"  name="period_to" id='period_to'>
                                </div>
                            </div>

                            <div class="m-3 px-4" style="margin-left:50px!important">
                                <div class="col-12 d-flex" style="flex-direction:column">
                                    <label style='font-weight:700;font-size:27px;font-faily:inter'>Orientations:</label>
                                    <?php
                                    
                                        $select_db_totalpmo = "SELECT COUNT(*) as xcount FROM pro_meiform WHERE status='PMO'";
                                        $stmt_totalpmo	= $link->prepare($select_db_totalpmo);
                                        $stmt_totalpmo->execute();
                                        while($rs_totalpmo = $stmt_totalpmo->fetch()){                                                
                                            echo "<span style='font-size:24px;font-family:inter' class='totalnum_orientation'>Total Number of Orientations Sessions Held: ".$rs_totalpmo['xcount']."</span>";
                                        }

                                        $select_db_totalpmo2 = "SELECT * FROM pro_meiform WHERE status='PMO'";
                                        $stmt_totalpmo2	= $link->prepare($select_db_totalpmo2);
                                        $stmt_totalpmo2->execute();
                                        $total_attendees = 0;
                                        while($rs_totalpmo2 = $stmt_totalpmo2->fetch()){

                                            try {
                                                $select_db_totalpmo3 = "SELECT ext_appointment_info.slots_avail as 'slots_avail' FROM mf_meiform LEFT JOIN mf_venue ON mf_meiform.venue = mf_venue.venue LEFT JOIN ext_appointment_info ON ext_appointment_info.venue_id = mf_venue.venue_id WHERE mf_meiform.usermeiformid='".$rs_totalpmo2['usermeiformid']."' LIMIT 1";
                                                $stmt_totalpmo3 = $link->prepare($select_db_totalpmo3);
                                                $stmt_totalpmo3->execute();
                                                while($rs_totalpmo3 = $stmt_totalpmo3->fetch()){
                                                    $total_attendees+=$rs_totalpmo3['slots_avail'];
                                                }
                                            } catch(PDOException $e) {
                                                echo "Error: " . $e->getMessage();
                                                // Handle the error appropriately
                                            }   
                                        }

                                    ?>
                                    <span style='font-size:20px;font-family:inter;margin-left:20px' class='totalnum_orientation_participants'>Total Number of Attendees: <?php echo $total_attendees; ?></span>
                                </div>
                            </div>

                            <div class="m-3 px-4" style="margin-left:50px!important">
                                <div class="col-12 d-flex" style="flex-direction:column">
                                    <label style='font-weight:700;font-size:27px;font-faily:inter'>Counseling:</label>
                                    <?php
                                        $select_db_totalpmc = "SELECT COUNT(*) as xcount FROM pro_meiform WHERE status='PMC'";
                                        $stmt_totalpmc	= $link->prepare($select_db_totalpmc);
                                        $stmt_totalpmc->execute();
                                        while($rs_totalpmc = $stmt_totalpmc->fetch()){
                                                
                                            echo "<span style='font-size:24px;font-family:inter'>Total Number of Counseling Sessions Held: ".$rs_totalpmc['xcount']."</span>";
                                        }
                                    ?>
                                    <span style='font-size:20px;font-family:inter;margin-left:20px'>Total Number of Pre-marriage Counseling:        <?php
                                        $select_db_totalpmc = "SELECT COUNT(*) as xcount FROM pro_meiform WHERE status='PMC'";
                                        $stmt_totalpmc	= $link->prepare($select_db_totalpmc);
                                        $stmt_totalpmc->execute();
                                        while($rs_totalpmc = $stmt_totalpmc->fetch()){
                                            echo $rs_totalpmc['xcount'];
                                        }
                                    ?>
                                    </span>
                                    <span style='font-size:20px;font-family:inter;margin-left:20px'>Total Number of Post-marriage Counseling: 0</span>
                                </div>
                            </div>

                            <div class="m-3 px-4" style="margin-left:50px!important">
                                <div class="col-12 d-flex" style="flex-direction:column">
                                    <label style='font-weight:700;font-size:27px;font-faily:inter'>Couples:</label>
            
                                    <?php

                                        $select_db_ac = "SELECT * FROM mf_concerns";
                                        $stmt	= $link->prepare($select_db_ac);
                                        $stmt->execute();
                                        while($rs_ac = $stmt->fetch()){

                                            $select_db_ac2 = "SELECT COUNT(*) as xcount FROM ext_pro_counselorbooking WHERE concern_id='".$rs_ac['concern_id']."' GROUP BY pro_crbookingid";
                                            $stmt2	= $link->prepare($select_db_ac2);
                                            $stmt2->execute();
                                            $xcount = "";
                                            while($rs_ac2 = $stmt2->fetch()){
                                                $xcount =   $rs_ac2["xcount"];
                                            }
                                                                                            
                                            echo "<span style='font-size:24px;font-family:inter'>Total Number of Reports of ".$rs_ac['concerns'].": ".$xcount."</span>";
                                        }
    
                                    ?>
                                </div>
                            </div>

                            <div class="m-3 mt-0 d-flex align-items-center" style="height:100%">
                                <div class="container d-flex align-items-center justify-content-center">
                                    <button type="button" onclick="acc_choose('DEC')" class="btn" style="background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:250px;height:50px;font-size:25px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Export File</button>
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

        <input type="hidden" name="ac_recid_hidden" id="ac_recid_hidden">
        
    </form>

    <script>

    $('.period_from, .period_to').on('change',function(e){

        var xdata = $("#myforms *").serialize();
        jQuery.ajax({    
            data:xdata,
            dataType:"json",
            type:"post",
            url:"cc_reportgen_ajax.php", 
            success: function(xdata2){

                $(".totalnum_orientation_participants").html("Total Number of Attendees: "+ xdata2['totalOrientationAttendees'])
                $(".totalnum_orientation").html("Total Number of Orientations Sessions Held: "+xdata2['totalOrientations']);
            },
            error: function (request, status, error) {
            }
        })
    });
    
    function review(recid){

        $("#ac_recid_hidden").val(recid);
        
        document.forms.myforms.method = "post";
        document.forms.myforms.target = "_self";
        document.forms.myforms.action = "cc_account_confirm2.php";
        document.forms.myforms.submit();
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

        function onLogin(){

            var xemail_input = document.getElementById("email_login");
            var xpassword = $("#pwd_login").val();
            var xemail = $("#pwd_login").val();

            if(!xpassword || !xemail){
                $(".error_msg").html("Empty password or Email");
                $(".xerror_modal").modal("show");
            }else if(validateEmail(xemail_input) == false){
                $(".error_msg").html("Invalid Email");
                $(".xerror_modal").modal("show");
            }

            jQuery.ajax({    
                data:{
                    email:xemail,
                    password:xpassword
                },
                dataType:"json",
                type:"post",
                url:"login_cc_ajax.php", 
                success: function(xdata){

                    if(xdata['status'] == false){
                        $('.error_msg').html(xdata['msg']);
                        $(".xerror_modal").modal("show");
                    }else{
                        document.forms.myforms.method = "post";
                        document.forms.myforms.target = "_self";
                        document.forms.myforms.action = "select_option.php";
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

