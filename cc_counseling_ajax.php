<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('resources/db_init.php');
require_once('resources/lx2.pdodb.php');
require_once("resources/stdfunc100.php");
require_once('resources/connect4.php');

session_start();

header('Content-Type: application/json');

$ret = array();
$ret['msg'] = '';
$ret['html'] = '';
$ret['retEdit'] = array();
$ret['partner1_name'] = '';
$ret['partner2_name'] = '';

// DEFAULT VALUES
$ret['retEdit'] = array(
    "name_1" => "N/A",
    "bday_1" => "N/A",
    "gender_1" => "N/A",
    "contact_1" => "N/A",
    "address_1" => "N/A",
    "name_2" => "N/A",
    "bday_2" => "N/A",
    "gender_2" => "N/A",
    "contact_2" => "N/A",
    "address_2" => "N/A"
);

if(isset($_POST['xevent_action'])) {
    
    if($_POST['xevent_action'] == "select_change") {
        
        // GET userid FROM username
        $userid = isset($_POST['xusername']) ? $_POST['xusername'] : null;
        
        if(empty($userid)) {
            $ret['html'] = "Error: No user selected";
            echo json_encode($ret);
            exit;
        }
        
        try {
            // FETCH ALL PARTNER DATA FROM mf_prog_users
            $select_db = "SELECT 
                            userid,
                            username,
                            partner1_fname,
                            partner1_mname,
                            partner1_lname,
                            partner1_sex,
                            partner1_bday,
                            partner1_municipality,
                            partner1_cellphone,
                            partner2_fname,
                            partner2_mname,
                            partner2_lname,
                            partner2_sex,
                            partner2_bday,
                            partner2_municipality,
                            partner2_cellphone
                         FROM mf_prog_users 
                         WHERE userid = ?";
            
            $stmt = $link->prepare($select_db);
            $stmt->execute(array($userid));
            $row = $stmt->fetch();
            
            if(!$row) {
                $ret['html'] = "User not found";
                echo json_encode($ret);
                exit;
            }
            
            // BUILD PARTNER 1 INFO
            $partner1_name = trim($row['partner1_fname'] . ' ' . $row['partner1_mname'] . ' ' . $row['partner1_lname']);
            $ret['retEdit']['name_1'] = !empty($partner1_name) ? $partner1_name : 'N/A';
            $ret['retEdit']['bday_1'] = $row['partner1_bday'] ? date('F j, Y', strtotime($row['partner1_bday'])) : 'N/A';
            $ret['retEdit']['gender_1'] = !empty($row['partner1_sex']) ? $row['partner1_sex'] : 'N/A';
            $ret['retEdit']['contact_1'] = !empty($row['partner1_cellphone']) ? $row['partner1_cellphone'] : 'N/A';
            $ret['retEdit']['address_1'] = !empty($row['partner1_municipality']) ? $row['partner1_municipality'] : 'N/A';
            
            // BUILD PARTNER 2 INFO
            $partner2_name = trim($row['partner2_fname'] . ' ' . $row['partner2_mname'] . ' ' . $row['partner2_lname']);
            $ret['retEdit']['name_2'] = !empty($partner2_name) ? $partner2_name : 'N/A';
            $ret['retEdit']['bday_2'] = $row['partner2_bday'] ? date('F j, Y', strtotime($row['partner2_bday'])) : 'N/A';
            $ret['retEdit']['gender_2'] = !empty($row['partner2_sex']) ? $row['partner2_sex'] : 'N/A';
            $ret['retEdit']['contact_2'] = !empty($row['partner2_cellphone']) ? $row['partner2_cellphone'] : 'N/A';
            $ret['retEdit']['address_2'] = !empty($row['partner2_municipality']) ? $row['partner2_municipality'] : 'N/A';
            
            // BUILD STATUS HTML
            $ret['html'] = "<div style='display:flex;align-items:center;gap:10px'>";
            $ret['html'] .= "<img src='images/Group.png' style='height:20px'>";
            $ret['html'] .= "<span style='font-size:16px;font-family:inter'>Requires Pre-Marriage Orientation</span>";
            $ret['html'] .= "</div>";
            
        } catch(Exception $e) {
            $ret['html'] = "Error: " . $e->getMessage();
        }
    }
    else if($_POST['xevent_action'] == 'view_meiform') {
        
        $userid = isset($_POST['xusername']) ? $_POST['xusername'] : null;
        
        if(empty($userid)) {
            echo json_encode($ret);
            exit;
        }
        
        try {
            // GET PARTNER NAMES FROM mf_prog_users
            $select_names = "SELECT 
                                partner1_fname,
                                partner1_mname,
                                partner1_lname,
                                partner2_fname,
                                partner2_mname,
                                partner2_lname
                             FROM mf_prog_users 
                             WHERE userid = ?";
            
            $stmt_names = $link->prepare($select_names);
            $stmt_names->execute(array($userid));
            $row_names = $stmt_names->fetch();
            
            if($row_names) {
                $ret['partner1_name'] = trim($row_names['partner1_fname'] . ' ' . $row_names['partner1_mname'] . ' ' . $row_names['partner1_lname']);
                $ret['partner2_name'] = trim($row_names['partner2_fname'] . ' ' . $row_names['partner2_mname'] . ' ' . $row_names['partner2_lname']);
            }
            
            // FETCH MEI FORM DATA
            $select_meiform = "SELECT 
                                ext_mf_meiform.meiformid,
                                ext_mf_meiform.partnerid,
                                ext_mf_meiform.answers,
                                ext_mf_meiform.reasons
                            FROM ext_mf_meiform
                            INNER JOIN pro_meiform ON ext_mf_meiform.meiformid = pro_meiform.usermeiformid
                            WHERE pro_meiform.userid = ?
                            AND pro_meiform.status = 'PMO'
                            ORDER BY ext_mf_meiform.partnerid ASC";
            
            $stmt_meiform = $link->prepare($select_meiform);
            $stmt_meiform->execute(array($userid));
            
            $meiform_data = array();
            $counter = 1;
            
            while($row_mei = $stmt_meiform->fetch()) {
                if($row_mei['partnerid'] == 1) {
                    $meiform_data[] = array(
                        'p1' => array(
                            'answer' => $row_mei['answers'],
                            'reason' => $row_mei['reasons'],
                            'counter' => $counter
                        )
                    );
                } else if($row_mei['partnerid'] == 2) {
                    $meiform_data[] = array(
                        'p2' => array(
                            'answer' => $row_mei['answers'],
                            'reason' => $row_mei['reasons'],
                            'counter' => $counter
                        )
                    );
                }
                $counter++;
            }
            
            // MERGE MEIFORM DATA WITH PARTNER NAMES
            $ret = array_merge($meiform_data, array(
                'partner1_name' => $ret['partner1_name'],
                'partner2_name' => $ret['partner2_name']
            ));
            
        } catch(Exception $e) {
            $ret['error'] = 'Error: ' . $e->getMessage();
        }
    }
}

echo json_encode($ret);
?>