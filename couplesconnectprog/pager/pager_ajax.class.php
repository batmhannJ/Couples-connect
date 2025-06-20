<?php 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();
require_once("../resources/lx2.pdodb.php");
require "../resources/db_init.php";
require "../resources/connect4.php";
require "../resources/stdfunc100.php";


$xret = array();
$xret["status"] = 1;

$xerror = array();
$xerror["error1"] = "";
$xerror["error2"] = "";
$xerror["error3"] = "";
$xret["add_pageno"] = "";

$select_db_session_user='SELECT * FROM users where recid=?';
$stmt_session_user	= $link->prepare($select_db_session_user);
$stmt_session_user->execute(array($_POST["userid"]));
$rs_session_user = $stmt_session_user->fetch();

$username_session = $rs_session_user["userdesc"];
$username_full_name = $rs_session_user["full_name"];

$xtrndte = date("Y-m-d H:i:s");
$ua_field2 = "";
$ua_field1 = "";

if($_POST["event_action"] == "delete"){
	$delete_id=$_POST['recid'];

	$select_db_delete="SELECT * FROM ".$_POST['tablename']." where recid=?";
	$stmt_delete	= $link->prepare($select_db_delete);
	$stmt_delete->execute(array($delete_id));
    $rs_delete = $stmt_delete->fetch();
    
    if(isset($_POST['ua_field1']) && !empty($_POST["ua_field1"])){
        $ua_field1 = $rs_delete["".$_POST['ua_field1'].""];
    }
    if(isset($_POST["ua_field2"]) && !empty($_POST["ua_field2"])){
        $ua_field2 = $rs_delete["".$_POST['ua_field2'].""];
    }


	$delete_query="DELETE  FROM ".$_POST['tablename']." WHERE recid=?";
	$xstmt=$link->prepare($delete_query);
	$xstmt->execute(array($delete_id));

    $xactivity = "Deleted Record";
    $xremarks = "Deleted Record In '".$_POST["main_header"]."', ".$_POST['ua_field1_header_hidden'].": '".$ua_field1."' , Record ID: ".$ua_field2;

    //PDO_UserActivityLog($link, $xusrcde, $xusrname, $xtrndte, $xprog_module, $xactivity, $xfullname, $xremarks , $linenum, $parameter, $trncde, $trndsc, $compname, $xusrnme);
    PDO_UserActivityLog($link, $username_session, '', $xtrndte, '', $xactivity, $username_full_name, $xremarks , 0, '', '', '','',$username_session);

}
else if($_POST["event_action"] == "getDelete"){

    $xret["retEdit"] = array();
    $xret["status"] = "getDelete";


    if(!empty($_POST["delFieldDDVal"])){

        $delField = $_POST["delField"];
        $mainTablename= $_POST["tablename"];
        $delFieldDDVal = $_POST["delFieldDDVal"];
        $delFieldDDtablename = $_POST["delFieldDDtablename"];
        $recid = $_POST["recid"];
 

        $select_db="SELECT ".$delFieldDDtablename.".".$delFieldDDVal." as ".$delFieldDDtablename."_".$delFieldDDVal." FROM ".$mainTablename." LEFT JOIN ".$delFieldDDtablename."
        ON ".$mainTablename.".".$delField." = ".$delFieldDDtablename.".".$delField." WHERE ".$mainTablename.".recid = '".$recid."'";
        $stmt	= $link->prepare($select_db);
        $stmt->execute();
        $rs_getDelete = $stmt->fetch();
    
        $xret["field"] = $rs_getDelete[$delFieldDDtablename."_".$delFieldDDVal];
    }else{
        
        $select_db="SELECT ".$_POST["delField"]." FROM ".$_POST['tablename']." WHERE recid=?";
        $stmt	= $link->prepare($select_db);
        $stmt->execute(array($_POST["recid"]));
        $rs_getDelete = $stmt->fetch();

        $select_db_columntype="DESCRIBE ".$_POST['tablename']." ".$_POST["delField"]."";
        $stmt_columntype	= $link->prepare($select_db_columntype);
        $stmt_columntype->execute(array($_POST["recid"]));
        $rs_columntype = $stmt_columntype->fetch();

        if($rs_columntype["Type"] == "date"){
            $rs_getDelete[$_POST["delField"]] = date("m-d-Y",strtotime($rs_getDelete[$_POST["delField"]]));
            $rs_getDelete[$_POST["delField"]] = str_replace('-','/',$rs_getDelete[$_POST["delField"]]);
            $xret["field"] = $rs_getDelete[$_POST["delField"]];
        }else{
            $xret["field"] = $rs_getDelete[$_POST["delField"]];
        }
    

    }


    
}
else if($_POST["event_action"] == "getEdit"){

    $xret["retEdit"] = array();
    $xret["status"] = "retEdit";
    $xcounter_select = 0;
    $fields_select = '';

    foreach($_POST["xdata"] as $key_value_select){

        $fieldname_select = $key_value_select[0]["name"];
        $fieldname_select = str_replace("_crudModal", "",$fieldname_select);

        if($xcounter_select == 0){
            $fields_select = $fieldname_select;
        }else{
            $fields_select .= ",".$fieldname_select;
        }
        $xcounter_select++;
    }
    $fields_select.=",recid";
    
    $retEdit_counter = 0;

    $select_db="SELECT ".$fields_select." FROM ".$_POST['tablename']." WHERE recid=?";
	$stmt	= $link->prepare($select_db);
    $stmt->execute(array($_POST["recid"]));
    while($rs_retEdit = $stmt->fetch()){

        foreach($_POST["xdata"] as $key_value){

            $fieldname = $key_value[0]["name"];
            $fieldname = str_replace("_crudModal", "",$fieldname);
            $field_type = $key_value[6]["data-field-type"];

            if($field_type == "date"){
                if(!empty($rs_retEdit[$fieldname]) && $rs_retEdit[$fieldname] !== NULL &&  $rs_retEdit[$fieldname]!=="1970-01-01"){
                    $rs_retEdit[$fieldname] = date("m-d-Y",strtotime($rs_retEdit[$fieldname]));
                    $rs_retEdit[$fieldname] = str_replace('-','/',$rs_retEdit[$fieldname]);
                }else{
                    $rs_retEdit[$fieldname] = NULL;
                }
            }
        

            $xret["retEdit"][$retEdit_counter]["field_name"] = $fieldname;
            $xret["retEdit"][$retEdit_counter]["field_value"] = $rs_retEdit[$fieldname];
            $xret["retEdit"][$retEdit_counter]["field_type"] = $key_value[6]["data-field-type"];
            $retEdit_counter++;
        }

        $xret["retEdit"]["recid"] = $_POST["recid"];
    }

}

