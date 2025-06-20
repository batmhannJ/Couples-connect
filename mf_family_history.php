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


                            $table1 = new pager("Family Medical History" , "fam_history_templatefile"  ,$link);
                            
                            $table1->add_crud = $add_crud;
                            $table1->edit_crud = $edit_crud;
                            $table1->delete_crud = $delete_crud;
                            $table1->view_crud = $view_crud;
                            $table1->export_crud = $export_crud;


                            //ORDER (table ORDER BY)
                            $table1->table_order_by["field"] = "disease";
                            $table1->table_order_by["type"] = "ASC";

                            //FIELDS  DISPLAY
                            $table1->field_type_dis["disease"] = "text";
                            $table1->field_name_dis["disease"] = "disease";
                            $table1->field_header_dis["disease"] = "Disease";
                          
                            //FIELDS  CRUD(create,read,update,delete)
                            $table1->field_type_crud["disease"] = "text";
                            $table1->field_name_crud["disease"] = "disease";
                            $table1->field_header_crud["disease"] = "Disease";
                            $table1->field_is_required["disease"] = "Y"; 
                            $table1->field_is_unique["disease"] = "Y";

                            //pager
                            $table1->show_pager = "Y";
                            $table1->show_export = "Y";
                            $table1->show_search = "Y";
                            $table1->pager_xlimit = 20;

                            //user activity log
                            $table1->ua_field1  = "disease";
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

