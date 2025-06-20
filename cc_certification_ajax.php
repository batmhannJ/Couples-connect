<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('resources/db_init.php');
require_once('resources/lx2.pdodb.php');
require_once("resources/stdfunc100.php");
require_once('resources/connect4.php');

session_start();

$ret=array();
$ret['msg']='';
$ret['user']='';
$ret['userlvl']='';
$ret['recid']='';
$ret['status']=true;
$ret['html']='';
$ret['time_fromto']='';
$ret["retEdit"] = array();

    // $select_db_ac="SELECT * FROM mf_prog_users WHERE usertype = 'USR' 
    // AND act_status = 'CRT' AND (cert_desc LIKE '%".$_POST['xval']."%' 
    // OR username LIKE '%".$_POST['xval']."%' OR date_requested_desc LIKE '%".$_POST['xval']."%') 
    // ORDER BY cert_status ASC, date_requested DESC";

    $select_db_ac="SELECT pro_cert_table.status as 'cert_status', 
    mf_prog_users.username  as 'username', 
    pro_cert_table.date_claimed as 'date_claimed',
    pro_cert_table.status_desc as 'cert_desc',
    pro_cert_table.recid as 'recid_cert',
    mf_prog_users.recid as 'recid_users'
    FROM pro_cert_table LEFT JOIN mf_prog_users ON pro_cert_table.userid = mf_prog_users.userid
    WHERE (pro_cert_table.status_desc LIKE '%".$_POST['xval']."%' OR 
    mf_prog_users.username LIKE '%".$_POST['xval']."%' OR
    pro_cert_table.date_claimed_desc LIKE '%".$_POST['xval']."%') 
    ORDER BY pro_cert_table.status ASC, mf_prog_users.date_requested DESC";

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
        
        $ret['html'] .= "<tr style='font-size:21px;font-family:inter;font-weight:700;color:black'>";
            $ret['html'] .= "<td class='pt-4'>";
                $ret['html'] .= "".$rs_ac['username']."";
            $ret['html'] .= "</td>";

   
            $ret['html'] .= "<td class='pt-4'>";
                $ret['html'] .= "".date('F d, Y', strtotime($rs_ac['date_claimed']))."";
            $ret['html'] .= "</td>";
            

            $ret['html'] .= "<td class='pt-4' style='color:".$cert_color."'>";
                $ret['html'] .= $rs_ac['cert_desc'];
            $ret['html'] .= "</td>";

            $ret['html'] .= "<td class='pt-4 d-flex justify-content-end'>";

                    $ret['html'] .= "<button onclick='review(\"{$rs_ac['recid_users']}\",\"{$rs_ac['recid_cert']}\")' type='button' style='border:none;background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;padding-top:5px;padding-bottom:5px;height:auto;font-size:21px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.21))'>";
                        $ret['html'] .= "Review";
                    $ret['html'] .= "</button>";

            $ret['html'] .= "</td>";
        $ret['html'] .= "</tr>";

    }
 

header('Content-Type: application/json');
echo json_encode($ret);
?>
