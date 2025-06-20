<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

// if(!isset($_SESSION['userdesc']) || !isset($_SESSION['password'])){
//     header('location: login_cc.php');
// }
require_once("resources/db_init.php") ;
require_once("resources/connect4.php");
require_once("resources/lx2.pdodb.php");
require_once("resources/stdfunc100.php");

?>
<!doctype html>
<html lang="en" style="height:100%;">

    <head>
        <!-- NEEDED TO MMAKE THE SIZE AND FORMAT OF WEBPAGE RIGHT -->
        <meta charset="utf-8">
        <!-- uses device width -->
        <!-- <meta name="viewport" content="width=device-width" /> -->
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="images/logo_short.png">

        <!-- PLAIN JQUERY AND JQUERY-UI JS -->
        <script src="js/jquery-3.5.1.min.js"></script>
        <script src="js/jquery-ui/jquery-ui.min.js"></script>

        <!--(independent libraries like JQUERY) / jquery css-->
        <link rel="stylesheet" type="text/css" href="js/jquery-ui/jquery-ui.min.css">
        <link href="js/jquery-ui/jquery-ui.structure.css" rel="stylesheet" >
        <link href="js/jquery-ui/jquery-ui.theme.css" rel="stylesheet" >

        <!-- BOOTSTRAP CSS-->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

        <!-- HOVER CSS -->
        <link rel="stylesheet" href="css/Hover-master/css/hover.css">

        <!--  FONT AWESOME ICONS -->
        <link rel='stylesheet' href='css/all.min.css'>

        <!-- BOOTSTRAP ICONS -->
        <link rel='stylesheet' href='bootstrap/icons/font/bootstrap-icons.css'>

        <!-- CUSTOM CSS-->
        <link rel="stylesheet" href="css/main.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <!-- <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" />
        <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script> -->
        <script src="js/moment.js"></script>
        <script src="fullcalendar-6.1.11/dist/index.global.js"></script>
        <script src="fullcalendar-6.1.11/dist/index.global.min.js"></script>

        <style>
            .footer {
                background-color: #23408E;
                position: absolute;
                bottom: 0;
                width: 100%;
            }

            body{
                overflow-x:hidden
            }

            form {
                flex: 1;
            }

            .cc_wrapper{
                height: 100vh;
                display: flex;
                flex-direction: column;
            }
            .has_hover:hover{
                cursor:pointer;
                opacity:0.5;
            }          
        </style>
    </head>
    
     <div class='cc_wrapper'>   
