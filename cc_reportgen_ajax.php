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
$ret['first_time'] = '';
$ret["retEdit"] = array();



    $xfilter = "";
    if(isset($_POST['period_from']) && !empty($_POST['period_from'])){
        $xdate = date("Y-m-d", strtotime($_POST['period_from']));
        $xfilter = " AND ext_mf_meiform.date>='".$xdate."' ";
    }

    if(isset($_POST['period_to']) && !empty($_POST['period_to'])){
        $xdate = date("Y-m-d", strtotime($_POST['period_to']));
        $xfilter .= " AND ext_mf_meiform.date<='".$xdate."' ";
    }
    
    $select_db_pmo = "SELECT * FROM ext_mf_meiform LEFT JOIN pro_meiform ON 
                    pro_meiform.usermeiformid = ext_mf_meiform.usermeiformid 
                    WHERE true ".$xfilter." AND pro_meiform.status='PMO'
                    GROUP BY ext_mf_meiform.usermeiformid";
    $stmt_pmo	= $link->prepare($select_db_pmo);
    $stmt_pmo->execute();
    $xtotal_orientations = 0;
    while($row_pmo = $stmt_pmo->fetch()){
        $xtotal_orientations++;
    }



    $select_db_totalpmo2 = "SELECT * FROM pro_meiform WHERE status='PMO'";
    $stmt_totalpmo2	= $link->prepare($select_db_totalpmo2);
    $stmt_totalpmo2->execute();
    $total_attendees = 0;
    while($rs_totalpmo2 = $stmt_totalpmo2->fetch()){

        $select_db_totalpmo3 = "SELECT ext_appointment_info.slots_avail as 'slots_avail' FROM ext_mf_meiform  
        LEFT JOIN mf_venue ON ext_mf_meiform.venue = mf_venue.venue 
        LEFT JOIN ext_appointment_info ON ext_appointment_info.venue_id = mf_venue.venue_id
        WHERE true ".$xfilter." AND ext_mf_meiform.usermeiformid='".$rs_totalpmo2['usermeiformid']."' LIMIT 1";
        $stmt_totalpmo3	= $link->prepare($select_db_totalpmo3);
        $stmt_totalpmo3->execute();
        while($rs_totalpmo3 = $stmt_totalpmo3->fetch()){
            $total_attendees+=$rs_totalpmo3['slots_avail'];
        }
            
    }

    $ret['totalOrientationAttendees'] = $total_attendees;
    $ret['totalOrientations'] = $xtotal_orientations;

                   
header('Content-Type: application/json');
echo json_encode($ret);
?>
