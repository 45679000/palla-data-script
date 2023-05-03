<?php 
include('./config/config.php');
include('./config/db.php');
class Student extends Database
{
    public $connect;
    // public $dbb = new Data();
    public $con_2;
    public function __construct(){
        $d = new Data();
        $this->connect = $this->getConnection();
        $this->con_2 = $d->getConnection();
    }
    public function fetchLoan($id){
        try {            
            $sql = "SELECT date_new, rct_no FROM receipts WHERE MONTH(date_new) IN (1) ORDER BY id DESC LIMIT 100";
            $stmt = $this->connect->prepare($sql); 
            $stmt->execute();
            $rows = $stmt->fetchAll();
            foreach($rows as $row){
                $this->updateDates($row['rct_no'], $row['date_new']);
                die();
            }
            // return $rows;
        }catch(Exception $ex){
            return $ex;
        }
    }
    public function updateDates($rct_no, $date_new){
        try{
            $sql = "UPDATE m_loan_transaction as t LEFT JOIN m_payment_detail as p ON p.id = t.payment_detail_id  SET t.transaction_date = DATE('$date_new') WHERE p.receipt_number = '$rct_no'";
            echo $sql;
            $stmt = $this->connect->prepare($sql); 
            echo $stmt->execute();
        }catch(Exception $ex){
            print_r($ex);
        }
    }
}


?>