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
            $sql = "SELECT * FROM loans WHERE id = $id";
            $stmt = $this->connect->prepare($sql); 
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows;
        }catch(Exception $ex){
            return $ex;
        }
    }
    public function getLoanById($id){
        try{
            $sql = "SELECT *,CAST(REPLACE(loan_amount, ',', '') AS FLOAT) as amount,SUBSTRING(acct_no,1,CHAR_LENGTH(acct_no) - 1) as sub,STR_TO_DATE(loan_date, '%d-%b-%y') as day,REPLACE(loan_date,'-', ' ') as date_loan, STR_TO_DATE(loan_date, '%d-%b-%y') as day,REPLACE(exp_date,'-', ' ') as loan_expiry FROM loans WHERE id = $id";
            $stmt = $this->connect->prepare($sql); 
            $stmt->execute();
            $rows = $stmt->fetchAll();
            $data = array();
            foreach($rows as $s){
                // print_r($s);
                try{
                    $dateObject = DateTime::createFromFormat('d M y', $s['date_loan']);
                    
                    $formattedDate = $dateObject->format('d M Y');
                    // print_r($formattedDate);
                    // print_r($row_clients); 
                    $loan_data = array(
                            "dateFormat"=> "dd MMMM yyyy",
                            "locale"=> "en",
                            "productId"=> 5,
                            "principal"=> $s['amount'],
                            "loanTermFrequency"=> 30,
                            "loanTermFrequencyType"=> 0,
                            "loanType"=> "individual",
                            "numberOfRepayments"=> 30,
                            "repaymentEvery"=> 1,
                            "repaymentFrequencyType"=> 0,
                            "interestRatePerPeriod"=> 25,
                            "amortizationType"=> 1,
                            "interestType"=> 0,
                            "interestCalculationPeriodType"=> 1,
                            "transactionProcessingStrategyId"=> 1,
                            "rates"=> array(),
                            "expectedDisbursementDate"=> $formattedDate,
                            "submittedOnDate"=> $formattedDate,
                            "client_id"=> $s['client_id'],
                            "daysInYearType"=>1,
                            "disbursementData"=>array()
                        );

                    // "maxOutstandingLoanBalance"=>"35000",
                        $json_data = json_encode($loan_data);
                        $dta = array(
                            "loan"=>$loan_data,
                            "transction"=> $s['transction'],
                            "loan_s"=> $s['id']
                        );
                        array_push($data,$dta);
                }catch (Exception $ex){
                    // print_r($ex);
                }
            }
            // print_r($data);
            return $data;
        }catch(Exception $ex){
            return $ex;
        }
    }
    public function fetchLoans($max_date=0, $min_date=0,$region=0, $page=0,$dashboard=false) {
        try {
            $sql = "SELECT * FROM loans WHERE 1 ";
            if(!$dashboard){
                $sql.=" AND client_id !=0 AND loan_Id IS NOT NULL ";
            }
            // WHERE client_id != 0 AND loan_Id IS NULL
            // $sql = "SELECT * FROM loan_s WHERE client_id != 0 AND loan_Id IS NULL OR loan_Id != 0 ";
            if($max_date !=0 && $min_date !=0 ){
                $sql.="AND STR_TO_DATE(loan_date, '%d-%b-%y') >= '$min_date' AND STR_TO_DATE(loan_date, '%d-%b-%y') <= '$max_date' ";
            }
            if(strlen($region)>1 ){
                $sql.=" AND region = '$region'";
            }
            $sql.="ORDER BY approved ASC ";
            if(!$dashboard){
                if($page != 0){
                $p = $page*100;
                $sql.=" LIMIT 100 OFFSET $p";
                }else{
                    $sql .= "LIMIT 100";
                }
            }
            if($dashboard){
                $sql.=" LIMIT 300";
            }
            echo $sql;
            // WHERE MONTH(loan_date) = 12
            // client_id !=0 AND loan_id = 0
            $db = $this->getConnection();
            // var_dump($this); die();

            // $stmt = $this->con_2->prepare($sql);
            $stmt = $this->connect->prepare($sql); 
            $stmt->execute();
            $rows = $stmt->fetchAll();
            
            return $rows;
        }catch(Exception $ex){
            return $ex;
        }
    }
    public function fetchReceipts($max_date=0, $min_date=0) {
        try {            
            $sql = "SELECT * FROM receipts_zip";
            if($max_date !=0 && $min_date !=0){
                $sql.=" WHERE STR_TO_DATE(date,'%d/%m/%Y') >= '$min_date' AND STR_TO_DATE(date,'%d/%m/%Y') <= '$max_date'";
            }
            $sql.=" LIMIT 100";
            // echo $sql; die();
            // WHERE MONTH(loan_date) = 12
            // client_id !=0 AND loan_id = 0
            $db = $this->getConnection();
            // var_dump($this); die();

            // $stmt = $this->con_2->prepare($sql);
            $stmt = $this->connect->prepare($sql); 
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return $rows;
        }catch(Exception $ex){
            return $ex;
        }
    }

    public function insertNewLoan($data){
        try{
            $sql = "INSERT IGNORE INTO `loans` (`client_id`, `acct_no`, `transction`, `client`, `tel`, `loan_amount`, `interest`, `rate`, `total_amount`, `loan_date`, `exp_date`, `region`, `sub_region`) VALUES (".$data['client_id'].", ".$data['acct_no'].", '".$data['transction']."', '".$data['client']."', '".$data['tel']."',".$data['loan_amount'].",".$data['interest'].", ".$data['rate'].",".$data['total_amount'].",'".$data['loan_date']."','".$data['exp_date']."', '".$data['region']."', '".$data['sub_region']."')";
            $stmt = $this->connect->prepare($sql);
            return $stmt->execute();
        }catch(Exception $ex){
            return $ex;
        }
    }
    public function insertNewReceipt($data){
        
        try{
            $sql = "INSERT IGNORE INTO `receipts` (`acct_no`, `rct_no`, `client`, `tel`, `Description`, `date`, `amount`, `branch`, `sub_region`) VALUES (".$data['acct_no'].",".$data['rct_no'].", '".$data['client']."', '".$data['tel']."', '".$data['description']."', '".$data['date']."', ".$data['amount'].", '".$data['branch']."', '".$data['sub_region']."')";
            // echo $sql;
            $stmt = $this->connect->prepare($sql);
            echo $stmt->execute();
        }catch(Exception $ex){
            return $ex;
        }
    }
    public function fetchReceiptsForLoan($id){
        try{
            $sql = "SELECT *, receipts.id as r_id FROM receipts LEFT JOIN loans ON receipts.tel = loans.tel WHERE loans.id = $id AND DATEDIFF(STR_TO_DATE(receipts.date,'%d/%m/%Y'),STR_TO_DATE(loans.loan_date,'%d-%b-%y')) >=0 AND DATEDIFF(STR_TO_DATE(receipts.date,'%d/%m/%Y'),STR_TO_DATE(loans.loan_date,'%d-%b-%y')) <= 30 GROUP BY receipts.id ";
            // $sql = "SELECT *, receipts_zip.id as r_id FROM receipts_zip LEFT JOIN loan_s ON receipts_zip.tel = loan_s.tel WHERE loan_s.id = $id AND DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) >=0 AND DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) <= 30 GROUP BY receipts_zip.id ";
            // echo $sql;
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(Exception $ex){
            return $ex;
        }
    }
    public function fetchApproveByID($id){
        $sql = "SELECT *,loan_Id as loan_id, CAST(REPLACE(loan_amount, ',', '') AS FLOAT) as amount,SUBSTRING(acct_no,1,CHAR_LENGTH(acct_no) - 1) as sub,STR_TO_DATE(loan_date, '%d-%b-%y') as day,REPLACE(loan_date,'-', ' ') as date_loan, STR_TO_DATE(loan_date, '%d-%b-%y') as day,REPLACE(exp_date,'-', ' ') as loan_expiry FROM loans WHERE id = $id";
        //  AND disbursed = 0 AND disbursed_error = '' 
        // AND approved != 0 AND disbursed =0 AND disbursed_error = ''
        $stmt = $this->connect->prepare($sql); 
        $stmt->execute();
        $rows = $stmt->fetchAll();
        // print_r($rows);
        $data=array(); 
        foreach($rows as $row){
            $dateObject = DateTime::createFromFormat('d M y', $row['date_loan']);        
            $formattedDate = $dateObject->format('d M Y'); 
            $loan_data = array(
                "locale"=> "en",
                "dateFormat"=> "dd MMMM yyyy",
                "approvedOnDate"=> $formattedDate,
                "approvedLoanAmount"=> $row['amount'],
                "expectedDisbursementDate"=> $formattedDate,
                "note"=> "",
                "disbursementData"=> []
            );
            // "maxOutstandingLoanBalance"=>"35000",
            $json_data = json_encode($loan_data);
            $dta = array(
                "loan"=>$loan_data,
                "transction"=> $s['transction'],
                "loan_s"=> $row['id'],
                "loan_id"=> $row['loan_id']
            );
            // print_r($row); die();
            array_push($data,$dta);
        }
        return $data;
    }
    // fetchStudent
    public function fetchStudent($start_date=0, $end_date=0) {
        try {            
            $sql = "SELECT *,CAST(REPLACE(loan_amount, ',', '') AS FLOAT) as amount,SUBSTRING(acct_no,1,CHAR_LENGTH(acct_no) - 1) as sub,STR_TO_DATE(loan_date, '%d-%b-%y') as day,REPLACE(loan_date,'-', ' ') as date_loan, STR_TO_DATE(loan_date, '%d-%b-%y') as day,REPLACE(exp_date,'-', ' ') as loan_expiry FROM loans WHERE STR_TO_DATE(loan_date, '%d-%b-%y') >= '$start_date' AND STR_TO_DATE(loan_date, '%d-%b-%y') <= '$end_date' AND loan_Id IS NULL AND client_id IS NOT NULL";
            // WHERE client_id != 0 AND loan_Id = 0 AND error =''
            // WHERE MONTH(loan_date) = 12
            // client_id !=0 AND loan_id = 0
            $db = $this->getConnection();
            // var_dump($this); die();
            // echo $sql;
            // $stmt = $this->con_2->prepare($sql);
            $stmt = $this->connect->prepare($sql); 
            $stmt->execute();
            $rows = $stmt->fetchAll();
            // var_dump($rows); die();
            $data = array();
            foreach($rows as $s){
                // print_r($s);
                try{
                    $dateObject = DateTime::createFromFormat('d M y', $s['date_loan']);
                    
                    $formattedDate = $dateObject->format('d M Y');
                    // print_r($formattedDate);
                    // print_r($row_clients); 
                    $loan_data = array(
                            "dateFormat"=> "dd MMMM yyyy",
                            "locale"=> "en",
                            "productId"=> 5,
                            "principal"=> $s['amount'],
                            "loanTermFrequency"=> 30,
                            "loanTermFrequencyType"=> 0,
                            "loanType"=> "individual",
                            "numberOfRepayments"=> 30,
                            "repaymentEvery"=> 1,
                            "repaymentFrequencyType"=> 0,
                            "interestRatePerPeriod"=> 25,
                            "amortizationType"=> 1,
                            "interestType"=> 0,
                            "interestCalculationPeriodType"=> 1,
                            "transactionProcessingStrategyId"=> 1,
                            "rates"=> array(),
                            "expectedDisbursementDate"=> $formattedDate,
                            "submittedOnDate"=> $formattedDate,
                            "client_id"=> $s['client_id'],
                            "daysInYearType"=>1,
                            "disbursementData"=>array()
                        );

                    // "maxOutstandingLoanBalance"=>"35000",
                        $json_data = json_encode($loan_data);
                        $dta = array(
                            "loan"=>$loan_data,
                            "transction"=> $s['transction'],
                            "loan_s"=> $s['id']
                        );
                        array_push($data,$dta);
                }catch (Exception $ex){
                    // print_r($ex);
                }
            }
            // print_r($data);
            return $data;
        }catch(Exception $ex){
            return $ex;
        }
    }
    public function fetchApprove( $start_date=0, $end_date=0){
        $sql = "SELECT *,CAST(REPLACE(loan_amount, ',', '') AS FLOAT) as amount,SUBSTRING(acct_no,1,CHAR_LENGTH(acct_no) - 1) as sub,STR_TO_DATE(loan_date, '%d-%b-%y') as day,REPLACE(loan_date,'-', ' ') as date_loan, STR_TO_DATE(loan_date, '%d-%b-%y') as day,REPLACE(exp_date,'-', ' ') as loan_expiry FROM loans WHERE STR_TO_DATE(loan_date, '%d-%b-%y') >= '$start_date' AND STR_TO_DATE(loan_date, '%d-%b-%y') <= '$end_date' AND loan_Id IS NOT NULL AND client_id IS NOT NULL";
        // echo $sql;
        //  AND disbursed = 0 AND disbursed_error = '' 
        // AND approved != 0 AND disbursed =0 AND disbursed_error = ''
        $stmt = $this->connect->prepare($sql); 
        $stmt->execute();
        $rows = $stmt->fetchAll();
        // print_r($rows);
        $data=array(); 
        foreach($rows as $row){
            $dateObject = DateTime::createFromFormat('d M y', $row['date_loan']);        
            $formattedDate = $dateObject->format('d M Y'); 
            $loan_data = array(
                "locale"=> "en",
                "dateFormat"=> "dd MMMM yyyy",
                "approvedOnDate"=> $formattedDate,
                "approvedLoanAmount"=> $row['amount'],
                "expectedDisbursementDate"=> $formattedDate,
                "note"=> "",
                "disbursementData"=> []
            );
            // "maxOutstandingLoanBalance"=>"35000",
            $json_data = json_encode($loan_data);
            $dta = array(
                "loan"=>$loan_data,
                "transction"=> $s['transction'],
                "loan_s"=> $row['id'],
                "loan_id"=> $row['loan_id']
            );
            // print_r($row); die();
            array_push($data,$dta);
        }
        return $data;
    }
    public function postLoanId($loan_s, $loan_id, $acct_no){
        try{
            $sql3 = "UPDATE loans SET loan_id = $loan_id  WHERE id = $loan_s";
            // print_r($s);echo $sql3; die();
            // echo $sql3; die();
            $stmt3 = $this->connect->prepare($sql3); 
            $stmt3->execute();
        }catch(Exception $ex){
            print_r($ex);
        }
    }
    public function postError($loan_id,$tran,$loan_s,$error){
        try{
            $sql3 = 'UPDATE loans SET error = "'.$error.'" WHERE id = '.$loan_s.'';
            // echo $sql3; die();
            // print_r($s);echo $sql3; die();
            $stmt3 = $this->connect->prepare($sql3); 
            $stmt3->execute();
        }catch(Exception $ex){
            print_r($ex);
        }
    }
    public function postApproved($loan_s, $loan_id, $acct_no){
        try{
            // approve
            $sql3 = "UPDATE loans SET approved = 1  WHERE id = $loan_s";
            // $sql3 = "UPDATE loans SET disbursed = 1  WHERE id = $loan_s";
            // print_r($s);echo $sql3; die();
            // echo $sql3; die();
            $stmt3 = $this->connect->prepare($sql3); 
            $stmt3->execute();
        }catch(Exception $ex){
            print_r($ex);
        }
    }
     public function postDisburse($loan_s, $loan_id, $acct_no){
        try{
            // approve
            // $sql3 = "UPDATE loans_1_19jan SET approved = 1  WHERE id = $loan_s";
            $sql3 = "UPDATE loans SET disbursed = 1  WHERE id = $loan_s";
            // print_r($s);echo $sql3; die();
            // echo $sql3; die();
            $stmt3 = $this->connect->prepare($sql3); 
            $stmt3->execute();
        }catch(Exception $ex){
            print_r($ex);
        }
    }
    public function postError_2($loan_id,$tran,$loan_s,$error){
        try{
            // approve
            $sql3 = 'UPDATE loans SET approved_error = "'.$error.'" WHERE id = '.$loan_s.'';
            // $sql3 = 'UPDATE loans SET disbursed_error = "'.$error.'" WHERE id = '.$loan_s.'';
            // echo $sql3; die();
            // print_r($s);echo $sql3; die();
            $stmt3 = $this->connect->prepare($sql3); 
            $stmt3->execute();
        }catch(Exception $ex){
            print_r($ex);
        }
    }
    public function postError_4($loan_id,$tran,$loan_s,$error){
        try{
            // approve
            // $sql3 = 'UPDATE loans_1_19jan SET approved_error = "'.$error.'" WHERE id = '.$loan_s.'';
            $sql3 = 'UPDATE loans SET disbursed_error = "'.$error.'" WHERE id = '.$loan_s.'';
            // echo $sql3; die();
            // print_r($s);echo $sql3; die();
            $stmt3 = $this->connect->prepare($sql3); 
            $stmt3->execute();
        }catch(Exception $ex){
            print_r($ex);
        }
    }
    public function postError_3($loan_id,$id,$error){
        try{
            // approve
            // $sql3 = 'UPDATE loans_1_19jan SET approved_error = "'.$error.'" WHERE id = '.$loan_s.'';
            $sql3 = 'UPDATE receipts SET posted_error = "'.$error.'" WHERE id = '.$id.'';
            // echo $sql3; die();
            // print_r($s);echo $sql3; die();
            $stmt3 = $this->connect->prepare($sql3); 
            $stmt3->execute();
        }catch(Exception $ex){
            print_r($ex);
        }
    }
    public function postRepaid($id, $loan_id){
        try{
            // approve
            // $sql3 = 'UPDATE loans_1_19jan SET approved_error = "'.$error.'" WHERE id = '.$loan_s.'';
            $sql3 = 'UPDATE receipts SET posted = 1 WHERE id = '.$id.'';
            // echo $sql3; die();
            // print_r($s);echo $sql3; die();
            $stmt3 = $this->connect->prepare($sql3); 
            $stmt3->execute();
        }catch(Exception $ex){
            print_r($ex);
        }
    }
    // receipts
    public function getAndInsert(){
        try{
            $sql = "SELECT *,SUBSTRING(acct_no,1,CHAR_LENGTH(acct_no) - 1) as sub,STR_TO_DATE(loan_date, '%d-%b-%y') as day,REPLACE(loan_date,'-', ' ') as date_loan, STR_TO_DATE(loan_date, '%d-%b-%y') as day,REPLACE(exp_date,'-', ' ') as loan_expiry FROM loan_s";
            // WHERE MONTH(loan_date) = 12
            $db = $this->getConnection();
            // var_dump($this); die();

            // $stmt = $this->con_2->prepare($sql);
            $stmt = $this->connect->prepare($sql); 
            $stmt->execute();
            $rows = $stmt->fetchAll();
            // 
            foreach($rows as $item){
                $sql2 = "UPDATE receipts_zip 
                        LEFT JOIN loan_s ON receipts_zip.tel = loan_s.tel
                        SET receipts_zip.load_s_id = loan_s.id  WHERE 
                        loan_s.id = ".$item['id']." AND 
                        DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) >=1 AND
                        DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) <= 30 ";
                // $sql2 = "SELECT loan_s.id,STR_TO_DATE(receipts_zip.date,'%d/%m/%Y') as date_of_pay,loan_s.loan_amount, sum(receipts_zip.amount),DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) as diff,receipts_zip.acct_no, STR_TO_DATE(loan_date, '%d-%b-%y') as day,REPLACE(loan_date,'-', ' ') as date_loan, REPLACE(exp_date,'-', ' ') as loan_expiry FROM loan_s LEFT JOIN receipts_zip ON receipts_zip.tel = loan_s.tel WHERE 
                //         loan_s.id = ".$item['id']." AND 
                //         DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) >=1 AND
                //         DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) <= 30 
                //     GROUP BY loan_s.id";
                $stmt2 = $this->connect->prepare($sql2); 
                $stmt2->execute();
                // return $stmt2->fetchAll();
            }
        }catch(Exception $ex){
            print_r($ex);
        }

    }
    public function getAllReceipts ($id){
    try{
            $sql = "SELECT STR_TO_DATE(receipts.date,'%d/%m/%Y') as day,amount,receipts.id,rct_no, receipts.id as r_id FROM receipts LEFT JOIN loans ON receipts.tel = loans.tel WHERE loans.id = $id AND DATEDIFF(STR_TO_DATE(receipts.date,'%d/%m/%Y'),STR_TO_DATE(loans.loan_date,'%d-%b-%y')) >=0 AND DATEDIFF(STR_TO_DATE(receipts.date,'%d/%m/%Y'),STR_TO_DATE(loans.loan_date,'%d-%b-%y')) <= 30 AND posted IS NULL GROUP BY receipts.id ";
            // $sql = "SELECT *, receipts_zip.id as r_id FROM receipts_zip LEFT JOIN loan_s ON receipts_zip.tel = loan_s.tel WHERE loan_s.id = $id AND DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) >=0 AND DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) <= 30 GROUP BY receipts_zip.id ";
            // echo $sql;
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(Exception $ex){
            return $ex;
        }
    
    }
    public function getRegions(){
        try{
            $sql = "SELECT region FROM loans GROUP BY region";
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(Exception $ex){
            return $ex;
        }
    }
    public function getReceipts(){
        $sql1 = "SELECT * FROM loan_s WHERE loan_Id !=0 LIMIT 50";
        $stmt1 = $this->connect->prepare($sql1);
        $stmt1->execute();
        $data = $stmt1->fetchAll();
        $post_data = array();
        foreach($data as $row){
            try{
                $sql2 = "SELECT STR_TO_DATE(receipts_zip.date,'%d/%m/%Y') as day,amount,load_s_id, receipts_zip.id,rct_no,load_s_id  FROM `receipts_zip` WHERE load_s_id = ".$row['loan_Id']." AND posted = 0 GROUP BY receipts_zip.id ";
                $stmt2 = $this->connect->prepare($sql2);
                $stmt2->execute();
                $rows = $stmt2->fetchAll();
                if(count($rows) > 0){
                    array_push($post_data, $rows);
                }
            }catch(Exception $ex){
                print_r($ex);
            }
        }
        return $post_data;
        die();
        $sql = "SELECT STR_TO_DATE(receipts_zip.date,'%d/%m/%Y') as day,amount,load_s_id, receipts_zip.id,rct_no  FROM `receipts_zip` LEFT JOIN loan_s ON loan_s.loan_Id =receipts_zip.load_s_id WHERE load_s_id !=0 AND posted = 0 GROUP BY receipts_zip.id LIMIT 2 OFFSET 14200";

            // 15200
            // limit 100
            // offset 100
            // var_dump($this); die();

            // $stmt = $this->con_2->prepare($sql);
            $stmt = $this->connect->prepare($sql); 
            $stmt->execute();
            $rows = $stmt->fetchAll();echo "yy"; die();
            return $rows;
            // print_r($rows);
            // foreach($rows as $row){
            //     $dt = array();
            //     $dt['amount'] = $row['amount'];
            //     $dt['loan_id'] = $row['load_s_id'];
            //     $dt['id'] = $row['id'];
            //     $dt['rct_no'] = $row['rct_no'];
            //     // $dateObject = DateTime::createFromFormat('Y-M-d', $row['day']);
                    
            //     $formattedDate = date("d M Y", strtotime($row['day']));;  
            //     $dt['d'] = $formattedDate;
            //     $curl = curl_init();

            //     curl_setopt_array($curl, array(
            //       // CURLOPT_URL => 'https://palla.techsavanna.technology:7000/fineract-provider/api/v1/loans/'.$row['load_s_id'].'/transactions?tenantIdentifier=test&command=repayment',
            //       CURLOPT_RETURNTRANSFER => true,
            //       CURLOPT_ENCODING => '',
            //       CURLOPT_MAXREDIRS => 10,
            //       CURLOPT_TIMEOUT => 0,
            //       CURLOPT_FOLLOWLOCATION => true,
            //       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //       CURLOPT_CUSTOMREQUEST => 'POST',
            //       CURLOPT_POSTFIELDS =>'{
            //       "dateFormat": "dd MMMM yyyy",
            //       "locale": "en",
            //       "transactionDate": '.$formattedDate'.,
            //       "transactionAmount": '. $row['amount'].',
            //       "paymentTypeId": "1",
            //       "note": "",
            //       "receiptNumber": '.$row['rct_no'].'
            //     }
            //         ',
            //       CURLOPT_HTTPHEADER => array(
            //         'Authorization: Basic YWRtaW46cGFzc3dvcmQ=',
            //         'Content-Type: application/json'
            //       ),
            //     ));
            //                 echo "dddd"; die();


            //     // $response = curl_exec($curl);

            //     // curl_close($curl);
            //     // $res_data = json_decode($response);
            //     // print_r($res_data);
            //     // if(isset($res_data->resourceId)){
            //     //     postRepaid($row['id'], $row['load_s_id']);
            //     // }else {
            //     //     postError_3($row['load_s_id'],$row['id'],"There was an error");
            //     // }
            //     // array_push($data, $dt);        
            // }

            // return $data;
    }
    public function getReceiptDets($id){
        try{
           $sql2 = "SELECT STR_TO_DATE(receipts.date,'%d/%m/%Y') as day,amount, receipts.id,rct_no FROM `receipts` WHERE id = $id ";
            $stmt2 = $this->connect->prepare($sql2);
            $stmt2->execute();
            $rows = $stmt2->fetchAll();
            return $rows;
        }catch(Exception $ex){
            print_r($ex);
        }
    }
    public function getLoans(){

        $sql = "SELECT * FROM loan_s WHERE loan_Id != 0";
            // var_dump($this); die();

            // $stmt = $this->con_2->prepare($sql);
            $stmt = $this->connect->prepare($sql); 
            $stmt->execute();
            $rows = $stmt->fetchAll();
            // $data = array();

            // foreach($rows as $row){
            //     $dt = array();
            //     $dt['amount'] = $row['amount'];
            //     $dt['id'] = $row['loan_Id'];
            //     // $dateObject = DateTime::createFromFormat('Y-M-d', $row['day']);
                    
            //     $formattedDate = date("d M Y", strtotime($row['day']));;  
            //     $dt['d'] = $formattedDate;
            //     array_push($data, $dt);        
            // }

            return $rows;
    }
    public function searchClient($account, $id){
        // echo $account;
        try{
             $sql = 'SELECT * FROM FF WHERE tel = "'.$account.'" AND client_id = 0';
             // echo $sql;
             // REPLACE(tel," - ", "")
                // WHERE MONTH(loan_date) = 12
            $db = $this->getConnection();
                // var_dump($this); die();
            // echo $sql;
                // $stmt = $this->con_2->prepare($sql);
            $stmt = $this->connect->prepare($sql); 
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if(count($rows) != 0){
                echo $id;
                print_r($rows);
            }
            // if(count($rows)){
            //     // echo " (id)=>[".$id."]";
            //     foreach($rows as $value){
            //         $sql2 = "UPDATE loans_1_19jan SET client_id = $id WHERE id = ".$value['id']." AND client_id = 0";
            //         $stmt2 = $this->connect->prepare($sql2); 
            //         echo $stmt2->execute();
            //     }
            //    //  echo $sql2;
            //    // print_r($rows);
            // }else{
            //     echo "0 -0- 0 => ";
            // }
        }catch(Exception $ex){
            return $ex;
        }
    }
    public function receiptIds(){
        $sql = "SELECT * FROM loan_s WHERE loan_Id != 0 LIMIT 10 OFFSET 10";
        $stmt = $this->connect->prepare($sql); 
        $stmt->execute();
        $rows = $stmt->fetchAll();
        // print_r(count($rows)); die();
        foreach($rows as $item){
            $sql2 = "SELECT * FROM loan_s WHERE client_id = ".$item['client_id']." AND loan_Id !=0";
            $stmt2 = $this->connect->prepare($sql2);
            $stmt2->execute();
            $items = $stmt2->fetchAll();
            print_r(count($items)."  -   ".$item['client_id']);
            echo "gg    oo";
            if(count($items)>0){
                print_r("count = ".count($items)."{}  ");
                if(count($items) >1){
                    for($i=0;$i<count($items);$i++){
                        try{
                            // $sql3 = "UPDATE receipts_zip LEFT JOIN loan_s ON receipts_zip.tel = loan_s.tel SET receipts_zip.load_s_id = loan_s.loan_Id WHERE loan_s.loan_Id = ".$items[$i]['loan_Id']." AND DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) >0 AND DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) <= 30 ";
                            $sql3 = "SELECT sum(amount),total_amount FROM loan_s LEFT JOIN receipts_zip ON receipts_zip.tel = loan_s.tel WHERE loan_s.loan_Id = ".$items[$i]['loan_Id']." AND DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) >0 AND DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) <= 30  ";
                            if($i != count($items)-1){
                                $sql3.="AND STR_TO_DATE(receipts_zip.date,'%d/%m/%Y') <= STR_TO_DATE('".$items[$i==(count($items)-1)?$i:$i+1]['loan_date']."', '%d-%b-%y') ";
                            }
                            
                            $stmt3 = $this->connect->prepare($sql3);
                            $stmt3->execute();
                            echo "id = ".$items[$i]['id'];
                            print_r($sql3);
                            // print_r($stmt3->fetchAll());
                        }catch(Exception $ex){
                            print_r($ex);
                        }
                    }   
                }else {
                    // $sql4 = "UPDATE receipts_zip LEFT JOIN loan_s ON receipts_zip.tel = loan_s.tel SET receipts_zip.load_s_id = loan_s.loan_Id WHERE loan_s.loan_Id = ".$items[$i]['loan_Id']." AND DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) >0 AND DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) <= 30 ";
                    $sql4 = "SELECT loan_s.id,STR_TO_DATE(receipts_zip.date,'%d/%m/%Y') as date_of_pay,DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) as diff,receipts_zip.acct_no, STR_TO_DATE(loan_date, '%d-%b-%y') as day,REPLACE(loan_date,'-', ' ') as date_loan, REPLACE(exp_date,'-', ' ') as loan_expiry, 2,amount FROM loan_s LEFT JOIN receipts_zip ON receipts_zip.tel = loan_s.tel WHERE loan_s.loan_Id = ".$items[$i]['loan_Id']." AND DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) >0 AND DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) <= 30  GROUP BY receipts_zip.id";
                                echo $items[$i]['id']."\trrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr";
                    $stmt4 = $this->connect->prepare($sql4);
                    $stmt4->execute();
                    print_r($sql4);

                }
            }
            // die();
        }
        // print_r(array_search("1",$rows[0]);
    }
    public function receiptIdsReverse(){
        $sql = "SELECT * FROM receipts_zip WHERE load_s_id =0 ORDER BY `receipts_zip`.`date` DESC";
        $stmt = $this->connect->prepare($sql); 
        $stmt->execute();
        $rows = $stmt->fetchAll();
        // print_r($rows); die();
        foreach($rows as $row){
            $sql1 = "SELECT * FROM loan_s WHERE tel = '".$row['tel']."'AND  STR_TO_DATE('".$row['date']."','%d/%m/%Y') > STR_TO_DATE(loan_s.loan_date,'%d-%b-%y') AND STR_TO_DATE('".$row['date']."','%d/%m/%Y') <= STR_TO_DATE(loan_s.exp_date,'%d-%b-%y') ";
            try{
                // $sql1 = "UPDATE receipts_zip LEFT JOIN loan_s ON receipts_zip.tel = loan_s.tel SET load_s_id = loan_s.id WHERE tel = '".$row['tel']."'AND  STR_TO_DATE('".$row['date']."','%d/%m/%Y') >= STR_TO_DATE(loan_s.loan_date,'%d-%b-%y') AND STR_TO_DATE('".$row['date']."','%d/%m/%Y') <= STR_TO_DATE(loan_s.exp_date,'%d-%b-%y') ";
                // AND DATEDIFF(STR_TO_DATE('".$row['date']."','%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) >0 AND DATEDIFF(STR_TO_DATE('".$row['date']."','%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) <= 30 
                // AND STR_TO_DATE('".$row['date']."','%d/%m/%Y') <= STR_TO_DATE(loan_s.loan_date, '%d-%b-%y')
                    $stmt1 = $this->connect->prepare($sql1);
                    $stmt1->execute();
                    $items = $stmt1->fetchAll();
                    // if(count($items) >0){
                    //     print_r("Number of items = ".count($items)."   =    ");
                    //     print_r($items);
                    //     echo "                                       next                           ";
                    // }

                    // }else 
                    if(count($items)>0){
                        $sql4 = "UPDATE receipts_zip SET load_s_id = ".$items[0]['loan_Id']." WHERE id = ".$row['id']."";
                        // echo $sql4;
                        $stmt4 = $this->connect->prepare($sql4);
                        $stmt4->execute();
                    }
            }catch(Exception $ex){
                return $ex;
            }   

        }
    }
    public function fetchStream($id = 0) {
        $table_name = 'streams';
        $sql = "SELECT * FROM streams";
        if ($id != 0) {
          $sql .= ' WHERE '.$table_name.'.id = :id';
        }
        $db = $this->getConnection();
        // var_dump($this); die();
        
        $stmt = $this->connect->prepare($sql);
        
        $stmt->execute(['id' => $id]);
        $rows = $stmt->fetchAll();
        return $rows;
    }
    public function fetchAll($table_name,$id=0) {
        if($table_name == "students"){
            $sql = "SELECT students.id,students.name, students.stream_id, streams.stream_name as stream FROM students LEFT JOIN streams ON students.stream_id = streams.id";
        }else{
            $sql = "SELECT * FROM $table_name";
        }
        if ($id != 0) {
            $sql .= ' WHERE '.$table_name.'.id = :id';
          }
        $db = $this->getConnection();
        // var_dump($this); die();
        // $conn =
        $stmt = $this->connect->prepare($sql);
        
        $stmt->execute();
        $rows = $stmt->fetchAll();
        echo json_encode($rows);
    }
    // public function fetchSize($table_name) {
        
    //     $sql = "SELECT * FROM $table_name";
    //     $db = $this->getConnection();
    //     // var_dump($this); die();
        
    //     $stmt = $this->conn->prepare($sql);
        
    //     $stmt->execute();
    //     $rows = $stmt->fetchAll();
    //     echo json_encode(count($rows));
    // }
    public function insertStudent($student) {
    try {
        $sql = "INSERT INTO students (name , stream_id ) VALUES ('".$student['name']."', ".$student['stream'].")";
        $stmt = $this->connect->prepare($sql);

        return $stmt->execute();
    }catch(Exception $ex) {
        var_dump($ex);
    }
    }
    public function insertStream($stream) {
        try {
            $sql = "INSERT INTO streams (stream_name) VALUES ('".$stream['name']."')";
            $stmt = $this->connect->prepare($sql);
    
            return $stmt->execute();
        }catch(Exception $ex) {
            var_dump($ex);
        }
    }
    public function editStudent($student,$stream, $id) {
        try{
            $sql = "UPDATE students SET name = '$student', stream_id = $stream WHERE id= $id";
            $stmt = $this->connect->prepare($sql);
            // echo $stmt; die();
            return $stmt->execute();
        }catch(Exception $ex) {
            var_dump($ex);
        }
    }
    public function editStream($stream, $id) {
        try{
            $sql = "UPDATE streams SET stream_name = '$stream' WHERE id= $id";
            $stmt = $this->connect->prepare($sql);
            // echo $stmt; die();
            return $stmt->execute();
        }catch(Exception $ex) {
            var_dump($ex);
        }
    }
    public function delete($table_name, $id) {
        try {
            // DELETE FROM `students` WHERE id = 4; 
            $sql = "DELETE FROM `$table_name` WHERE id = $id";
            // echo $sql; die();
            $stmt = $this->connect->prepare($sql);
    
            return $stmt->execute();
        }catch(Exception $ex) {
            var_dump($ex);
        }
    }
}


?>