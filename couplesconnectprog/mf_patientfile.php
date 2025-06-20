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

                            $table1 = new pager("Patients" , "patientfile"  ,$link);

                            $table1->add_crud = $add_crud;
                            $table1->edit_crud = $edit_crud;
                            $table1->delete_crud = $delete_crud;
                            $table1->view_crud = $view_crud;
                            $table1->export_crud = $export_crud;

                            $table1->customize_function_name = "customize_crud";

                            //field code
                            $table1->field_code = "cuscde";
                            $table1->field_code_init = "PT-00001";

                            //ORDER (table ORDER BY)
                            $table1->table_order_by["field"] = "cusdsc";
                            $table1->table_order_by["type"] = "ASC";

                            //FIELDS  DISPLAY
                            $table1->field_type_dis["cusdsc"] = "text";
                            $table1->field_name_dis["cusdsc"] = "cusdsc";
                            $table1->field_header_dis["cusdsc"] = "Patient Name";
                            $table1->field_font_weight_dis["cusdsc"] = "bold";

                            $table1->field_type_dis["adddte"] = "date";
                            $table1->field_name_dis["adddte"] = "adddte";
                            $table1->field_header_dis["adddte"] = "Date Added";
 
                            // $table1->field_type_dis["bloodtype"] = "dropdown_custom";
                            // $table1->field_name_dis["bloodtype"] = "bloodtypcde";
                            // $table1->field_header_dis["bloodtype"] = "Blood Type";
                            // $table1->field_dropdown_tablename_dis["bloodtype"] =  "bloodtypefile";
                            // $table1->field_dropdown_field_name_dis["bloodtype"] = "bloodtypcde";
                            // $table1->field_dropdown_field_name_value_dis["bloodtype"] = "bloodtypdsc";
                            // $table1->field_font_weight_dis["birthday"] = "bold";

                            //pager
                            $table1->show_pager = "Y";
                            $table1->show_export = "Y";
                            $table1->pager_xlimit = 4;

                            //search
                            $table1->show_search = "Y";

                            //user activity log
                            $table1->alert_del = "Y";
                            $table1->alert_del_field = "cusdsc";
                            $table1->alert_del_dd_field_val = "";
                            $table1->alert_del_dd_tablename = "patientfile";
                            
                            $table1->alert_del_logo_dir = $logo_dir;
                            $table1->alert_del_logo_w = $logo_width;
                            $table1->alert_del_logo_h = $logo_height;

                            $table1->ua_field1  = "cusdsc";
                            $table1->ua_field2  = "cuscde";


                            $date_today = date('m-d-Y');
                            $date_today = str_replace("-","_",$date_today);
                            
                            //change the sample name
                            $table1->exp_txt_filename = "Patients_".$date_today."_pdf";

                            //custom
                            $table1->save_page  = "Y";
                            $table1->txt_pager_pageno_hidden = (!isset($_POST['txt_pager_pageno_hidden']))   ? NULL :  $_POST['txt_pager_pageno_hidden'];
                            $table1->search_hidden_save_input = (!isset($_POST['search_hidden_save_input']))   ? NULL :  $_POST['search_hidden_save_input'];
                            $table1->search_hidden_save_dd = (!isset($_POST['search_hidden_save_dd']))   ? NULL :  $_POST['search_hidden_save_dd'];
                            $table1->check_search_save = (!isset($_POST['check_search']))   ? NULL :  $_POST['check_search'];
                            $table1->search_current_dd = (!isset($_POST['search_current_dd']))   ? NULL :  $_POST['search_current_dd'];
                            $table1->search_current_input = (!isset($_POST['search_current_input']))   ? NULL :  $_POST['search_current_input'];
                            $table1->event_save_hidden = (!isset($_POST['event_save_hidden']))   ? NULL :  $_POST['event_save_hidden'];
                            $table1->datatype_hidden = (!isset($_POST['search_current_dd_datatype']))   ? NULL :  $_POST['search_current_dd_datatype'];
                            $table1->search_current_dd_field = (!isset($_POST['search_current_dd_field']))   ? NULL :  $_POST['search_current_dd_field'];
                            $table1->search_current_dd_field_val = (!isset($_POST['search_current_dd_field_val']))   ? NULL :  $_POST['search_current_dd_field_val'];
                            $table1->search_current_dd_table = (!isset($_POST['search_current_dd_table']))   ? NULL :  $_POST['search_current_dd_table'];
                            $table1->search_event_action = (!isset($_POST['search_event_action']))   ? NULL :  $_POST['search_event_action'];
                            $table1->search_event_action2 = (!isset($_POST['search_event_action2']))   ? NULL :  $_POST['search_event_action2'];

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

    ?>
    <script>

        function customize_crud(event ,recid){

            switch(event) {
                case "delete":

                    var alert_delete = $("#alert_delete").val();


                    if(alert_delete == "Y"){

                        var delField = $("#alert_del_field").val();
                        var tablename  = $("#tablename_hidden").val();
                        var delFieldDDVal = $("#alert_del_dd_field_val").val();
                        var delFieldDDtablename = $("#alert_del_dd_tablename").val();
                        var userid = $("#session_userid").val();
                        
                            jQuery.ajax({    
                                data:{
                                    recid:recid,
                                    delField:delField,
                                    delFieldDDVal:delFieldDDVal,
                                    delFieldDDtablename:delFieldDDtablename,
                                    event_action:"getDelete",
                                    tablename:tablename,
                                    userid:userid
                                },
                                dataType:"json",
                                type:"post",
                                url:"pager/pager_ajax.class.php", 

                                success: function(xdata){ 

                                    $(".modalDelField").html(xdata["field"]);
                                    $("#delete_modal_btn").html("<button type='button' style='width:70px' class='btn btn-primary' onclick=\"ajaxFunc('"+event+"',"+recid+", 'modal')\">Yes</button>");
                                    $("#main_delete_modal").modal('show');


                                    
                                },
                                error: function (request, status, error) {
                                    alert(request.responseText);
                                }
                                
                            })

                        return;


                    }



                    var xdata = "event_action=delete&recid="+recid;

                    jQuery.ajax({    

                        data:xdata,
                        dataType:"json",
                        type:"post",
                        url:"mf_patientfile_ajax.php", 

                        success: function(xdata){ 
                            window.location.reload();
                        },
                        error: function (request, status, error) {
                            alert(request.responseText);
                        }

                    })

                 
                    break;
                case "insert":
                    var xdata = $("#custom_modal *").serialize()+"&event_action=insert";
                    break;
                case "getEdit":

                        $("#patient_event_action").val("edit_main");
                        $("#cus_recid_hidden").val(recid);
                        document.forms.myforms.method = "post";
                        document.forms.myforms.target = "_self";
                        document.forms.myforms.action = "mf_patientfile_add.php";
                        document.forms.myforms.submit();
                    break;
                case "submitEdit":
                    var xdata = $("#custom_modal *").serialize()+"&event_action=submitEdit";
                    break;
                case "openInsert":

                            $("#patient_event_action").val("add_main");
                            document.forms.myforms.method = "post";
                            document.forms.myforms.target = "_self";
                            document.forms.myforms.action = "mf_patientfile_add.php";
                            document.forms.myforms.submit();
                        return;
            }

        }
    </script>

    <script src="pager/pager_js.class.js"> </script>


<?php 
include "includes/main_footer.php";
?>

