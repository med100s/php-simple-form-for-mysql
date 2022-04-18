<?php
class dbConnector
{

    private $servername;
    private $dbusername;
    private $dbpassword;
    private $dbname;
    private $dbsubname;


    public function __construct(
        $servername,
        $dbusername,
        $dbpassword,
        $dbname,
        $dbsubname

    ) {
        $this->servername = $servername;
        $this->dbusername = $dbusername;
        $this->dbpassword = $dbpassword;
        $this->dbname = $dbname;
        $this->dbsubname = $dbsubname;  
    }
    public function Connect()
    {
        $conn = mysqli_connect($this->servername, $this->dbusername, $this->dbpassword, $this->dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        } else {
            $this->conn = $conn;
        }
    }
    public function CloseConection()
    {
        mysqli_close($this->conn);
    }
}
