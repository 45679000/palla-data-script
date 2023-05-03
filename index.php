<?php 
include_once('./nav.php');
?>
<style>
    .dataTables_paginate a{
        margin-right: 1rem;
        cursor: pointer;
    }
</style>
    <div class="container-fluid">
        <div class="my-5 row col-12 mx-auto" style="justify-content: space-around;">
            <div class="card" style="width: 18rem;">
              <div class="card-body">
                <h5 class="card-title">Loan posted</h5>
                <p class="card-text">This are the loans that have been posted to the LMS</p>
                <a href="./loans.php" class="card-link">View posted loans</a>
              </div>
            </div>
            <div class="card" style="width: 18rem;">
              <div class="card-body">
                <h5 class="card-title">Receipts posted</h5>
                <p class="card-text">This are the total repayments that have been posted to the ls</p>
                <a href="#" class="card-link">View posted repayments</a>
              </div>
            </div>
            <!-- <div class="card" style="width: 18rem;">
              <div class="card-body">
                <h5 class="card-title">Receipts not yet posted</h5>
                <p class="card-text">Repayments that have not yet been posted</p>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
              </div>
            </div>
            <div class="card" style="width: 18rem;">
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
              </div>
            </div> -->
        </div>
        <div class="col-8 col-lg-3 col-md-6 col-sm-8 mx-5 py-4 px-2" style="border: 1px solid rgba(0, 0, 0, 0.175); border-radius: 5px;">
            <h5 class="h5">Filter table to view</h5>
            <form id="data">
                <label class="label mb-2 mx-3">Select table you would like to view</label>
                <select name="type" class="form-select" id="type">
                    <option value="1">All loans</option>
                    <option value="2">All receipts</option>
                    <option value="3">Posted loans</option>
                    <option value="4">Posted receipts</option>
                    <option value="5">Loans waiting to be posted</option>
                    <option value="6">Receipts waiting to be posted</option>
                </select>
                <div class="mx-1 mt-2 col-12 row">
                    <form id="dates-form">
                        <div class="col-6">
                            <label class="label mb-2 mx-3">Start date</label>
                            <input name="start_date" id="start_date" type="date" class="form-control" required />
                        </div>
                        <div class="col-6">
                            <label class="label mb-2 mx-3">End date</label>
                            <input name="end_date" id="end_date" type="date" class="form-control" required />
                        </div>
                        <input type="submit" id="filter_date" class="mt-3 btn btn-danger" value="Filter" />
                    </form>
                </div>
            </form>
        </div>
      <div id="studentList" class="my-5 col-12 mx-auto">
          <div class="list_div" id="list">

          </div>
      </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#edit_student').hide()
        $('#type').change(function(e){
            let type = $('#type').val()
            console.log(type)
            if(type ==1 ){
                getLoans()
            }else if(type ==2){
                getReceipts()
                alert("2")
            }else if(type ==3){
                getPostedLoans()
                alert("3")
            }else if(type ==4){
                getPostedReceipts()
                alert("4")
            }else if(type ==5){
                getLoansToPost()
            }else if(type ==6){
                getReceiptsToPost()
            }
        })
        $('#filter_date').click(function(e){
            e.preventDefault()
            dateChange()
        })
        $
        // $('#edit_stream').hide()
        // $('#stream_new').hide()
        // $('#student_new').hide()
        // $('#by-id').hide()
    // $('.loader').hide()
    // loadLoans();
    // loadStreams()
        // approveLoan()
        // repayLoan()
        getLoans()
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
    function dateChange(){
        let type = $('#type').val()
        let min_date = $("#start_date").val()
        let max_date = $("#end_date").val()
        console.log(type)
        if(max_date && min_date){
            console.log(max_date)
            console.log(min_date)
            if(type ==1 ){
                getLoans(max_date,min_date)
            }else if(type ==2){
                getReceipts(max_date,min_date)
                alert("2")
            }else if(type ==3){
                getPostedLoans(max_date,min_date)
                alert("3")
            }else if(type ==4){
                getPostedReceipts(max_date,min_date)
                alert("4")
            }else if(type ==5){
                getLoansToPost(max_date,min_date)
            }else if(type ==6){
                getReceiptsToPost(max_date,min_date)
            }
        }else{
            alert("Make sure you input both starting and end date")
        }
    }
    function getLoans(max_date=null,min_date=null){
        $.ajax({
            type: "GET",
            url: "./action.php",
            cache: true,
            // contentType: 'text/html',
            dataType: "html",
            data: {
                action: 'get-loans',
                max_date: max_date,
                min_date: min_date
            },
            success: function(data) {
                console.log(data)
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
    function getReceipts(max_date=null,min_date=null){
        $.ajax({
            type: "GET",
            url: "./action.php",
            cache: true,
            // contentType: 'text/html',
            dataType: "html",
            data: {
                action: 'get-receipts',
                max_date: max_date,
                min_date: min_date
            },
            success: function(data) {
                console.log(data)
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
    function getPostedLoans(max_date=null,min_date=null){
        $.ajax({
            type: "GET",
            url: "./action.php",
            cache: true,
            // contentType: 'text/html',
            dataType: "html",
            data: {
                action: 'get-posted-loans',
                max_date: max_date,
                min_date: min_date
            },
            success: function(data) {
                console.log(data)
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
    function getPostedReceipts(max_date=null,min_date=null){
        $.ajax({
            type: "GET",
            url: "./action.php",
            cache: true,
            // contentType: 'text/html',
            dataType: "html",
            data: {
                action: 'get-posted-receipts',
                max_date: max_date,
                min_date: min_date
            },
            success: function(data) {
                console.log(data)
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
    function getLoansToPost(max_date=null,min_date=null){
        $.ajax({
            type: "GET",
            url: "./action.php",
            cache: true,
            // contentType: 'text/html',
            dataType: "html",
            data: {
                action: 'get-loans-to-post',
                max_date: max_date,
                min_date: min_date
            },
            success: function(data) {
                console.log(data)
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
    function getReceiptsToPost(max_date=null,min_date=null){
        $.ajax({
            type: "GET",
            url: "./action.php",
            cache: true,
            // contentType: 'text/html',
            dataType: "html",
            data: {
                action: 'get-receipts-to-post',
                max_date: max_date,
                min_date: min_date
            },
            success: function(data) {
                console.log(data)
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
          "url": "https://palla.techsavanna.technology:7000/fineract-provider/api/v1/loans?tenantIdentifier=default",
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
<script>
    console.log("whha")
    fetch('loans.csv')
    .then(response => response.text())
    .then(data => {
    // Parse the CSV data
    const rows = data.split('\n');
    // console.log(rows)
    // const headers = rows[0].split(',');
    // const result = [];
    // for (let i = 1; i < rows.length; i++) {
    //   const obj = {};
    //   const currentRow = rows[i].split(',');
    //   for (let j = 0; j < headers.length; j++) {
    //     obj[headers[j]] = currentRow[j];
    //   }
    //   result.push(obj);
    // }
    // console.log(result); // Output the parsed data
  });
</script>
</html>