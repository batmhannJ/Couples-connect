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

$current_row = $_POST['current_rows'];
$new_row = $current_row + 1;

$ret['new_row']=$new_row;

if($_POST['event_action'] == 'add_new'){
    $ret['html']="<tr>";
        $ret['html'].="<td style='height:80px;width:25%'>";
            $ret['html'].="<div style='border-bottom:1px solid black;
                border-left:1px solid black;
                width:100%;height:100%'>";

                    $ret['html'].="<select 
                    name='text_submit[".$new_row."][concern]' 
                    id='text_submit[".$new_row."][concern]' 
                    style='width:100%;height:100%;border:none;border-radius:none;'>";

                    $select_db_concerns="SELECT * FROM mf_concerns";
                    $stmt_concerns	= $link->prepare($select_db_concerns);
                    $stmt_concerns->execute();
                    while($rs_concerns = $stmt_concerns->fetch()){
                         $ret['html'].="<option value='".$rs_concerns['concern_id']."'>".$rs_concerns['concerns']."</option>";
                    }

                    $ret['html'].="</select>";

            $ret['html'].="</div>";
        $ret['html'].="</td>";

        $ret['html'].="<td style='height:80px;width:25%'>";
            $ret['html'].="<div style='
                border-bottom:1px solid black;
                border-left:1px solid black;
                border-right:1px solid black;
                width:100%;height:100%'>";

                    $ret['html'].="<textarea 
                    name='text_submit[".$new_row."][description]' 
                    id='text_submit[".$new_row."][description]' 
                    style='width:100%;height:100%;border:none;border-radius:15px;'>";
                    $ret['html'].="</textarea>";

            $ret['html'].="</div>";

        $ret['html'].="</td>";

        $ret['html'].="<td style='height:80px;width:25%'>";
            $ret['html'].="<div style='
                border-bottom:1px solid black;
                border-right:1px solid black;
                width:100%;height:100%'>";

                    $ret['html'].="<textarea 
                    name='text_submit[".$new_row."][reccomendation]' 
                    id='text_submit[".$new_row."][reccomendation]' 
                    style='width:100%;height:100%;border:none;border-radius:15px;'>";
                    $ret['html'].="</textarea>";

            $ret['html'].="</div>";
        $ret['html'].="</td>";

        $ret['html'].="<td style='height:80px;width:25%'>";
            
            $ret['html'].="<div style='
                border-bottom:1px solid black;
                border-right:1px solid black;
                width:100%;height:100%'>";
                    $ret['html'].="<textarea 
                    name='text_submit[".$new_row."][future_actions]' 
                    id='text_submit[".$new_row."][future_actions]' 
                    style='width:100%;height:100%;border:none;border-radius:15px;'>";
                    $ret['html'].="</textarea>";
            $ret['html'].="</div>";
        $ret['html'].="</td>";

    $ret['html'].="</tr>";
}else if($_POST['event_action'] == 'submit_data'){
    $select_db="SELECT * FROM mf_prog_users WHERE username='".$_POST['ac_recid_hidden']."' LIMIT 1";
    $stmt	= $link->prepare($select_db);
    $stmt->execute();
    $row = $stmt->fetch();
    $userid = $row['userid'];
    
    $select_db2="SELECT * FROM pro_counselorbooking ORDER BY pro_crbookingid DESC LIMIT 1";
    $stmt2	= $link->prepare($select_db2);
    $stmt2->execute();
    $row2 = $stmt2->fetch();

    if(isset($row2['pro_crbookingid']) && !empty($row2['pro_crbookingid'])){
        $crid = LNexts($row2['pro_crbookingid']);
    }else{
        $crid = "CID-00001";
    }

    $select_mf_users = "";
    $cert_status = "";
    $cert_desc = "";
    if($_POST['select_status'] == "DAR"){
        $select_mf_users = "NCT";
    }else if($_POST['select_status'] == "APR"){
        $select_mf_users = "PCT";
        // $cert_status = "PRP";
        // $cert_desc = "Preparing";
    }

    $date_today = date('Y-m-d');
    $date_today_desc = date('F d, Y', strtotime($date_today));

    $mf_prog_users = array();
    $mf_prog_users["act_status"] = $select_mf_users;
    $mf_prog_users["cert_status"] = $cert_status;
    $mf_prog_users["cert_desc"] = $cert_desc;
    $mf_prog_users["date_requested"] = $date_today;
    $mf_prog_users["date_requested_desc"] = $date_today_desc;
    PDO_UpdateRecord($link,"mf_prog_users",$mf_prog_users,"userid = ?",array($userid),false);  

    $pro_counselorbooking = array();
    $pro_counselorbooking["pro_crbookingid"] = $crid;
    $pro_counselorbooking["userid"] = $userid;
    // $pro_counselorbooking["reccomendation_future"] = $_POST['future_reco'];
    $pro_counselorbooking["status"] = $_POST['select_status'];
    $pro_counselorbooking["date"] = $date_today;
    $pro_counselorbooking["date_desc"] = $date_today_desc;
    $pro_counselorbooking["prepared_by"] = $_SESSION['username'];
    PDO_InsertRecord($link,'pro_counselorbooking',$pro_counselorbooking,$debug=false);
 
    $ext_pro_counselorbooking = array();
    foreach($_POST['text_submit'] as $form2_e => $key) {

        $ext_pro_counselorbooking["pro_crbookingid"] = $crid;
        $ext_pro_counselorbooking["userid"] = $userid;
        $ext_pro_counselorbooking["concern_id"] = $key['concern'];
        $ext_pro_counselorbooking["description"] = $key['description'];
        $ext_pro_counselorbooking["reccomendation"] = $key['reccomendation'];
        $ext_pro_counselorbooking["future_actions"] = $key['future_actions'];

        PDO_InsertRecord($link,'ext_pro_counselorbooking',$ext_pro_counselorbooking,$debug=false);

    }
}



header('Content-Type: application/json');
echo json_encode($ret);
?>
