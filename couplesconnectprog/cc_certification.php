<?php
require "includes/cc_header.php";

$header_name = '';
if($_SESSION['usertype'] == 'DSK'){
    $header_name = "DESK";
}else if($_SESSION['usertype'] == 'CNR'){
    $header_name = "COUNSELOR";
}else if($_SESSION['usertype'] == 'HED'){
    $header_name = "HEAD";
}

?>

    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <style>

        #search_text:focus{
            outline:none;
        }
    </style>
    <div class="container-fluid">
        <div class='row bg-white' style="height:99px">
            <div class="col-3 pe-0 d-flex align-items-center">
                <img src="images/350 x 88.png" style='height:76px;width:auto;'>
            </div>

            <div class="col-3 offset-6" style="display:flex;flex-direction:row;justify-content:center;font-family:inter;font-size:21px;align-items:center"> 
                <div style="flex:0.5;text-align:right;margin-right:10px">
                    <a href="http://localhost/couplesconnectprog/select_option.php" style='color:black;text-decoration:none' class='has_hover'>HOME</a>
                </div>

                <div style="flex:.1;text-align:center;padding-right:10px">
                    <a style='color:black;text-decoration:none'>|</a>
                </div>

                <div style="flex:.3;text-align:center;padding-right:15px">
                    <a style='color:black;text-decoration:none'><?php echo $header_name;?> </a>
                </div>

                <div style="flex:0.6;text-align:right;padding-right:35px">
                    <a href="http://localhost/couplesconnectprog/logout_cc.php"  class='has_hover' style='color:black;text-decoration:none'>LOGOUT</a>
                </div>

            </div> 
        </div>
    </div>

    <form name='myforms' id="myforms" method="post" target="_self" style='height:100%'> 
    <table style="width:100%;height:100%;background-color:#f2f2f2">
            <tr>
                <td style='width:30%'>
                    <div class="row h-100 justify-content-center align-items-center">
                        <div style='width:437px;height:700px;background-color:white;border-radius:30px;filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25))'>
                            <div class="m-3 pt-2 text-center login_form_header">
                                <p style="font-weight:bold;font-size:27px;font-family:inter;margin-bottom:0">Options</p>
                                <img src="images/Rectangle 11934.png" style='width:100%'>
                            </div>

                            <?php
                                require 'cc_mf_menu.php';
                            ?>
                         
                        </div>
                    </div>
                </td>

                <td style='width:70%'>
                    <div class="row h-100 justify-content-center align-items-center">
                        <div style='width:1025px;height:700px;background-color:white;border-radius:30px;filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25));display:flex;flex-direction:column'>

                            <div class="m-3 pt-2 text-center">
                                    <p style="font-weight:bold;font-size:27px;font-family:inter;margin-bottom:0">Certificates</p>
                                    <img src="images/Rectangle 11934.png" style='width:100%;height:4px'>
                            </div>

                            <div class="container text-center">
                           
                                        <?php if(isset($_GET['dateFrom']) && isset($_GET['dateTo'])):?>
                                            <a href="cc_certification.php" class="btn btn-primary text-white">Clear</a>
                                        <?php else: ?>
                                    <div class="card">
                                    <div class="card-body d-flex justify-content-between align-items-center gap-2">
                                         <label>Date Form:</label>
                                        <input type="date" class="form-control" id="dateFrom">
                                        <label>Date To:</label>
                                        <input type="date" class="form-control" id="dateTo">
                                        <br>
                                            <button type="button" class="btn btn-primary btn-filter">Filter</button>
                                    </div>
                                </div>
                                        <?php endif; ?>
                                  
                            </div>
                            <script>
                                $('.btn-filter').click((e)=>{
                                    let dateFrom = $('#dateFrom').val(), dateTo = $('#dateTo').val();

                                    window.location.href = `?dateFrom=${encodeURIComponent(dateFrom)}&dateTo=${encodeURIComponent(dateTo)}`;

                                })
                            </script>


                            <div class="m-3 d-flex justify-content-center" style='overflow:auto'>
                                <table style='width:80%;height:100%'>

                                    <thead>
                                        <tr>
                                            <td colspan="2">
                                                <!-- <div class="input-group mb-3" style='
                                                width:300px;
                                                height:40px;
                                                filter: drop-shadow(0px 4px 10px rgba(0, 0, 0, 0.25))'>
                                                    <span class="input-group-text" id="inputGroup-sizing-sm" style='
                                                    background-color:white;
                                                    border-top-left-radius:15px;
                                                    border-bottom-left-radius:15px;'><i class="fas fa-search"></i></span>
                                                    <input type="text" style='
                                                    border-left:none;
                                                    border-top-right-radius:15px;
                                                    border-bottom-right-radius:15px' name="search_text" id="search_text" class="form-control shadow-none" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder='Search'> 
                                                </div>-->
                                            </td>
                                        </tr>

                                        <tr style='font-size:21px;font-family:inter;font-weight:700;color:#797979'>
                                            <td>
                                                Email
                                            </td>

                                            <td>
                                                Date Printed
                                            </td>

                                            <td>
                                                Control Number
                                            </td>

                                            <td>
                                                &nbsp; &nbsp;
                                            </td>
                                        </tr>

                                    </thead>


                                    <tbody name="tbody_table" id="tbody_table">
                                        <?php

                                        if(isset($_GET['dateFrom']) && isset($_GET['dateTo'])) {

                                            $datefrom = $_GET['dateFrom'];
                                            $dateto = $_GET['dateTo'];

                                            $select_db_ac = "
                                                SELECT 
                                                    pro_cert_table.status AS 'cert_status', 
                                                    mf_prog_users.username AS 'username', 
                                                    pro_cert_table.date_claimed AS 'date_claimed', 
                                                    pro_cert_table.control_number AS 'cntrl_number', 
                                                    pro_cert_table.recid AS 'recid_cert', 
                                                    pro_cert_table.reason AS 'reason', 
                                                    mf_prog_users.recid AS 'recid_users'
                                                FROM 
                                                    pro_cert_table 
                                                LEFT JOIN 
                                                    mf_prog_users 
                                                ON 
                                                    pro_cert_table.userid = mf_prog_users.userid
                                                WHERE 
                                                    pro_cert_table.date_claimed BETWEEN '$datefrom' AND '$dateto'
                                                ORDER BY 
                                                    pro_cert_table.status ASC, 
                                                    mf_prog_users.date_requested DESC
                                            ";

                                        } else {

                                              $select_db_ac="SELECT pro_cert_table.status as 'cert_status', 
                                              mf_prog_users.username  as 'username', 
                                              pro_cert_table.date_claimed as 'date_claimed',
                                              pro_cert_table.control_number as 'cntrl_number',
                                              pro_cert_table.recid as 'recid_cert',
                                              pro_cert_table.reason as 'reason',
                                              mf_prog_users.recid as 'recid_users'
                                                FROM pro_cert_table LEFT JOIN mf_prog_users ON pro_cert_table.userid = mf_prog_users.userid ORDER BY pro_cert_table.status ASC, mf_prog_users.date_requested DESC";
                                        }



                                              $stmt	= $link->prepare($select_db_ac);
                                              $stmt->execute();
                                              while($rs_ac = $stmt->fetch()){

                                                    $cert_color = '';
                                                    if($rs_ac['cert_status'] == 'PRP'){
                                                        $cert_color = '#FF7800';
                                                    }else if($rs_ac['cert_status'] == 'PUP'){
                                                        $cert_color = '#2ECD6E';
                                                    }else if($rs_ac['cert_status'] == 'RCV'){
                                                        $cert_color = '#08A9F4';
                                                    }

                                                    if ($rs_ac['cert_status'] === 'APRV' ) {
                                                        $status = "APPROVED";
                                                    } else if ($rs_ac['cert_status'] === 'DEC' ) {
                                                        $status = "DECLINED";
                                                    } else {
                                                        $status = "PENDING";
                                                    }
                                                  
                                                  echo "<tr style='font-size:21px;font-family:inter;font-weight:700;color:black'>";
                                                        echo "<td class='pt-4'>";
                                                            echo "".$rs_ac['username']."";
                                                        echo "</td>";

                                              
                                                        echo "<td class='pt-4'>";
                                                            echo "".date('F d, Y', strtotime($rs_ac['date_claimed']))."";
                                                        echo "</td>";

                                                        echo "<td class='pt-4' style='color:".$cert_color."'>";
                                                            echo $rs_ac['cntrl_number'];
                                                        echo "</td>";

                                                        echo "<td class='pt-4 d-flex justify-content-end'>";
                                 
                                                                echo "<button onclick='review(\"{$rs_ac['recid_users']}\",\"{$rs_ac['recid_cert']}\",\"{$rs_ac['reason']}\")' type='button' style='border:none;background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;padding-top:5px;padding-bottom:5px;height:auto;font-size:21px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>";
                                                                echo $status;
                                                                echo "</button>";
                            
                                                        echo "</td>";
                                                  echo "</tr>";
              
                                              }

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </td>    
            </tr>
        
        </table>

        <div class="modal fade  xerror_modal" data-bs-backdrop="static" id="xerror_modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Couples Connect Says:</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="error_msg">Modal body text goes here.</p>
                    </div>
     
                </div>
            </div>
        </div>


        <div class="modal fade modal_cert_reason" id="modal_cert_reason" style="display: none;" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style='border-radius:25px'>
                <div class="modal-header">
                    <div class="modal-title">
                        <div style="color:black;font-family:inter;color:#252733;font-size:33px;font-weight:600">Certification</div>
                        <div style="color:black;font-family:inter;color:#9B9B9B;font-size:21px;margin-top:-5px">Request</div>
                    </div>
          
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mx-3">
                    <label for="" style='font-size:21px;color:252733;font-weight:600;font-family:inter'>Reason for request:</label>
                    <p id="reason" cols="30" rows="10" style='font-size: 18px;'></p>
                    <div style='display:flex;justify-content:center;padding-top:25px;padding-bottom:20px'>
                        <button type="button" class="btn" id="appBtn" style=";background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:250px;height:45px;font-size:25px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25)); margin-right: 12px;">APPROVE</button>
                        <button type="button" id="decBtn" class="btn" style=";background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:250px;height:45px;font-size:25px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">DECLINE</button>
                    </div>
                    
                </div>
          
                </div>
            </div>
        </div>

        <div class="modal fade modal_dec_cert_reason" id="modal_dec_cert_reason" style="display: none;" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style='border-radius:25px'>
                <div class="modal-header">
                    <div class="modal-title">
                        <div style="color:black;font-family:inter;color:#252733;font-size:33px;font-weight:600">Certification</div>
                        <div style="color:black;font-family:inter;color:#9B9B9B;font-size:21px;margin-top:-5px">Request</div>
                    </div>
          
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mx-3">
                    <label for="" style='font-size:21px;color:252733;font-weight:600;font-family:inter'>Reason for declination:</label>
                    <textarea id="dec_reason" class="form-control" cols="30" rows="10" placeholder="Enter reason" style='font-size: 18px;'></textarea>
                    <div style='display:flex;justify-content:center;padding-top:25px;padding-bottom:20px'>
                        <button type="button" id="decReasonBtn" class="btn" style=";background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:250px;height:45px;font-size:25px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">SUBMIT</button>
                    </div>
                    
                </div>
          
                </div>
            </div>
        </div>

        <input type="hidden" name="ac_recid_hidden" id="ac_recid_hidden">
        <input type="hidden" name="cert_recid_hidden" id="cert_recid_hidden">

        <input type="hidden" name="cus_recid_hidden" id="cus_recid_hidden">
        
    </form>

    <script>


    
    function review(recid_users,recid_cert, reason){

        $('#reason').append(reason);

        $('#cert_recid_hidden').val(recid_cert);

        $('#modal_cert_reason').modal('show');

        $('#appBtn').click(() => {
            jQuery.ajax({    
            data:{
                cert_status: 'APRV',
                cert_recid_hidden: $('#cert_recid_hidden').val(),
                userid: recid_users
            },
            type:"post",
            url:"cc_certification2_ajax.php", 
            success: function(xdata){
                window.location.reload();
            },
            error: function (request, status, error) {
                console.log(error.message)
            }
        
        })
        });

        $('#decBtn').click(() => {
            $("#modal_cert_reason").modal("hide");
            $("#modal_dec_cert_reason").modal("show");
            $("#decReasonBtn").click(() => {
                jQuery.ajax({    
                   data:{
                   cert_status: 'DEC',
                   cert_recid_hidden: $('#cert_recid_hidden').val(),
                   reason: $("#dec_reason").val(),
                   userid: recid_users
                },
                type:"post",
                url:"cc_certification2_ajax.php", 
                success: function(xdata){
                   window.location.reload();
                },
                error: function (request, status, error) {
                   console.log(error.message)
                }
            });
        
          });
        });


        return;

        $("#ac_recid_hidden").val(recid_users);
        $("#cert_recid_hidden").val(recid_cert)

        const modal = ` `
        
        document.forms.myforms.method = "post";
        document.forms.myforms.target = "_self";
        document.forms.myforms.action = "cc_certification2.php";
        document.forms.myforms.submit();
    }


    </script>


