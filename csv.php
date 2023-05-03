<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With, Origin, Content-Type, Accept');
header("Access-Control-Expose-Headers: Content-Length, X-JSON");
header('Content-Type: application/json');
// print_r($_FILES);
$handle = fopen($_FILES['file_data']['tmp_name'], "r");
// $handle = fopen('./loans.csv', "r");
// print_r($handle);
$table = '';
$data_arr = array();
while(($data = fgetcsv($handle, 10000, ",")) !== FALSE){
	$lines = 0;
	if($lines = 0){

	}
    $table.="<div>";

    for($i = 0; $i < count($data); $i++) {
    	

        $table.="<p>".$data[$i]."</p>";

    }
	array_push($data_arr, $data);
	// die();
    $table.="</div>\n";

}
// return $table;
// print_r($data_arr);
$table = '';
$table.="<table class='table pt-3 mt-4'>";
for($i = 0;$i < count($data_arr); $i++){
	if($i == 0){
		$table.="<thead class='thead-dark'><tr>";
		foreach($data_arr[$i] as $heading){
			$table.="<th style='text-transform: capitalize'>".$heading."</th>";
		}
		$table.="</tr></thead><tbody>";
	}else {
		$table.="<tr>";
		foreach($data_arr[$i] as $heading){
			$table.="<td>".$heading."</td>";
		}
		$table.="</tr>";
	}
}
$table.="</tbody></table>";
echo json_encode(array(
	"table"=>$table,
	"data_arr"=>$data_arr
));
// echo "ggg gg =  >".count($data_arr);
// print_r($table);
// $headers = fgetcsv($handle, 10000, ",");
// print_r($headers);
// while (($data = fgetcsv($handle, 1000, ",")