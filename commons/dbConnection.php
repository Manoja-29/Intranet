<?php

class dbConnection{
    public $conn;
    public $archiveConn;
    private $hostname="localhost";
    private $dbusename="root";
    private $dbpassword="";
    private $db="intranet";
    private $archiveDb = "archive_intranet";
    
    function __construct() {
        $this->conn= new mysqli(
        $this->hostname,
        $this->dbusename,
        $this->dbpassword,        
        $this->db        
        );

       if(!$this->conn->connect_error)
       {
        $GLOBALS["con"]=$this->conn;
       }
       else{
            echo "Not Success";
        //$GLOBALS["con"]=$this->conn;
            $GLOBALS["con"] = null;
       }

       $this->archiveConn = new mysqli(
        $this->hostname,
        $this->dbusename,
        $this->dbpassword,        
        $this->archiveDb        
    );

    if (!$this->archiveConn->connect_error) {
        $GLOBALS["archiveCon"] = $this->archiveConn;
    } else {
        echo "Archive Connection Not Success";
        $GLOBALS["archiveCon"] = null; // Set to null if connection fails
    } 
}
    
        public function executeArchiveQuery($query) {
            return $this->archiveConn->query($query);
        }
    }
    
    


