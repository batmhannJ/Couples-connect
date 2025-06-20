<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('resources/db_init.php');
require_once('resources/lx2.pdodb.php');
require_once('resources/connect4.php');

$userId = isset($_POST['userId']) ? (int)$_POST['userId'] : 0;

(int) $status = 1;

try 
{ 
	    $st = $link->prepare("UPDATE mf_prog_users SET print_status = :print_status WHERE recid=:recid");
	    $st->bindParam(':print_status', $status, PDO::PARAM_INT);
	    $st->bindParam(':recid', $userId, PDO::PARAM_INT);

        $st->execute();

        echo $st->rowCount();

} 
	catch(Exception $e) 
{
    echo $e->getMessage();
}

?>