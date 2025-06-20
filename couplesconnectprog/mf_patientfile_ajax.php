<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();
require "resources/db_init.php";
require "resources/connect4.php";
require_once("resources/lx2.pdodb.php");

    $xret = array();
    $xret["status"] = 1;
    $xret["type"] = "";

    if($_POST["event_action"] == "delete"){


        $select_db_select="SELECT * FROM patientfile WHERE recid=?";
        $stmt_select	= $link->prepare($select_db_select);
        $stmt_select->execute(array($_POST["recid"]));
        $rs_select = $stmt_select->fetch();

        $select_db_delete_attach="SELECT * FROM patientfile_attachments WHERE cuscde=?";
        $stmt_delete_attach	= $link->prepare($select_db_delete_attach);
        $stmt_delete_attach->execute(array($rs_select["cuscde"]));
        while($rs_delete_attach = $stmt_delete_attach->fetch()){
            unlink("file_upload/".$rs_delete_attach["filename"]);
        }

        $select_delete_main="DELETE FROM patientfile WHERE recid=?";
        $stmt_delete_main	= $link->prepare($select_delete_main);
        $stmt_delete_main->execute(array($_POST["recid"]));


    }



echo json_encode($xret);
?>
