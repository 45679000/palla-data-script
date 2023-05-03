<?php 
include_once('./nav.php');
?>

    <div class="container-fluid">
      <div class="header">
        <h2 class="h2 text-center">Data to be uploaded</h2>
      </div>
      <div id="studentList" class="mt-5 col-8 mx-auto">
        <h3 class="text-center">Upload</h3>
        <!-- Data uploaded. Returning home to view uploaded data -->
        <div class="alert alert-primary" role="alert" id="success">
            Data uploaded. <button id="post_all" class="btn btn-primary">Post all</button>
        </div>
        <div class="alert alert-primary" role="alert" id="approve">
            Data posted. <button class="btn btn-secondary" id="approve_all">Approve all</button>
        </div>
        <div class="alert alert-primary" role="alert" id="disburse">
            Data approved. <button id="disburse_all">Disburse all</button>
        </div>
        <form id="loans_form">
            <label class="label">Type</label>
            <select name="type" id="type" class="form-select" required>
                <option value="1">Loans</option>
                <option value="2">Receipts</option>
            </select>
            <label class="label">Upload file</label>
            <input type="file" class="form-control" name="file_data" required />
            <input type="submit" name="submit_form" value="submit" class="mt-2 btn btn-danger">
        </form>
      </div>
        <div id="spin" class="col-12 mx-auto">
            <div class="col-6 mx-auto">
                <div class="spinner-grow text-primary" role="status">
                  <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-primary" role="status">
                  <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-primary" role="status">
                  <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-primary" role="status">
                  <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-primary" role="status">
                  <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-primary" role="status">
                  <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-primary" role="status">
                  <span class="sr-only"></span>
                </div>
                <div class="spinner-grow text-primary" role="status">
                  <span class="sr-only"></span>
                </div>
            </div>
        </div>
        
        <div class="list_div col-10 mx-auto">
            <div class="row col-12 mt-2" id="header-top">
                <div class="col-8 text-center p-3">
                    <h3 class="h3">Data to be uploaded preview</h3>
                </div>
                <div class="col-4 p-3">
                    <button class="btn btn-info btn-lg" id="upload">
                        Upload
                    </button>
                </div>
            </div>
            <div id="list"></div>
        </div>    
      <!-- </div> -->
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        $('#edit_student').hide()
        $('#spin').hide()
        $('#list').hide()
        $('#header-top').hide()
        $("#success").hide()
        $("#approve").hide()
        $("#disburse").hide()

        let data_arr = []
        let type = 0
        // $('#edit_stream').hide()
        // $('#stream_new').hide()
        // $('#student_new').hide()
        // $('#by-id').hide()
    // $('.loader').hide()
    // loadLoans();
    // loadStreams()
        // approveLoan()
        // repayLoan()
        // getLoans()
    // let r = ''
    // $('#add_new_student').click(function (e) {
    //     e.preventDefault()
    //     let x = false
    //     $('#student_new').toggle()
    //     // x =
    // })
    // $('#add_new_stream').click(function (e) {
    //     e.preventDefault()
    //     let x = false
    //     $('#stream_new').toggle()
    //     // x =
    // })
    // listStudents()
        $('#loans_form').on('submit', 
            function(e){
                e.preventDefault()
                openLoader()
                type = $('#type').val()
                console.log(type)
                form_data = new FormData(this)
                console.log(new FormData(this))
                $.ajax({
                    type: "POST",
                    data: form_data,
                    contentType: false,
                    dataType: "json",   
                    cache: false,
                    processData: false,
                    url: "./csv.php",
                    success: function(data) {
                        console.log(data)
                        data_arr = data.data_arr
                        closeLoader()
                        $('#list').html(data.table);
                        $('.table').DataTable({
                            // dom: 'Bfrtip',
                            buttons: [
                                'colvis',
                                'excel',
                                'print'
                            ]
                        } )
                        // loadUnbookedLots();
                        // $("#plistContainer").show();
                    }
                });
            }
        )
        $('#upload').click(function (e){
            e.preventDefault()
            $('#spin').show()
            // console.log(data_arr[0])
            console.log(data_arr)
            $.ajax({
                type: "POST",
                // url: "./action.php",
                cache: true,
                // contentType: 'html/text',
                data: {
                    action: type==1?'upload-loans':'post_receipts',
                    // loans: data_arr,
                    receipts: JSON.stringify(data_arr)
                },
                success: function(data) {
                    console.log(data)
                    $('#spin').hide()
                    // if(data.success){
                        $("#success").show()
                        // setInterval(
                        //     function(){
                        //         window.location.href = "./";
                        //     }
                        // ,3000);
                    // }
                        
                }
            })
        })
        $('#post_all').click(function (e){
            if(type =1){
                $.ajax({
                type: "GET",
                url: "./action.php",
                cache: true,
                // contentType: 'html/text',
                data: {
                    action: 'loans'
                },
                success: function(data) {
                    console.log(data)
                    data.forEach(item => {
                        // postLL(item)
                    })
                }
                });
            }else{
                repayLoan()
            }
        })
        $('#approve_all').click(function (e){
             $.ajax({
                type: "GET",
                url: "./action.php",
                cache: true,
                // contentType: 'html/text',
                data: {
                    action: 'approve-loans'
                },
                success: function(data) {
                    console.log(data)
                    data.forEach(item => {
                        // console.log(item.loan)
                        approveIt(item)
                        // disburseIt(item)
                        // postLoan(item)
                    })
                }
            });
        })
        $('#disburse_all').click(function (e){
             $.ajax({
                type: "GET",
                url: "./action.php",
                cache: true,
                // contentType: 'html/text',
                data: {
                    action: 'approve-loans'
                },
                success: function(data) {
                    console.log(data)
                    data.forEach(item => {
                        // console.log(item.loan)
                        // approveIt(item)
                        disburseIt(item)
                        // postLoan(item)
                    })
                }
            });
        })
    function openLoader(){
        $('#spin').show()
        $('#list').hide()
        $('#header-top').hide()
    }
    function closeLoader(){
        $('#spin').hide()
        $('#list').show()
        $('#header-top').show()
    }    
    function loadLoans() {
        $.ajax({
            type: "GET",
            url: "./action.php",
            cache: true,
            // contentType: 'html/text',
            data: {
                action: 'loans'
            },
            success: function(data) {
                console.log(data)
                data.forEach(item => {
                //     // console.log(item.loan)
                    postLL(item)
                //     // postLoan(item)
                })
            }
        });

    }
    function approveLoan(){
        $.ajax({
            type: "GET",
            url: "./action.php",
            cache: true,
            // contentType: 'html/text',
            data: {
                action: 'approve-loans'
            },
            success: function(data) {
                console.log(data)
                data.forEach(item => {
                    // console.log(item.loan)
                    // approveIt(item)
                    disburseIt(item)
                    // postLoan(item)
                })
            }
        });
    }
    function repayLoan(){
        $.ajax({
            type: "GET",
            url: "./action.php",
            cache: true,
            // contentType: 'html/text',
            data: {
                action: 'repay'
            },
            success: function(data) {
                console.log(data)
                data.forEach(item=>{
                    console.log(item)
                    item.forEach(i=>{
                        console.log(item)
                        var settings = {
                          // "url": "https://palla.techsavanna.technology:7000/fineract-provider/api/v1/loans/"+item.loan_id+"/transactions?tenantIdentifier=test&command=repayment",
                          "method": "POST",
                          "timeout": 0,
                          "headers": {
                            "Authorization": "Basic YWRtaW46cGFzc3dvcmQ=",
                            "Content-Type": "application/json"
                          },
                          "data": JSON.stringify({
                            "dateFormat": "dd MMMM yyyy",
                            "locale": "en",
                            "transactionDate": item.d,
                            "transactionAmount": item.amount,
                            "paymentTypeId": "1",
                            "note": "",
                            "receiptNumber": ""+item.rct_no+""
                          }),
                        };

                        $.ajax(settings).done(function (response) {
                          console.log(response);
                          $.ajax({
                            type: "POST",
                            // url: "./action.php",
                            // cache: true,
                            // contentType: 'html/text',
                            data: {
                                action: 'posted-receipt',
                                id: item.id,
                                loan_id: item.loan_id
                            },
                            success: function(data) {
                                // console.log(data)
                            }
                        })
                        }).fail(function (er){
                            console.log(er)
                            $.ajax({
                                type: "POST",
                                // url: "./action.php",
                                // cache: true,
                                // contentType: 'html/text',
                                data: {
                                    action: 'posted-receipt',
                                    error: er.status == 500 ? "Internal server error" : er.responseJSON.errors[0].developerMessage,
                                    id: item.id,
                                    loan_id: item.loan_id
                                },
                                success: function(data) {
                                    // console.log(data)
                                }
                            })
                        });
                    })
                    
                })
                // data.forEach(item => {
                //     console.log(item)
                    
                //     // approveIt(item)
                //     // disburseIt(item)
                //     // postLoan(item)
                // })
            }
        });
    }
    function approveIt(item){
        var content = item.loan
        var settings = {
          "url": "https://palla.techsavanna.technology:7000/fineract-provider/api/v1/loans/"+item.loan_id+"?tenantIdentifier=test&command=approve",
          "method": "POST",
          "timeout": 0,
          "headers": {
            "Authorization": "Basic YWRtaW46cGFzc3dvcmQ=",
            "Content-Type": "application/json"
          },
          "data": JSON.stringify({
            "locale": "en",
            "dateFormat": "dd MMMM yyyy",
            "approvedOnDate": content.approvedOnDate,
            "approvedLoanAmount": content.approvedLoanAmount,
            "expectedDisbursementDate" : content.approvedOnDate,
            "note": "",
            "disbursementData" : []}),
        };
        $.ajax(settings).done(function (response) {
          console.log(response);
          $.ajax({
                type: "POST",
                url: "./action.php",
                cache: true,
                // contentType: 'html/text',
                data: {
                    action: 'posted-approve',
                    trans: item.transction,
                    client: response.clientId,
                    loan_s: item.loan_s,
                    loan_id: response.loanId
                },
                success: function(data) {
                    // console.log(data)
                }
            })
        }).fail(function (er){
            console.log(er)
            $.ajax({
                type: "POST",
                url: "./action.php",
                cache: true,
                // contentType: 'html/text',
                data: {
                    action: 'posted-approve',
                    error: er.status == 500 ? "Internal server error" : er.responseJSON.errors[0].developerMessage,
                    trans: item.transction,
                    client: item.loan.clientId,
                    loan_s: item.loan_s
                },
                success: function(data) {
                    // console.log(data)
                }
            })
        });
    }
    function disburseIt(item){
        var content = item.loan
        var settings = {
          "url": "https://palla.techsavanna.technology:7000/fineract-provider/api/v1/loans/"+item.loan_id+"?tenantIdentifier=test&command=disburse",
          "method": "POST",
          "timeout": 0,
          "headers": {
            "Authorization": "Basic YWRtaW46cGFzc3dvcmQ=",
            "Content-Type": "application/json"
          },
          "data": JSON.stringify({
            "dateFormat": "dd MMMM yyyy",
            "locale": "en",
            "actualDisbursementDate": content.approvedOnDate
            }),
        };
        $.ajax(settings).done(function (response) {
          console.log(response);
          $.ajax({
                type: "POST",
                url: "./action.php",
                cache: true,
                // contentType: 'html/text',
                data: {
                    action: 'posted-approve',
                    trans: item.transction,
                    client: response.clientId,
                    loan_s: item.loan_s,
                    loan_id: response.loanId
                },
                success: function(data) {
                    // console.log(data)
                }
            })
        }).fail(function (er){
            console.log(er)
            $.ajax({
                type: "POST",
                url: "./action.php",
                cache: true,
                // contentType: 'html/text',
                data: {
                    action: 'posted-approve',
                    error: er.status == 500 ? "Internal server error" : er.responseJSON.errors[0].developerMessage,
                    trans: item.transction,
                    client: item.loan.clientId,
                    loan_s: item.loan_s
                },
                success: function(data) {
                    // console.log(data)
                }
            })
        });
    }
    function postLL(item){
        var content = item.loan
        var settings = {
          "url": "https://palla.techsavanna.technology:7000/fineract-provider/api/v1/loans?tenantIdentifier=test",
          "method": "POST",
          "timeout": 0,
          "headers": {
            "Authorization": "Basic YWRtaW46cGFzc3dvcmQ=",
            "Content-Type": "application/json"
          },
          "data": JSON.stringify({
            "dateFormat": "dd MMMM yyyy",
            "locale": "en",
            "clientId": content.client_id,
            "productId": 5,
            "principal": content.principal,
            "loanTermFrequency": 30,
            "loanTermFrequencyType": 0,
            "loanType": "individual",
            "numberOfRepayments": 30,
            "repaymentEvery": 1,
            "repaymentFrequencyType": 0,
            "interestRatePerPeriod": 25,
            "amortizationType": 1,
            "interestType": 1,
            "interestCalculationPeriodType": 1,
            "transactionProcessingStrategyId": 1,
            "rates": [],
            "expectedDisbursementDate": content.expectedDisbursementDate,
            "submittedOnDate": content.expectedDisbursementDate,
            "maxOutstandingLoanBalance": "",
            "daysInYearType": 1,
            "disbursementData": []
          }),
        };
        console.log(settings)
        $.ajax(settings).done(function (response) {
          console.log(response);
          $.ajax({
                type: "POST",
                url: "./action.php",
                cache: true,
                // contentType: 'html/text',
                data: {
                    action: 'posted',
                    trans: item.transction,
                    client: response.clientId,
                    loan_s: item.loan_s,
                    loan_id: response.loanId
                },
                success: function(data) {
                    // console.log(data)
                }
            })
        })
        .fail(function (er){
            console.log(er)
            $.ajax({
                type: "POST",
                url: "./action.php",
                cache: true,
                // contentType: 'html/text',
                data: {
                    action: 'posted',
                    error: er.status == 500 ? "Internal server error" : er.responseJSON.errors[0].developerMessage,
                    trans: item.transction,
                    client: item.loan.clientId,
                    loan_s: item.loan_s
                },
                success: function(data) {
                    // console.log(data)
                }
            })
        });
        // });
    }
    function postLoan(item){
        var i = item.loan
        var settings = {
          "url": "https://palla.techsavanna.technology:7000/fineract-provider/api/v1/loans?tenantIdentifier=test",
          "method": "POST",
          "timeout": 0,
          "headers": {
            "Authorization": "Basic YWRtaW46cGFzc3dvcmQ=",
            "Content-Type": "application/json"
          },
          "data": JSON.stringify({
            "dateFormat": "dd MMMM yyyy",
            "locale": "en",
            "clientId": 17252,
            "productId": 5,
            "principal": "10,000.00",
            "loanTermFrequency": 30,
            "loanTermFrequencyType": 0,
            "loanType": "individual",
            "numberOfRepayments": 30,
            "repaymentEvery": 1,
            "repaymentFrequencyType": 0,
            "interestRatePerPeriod": 25,
            "amortizationType": 1,
            "interestType": 0,
            "interestCalculationPeriodType": 1,
            "transactionProcessingStrategyId": 1,
            "rates": [],
            "expectedDisbursementDate": "10 Feb 2023",
            "submittedOnDate": "10 Feb 2023",
            "maxOutstandingLoanBalance": "35000",
            "daysInYearType": 1,
            "disbursementData": []
            // "dateFormat": "dd MMMM yyyy",
            // "locale": "en",
            // "clientId": i.clientId,
            // "productId": 5,
            // "principal": i.principal,
            // "loanTermFrequency": 30,
            // "loanTermFrequencyType": 0,
            // "loanType": "individual",
            // "numberOfRepayments": 30,
            // "repaymentEvery": 1,
            // "repaymentFrequencyType": 0,
            // "interestRatePerPeriod": 25,
            // "amortizationType": 1,
            // "interestType": 0,
            // "interestCalculationPeriodType": 1,
            // "transactionProcessingStrategyId": 1,
            // "rates": [],
            // "expectedDisbursementDate": i.expectedDisbursementDate,
            // "submittedOnDate": i.expectedDisbursementDate,
            // "maxOutstandingLoanBalance": "35000",
            // "daysInYearType": 1,
            // "disbursementData": []
          }),
        };

        $.ajax(settings).done(function (response) {
          console.log(response);
          $.ajax({
                type: "POST",
                url: "./action.php",
                cache: true,
                // contentType: 'html/text',
                data: {
                    action: 'posted',
                    trans: response.transction,
                    client: response.loan.clientId,
                    loan_s: response.loan_s,
                    loan_id: response.loanId
                },
                success: function(data) {
                    // console.log(data)
                }
            })
        }).fail(function (er){
            console.log(er)
            $.ajax({
                type: "POST",
                url: "./action.php",
                cache: true,
                // contentType: 'html/text',
                data: {
                    action: 'posted',
                    error: er.status == 500 ? "Internal server error" : er.responseJSON.errors[0].developerMessage,
                    trans: item.transction,
                    client: item.loan.clientId,
                    loan_s: item.loan_s
                },
                success: function(data) {
                    // console.log(data)
                }
            })
        });
    }
    function getLoans(){
        $.ajax({
            type: "GET",
            url: "./action.php",
            cache: true,
            // contentType: 'text/html',
            dataType: "html",
            data: {
                action: 'get-loans'
            },
            success: function(data) {
                // console.log(data)
                $('#list').html(data);
                $('.table').DataTable({
                    // dom: 'Bfrtip',
                    buttons: [
                        'colvis',
                        'excel',
                        'print'
                    ]
                } )
                // data.forEach(item => {
                //     var settings = {
                //       "url": "https://palla.techsavanna.technology:7000/fineract-provider/api/v1/loans/"+item.loan_Id+"?tenantIdentifier=default",
                //       "method": "GET",
                //       "timeout": 0,
                //       "headers": {
                //         "Authorization": "Basic YWRtaW46cGFzc3dvcmQ="
                //       },
                //     };

                //     $.ajax(settings).done(function (response) {
                //       console.log(response);
                //       console.log("live env"+response.clientId +" -> db"+ item.client_id)
                //       console.log(response.clientId == item.client_id)
                //     });
                //     // console.log(item.loan)
                //     // approveIt(item)
                //     // disburseIt(item)
                //     // postLoan(item)
                // })
            }
        });
        
    }
    function updateId(loan_id, client_id){
        var settings = {
          "url": "https://palla.techsavanna.technology:7000/fineract-provider/api/v1/loans/18780?tenantIdentifier=test",
          "method": "PUT",
          "timeout": 0,
          "headers": {
            "Authorization": "Basic YWRtaW46cGFzc3dvcmQ=",
            "Content-Type": "application/json"
          },
          "data": JSON.stringify({
            "locale": "en",
            "dateFormat": "dd MMMM yyyy",
            "loanType": "individual",
            "productId": 5,
            "clientId": "52"
          }),
        };

        $.ajax(settings).done(function (response) {
          console.log(response);
        });
    }
    function updateInterestType(){
        var settings = {
          "url": "https://palla.techsavanna.technology:7000/fineract-provider/api/v1/loans/18780?tenantIdentifier=test",
          "method": "PUT",
          "timeout": 0,
          "headers": {
            "Authorization": "Basic YWRtaW46cGFzc3dvcmQ=",
            "Content-Type": "application/json"
          },
          "data": JSON.stringify({
            "locale": "en",
            "dateFormat": "dd MMMM yyyy",
            "loanType": "individual",
            "productId": 5,
            "clientId": "52",
            "interestType": 0,
            // "principal": "10000",(principal)
            "loanTermFrequency": 30,
            "loanTermFrequencyType": 0,
            "numberOfRepayments": 30,
            "repaymentEvery": 1,
            "repaymentFrequencyType": 0,
            // "interestRatePerPeriod": 25,(interestRatePerPeriod)
            // "interestCalculationPeriodType": 0,(interestCalculationPeriodType)
            "amortizationType": 1,
            "expectedDisbursementDate": "20 Feb 2023",
            "transactionProcessingStrategyId": 1
          }),
        };

        $.ajax(settings).done(function (response) {
          console.log(response);
        });
    }
})
</script>
</html>