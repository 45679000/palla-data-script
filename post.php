<?php
include_once('./controller.php');
$r = new Student();
$rows = $r->getReceipts();
foreach($rows as $row){

  var_dump($row);
  echo "-----------------------------------space---------------------------------";
    // $dt = array();
    // $dt['amount'] = $row['amount'];
    // $dt['loan_id'] = $row['load_s_id'];
    // $dt['id'] = $row['id'];
    // $dt['rct_no'] = $row['rct_no'];
    // $dateObject = DateTime::createFromFormat('Y-M-d', $row['day']);
        
    $formattedDate = date("d M Y", strtotime($row['day']));;  
    $id = $row['id'];
    $loan_id = $row['load_s_id'];
    $rct_no= $row['rct_no'];
    $amount = $row['amount'];
    // $dt['d'] = $formattedDate;
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://palla.techsavanna.technology:7000/fineract-provider/api/v1/loans/'.$loan_id.'/transactions?tenantIdentifier=test&command=repayment',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
      "dateFormat": "dd MMMM yyyy",
      "locale": "en",
      "transactionDate": "'.$formattedDate.'",
      "transactionAmount": '.$amount.',
      "paymentTypeId": "1",
      "note": "",
      "receiptNumber": "'.$rct_no.'"
    }
        ',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic YWRtaW46cGFzc3dvcmQ=',
        'Content-Type: application/json'
      ),
    ));
    //             echo "dddd"; die();


    $response = curl_exec($curl);

    curl_close($curl);
    $res_data = json_decode($response);
    print_r($res_data);
    if(isset($res_data->resourceId)){
        $r->postRepaid($row['id'], $row['load_s_id']);
    }else {
        $r->postError_3($row['load_s_id'],$row['id'],"There was an error");
    }
    // array_push($data, $dt);        
}
// $curl = curl_init();

// curl_setopt_array($curl, array(
//   CURLOPT_URL => 'https://palla.techsavanna.technology:7000/fineract-provider/api/v1/loans/19392/transactions?tenantIdentifier=test&command=repayment',
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => '',
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => 'POST',
//   CURLOPT_POSTFIELDS =>'{
//   "dateFormat": "dd MMMM yyyy",
//   "locale": "en",
//   "transactionDate": "30 Oct 2022",
//   "transactionAmount": "1500.00",
//   "paymentTypeId": "1",
//   "note": "",
//   "receiptNumber": "1623558"
// }
// 	',
//   CURLOPT_HTTPHEADER => array(
//     'Authorization: Basic YWRtaW46cGFzc3dvcmQ=',
//     'Content-Type: application/json'
//   ),
// ));

// // $response = curl_exec($curl);

// curl_close($curl);
// $res_data = json_decode($response);
// print_r($res_data);
// print_r($res_data->resourceId);
