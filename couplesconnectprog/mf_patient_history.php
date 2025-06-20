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

                            //new pager(Main Name , Main Tablename , link (connection to DB))
                            $table1 = new pager("Medical Conditions" , "patient_history_templatefile"  ,$link);
                            
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
                            $table1->show_search = "Y";
                            $table1->show_export = "Y";
                            $table1->pager_xlimit = 20;

                            $table1->alert_del = "Y";
                            $table1->alert_del_logo_dir = $logo_dir;
                            $table1->alert_del_logo_w = $logo_width;
                            $table1->alert_del_logo_h = $logo_height;

                            $table1->alert_del_field = "disease";
                            $table1->alert_del_table = "patient_history_templatefile";


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
    <script>
        // function customize_crud(event ,recid){

        //     switch(event) {
        //         case "delete":
        //             if (confirm('Are you sure you want to delete?')) {
        //                 var xdata = "event_action=delete&recid="+recid;

        //                 jQuery.ajax({    

        //                     data:xdata,
        //                     dataType:"json",
        //                     type:"post",
        //                     url:"mf_patientfile_ajax.php", 

        //                     success: function(xdata){ 
        //                         window.location.reload();
        //                     },
        //                     error: function (request, status, error) {
        //                         alert(request.responseText);
        //                     }

        //                 })

        //             } else {
        //                 return;
        //             }
        //             break;
        //         case "insert":
        //             var xdata = $("#custom_modal *").serialize()+"&event_action=insert";
        //             break;
        //         case "getEdit":

        //                 $("#patient_event_action").val("edit_main");
        //                 $("#cus_recid_hidden").val(recid);
        //                 document.forms.myforms.method = "post";
        //                 document.forms.myforms.target = "_self";
        //                 document.forms.myforms.action = "mf_patientfile_add.php";
        //                 document.forms.myforms.submit();
        //             break;
        //         case "submitEdit":
        //             var xdata = $("#custom_modal *").serialize()+"&event_action=submitEdit";
        //             break;
        //         case "openInsert":

        //                     $("#patient_event_action").val("add_main");
        //                     document.forms.myforms.method = "post";
        //                     document.forms.myforms.target = "_self";
        //                     document.forms.myforms.action = "mf_patientfile_add.php";
        //                     document.forms.myforms.submit();
        //                 return;
        //     }

        // }
    </script>

    <script src="pager/pager_js.class.js"> </script>


<?php 
include "includes/main_footer.php";
?>

