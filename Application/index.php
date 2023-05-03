<?php 
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script
    src="https://code.jquery.com/jquery-3.6.3.min.js"integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
        crossorigin="anonymous"></script> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <title>Kilimo High School</title>

</head>
<body>
    <div class="header">
        <h2 class="h2 text-center">Kilimo high school</h2>

    </div>
    <nav class="nav justify-content-center  ">
          <a class="nav-link active" href="#" aria-current="page">Home</a>
          <!-- <a class="nav-link" href="#">Students</a>
          <a class="nav-link disabled" href="#">Streams</a> -->
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <div class="mt-4">
                    <h3 class="h3">Number of students: <span id="students_no"></span></h3>
                </div>
                <div class="mt-4">
                    <h3 class="h3">Number of streams: <span id="streams_no"></span></h3>
                </div>
            </div>
            <div class="col-6">
            <div class="mt-4  mx-auto">
                    <button class="btn btn-info" id="add_new_student">Add new student</button>
                </div>
                <div class="mt-2  mx-auto">
                    <button class="btn btn-info" id="add_new_stream">Add new stream</button>
                </div>
            </div>
        </div>
        <hr>
        <div id="new_student">
            <form id="student_new" class="col-5">
                <h4 class="h4">New Student form</h4>
                <div class="form-control">
                    <label for="">Full name</label>
                    <input type="text" name="name" class="form-control" placeholder="John Doe">

                    <label for="">Stream</label>
                    <select name="stream" id="stream" class="stream form-select">
                    </select>
                    <input type="submit" value="Submit" class="mt-2 btn btn-danger">
                </div>
            </form>
        </div>
        <div id="new_stream">
            <form id="stream_new" class="col-5">
                <h4 class="h4">New Stream form</h4>
                <div class="form-control">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Form 1A">

                    <input type="submit" value="Submit" class="mt-2 btn btn-danger">
                </div>
            </form>
        </div>
        <div id="edit_student">
            <form id="student_edit" class="col-5">
                <h4 class="h4">Edit Student form</h4>
                <div class="form-control">
                    <label for="">Full name</label>
                    <input type="text" id="student_name" name="name" class="form-control" placeholder="John Doe">
                    <input type="hidden" name="id" id="student_id">
                    <label for="">Stream</label>
                    <!-- <select name="stream" id="stream" class="stream form-select"> -->
                    <!-- </select> -->
                    <select name="stream" id="stream_student" class="stream form-select">
                    </select>
                    <input type="submit" value="Submit" class="mt-2 btn btn-danger">
                </div>
            </form>
        </div>
        <div id="edit_stream">
            <form id="stream_edit" class="col-5">
                <h4 class="h4">Edit Stream form</h4>
                <div class="form-control">
                    <label for="">Name</label>
                    <input type="text" name="name" id="stream_name" class="form-control" placeholder="Form 1A">
                    <input type="hidden" name="id" id="stream_id">
                    <input type="submit" value="Submit" class="mt-2 btn btn-danger">
                </div>
            </form>
        </div>
        <div class="row" id="tables">
            <div id="studentList" class="mt-3 col-6">
                <h3 class="text-center">Table of all Students</h3>
                <table class="table pt-3 card-table table-striped table-vcenter">
                    <thead class="bg-teal">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Stream</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="table-body"></tbody>
                </table>
            </div>
            <div id="streamList" class="mt-3 col-6">
                <h3 class="text-center">Table of all Streams</h3>
                <table class="table pt-3 card-table table-striped table-vcenter">
                    <thead class="bg-teal">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="table-stream"></tbody>
                </table>
            </div>
        </div>
        <div class="col-7" id="by-id">
            <div class="mx-auto" id="stream_details">
                <h4 class="h4">Stream: <span id="stream_name"></span></h4>
            </div>
            <div class="mx-auto" id="student_details">
                <h4 class="h4">Name: <span id="student_name"></span></h4>
                <p id="stream_student">Stream:  <span id="student_stream_content"></span></p>
            </div>
        </div>
        
    </div>
   
    
