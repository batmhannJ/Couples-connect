<?php

    class db_init{

        // //FOR DB CONN ON APPSYSTEM DB containing syspar or the program file itself
        public static $syspar_db_name         = 'patientfile_appsystem';
        public static $syspar_db_tablename    = 'patientfile_companyfile';
        public static $syspar_host       = 'localhost';
        public static $syspar_username   = 'root';
        public static $syspar_password   = '';

        //FOR DB CONN ON DB CONTAINING ALL THE DBS containing the companyfile
        //OR normal DB connection
        
        public static $dbholder_db_name  = 'db_name3';
        public static $dbholder_host     = 'localhost';
        public static $dbholder_username = 'root';
        public static $dbholder_password = '';

        //needed for either Y for one DB 
        //N for multiple DBS
        public static $dbmode_singledb   = 'N';

    }

?>