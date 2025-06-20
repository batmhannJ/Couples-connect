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

    $select_db_ac = "SELECT mf_prog_users.username  as 'username', pro_counselorbooking.date_desc as 'date_desc',
    pro_counselorbooking.prepared_by as 'prepared_by', pro_counselorbooking.recid as 'recid_book',  pro_counselorbooking.userid as 'userid',
    mf_prog_users.recid as 'recid_users' FROM pro_counselorbooking LEFT JOIN mf_prog_users ON 
    pro_counselorbooking.userid = mf_prog_users.userid WHERE 
    pro_counselorbooking.prepared_by='".$_SESSION['username']."'AND (pro_counselorbooking.date_desc LIKE '%".$_POST['xval']."%' OR 
    mf_prog_users.username LIKE '%".$_POST['xval']."%' OR
    pro_counselorbooking.prepared_by LIKE '%".$_POST['xval']."%')  ORDER BY pro_counselorbooking.date ASC";
    $stmt	= $link->prepare($select_db_ac);
    $stmt->execute();
    while($rs_ac = $stmt->fetch()){

        $ret['html'] .= "<tr style='font-size:21px;font-family:inter;font-weight:700;color:black'>";
            $ret['html'] .= "<td class='pt-4'>";
                $ret['html'] .= "".$rs_ac['username']."";
            $ret['html'] .= "</td>";

   
            $ret['html'] .= "<td class='pt-4'>";
                $ret['html'] .= "".date('F d, Y', strtotime($rs_ac['date_desc']))."";
            $ret['html'] .= "</td>";
            

            $ret['html'] .= "<td class='pt-4'>";
                $ret['html'] .= $rs_ac['prepared_by'];
            $ret['html'] .= "</td>";

            $ret['html'] .= "<td class='pt-4 d-flex justify-content-end'>";
                    $ret['html'] .= "<button onclick='review(\"{$rs_ac['recid_users']}\",\"{$rs_ac['recid_book']}\",\"{$rs_ac['username']}\",\"{$rs_ac['userid']}\")' type='button' style='border:none;background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:180px;padding-top:5px;padding-bottom:5px;height:auto;font-size:21px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))'>";
                        $ret['html'] .= "Review";
                    $ret['html'] .= "</button>";
            $ret['html'] .= "</td>";
        $ret['html'] .= "</tr>";

    }
 

header('Content-Type: application/json');
echo json_encode($ret);
?>
