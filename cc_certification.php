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
                    <a href="http://localhost/couples-connect/select_option.php" style='color:black;text-decoration:none' class='has_hover'>HOME</a>
                </div>

                <div style="flex:.1;text-align:center;padding-right:10px">
                    <a style='color:black;text-decoration:none'>|</a>
                </div>

                <div style="flex:.3;text-align:center;padding-right:15px">
                    <a style='color:black;text-decoration:none'><?php echo $header_name;?> </a>
                </div>

                <div style="flex:0.6;text-align:right;padding-right:35px">
                    <a href="http://localhost/couples-connect/logout_cc.php"  class='has_hover' style='color:black;text-decoration:none'>LOGOUT</a>
                </div>

            </div> 
        </div>
    </div>

    <form name='myforms' id="myforms" method="post" target="_self" style='min-height:100vh; background: linear-gradient(135deg, rgb(215, 217, 225) 0%, rgb(162, 185, 231) 100%); padding: 20px; font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;'>
    <div style="max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: 320px 1fr; gap: 24px; height: calc(100vh - 40px);">
        
        <!-- Left Sidebar -->
        <div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 24px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); padding: 24px 20px; height: fit-content; max-height: calc(100vh - 80px); border: 1px solid rgba(255, 255, 255, 0.2); overflow-y: auto;">
            <div style="text-align: center; margin-bottom: 20px;">
                <h2 style="font-size: 24px; font-weight: 700; color: #1a1a1a; margin: 0 0 12px 0;">Options</h2>
                <div style="height: 3px; background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%); border-radius: 2px; width: 100%;"></div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px;">
                <?php
                    require 'cc_mf_menu.php';
                ?>
            </div>
        </div>

        <!-- Main Content -->
        <div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 24px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; border: 1px solid rgba(255, 255, 255, 0.2); height: calc(100vh - 80px); max-height: 650px;">

            <!-- Header -->
            <div style="padding: 20px 24px 16px 24px; text-align: center; border-bottom: 1px solid rgba(0, 0, 0, 0.05); flex-shrink: 0;">
                <h1 style="font-size: 26px; font-weight: 700; color: #1a1a1a; margin: 0 0 10px 0;">Certificates</h1>
                <div style="height: 3px; background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%); border-radius: 2px; width: 150px; margin: 0 auto;"></div>
            </div>

            <!-- Filter Section -->
            <div style="padding: 16px 24px; flex-shrink: 0;">
                <?php if(isset($_GET['dateFrom']) && isset($_GET['dateTo'])):?>
                    <div style="text-align: center;">
                        <a href="cc_certification.php" style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 14px; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); transition: all 0.2s ease;">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                            </svg>
                            Clear Filter
                        </a>
                    </div>
                <?php else: ?>
                    <div style="background: rgba(255, 255, 255, 0.7); border-radius: 12px; padding: 16px; border: 1px solid rgba(0, 0, 0, 0.05);">
                        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                            <div style="display: flex; align-items: center; gap: 8px; flex: 1; min-width: 180px;">
                                <label style="font-weight: 600; color: #374151; font-size: 13px; white-space: nowrap;">Date From:</label>
                                <input type="date" class="form-control" id="dateFrom" style="border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 8px 12px; font-size: 13px; background: white; flex: 1; transition: all 0.2s ease;">
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px; flex: 1; min-width: 180px;">
                                <label style="font-weight: 600; color: #374151; font-size: 13px; white-space: nowrap;">Date To:</label>
                                <input type="date" class="form-control" id="dateTo" style="border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 8px 12px; font-size: 13px; background: white; flex: 1; transition: all 0.2s ease;">
                            </div>
                            <button type="button" class="btn btn-primary btn-filter" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); border: none; color: white; padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 13px; box-shadow: 0 3px 8px rgba(79, 70, 229, 0.3); cursor: pointer; transition: all 0.2s ease; white-space: nowrap;">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 4px;">
                                    <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                                Filter
                            </button>
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

            <!-- Table Container -->
            <div style="flex: 1; padding: 0 24px 24px 24px; overflow: hidden; min-height: 0;">
                <div style="background: rgba(255, 255, 255, 0.7); border-radius: 12px; height: 100%; overflow: auto; border: 1px solid rgba(0, 0, 0, 0.05);">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; background: rgba(249, 250, 251, 0.95); backdrop-filter: blur(10px);">
                            <tr>
                                <th style="padding: 16px 20px; text-align: left; font-weight: 700; font-size: 14px; color: #374151; border-bottom: 2px solid rgba(0, 0, 0, 0.05);">Email</th>
                                <th style="padding: 16px 20px; text-align: left; font-weight: 700; font-size: 14px; color: #374151; border-bottom: 2px solid rgba(0, 0, 0, 0.05);">Date Printed</th>
                                <th style="padding: 16px 20px; text-align: left; font-weight: 700; font-size: 14px; color: #374151; border-bottom: 2px solid rgba(0, 0, 0, 0.05);">Control Number</th>
                                <th style="padding: 16px 20px; text-align: center; font-weight: 700; font-size: 14px; color: #374151; border-bottom: 2px solid rgba(0, 0, 0, 0.05);">Action</th>
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

                            $stmt = $link->prepare($select_db_ac);
                            $stmt->execute();
                            $row_count = 0;
                            while($rs_ac = $stmt->fetch()){
                                $cert_color = '';
                                if($rs_ac['cert_status'] == 'PRP'){
                                    $cert_color = '#f59e0b';
                                }else if($rs_ac['cert_status'] == 'PUP'){
                                    $cert_color = '#10b981';
                                }else if($rs_ac['cert_status'] == 'RCV'){
                                    $cert_color = '#3b82f6';
                                }

                                if ($rs_ac['cert_status'] === 'APRV' ) {
                                    $status = "APPROVED";
                                    $status_color = '#10b981';
                                } else if ($rs_ac['cert_status'] === 'DEC' ) {
                                    $status = "DECLINED";
                                    $status_color = '#ef4444';
                                } else {
                                    $status = "PENDING";
                                    $status_color = '#f59e0b';
                                }

                                $bg_color = $row_count % 2 == 0 ? 'rgba(255, 255, 255, 0.5)' : 'rgba(249, 250, 251, 0.5)';
                                
                                echo "<tr style='background: {$bg_color}; transition: all 0.2s ease;' onmouseover='this.style.background=\"rgba(79, 70, 229, 0.05)\"' onmouseout='this.style.background=\"{$bg_color}\"'>";
                                    echo "<td style='padding: 12px 20px; font-size: 13px; font-weight: 500; color: #1f2937; border-bottom: 1px solid rgba(0, 0, 0, 0.02);'>";
                                        echo htmlspecialchars($rs_ac['username']);
                                    echo "</td>";

                                    echo "<td style='padding: 12px 20px; font-size: 13px; font-weight: 500; color: #6b7280; border-bottom: 1px solid rgba(0, 0, 0, 0.02);'>";
                                        echo date('M d, Y', strtotime($rs_ac['date_claimed']));
                                    echo "</td>";

                                    echo "<td style='padding: 12px 20px; font-size: 13px; font-weight: 600; color: {$cert_color}; border-bottom: 1px solid rgba(0, 0, 0, 0.02);'>";
                                        echo htmlspecialchars($rs_ac['cntrl_number']);
                                    echo "</td>";

                                    echo "<td style='padding: 12px 20px; text-align: center; border-bottom: 1px solid rgba(0, 0, 0, 0.02);'>";
                                        echo "<button onclick='review(\"{$rs_ac['recid_users']}\",\"{$rs_ac['recid_cert']}\",\"{$rs_ac['reason']}\")' type='button' style='background: linear-gradient(135deg, {$status_color} 0%, {$status_color}dd 100%); color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 11px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);' onmouseover='this.style.transform=\"translateY(-1px)\"; this.style.boxShadow=\"0 3px 10px rgba(0, 0, 0, 0.2)\"' onmouseout='this.style.transform=\"translateY(0)\"; this.style.boxShadow=\"0 2px 6px rgba(0, 0, 0, 0.1)\"'>";
                                            echo $status;
                                        echo "</button>";
                                    echo "</td>";
                                echo "</tr>";
                                $row_count++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Design -->
    <style>
        @media (max-width: 1200px) {
            form > div {
                grid-template-columns: 1fr !important;
                gap: 16px !important;
            }
            
            form > div > div:first-child {
                order: 2;
            }
            
            form > div > div:last-child {
                order: 1;
            }
        }
        
        @media (max-width: 768px) {
            form {
                padding: 12px !important;
            }
            
            form > div > div:nth-child(2) .filter-container {
                flex-direction: column !important;
                gap: 12px !important;
            }
            
            form > div > div:nth-child(2) .filter-container > div {
                flex-direction: column !important;
                min-width: 100% !important;
            }
            
            table th, table td {
                padding: 12px 8px !important;
                font-size: 12px !important;
            }
            
            h1 {
                font-size: 24px !important;
            }
            
            h2 {
                font-size: 20px !important;
            }
        }
        
        input[type="date"]:focus {
            border-color: #4f46e5 !important;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important;
            outline: none !important;
        }
        
        .btn-filter:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4) !important;
        }
        
        tbody tr:hover button {
            transform: scale(1.05) !important;
        }
    </style>

    <!-- Modals -->
    <div class="modal fade xerror_modal" data-bs-backdrop="static" id="xerror_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);">
                <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 24px;">
                    <h5 class="modal-title" style="font-weight: 700; color: #1f2937;">Couples Connect Says:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 24px;">
                    <p class="error_msg" style="color: #6b7280; margin: 0;">Modal body text goes here.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal_cert_reason" id="modal_cert_reason" style="display: none;" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15); background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(20px);">
                <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 24px 32px;">
                    <div class="modal-title">
                        <div style="color: #1f2937; font-family: Inter, sans-serif; font-size: 28px; font-weight: 700;">Certification</div>
                        <div style="color: #6b7280; font-family: Inter, sans-serif; font-size: 16px; margin-top: -2px;">Request</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 24px 32px 32px 32px;">
                    <label style="font-size: 16px; color: #374151; font-weight: 600; font-family: Inter, sans-serif; display: block; margin-bottom: 12px;">Reason for request:</label>
                    <p id="reason" style="font-size: 14px; color: #6b7280; background: rgba(249, 250, 251, 0.5); padding: 16px; border-radius: 12px; border: 1px solid rgba(0, 0, 0, 0.05); margin-bottom: 24px; line-height: 1.5;"></p>
                    <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
                        <button type="button" class="btn" id="appBtn" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; width: 140px; height: 44px; font-size: 14px; font-family: Inter, sans-serif; font-weight: 600; border-radius: 12px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(16, 185, 129, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(16, 185, 129, 0.3)'">APPROVE</button>
                        <button type="button" id="decBtn" class="btn" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; width: 140px; height: 44px; font-size: 14px; font-family: Inter, sans-serif; font-weight: 600; border-radius: 12px; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(239, 68, 68, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(239, 68, 68, 0.3)'">DECLINE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal_dec_cert_reason" id="modal_dec_cert_reason" style="display: none;" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15); background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(20px);">
                <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.05); padding: 24px 32px;">
                    <div class="modal-title">
                        <div style="color: #1f2937; font-family: Inter, sans-serif; font-size: 28px; font-weight: 700;">Certification</div>
                        <div style="color: #6b7280; font-family: Inter, sans-serif; font-size: 16px; margin-top: -2px;">Request</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 24px 32px 32px 32px;">
                    <label style="font-size: 16px; color: #374151; font-weight: 600; font-family: Inter, sans-serif; display: block; margin-bottom: 12px;">Reason for declination:</label>
                    <textarea id="dec_reason" class="form-control" cols="30" rows="6" placeholder="Enter reason for declining..." style="font-size: 14px; border: 2px solid rgba(0, 0, 0, 0.1); border-radius: 12px; padding: 16px; background: rgba(249, 250, 251, 0.5); resize: vertical; transition: all 0.2s ease; margin-bottom: 24px;" onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 3px rgba(79, 70, 229, 0.1)'" onblur="this.style.borderColor='rgba(0, 0, 0, 0.1)'; this.style.boxShadow='none'"></textarea>
                    <div style="display: flex; justify-content: center;">
                        <button type="button" id="decReasonBtn" class="btn" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: white; border: none; width: 160px; height: 44px; font-size: 14px; font-family: Inter, sans-serif; font-weight: 600; border-radius: 12px; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3); cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(79, 70, 229, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(79, 70, 229, 0.3)'">SUBMIT</button>
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