else if($_POST["event_action"] == "insert")
{

    $arr_record_data = array();
    if(isset($_POST["unique_key"])){
        $unique_key_array = array();
        parse_str($_POST["unique_key"] , $unique_key_array);
    }


    $searchfield = "";
    $searchfieldValue   =   "";

    $search_text_input = '';
    if((isset($_POST["search_text_input_hidden"]) && $_POST["search_text_input_hidden"] == $_POST["search_text_input"])){
            $search_text_input = $_POST["search_text_input"];
    }else{

        if(!isset($_POST["search_text_input_hidden"])){
            $_POST["search_text_input_hidden"] = "";
        }
        $search_text_input = $_POST["search_text_input_hidden"];
    }

    $search_text_input_dd = '';

    if((isset($_POST["search_text_input_hidden_dd"]) && $_POST["search_text_input_hidden_dd"] == $_POST["search_dd"])){
        $search_text_input_dd = $_POST["search_dd"];
    }else{

        if(!isset($_POST["search_text_input_hidden_dd"])){
            $_POST["search_text_input_hidden_dd"] = "";
        }
        $search_text_input_dd = $_POST["search_text_input_hidden_dd"];
    }

    
    if($search_text_input_dd !== ""){
        $searchfield    =   $search_text_input_dd;
    }else{
        $searchfield    =   $_POST["table_order_field"];
    }


    foreach($_POST["xdata"] as $key_value){

        $fieldname              = $key_value[0]["name"];
        $fieldvalue             = $key_value[1]["value"];
        $field_datavalue        = $key_value[2]["data-value"];
        $field_is_required      = $key_value[4]["data-is-required"];
        $field_is_unique        = $key_value[5]["data-is-unique"];
        $field_type             = $key_value[6]["data-field-type"];

        $fieldname              = str_replace("_crudModal", "",$fieldname);
        $field_datavalue        = str_replace("_crudModal", "",$field_datavalue);
        $field_is_required      = str_replace("_crudModal", "",$field_is_required);
        $field_is_unique        = str_replace("_crudModal", "",$field_is_unique);

        if($field_type == "date"){
            $fieldvalue  = (empty($fieldvalue))   ? NULL :  date("Y-m-d", strtotime($fieldvalue));
        }
        if($field_is_unique == "Y"){

            $select_db_unique="SELECT ".$fieldname." FROM ".$_POST['tablename']." WHERE ".$fieldname."=?";
            $stmt_unique	= $link->prepare($select_db_unique);
            $stmt_unique->execute(array($fieldvalue));
            $rs_unique = $stmt_unique->fetchAll();

            if(
                ($xerror["error1"] == true || $xerror["error2"] == true || $xerror["error3"] == true) && 
                (count($rs_unique) > 0)
            ){
                
                $xret["msg"] .= "</br>".$field_datavalue." in use.";
                $xret["status"] = 0;
                $xerror["error1"] = true;
                
            }
            else if(
                ($xerror["error1"] !== true || $xerror["error2"] !== true || $xerror["error3"] !==true) && 
                (count($rs_unique) > 0)
            ){
                $xret["msg"] = $field_datavalue." in use.";
                $xret["status"] = 0;
                $xerror["error1"] = true;
            }

        }

        if(
            (empty($fieldvalue)) && 
            ($xerror["error1"] == true || $xerror["error2"] == true || $xerror["error3"] == true) && 
            ($field_is_required == "Y")
        ){
            $xret["msg"] .= "</br> ".$field_datavalue." is required.";
            $xret["status"] = 0;
            $xerror["error2"] = true;
        }else if(
            (empty($fieldvalue)) && 
            ($xerror["error1"] !== true && $xerror["error2"] !== true && $xerror["error3"] !== true) && 
            ($field_is_required == "Y")
        ){
            $xret["msg"] = "".$field_datavalue." is required.";
            $xret["status"] = 0;
            $xerror["error2"] = true;
        }

        if($field_type == "number"){
            if(!empty($key_value[7]["data-num-limit"])){
                if(
                    ($fieldvalue >= $key_value[7]["data-num-limit"]) && 
                    ($xerror["error1"] == true|| $xerror["error2"] == true || $xerror["error3"] == true)
                ){
                    $xret["msg"] .= "</br>".$field_datavalue.": ".$fieldvalue." (number) entered is too large.";
                    $xret["status"] = 0;
                    $xerror["error3"] = true;
                }

                else if(
                    ($fieldvalue >= $key_value[7]["data-num-limit"]) && 
                    ($xerror["error1"] !== true && $xerror["error2"] !== true && $xerror["error3"] !== true)
                ){
                    $xret["msg"] = $field_datavalue.": ".$fieldvalue." (number) entered is too large.";
                    $xret["status"] = 0;
                    $xerror["error3"] = true;
                }

            }

            if($fieldvalue == '' && ($field_is_required !== "Y")){
                $fieldvalue = NULL;
            }

        }

        $arr_record_data[$fieldname] 	= $fieldvalue;

        if($_POST["ua_field1"] == $fieldname){
            $ua_field1 =  $fieldvalue;
            $ua_field_header = $field_datavalue;
        }

        if($fieldname == $searchfield){
            $searchfield = $fieldname;
            $searchfieldValue = $fieldvalue;
        }


    }

    if($xret["status"] == 1){

        $fieldcode_innit  = "";

        if(!empty($_POST["fieldcode"])){

            if(!empty($_POST["fieldcode_init"])){
                $select_db_fieldcode="SELECT ".$_POST['fieldcode']." FROM ".$_POST['tablename']." ORDER BY ".$_POST['fieldcode']." DESC LIMIT 1";
                $stmt_fieldcode	= $link->prepare($select_db_fieldcode);
                $stmt_fieldcode->execute(array($fieldvalue));
                while($rs_fieldcode = $stmt_fieldcode->fetch()){
                    if(!empty($rs_fieldcode[$_POST["fieldcode"]])){
                        $fieldcode_innit = lNexts($rs_fieldcode[$_POST["fieldcode"]]);
                    }
                };

                if($fieldcode_innit == ""){
                    $fieldcode_innit = $_POST["fieldcode_init"];
                }
                
            }else{
                $fieldcode_innit = $_POST["fieldcode_init"];
            }

            $arr_record_data[$_POST["fieldcode"]] = $fieldcode_innit;
            if(!empty($_POST["ua_field2"])){
                $ua_field2 = $fieldcode_innit;
            }



            if((isset($_POST["search_hidden"]) && $_POST["search_hidden"] == "Y")){
                if($_POST["search_data_type"] == "checkbox"){
                    if($search_text_input !== "all"){
                        $filter = "AND ".$search_text_input_dd." ='".$search_text_input."'";
                    }
                }else if($_POST["search_data_type"] == "date"){
        
                    $search_text_input  = (empty($search_text_input))   ? NULL :  date("Y-m-d", strtotime($search_text_input));
        
                    if($search_text_input == NULL){
                        $filter = "";
                    }else{
                        $filter = "AND ".$search_text_input_dd." LIKE '%".$search_text_input."%'";
                    }
        
                }
                else if($_POST["search_data_type"] == "dropdown_custom"){
        
                    $dropdown_field_name_value_search = (isset($_POST["field_name_value"]))?($_POST["field_name_value"]) : "";
                    $dropdown_field_name_search       = $_POST["field_name"];
                    $dropdown_tablename_search        = $_POST["tablename_search"];
                    $dropdown_txt_value               = $search_text_input;
        
                    if($dropdown_field_name_value_search !== ""){
        
                        $select_db_xtotal="SELECT count(*) as rec_count FROM ".$_POST["tablename"]." INNER JOIN ".$dropdown_tablename_search
                        ." ON ".$_POST["tablename"].'.'.$dropdown_field_name_search.'  = '.$dropdown_tablename_search.'.'.$dropdown_field_name_search."
                        WHERE ".$dropdown_field_name_value_search." LIKE '%".$dropdown_txt_value."%' AND (".$_POST['tablename'].".". $dropdown_field_name_search." <='".$searchfieldValue."' OR ".$_POST['tablename'].".".$dropdown_field_name_search." IS NULL)";
                    }else{
                        $select_db_xtotal = "SELECT count(*) as rec_count FROM ".$_POST['tablename']." WHERE ".$dropdown_field_name_search." LIKE '%".$dropdown_txt_value."%' AND (". $searchfield." <= '" . $searchfieldValue."' OR ". $searchfield." IS NULL)";
                    }
        
                }
                else{
        
                    $search_text_input  = (empty($search_text_input))   ? NULL :  $search_text_input;
        
                    if($search_text_input == NULL){
                        $filter = "";
                    }else{
                        $filter = "AND ".$search_text_input_dd." LIKE '%".$search_text_input."%'";
                    }
                }
            }


            if(!isset($_POST["search_data_type"]) || $_POST["search_data_type"] !== "dropdown_custom"){
                $select_db_xtotal="SELECT count(*) as rec_count FROM ".$_POST['tablename']." WHERE true ".$filter."";
            }else{
        
                $dropdown_field_name_value_search = (isset($_POST["field_name_value"]))?($_POST["field_name_value"]) : "";
                $dropdown_field_name_search       = $_POST["field_name"];
                $dropdown_tablename_search        = $_POST["tablename_search"];
                $dropdown_txt_value               = $search_text_input;
        
                if($dropdown_field_name_value_search !== ""){
        
                    $select_db_xtotal="SELECT count(*) as rec_count FROM ".$_POST["tablename"]." INNER JOIN ".$dropdown_tablename_search
                    ." ON ".$_POST["tablename"].'.'.$dropdown_field_name_search.'  = '.$dropdown_tablename_search.'.'.$dropdown_field_name_search."
                    WHERE ".$dropdown_field_name_value_search." LIKE '%".$dropdown_txt_value."%' AND (".$_POST['tablename'].".". $dropdown_field_name_search." <='".$searchfieldValue."' OR ".$_POST['tablename'].".".$dropdown_field_name_search." IS NULL)";
                }else{
                    $select_db_xtotal = "SELECT count(*) as rec_count FROM ".$_POST['tablename']." WHERE ".$dropdown_field_name_search." LIKE '%".$dropdown_txt_value."%' AND (". $searchfield." <= '" . $searchfieldValue."' OR ". $searchfield." IS NULL)";
                }
        
            }
        
  
            if($_POST['search_data_type'] !== "dropdown_custom"){
                $select_db_xtotal = "SELECT count(*) as rec_count FROM ".$_POST['tablename']." WHERE true ".$filter." AND (". $searchfield." <= '" . $searchfieldValue."' OR ". $searchfield." IS NULL)";
            }
            

            $stmt_addcount	= $link->prepare($select_db_xtotal);
            $stmt_addcount->execute();
            while($rs = $stmt_addcount->fetch()){
                $xcount =   $rs["rec_count"];
            } 

            $new_pageno =   intval($xcount/$_POST["xlimit"]) + 1;

            $xret["add_pageno"] = $new_pageno;
        }

        PDO_InsertRecord($link,$_POST["tablename"],$arr_record_data, false);

        $xactivity = "Added Record";
        $xremarks = "Added Record In '".$_POST["main_header"]."', ".$ua_field_header.": '".$ua_field1."' , Record ID: ".$ua_field2;

        //PDO_UserActivityLog($link, $xusrcde, $xusrname, $xtrndte, $xprog_module, $xactivity, $xfullname, $xremarks , $linenum, $parameter, $trncde, $trndsc, $compname, $xusrnme);
        PDO_UserActivityLog($link, $username_session, '', $xtrndte, '', $xactivity, $username_full_name, $xremarks , 0, '', '', '','',$username_session);
    }
}

