<?php 
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: X-Requested-With, Origin, Content-Type, Accept');
    header("Access-Control-Expose-Headers: Content-Length, X-JSON");
    header('Content-Type: application/json');

    // Include action.php file
    include_once './controller.php';
    // Create object of Book class
    $book = new Student();
    
    
    if($_GET['action'] == 'loans'){
        $html = "";
        echo json_encode($book->fetchStudent());die();
        $html .='<table class="table pt-3 card-table table-striped table-vcenter">
        <thead class="bg-teal">
        <tr>
            <th>Client Id</th>
            <th>Account no</th>
            <th>Name</th>
            <th>Mobile No.</th>
            <th>Loan amount</th>
            <th>Total amount</th>
            <th>Loan date</th>
            <th>Expiry date</th>
            <th>Sub-region</th>
            <th>Region</th>
            <th>Posted</th>
            <th>Approved</th>
            <th>Disbursed</th>
            <th>Receipted</th>
        </tr>
        </thead>
        <tbody>';
        $data =$book->fetchStudent();
        echo count('$data'); die();
        foreach($data as $item){
            $html.="<tr>";
                $html.="
                    <td>".$item['client_id']."</td>
                    <td>".$item['acct_no']."</td>
                    <td>".$item['client']."</td>
                    <td>".$item['tel']."</td>
                    <td>".$item['loan_amount']."</td>
                    <td>".$item['total_amount']."</td>
                    <td>".$item['loan_date']."</td>
                    <td>".$item['exp_date']."</td>
                    <td>".$item['sub_region']."</td>
                    <td>".$item['region']."</td>
                    <td>Posted</td>
                    <td>Approved</td>
                    <td>Disbursed</td>
                    <td>Receipted</td>
                ";
            $html.="</tr>";
        }
        $html .="</tbody></thead>";
        echo json_encode($html);
        // echo $book->fetchAll("students");
    }
    if($_GET['action'] == 'approve-loans'){
        $html = "";
        echo json_encode($book->fetchApprove());die();
        $html .='<table class="table pt-3 card-table table-striped table-vcenter">
        <thead class="bg-teal">
        <tr>
            <th>Client Id</th>
            <th>Account no</th>
            <th>Name</th>
            <th>Mobile No.</th>
            <th>Loan amount</th>
            <th>Total amount</th>
            <th>Loan date</th>
            <th>Expiry date</th>
            <th>Sub-region</th>
            <th>Region</th>
            <th>Posted</th>
            <th>Approved</th>
            <th>Disbursed</th>
            <th>Receipted</th>
        </tr>
        </thead>
        <tbody>';
        $data =$book->fetchStudent();
        echo count('$data'); die();
        foreach($data as $item){
            $html.="<tr>";
                $html.="
                    <td>".$item['client_id']."</td>
                    <td>".$item['acct_no']."</td>
                    <td>".$item['client']."</td>
                    <td>".$item['tel']."</td>
                    <td>".$item['loan_amount']."</td>
                    <td>".$item['total_amount']."</td>
                    <td>".$item['loan_date']."</td>
                    <td>".$item['exp_date']."</td>
                    <td>".$item['sub_region']."</td>
                    <td>".$item['region']."</td>
                    <td>Posted</td>
                    <td>Approved</td>
                    <td>Disbursed</td>
                    <td>Receipted</td>
                ";
            $html.="</tr>";
        }
        $html .="</tbody></thead>";
        echo json_encode($html);
        // echo $book->fetchAll("students");
    }
    if($_GET['action'] == 'repay'){
        $html = "";
        echo json_encode($book->getReceipts());die();
        // echo $book->fetchAll("students");
    }
    if($_GET['action'] == 'repay_id'){
        $id = $_GET['id'];
        $loan_id = $_GET['loan_id'];
        echo json_encode($book->getReceiptDets($id));die();
        // echo $book->fetchAll("students");
    }
    if($_GET['action'] == 'get-loans'){
        $max_date = $_GET['max_date'];
        $min_date = $_GET['min_date'];
        if(isset($max_date) && isset($min_date)){
            $data =$book->fetchLoans($max_date, $min_date);
        }else{
            $data = $book->fetchLoans();
        }
        $html = "";
        // echo json_encode($book->getLoans());die();
        $html .='<h3 class="text-center">Table of all loans</h3><table class="table pt-3 card-table table-striped table-vcenter">
        <thead class="bg-teal">
        <tr>
            <th>Client Id</th>
            <th>Account no</th>
            <th>Name</th>
            <th>Mobile No.</th>
            <th>Loan amount</th>
            <th>Total amount</th>
            <th>Loan date</th>
            <th>Expiry date</th>
            <th>Sub-region</th>
            <th>Region</th>
            <th>Loan id</th>
            <th>Posted</th>
            <th>Approved</th>
            <th>Disbursed</th>
            <th>Receipted</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>';
        // print_r($data); die();
        foreach($data as $item){
            $html.="<tr>";
                $html.="
                    <td>".$item['client_id']."</td>
                    <td>".$item['acct_no']."</td>
                    <td>".$item['client']."</td>
                    <td>".$item['tel']."</td>
                    <td>".$item['loan_amount']."</td>
                    <td>".$item['total_amount']."</td>
                    <td>".$item['loan_date']."</td>
                    <td>".$item['exp_date']."</td>
                    <td>".$item['sub_region']."</td>
                    <td>".$item['region']."</td>
                    <td>".$item['loan_Id']."</td>
                    <td>Posted</td>
                    <td>Approved</td>
                    <td>Disbursed</td>
                    <td>Receipted</td>
                    <td class='".$item['id']."'><button id='post_loan' class='btn btn-sm btn-info'>Post loan</button><a href='./receipts.php?id=".$item['id']."' class='view btn btn-sm btn-danger' id='".$item['id']."'>View Receipts</a></td>
                ";
            $html.="</tr>";
        }
        $html .="</tbody></thead>";
        echo $html;
        // echo $book->fetchAll("students");
    }
    if($_GET['action'] == 'get-receipts'){
        $max_date = $_GET['max_date'];
        $min_date = $_GET['min_date'];
        if(isset($max_date) && isset($min_date)){
            $data =$book->fetchReceipts($max_date, $min_date);
        }else{
            $data =$book->fetchReceipts();
        }
        $html = "";
        // echo json_encode($book->getLoans());die();
        $html .='<h3 class="text-center">Table of all Receipts</h3><table class="table pt-3 card-table table-striped table-vcenter">
        <thead class="bg-teal">
        <tr>
            <th>Id</th>
            <th>Account No.</th>
            <th>Receipt No.</th>
            <th>Client</th>
            <th>Tel</th>
            <th>Description</th>
            <th>Amount/th>
            <th>Branch</th>
            <th>Sub-region</th>
            <th>Loan id</th>
            <th>Posted</th>
            <th>Posted error</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>';
        foreach($data as $item){
            $html.="<tr>";
                $html.="
                    <td>".$item['id']."</td>
                    <td>".$item['acct_no']."</td>
                    <td>".$item['rct_no']."</td>
                    <td>".$item['client']."</td>
                    <td>".$item['tel']."</td>
                    <td>".$item['Description']."</td>
                    <td>".$item['date']."</td>
                    <td>".$item['amount']."</td>
                    <td>".$item['branch']."</td>
                    <td>".$item['sub_region']."</td>
                    <td>".$item['posted']."</td>
                    <td>".$item['posted_error']."</td>
                    <td class='".$item['id']."'><button id='post_loan' class='btn btn-sm btn-info'>Post</button></td>
                ";
            $html.="</tr>";
        }
        $html .="</tbody></thead>";
        echo $html;
        // echo $book->fetchAll("students");
    }
    if($_GET['action'] == 'get_loan_dets'){
        $id = $_GET['id'];
        echo json_encode($book->fetchLoan($id)[0]);
    }
    if($_GET['action'] == 'get_receipts-for-loan'){
        $max_date = $_GET['max_date'];
        $id = $_GET['id'];
        $data = $book->fetchReceiptsForLoan($id);
        $html = "";
        // echo json_encode($book->getLoans());die();
        $html .='<h3 class="text-center">Receipts</h3><table class="table pt-3 card-table table-striped table-vcenter">
        <thead class="bg-teal">
        <tr>
            <th>Id</th>
            <th>Account No.</th>
            <th>Receipt No.</th>
            <th>Client</th>
            <th>Tel</th>
            <th>Description</th>
            <th>Amount/th>
            <th>Branch</th>
            <th>Sub-region</th>
            <th>Loan id</th>
            <th>Posted</th>
            <th>Posted error</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>';
        foreach($data as $item){
            $html.="<tr>";
            $posted = $item['posted'] == null? "<span class='text-danger text-capitalize'>false</span>":"<span class='text-success text-capitalize'>true</span>";
            $btn = $item['posted'] == null? "<button id='".$item['r_id']."' loan='".$item['id']."' class='btn btn-sm btn-info post_loan'>Post</button>":"";
                $html.="
                    <td>".$item['r_id']."</td>
                    <td>".$item['acct_no']."</td>
                    <td>".$item['rct_no']."</td>
                    <td>".$item['client']."</td>
                    <td>".$item['tel']."</td>
                    <td>".$item['Description']."</td>
                    <td>".$item['date']."</td>
                    <td>".$item['amount']."</td>
                    <td>".$item['branch']."</td>
                    <td>".$item['sub_region']."</td>
                    <td>".$posted."</td>
                    <td>".$item['posted_error']."</td>
                    <td class='".$item['r_id']."'>".$btn."</td>
                ";
            $html.="</tr>";
        }
        $html .="</tbody></thead>";
        echo $html;
        // echo $book->fetchAll("students");
    }
    // $post_data = $_POST;
    // var_dump($_POST["action"]);
    // $post = $post_data[action];
    // echo $post == posted;
    if($_POST["action"] == "posted"){
        // print_r($_POST);die();
        // [error] => Client with identifier 8833 does not exist
        // [trans] => 221019 - 75L
        // [client] => 8833
        // [loan_s] => 6
        $loan_id = $_POST['loan_id'];
        $tran = $_POST['trans'];
        $loan_s = $_POST['loan_s'];
        $error = $_POST['error'];
        $client = $_POST["client"];
        if(!$loan_id){
            $book->postError($loan_id,$tran,$loan_s,$error);
        }else{
            $book->postLoanId($loan_s, $loan_id, $acct_no);
            // "UPDATE tbl SET loan_id = $loan_id  WHERE id = $loan_s";
        }
    }
    if($_POST["action"] == "posted-approve"){
        // print_r($_POST);die();
        // [error] => Client with identifier 8833 does not exist
        // [trans] => 221019 - 75L
        // [client] => 8833
        // [loan_s] => 6
        $loan_id = $_POST['loan_id'];
        $tran = $_POST['trans'];
        $loan_s = $_POST['loan_s'];
        $error = $_POST['error'];
        $client = $_POST["client"];
        if(!$loan_id){
            $book->postError_2($loan_id,$tran,$loan_s,$error);
        }else{
            $book->postApproved($loan_s, $loan_id, $acct_no);
            // "UPDATE tbl SET loan_id = $loan_id  WHERE id = $loan_s";
        }
    }
    if($_POST["action"] == "posted-receipt"){
        // print_r($_POST);die();
        // [error] => Client with identifier 8833 does not exist
        // [trans] => 221019 - 75L
        // [client] => 8833
        // [loan_s] => 6
        $loan_id = $_POST['loan_id'];
        $id = $_POST['id'];
        $error = $_POST['error'];
        if($error){
            $book->postError_3($loan_id,$id,$error);
        }else{
            $book->postRepaid($id, $loan_id);
            // "UPDATE tbl SET loan_id = $loan_id  WHERE id = $loan_s";
        }
    }
    if($_POST["action"] == "upload-loans"){
        $jsonString = file_get_contents('response.json');
        // Decode the JSON string into a PHP array
        $data = json_decode($jsonString, true);
        $pageItems = $data['pageItems'];
        $load_data = $_POST["loans"];
        $arr = array_slice($load_data,5);
        foreach ($arr as $value) {
            $post_data = array(
                "client_id"=>0,
                "acct_no"=> $value[0],
                "transction"=>$value[1],
                "client"=>$value[2],
                "tel"=>$value[3],
                "loan_amount"=>str_replace(',',"",$value[4]),
                "interest"=>str_replace(',',"",$value[5]),
                "rate"=>$value[6],
                "total_amount"=>str_replace(',',"",$value[7]),
                "loan_date"=>$value[8],
                "exp_date"=>$value[9],
                "region"=>$value[10],
                "sub_region"=>$value[11]
            );
            // echo str_replace(" - ","",$value[3]);
            $found_key = array_search(str_replace(" - ","",$value[3]), array_column($pageItems, 'mobileNo'));
            if($found_key){
                $post_data["client_id"] = $pageItems[$found_key]['id'];
            }
            // print_r($book->insertNewLoan($post_data));
            // print_r(gettype($book->insertNewLoan($post_data)));
            if($book->insertNewLoan($post_data)){
                echo json_encode(array(
                    success=>true
                ));
            }else{
                echo json_encode(array(
                    success=>false
                ));
            }
            // print_r($post_data);
            // print_r($found_key);
            // die();
        }
        
    }
    if($_POST["action"] == "post_receipts"){

        $load_data = json_decode($_POST['receipts']);
        $arr = array_slice($load_data,1);
        foreach ($arr as $value) {
            $post_data = array(
                "acct_no"=> $value[0],
                "rct_no"=>$value[1],
                "client"=>$value[2],
                "tel"=>$value[3],
                "description"=>$value[4],
                "date"=>$value[5],
                "amount"=>str_replace(',',"",$value[6]),
                "branch"=>$value[7],
                "sub_region"=>$value[8]
            );
            print_r($book->insertNewReceipt($post_data));
            // print_r($post_data);
            // print_r($found_key);
            // die();
        }
        
    }
    die();
    if($_GET['action'] == 'students'){
        // print_r($book->fetchStudent());
        echo $book->fetchAll("students");
    }
    if($_GET['action'] == 'get_student'){
        // $data = array(
        //     "student" => $book->fetchStudent($_GET['id'])[0],
        //     "streams" => $book->fetchAll("streams")
        // );
        echo json_encode($book->fetchStudent($_GET['id'])[0]);
    }
    if($_GET['action'] == 'get_stream'){
        echo json_encode($book->fetchStream($_GET['id'])[0]);
    }
    if($_GET['action'] == 'streams'){
        echo $book->fetchAll("streams");
    }
    if($_GET['action'] == "students_table"){
    }
    if($_GET['action'] == 'list_students'){
        $html = "";
        $students = $book->fetchStudent();
        $html.= '
            <table class="table pt-3 card-table table-striped table-vcenter">
                <thead class="bg-teal">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Stream</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
                foreach($students AS $record){
                    $id = $record['stream_id'];
                    $html.= "<tr id=".$id.">";
                    $html.= "<td>".$record['id']."</td>";
                    $html.= "<td>".$record['name']."</td>";
                    $html.= "<td>".$record['stream_id']."</td>";
                    // actions
                    $html.= "<td>
                        <i class='fa fa-edit text-success editBtn'></i> &nbsp;&nbsp;&nbsp;
                        "; 
                        // if($_SESSION['role_id'] == 1){
                        //     $html.= "<i class='fa fa-close text-danger deleteBtn'></i> &nbsp;&nbsp;&nbsp;";
                        // }

                    $html.= "</td>";
                }
                $html.= '</tbody>
            </table>
        ';
        echo $html;
    }
    if($_POST){
        if($_POST['action'] == 'new_student'){
            $student = array();
            $student['name'] = $_POST['name'];
            $student['stream'] = $_POST['stream'];
            $res = $book->insertStudent($student);
            if($res == 1){
                echo json_encode(array(
                    "success"=> true,
                    
                ));
            }else{
                echo json_encode(array(
                    "success"=> false,
                    "res" => $res
                ));
            }
        }
        if($_POST['action'] == 'new_stream'){
            $stream = array();
            $stream['name'] = $_POST['name'];
            $res = $book->insertStream($stream);
            print_r($res); die();
            if($res == 1){
                echo json_encode(array(
                    "success"=> true,
                    
                ));
            }else{
                echo json_encode(array(
                    "success"=> false,
                    "res" => $res
                ));
            }
        }
        if($_POST['action'] == 'delete_student'){
            // print_r($_POST);
            $res = $book->delete("students", $_POST['id']);
            if($res == 1){
                echo json_encode(array(
                    "success"=> true,
                    
                ));
            }else{
                echo json_encode(array(
                    "success"=> false,
                    "res" => $res
                ));
            }
        }
        if($_POST['action'] == 'delete_stream'){
            // print_r($_POST);
            $res = $book->delete("streams", $_POST['id']);
            if($res == 1){
                echo json_encode(array(
                    "success"=> true,
                    
                ));
            }else{
                echo json_encode(array(
                    "success"=> false,
                    "res" => $res
                ));
            }
        }
        if($_POST['action'] == 'edit_stream'){
            $res = $book->editStream($_POST['name'], $_POST['id']);
            if($res == 1){
                echo json_encode(array(
                    "success"=> true,
                    
                ));
            }else{
                echo json_encode(array(
                    "success"=> false,
                    "res" => $res
                ));
            }
        }
        if($_POST['action'] == 'edit_student'){
            $res = $book->editStudent($_POST['name'],$_POST['stream'], $_POST['id']);
            if($res == 1){
                echo json_encode(array(
                    "success"=> true,
                    
                ));
            }else{
                echo json_encode(array(
                    "success"=> false,
                    "res" => $res
                ));
            }
        }
        // echo "whaa";
    }
?>