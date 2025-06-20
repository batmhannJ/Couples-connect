<?php
    session_start();
    // echo "<pre>";
    // var_dump($_POST);

    $xfilter = '';
    $xorder = '';
    $search_text_input = $_POST['search_hidden_value'];
    //getting header fields
    $fields_count = 0;
    $fields = '';

    foreach($_POST["fields"] as $arr_key => $arr_val){

        if($fields_count == 0){
            $fields = $arr_val["fname"];
        }else{
            $fields .= ",".$arr_val["fname"];
        }

        if($arr_val["fname"] == $_POST['search_hidden_dd']){
            $search_dd_field = $_POST["search_hidden_dd"];
            $_POST["search_hidden_dd"] = $arr_val["fheader"];
        }
        $fields_count++;
    }
    $fields.=",recid";

        if((isset($search_dd_field) && !empty($search_dd_field)) && isset($_POST['search_hidden_value']) &&
       (!isset($_POST["first_load_hidden"]) || $_POST["first_load_hidden"] !== "Y")){

        $xorder = "ORDER BY ".$search_dd_field." ASC";
        if($_POST["search_hidden_type"] == "checkbox"){
            if($search_text_input !== 'all'){
                $xfilter = "AND ".$search_dd_field." ='".$search_text_input."'";
            }

        }
        else if($_POST["search_hidden_type"] == "date"){
            $search_text_input  = (empty($search_text_input))   ? NULL :  date("Y-m-d", strtotime($search_text_input));

            if($search_text_input == NULL){
                $xfilter = "";
            }else{
                $xfilter = "AND ".$search_dd_field." LIKE '%".$search_text_input."%'";
            }
        }   
        else if($_POST["search_hidden_type"] == "dropdown_custom"){

            $fields_count_search = 0;
            foreach($_POST["fields"] as $key_select => $value_select_search){
        
                $value_select_name =$value_select_search["fname"];
        
                    if($fields_count_search == 0){
                        $fields_search_cus_dd = $_POST["tablename_hidden"].".".$value_select_name;
                    }else{
                        $fields_search_cus_dd .= ",".$_POST["tablename_hidden"].".".$value_select_name;
                    }
        
                $fields_count_search++;
            }
            $fields_search_cus_dd.=",".$_POST["tablename_hidden"]."."."recid";
        
            foreach($_POST["fields"] as $key_select => $fields_arr_val){
        
                if($fields_arr_val["ftype"] == "dropdown_custom"){
        
                    $dropdown_field_name        = $fields_arr_val["f_dd_fieldname"]; 
                    $dropdown_field_name_value  = (isset($fields_arr_val["f_dd_fieldname_val"]))?($fields_arr_val["f_dd_fieldname_val"]) : ""; 
                    $dropdown_tablename         = $fields_arr_val["f_dd_tablename"];
            
                    if($dropdown_field_name_value !== ""){
                        $select_db_main = "SELECT ".$fields_search_cus_dd." FROM ".$_POST["tablename_hidden"]." INNER JOIN ".$dropdown_tablename
                        ." ON ".$_POST["tablename_hidden"].'.'.$dropdown_field_name.'  = '.$dropdown_tablename.'.'.$dropdown_field_name."
                            WHERE ".$dropdown_field_name_value." LIKE '%".$search_text_input."%'"." ORDER BY ".$_POST["tablename_hidden"].".".$dropdown_field_name;
                    }else{
                        $select_db_main = "SELECT ".$fields." FROM ".$_POST['tablename_hidden']." WHERE ".$dropdown_field_name." LIKE '%".$search_text_input."%' ORDER BY ".$dropdown_field_name." ASC";
                    }
            
                    
                }
        
            }
            
        
        }
        else{
            $_POST['search_hidden_value']  = (empty($_POST['search_hidden_value']))   ? NULL :  $_POST['search_hidden_value'];

            if($_POST['search_hidden_value'] == NULL){
                $xfilter = "";
            }else{
                $xfilter = "AND ".$search_dd_field." LIKE '%".$_POST['search_hidden_value']."%'";
            }

        }
    }else{
        $xorder = "ORDER BY ".$_POST["table_order_field"]." ".$_POST["table_order_type"];
    }

    if((isset($search_dd_field) && !empty($search_dd_field)) && isset($_POST['search_hidden_value']) &&
       (!isset($_POST["first_load_hidden"]) || $_POST["first_load_hidden"] !== "Y")){

        $xorder = "ORDER BY ".$search_dd_field." ASC";
        if($_POST["search_hidden_type"] == "checkbox"){
            if($search_text_input !== 'all'){
                $xfilter = "AND ".$search_dd_field." ='".$search_text_input."'";
            }

        }
        else if($_POST["search_hidden_type"] == "date"){
            $search_text_input  = (empty($search_text_input))   ? NULL :  date("Y-m-d", strtotime($search_text_input));

            if($search_text_input == NULL){
                $xfilter = "";
            }else{
                $xfilter = "AND ".$search_dd_field." LIKE '%".$search_text_input."%'";
            }
        }   
        else if($_POST["search_hidden_type"] == "dropdown_custom"){

            $fields_count_search = 0;
            foreach($_POST["fields"] as $key_select => $value_select_search){
        
                $value_select_name =$value_select_search["fname"];
        
                    if($fields_count_search == 0){
                        $fields_search_cus_dd = $_POST["tablename_hidden"].".".$value_select_name;
                    }else{
                        $fields_search_cus_dd .= ",".$_POST["tablename_hidden"].".".$value_select_name;
                    }
        
                $fields_count_search++;
            }
            $fields_search_cus_dd.=",".$_POST["tablename_hidden"]."."."recid";
        
            foreach($_POST["fields"] as $key_select => $fields_arr_val){
        
                if($fields_arr_val["ftype"] == "dropdown_custom"){
        
                    $dropdown_field_name        = $fields_arr_val["f_dd_fieldname"]; 
                    $dropdown_field_name_value  = (isset($fields_arr_val["f_dd_fieldname_val"]))?($fields_arr_val["f_dd_fieldname_val"]) : ""; 
                    $dropdown_tablename         = $fields_arr_val["f_dd_tablename"];
            
                    if($dropdown_field_name_value !== ""){
                        $select_db_main = "SELECT ".$fields_search_cus_dd." FROM ".$_POST["tablename_hidden"]." INNER JOIN ".$dropdown_tablename
                        ." ON ".$_POST["tablename_hidden"].'.'.$dropdown_field_name.'  = '.$dropdown_tablename.'.'.$dropdown_field_name."
                            WHERE ".$dropdown_field_name_value." LIKE '%".$search_text_input."%'"." ORDER BY ".$dropdown_tablename.".".$dropdown_field_name_value;
                    }else{
                        $select_db_main = "SELECT ".$fields." FROM ".$_POST['tablename_hidden']." WHERE ".$dropdown_field_name." LIKE '%".$search_text_input."%' ORDER BY ".$dropdown_field_name." ASC";
                    }
            
                    
                }
        
            }
            
        
        }
        else{
            $_POST['search_hidden_value']  = (empty($_POST['search_hidden_value']))   ? NULL :  $_POST['search_hidden_value'];

            if($_POST['search_hidden_value'] == NULL){
                $xfilter = "";
            }else{
                $xfilter = "AND ".$search_dd_field." LIKE '%".$_POST['search_hidden_value']."%'";
            }

        }
    }else{
        $xorder = "ORDER BY ".$_POST["table_order_field"]." ".$_POST["table_order_type"];
    }

    if(!isset($_POST["search_hidden_type"]) || $_POST["search_hidden_type"] !== "dropdown_custom"){
        $select_db_main="SELECT ".$fields." FROM ".$_POST["tablename_hidden"]." WHERE true " .$xfilter." ".$xorder;
    }else if($_POST["search_hidden_type"] == "dropdown_custom" && (isset($_POST["first_load_hidden"]) && $_POST["first_load_hidden"] == "Y")){

        $fields_count_search = 0;
        foreach($_POST["fields"] as $key_select => $value_select_search){
    
            $value_select_name =$value_select_search["fname"];
    
                if($fields_count_search == 0){
                    $fields_search_cus_dd = $_POST["tablename_hidden"].".".$value_select_name;
                }else{
                    $fields_search_cus_dd .= ",".$_POST["tablename_hidden"].".".$value_select_name;
                }
    
            $fields_count_search++;
        }
        $fields_search_cus_dd.=",".$_POST["tablename_hidden"]."."."recid";
     
        $dropdown_field_name        = $_POST["dd_field_name_search"]; 
        $dropdown_field_name_value  = (isset($_POST["dd_field_name_value_search"]))?($_POST["dd_field_name_value_search"]) : ""; 
        $dropdown_tablename         = $_POST["dd_tablename_search"];

        if($dropdown_field_name_value !== ""){

            $select_db_main = "SELECT ".$fields_search_cus_dd." FROM ".$_POST["tablename_hidden"]." INNER JOIN ".$dropdown_tablename
            ." ON ".$_POST["tablename_hidden"].'.'.$dropdown_field_name.'  = '.$dropdown_tablename.'.'.$dropdown_field_name."
                WHERE ".$dropdown_field_name_value." LIKE '%".$search_text_input."%'"." ORDER BY ".$_POST["tablename_hidden"].".".$_POST["table_order_field"]. " ".$_POST["table_order_type"];
        }else{
            $select_db_main = "SELECT ".$fields." FROM ".$_POST['tablename_hidden']." WHERE ".$dropdown_field_name." LIKE '%".$search_text_input."%' ORDER BY ".$_POST["table_order_field"]." ".$_POST["table_order_type"];
        }  

        
    }

    var_dump($select_db_main);



?>