<?php 
class Data{
  
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "palla_db";
    private $username = "root";
    private $password = "";
    public $conn;
    public $name = "ttdd";
    public $validToken = false;
    // get the database connection
    public function getConnection(){
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=".$this->host.";port=8090;dbname=".$this->db_name,$this->username, $this->password,$options);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}


?>