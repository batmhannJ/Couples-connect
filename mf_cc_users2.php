<?php 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


include "includes/main_header.php";
require "pager/pager_main.class.php";

?>



    <form name='myforms' id="myforms" method="post" target="_self"> 
        <table class='big_table'> 
            <tr colspan=1>
                <td colspan=1 class='td_bl'>
                    <?php
                        include 'includes/main_menu.php';
                    ?>
                </td>
 
                <td colspan=1 class="td_br" id="td_br">

                    <div class="container mt-2">

                        

                        <?php


                            $table1 = new pager("USERS" , "mf_prog_users"  ,$link);
                            
                            $table1->add_crud = $add_crud;
                            $table1->edit_crud = $edit_crud;
                            $table1->delete_crud = $delete_crud;
                            $table1->view_crud = $view_crud;
                            $table1->export_crud = $export_crud;


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

                            $table1->field_type_dis["usertype"] = "text";
                            $table1->field_name_dis["usertype"] = "usertype";
                            $table1->field_header_dis["usertype"] = "User Type";

                            //FIELDS  CRUD(create,read,update,delete)
                            $table1->field_type_crud["username"] = "text";
                            $table1->field_name_crud["username"] = "username";
                            $table1->field_header_crud["username"] = "Email";
                            $table1->field_font_weight_crud["username"] = "bold";
                            $table1->field_is_required["username"] = "Y"; 

                            $table1->field_type_crud["secondary_email"] = "text";
                            $table1->field_name_crud["secondary_email"] = "secondary_email";
                            $table1->field_header_crud["secondary_email"] = "Secondary Email";
                            $table1->field_is_required["secondary_email"] = "N";

                            $table1->field_type_crud["usertype"] = "dropdown_normal";
                            $table1->field_name_crud["usertype"] = "usertype";
                            $table1->field_header_crud["usertype"] = "User Type";
                            $table1->field_dropdown_list_crud["usertype"] = array('DSK','CNR','HED');

                            $table1->field_type_crud["password"] = "text";
                            $table1->field_name_crud["password"] = "password";
                            $table1->field_header_crud["password"] = "Pasword";
                            $table1->field_is_required["password"] = "Y"; 
                            $table1->field_is_unique["password"] = "N";

                            //pager
                            $table1->show_pager = "Y";
                            $table1->show_export = "Y";
                            $table1->show_search = "Y";
                            $table1->pager_xlimit = 20;

                            //user activity log
                            $table1->ua_field1  = "username";
                            //$table1->ua_field2  = "cuscde";

                            //CRUD
                            $table1->display_table();
                        ?>

                    </div>
                </td>

            </tr>
        </table>
        <!-- HIDDEN --> 
        <input type="hidden" name="cus_recid_hidden" id="cus_recid_hidden">
        <input type="hidden" name="patient_event_action" id="patient_event_action">
        
    </form>

    
    <?php 
        // pager
        $table1->display_modal();
        // $table1->pager_js();
    ?>
    <script src="pager/pager_js.class.js"> </script>


<?php 
include "includes/main_footer.php";
?>

