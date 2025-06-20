<?php
try
{
    $link_appsys = new PDO('mysql:dbname=;host=localhost','lstuser_lennard', 'lstV@2021');	
     
    $select_db_conn="SELECT * FROM CHANGE THIS WHERE comp_code=?";
    $stmt_conn	= $link_appsys->prepare($select_db_conn);
    $stmt_conn->execute(array($_SESSION["comp_code"]));

    while($row_conn = $stmt_conn->fetch()){
        if(!empty($row_conn)){

                $auth_dbhost =   $row_conn['db_host'];
                $auth_dbusername = $row_conn['db_username'];
                $auth_dbuserpassword = $row_conn['db_pass'];
                $auth_dbname =$row_conn['db_dbname'];

                $auth_cnstr = "mysql:host=$auth_dbhost; dbname=$auth_dbname";
                $dboptions = array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY=>true);

                $link = new PDO($auth_cnstr, $auth_dbusername, $auth_dbuserpassword, $dboptions);

        }else{
            echo "Connection Failed";
            die();
        }
    }


}
catch(PDOException $e)
{
    echo "Connection Failed";
    die();
}

?>