</body>
<script
			  src="https://code.jquery.com/jquery-3.6.3.min.js"
			  integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
			  crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#edit_student').hide()
        $('#edit_stream').hide()
        $('#stream_new').hide()
        $('#student_new').hide()
        $('#by-id').hide()
    // $('.loader').hide()
    loadStudents();
    loadStreams()

    let r = ''
    $('#add_new_student').click(function (e) {
        e.preventDefault()
        let x = false
        $('#student_new').toggle()
        // x =
    })
    $('#add_new_stream').click(function (e) {
        e.preventDefault()
        let x = false
        $('#stream_new').toggle()
        // x =
    })
    // listStudents()
    function loadStudents() {
        $.ajax({
            type: "GET",
            url: "./action.php",
            data: {
                action: 'students'
            },
            success: function(data) {
                console.log(data)
                document.getElementById('students_no').innerText = data.length
                let tr = ''
                data.forEach((element) => {
                    tr += `<tr id="${element.id}">
                    <td>${element.id}</td>
                    <td>${element.name}</td>
                    <td>${element.stream}</td>
                    <td><button class='btn btn-sm btn-info editBtn'>Edit</button><button class='ml-3 btn btn-sm btn-danger deleteBtn'>Delete</button><button class='ml-3 btn btn-sm btn-secondary viewStudentBtn'>View</button></td>
                    </tr>`
                })
                document.getElementById('table-body').innerHTML = tr
                // <td>".$record['id']."</td>";
                //     $html.= "<td>".$record['name']."</td>";
                //     $html.= "<td>".$record['stream_id']."</td>";
                //     // actions
                //     $html.= "<td>
                //         <i class='fa fa-edit text-success editBtn'></i> &nbsp;&nbsp;&nbsp;
                //         "; 
                // $('#students_no').val(data.length)
            }
        });

    }
    function loadStreams() {
        $.ajax({
            type: "GET",
            url: "./action.php",
            data: {
                action: 'streams'
            },
            success: function(data) {
                $('#streams_no').val(data.length)
                document.getElementById('streams_no').innerText = data.length
                console.log(data)
                let x = ''
                data.forEach(element => {
                    x += `<option value="${element.id}">${element.stream_name}</option>`
                });
                document.getElementById('stream').innerHTML = x
                document.getElementsByClassName('stream').innerHTML = x
                r = x
                let tr = ''
                data.forEach((element) => {
                    tr += `<tr id="${element.id}">
                    <td>${element.id}</td>
                    <td>${element.stream_name}</td>
                    <td><button class='btn btn-sm btn-info editStreamBtn'>Edit</button><button class='ml-3 btn btn-sm btn-danger deleteStreamBtn'>Delete</button><button class='ml-3 btn btn-sm btn-secondary viewStreamBtn'>View</button></td>
                    </tr>`
                })
                document.getElementById('table-stream').innerHTML = tr
                // console.log(data.length)
            }
        });

    }
    $('#student_new').on('submit', (function(e){
        let x = new FormData(this)
        x.append('action', 'new_student')
        e.preventDefault();
        $.ajax({
            type: "POST",
            data: x,
            contentType: false,
            cache: false, 
            processData:false,
            url: "./action.php",
            success: function (data) {
                // console.log(data)
                alert("Student was saved successfully")
                $('#student_new').hide();
                loadStudents();
                loadStreams()

            }
        });
    }))
    $('#stream_new').on('submit', (function(e){
        let x = new FormData(this)
        x.append('action', 'new_stream')
        e.preventDefault();
        $.ajax({
            type: "POST",
            data: x,
            contentType: false,
            cache: false, 
            processData:false,
            url: "./action.php",
            success: function (data) {
                // console.log(data)
                alert("Stream was saved successfully")
                $('#stream_new').hide();
                loadStudents();
                loadStreams()

            }
        });
    }))
    $('#stream_edit').on('submit', (function(e){
        let x = new FormData(this)
        x.append('action', 'edit_stream')
        e.preventDefault();
        $.ajax({
            type: "POST",
            data: x,
            contentType: false,
            cache: false, 
            processData:false,
            url: "./action.php",
            success: function (data) {
                // console.log(data)
                alert("Stream was edited successfully")
                $("#edit_stream").hide();
                loadStudents();
                loadStreams()
                

            }
        });
    }))
    $('#student_edit').on('submit', (function(e){
        let x = new FormData(this)
        x.append('action', 'edit_student')
        e.preventDefault();
        $.ajax({
            type: "POST",
            data: x,
            contentType: false,
            cache: false, 
            processData:false,
            url: "./action.php",
            success: function (data) {
                // console.log(data)
                alert("Student was edited successfully")
                $("#edit_student").hide();
                loadStudents();
                loadStreams()

            }
        });
    }))
     $("body").on("click", ".viewStudentBtn", function(e){
        e.preventDefault()
        
        var editId = $(this).parent().parent().attr('id');
        console.log("i was clicked"+editId)
        // $('#by-id').show()
        // $('#tables')
        // $('#stream_details').hide()
        // $('#student_details').show()
        $.ajax({
            type: "GET",
            url: "./action.php",
            data: {
                action: 'get_student',
                id: editId
            },
            success: function(e) {
                alert(`Student name: ${e.name} \n Stream: ${e.stream}`)
            }
        });
        // $('#edit_stream').hide()
    });
    $("body").on("click", ".viewStreamBtn", function(e){
        e.preventDefault()
        
        var editId = $(this).parent().parent().attr('id');
        console.log("i was clicked"+editId)
        $.ajax({
            type: "GET",
            url: "./action.php",
            data: {
                action: 'get_stream',
                id: editId
            },
            success: function(e) {
                alert(`Stream name: ${e.stream_name}`)
            }
        });
        // $('#edit_stream').hide()
    });
    $("body").on("click", ".editBtn", function(e){
        e.preventDefault()
        
        var editId = $(this).parent().parent().attr('id');
        console.log("i was clicked"+editId)
        $('#edit_student').show()
        $.ajax({
            type: "GET",
            url: "./action.php",
            data: {
                action: 'get_student',
                id: editId
            },
            success: function(e) {
                $('#edit_student').show()
                let data = e.student
                document.getElementById('student_name').value = e.name
                document.getElementById('student_id').value = e.id
                console.log(r)
                document.getElementById('stream_student').innerHTML = r
                loadStudents();
                loadStreams()
            }
        });
        // $('#edit_stream').hide()
    });
    $("body").on("click", ".deleteBtn", function(e){
        e.preventDefault()
        var editId = $(this).parent().parent().attr('id');
        console.log("i was clicked"+editId)
        $.ajax({
            type: "POST",
            data: {
                action: "delete_student",
                id: editId
            },
            // contentType: false,
            // cache: false, 
            // processData:false,
            url: "./action.php",
            success: function (data) {
                // console.log(data)
                alert("Student was deleted successfully")
                loadStudents();
                loadStudents();

            }
        });
    });
    $("body").on("click", ".editStreamBtn", function(e){
        e.preventDefault()
        
        var editId = $(this).parent().parent().attr('id');
        console.log("i was clicked"+editId)
        // $('#edit_stream').show()
        $.ajax({
            type: "GET",
            url: "./action.php",
            data: {
                action: 'get_stream',
                id: editId
            },
            success: function(e) {
                console.log(e)
                $('#edit_stream').show()
                document.getElementById('stream_name').value = e.stream_name
                document.getElementById('stream_id').value = e.id
                loadStudents();
                loadStreams()
            }
        });
        
    });
    $("body").on("click", ".deleteStreamBtn", function(e){
        e.preventDefault()
        var editId = $(this).parent().parent().attr('id');
        console.log("i was clicked"+editId)
        $.ajax({
            type: "POST",
            data: {
                action: "delete_stream",
                id: editId
            },
            url: "./action.php",
            success: function (data) {
                // console.log(data)
                alert("Student was deleted successfully")
                loadStreams()
                loadStudents();
            }
        });
    });
})
</script>
</html>