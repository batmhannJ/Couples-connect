<?php 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require "includes/main_header.php";
require "pager/pager_main.class.php";

?>

    <style>

        .data_table{
            border-collapse:collapse;
            width:100%;
        }

        .data_table tbody tr:nth-child(even){
            background-color:#f5f5f5;
        }

    </style>

    <script>
        function john(event2, id){
            alert(event2+","+id);
        }
    </script>

    <form name='myforms' id="myforms" method="post" target="_self"> 

        <table class='big_table'> 

            <tr colspan=1>

                <td colspan=1 class='td_bl'>
                                            
                    <?php
                        include 'includes/main_menu.php';
                    ?>
                </td>
 
                <td colspan=1 class="td_br" id="td_br">

                    <div class="container-fluid pt-2 main_br_div">

                        <?php
                           
                            $table1 = new pager("Users" , "mf_prog_users"  ,$link);
                            
                            $table1->add_crud = $add_crud;
                            $table1->edit_crud = $edit_crud;
                            $table1->delete_crud = $delete_crud;
                            $table1->view_crud = $view_crud;
                            $table1->export_crud = $export_crud;

                            //$table1->customize_function_name = 'sample_func';
                            //$table1->display_only = "Y";

                            $table1->field_code = "userid";
                            $table1->field_code_init = "USR-00001";

                            //ORDER (table ORDER BY)
                            $table1->table_order_by["field"] = "username";
                            $table1->table_order_by["type"] = "ASC";

                            //FIELDS  DISPLAY
                            $table1->field_type_dis["username"] = "text";
                            $table1->field_name_dis["username"] = "username";
                            $table1->field_header_dis["username"] = "Email";
                            $table1->field_font_weight_dis["username"] = "bold";

                            $table1->field_type_dis["secondary_email"] = "text";
                            $table1->field_name_dis["secondary_email"] = "secondary_email";
                            $table1->field_header_dis["secondary_email"] = "Secondary Email";
                            
                            // $table1->field_type_dis["usertype"] = "dropdown_normal";
                            // $table1->field_name_dis["usertype"] = "usertype";
                            // $table1->field_header_dis["usertype"] = "User Type";
                            // $table1->field_dropdown_list_crud["usertype"] = array('ADN','CNR','HED');

                            //FIELDS  CRUD(create,read,update,delete)
                            $table1->field_type_crud["username"] = "text";
                            $table1->field_name_crud["username"] = "username";
                            $table1->field_header_crud["username"] = "Email";
                            $table1->field_font_weight_crud["username"] = "bold";
                            $table1->field_is_required["username"] = "Y"; 

                            $table1->field_type_crud["secondary_email"] = "text";
                            $table1->field_name_crud["secondary_email"] = "secondary_email";
                            $table1->field_header_crud["secondary_email"] = "Secondary Email";

                            $table1->field_type_crud["password"] = "text";
                            $table1->field_name_crud["password"] = "password";
                            $table1->field_header_crud["password"] = "Pasword";
                            $table1->field_is_required["password"] = "Y"; 
                            $table1->field_is_unique["password"] = "N";
                            
                            // $table1->field_type_crud["usertype"] = "dropdown_normal";
                            // $table1->field_name_crud["usertype"] = "usertype";
                            // $table1->field_header_crud["usertype"] = "User Type";
                            // $table1->field_is_required["usertype"] = "Y"; 

                            //pager
                            $table1->show_pager = "Y";
                            $table1->pager_xlimit = 5;

                            //export
                            $table1->show_export = "N";

                            //search
                            $table1->show_search = "N";

                            $table1->save_page  = "N";

                            //alert
                            $table1->alert_del = "Y";

                            //alert_del_field is required when alerting delete
                            $table1->alert_del_field = "username";
                            // $table1->alert_del_dd_field_val = "position_desc";
                            // $table1->alert_del_dd_tablename = "mf_positionfile";
                            $table1->alert_del_logo_dir = $logo_dir;
                            
                            $table1->alert_del_logo_w = $logo_width;
                            $table1->alert_del_logo_h = $logo_height;

                            $date_today = date('m-d-Y');
                            $date_today = str_replace("-","_",$date_today);

                            //change the sample name
                            $table1->exp_txt_filename = "Sample Name_".$date_today."_pdf";

                            //user activity log
                            $table1->ua_field1  = "username";
                            $table1->ua_field2  = "userid";

                            //export settings
                            // $table1->exp_pdf = "var_dump.php";
                            // $table1->exp_txt = "export_page.php";

                            //CRUD
                            $table1->display_table();
                        ?>

                    </div>
                </td>

            </tr>
        </table>


    </form>

    
    <?php 
        // displays modal outside form to avoid confusion
        $table1->display_modal();
    ?>


   

<!-- PAGER JS -->   
<script src="pager/pager_js.class.js"> </script>
<?php 
require "includes/main_footer.php";
?>

