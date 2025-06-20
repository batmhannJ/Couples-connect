<?php
require "includes/cc_header.php";

$header_name = '';
if ($_SESSION['usertype'] == 'DSK') {
    $header_name = "DESK";
} else if ($_SESSION['usertype'] == 'CNR') {
    $header_name = "COUNSELOR";
} else if ($_SESSION['usertype'] == 'HED') {
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
                <a href="http://localhost/couples-connectprog/select_option.php" style='color:black;text-decoration:none' class='has_hover'>HOME</a>
            </div>

            <div style="flex:.1;text-align:center;padding-right:10px">
                <a style='color:black;text-decoration:none'>|</a>
            </div>

            <div style="flex:.3;text-align:center;padding-right:15px">
                <a style='color:black;text-decoration:none'><?php echo $header_name; ?> </a>
            </div>

            <div style="flex:0.6;text-align:right;padding-right:35px">
                <a href="http://localhost/couples-connectprog/logout_cc.php" class='has_hover' style='color:black;text-decoration:none'>LOGOUT</a>
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
                    <div style='width:1025px;height:700px;background-color:white;border-radius:30px;filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25));display:flex;flex-direction:column'>

                        <div class="m-3 pt-2 text-center">
                            <p style="font-weight:bold;font-size:27px;font-family:inter;margin-bottom:0">Counseling</p>
                            <img src="images/Rectangle 11934.png" style='width:100%;height:4px'>
                        </div>
                        <div class="m-3">

                            <div class="row d-flex justify-content-center" style='width:100%'>
                                <div class="col-5 m-2" style='font-family:inter;font-size:22px;color:black;font-weight:500'>
                                    Select Patient
                                </div>

                                <div class="col-5" style='font-family:inter;font-size:22px;color:#3D3D3D;font-weight:500'>
                                    Status
                                </div>
                            </div>

                            <div class="row  d-flex justify-content-center" style='width:100%'>
                                <div class="col-5 m-2" name='select_patient' id='select_patient' style='font-family:inter;font-size:22px;color:#3D3D3D;font-weight:500'>
                                    <select name="select_user" id="select_user" class='form-control' style='width:80%'>
                                        <option disabled selected>Select a user:</option>
                                        <?php


                                    
                                        $select_dd = "SELECT * FROM mf_prog_users LEFT JOIN pro_meiform ON mf_prog_users.userid = pro_meiform.userid WHERE pro_meiform.status='PMC' AND pro_meiform.counselorid='" . $_SESSION['usr_id'] . "' AND mf_prog_users.act_status='PMC' GROUP BY mf_prog_users.username";

                                        $stmt_dd    = $link->prepare($select_dd);
                                        $stmt_dd->execute();

                                        while ($row_dd = $stmt_dd->fetch()) {
                                            echo "<option>";
                                            echo $row_dd['username'];
                                            echo "</option>";
                                        }

                                        ?>
                                    </select>
                                </div>

                                <div class="col-5" style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:500' id='status_html' name='status_html'>
                                    ...
                                </div>



                            </div>


                            <div class="row d-flex justify-content-center">
                                <div class="col-10 m-4 my-3" style='font-family:inter;font-size:22px;color:#3D3D3D;font-weight:500'>
                                    Personal Information
                                </div>
                            </div>


                            <!-- <div class="row d-flex justify-content-center">
                                    <div class="col-5 m-2" style='font-family:inter;font-size:22px;color:#3D3D3D;font-weight:500'>
                                        JOENEL
                                    </div>

                                    <div class="col-5 my-2" style='font-family:inter;font-size:22px;color:#3D3D3D;font-weight:500'>
                                        LEGAZPI
                                    </div>
                                </div> -->

                            <div class="row">
                                <div class="col-6 d-flex">
                                    <div style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:400;margin-left:105px'>
                                        Name:
                                    </div>

                                    <div id="name_1" name="name_1" style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:600;margin-left:10px'>

                                    </div>
                                </div>

                                <div class="col-6 d-flex">
                                    <div style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:400;margin-left:7px'>
                                        Name:
                                    </div>

                                    <div id="name_2" name="name_2" style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:600;margin-left:10px'>

                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-6 d-flex">
                                    <div style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:400;margin-left:105px'>
                                        Birthdate:
                                    </div>

                                    <div id="bday_1" name="bday_1" style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:600;margin-left:10px'>

                                    </div>
                                </div>

                                <div class="col-6 d-flex">
                                    <div style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:400;margin-left:7px'>
                                        Birthdate:
                                    </div>

                                    <div id="bday_2" name="bday_2" style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:600;margin-left:10px'>

                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-6 d-flex">
                                    <div style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:400;margin-left:105px'>
                                        Gender:
                                    </div>

                                    <div id="gender_1" name="gender_1" style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:600;margin-left:10px'>

                                    </div>
                                </div>

                                <div class="col-6 d-flex">
                                    <div style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:400;margin-left:7px'>
                                        Gender:
                                    </div>

                                    <div id="gender_2" name="gender_2" style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:600;margin-left:10px'>

                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-6 d-flex">
                                    <div style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:400;margin-left:105px'>
                                        Contact:
                                    </div>

                                    <div id="contact_1" name="contact_1" style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:600;margin-left:10px'>

                                    </div>
                                </div>

                                <div class="col-6 d-flex">
                                    <div style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:400;margin-left:7px'>
                                        Contact:
                                    </div>

                                    <div id="contact_2" name="contact_2" style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:600;margin-left:10px'>

                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-6 d-flex">
                                    <div style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:400;margin-left:105px'>
                                        Address:
                                    </div>

                                    <div id="address_1" name="address_1" style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:600;margin-left:10px'>

                                    </div>
                                </div>

                                <div class="col-6 d-flex">
                                    <div style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:400;margin-left:7px'>
                                        Address:
                                    </div>

                                    <div id="address_2" name="address_2" style='font-family:inter;font-size:20px;color:#3D3D3D;font-weight:600;margin-left:10px'>

                                    </div>
                                </div>
                            </div>

                            <div style='display:flex;flex-direction:row;align-items:center'>
                                <div style='font-size:22px;font-familter:inter;color:#3D3D3D;margin-left:105px;margin-top:15px;font-weight:600'>
                                    MEI Form:
                                </div>

                                <button type="button" id="view_meiform_btn" disabled="true" onclick="viewMei('PMC')" class="btn cnr_btn" style="background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:185px;height:40px;font-size:20px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25));margin-top:15px;margin-left:20px">View</button>

                            </div>

                            <div class="row mt-3 d-flex justify-content-center align-items-center">
                                <button type="button" id="proceed_btn" disabled="true" onclick="onProceed('PMC')" class="btn cnr_btn" style="background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:200px;height:auto;font-size:21px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Proceed</button>
                            </div>

                        </div>
                    </div>
                </div>
            </td>
        </tr>

    </table>

    <input type="hidden" name="username_hidden" id="username_hidden">

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
                <div class="modal-header mb-0 pb-0">
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
                            <td style='font-size:23px;font-family:inter;font-weight:500;color:#797979;width:50%;padding-left:20px;width:40%'>
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
                        $stmt_meiform    = $link->prepare($select_db_meiform);
                        $stmt_meiform->execute();
                        while ($row_meiform = $stmt_meiform->fetch()) {
                            echo "<tr>";

                            echo "<td style='width:50%;font-weight:500;font-family:inter;font-size:16px;padding-left:20px;padding-top:10px'>";
                            echo "<div style='width:90%'>" . $meiform_count . ". " . $row_meiform['questions'] . "</div>";
                            echo "</td>";

                            $select_db_meiform_1 = "SELECT ext_mf_meiform.answers as 'answers', ext_mf_meiform.reasons as 'reasons'  FROM ext_mf_meiform LEFT JOIN mf_meiform ON ext_mf_meiform.meiformid =  mf_meiform .meiformid WHERE ext_mf_meiform.meiformid='" . $row_meiform['meiformid'] . "' AND ext_mf_meiform.partnerid='1' LIMIT 1";
                            $stmt_meiform_1    = $link->prepare($select_db_meiform_1);
                            $stmt_meiform_1->execute();
                            $xcolor = "";

                            while ($row_meiform_1 = $stmt_meiform_1->fetch()) {


                                echo "<td class='px-3' style='width:10%'>";
                                echo "<select  style='color:white' name='ans_1[" . $meiform_count . "]' class='form_control' id='ans_1[" . $meiform_count . "]' disabled>";
                                echo "<option>Agree</option>";
                                echo "<option>Disagree</option>";
                                echo "</select>";
                                echo "</td>";

                                echo "<td class='px-3' style='width:15%'>";
                                echo "<textarea style='width:100%;border-radius:5px' disabled name='reason_1[" . $meiform_count . "]' id='reason_1[" . $meiform_count . "]'>" . $row_meiform_1['reasons'] . "</textarea>";
                                echo "</td>";
                            }

                            $select_db_meiform_2 = "SELECT ext_mf_meiform.answers as 'answers', ext_mf_meiform.reasons as 'reasons'  FROM ext_mf_meiform LEFT JOIN mf_meiform ON ext_mf_meiform.meiformid =  mf_meiform .meiformid WHERE ext_mf_meiform.meiformid='" . $row_meiform['meiformid'] . "' AND ext_mf_meiform.partnerid='2' LIMIT 1";
                            $stmt_meiform_2    = $link->prepare($select_db_meiform_2);
                            $stmt_meiform_2->execute();

                            $meiform_count2 = $meiform_count + 10;

                            while ($row_meiform_2 = $stmt_meiform_2->fetch()) {

                                echo "<td class='px-3' style='width:10%'>";
                                echo "<select style='color:white' disabled name='ans_2[" . $meiform_count2 . "]' class='form_control' id='ans_2[" . $meiform_count2 . "]'>";
                                echo "<option>Agree</option>";
                                echo "<option>Disagree</option>";
                                echo "</select>";
                                echo "</td>";

                                echo "<td class='px-3' style='width:20%'>";
                                echo "<textarea style='width:100%;border-radius:5px'  name='reason_2[" . $meiform_count2 . "]' id='reason_2[" . $meiform_count2 . "]' disabled>" . $row_meiform_2['reasons'] . "</textarea>";
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

    <input type="hidden" name="ac_recid_hidden" id="ac_recid_hidden">

</form>

<script>
    $('#select_user').on('change', function() {
        $("#ac_recid_hidden").val(this.value);
        $("#username_hidden").val(this.value);
        $(".cnr_btn").prop('disabled', false);

        $.ajax({
            url: 'cc_counseling_ajax.php',
            type: "post",
            data: {
                xevent_action: "select_change",
                xusername: this.value
            },
            success: function(xdata) {
                $('#name_1').html(xdata['retEdit']['name_1']);
                $('#bday_1').html(xdata['retEdit']['bday_1']);
                $('#gender_1').html(xdata['retEdit']['gender_1']);
                $('#contact_1').html(xdata['retEdit']['contact_1']);
                $('#address_1').html(xdata['retEdit']['address_1']);

                $('#name_2').html(xdata['retEdit']['name_2']);
                $('#bday_2').html(xdata['retEdit']['bday_2']);
                $('#gender_2').html(xdata['retEdit']['gender_2']);
                $('#contact_2').html(xdata['retEdit']['contact_2']);
                $('#address_2').html(xdata['retEdit']['address_2']);

                $("#status_html").html(xdata['html']);

            },
            error: function(request, status, error) {}
        });
    });

    function viewMei() {

        var username_hidden2 = $("#username_hidden").val();

        $.ajax({
            url: 'cc_counseling_ajax.php',
            type: "post",
            data: {
                xevent_action: "view_meiform",
                xusername: username_hidden2
            },
            success: function(xdata) {

                var counter_cert = 1;
                $.each(xdata, function(index, value) {

                    if (value.hasOwnProperty('p1')) {

                        $(`[id="ans_1[${counter_cert}]"]`).val(function() {
                            return $(this).find("option").filter(function() {
                                return $(this).text() === value.p1.answer;
                            }).val();
                        });

                        if (value.p1.answer == 'Agree') {
                            $(`[id="ans_1[${counter_cert}]"]`).css('background-color', '#2eb82e')
                        } else {
                            $(`[id="ans_1[${counter_cert}]"]`).css('background-color', '#e62e00')
                        }

                        $(`[id="reason_1[${counter_cert}]"]`).html(value.p1.reason);

                        // console.log('p1 answer: ' + value.p1.answer);
                        // console.log('p1 reason: ' + value.p1.reason);
                        // console.log('p1 reason: ' + value.p1.counter);

                    } else if (value.hasOwnProperty('p2')) {

                        $(`[id="ans_2[${counter_cert}]"]`).val(function() {
                            return $(this).find("option").filter(function() {
                                return $(this).text() === value.p2.answer;
                            }).val();
                        });

                        if (value.p2.answer == 'Agree') {
                            $(`[id="ans_2[${counter_cert}]"]`).css('background-color', '#2eb82e')
                        } else {
                            $(`[id="ans_2[${counter_cert}]"]`).css('background-color', '#e62e00')
                        }

                        $(`[id="reason_2[${counter_cert}]"]`).html(value.p2.reason);


                    }

                    counter_cert++;

                });

                $("#meiform_p1_name").html(xdata['partner1_name']);
                $("#meiform_p2_name").html(xdata['partner2_name']);
            },
            error: function(request, status, error) {}
        });
        $("#modal_meiform").modal("show");
    }

    function onProceed() {
        document.forms.myforms.method = "post";
        document.forms.myforms.target = "_self";
        document.forms.myforms.action = "cc_counseling2.php";
        document.forms.myforms.submit();
    }
</script>

<?php
require "includes/cc_footer.php";
?>