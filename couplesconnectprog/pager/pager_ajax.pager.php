<?php
    // ini_set('display_errors', '1');
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL);     

    session_start();
    
    require_once("../resources/db_init.php");
    require "../resources/connect4.php";
    require "../resources/stdfunc100.php";
    require "../resources/lx2.pdodb.php";

    $fields_count = 0;

    foreach($_POST["xfields"] as $key_select => $value_select){

        $name_select = remove_xfields($value_select[0]["name"],"fname");

            if($fields_count == 0){
                $fields = $name_select;
            }else{
                $fields .= ",".$name_select;
            }

        $fields_count++;
    }
    $fields.=",recid";

    //TO CHANGE
    $xlimit = $_POST["xlimit"];

    //INIITALIZING XRET
    $xret = array();
    $xret["html"] = '';
    $xret["html_mobile"] = '';
    $xret["html_search"] = '';
    $filter =  '';
    $search_text_input = '';
    

    if($_POST["event_action"] == "search" ||
       (isset($_POST["search_text_input_hidden"]) && $_POST["search_text_input_hidden"] == $_POST["search_text_input"])
    ){
        $search_text_input = $_POST["search_text_input"];
        $xret["hidden_value_search"] = $_POST['search_text_input'];
    }else{

        if(!isset($_POST["search_text_input_hidden"])){
            $_POST["search_text_input_hidden"] = "";
        }
        $search_text_input = $_POST["search_text_input_hidden"];
        $xret["hidden_value_search"] = $_POST['search_text_input_hidden'];
    }

    $search_text_input_dd = '';

    if($_POST["event_action"] == "search" ||
    (isset($_POST["search_text_input_hidden_dd"]) && $_POST["search_text_input_hidden_dd"] == $_POST["search_dd"])
    ){
        $search_text_input_dd = $_POST["search_dd"];
        $xret["hidden_value_search_dd"] = $_POST['search_dd'];
    }else{

        if(!isset($_POST["search_text_input_hidden_dd"])){
            $_POST["search_text_input_hidden_dd"] = "";
        }
        $search_text_input_dd = $_POST["search_text_input_hidden_dd"];
        $xret["hidden_value_search_dd"] = $_POST['search_text_input_hidden_dd'];
    }

    if(
        (isset($_POST["search_hidden"]) && $_POST["search_hidden"] == "Y") &&
        (!isset($_POST["first_load"]) || $_POST["first_load"] !== "Y")
    ){
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
                    WHERE ".$dropdown_field_name_value_search." LIKE '%".$dropdown_txt_value."%'";
            }else{
                $select_db_xtotal = "SELECT count(*) as rec_count FROM ".$_POST['tablename']." WHERE ".$dropdown_field_name_search." LIKE '%".$dropdown_txt_value."%'";
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
                WHERE ".$dropdown_field_name_value_search." LIKE '%".$dropdown_txt_value."%'";
        }else{
            $select_db_xtotal = "SELECT count(*) as rec_count FROM ".$_POST['tablename']." WHERE ".$dropdown_field_name_search." LIKE '%".$dropdown_txt_value."%'";
        }

    }

    $stmt_xtotal	= $link->prepare($select_db_xtotal);

    $stmt_xtotal->execute();
    $rs_xtotal = $stmt_xtotal->fetch();

    //INITIALIZE PAGE NO.
    $xpageno=$_POST['pageno'];

    //RETURN TOTAL RECORDS
    $xtotalrec=$rs_xtotal['rec_count'];
    $xret['totalrec']=$xtotalrec;

    //CALCULATE MAXPAGE
    $maxpage = ceil($xtotalrec / $xlimit);
    //RETURN MAXPAGE
    $xret["maxpage"] = $maxpage;
    $new_field_num = $_POST['field_num'];


    if ($xtotalrec==0)
    {
        $xret["html"] = "<tr><td colspan=".$new_field_num." class='text-center display-5 w-100' style='padding-left:0px !important;'> NO RECORDS<i class='fas fa-search display-6 mx-2'></i></td></tr>";
        $xret["html_mobile"] = "<tr><td colspan=".$new_field_num." class='text-center display-5 w-100' style='padding-left:0px !important;'> NO RECORDS<i class='fas fa-search display-6 mx-2'></i></td></tr>";
        $xret["maxpage"]=0;
        $xret["xpageno"] ='';
        echo json_encode($xret);
        return;
    }

    //CALCULATE OFFSET
    if($xpageno == 0 || $xpageno == 1 || empty($xpageno) || $_POST["event_action"] == "search"){
        $xpageno = 1;
        $xoffset = 0;
    }
    if($_POST["event_action"] == "next_p"){
        if($xpageno == $maxpage){
            //nothing changes
        }else{
            $xpageno++;
        }
        $xoffset =  ($xpageno * $xlimit) - $xlimit ;

    }
    else if($_POST["event_action"] == "previous_p"){
        if($xpageno==1){
            $xoffset = 0;
        }else{
            $xpageno--;
            $xoffset =  ($xpageno * $xlimit) - $xlimit ;
        }
    }
    else if($_POST["event_action"] == "first_p"){
        $xpageno=1;
        $xoffset = 0;
    }
    else if($_POST["event_action"] == "last_p"){
        $xpageno = $maxpage;
        $xoffset =  ($xpageno * $xlimit) - $xlimit ;
    }
    else if($_POST["event_action"] =="same"){
        if($xpageno > $maxpage){
            $xpageno = $maxpage;
            $xoffset =  ($xpageno * $xlimit) - $xlimit ;
        }else{
            $xoffset =  ($xpageno * $xlimit) - $xlimit ;
        }
    }

    //RETURN PAGE NO
    $xret["xpageno"] = $xpageno;

    //initializing filter
    $filter = "";
    $order_filter = "";

    if(
        (isset($_POST["search_hidden"]) && $_POST["search_hidden"] == "Y") &&
        (!isset($_POST["first_load"]) || $_POST["first_load"] !== "Y")
    ){

        $filter_order = "ORDER BY  ".$search_text_input_dd." ASC, recid ASC";

        if($_POST["search_data_type"] == "checkbox"){
            if($search_text_input !== 'all'){
                $filter = "AND ".$search_text_input_dd." ='".$search_text_input."'";
            }
        }else if($_POST["search_data_type"] == "date"){

            $search_text_input  = (empty($search_text_input)) ? NULL :  date("Y-m-d", strtotime($search_text_input));

            if($search_text_input == NULL){
                $filter = "";
            }else{
                $filter = "AND ".$search_text_input_dd." LIKE '%".$search_text_input."%'";
            }

        }
        else if($_POST["search_data_type"] == "dropdown_custom"){

            $fields_count_search = 0;

            foreach($_POST["xfields"] as $key_select => $value_select_search){

                $value_select_name = remove_xfields($value_select_search[0]["name"],"fname");
        
                    if($fields_count_search == 0){
                        $fields_search = $_POST["tablename"].".".$value_select_name;
                    }else{
                        $fields_search .= ",".$_POST["tablename"].".".$value_select_name;
                    }

                $fields_count_search++;
            }
            $fields_search.=",".$_POST["tablename"]."."."recid";


            $dropdown_field_name_value_search = (isset($_POST["field_name_value"]))?($_POST["field_name_value"]) : "";
            $dropdown_field_name_search       = $_POST["field_name"];
            $dropdown_tablename_search        = $_POST["tablename_search"];
            $dropdown_txt_value               = $search_text_input;

            if($dropdown_field_name_value_search !== ""){

                $select_db_fields="SELECT ".$fields_search." FROM ".$_POST["tablename"]." INNER JOIN ".$dropdown_tablename_search
                ." ON ".$_POST["tablename"].'.'.$dropdown_field_name_search.'  = '.$dropdown_tablename_search.'.'.$dropdown_field_name_search."
                    WHERE ".$dropdown_field_name_value_search." LIKE '%".$dropdown_txt_value."%'"." ORDER BY ".$dropdown_tablename_search.".".$dropdown_field_name_value_search." ASC LIMIT ".$xlimit." OFFSET ".$xoffset;
            }else{
                $select_db_fields = "SELECT ".$fields." FROM ".$_POST['tablename']." WHERE ".$dropdown_field_name_search." LIKE '%".$dropdown_txt_value."%' ORDER BY ".$dropdown_field_name_search." ASC LIMIT ".$xlimit." OFFSET ".$xoffset;
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

    }else{
        $filter_order = "ORDER BY ".$_POST["table_order_field"]." ".$_POST["table_order_type"].", recid ASC";
    }
    

    if(!isset($_POST["search_data_type"]) || $_POST["search_data_type"] !== "dropdown_custom"){
        $select_db_fields="SELECT ".$fields." FROM ".$_POST['tablename']."  WHERE true ".$filter." ".$filter_order." LIMIT ".$xlimit." OFFSET ".$xoffset;
    }else if($_POST["search_data_type"] == "dropdown_custom" && (isset($_POST["first_load"]) && $_POST["first_load"] == "Y")){
        $fields_count_search = 0;

        foreach($_POST["xfields"] as $key_select => $value_select_search){

            $value_select_name = remove_xfields($value_select_search[0]["name"],"fname");
    
                if($fields_count_search == 0){
                    $fields_search = $_POST["tablename"].".".$value_select_name;
                }else{
                    $fields_search .= ",".$_POST["tablename"].".".$value_select_name;
                }

            $fields_count_search++;
        }
        $fields_search.=",".$_POST["tablename"]."."."recid";

        $dropdown_field_name_value_search = (isset($_POST["field_name_value"]))?($_POST["field_name_value"]) : "";
        $dropdown_field_name_search       = $_POST["field_name"];
        $dropdown_tablename_search        = $_POST["tablename_search"];
        $dropdown_txt_value               = '';

        if($dropdown_field_name_value_search !== ""){

            $select_db_fields="SELECT ".$fields_search." FROM ".$_POST["tablename"]." INNER JOIN ".$dropdown_tablename_search
            ." ON ".$_POST["tablename"].'.'.$dropdown_field_name_search.'  = '.$dropdown_tablename_search.'.'.$dropdown_field_name_search."
                WHERE ".$dropdown_field_name_value_search." LIKE '%".$dropdown_txt_value."%'"." ORDER BY ".$_POST["tablename"].".".$_POST["table_order_field"]." ".$_POST["table_order_type"].", ".$_POST["tablename"].".recid ASC LIMIT ".$xlimit." OFFSET ".$xoffset;
        }else{
            $select_db_fields = "SELECT ".$fields." FROM ".$_POST['tablename']." WHERE ".$dropdown_field_name_search." LIKE '%".$dropdown_txt_value."%' ORDER BY ".$dropdown_field_name_search." ASC";
        }
    }

    $stmt	= $link->prepare($select_db_fields);
    $xret["sql"] = $select_db_fields; 
    $stmt->execute();
    while($row = $stmt->fetch()){

        if((int)$_SESSION["view_crud"] == 0){
            break;
        }

        $xret["html"] .= "<tr>";

            foreach($_POST["xfields"] as $xfields_arr_key => $xfields_arr_val){

                $field_name = remove_xfields($xfields_arr_val[0]["name"], "fname");
                $field_type = $xfields_arr_val[1]["data-field-type"];
                if($field_type !== "dropdown_custom"){
                    $field_decimal_place = $xfields_arr_val[4]["data-field-decimal-place"];
                }else{
                    $field_decimal_place = '';
                }
                
                $field_fw = (
                                !isset($xfields_arr_val[2]["data-field-fw"]) ||
                                empty($xfields_arr_val[2]["data-field-fw"]) ||
                                $xfields_arr_val[2]["data-field-fw"] == "normal" ||
                                $xfields_arr_val[2]["data-field-fw"] == "none"
                                ) ? "normal" : $xfields_arr_val[2]["data-field-fw"];


                if($field_type == "date"){

                    if(!empty($row[$field_name]) && $row[$field_name] !== NULL &&  $row[$field_name]!=="1970-01-01"){
                        $row[$field_name] = date("m-d-Y",strtotime($row[$field_name]));
                        $row[$field_name] = str_replace('-','/',$row[$field_name]);
                    }else{
                        $row[$field_name] = NULL;
                    }

                }

                if($field_type == "checkbox"){

                    if($row["".$field_name.""] == 0){
                        $xret["html"] .= "<td data-label='".$xfields_arr_val[3]["data-field-header"]."' style='text-align:center'>";
                            $xret["html"].= "<input type='checkbox' class='form-check-input' style='opacity:1' disabled>";
                        $xret["html"] .= "</td>";
                    }else{
                        $xret["html"] .= "<td data-label='".$xfields_arr_val[3]["data-field-header"]."' style='text-align:center'>";
                            $xret["html"].= "<input type='checkbox' class='form-check-input' style='opacity:1' checked disabled>";
                        $xret["html"] .= "</td>";
                    }

                }

                if($row[$field_name] == NULL){
                    $row[$field_name] = '&nbsp';
                }

                if($field_type == "dropdown_custom"){

                    $dropdown_field_name = $xfields_arr_val[4]["data-dd-field_name"];
                    $dropdown_field_name_value = (isset($xfields_arr_val[5]["data-dd-field_name-value"]))?($xfields_arr_val[5]["data-dd-field_name-value"]) : "";
                    $dropdown_tablename       = $xfields_arr_val[6]["data-dd-tablename"];

                    if($dropdown_field_name_value !== ""){
                        $select_db_dd="SELECT ".$dropdown_field_name_value.", ".$dropdown_field_name." FROM ".$dropdown_tablename." where ".$dropdown_field_name."='".$row["".$dropdown_field_name.""]."'";
                    }else{
                        $select_db_dd="SELECT ".$dropdown_field_name." FROM ".$_POST["tablename"]." WHERE ".$dropdown_field_name."='".$row["".$dropdown_field_name.""]."'";
                    }

                    $stmt_dd	= $link->prepare($select_db_dd);
                    $stmt_dd->execute();

                    while($rs_dd = $stmt_dd->fetch()){

                        if($dropdown_field_name_value !== ""){
                            $row[$field_name] = $rs_dd[$dropdown_field_name_value];
                        }
                        else{
                            $row[$field_name] = $rs_dd[$dropdown_field_name];
                        }

                    }

                }

                if($field_type !== "checkbox"){

                    if(!empty($field_decimal_place)){
                        $xret["html"] .= "<td style='font-weight:".$field_fw.";text-align:right' data-label='".$xfields_arr_val[3]["data-field-header"]."'>";
                            $xret["html"].= "<span>".number_format($row["".$field_name.""],$field_decimal_place)."</span>";
                        $xret["html"] .= "</td>";
                    }else{
                        $xret["html"] .= "<td style='font-weight:".$field_fw."' data-label='".$xfields_arr_val[3]["data-field-header"]."'>";
                            $xret["html"].= "<span>".$row["".$field_name.""]."</span>";
                        $xret["html"] .= "</td>";
                    }

                }

            }

            if(($_POST["display_only"] !== "Y" || empty($_POST["display_only"])) && ((int)$_SESSION["edit_crud"] == 1 || (int)$_SESSION["delete_crud"] == 1)){

                $xret["html"].= "<td class='text-center align-middle' data-label='Action'>";
                    $xret["html"].= "<div class='dropdown'>";
                        $xret["html"].= "<button class='btn btn-primary dropdown-toggle fw-bold' type='button' id='dropdownMenuButton1-".$row['recid']."'  data-bs-toggle='dropdown' aria-expanded='false'>";
                            $xret["html"].= "Action";
                        $xret["html"].= "</button>";

                        $xret["html"].= "<ul class='dropdown-menu main_action_dd' aria-labelledby='dropdownMenuButton1-".$row['recid']."'>";

                            if((int)$_SESSION["edit_crud"] == 1){
                                if(!empty($_POST["cus_function_name"])){
                                    $xret["html"].= "<li onclick=\"".$_POST['cus_function_name']."('getEdit' , '".$row['recid']."')\">";
                                }else{
                                    $xret["html"].= "<li onclick=\"ajaxFunc('getEdit' , '".$row['recid']."')\">";
                                }
                                    $xret["html"].= "<a class='dropdown-item dd_action' style='color:#008ae6;font-weight:bold;'><i class='fas fa-pencil-alt'></i><span style='margin-left:7px;font-size:17px;font-family:arial'>Edit</span></a>";
                                $xret["html"].= "</li>";
                            }

                            if((int)$_SESSION["delete_crud"] == 1){
                                if(!empty($_POST["cus_function_name"])){
                                    $xret["html"].= "<li onclick=\"".$_POST['cus_function_name']."('delete' , '".$row['recid']."')\">";
                                }else{
                                    $xret["html"].= "<li onclick=\"ajaxFunc('delete' , '".$row['recid']."')\">";
                                }
                                
                                    $xret["html"].= "<a class='dropdown-item dd_action' style='color:#ff3333;font-weight:bold;'><i class='fas fa-trash-alt'></i><span style='margin-left:7px;font-size:17px;font-family:arial'>Delete</span></a>";
                                $xret["html"].= "</li>";
                            }   

                            if(isset($_POST["xdata_btn"])){
                                foreach($_POST["xdata_btn"] as $xdata_btn_key => $xdata_btn_value){
                                    $btn_header = $xdata_btn_value[0]["btn-header"];
                                    $btn_color  = $xdata_btn_value[1]["btn-color"];
                                    $btn_logo = $xdata_btn_value[2]["btn-logo"];
                                    $btn_function = $xdata_btn_value[3]["btn-function"];

                                    $xret["html"].= "<li onclick=\"$btn_function\">";
                                        $xret["html"].= "<a class='dropdown-item' style='color:".$btn_color."'>".$btn_logo."<span style='margin-left:7px;font-size:17px;font-family:arial'>".$btn_header."</span></a>";
                                    $xret["html"].= "</li>";
                                }
                            }

                        $xret["html"].= "</ul>";
                    $xret["html"].= "</div>";
                $xret["html"].= "</td>";
            }

        $xret["html"] .= "</tr>";

        $xhtml_mobile_counter = 0;

        foreach($_POST["xfields"] as $xfields_arr_key => $xfields_arr_val){
            $xstyle = ''; 
            $xhtml_mobile_counter++;

            if(((int)$_SESSION["edit_crud"] !== 1 && (int)$_SESSION["delete_crud"] !== 1) && ($xhtml_mobile_counter == $_POST["field_num"])){
                $xstyle = 'border-bottom:2px solid black;';
            }

            

            $xret["html_mobile"] .= "<tr style='".$xstyle."'>";

            $field_name = remove_xfields($xfields_arr_val[0]["name"], "fname");
            $field_type = $xfields_arr_val[1]["data-field-type"];

            $field_fw = (
                        !isset($xfields_arr_val[2]["data-field-fw"]) ||
                        empty($xfields_arr_val[2]["data-field-fw"]) ||
                        $xfields_arr_val[2]["data-field-fw"] == "normal" ||
                        $xfields_arr_val[2]["data-field-fw"] == "none"
                        ) ? "normal" : $xfields_arr_val[2]["data-field-fw"];

            $xret["html_mobile"] .= "<td style='font-weight:bold;'>";
                $xret["html_mobile"].= "<span>".$xfields_arr_val[3]["data-field-header"]."</span>";
            $xret["html_mobile"] .= "</td>";

            if($field_type == "date"){

                if(!empty($row[$field_name]) && $row[$field_name] !== NULL &&  $row[$field_name]!=="1970-01-01"){
                    $row[$field_name] = date("m-d-Y",strtotime($row[$field_name]));
                    $row[$field_name] = str_replace('-','/',$row[$field_name]);
                }else{
                    $row[$field_name] = NULL;
                }

            }

            if($field_type == "checkbox"){

                if($row["".$field_name.""] == 0){
                    $xret["html_mobile"] .= "<td data-label='".$xfields_arr_val[3]["data-field-header"]."'>";
                        $xret["html_mobile"].= "<input type='checkbox' class='form-check-input' style='opacity:1' disabled>";
                    $xret["html_mobile"] .= "</td>";
                }else{
                    $xret["html_mobile"] .= "<td data-label='".$xfields_arr_val[3]["data-field-header"]."'>";
                        $xret["html_mobile"].= "<input type='checkbox' class='form-check-input' style='opacity:1' checked disabled>";
                    $xret["html_mobile"] .= "</td>";
                }

            }


            if($row[$field_name] == NULL){
                $row[$field_name] = '&nbsp';
            }

            if($field_type == "dropdown_custom"){

                $dropdown_field_name = $xfields_arr_val[4]["data-dd-field_name"];
                $dropdown_field_name_value = (isset($xfields_arr_val[5]["data-dd-field_name-value"]))?($xfields_arr_val[5]["data-dd-field_name-value"]) : "";
                $dropdown_tablename       = $xfields_arr_val[6]["data-dd-tablename"];

                if($dropdown_field_name_value !== ""){
                    $select_db_dd="SELECT ".$dropdown_field_name_value.", ".$dropdown_field_name." FROM ".$dropdown_tablename." where ".$dropdown_field_name."='".$row["".$dropdown_field_name.""]."'";
                }else{
                    $select_db_dd="SELECT ".$dropdown_field_name." FROM ".$_POST["tablename"]." WHERE ".$dropdown_field_name." LIKE '%".$row["".$dropdown_field_name.""]."%'";
                }
            

                $stmt_dd	= $link->prepare($select_db_dd);
                $stmt_dd->execute();

                while($rs_dd = $stmt_dd->fetch()){

                    if($dropdown_field_name_value !== ""){
                        $row[$field_name] = $rs_dd[$dropdown_field_name_value];
                    }
                    else{
                        $row[$field_name] = $rs_dd[$dropdown_field_name];
                    }

                }

            }

            if($field_type !== "checkbox"){

                if(!empty($field_decimal_place)){
                    $xret["html_mobile"] .= "<td style='font-weight:".$field_fw.";text-align:right' data-label='".$xfields_arr_val[3]["data-field-header"]."'>";
                        $xret["html_mobile"].= "<span>".number_format($row["".$field_name.""],$field_decimal_place)."</span>";
                    $xret["html_mobile"] .= "</td>";
                }else{
                    $xret["html_mobile"] .= "<td style='font-weight:".$field_fw."' data-label='".$xfields_arr_val[3]["data-field-header"]."'>";
                        $xret["html_mobile"].= "<span>".$row["".$field_name.""]."</span>";
                    $xret["html_mobile"] .= "</td>";
                }
            }

            $xret["html_mobile"] .= "</tr>";

        }

        if(($_POST["display_only"] !== "Y"|| empty($_POST["display_only"])) && ((int)$_SESSION["edit_crud"] == 1 || (int)$_SESSION["delete_crud"] == 1)){

            $xret["html_mobile"] .= "<tr>";
                $xret["html_mobile"] .= "<td style='font-weight:bold;' class='align-middle'>";
                    $xret["html_mobile"].= "<span>Action</span>";
                $xret["html_mobile"] .= "</td>";

                $xret["html_mobile"].= "<td class='text-center align-middle' data-label='Action'>";
                    $xret["html_mobile"].= "<div class='dropdown'>";
                        $xret["html_mobile"].= "<button class='btn btn-primary dropdown-toggle fw-bold' type='button' id='dropdownMenuButton1-".$row['recid']."'  data-bs-toggle='dropdown' aria-expanded='false'>";
                            $xret["html_mobile"].= "Action";
                        $xret["html_mobile"].= "</button>";

                        $xret["html_mobile"].= "<ul class='dropdown-menu main_action_dd' aria-labelledby='dropdownMenuButton1-".$row['recid']."'>";

                            if((int)$_SESSION["edit_crud"] == 1){
                                if(!empty($_POST["cus_function_name"])){
                                    $xret["html_mobile"].= "<li onclick=\"".$_POST['cus_function_name']."('getEdit' , '".$row['recid']."')\">";
                                }else{
                                    $xret["html_mobile"].= "<li onclick=\"ajaxFunc('getEdit' , '".$row['recid']."')\">";
                                }

                                    $xret["html_mobile"].= "<a class='dropdown-item dd_action' style='color:#008ae6;font-weight:bold;'><i class='fas fa-pencil-alt'></i><span style='margin-left:7px;font-size:17px;font-family:arial'>Edit</span></a>";
                                $xret["html_mobile"].= "</li>";
                            }
                            if((int)$_SESSION["delete_crud"] == 1){
                                if(!empty($_POST["cus_function_name"])){
                                    $xret["html_mobile"].= "<li onclick=\"".$_POST['cus_function_name']."('delete' , '".$row['recid']."')\">";
                                }else{
                                    $xret["html_mobile"].= "<li onclick=\"ajaxFunc('delete' , '".$row['recid']."')\">";
                                }
                            
                                    $xret["html_mobile"].= "<a class='dropdown-item dd_action' style='color:#ff3333;font-weight:bold;'><i class='fas fa-trash-alt'></i><span style='margin-left:7px;font-size:17px;font-family:arial'>Delete</span></a>";
                                $xret["html_mobile"].= "</li>";
                            }

                            if(isset($_POST["xdata_btn"])){
                                foreach($_POST["xdata_btn"] as $xdata_btn_key => $xdata_btn_value){
                                    $btn_header = $xdata_btn_value[0]["btn-header"];
                                    $btn_color  = $xdata_btn_value[1]["btn-color"];
                                    $btn_logo = $xdata_btn_value[2]["btn-logo"];
                                    $btn_function = $xdata_btn_value[3]["btn-function"];

                                    $xret["html_mobile"].= "<li onclick=\"$btn_function\">";
                                        $xret["html_mobile"].= "<a class='dropdown-item' style='color:".$btn_color."'>".$btn_logo."<span style='margin-left:7px;font-size:17px;font-family:arial'>".$btn_header."</span></a>";
                                    $xret["html_mobile"].= "</li>";
                                }
                            }

                        $xret["html_mobile"].= "</ul>";
                    $xret["html_mobile"].= "</div>";
                $xret["html_mobile"].= "</td>";
            $xret["html_mobile"] .= "</tr>";
        }

    };



    

echo json_encode($xret);
?>