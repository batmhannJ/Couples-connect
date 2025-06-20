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
$ret['html2']='';
$ret['time_fromto']='';
$ret["retEdit"] = array();
$ret["partner1_name"] = '';
$ret["partner2_name"] = '';


if($_POST['xevent_action'] == "select_change"){
    $select_db="SELECT 
    ext_couples_accountinfo.first_name as 'first_name',
    ext_couples_accountinfo.middle_name as 'middle_name',
    ext_couples_accountinfo.last_name as 'last_name',
    ext_couples_accountinfo.partnerno as 'partnerno',
    ext_couples_accountinfo.sex as 'sex',
    ext_couples_accountinfo.bday as 'bday',
    ext_couples_accountinfo.country as 'country',
    ext_couples_accountinfo.municipality as 'municipality',
    ext_couples_accountinfo.occupation as 'occupation',
    ext_couples_accountinfo.cellphone_number as 'cellphone_number'
     FROM mf_prog_users RIGHT JOIN ext_couples_accountinfo
    ON mf_prog_users.userid = ext_couples_accountinfo.userid WHERE mf_prog_users.username='".$_POST['xusername']."' ORDER BY ext_couples_accountinfo.partnerno LIMIT 2";
    $stmt	= $link->prepare($select_db);
    $stmt->execute(array($_SESSION['usr_recid']));
    while($row = $stmt->fetch()){
        if($row['partnerno'] == '1'){
            $ret["retEdit"] = [
                "name_1" => $row['first_name'].' '.$row['middle_name'].' '.$row['last_name'],
                "bday_1" => $row['bday'],
                "gender_1" => $row['sex'],
                "contact_1" => $row['cellphone_number'],
                "address_1" => $row['municipality'],
            ];
    
        }else if($row['partnerno'] == '2'){
            $ret["retEdit"]["name_2"] = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
            $ret["retEdit"]["bday_2"] = $row['bday'];
            $ret["retEdit"]["gender_2"] = $row['sex'];
            $ret["retEdit"]["contact_2"] = $row['cellphone_number'];
            $ret["retEdit"]["address_2"] = $row['municipality'];
        }
    }
    
    $ret["html"] = "<div>";
        $ret["html"] .="<img src='images/Group.png'>";
        $ret["html"] .="<span style='margin-left:10px'>Requires Pre-Marriage Counseling</span>";
    $ret["html"] .= "</div>";
}else if($_POST['xevent_action'] == 'view_meiform'){


    $xcounter = 1;

    $select_db_all="SELECT ext_mf_meiform.userid as 'userid', ext_mf_meiform.answers as 'answers', ext_mf_meiform.reasons as 'reasons', ext_mf_meiform.partnerid as 'partnerid'  FROM ext_mf_meiform LEFT JOIN mf_prog_users ON mf_prog_users.userid = ext_mf_meiform.userid 
    LEFT JOIN pro_meiform ON pro_meiform.usermeiformid = ext_mf_meiform.usermeiformid WHERE pro_meiform.status = 'PMO' AND mf_prog_users.username='".$_POST['xusername']."' ORDER BY ext_mf_meiform.partnerid";
    $stmt	= $link->prepare($select_db_all);
    $stmt->execute();
    while($rs_all = $stmt->fetch()){

        $select_db_users="SELECT  ext_couples_accountinfo.first_name as 'first_name', ext_couples_accountinfo.middle_name as 'middle_name',
        ext_couples_accountinfo.last_name as 'last_name' FROM mf_prog_users LEFT JOIN ext_couples_accountinfo ON mf_prog_users.userid = ext_couples_accountinfo.userid WHERE mf_prog_users.userid='".$rs_all['userid']."' 
         ORDER BY ext_couples_accountinfo.partnerno LIMIT 2";
        $stmt_users	= $link->prepare($select_db_users);
        $stmt_users->execute();
        
        $xcounter_users = 0;
        while($row_users = $stmt_users->fetch()){
            if($xcounter_users == 0){
                $ret["partner1_name"] = $row_users['first_name'].' '.$row_users['middle_name'].' '.$row_users['last_name'];
            }else{
                $ret["partner2_name"] = $row_users['first_name'].' '.$row_users['middle_name'].' '.$row_users['last_name'];
            }
            $xcounter_users++;
        };
        



        if($rs_all['partnerid'] == '1' || $rs_all['partnerid'] == 1){
            $ret[$xcounter]['p1']['answer'] = $rs_all['answers'];
            $ret[$xcounter]['p1']['reason'] = $rs_all['reasons'];
            $ret[$xcounter]['p1']['counter'] = $xcounter;
        }else{
            $ret[$xcounter]['p2']['answer'] = $rs_all['answers'];
            $ret[$xcounter]['p2']['reason'] = $rs_all['reasons'];
            $ret[$xcounter]['p2']['counter'] = $xcounter;
        }

        $xcounter++;
        
    }
    

}






  





header('Content-Type: application/json');
echo json_encode($ret);
?>