else if($_POST["event_action"] == "submitEdit")
{

    $arr_record_data = array();
    if(isset($_POST["unique_key"])){
        $unique_key_array = array();
        parse_str($_POST["unique_key"] , $unique_key_array);
    }

    foreach($_POST["xdata"] as $key_value){

        $fieldname              = $key_value[0]["name"];
        $fieldvalue             = $key_value[1]["value"];
        $field_datavalue        = $key_value[2]["data-value"];
        if(isset($key_value[3]["data-value-hidden"])){
            $field_datavalue_hidden = $key_value[3]["data-value-hidden"];
        }else{
            $field_datavalue_hidden = '';
        }

        $field_is_required      = $key_value[4]["data-is-required"];
        $field_is_unique        = $key_value[5]["data-is-unique"];
        $field_type             = $key_value[6]["data-field-type"];

        $fieldname = str_replace("_crudModal", "",$fieldname);
        $field_datavalue = str_replace("_crudModal", "",$field_datavalue);
        $field_is_required = str_replace("_crudModal", "",$field_is_required);
        $field_is_unique = str_replace("_crudModal", "",$field_is_unique);

        if($field_type == "date"){
            $fieldvalue  = (empty($fieldvalue))   ? NULL :  date("Y-m-d", strtotime($fieldvalue));
            $field_datavalue_hidden  = (empty($field_datavalue_hidden))   ? NULL :  date("Y-m-d", strtotime($field_datavalue_hidden));
        }

        if(($field_is_unique == "Y") && ($field_datavalue_hidden !== $fieldvalue)){

            $select_db_unique="SELECT ".$fieldname." FROM ".$_POST['tablename']." WHERE ".$fieldname."=?";
            $stmt_unique	= $link->prepare($select_db_unique);
            $stmt_unique->execute(array($fieldvalue));
            $rs_unique = $stmt_unique->fetchAll();

            if(
                ($xerror["error1"] == true || $xerror["error2"] == true || $xerror["error3"] == true) && 
                (count($rs_unique) > 0)
            ){
                
                $xret["msg"] .= "</br>".$field_datavalue." in use.";
                $xret["status"] = 0;
                $xerror["error1"] = true;
                
            }
            else if(
                ($xerror["error1"] !== true && $xerror["error2"] !== true && $xerror["error3"] !== true) && 
                (count($rs_unique) > 0)
            ){
                $xret["msg"] = $field_datavalue." in use.";
                $xret["status"] = 0;
                $xerror["error1"] = true;
            }

        }

        if(
            (empty($fieldvalue)) && 
            ($xerror["error1"] == true || $xerror["error2"] == true || $xerror["error3"] == true) && 
            ($field_is_required == "Y")
        ){
            $xret["msg"] .= "</br> ".$field_datavalue." is required.";
            $xret["status"] = 0;
            $xerror["error2"] = true;
        }else if(
            (empty($fieldvalue)) && 
            ($xerror["error1"] !== true && $xerror["error2"] !== true && $xerror["error3"] !== true) && 
            ($field_is_required == "Y")
        ){
            $xret["msg"] = "".$field_datavalue." is required.";
            $xret["status"] = 0;
            $xerror["error2"] = true;
        }

        if($field_type == "number"){
            if(!empty($key_value[7]["data-num-limit"])){
                if(
                    ($fieldvalue >= $key_value[7]["data-num-limit"]) && 
                    ($xerror["error1"] == true|| $xerror["error2"] == true || $xerror["error3"] == true)
                ){
                    $xret["msg"] .= "</br>".$field_datavalue." ".$fieldvalue." (number) entered is too large.";
                    $xret["status"] = 0;
                    $xerror["error3"] = true;
                }

                else if(
                    ($fieldvalue >= $key_value[7]["data-num-limit"]) && 
                    ($xerror["error1"] !== true && $xerror["error2"] !== true && $xerror["error3"] !== true)
                ){
                    $xret["msg"] = $field_datavalue." ".$fieldvalue." (number) entered is too large.";
                    $xret["status"] = 0;
                    $xerror["error3"] = true;
                }

            }

            if($fieldvalue == '' && ($field_is_required !== "Y")){
                $fieldvalue = NULL;
            }

        }

        if($_POST["ua_field1"] == $fieldname){
            $ua_field1 =  $fieldvalue;
            $ua_field_header = $field_datavalue;
        }

        $fieldname = str_replace("_crudModal", "",$fieldname);
        $arr_record_data[$fieldname] 	= $fieldvalue;

    }

    if($xret["status"] == 1){

        PDO_UpdateRecord($link,$_POST["tablename"],$arr_record_data,"recid = ?",array($_POST["recid_edit"]),false);  

        $select_db_editcode="SELECT * FROM ".$_POST['tablename']." where recid=?";
        $stmt_editcode	= $link->prepare($select_db_editcode);
        $stmt_editcode->execute(array($_POST["recid_edit"]));
        $rs_editcode = $stmt_editcode->fetch();

        if(isset($_POST["ua_field2"]) &&  !empty($_POST['ua_field2'])){
            $ua_field2 = $rs_editcode["".$_POST['ua_field2'].""];
        }


        $ua_field1_old = $_POST["ua_field1_hidden_modal"];

        $xactivity = "Updated Record";
        $xremarks = "Updated Record In '".$_POST["main_header"]."', FROM: '".$ua_field1_old."' TO: '".$ua_field1."' , Record ID: ".$ua_field2;

        //PDO_UserActivityLog($link, $xusrcde, $xusrname, $xtrndte, $xprog_module, $xactivity, $xfullname, $xremarks , $linenum, $parameter, $trncde, $trndsc, $compname, $xusrnme);
        PDO_UserActivityLog($link, $username_session, '', $xtrndte, '', $xactivity, $username_full_name, $xremarks , 0, '', '', '','',$username_session);
    }
}

else if($_POST["event_action"] == "delete_alert"){



    $select_db="SELECT ".$_POST['fieldname_del']." FROM ".$_POST['tablename_del']." WHERE recid=?";
	$stmt	= $link->prepare($select_db);
    $stmt->execute(array($_POST["recid"]));

    $rs_ret = $stmt->fetch();

    $xret["xdata"] = [
        "del_field_val" => $rs_ret["".$_POST['fieldname_del'].""]
    ];



}

header('Content-Type: application/json');
echo json_encode($xret);
?>