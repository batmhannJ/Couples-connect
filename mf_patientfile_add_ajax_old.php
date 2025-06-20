<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

session_start();
require "resources/db_init.php";
require "resources/connect4.php";
require_once("resources/lx2.pdodb.php");
require_once("resources/stdfunc100.php");


    $xret = array();
    $xret["status"] = 1;
    $xret["type"] = "";
    $xret["remarks"] = "";
    $xret["patient_name"] = "";
    $xret["recid"] = "";
    $xret["msg"] = "";
    $xret["event_save_hidden"] = "";


    $xerror = array();
    $xerror["error1"] = "";
    $xerror["error2"] = "";
    $xerror["error3"] = "";
    $xerror["error4"] = "";

    if(isset($_POST["inactive"])){
        $inactive = 1;
    }else{
        $inactive = 0;
    }

    if($_POST["event_action"] == "add_main"){
        $xret["type"] = "add_main";
    }else if($_POST["event_action"] == "edit_main"){
        $xret["type"] = "edit_main";
    }



    if($_POST["event_action"] == "add_main" || $_POST["event_action"] == "edit_main"){

        $select_cusdsc="SELECT cusdsc FROM patientfile WHERE cusdsc=?";
        $stmt_cusdsc	= $link->prepare($select_cusdsc);
        $stmt_cusdsc->execute(array($_POST["patient_name"]));
        $rs_cusdsc = $stmt_cusdsc->fetch();

        if($_POST["event_action"] == "add_main"){
            if(!empty($rs_cusdsc)){
                $xret["status"] = 0;
                $xret["msg"] = "Patient Name in use, please use another one";
                $xerror["error1"] = 1;
            }
        }else if($_POST["event_action"] == "edit_main"){
            if($_POST["patient_name"] !== $_POST["patient_name_hidden"]){
                if(!empty($rs_cusdsc)){
                    $xret["status"] = 0;
                    $xret["msg"] = "Patient Name in use, please use another one";
                    $xerror["error1"] = 1;
                }
            }
        }

        if($xret["status"] == 1){

            $arr_record = array();
            $arr_record['cuscde']           = $_POST["cuscde_hidden"];
            $arr_record['cusdsc']           = $_POST["patient_name"];
            $arr_record['birthday']         = $_POST["date_of_birth"]  = (empty($_POST["date_of_birth"]))   ? NULL :  date("Y-m-d", strtotime($_POST["date_of_birth"]));
            $arr_record['age']              = $_POST["age"];
            $arr_record['bloodtypecde']     = $_POST["bloodtype"];
            $arr_record['address']          = $_POST["address"];
            $arr_record['office_telno']     = $_POST["office_telno"];
            $arr_record['tin_num']          = $_POST["tin"];
            $arr_record['contact_person']   = $_POST["contact_person"];
            $arr_record['remarks']          = $_POST["remarks"];
            // $arr_record['prccde']           = $_POST["price_list"];
            $arr_record['home_telno']       = $_POST["home_telno"];
            $arr_record['mobile_no']        = $_POST["mobile_no"];
            $arr_record['gender']        = $_POST["gender"];
            $arr_record['fax']              = $_POST["fax"];
            $arr_record['email']            = $_POST["email"];
            $arr_record['inactive_chk']     = $inactive;
            $arr_record['other_pat']        = $_POST["other_pat"];
            $arr_record['surgery_pat']      = $_POST["surgery_pat"];
            $arr_record['trauma_pat']       = $_POST["trauma_pat"];
            $arr_record['allergy_pat']      = $_POST["allergy_pat"];
            $arr_record['other_fam']        = $_POST["other_fam"];
            $arr_record['adddte']           = $_POST["adddte"]  = (empty($_POST["adddte"]))   ? NULL :  date("Y-m-d", strtotime($_POST["adddte"]));

            if($_POST["event_action"] == "add_main"){
                PDO_InsertRecord($link,'patientfile',$arr_record, false);
                $xret["query_test"] =  "";

                $query   =  "SELECT count(*) as xcount FROM patientfile WHERE ".$_POST['search_current_dd']."    <=   '" . $arr_record[$_POST['search_current_dd']]."'";
                $stmt	= $link->prepare($query);
                $stmt->execute();
                while($rs = $stmt->fetch()){
                    $xcount =   $rs["xcount"];
                }

                $xret["xcount_test"] =   "";      
                $xret["xcount_test"] =   $xcount;      

                $new_pageno =   intval($xcount/$_POST["pager_xlimit2"]) + 1;

                $xret["query_test"] =   $query;
                $xret["new_pageno"] =   "";                
                $xret["new_pageno"] =   $new_pageno;

                // $xret["new_offset"] =   "";                
                // $xret["new_offset"] =   $xcount - 1;

                // if($xret["new_offset"] < 0 ){
                //     $xret["new_offset"] =  0;
                // }

                $xret["event_save_hidden"] = "add";

            }else if($_POST["event_action"] == "edit_main"){
                PDO_UpdateRecord($link,"patientfile",$arr_record,"recid = ?",array($_POST['recid_hidden']),false);  
                $xret["new_pageno"] =   $_POST["txt_pager_pageno_hidden"];
            }

            foreach($_POST["patient_chk"] as $key => $value){

                if($value == 1){

                    $arr_record_patient_chk = array();
                    $arr_record_patient_chk["cuscde"] = $_POST["cuscde_hidden"];
                    $arr_record_patient_chk["disease"] = $key;

                    if($_POST["event_action"] == "edit_main"){
                        $select_patient_chk ='SELECT * FROM patient_historyfile WHERE cuscde=? AND disease=?';
                        $stmt_patient_chk	= $link->prepare($select_patient_chk);
                        $stmt_patient_chk->execute(array($_POST["cuscde_hidden"],$key));
                        $rs_patient_chk = $stmt_patient_chk->fetch();

                        if(empty($rs_patient_chk)){
                            PDO_InsertRecord($link,'patient_historyfile',$arr_record_patient_chk, false);    
                        }
                    }else{
                        PDO_InsertRecord($link,'patient_historyfile',$arr_record_patient_chk, false);    
                    }
        
                }

                if($value == 0 && $_POST["event_action"] == "edit_main"){
        
                    $delete_patient_chk="DELETE FROM patient_historyfile WHERE cuscde=? AND disease=?";
                    $stmt_patient_chk=$link->prepare($delete_patient_chk);
                    $stmt_patient_chk->execute(array($_POST["cuscde_hidden"],$key));
                }

            }

            foreach($_POST["fam_chk"] as $key => $value){

                if($value == 1){
                    $arr_record_fam_chk = array();
                    $arr_record_fam_chk["cuscde"] = $_POST["cuscde_hidden"];
                    $arr_record_fam_chk["disease"] = $key;

                    if($_POST["event_action"] == "edit_main"){
                        $select_fam_chk ='SELECT * FROM fam_historyfile WHERE cuscde=? AND disease=?';
                        $stmt_fam_chk	= $link->prepare($select_fam_chk);
                        $stmt_fam_chk->execute(array($_POST["cuscde_hidden"],$key));
                        $rs_fam_chk = $stmt_fam_chk->fetch();

                        if(empty($rs_fam_chk)){
                            PDO_InsertRecord($link,'fam_historyfile',$arr_record_fam_chk, false);    
                        }
                    }else{
                        PDO_InsertRecord($link,'fam_historyfile',$arr_record_fam_chk, false);    
                    }

                }

                if($value == 0 && $_POST["event_action"] == "edit_main"){
        
                    $delete_fam_chk="DELETE FROM fam_historyfile WHERE cuscde=? AND disease=?";
                    $stmt_fam_chk=$link->prepare($delete_fam_chk);
                    $stmt_fam_chk->execute(array($_POST["cuscde_hidden"],$key));
                }

            }

            

            if($_POST["event_action"] == "add_main"){
                $xret["msg"] = "Successfully added record.";
            }else if($_POST["event_action"] == "edit_main"){
                $xret["patient_name_hidden"] = $_POST["patient_name"];
                $xret["msg"] = "Successfully updated record.";

            }
            
        }
    }
    else if($_POST["event_action"] == "view_pat_rec" || 
            $_POST["event_action"] == "submit_add_pat_rec" || 
            $_POST["event_action"] == "submit_edit_pat_rec" ||
            $_POST["event_action"] == "submit_edit_pat_rec_cus" ||
            $_POST["event_action"] == "delete_pat_rec" 
    ){


        if($_POST["event_action"] == "submit_add_pat_rec" || $_POST["event_action"] == "submit_edit_pat_rec" || $_POST["event_action"] == "submit_edit_pat_rec_cus"){

            if($_POST["event_action"] == "submit_edit_pat_rec_cus"){
                $date_visit = $_POST["visit_date_cus"];
                $height = $_POST["height_cus"];
                $weight = $_POST["weight_cus"];
                $bp = $_POST["bp_cus"];
                $complaint = $_POST["complaint_cus"];
                $diagnosis = $_POST["diagnosis_cus"];
                $medication = $_POST["medication_cus"];
                $herbs = $_POST["herbs_cus"];
                $other_treat = $_POST["other_treat_cus"];
                $accu = $_POST["accu_cus"];

            }else{
                $date_visit = $_POST["date_visit_modal"];
                $height = $_POST["height_modal"];
                $weight = $_POST["weight_modal"];
                $bp = $_POST["bp_modal"];
                $complaint = $_POST["complaint_modal"];
                $diagnosis = $_POST["diagnosis_modal"];
                $medication = $_POST["medication_modal"];          
                $herbs = $_POST["herbs_modal"];
                $other_treat = $_POST["other_treat_modal"];
                $accu = $_POST["accu_modal"];
            }


            if(!isset($date_visit) || empty($date_visit)){

                if($xerror["error1"] == true || $xerror["error2"] == true ){
                    $xret["msg"] .= "</br> Visit Date cannot be empty.";
                }else{
                    $xret["msg"] = "Visit Date cannot be empty.";   
                }
    
                $xret["status"] = 0;
                $xret["msg"] = "Date Visit cannot be empty.";
                $xerror["error1"] = true;
            }   
    
            // if(!isset($bp) || empty($bp)){
    
            //     if($xerror["error1"] == true || $xerror["error2"] == true){
            //         $xret["msg"] .= "</br> BP cannot be empty.";
            //     }else{
            //         $xret["msg"] = "BP cannot be empty.";   
            //     }
                
            //     $xret["status"] = 0;
            //     $xerror["error2"] = true;
            // }

            if(($_POST["event_action"] == "submit_add_pat_rec" || $_POST["event_action"] == "submit_edit_pat_rec" || $_POST["event_action"] == "submit_edit_pat_rec_cus") &&  $xret["status"] == 1){

                $arr_rec_pat = array();
                $arr_rec_pat['cuscde'] 	        = $_POST["cuscde"];
                $arr_rec_pat['visitdate'] 	    = $date_visit  = (empty($date_visit))   ? NULL :  date("Y-m-d", strtotime($date_visit));
                $arr_rec_pat['height'] 	        = $height;
                $arr_rec_pat['weight'] 	        = $weight;
                $arr_rec_pat['bloodpressure'] 	= $bp;
                $arr_rec_pat['complaint'] 	    = $complaint = (isset($complaint))   ? $complaint :  '';
                $arr_rec_pat['diagnosis'] 	    = $diagnosis = (isset($diagnosis))   ? $diagnosis :  '';
                $arr_rec_pat['medication'] 	    = $medication = (isset($medication))   ? $medication : '';
                $arr_rec_pat['herbs'] 	        = $herbs = (isset($herbs))   ? $herbs : '';
                $arr_rec_pat['other_treatment'] = $other_treat = (isset($other_treat))   ? $other_treat : '';
                $arr_rec_pat['accupuncture'] 	= $accu = (isset($accu))   ? $accu : '';
    
                if($_POST["event_action"] == "submit_add_pat_rec"){

                    $select_db_pat_ret_chk="SELECT * FROM patientfile WHERE cuscde=? ";
                    $stmt_pat_ret_chk	= $link->prepare($select_db_pat_ret_chk);
                    $stmt_pat_ret_chk->execute(array($_POST["cuscde"]));
                    $rs_pat_ret_chk = $stmt_pat_ret_chk->fetch();

                    if(empty($rs_pat_ret_chk)){

                        $select_cusdsc="SELECT cusdsc FROM patientfile WHERE cusdsc=?";
                        $stmt_cusdsc	= $link->prepare($select_cusdsc);
                        $stmt_cusdsc->execute(array($_POST["patient_name"]));
                        $rs_cusdsc = $stmt_cusdsc->fetch();
          
                        if(!empty($rs_cusdsc)){
                            $xret["status"] = 0;
                            $xret["msg"] = "Patient Name in use, please use another one";
                            $xerror["error1"] = 1;
                        }else{
                            $arr_record = array();
                            $arr_record['cuscde']           = $_POST["cuscde"];
                            $arr_record['cusdsc']           = $_POST["patient_name"];
                            $arr_record['birthday']         = $_POST["date_of_birth"]  = (empty($_POST["date_of_birth"]))   ? NULL :  date("Y-m-d", strtotime($_POST["date_of_birth"]));
                            $arr_record['age']              = $_POST["age"];
                            $arr_record['bloodtypecde']     = $_POST["bloodtype"];
                            $arr_record['address']          = $_POST["address"];
                            $arr_record['office_telno']     = $_POST["office_telno"];
                            $arr_record['tin_num']          = $_POST["tin"];
                            $arr_record['contact_person']   = $_POST["contact_person"];
                            $arr_record['remarks']          = $_POST["remarks"];
                            // $arr_record['prccde']           = $_POST["price_list"];
                            $arr_record['home_telno']       = $_POST["home_telno"];
                            $arr_record['mobile_no']        = $_POST["mobile_no"];
                            $arr_record['fax']              = $_POST["fax"];
                            $arr_record['email']            = $_POST["email"];
                            $arr_record['inactive_chk']     = $inactive;
                            $arr_record['other_pat']        = $_POST["other_pat"];
                            $arr_record['surgery_pat']      = $_POST["surgery_pat"];
                            $arr_record['trauma_pat']       = $_POST["trauma_pat"];
                            $arr_record['allergy_pat']      = $_POST["allergy_pat"];
                            $arr_record['other_fam']        = $_POST["other_fam"];
                            $arr_record['gender']           = $_POST["gender"];
                            $arr_record['adddte']           = $_POST["adddte"]  = (empty($_POST["adddte"]))   ? NULL :  date("Y-m-d", strtotime($_POST["adddte"]));
                            PDO_InsertRecord($link,'patientfile',$arr_record, false);
                            $xret["event_save_hidden"] = "add";

                            foreach($_POST["patient_chk"] as $key => $value){
    
                                if($value == 1){
                
                                    $arr_record_patient_chk = array();
                                    $arr_record_patient_chk["cuscde"] = $_POST["cuscde"];
                                    $arr_record_patient_chk["disease"] = $key;
                
                                    if($_POST["event_action"] == "edit_main"){
                                        $select_patient_chk ='SELECT * FROM patient_historyfile WHERE cuscde=? AND disease=?';
                                        $stmt_patient_chk	= $link->prepare($select_patient_chk);
                                        $stmt_patient_chk->execute(array($_POST["cuscde"],$key));
                                        $rs_patient_chk = $stmt_patient_chk->fetch();
                
                                        if(empty($rs_patient_chk)){
                                            PDO_InsertRecord($link,'patient_historyfile',$arr_record_patient_chk, false);    
                                        }
                                    }else{
                                        PDO_InsertRecord($link,'patient_historyfile',$arr_record_patient_chk, false);    
                                    }
                        
                                }
                
                                if($value == 0 && $_POST["event_action"] == "edit_main"){
                        
                                    $delete_patient_chk="DELETE FROM patient_historyfile WHERE cuscde=? AND disease=?";
                                    $stmt_patient_chk=$link->prepare($delete_patient_chk);
                                    $stmt_patient_chk->execute(array($_POST["cuscde"],$key));
                                }
                
                            }
                
                            foreach($_POST["fam_chk"] as $key => $value){
                
                                if($value == 1){
                                    $arr_record_fam_chk = array();
                                    $arr_record_fam_chk["cuscde"] = $_POST["cuscde"];
                                    $arr_record_fam_chk["disease"] = $key;
                
                                    if($_POST["event_action"] == "edit_main"){
                                        $select_fam_chk ='SELECT * FROM fam_historyfile WHERE cuscde=? AND disease=?';
                                        $stmt_fam_chk	= $link->prepare($select_fam_chk);
                                        $stmt_fam_chk->execute(array($_POST["cuscde"],$key));
                                        $rs_fam_chk = $stmt_fam_chk->fetch();
                
                                        if(empty($rs_fam_chk)){
                                            PDO_InsertRecord($link,'fam_historyfile',$arr_record_fam_chk, false);    
                                        }
                                    }else{
                                        PDO_InsertRecord($link,'fam_historyfile',$arr_record_fam_chk, false);    
                                    }
                
                                }
                
                                if($value == 0 && $_POST["event_action"] == "edit_main"){
                        
                                    $delete_fam_chk="DELETE FROM fam_historyfile WHERE cuscde=? AND disease=?";
                                    $stmt_fam_chk=$link->prepare($delete_fam_chk);
                                    $stmt_fam_chk->execute(array($_POST["cuscde"],$key));
                                }
                
                            }
    
                            PDO_InsertRecord($link,'patientfile_patientrecord',$arr_rec_pat, false);


                            $select_cusdsc="SELECT recid FROM patientfile WHERE cusdsc=?";
                            $stmt_cusdsc	= $link->prepare($select_cusdsc);
                            $stmt_cusdsc->execute(array($_POST["patient_name"]));
                            $rs_cusdsc = $stmt_cusdsc->fetch();
    
                            $xret["msg"] = "Successfully added record in <b>Patient Record</b>";  
                            $xret["remarks"] = "edit_main";
                            $xret["patient_name"] = $_POST["patient_name"];
                            $xret["recid"] = $rs_cusdsc["recid"];
                        }


                    }else{
                        PDO_InsertRecord($link,'patientfile_patientrecord',$arr_rec_pat, false);
                        $xret["msg"] = "Successfully added record in <b>Patient Record</b>"; 
                    }

  
    
                }else if($_POST["event_action"] == "submit_edit_pat_rec" || $_POST["event_action"] == "submit_edit_pat_rec_cus"){
                    PDO_UpdateRecord($link,"patientfile_patientrecord",$arr_rec_pat,"recid = ?",array($_POST["pat_rec_modal_recid_hidden"]), false);   
                    $xret["msg"] = "Successfully edited record in <b> Patient Record</b>";
    
                }
                
            }

        }

        if($_POST["event_action"] == "delete_pat_rec"){
            
            $delete_query="DELETE  FROM patientfile_patientrecord WHERE recid=?";
            $stmt=$link->prepare($delete_query);
            $stmt->execute(array($_POST["recid"]));

            $xret["status"] = 1;
            $xret["msg"] = "Successfully deleted a record in <b>Patient Record</b>";
        }

        $select_db_cus_rec="SELECT * FROM patientfile_patientrecord WHERE cuscde=? ORDER BY recid DESC LIMIT 1";
        $stmt_cus_rec	= $link->prepare($select_db_cus_rec);
        $stmt_cus_rec->execute(array($_POST["cuscde"]));
        $rs_cus_rec = $stmt_cus_rec->fetch();

        if(empty($rs_cus_rec)){

            $rs_cus_rec_visitdate = '';
            $rs_cus_rec_height = '';
            $rs_cus_rec_weight = '';
            $rs_cus_rec_bp = '';
            $rs_cus_rec_complaint = '';
            $rs_cus_rec_diagnosis = '';
            $rs_cus_rec_medication = '';
            $rs_cus_rec_herbs = '';
            $rs_cus_rec_other_treat = '';
            $rs_cus_rec_accu = '';
            $recid = '';

        }else{

            if(!empty($rs_cus_rec['visitdate']) && $rs_cus_rec['visitdate'] !== NULL &&  $rs_cus_rec['visitdate']!=="1970-01-01"){
                $rs_cus_rec['visitdate'] = date("m-d-Y",strtotime($rs_cus_rec['visitdate']));
                $rs_cus_rec['visitdate'] = str_replace('-','/',$rs_cus_rec['visitdate']);
            }else{
                $rs_cus_rec['visitdate'] = NULL;
            }

            $rs_cus_rec_visitdate = $rs_cus_rec['visitdate'];
            $rs_cus_rec_height = $rs_cus_rec['height'];
            $rs_cus_rec_weight = $rs_cus_rec['weight'];
            $rs_cus_rec_bp = $rs_cus_rec['bloodpressure'];  
            $rs_cus_rec_complaint = $rs_cus_rec['complaint'];
            $rs_cus_rec_diagnosis = $rs_cus_rec['diagnosis'];
            $rs_cus_rec_medication = $rs_cus_rec['medication'];
            $rs_cus_rec_herbs = $rs_cus_rec['herbs'];
            $rs_cus_rec_other_treat = $rs_cus_rec['other_treatment'];
            $rs_cus_rec_accu = $rs_cus_rec['accupuncture'];
            $recid = $rs_cus_rec['recid'];
            
        }
        

        $xret["html"] = "";

        $xret["html"] = "<button type='button' class='btn btn-success my-2 me-auto' value='Add Record' onclick=\"pat_rec_func('open_add')\">
            <i class='fas fa-plus'></i>
            <span>Add record</span> 
        </button>";

        
        if(!empty($rs_cus_rec)){
            $xret["html"].="<div id='pat_cus_div'>
                <div>
                    <div class='form-group row my-2 d-flex align-items-center' style='background-color:#cccccc'>
                        <label class='col-1 col-form-label'><b>Date Visit:</b></label>
                        <div class='col-2 my-2'>
                            <div class='clearable-input'>
                                <input 
                                    type='text' 
                                    class='form-control date_picker' 
                                    date_picker_recipient='dp_date_of_visit_cus_pat'
                                    autocomplete='off' 
                                    id='visit_date_cus'
                                    name='visit_date_cus'
                                    value='".$rs_cus_rec_visitdate."'
                                    readonly>
                                <span class='clear_date_btn' date_picker_target='dp_date_of_visit_cus_pat'>&times;</span>
                            </div>  
                        </div>

                        <label class='col-1 col-form-label'><b>BP:</b></label>
                        <div class='col-2'>
                            <input type='email' class='form-control' id='bp_cus' name='bp_cus' value='".$rs_cus_rec_bp."'>
                        </div>

                        <label class='col-1 col-form-label'><b>Height:</b></label>
                        <div class='col-2'>
                            <input type='email' class='form-control' id='height_cus' name='height_cus' value='".$rs_cus_rec_height."'>
                        </div>

                        <label class='col-1 col-form-label'><b>Weight:</b></label>
                        <div class='col-2'>
                            <input type='email' class='form-control' id='weight_cus' name='weight_cus' value='".$rs_cus_rec_weight."'>
                        </div>



                    </div>
                </div>";

                $xret["html"].="<div class='form-group row my-3'>
                    <label><b>Complaint:</b></label>  
                    <textarea class='form-control mx-auto' style='max-width:85%' rows='2' id='complaint_cus' name='complaint_cus' autocomplete='off'>".$rs_cus_rec_complaint."</textarea>
                </div>

                <div class='form-group row my-3'>
                    <label><b>Diagnosis:</b></label>  
                    <textarea class='form-control mx-auto' style='max-width:85%' rows='2' id='diagnosis_cus' name='diagnosis_cus' autocomplete='off'>".$rs_cus_rec_diagnosis."</textarea>
                </div>

                <div class='form-group row my-3'>
                    <label><b>Accunpuncture:</b></label>  
                    <textarea class='form-control mx-auto' style='max-width:85%' rows='2' id='accu_cus' name='accu_cus' autocomplete='off'>".$rs_cus_rec_accu."</textarea>
                </div>

                <div class='form-group row my-3'>
                    <label><b>Herbs:</b></label>  
                    <textarea class='form-control mx-auto' style='max-width:85%' rows='2' id='herbs_cus' name='herbs_cus' autocomplete='off'>".$rs_cus_rec_herbs."</textarea>
                </div>

                <div class='form-group row my-3'>
                    <label><b>Medication:</b></label>  
                    <textarea class='form-control mx-auto' style='max-width:85%' rows='2' id='medication_cus' name='medication_cus' autocomplete='off'>".$rs_cus_rec_medication."</textarea>
                </div>

                <div class='form-group row my-3'>
                    <label><b>Other Treatments:</b></label>  
                    <textarea class='form-control mx-auto' style='max-width:85%' rows='2' id='other_treat_cus' name='other_treat_cus' autocomplete='off'>".$rs_cus_rec_other_treat."</textarea>
                </div>";

                $xret["html"] .= "<div class='pb-4' style='border-bottom:3px solid black;border-color:#cc0000;font-size:20px;'>
                    <input type='button' class='btn btn-success my-2 me-auto' value='Save' onclick=\"pat_rec_func('submit_edit_pat_rec_cus','".$recid."')\">
                    <input type='button' class='btn btn-danger my-2 me-auto' value='Delete' onclick=\"pat_rec_func('delete','".$recid."')\">
                </div>";
            $xret["html"] .="</div>";
        }






        $xret["html"].= "<table class='table' style='border-collapse:collapse'>";

            //header
            $xret["html"].= "<tr>";
                $xret["html"].= "<th style='border-right:2px solid #e6e6e6'>";
                    $xret["html"].= "Visit Date";
                $xret["html"].= "</th>";                

                $xret["html"].= "<th style='border-right:2px solid #e6e6e6'>";
                    $xret["html"].= "Height";
                $xret["html"].= "</th>";

                $xret["html"].= "<th style='border-right:2px solid #e6e6e6'>";                   
                    $xret["html"].= "Weight";
                $xret["html"].= "</th>";

                $xret["html"].= "<th style='border-right:2px solid #e6e6e6'>";                    
                    $xret["html"].= "BP";
                $xret["html"].= "</th>";

                $xret["html"].= "<th style='border-right:2px solid #e6e6e6'>";                    
                    $xret["html"].= "Complaint";
                $xret["html"].= "</th>";

                $xret["html"].= "<th class='text-center'>";
                    $xret["html"].= "Diagnosis";
                $xret["html"].= "</th>";        
                
            $xret["html"].="</tr>";

            $xret["html"].= "<tr>";
                $xret["html"].= "<th style='border-right:2px solid #e6e6e6'>";
                    $xret["html"].= "Medication";
                $xret["html"].= "</th>";                

                $xret["html"].= "<th style='border-right:2px solid #e6e6e6'>";
                    $xret["html"].= "Herbs";
                $xret["html"].= "</th>";

                $xret["html"].= "<th style='border-right:2px solid #e6e6e6'>";                   
                    $xret["html"].= "Other Treatments";
                $xret["html"].= "</th>";

                $xret["html"].= "<th style='border-right:2px solid #e6e6e6'>";                    
                    $xret["html"].= "Accupuncture";
                $xret["html"].= "</th>";

                $xret["html"].= "<th class='text-center' colspan='2'>";
                    $xret["html"].= "Action";
                $xret["html"].= "</th>";        
            $xret["html"].="</tr>";

            
        $select_db_view_rec="SELECT * FROM patientfile_patientrecord WHERE cuscde=? ORDER BY recid DESC LIMIT 100000000 OFFSET 1";
        $stmt_view_rec	= $link->prepare($select_db_view_rec);
        $stmt_view_rec->execute(array($_POST["cuscde"]));
        while($rs_view_rec= $stmt_view_rec->fetch()){


            if(!empty($rs_view_rec["visitdate"]) && $rs_view_rec["visitdate"] !== NULL &&  $rs_view_rec["visitdate"]!=="1970-01-01"){
                $rs_view_rec["visitdate"] = date("m-d-Y",strtotime($rs_view_rec["visitdate"]));
                $rs_view_rec["visitdate"] = str_replace('-','/',$rs_view_rec["visitdate"]);
            }else{
                $rs_view_rec["visitdate"] = NULL;
            }

            $xret["html"].="<tbody class='tbody_pat_rec_view' style='border-bottom:2px solid black'>";
                $xret["html"].= "<tr style='border:none'>";
                    $xret["html"].= "<td style='border:none'>";
                        $xret["html"].= $rs_view_rec["visitdate"];
                    $xret["html"].= "</td>";                

                    $xret["html"].= "<td style='border:none'>";
                        $xret["html"].= $rs_view_rec["height"];
                    $xret["html"].= "</td>";

                    $xret["html"].= "<td style='border:none'>";                   
                        $xret["html"].= $rs_view_rec["weight"];
                    $xret["html"].= "</td>";

                    $xret["html"].= "<td style='border:none'>";                    
                        $xret["html"].= $rs_view_rec["bloodpressure"];
                    $xret["html"].= "</td>";

                    $xret["html"].= "<td style='border:none'>";                    
                        $xret["html"].= $rs_view_rec["complaint"];
                    $xret["html"].= "</td>";

                    $xret["html"].= "<td class='text-center;'  style='border:none'>";
                        $xret["html"].= $rs_view_rec["diagnosis"];
                    $xret["html"].= "</td>";                

                $xret["html"].= "</tr>";

                $xret["html"].= "<tr>";
                    $xret["html"].= "<td style='border:none'>";
                        $xret["html"].= $rs_view_rec["medication"];
                    $xret["html"].= "</td>";                

                    $xret["html"].= "<td style='border:none'>";
                        $xret["html"].= $rs_view_rec["herbs"];
                    $xret["html"].= "</td>";

                    $xret["html"].= "<td style='border:none'>";                   
                        $xret["html"].= $rs_view_rec["other_treatment"];
                    $xret["html"].= "</td>";

                    $xret["html"].= "<td style='border:none'>";                    
                        $xret["html"].= $rs_view_rec["accupuncture"];
                    $xret["html"].= "</td>";

                    $xret["html"].= "<td colspan='2' class='align-middle' style='border:none'>";                    
                        $xret["html"].= "<div class='text-center'>
                            <button class='btn btn-primary dropdown-toggle fw-bold' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'>
                                Action
                            </button>
                            <ul class='dropdown-menu' id='action_dropdown_data' aria-labelledby='dropdownMenuButton1'>
                                <li onclick=\"pat_rec_func('delete' ,'".$rs_view_rec['recid']."')\">
                                    <a class='dropdown-item' style='color:red;font-weight:bold'><i class='fas fa-trash-alt'></i><span style='margin-left:7px;font-size:17px;font-family:arial'>Delete</span></a>
                                </li>
                                <li onclick=\"pat_rec_func('open_edit' ,'".$rs_view_rec['recid']."')\">
                                    <a class='dropdown-item' style='color:blue;font-weight:bold'><i class='fas fa-pencil-alt'></i><span style='margin-left:7px;font-size:17px;font-family:arial'>Edit</span></a>
                                </li>
                            </ul>
                        </div>";
                    $xret["html"].= "</td>";

                $xret["html"].= "</tr>";
            $xret["html"].="</tbody>";            
        }

        $xret["html"].= "</table>";
    }
    else if($_POST["event_action"] == "open_edit_pat_rec"){

        $select_db_get_edit='SELECT * FROM patientfile_patientrecord WHERE recid=?';
        $stmt_get_edit	= $link->prepare($select_db_get_edit);
        $stmt_get_edit->execute(array($_POST["recid"]));
        $rs_get_edit = $stmt_get_edit->fetch();


        if(!empty($rs_get_edit['visitdate']) && $rs_get_edit['visitdate'] !== NULL &&  $rs_get_edit['visitdate']!=="1970-01-01"){
            $rs_get_edit['visitdate'] = date("m-d-Y",strtotime($rs_get_edit['visitdate']));
            $rs_get_edit['visitdate'] = str_replace('-','/',$rs_get_edit['visitdate']);
        }else{
            $rs_get_edit['visitdate'] = NULL;
        }

        $xret = [
            "recid" => $rs_get_edit["recid"],
            "visitdate" => $rs_get_edit["visitdate"],
            "height" => $rs_get_edit["height"],
            "weight" => $rs_get_edit["weight"],
            "bp" => $rs_get_edit["bloodpressure"],
            "complaint" => $rs_get_edit["complaint"],
            "diagnosis" => $rs_get_edit["diagnosis"],
            "medication" => $rs_get_edit["medication"],
            "herbs" => $rs_get_edit["herbs"],
            "other_treat" => $rs_get_edit["other_treatment"],
            "accu" => $rs_get_edit["accupuncture"],
        ];
    }
    else if(
        $_POST["event_action"] == "view_attach" ||
        $_POST["event_action"] == "submit_add_attach" ||
        $_POST["event_action"] == "delete_attach" ||
        $_POST["event_action"] == "submit_edit_attach" ||
        $_POST["event_action"] == "getEdit_attach"
        ){


            if($_POST["event_action"] == "submit_add_attach"){

                if(isset($_FILES) && !empty($_FILES["xfile"]["name"])){
                    $select_db_upload2='SELECT * FROM  patientfile_attachments WHERE `filename`=?';
                    $stmt_upload2	= $link->prepare($select_db_upload2);
                    $stmt_upload2->execute(array($_FILES["xfile"]["name"]));
                    $row_upload2 = $stmt_upload2->fetchAll();

                    if(count($row_upload2) > 0){
                        $xret["msg"] = "File <b>".$_FILES["xfile"]["name"]."</b> already uploaded";
                        $xret["status"] = 0;
                    }
                } 

                if($xret["status"] == 1){

                    $select_db_pat_ret_chk="SELECT * FROM patientfile WHERE cuscde=? ";
                    $stmt_pat_ret_chk	= $link->prepare($select_db_pat_ret_chk);
                    $stmt_pat_ret_chk->execute(array($_POST["cuscde"]));
                    $rs_pat_ret_chk = $stmt_pat_ret_chk->fetch();

                    if(empty($rs_pat_ret_chk)){

                        $select_cusdsc="SELECT cusdsc FROM patientfile WHERE cusdsc=?";
                        $stmt_cusdsc	= $link->prepare($select_cusdsc);
                        $stmt_cusdsc->execute(array($_POST["patient_name"]));
                        $rs_cusdsc = $stmt_cusdsc->fetch();
            
                        if(!empty($rs_cusdsc)){
                            $xret["status"] = 0;
                            $xret["msg"] = "Patient Name in use, please use another one";
                            $xerror["error1"] = 1;
                        }else{
                            $arr_record = array();
                            $arr_record['cuscde']           = $_POST["cuscde"];
                            $arr_record['cusdsc']           = $_POST["patient_name"];
                            $arr_record['birthday']         = $_POST["date_of_birth"]  = (empty($_POST["date_of_birth"]))   ? NULL :  date("Y-m-d", strtotime($_POST["date_of_birth"]));
                            $arr_record['age']              = $_POST["age"];
                            $arr_record['bloodtypecde']     = $_POST["bloodtype"];
                            $arr_record['address']          = $_POST["address"];
                            $arr_record['office_telno']     = $_POST["office_telno"];
                            $arr_record['tin_num']          = $_POST["tin"];
                            $arr_record['contact_person']   = $_POST["contact_person"];
                            $arr_record['remarks']          = $_POST["remarks"];
                            // $arr_record['prccde']           = $_POST["price_list"];
                            $arr_record['home_telno']       = $_POST["home_telno"];
                            $arr_record['mobile_no']        = $_POST["mobile_no"];
                            $arr_record['fax']              = $_POST["fax"];
                            $arr_record['email']            = $_POST["email"];
                            $arr_record['inactive_chk']     = $inactive;
                            $arr_record['other_pat']        = $_POST["other_pat"];
                            $arr_record['surgery_pat']      = $_POST["surgery_pat"];
                            $arr_record['trauma_pat']       = $_POST["trauma_pat"];
                            $arr_record['allergy_pat']      = $_POST["allergy_pat"];
                            $arr_record['other_fam']        = $_POST["other_fam"];
                            $arr_record['adddte']           = $_POST["adddte"]  = (empty($_POST["adddte"]))   ? NULL :  date("Y-m-d", strtotime($_POST["adddte"]));
                            $xret["event_save_hidden"] = "add";
                            $arr_record['gender']        = $_POST["gender"];
                            PDO_InsertRecord($link,'patientfile',$arr_record, false);

                            foreach($_POST["patient_chk"] as $key => $value){

                                if($value == 1){
                
                                    $arr_record_patient_chk = array();
                                    $arr_record_patient_chk["cuscde"] = $_POST["cuscde"];
                                    $arr_record_patient_chk["disease"] = $key;
                
                                    if($_POST["event_action"] == "edit_main"){
                                        $select_patient_chk ='SELECT * FROM patient_historyfile WHERE cuscde=? AND disease=?';
                                        $stmt_patient_chk	= $link->prepare($select_patient_chk);
                                        $stmt_patient_chk->execute(array($_POST["cuscde"],$key));
                                        $rs_patient_chk = $stmt_patient_chk->fetch();
                
                                        if(empty($rs_patient_chk)){
                                            PDO_InsertRecord($link,'patient_historyfile',$arr_record_patient_chk, false);    
                                        }
                                    }else{
                                        PDO_InsertRecord($link,'patient_historyfile',$arr_record_patient_chk, false);    
                                    }
                        
                                }
                
                                if($value == 0 && $_POST["event_action"] == "edit_main"){
                        
                                    $delete_patient_chk="DELETE FROM patient_historyfile WHERE cuscde=? AND disease=?";
                                    $stmt_patient_chk=$link->prepare($delete_patient_chk);
                                    $stmt_patient_chk->execute(array($_POST["cuscde"],$key));
                                }
                
                            }
                
                            foreach($_POST["fam_chk"] as $key => $value){
                
                                if($value == 1){
                                    $arr_record_fam_chk = array();
                                    $arr_record_fam_chk["cuscde"] = $_POST["cuscde"];
                                    $arr_record_fam_chk["disease"] = $key;
                
                                    if($_POST["event_action"] == "edit_main"){
                                        $select_fam_chk ='SELECT * FROM fam_historyfile WHERE cuscde=? AND disease=?';
                                        $stmt_fam_chk	= $link->prepare($select_fam_chk);
                                        $stmt_fam_chk->execute(array($_POST["cuscde"],$key));
                                        $rs_fam_chk = $stmt_fam_chk->fetch();
                
                                        if(empty($rs_fam_chk)){
                                            PDO_InsertRecord($link,'fam_historyfile',$arr_record_fam_chk, false);    
                                        }
                                    }else{
                                        PDO_InsertRecord($link,'fam_historyfile',$arr_record_fam_chk, false);    
                                    }
                
                                }
                
                                if($value == 0 && $_POST["event_action"] == "edit_main"){
                        
                                    $delete_fam_chk="DELETE FROM fam_historyfile WHERE cuscde=? AND disease=?";
                                    $stmt_fam_chk=$link->prepare($delete_fam_chk);
                                    $stmt_fam_chk->execute(array($_POST["cuscde"],$key));
                                }
                
                            }

                            PDO_InsertRecord($link,'patientfile_patientrecord',$arr_rec_pat, false);

                            if($xret["status"] == 1){
                                $select_cusdsc="SELECT recid FROM patientfile WHERE cusdsc=?";
                                $stmt_cusdsc	= $link->prepare($select_cusdsc);
                                $stmt_cusdsc->execute(array($_POST["patient_name"]));
                                $rs_cusdsc = $stmt_cusdsc->fetch();
    
                                $xret["msg"] = "Successfully added record in <b>Patient Record</b>";  
                                $xret["remarks"] = "edit_main";
                                $xret["patient_name"] = $_POST["patient_name"];
                                $xret["recid"] = $rs_cusdsc["recid"];
                            }

                        }
            

                    }else{
                        PDO_InsertRecord($link,'patientfile_patientrecord',$arr_rec_pat, false);
                        $xret["msg"] = "Successfully added record in <b>Attachments</b>"; 
                    }


                    if($xret["status"] == 1){
                        $select_db_file_id='SELECT * FROM patientfile_attachments ORDER BY `file_id` DESC LIMIT 1';
                        $stmt_file_id	= $link->prepare($select_db_file_id);
                        $stmt_file_id->execute();
                        $rs_file_id = $stmt_file_id->fetch();
                        if(empty($rs_file_id)){
                            $file_id = "FILE-00001";
                        }else{
                            $file_id = LNexts($rs_file_id["file_id"]);
                        }
                
                        $arr_record_upload = array();
                        $arr_record_upload['file_id'] 	= $file_id;
                        $arr_record_upload['filename'] 	= $_FILES["xfile"]["name"];
                        $arr_record_upload['cuscde'] 	= $_POST["cuscde"];
                        $arr_record_upload['remarks'] 	= $_POST["xfile_remarks"];
                        $arr_record_upload['trndte']   = (empty($_POST["trndte"]))   ? NULL :  date("Y-m-d", strtotime($_POST["trndte"]));
                        PDO_InsertRecord($link,'patientfile_attachments',$arr_record_upload, false);
                    
                        $target_path ="file_upload/";
                        $target_path = $target_path . basename($_FILES["xfile"]["name"]); 
                        $xfilename = basename($_FILES["xfile"]["name"]); 
                        
                        move_uploaded_file($_FILES["xfile"]["tmp_name"], $target_path);
    
                        $xret["msg"] = "Successfully uploaded file in <b>Attachments</b>";
                    }
                


                }else{
            
                }



            }

            if($_POST["event_action"] == "delete_attach"){

                $select_db_filename='SELECT * FROM patientfile_attachments WHERE recid=?';
                $stmt_filename	= $link->prepare($select_db_filename);
                $stmt_filename->execute(array($_POST["recid"]));
                $rs_filename = $stmt_filename->fetch();
            
                unlink("file_upload/".$rs_filename["filename"]);

                $delete_query="DELETE  FROM patientfile_attachments WHERE recid=?";
                $stmt=$link->prepare($delete_query);
                $stmt->execute(array($_POST["recid"]));


                $xret["msg"] = "Successfully deleted file in <b>Attachments</b>";
            }

            if($_POST["event_action"] == "getEdit_attach"){

                $select_db_filename='SELECT * FROM patientfile_attachments WHERE recid=?';
                $stmt_filename	= $link->prepare($select_db_filename);
                $stmt_filename->execute(array($_POST["recid"]));
                $rs_filename = $stmt_filename->fetch();

                
                if(!empty($rs_filename["trndte"]) && $rs_filename["trndte"] !== NULL &&  $rs_filename["trndte"]!=="1970-01-01"){
                    $rs_filename["trndte"] = date("m-d-Y",strtotime($rs_filename["trndte"]));
                    $rs_filename["trndte"] = str_replace('-','/',$rs_filename["trndte"]);
                }else{
                    $rs_filename["trndte"] = NULL;
                }

            
                $xret["xdata"] = [
                    "filename" => $rs_filename["filename"],
                    "remarks" => $rs_filename["remarks"],
                    "file_id" => $rs_filename["file_id"],
                    "recid" => $rs_filename["recid"],
                    "trndte" => $rs_filename["trndte"]
                ];
            }

            
            if($_POST["event_action"] == "submit_edit_attach"){

                if(isset($_FILES) && !empty($_FILES["xfile"]["name"])){
                    $select_db_upload2='SELECT * FROM  patientfile_attachments WHERE `filename`=?';
                    $stmt_upload2	= $link->prepare($select_db_upload2);
                    $stmt_upload2->execute(array($_FILES["xfile"]["name"]));
                    $row_upload2 = $stmt_upload2->fetchAll();

                    if(count($row_upload2) > 0){
                        $xret["msg"] = "File <b>".$_FILES["xfile"]["name"]."</b> already uploaded";
                        $xret["status"] = 0;
                    }
                } 

                if($xret["status"] == 1){
            
                    $arr_record_upload = array();
                    if(isset($_FILES["xfile"]["name"])){
                        $arr_record_upload['filename'] 	= $_FILES["xfile"]["name"];
                    }else{
                        $xret["xtype"] = "xfile";
                    }
                    $arr_record_upload['remarks'] 	= $_POST["xfile_remarks"];
                    $arr_record_upload['trndte']   = (empty($_POST["trndte"]))   ? NULL :  date("Y-m-d", strtotime($_POST["trndte"]));
                    PDO_UpdateRecord($link,"patientfile_attachments",$arr_record_upload,"recid = ?",array($_POST['xfile_recid']),false);   

                    if(isset($_FILES["xfile"]["name"])){
                        unlink("file_upload/".$_POST["xfile_hidden"]);

                        $target_path ="file_upload/";
                        $target_path = $target_path . basename($_FILES["xfile"]["name"]); 
                        $xfilename = basename($_FILES["xfile"]["name"]); 
                        
                        move_uploaded_file($_FILES["xfile"]["tmp_name"], $target_path);
                        $xret["msg"] = "Successfully uploaded file in <b>Attachments</b>";
                    }
    

                }

            }





        $xret["html_attach"] = '';

        $xret["html_attach"] = "
            <button type='button' class='btn btn-success my-2 me-auto' style='width:150px' value='Add Record' onclick=\"attachment_func('open_add')\">
                <i class='fas fa-plus'></i>
                <span>Add</span> 
            </button>";

        $xret["html_attach"].= "<table class='table table-striped' style='table-layout:fixed'>";

            //header
            $xret["html_attach"].= "<tr>";
                $xret["html_attach"].= "<th>";
                    $xret["html_attach"].= "Filename";
                $xret["html_attach"].= "</th>";   
                
                $xret["html_attach"].= "<th>";
                    $xret["html_attach"].= "Date";
                $xret["html_attach"].= "</th>"; 
                
                $xret["html_attach"].= "<th>";
                    $xret["html_attach"].= "Remarks";
                $xret["html_attach"].= "</th>";        

                $xret["html_attach"].= "<th class='text-center'>";
                    $xret["html_attach"].= "Action";
                $xret["html_attach"].= "</th>";
            $xret["html_attach"].= "</tr>";

            $select_db_view_file='SELECT * FROM patientfile_attachments WHERE cuscde=? ORDER BY trndte DESC';
            $stmt_view_file	= $link->prepare($select_db_view_file);
            $stmt_view_file->execute(array($_POST["cuscde"]));
            while($rs_view_file = $stmt_view_file->fetch()){

                if(!empty($rs_view_file["trndte"]) && $rs_view_file["trndte"] !== NULL &&  $rs_view_file["trndte"]!=="1970-01-01"){
                    $rs_view_file["trndte"] = date("m-d-Y",strtotime($rs_view_file["trndte"]));
                    $rs_view_file["trndte"] = str_replace('-','/',$rs_view_file["trndte"]);
                }else{
                    $rs_view_file["trndte"] = NULL;
                }

            
                $xret["html_attach"].= "<tr>";
                    $xret["html_attach"].= "<td style='width:30%;word-wrap:break-word'>";
                        $xret["html_attach"].= "<span id='xfile_txt' style='color:black;font-weight:bold;' onclick=\"view_click('".$rs_view_file['filename']."')\">".$rs_view_file["filename"]."</span>";
                    $xret["html_attach"].= "</td>";

                    $xret["html_attach"].= "<td>";
                        $xret["html_attach"].= $rs_view_file["trndte"];
                    $xret["html_attach"].= "</td>";

                    $xret["html_attach"].= "<td style='word-wrap:break-word'>";
                        $xret["html_attach"].= $rs_view_file["remarks"];
                    $xret["html_attach"].= "</td>";
                    
                    $xret["html_attach"].= "<td class='align-middle'>";                    
                        $xret["html_attach"].= "<div class='text-center'>
                            <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'>
                               <b>Action</b>
                            </button>
                            <ul class='dropdown-menu' id='action_dropdown_data' aria-labelledby='dropdownMenuButton1'>

                                <li onclick=\"attachment_func('getEdit' , '".$rs_view_file['recid']."')\">
                                    <a class='dropdown-item dd_action' style='color:#008ae6;font-weight:bold;'><i class='fas fa-pencil-alt'></i><span style='margin-left:7px;font-size:17px;font-family:arial'>Edit</span></a>
                                </li>
                                <li onclick=\"attachment_func('delete' ,'".$rs_view_file['recid']."')\">
                                    <a class='dropdown-item' style='color:red'><i class='fas fa-trash-alt'></i><span style='margin-left:7px;font-size:17px;font-family:arial'><b>Delete</b></span></a>
                                </li>
   
                            </ul>
                        </div>";
                    $xret["html_attach"].= "</td>";
                $xret["html_attach"].= "</tr>";
            }

        $xret["html_attach"].="</table>";
    }



echo json_encode($xret);
?>
