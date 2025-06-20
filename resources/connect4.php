<?php



try

{



    if(isset(db_init::$dbmode_singledb) && db_init::$dbmode_singledb == "N"){

        $link_appsys = new PDO("mysql:dbname=".db_init::$syspar_db_name.";host=".db_init::$syspar_host."","".db_init::$syspar_username."","".db_init::$syspar_password."");
        $select_db_conn="SELECT * FROM ".db_init::$syspar_db_tablename." WHERE comp_code=?";

        $stmt_conn	= $link_appsys->prepare($select_db_conn);
        $stmt_conn->execute(array($_SESSION["comp_code"]));
        $row_conn = $stmt_conn->fetch();

        if(!empty($row_conn)){

                $auth_dbhost =   $row_conn['db_host'];
                $auth_dbusername = $row_conn['db_username'];
                $auth_dbuserpassword = $row_conn['db_pass'];
                $auth_dbname =$row_conn['db_dbname'];

                $auth_cnstr = "mysql:host=$auth_dbhost; dbname=$auth_dbname";
                $dboptions = array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY=>true);

                $link = new PDO($auth_cnstr, $auth_dbusername, $auth_dbuserpassword, $dboptions);
                //$link = new PDO("mysql:dbname=".$auth_dbname.";host=".$auth_dbhost."","".$auth_dbusername."","".$auth_dbuserpassword."");		
        }else{
            echo "Connection Failed";
            die();
        }
        
    }else{
        //$link = new PDO('mysql:dbname=CHANGE THIS;host=localhost','lstuser_lennard', 'lstV@2021');	
        $link = new PDO("mysql:dbname=".db_init::$dbholder_db_name.";host=".db_init::$dbholder_host."","".db_init::$dbholder_username."","".db_init::$dbholder_password."");		
    }
}
catch(PDOException $e)
{          

    echo "Connection Failed";
    die();
}

?>
