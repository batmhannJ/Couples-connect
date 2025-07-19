<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('resources/db_init.php');
require_once('resources/lx2.pdodb.php');
require_once('resources/connect4.php');

$userId = isset($_POST['userId']) ? (int)$_POST['userId'] : 0;

try 
{ 
    // Option 1: Using positional parameters (recommended for your current setup)
    $st = $link->prepare("UPDATE mf_prog_users SET print_status = ? WHERE recid = ?");
    $st->execute([1, $userId]);
    
    echo json_encode([
        'success' => true,
        'rowCount' => $st->rowCount(),
        'userId' => $userId
    ]);

} 
catch(Exception $e) 
{
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

?>