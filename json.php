<?php
include_once('./controller.php');
$r = new Student();
// $r->receiptIdsReverse();die();
// $r->receiptIds();die();
// $_SESSION['whha'] = "fgg"; print_r($_SESSION['whha']); die();
// print_r(json_encode($r->getReceipts())); die();
$jsonString = file('loan.json','r');

print_r($jsonString);
echo "ddd"; die();

// Decode the JSON string into a PHP array
$data = json_decode($jsonString, true);
print_r($data['pageItems']); die();
// $data['pageItems'][0]['accountNo']
// $i + 0;
foreach ($data['pageItems'] as $key => $value) {
	echo $value['accountNo'];echo"fly";echo $value['id'];echo "whhwwwwwwwwwwwwwwwwwwwwwwwwww";
	die();
	// mobileNo
	if($r->searchClient($value['mobileNo'], $value['id'])){
		// $i+1;
	} 

	// echo '      t   ';
	// code...
}
echo $i;
die();
// print_r($r->searchClient($data['pageItems'][0]['accountNo'])); die();
echo date('h:i:s') . "<br>";

//sleep for 3 seconds
sleep(1);

//start again
echo date('h:i:s'); die();
	$data = array(
	    "dateFormat"=> "dd MMMM yyyy",
	    "locale"=> "en",
	    "clientId"=> 3397,
	    "productId"=> 5,
	    "principal"=> "10,000.00",
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
	    "expectedDisbursementDate"=> "20 Feb 2023",
	    "submittedOnDate"=> "20 Feb 2023",
	    "maxOutstandingLoanBalance"=>"35000",
	    "daysInYearType"=>1,
	    "disbursementData"=>array()
	);
	$json_data = json_encode($data);
	// print_r($json_data); die();
//     // $json_data = json_encode($cart);
    $username = "admin";
    $password = "password";
    $headers = array(
        'Authorization: Basic '. base64_encode($username.':'.$password),
        'Content-Type: application/json'
    );

    //Perform curl post request to add item to the accounts erp
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://palla.techsavanna.technology:7000/fineract-provider/api/v1/loans?tenantIdentifier=test",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $json_data,
        CURLOPT_HTTPHEADER => $headers,
    ));

    $response = curl_exec($curl);

    curl_close($curl);
        
    $response_data = json_decode($response);
    // loan id
    print_r($response_data->loanId);

// curl --location --request POST 'https://palla.techsavanna.technology:7000/fineract-provider/api/v1/loans?tenantIdentifier=test' \
// --header 'Authorization: Basic YWRtaW46cGFzc3dvcmQ=' \
// --header 'Content-Type: application/json' \
// --data-raw '{
// }'
?>