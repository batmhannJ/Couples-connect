<?php
include "includes/main_header.php";

        if($_POST["patient_event_action"] == "edit_main"){

            $select_db_main="SELECT * FROM patientfile WHERE recid=?";
            $stmt_main	= $link->prepare($select_db_main);
            $stmt_main->execute(array($_POST["cus_recid_hidden"]));
            while($rs_main = $stmt_main->fetch()){

                if(!empty($rs_main['birthday']) && $rs_main['birthday'] !== NULL &&  $rs_main['birthday']!=="1970-01-01"){
                    $rs_main['birthday'] = date("m-d-Y",strtotime($rs_main['birthday']));
                    $rs_main['birthday'] = str_replace('-','/',$rs_main['birthday']);
                }else{
                    $rs_main['birthday'] = NULL;
                }

                if(!empty($rs_main['adddte']) && $rs_main['adddte'] !== NULL &&  $rs_main['adddte']!=="1970-01-01"){
                    $rs_main['adddte'] = date("m-d-Y",strtotime($rs_main['adddte']));
                    $rs_main['adddte'] = str_replace('-','/',$rs_main['adddte']);
                }else{
                    $rs_main['adddte'] = NULL;
                }

                if($rs_main["inactive_chk"] == 1){
                    $rs_main["inactive_chk"] = "checked";
                }

                $cuscde             = $rs_main['cuscde'];
                $birthday           = $rs_main['birthday'];
                $age                = $rs_main['age'];
                $bloodtype          = $rs_main["bloodtypecde"];
                $patient_name       = $rs_main['cusdsc'];
                $address            = $rs_main['address'];
                $office_telno       = $rs_main['office_telno'];
                $tin_num            = $rs_main['tin_num'];
                $contact_person     = $rs_main['contact_person'];
                $remarks            = $rs_main['remarks'];
                $price_list         = $rs_main['prccde'];
                $home_telno         = $rs_main['home_telno'];
                $mobile_no          = $rs_main['mobile_no'];
                $fax                = $rs_main['fax'];
                $email              = $rs_main['email'];
                $inactive_chk       = $rs_main['inactive_chk'];
                $other_pat          = $rs_main['other_pat'];
                $surgery_pat        = $rs_main['surgery_pat'];
                $trauma_pat         = $rs_main['trauma_pat'];
                $allergy_pat        = $rs_main['allergy_pat'];
                $other_fam          = $rs_main['other_fam'];
                $adddte          = $rs_main['adddte'];
                $prccde          = $rs_main['prccde'];
                $gender          = $rs_main['gender'];
                // loop here
            }
        }else if($_POST["patient_event_action"] == "add_main"){
            $select_db_cuscde_add = "SELECT cuscde FROM patientfile ORDER BY cuscde DESC LIMIT 1";
            $stmt_cuscde_add	= $link->prepare($select_db_cuscde_add);
            $stmt_cuscde_add->execute();
            $rs_cuscde_add = $stmt_cuscde_add->fetch();

            if(empty($rs_cuscde_add)){
                    $cuscde = "PT-00001";
            }else{
                $cuscde = LNexts($rs_cuscde_add['cuscde']);
            }


            $patient_name       = '';
            $birthday           = '';
            $age                = '';
            $bloodtype          = '';
            $address            = '';
            $office_telno       = '';
            $tin_num            = '';
            $contact_person     = '';
            $remarks            = '';
            $price_list         = '';
            $home_telno         = '';
            $mobile_no          = '';
            $fax                = '';
            $email              = '';
            $inactive_chk       = '';
            $other_pat          = '';
            $surgery_pat        = '';
            $trauma_pat         = '';
            $allergy_pat        = '';
            $other_fam          = '';
            $prccde             = '';
            $adddte = date('m/d/Y');
            $gender = "";


        }