</div>


        
        <!-- BOOSTRAP JS -->
        <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- CUSTOM SCRIPTS -->
        <script>
            //get crudModal
            var crudModal = document.getElementById('crudModal');

            if(crudModal !== null){
                //make sure error message is gone
                crudModal.addEventListener('hidden.bs.modal', function (event) {
                    $(".error_msg").html("");
                })
            }

            function checkNumbers(xthis, before_dec, after_dec,xtype)
            {
                var numbers = xthis.value.split('.');
                var full_str = xthis.value;
                var preDecimal = numbers[0];
                var postDecimal = numbers[1];
                var field_id = xthis.id;

                var full_str_complete = $("#"+field_id).val();

                if(full_str.includes('.') && after_dec == -1){

                    new_num = full_str.substring(0, full_str.length - 1);
                    $("#"+field_id).val(new_num);
                    return;
                }

                if(postDecimal == null){

                    if (preDecimal.length > before_dec)
                    {
                        new_num = full_str.substring(0, full_str.length - 1);
                        $("#"+field_id).val(new_num)
                    } 
                }else{

                    if (preDecimal.length > before_dec || postDecimal.length > after_dec)
                    {
                        new_num = full_str.substring(0, full_str.length - 1);
                        $("#"+field_id).val(new_num);

                    } 
                    
                }
                
            }

            function onlyNumberKeyWDecimal(evt){
                var ASCIICode = (evt.which) ? evt.which : evt.keyCode
                console.log(ASCIICode);
                if ((ASCIICode > 31) && (ASCIICode < 48 || ASCIICode > 57) && (ASCIICode !==46))
                    return false;
                return true;
                
            }

            function check_enter(evt) {

                var ASCIICode = (evt.which) ? evt.which : evt.keyCode
                if(ASCIICode == 13){
                    page_click("search");
                }
            }

            function onlyNumberKey(evt) {

                // Only ASCII character in that range allowed
                var ASCIICode = (evt.which) ? evt.which : evt.keyCode
                if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                    return false;
                return true;
            }

            var doc = document;
            var providers = doc.getElementsByClassName("tabbable");

            for (var i = 0; i < providers.length; i++) {
                providers[i].onclick = function() {
                console.log(this.innerHTML);
                };
            }

            //if screen is small do not make other data be pushed when opening menu
            if (window.matchMedia('(max-width: 576px)').matches)
            {
                $(".pagination").removeClass("pagination-lg")
                // $(".td_br").removeClass();

            }
        //to get the today working jquery
        var old_goToToday = $.datepicker._gotoToday
            $.datepicker._gotoToday = function(id) {
            old_goToToday.call(this,id)
            this._selectDate(id)
        }

        function setDatepickerPos(input, inst) {
            var rect = input.getBoundingClientRect();
            // use 'setTimeout' to prevent effect overridden by other scripts
            setTimeout(function () {
                var scrollTop = $("body").scrollTop();
                inst.dpDiv.css({ top: rect.top + input.offsetHeight + scrollTop });
            }, 0);
        }

        $( document ).on( "ajaxComplete", function() {
            $( ".date_picker" ).datepicker({
                showAnim: "slideDown",
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0",
                showOn: 'focus',
                showButtonPanel: true,
                inline:true,
                closeText: 'Clear', // Text to show for "close" button
                beforeShow: function (input, inst) { setDatepickerPos(input, inst) },
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

            })
        } );


        // $(window).on('shown.bs.modal', function (e) {

        //     // $("#ui-datepicker-div").remove();
        //     // $(".date_picker").datepicker( "destroy" );

        //     // var popup = document.getElementById('alert_modal');
        //     // var datePicker = document.getElementById('ui-datepicker-div');

        //     // if(datePicker){
        //     //     popup.appendChild(datePicker);
        //     // }

        //     $(".date_picker").datepicker({
        //         showAnim: "blind",
        //         changeMonth: true,
        //         changeYear: true,
        //         yearRange: "-100:+0",
        //         showOn: 'focus',
        //         showButtonPanel: true,
        //         closeText: 'Clear', // Text to show for "close" button
        //         beforeShow: function(input, inst) {

        //             // Handle calendar position before showing it.
        //             // It's not supported by Datepicker itself (for now) so we need to use its internal variables.
        //             var calendar = inst.dpDiv;

        //             // Dirty hack, but we can't do anything without it (for now, in jQuery UI 1.8.20)
        //             setTimeout(function() {
        //                 calendar.position({
        //                     my: 'right top',
        //                     at: 'right bottom',
        //                     collision: 'none',
        //                     of: input
        //                 });
        //             }, 1);

                    
        //         },onClose: function () {
        //                 $(this).blur();
        //                 var event = arguments.callee.caller.caller.arguments[0];
        //                 var event_checker = false;
        //                 if(event){
        //                     event_checker = event.hasOwnProperty('delegateTarget');
        //                 }
        //                 if(event_checker == true){
        //                     if ($(event.delegateTarget).hasClass('ui-datepicker-close')) {
        //                     $(this).val('');
        //                     }
        //                 }

        //         }
        //     }); 




        // })

        $( ".date_picker" ).datepicker({
            showAnim: "slideDown",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0",
            showOn: 'focus',
            showButtonPanel: true,
            inline:true,
            closeText: 'Clear', // Text to show for "close" button
            beforeShow: function (input, inst) { setDatepickerPos(input, inst) },
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

        })
        // $(".date_picker").datepicker().bind('click',function () {
        //     $(".date_picker").appendTo(".date_picker");
        // });
     
        //related to menu toggle javascript
        $(".menu-toggle").click(function(){
            $(".arrow_toggle").toggleClass("open");
            $(".td_bl").toggleClass("menuDisplayed");

            if($(".arrow_toggle.open")[0]){

                $(".td_br").css("opacity","0.5");
                // $(".td_br").css("pointer-events","none");
                $(".td_br").css("pointer-events","none");
                if ($(document).height() > $(window).height()) { 
                    
                }else{
                    $('body').css('overflow-y','hidden');
                } 

                $(".menu-toggle").attr("disabled", true);
                setTimeout(
                function() 
                {
                    $(".td_br").css("pointer-events","initial");
                    $(".nav-item").css("white-space","normal");
                    $(".menu-toggle").attr("disabled", false);
                }, 500);


                $(".menu-toggle").hover(function() {
                    $(".arrow-toggle").css("opacity","0.5");
                    $(".arrow-toggle").css("cursor","pointer");
                });




                //$(".nav-item").css("white-space","normal");
            }else{


                $(".td_br").css("opacity","1");
                // $(".td_br").css("pointer-events","initial");

                $(".nav-item").css("white-space","nowrap");
                $(".menu-toggle").attr("disabled", true);
                setTimeout(
                function() 
                {
        
                    $(".menu-toggle").attr("disabled", false);
                }, 500);

                $(".menu-toggle").hover(function() {
                    $(".arrow-toggle").css("opacity","0.5");
                    $(".arrow-toggle").css("cursor","pointer");
                });
        

            }
            // $(".td_br").toggleClass("menuDisplayed");
        });

        $(".td_br").click(function(){
        
            // $(".arrow_toggle").toggleClass("open");


            if (document.querySelector('.arrow_toggle.open') !== null) {


        
                // $(".td_br").css("pointer-events","initial");

                

                $(".menu-toggle").attr("disabled", true);
                // $(".td_br").css("pointer-events","none");
                setTimeout(
                function() 
                {
        
                    $(".menu-toggle").attr("disabled", false);
                    // $(".td_br").css("pointer-events","initial");

                }, 500);

                $(".td_br").css("opacity","1");
                $(".nav-item").css("white-space","nowrap");
                
                $(".td_bl").removeClass("menuDisplayed");
                $(".arrow_toggle").removeClass("open");

                $(".menu-toggle").hover(function() {
                    $(".arrow-toggle").css("opacity","0.5");
                    $(".arrow-toggle").css("cursor","pointer");
                });


            }

        });


        document.addEventListener("DOMContentLoaded", function(){
            document.querySelectorAll('.sidebar .nav-link').forEach(function(element){
                
                element.addEventListener('click', function (e) {

                let nextEl = element.nextElementSibling;
                let parentEl  = element.parentElement;	

                    if(nextEl) {
                        e.preventDefault();	
                        let mycollapse = new bootstrap.Collapse(nextEl);
                        
                        if(nextEl.classList.contains('show')){
                        mycollapse.hide();
                        } else {
                            mycollapse.show();
                            // find other submenus with class=show
                            var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
                            // if it exists, then close all of them
                            if(opened_submenu){
                            new bootstrap.Collapse(opened_submenu);
                            }
                        }
                    }
                }); // addEventListener
            }) // forEach
        });

        </script>

    </body>
</html>

