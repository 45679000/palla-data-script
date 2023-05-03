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
    
    // print_r($_GET);
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