?>

    <style>
        .back_btn:hover{
            opacity:0.5;
            cursor:pointer;
            color:#cc0000;
        }
        .save_btn:hover{
            opacity:0.5;
            cursor:pointer;
            color:#00cc00;
        }

        #xfile_txt:hover{
            cursor:pointer;
        }


        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        /* Style the buttons inside the tab */
        .tab button {
            color:white;
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 17px;
            opacity:0.5
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            opacity:1;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            opacity:1;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }

        .input_w_reset{
            width: 100%;
            padding-right: 20px;
            box-sizing: border-box;
        }
        .btn_reset{
            position: absolute;
            border: none;
            display: block;
            width: 15px;
            height: 15px;
            line-height: 16px;
            font-size: 12px;
            border-radius: 50%;
            top: 0;
            bottom: 0;
            right: 5px;
            margin: auto;
            background: #ddd;
            padding: 0;
            outline: none;
            cursor: pointer;
            transition: .1s;
        }

        .tbody_pat_rec_view:nth-of-type(even){
            background-color: #e6e6e6!important;
        }

        #ui-datepicker-div{
            top:auto;
            left:auto;
        }

        .datePicker {
            z-index:9999;
        }

        /* 
        .btn-file {
        position: relative;
        overflow: hidden;
        }

        .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
        } */


        /*VIEW MODAL CSS */
        #table_points {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            /* width: 100%; */
        }

        #table_points td, #table_points th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #table_points tr:nth-child(even){background-color: #f2f2f2;}

        #table_points tr:hover {background-color: #ddd;}

        #table_points th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }

        /* The Modal (background) */
        .modal_view {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 20px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content-view{
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            border-radius:10px;
            width: 80%;
        }

        /* The Close Button */
        .close{
            color: #aaaaaa;
            font-size: 35px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }


    </style>
    <form name='myforms' id="myforms" method="post" target="_self">
        <table class='big_table'>
            <tr colspan=1>
                <td colspan=1 class='td_bl'>
                    <?php
                        include 'includes/main_menu.php';
                    ?>
                </td>

                <td colspan=1 class="td_br" id="td_br">
                    <?php
                        //$field1 = new Pager("Page name" , "tablename" ,"link");
                    ?>
                    <div class="container-fluid d-flex justify-content-center mt-3 mb-3">
                        <div class="row w-75 bg-white border rounded shadow">

                            <div style="border-bottom:3px solid black;border-color:#cc0000">
                                <h4 class="text-nowrap align-middle text-center p-1">Patient File</h4>
                            </div>

                            <div class="fs-3 d-flex flex-nowrap container-fluid"
                                 style="border-bottom:3px solid black;border-color:#cc0000">
                                <div class="col-3">
                                    <span class="save_btn" onclick="save_patient()">
                                        <i class="far fa-save" style="font-size:25px;"></i>&nbsp;<span>Save & Exit</span>
                                    </span>
                                </div>

                                <!-- <div class="col-2 px-0" >
                                    <span class="back_btn" onclick="back()">
                                        <i class="fas fa-arrow-left" style="font-size:25px;"></i>&nbsp;<span>Cancel</span>
                                    </span>
                                </div> -->

                            </div>

                            <div class="container-fluid mx-3 my-2 top_header_patient">

                                <div class="form-group row my-3" style="font-size:20px;">
                                    <label class="col-2">Patient Name:</label>
                                    <div class="col-5">
                                        <input type="text" class="form-control form_custom_input" id="patient_name" name="patient_name" autocomplete="off" value="<?php echo $patient_name;?>">
                                    </div>

                                    <label class="col-2 ms-2 align-middle">Date Added:</label>
                                    <div class="col-2 mx-0 px-0">
                                        <input type="text" class="form-control form_custom_input date_picker" id="adddte" name="adddte" autocomplete="off" value="<?php echo $adddte;?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group row my-3" style="font-size:20px;">
                                    <label class="col-2">Date Of Birth:</label>
                                    <div class="col-2">
                                        <div class='clearable-input'>
                                            <input type="text" class="form-control date_picker form_custom_input" date_picker_recipient="dp_date_of_birth" id="date_of_birth" name="date_of_birth" autocomplete="off" value="<?php echo $birthday;?>" readonly>
                                        </div>
                                    </div>

                                    

                                    <label class="col-sm-12 col-1 text-center mx-0 px-0" style="font-size:20px;width:6.7%">Age:</label>
                                    <div class="col-1">
                                        <input type="text" class="form-control form_custom_input" id="age" name="age" autocomplete="off" value="<?php echo $age;?>" disabled>
                                    </div>

                                    <label class="col-1" style='padding-left:20px;width: 13.499999995%'>
                                        
                                        Blood Type:
                                        
                                    </label>
                                    <div class="col-1" style="margin-left:8px;margin-right:0px;padding-left:0px;pading-right:0px;width:10%">
                                        <select class="form-select form_custom_input" id="bloodtype" name="bloodtype" autocomplete="off">

                                            <?php
                                                $select_db_bloodtype="SELECT * FROM bloodtypefile";
                                                $stmt_bloodtype	= $link->prepare($select_db_bloodtype);
                                                $stmt_bloodtype->execute();

                                                    echo "<option></option>";
                                                while($rs_bloodtype = $stmt_bloodtype->fetch()){

                                                    $select_bloodtype = "";
                                                    if($rs_bloodtype['bloodtypdsc'] == $bloodtype){
                                                        $select_bloodtype = "selected";;
                                                    }


                                                    echo "<option value=".$rs_bloodtype['bloodtypcde']." ".$select_bloodtype.">".$rs_bloodtype['bloodtypdsc']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <label class="col-1" style='padding-left:15px;margin-right:15px'>Gender:</label>
                                    <div class="col-1" style="margin-left:8px;margin-right:0px;padding-left:0px;pading-right:0px;width:10%">
                                        <select class="form-select form_custom_input" id="gender" name="gender" autocomplete="off">
                                            <?php

                                                $m_selected = "";
                                                $f_selected = "";
                                                if($gender == "M"){
                                                    $m_selected = "selected";
                                                }
                                                if($gender == "F"){
                                                    $f_selected = "selected";
                                                }
                                                echo"<option ".$m_selected.">M</option>";
                                                echo"<option ".$f_selected.">F</option>";
                                            ?>
                                        </select>
                                    </div>

                                </div>

                            </div>

                            <span class="error_msg_span" id="error_msg_span">

                            </span>

                            <div class="container-fluid mt-0 mb-3">
                                    <div class="tab col-12" style="background-color:#cc0000;">
                                        <button type="button" class="tablinks" id="tab_header_generalinfo" onclick="openCity(this.id, 'tab_content_generalinfo')"><b>General Info</b></button>
                                        <button type="button" class="tablinks" id="tab_header_patientrecord" onclick="openCity(this.id, 'tab_content_patientrecord')"><b>Patient Record</b></button>
                                        <button type="button" class="tablinks" id="tab_header_attachment" onclick="openCity(this.id, 'tab_content_attachment')"><b>Attachments</b></button>
                                    </div>

                                    <div id="tab_content_generalinfo" class="tabcontent" style="background-color:#e6e6e6">
                                        <div class="form-group row my-3" style="font-size:20px;">
                                            <label class="col-2">Address:</label>
                                            <div class="col-4">
                                                <input type="text" class="form-control form_custom_input" id="address" name="address" autocomplete="off" value="<?php echo $address;?>">
                                            </div>

                                            <label class="col-2">Office Tel No:</label>
                                            <div class="col-4">
                                                <input type="text" class="form-control form_custom_input" id="office_telno" name="office_telno" autocomplete="off" value="<?php echo $office_telno;?>">
                                            </div>

                                        </div>

                                        <div class="form-group row my-3" style="font-size:20px;">
                                            <label class="col-2">TIN:</label>
                                            <div class="col-4">
                                                <input type="text" class="form-control form_custom_input" id="tin" name="tin" autocomplete="off" value="<?php echo $tin_num;?>">
                                            </div>

                                            <label class="col-2">Contact Person:</label>
                                            <div class="col-4">
                                                <input type="text" class="form-control form_custom_input" id="contact_person" name="contact_person" autocomplete="off" value="<?php echo $contact_person;?>">
                                            </div>

                                        </div>

                                        <div class="form-group row my-3" style="font-size:20px;">
                                            <label>Remarks:</label>
                                            <textarea class="form-control mx-auto form_custom_input" style="max-width:85%" rows="3" id="remarks" name="remarks" autocomplete="off"><?php echo $remarks;?></textarea>
                                        </div>

                                        <div class="form-group row my-3" style="font-size:20px;">

                                        <label class="col-2">Email:</label>
                                            <div class="col-10">
                                                <input type="text" class="form-control form_custom_input" id="email" name="email" autocomplete="off" value="<?php echo $email;?>">
                                            </div>



                                        </div>

                                        <div class="form-group row my-3" style="font-size:20px;">
                                            <label class="col-2">Mobile:</label>
                                            <div class="col-4">
                                                <input type="text" class="form-control form_custom_input" id="mobile_no" name="mobile_no" autocomplete="off" value="<?php echo $mobile_no;?>">
                                            </div>

                                            <label class="col-2">Fax:</label>
                                            <div class="col-4">
                                                <input type="text" class="form-control form_custom_input" id="fax" name="fax" autocomplete="off" value="<?php echo $fax;?>">
                                            </div>

                                        </div>

                                        <div class="form-group row mt-3 pb-4" style="border-bottom:3px solid black;border-color:#cc0000;font-size:20px;">
                                             <label class="col-2">Home Tel No:</label>
                                            <div class="col-4">
                                                <input type="text" class="form-control form_custom_input" id="home_telno" name="home_telno" autocomplete="off" value="<?php echo $home_telno;?>">
                                            </div>
                                            <label class="col-1">Inactive:</label>
                                            <div class="form-check col-2 offset-1">
                                                <input class="form-check-input form_custom_input" type="checkbox" id="inactive" name="inactive" <?php echo $inactive_chk;?>>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <h3 class="px-2 py-2">Patient Medical History</h3>
                                            <?php

                                                $patient_history_counter = 0;

                                                $select_db_patient_history_template="SELECT * FROM patient_history_templatefile ORDER BY disease ASC";
                                                $stmt_patient_history_template	= $link->prepare($select_db_patient_history_template);
                                                $stmt_patient_history_template->execute();

                                                echo "<table>";
                                                while($rs_patient_history_template = $stmt_patient_history_template->fetch()){

                                                    $patient_history_counter++;


                                                    if($patient_history_counter % 2 == 1) {
                                                        echo "<tr>";
                                                    }

                                                    $select_db_patient_history="SELECT * FROM patient_historyfile WHERE cuscde='".$cuscde."' AND disease='".$rs_patient_history_template['disease']."'";
                                                    $stmt_patient_history	= $link->prepare($select_db_patient_history);
                                                    $stmt_patient_history->execute();
                                                    $rs_patient_history = $stmt_patient_history->fetch();

                                                    $checked_pat = "";
                                                    if(!empty($rs_patient_history)){
                                                        $checked_pat = "checked";
                                                    }

                                                    echo "<td>

                                                        <div class='my-1 mx-2'>

                                                            <input class='form-check-input form_custom_input' type='hidden' name='patient_chk[".$rs_patient_history_template['disease']."]' value='0'>
                                                            <input class='form-check-input form_custom_input' type='checkbox' style='float:left;margin-right:10px'  id='patient_chk[".$rs_patient_history_template['disease']."]' name='patient_chk[".$rs_patient_history_template['disease']."]' value='1' ".$checked_pat." >

                                                            <label>
                                                                <b style='font-size:18px'>
                                                                    ".$rs_patient_history_template['disease']."
                                                                </b>
                                                            </label>
                                                        </div>
                                                    </td>";

                                                    if($patient_history_counter % 2 == 0) {
                                                        echo "</tr>";
                                                    }

                                                }
                                                if($patient_history_counter % 2 == 1) { // Used to prevent alignment issue while odd number of rows return
                                                    echo "<td></td></tr>";
                                                }
                                                echo"</table>";
                                            ?>
                                        </div>

                                        <div class="form-group row my-3" style="font-size:20px;">
                                            <label>Other Diseases:</label>
                                            <textarea class="form-control mx-auto form_custom_input" style="max-width:85%" rows="3" id="other_pat" name="other_pat" autocomplete="off"><?php echo $other_pat;?></textarea>
                                        </div>

                                        <div class="form-group row my-3" style="font-size:20px;">
                                            <label>Surgeries :</label>
                                            <textarea class="form-control mx-auto form_custom_input" style="max-width:85%" rows="3" id="surgery_pat" name="surgery_pat" autocomplete="off"><?php echo $surgery_pat;?></textarea>
                                        </div>

                                        <div class="form-group row my-3" style="font-size:20px;">
                                            <label>Significant Trauma : auto accident , fall or other :</label>
                                            <textarea class="form-control mx-auto form_custom_input" style="max-width:85%" rows="3" id="trauma_pat" name="trauma_pat" autocomplete="off"><?php echo $trauma_pat?></textarea>
                                        </div>

                                        <div class="form-group row my-3 pb-4"
                                             style="border-bottom:3px solid black;border-color:#cc0000;font-size:20px;">
                                            <label>Allergies: drug, food or other:</label>
                                            <textarea class="form-control mx-auto form_custom_input" style="max-width:85%" rows="3" id="allergy_pat" name="allergy_pat" autocomplete="off"><?php echo $allergy_pat;?></textarea>
                                        </div>

                                        <div class="form-group row">
                                            <h3 class="px-2 py-2">Family Medical History</h3>
                                            <?php

                                                $fam_history_counter = 0;

                                                $select_db_fam_history_template="SELECT * FROM patient_history_templatefile ORDER BY disease ASC";
                                                $stmt_fam_history_template	= $link->prepare($select_db_fam_history_template);
                                                $stmt_fam_history_template->execute();

                                                echo "<table>";
                                                while($rs_fam_history_template = $stmt_fam_history_template->fetch()){

                                                    $fam_history_counter++;


                                                    if($fam_history_counter % 2 == 1) {
                                                        echo "<tr>";
                                                    }

                                                    $select_db_fam_history="SELECT * FROM fam_historyfile WHERE cuscde='".$cuscde."' AND disease='".$rs_fam_history_template['disease']."'";
                                                    $stmt_fam_history	= $link->prepare($select_db_fam_history);
                                                    $stmt_fam_history->execute();
                                                    $rs_fam_history = $stmt_fam_history->fetch();

                                                    $checked_fam = "";
                                                    if(!empty($rs_fam_history)){
                                                        $checked_fam = "checked";
                                                    }

                                                    echo "<td>

                                                        <div class='my-1 mx-2'>


                                                            <input class='form-check-input form_custom_input' type='hidden' name='fam_chk[".$rs_fam_history_template['disease']."]' value='0'>
                                                            <input class='form-check-input form_custom_input' type='checkbox' style='float:left;margin-right:10px'  id='fam_chk[".$rs_fam_history_template['disease']."]' name='fam_chk[".$rs_fam_history_template['disease']."]' value='1' ".$checked_fam.">

                                                            <label>
                                                                <b style='font-size:18px'>
                                                                    ".$rs_fam_history_template['disease']."
                                                                </b>
                                                            </label>

                                                        </div>
                                                    </td>";

                                                    if($fam_history_counter % 2 == 0) {
                                                        echo "</tr>";
                                                    }

                                                }
                                                if($fam_history_counter % 2 == 1) { // Used to prevent alignment issue while odd number of rows return
                                                    echo "<td></td></tr>";
                                                }
                                                echo"</table>";
                                            ?>
                                        </div>

                                        <div class="form-group row my-3" style="font-size:20px;">
                                            <label>Other Diseases:</label>
                                            <textarea class="form-control mx-auto form_custom_input" style="max-width:85%" rows="3" id="other_fam" name="other_fam" autocomplete="off"><?php echo $other_fam;?></textarea>
                                        </div>

                                    </div>

                                    <div id="tab_content_patientrecord" class="tabcontent">
                                    </div>

                                    <div id="tab_content_attachment" class="tabcontent">
                                    </div>
                            </div>
                        </div>
                    </div>

                </td>

            </tr>
        </table>

        <input type="hidden" name="cuscde_hidden" id="cuscde_hidden" value="<?php echo $cuscde; ?>">
        <input type="hidden" name="event_action" id="event_action" value="<?php echo $_POST['patient_event_action'];?>">
        <input type="hidden" name="event_action_save" class="" id="event_action_save" class="form_custom_input" value="<?php echo $_POST['patient_event_action'];?>">
        <input type="hidden" name="patient_name_hidden" id="patient_name_hidden" class="event_action_save" value="<?php echo $patient_name;?>">
        <input type="hidden" name="recid_hidden" id="recid_hidden" value="<?php echo $_POST['cus_recid_hidden'];?>">
        <input type='hidden' name='txt_pager_pageno_hidden' id='txt_pager_pageno_hidden' value="<?php echo $_POST['txt_pager_pageno_hidden'];?>">
        <input type='hidden' name='search_hidden_save_input' id='search_hidden_save_input' value="<?php echo $_POST['search_hidden_save_input'];?>">
        <input type='hidden' name='search_hidden_save_dd' id='search_hidden_save_dd' value="<?php echo $_POST['search_hidden_save_dd'];?>">
        <input type='hidden' name='search_current_dd' id='search_current_dd' value="<?php echo $_POST['search_dd'];?>">
        <input type='hidden' name='search_current_input' id='search_current_input' value="<?php echo $_POST['search_text_input'];?>">
        <input type='hidden' name='search_current_dd_datatype' id='search_current_dd_datatype' value="<?php echo $_POST['datatype_hidden'];?>">
        <input type='hidden' name='search_current_dd_field' id='search_current_dd_field' value="<?php echo $_POST['search_dd_field_hidden'];?>">
        <input type='hidden' name='search_current_dd_field_val' id='search_current_dd_field_val' value="<?php echo $_POST['search_dd_field_val_hidden'];?>">
        <input type='hidden' name='search_current_dd_table' id='search_current_dd_table' value="<?php echo $_POST['search_dd_table_hidden'];?>">
        <input type='hidden' name='search_event_action2' id='search_event_action2' value="<?php echo $_POST['search_event_action2'];?>">
        <input type='hidden' name='check_search' id='check_search' value="Y">
        
        <input type='hidden' name='event_save_hidden' id='event_save_hidden'>
    </form>


    <!-- PUT MODALS HERE -->
    <div class="modal fade" id="alert_modal" tabindex="-1"  aria-hidden='true' data-backdrop='false'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body alert_modal_body" id="alert_modal_body"></div>
            </div>
        </div>
    </div>


    <div class="modal fade fw-bold" id="pat_rec_modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pat_rec_modal_title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="pat_rec_modal_body">
                    <table class='table'>
                        <tr>
                            <td>
                                <span>Date Visit <span style='color:red'>*</span></span>

                                <div class='clearable-input'>
                                    <input type="text" class="form-control date_picker" date_picker_recipient="dp_date_of_visit" name="date_visit_modal" id="date_visit_modal" autocomplete="off" readonly>
                                </div>
                            </td>

                            <td>
                                <span>BP<input type="text"  name="bp_modal" id="bp_modal" class="form-control" autocomplete="off">
                            </td>

                            <td>
                                <span>
                                    Height

                                </span> <input type="text" name="height_modal" id="height_modal" class="form-control" autocomplete="off">
                            </td>

                            <td>
                                <span>Weight</span><input type="text"  name="weight_modal" id="weight_modal" class="form-control" autocomplete="off">
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                Complaint
                                <textarea rows="3" class="form-control"  name="complaint_modal" id="complaint_modal"></textarea>
                            </td>

                            <td colspan="2">
                                Diagnosis
                                <textarea rows="3" class="form-control"  name="diagnosis_modal" id="diagnosis_modal"></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4">
                                Accupuncture
                                <textarea rows="2" class="form-control"  name="accu_modal" id="accu_modal"></textarea>
                            </td>
                        </tr>

                        <tr>

                            <td colspan="2">
                                Herbs
                                <textarea rows="3" class="form-control"  name="herbs_modal" id="herbs_modal"></textarea>
                            </td>

                            <td colspan="2">
                                Medication
                                <textarea rows="3" class="form-control"  name="medication_modal" id="medication_modal"></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4">
                                Other Treatments
                                <textarea rows="2" class="form-control"  name="other_treat_modal" id="other_treat_modal"></textarea>
                            </td>
                        </tr>



                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <div id="pat_rec_modal_button"></div>
                </div>

                <input type="hidden" name="pat_rec_modal_recid_hidden" id="pat_rec_modal_recid_hidden">
            </div>
        </div>
    </div>

    <div class="modal fade" id="xfile_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-title-xfile"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            <div class="m-2">

                <div class="row">

                    <div class="col-7">
                        <label><b>File Select <span style='color:red'>*</span></b></label>
                        <div class="input-group xfile_input_group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary">
                                    Browse<input type="file" name="xfile" id="xfile" style="display: none;">
                                </span>
                            </label>
                            <input type="text" name="xfile_input" id="xfile_input" class="form-control input_xfile" readonly>
                        </div>
                    </div>

                    <div class="col-5">
                        <label>Date</label>
                        <input type="text" name="xfile_date" id="xfile_date" class="form-control date_picker" readonly>
                    </div>

                </div>




            </div>
                <div class="m-2">
                <label>Remarks</label>
                <textarea name="xfile_remarks" id="xfile_remarks" cols="30" rows="3" class="form-control"></textarea>
                </div>

                <div class="m-2">
                    <div class="error_msg_xfile" id="error_msg_xfile"></div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <span id="xfile_btns"></span>
            </div>
            </div>

            <input type="hidden" name="xfile_recid_hidden" id="xfile_recid_hidden">
        </div>
    </div>

    <div id="modal_view" class="modal_view">
        <!-- Modal content -->
        <div class="modal-content-view">
            <table style="width:100%;">
                <tr>
                    <td style="display:flex;justify-content:flex-end;align-items:center">
                        <input type='text' readonly id='txt_modal' class="form-control" style='border:none;width:300px;margin-right:auto'>
                        <?php
                                echo "&nbsp; &nbsp; <select name='sel_zoom' id='sel_zoom' onchange='zoom_change()' class='form-control' style='width:100px;margin-right:1rem'>";	
                                
                                $selected1="";
                                $selected2="";
                                $selected3="";
                                $selected4="";
                                $selected5="";
                                $selected6="";
                                $selected7="";
                                if (isset($_POST['sel_zoom'])==false)
                                {$selected3="selected";
                                }
                                else
                                {
                                    if ($_POST['sel_zoom']=='50%')
                                        {$selected1="selected";}
                                    elseif ($_POST['sel_zoom']=='75%')
                                        {$selected2="selected";}
                                    elseif ($_POST['sel_zoom']=='100%')
                                        {$selected3="selected";}
                                    elseif ($_POST['sel_zoom']=='125%')
                                        {$selected4="selected";}
                                    elseif ($_POST['sel_zoom']=='150%')
                                        {$selected5="selected";}	
                                    elseif ($_POST['sel_zoom']=='200%')
                                        {$selected6="selected";}
                                    elseif ($_POST['sel_zoom']=='original')
                                        {$selected7="selected";}
                                    
                                }
                                
                                
                                echo "<option ".$selected1.">50%</option>";
                                echo "<option ".$selected2.">75%</option>";
                                echo "<option ".$selected3.">100%</option>";
                                echo "<option ".$selected4.">125%</option>";
                                echo "<option ".$selected5.">150%</option>";
                                echo "<option ".$selected6.">200%</option>";
                                echo "<option ".$selected7.">original</option>";
                                
                                echo "</select>";
                        ?>		
                        <span class="close">&times;</span>
                    </td>
                </tr>



                                     
 

            </table>
            <table border=0 width='100%;' style="margin-top:10px">
                <tr style='width;100px;' >
                    
                    <td style='width;150px;' id='td_point' name='tr_point'></td>
                    <td>
                        <div name='div_view' id='div_view'  style='border:1px; top:50px; width:100%;  height:400px;box-shadow: 0px 0px 4px black;overflow: auto;' >

                            <?php
                            
                            echo "<img name='img_modal' id='img_modal' alt='no image' ";	
                            echo "style='width:100%;height: auto;'";
                            echo ">";
                            
                            ?>
                        </div>
                    
                    </td>
                </tr>
            </table>
        </div>      
    </div>

    <input type="hidden" name="xfile_hidden" id="xfile_hidden">


    <script>


            var cuscde = $("#cuscde_hidden").val();
            var xcheck_effect_pat_rec = true;
            var xcheck_effect_attach = true;


            function openCity(arr_header_id, cityName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(cityName).style.display = "block";
                $("#"+arr_header_id).addClass("active");
            }

            $(document).ready(function(){
                openCity('tab_header_generalinfo', 'tab_content_generalinfo');
            });

            // Get the modal
	        var modal = document.getElementById("modal_view");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            function view_click(ximage)
            {

                var x_extension =  ximage.split('.').pop();
                if(x_extension !== "png" && x_extension !== "jpg" && x_extension !== "gif"){
                    document.forms.myforms.method = "post";
                    document.forms.myforms.target = "_blank";
                    document.forms.myforms.action = "./file_upload/"+ximage;
                    document.forms.myforms.submit();

                    return;
                }

                //var xdisplay="images2/area/hehhe.png";
                 var xdisplay= ximage;
                //ximage="images2/area/"+abdomen.jpg;
                //alert(xdisplay);
                document.getElementById('txt_modal').value=xdisplay;
                document.getElementById('img_modal').src="file_upload/"+xdisplay;	
                modal.style.display = "block";
            }

            function zoom_change() {
	

        
                // var e = document.getElementById("sel_zoom");
                // var xzoom = e.options[e.selectedIndex].text;
                var xsrc = document.getElementById('img_modal').src;

                var xzoom = $("#sel_zoom").val();
                var xzoom = xzoom.replace("%", "");

                  var xval="action=zoom&sel_zoom="+xzoom+"&xsrc="+xsrc;
                  jQuery.ajax({
                          type: "POST",
                          url: "mf_points_view_ajax.php",
                          data: xval,
                          dataType: "json",
                          success: function(xdata) {1

                              //console.log(xdata)
                              document.getElementById('div_view').innerHTML = xdata;
                          }
                    });


            }





            $('#tab_header_patientrecord').click(function(){

                xdata = "event_action=view_pat_rec&cuscde="+cuscde;

                jQuery.ajax({
                    data:xdata,
                    dataType:"json",
                    type:"post",
                    url:"mf_patientfile_add_ajax.php",

                    success: function(xdata){

                        if(xcheck_effect_pat_rec == true){
                            $("#tab_content_attachment").hide();
                            $("#tab_content_patientrecord").hide().html(xdata["html"]).fadeIn(500);
                            xcheck_effect_pat_rec = false;
                        }else{
                            $("#tab_content_patientrecord").html(xdata["html"]);
                        }
                        $(".date_picker").datepicker({
                            showAnim: "blind",
                            changeMonth: true,
                            changeYear: true,
                            yearRange: "-100:+0",
                            showOn: 'focus',
                            showButtonPanel: true,
                            closeText: 'Clear', // Text to show for "close" button
                            beforeShow: function(el, dp) {

                                $(el).parent().append($('#ui-datepicker-div'));
                                $('#ui-datepicker-div').hide();
                            },
                            onClose: function () {
                                $(this).blur();
                                var event = arguments.callee.caller.caller.arguments[0];
                                var event_checker = false;
                                if(event){
                                    event_checker = event.hasOwnProperty('delegateTarget');
                                }
                                if(event_checker == true){
                                    if ($(event.delegateTarget).hasClass('ui-datepicker-close')) {
                                    $(this).val('');
                                    }
                                }

                            }

                        });
                        $("[date_picker_target]").click(function(){

                            var target_val = $(this).attr("date_picker_target");
                            $("[date_picker_recipient="+target_val+"]").val('');
                        });
                    }
                })
            });

            $("#tab_header_attachment").click(function(){

                xdata = "event_action=view_attach&cuscde="+cuscde;

                jQuery.ajax({
                    data:xdata,
                    dataType:"json",
                    type:"post",
                    url:"mf_patientfile_add_ajax.php",

                    success: function(xdata){

                        if(xcheck_effect_attach == true){
                            $("#tab_content_patientrecord").hide();
                            $("#tab_content_attachment").hide().html(xdata["html_attach"]).fadeIn(500);
                            xcheck_effect_attach = false;
                        }else{
                            $("#tab_content_attachment").html(xdata["html_attach"]);
                        }

                    }
                })
            });

            function save_patient(){


                var patient_name = $("#patient_name").val();
                var age          = $("#age").val();

                if(patient_name == "" || patient_name == null){


                    $("#alert_modal_body").html("Cannot save without Patient Name, please fill out");
                    $("#alert_modal").modal("show");

  
                    return;
                }

                if(isNaN(age)){

                    $("#alert_modal_body").html("Age must be a number, please enter a valid age");
                    $("#alert_modal").modal("show");

                    return;
                }

                var form_data = $("#myforms *").serialize()+"&age="+age;

                jQuery.ajax({

                    data:form_data,
                    dataType:"json",
                    type:"post",
                    url:"mf_patientfile_add_ajax.php",

                    success: function(xdata){

                        if(xdata["status"] == 1){
                            // $("#error_msg_span").html("");
                            // $("#alert_modal .modal-body").html(xdata["msg"]);
                            // $("#alert_modal").modal("show");
                            // $('#alert_modal').on('hidden.bs.modal', function () {

                                if(xdata["event_save_hidden"]== "add"){
                                    $("#event_save_hidden").val("add");
                                }

                                localStorage.setItem("ret_check", "Y");
                                localStorage.setItem("ret_check2", "Y");

                                document.forms.myforms.method = "post";
                                document.forms.myforms.target = "_self";
                                document.forms.myforms.action = "mf_patientfile.php";
                                document.forms.myforms.submit();
                            // });

                        }else{
                            $("#error_msg_span").html(" <div class='alert alert-danger' role='alert'>"+xdata["msg"]+"</div>")
                        }






                    }
                })
            }

            function back(){

                if (confirm('Are you sure to exit? Changes will not be saved')) {


                    localStorage.setItem("ret_check", "Y");
                    localStorage.setItem("ret_check2", "Y");

                    document.forms.myforms.method = "post";
                    document.forms.myforms.target = "_self";
                    document.forms.myforms.action = "mf_patientfile.php";
                    document.forms.myforms.submit();
                } else {

                }

            }

            function pat_rec_func(event ,recid){

                var patient_name = $("#patient_name").val();
                var age          = $("#age").val();

                switch(event){
                    case "open_add":

                        $('#pat_rec_modal').find('input:text').val('');
                        $('#pat_rec_modal').find('textarea').val('');

                        var d = new Date();
                        var month = d.getMonth()+1;
                        var day = d.getDate();

                        var output = (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day + '/' +  d.getFullYear();

                        $('#date_visit_modal').val(output);

                        $("#pat_rec_modal_title").html("Add Patient Record");
                        $("#pat_rec_modal_button").html("<button type='button' class='btn btn-primary' onclick=\"pat_rec_func('submit_add')\" data-bs-dismiss='modal'>Save</button>");
                        $("#pat_rec_modal").modal("show");
                        return;
                    break;

                    case "open_edit":

                        var xdata = "event_action=open_edit_pat_rec&recid="+recid+"&cuscde="+cuscde;

                        jQuery.ajax({

                            data:xdata,
                            dataType:"json",
                            type:"post",
                            url:"mf_patientfile_add_ajax.php",

                            success: function(xdata){

                                $("#date_visit_modal").val(xdata["visitdate"]);

                                $("#bp_modal").val(xdata["bp"]);
                                $("#height_modal").val(xdata["height"]);
                                $("#weight_modal").val(xdata["weight"]);
                                $("#complaint_modal").val(xdata["complaint"]);
                                $("#diagnosis_modal").val(xdata["diagnosis"]);
                                $("#medication_modal").val(xdata["medication"]);

                                $("#herbs_modal").val(xdata["herbs"]);
                                $("#other_treat_modal").val(xdata["other_treat"]);
                                $("#accu_modal").val(xdata["accu"]);

                                $("#pat_rec_modal_recid_hidden").val(xdata["recid"]);
                                $("#pat_rec_modal_title").html("Edit Patient Record");

                                $("#pat_rec_modal_button").html("<button type='button' class='btn btn-primary' onclick=\"pat_rec_func('submit_edit','"+recid+"')\" data-bs-dismiss='modal'>Save</button>");
                                $("#pat_rec_modal").modal("show");

                            }
                        })
                        return;
                        break;

                    case "submit_add":
                        var patient_name = $("#patient_name").val();
                        var age          = $("#age").val();

                        if(patient_name == "" || patient_name == null){

                            $("#alert_modal_body").html("Cannot save without Patient Name, please fill out");
                            $("#alert_modal").modal("show");

                            return;
                        }

                        if(isNaN(age)){

                            $("#alert_modal_body").html("Age must be a number, please enter a valid age");
                            $("#alert_modal").modal("show");

                            return;
                        }
                        var xdata = $("#pat_rec_modal *").serialize()+"&event_action=submit_add_pat_rec&cuscde="+cuscde;
                    break;

                    case "submit_edit":
                        var patient_name = $("#patient_name").val();
                        var age          = $("#age").val();

                        if(patient_name == "" || patient_name == null){

                            $("#alert_modal_body").html("Cannot save without Patient Name, please fill out");
                            $("#alert_modal").modal("show");

                            return;
                        }

                        if(isNaN(age)){

                            $("#alert_modal_body").html("Age must be a number, please enter a valid age");
                            $("#alert_modal").modal("show");

                            return;
                        }
                        var xdata = $("#pat_rec_modal *").serialize()+"&event_action=submit_edit_pat_rec&cuscde="+cuscde;
                    break;

                    case "submit_edit_pat_rec_cus":
                        var xdata = $("#pat_cus_div *").serialize()+"&event_action=submit_edit_pat_rec_cus&cuscde="+cuscde+"&pat_rec_modal_recid_hidden="+recid;
                    break;

                    case "delete":
                        var xdata = "event_action=delete_pat_rec&cuscde="+cuscde+"&recid="+recid;
                }

                var  top_header_patient = $(".top_header_patient *").serialize();
                var  generalinfo_patient = $("#tab_content_generalinfo *").serialize();
                var event_action_save = $("#event_action_save").val();
                var patient_name_hidden = $("#patient_name_hidden").val();
                var xdata =  xdata+"&"+top_header_patient+"&"+generalinfo_patient+"&event_action_save="+event_action_save+"&patient_name_hidden="+patient_name_hidden;
                


                jQuery.ajax({

                    data:xdata,
                    dataType:"json",
                    type:"post",
                    url:"mf_patientfile_add_ajax.php",

                    success: function(xdata){




                        if(xdata["status"] == 0){
                            $("#error_msg_span").html(" <div class='alert alert-danger' role='alert'>"+xdata["msg"]+"</div>");
                        }
                        else if(xdata["status"] == 1){

                            if(xdata["msg"] !=="" && xdata["msg"] !== null){
                                $("#error_msg_span").html(" <div class='alert alert-success' role='alert'>"+xdata["msg"]+"</div>");
                            }
                            $("#tab_content_patientrecord").html(xdata["html"]);
                        }


                        if(xdata["remarks"] == "edit_main"){
                            $("#event_action").val("edit_main");
                            $("#patient_name_hidden").val(xdata["patient_name"]);
                            $("#recid_hidden").val(xdata["recid"]);
                        }

                        if(xdata["event_save_hidden"]== "add"){
                            $("#event_save_hidden").val("add");
                        }


                        $( ".date_picker" ).datepicker({
                            showAnim: "blind",
                            changeMonth: true,
                            changeYear: true,
                            yearRange: "-100:+0",
                            showOn: 'focus',
                            showButtonPanel: true,
                            closeText: 'Clear', // Text to show for "close" button
                            beforeShow: function(el, dp) {

                                $(el).parent().append($('#ui-datepicker-div'));
                                $('#ui-datepicker-div').hide();
                            },
                            onClose: function () {
                                $(this).blur();
                                var event = arguments.callee.caller.caller.arguments[0];
                                var event_checker = false;
                                if(event){
                                    event_checker = event.hasOwnProperty('delegateTarget');
                                }
                                if(event_checker == true){
                                    if ($(event.delegateTarget).hasClass('ui-datepicker-close')) {
                                    $(this).val('');
                                    }
                                }

                            }
                        });




                    }
                })


            }

            var modal_xfile;

            function removeModal() {
                modal_xfile.remove();
                $('body').off('keyup.modal-close');
            }

            function show_image(ximage){

                var src = "file_upload/"+ximage;

                modal_xfile = $('<div>').css({
                    background: 'RGBA(0,0,0,.5) url("' + src + '") no-repeat center',
                    backgroundSize: 'contain',
                    width: '100%',
                    height: '100%',
                    position: 'fixed',
                    zIndex: '10000',
                    top: '0',
                    left: '0',
                    cursor: 'zoom-out'
                }).click(function() {
                    removeModal();
                }).appendTo('body');
                //handling ESC
                $('body').on('keyup.modal-close', function(e) {
                    if (e.key === 'Escape') {
                    removeModal();
                    }
                });
            }

            function attachment_func(event, recid){

                switch(event){

                    case "open_add":
                        $(".modal-title-xfile").html("Add File");
                        $(".input_xfile").val("");
                        $("#xfile_remarks").val("");
                        $("#xfile_btns").html("<button type='button' class='btn btn-primary' onclick=\"attachment_func('submit_add')\" data-bs-dismiss='modal'>Save</button>");

                        var today = new Date();
                        var dd = String(today.getDate()).padStart(2, '0');
                        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                        var yyyy = today.getFullYear();

                        today = mm + '/' + dd + '/' + yyyy;

                        $("#xfile_date").val(today);

                        $("#xfile").val(null);

                        $("#xfile_modal").modal("show");
                        return;

                        break;

                    case "getEdit":
                        $(".modal-title-xfile").html("Edit File");
                        $("#xfile_btns").html("<button type='button' class='btn btn-primary' onclick=\"attachment_func('submit_edit',"+recid+")\">Save</button>");
                        var xdata = new FormData();
                        xdata.append('event_action', 'getEdit_attach');
                        xdata.append('recid', recid);


                        break;

                    case "submit_add":

                        var patient_name = $("#patient_name").val();
                        var age          = $("#age").val();

                        if(patient_name == "" || patient_name == null){
                            $("#alert_modal_body").html("Cannot save without Patient Name, please fill out");
                            $("#alert_modal").modal("show");

                            return;
                        }

                        if(isNaN(age)){
                            $("#alert_modal_body").html("Age must be a number, please enter a valid age");
                            $("#alert_modal").modal("show");

                            return;
                        }


                        var xfile_input = $("#xfile_input").val();

                        if(document.getElementById("xfile").files.length == 0 || xfile_input == ""){
                            $("#xfile_modal").modal("hide");
                            $("#alert_modal_body").html("No file selected.");
                            $("#alert_modal").modal("show");
 
                            return
                        }

                        var xdata = new FormData();
                        var files = $('#xfile')[0].files;
                        var remarks =  $("#xfile_remarks").val();
                        var xfile_date = $("#xfile_date").val();
                        var recid_hidden = $("#recid_hidden").val();
                        var patient_name_hidden = $("#patient_name_hidden").val();
                        xdata.append('xfile',files[0]);
                        xdata.append('event_action', 'submit_add_attach');
                        xdata.append('cuscde', cuscde);
                        xdata.append('xfile_remarks', remarks);
                        xdata.append('trndte', xfile_date);
                        xdata.append('recid', recid_hidden);
                        xdata.append('patient_name_hidden', patient_name_hidden);



                        $(".top_header_patient .form_custom_input").each(function () {
                            xdata.append(this.name, this.value);
                        });

                        $("#tab_content_generalinfo .form_custom_input").each(function () {
                            xdata.append(this.name, this.value);
                        });



                        break;

                    case "submit_edit":

                        var patient_name = $("#patient_name").val();
                        var age          = $("#age").val();

                        if(patient_name == "" || patient_name == null){
                            $("#alert_modal_body").html("Cannot save without Patient Name, please fill out");
                            $("#alert_modal").modal("show");

                            return;
                        }

                        if(isNaN(age)){
                            $("#alert_modal_body").html("Age must be a number, please enter a valid age");
                            $("#alert_modal").modal("show");

                            return;
                        }

                        var xdata = new FormData();
                        var files = $('#xfile')[0].files;
                        var remarks =  $("#xfile_remarks").val();
                        var recid_hidden = $("#recid_hidden").val();
                        var xfile_date = $("#xfile_date").val();
                        var xfile_hidden = $("#xfile_hidden").val();
                        var xfile_recid_hidden  = $("#xfile_recid_hidden").val();
                        var patient_name_hidden = $("#patient_name_hidden").val();


                        var xfile_input = $("#xfile_input").val();

                        if(document.getElementById("xfile").files.length == 0 && xfile_input == ""){
                      
                            $("#xfile_modal").modal("hide");
                            $("#alert_modal_body").html("No file selected.");
                            $("#alert_modal").modal("show");
                            return
                        }

                        xdata.append('xfile',files[0]);
                        xdata.append('event_action', 'submit_edit_attach');
                        xdata.append('cuscde', cuscde);
                        xdata.append('xfile_remarks', remarks);
                        xdata.append('trndte', xfile_date);
                        xdata.append('xfile_hidden', xfile_hidden);
                        xdata.append('xfile_recid', xfile_recid_hidden);
                        xdata.append('recid', recid_hidden);
                        xdata.append('patient_name_hidden', patient_name_hidden);

                        $(".top_header_patient .form_custom_input").each(function () {
                            xdata.append(this.name, this.value);
                        });

                        $("#tab_content_generalinfo .form_custom_input").each(function () {
                            xdata.append(this.name, this.value);
                        });




                        break;

                    case "delete":
                        var xdata = new FormData();
                        xdata.append('event_action', 'delete_attach');
                        xdata.append('recid', recid);
                        xdata.append('cuscde', cuscde);

                        break;
                }

                jQuery.ajax({

                    data:xdata,
                    dataType:"json",
                    type:"post",
                    url:"mf_patientfile_add_ajax.php",
                    processData: false,
                    contentType: false,

                    success: function(xdata){

                        if(xdata["status"] == "clear"){
                            $("#error_msg_span").html("");
                            $("#xfile_modal").modal("hide");
                        }

                        else if(event == "getEdit"){

                            $(".input_xfile").val(xdata["xdata"]["filename"]);
                            $("#xfile_hidden").val(xdata["xdata"]["filename"]);
                            $("#xfile_remarks").val(xdata["xdata"]["remarks"]);
                            $("#xfile_date").val(xdata["xdata"]["trndte"]);
                            $("#xfile_recid_hidden").val(xdata["xdata"]["recid"]);
                            $("#xfile").val(null);
                            $("#xfile_modal").modal("show");

                        }
                        else if(xdata["status"] == 0 && xdata["xtype"]!== "xfile"){
                            $("#error_msg_span").html("<div class='alert alert-danger' role='alert'>"+xdata["msg"]+"</div>");
                            $("#xfile_modal").modal("hide");
                        }
                        else if(xdata["status"] == 1 && xdata["xtype"]!== "xfile"){

                            if(xdata["msg"] !=="" && xdata["msg"] !== null){
                                $("#error_msg_span").html(" <div class='alert alert-success' role='alert'>"+xdata["msg"]+"</div>");
                            }
                            $("#tab_content_attachment").html(xdata["html_attach"]);
                            $("#xfile_modal").modal("hide");

                        }else{
                            $("#error_msg_span").html("");
                            $("#tab_content_attachment").html(xdata["html_attach"]);
                            $("#xfile_modal").modal("hide");
                        }

                        if(xdata["remarks"] == "edit_main"){
                            $("#event_action").val("edit_main");
                            $("#patient_name_hidden").val(xdata["patient_name"]);
                            $("#recid_hidden").val(xdata["recid"]);
                        }


                        if(xdata["event_save_hidden"]== "add"){
                            $("#event_save_hidden").val("add");
                        }
                    }
                })
            }


            $(document).on('change', ':file', function() {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
            });

            $(document).ready( function() {
                $(':file').on('fileselect', function(event, numFiles, label) {

                    var input = $(this).parents('.xfile_input_group').find(':text'),
                        log = numFiles > 1 ? numFiles + ' files selected' : label;

                    if( input.length ) {
                        input.val(log);
                    } else {
                        // if( log ) alert(log);
                    }

                });
            });

            var age_calc = "";
            $('#date_of_birth').datepicker({
                onSelect: function(value, ui) {
                    var today = new Date();
                    age_calc = today.getFullYear() - ui.selectedYear;
                    $('#age').val(age_calc);
                },
                showAnim: "blind",
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0",
                showOn: 'focus',
                showButtonPanel: true,
                closeText: 'Clear', // Text to show for "close" button
                beforeShow: function(el, dp) {

                    $(el).parent().append($('#ui-datepicker-div'));
                    $('#ui-datepicker-div').hide();
                },
                onClose: function () {
                    $(this).blur();
                    var event = arguments.callee.caller.caller.arguments[0];
                    var event_checker = false;
                    if(event){
                        event_checker = event.hasOwnProperty('delegateTarget');
                    }
                    if(event_checker == true){
                        if ($(event.delegateTarget).hasClass('ui-datepicker-close')) {
                        $(this).val('');
                        }
                    }

                    if(this.value == ""){
                        $("#age").val("");
                    }

                }
            })


            $('#pat_rec_modal').on('hidden.bs.modal', function () {
                $(".date_picker").datepicker({
                    showAnim: "blind",
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "-100:+0",
                    showOn: 'focus',
                    showButtonPanel: true,
                    closeText: 'Clear', // Text to show for "close" button
                    beforeShow: function(el, dp) {

                        $(el).parent().append($('#ui-datepicker-div'));
                        $('#ui-datepicker-div').hide();

                    } ,
                    onClose: function () {
                        $(this).blur();
                        var event = arguments.callee.caller.caller.arguments[0];
                        var event_checker = false;
                        if(event){
                            event_checker = event.hasOwnProperty('delegateTarget');
                        }
                        if(event_checker == true){
                            if ($(event.delegateTarget).hasClass('ui-datepicker-close')) {
                            $(this).val('');
                            }
                        }

                    },
                }); 
            });



    </script>



<?php
include "includes/main_footer.php";
?>

