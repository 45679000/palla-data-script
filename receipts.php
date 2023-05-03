<?php 
include_once('./nav.php');
// print_r($_GET);
?>
    <style>
    .wrap-div: {
        border: 1px solid #333;
        border-radius: 10px;
    }
</style>
    <div class="container-fluid">
      <div class="header">
        <h2 class="h2 text-center">Receipts for loan: <span id="id"><?php echo $_GET['id'];?></span></h2>
      </div>
      <div id="studentList" class="mt-5 col-10 mx-auto">
        <h3 class="text-center">Loan details</h3>
        <div class="row col-12 mx-auto wrap-div border p-3">
            <div class="col-3 wrap-card" style="border-right: 1px solid #333;">
                <p>Client name: <span id="client" class="text-bold" style="font-weight: bold;"></span></p>
                <p>Loan amount: <span id="loan_amount" class="text-bold"  style="font-weight: bold;"></span></p>
                <p>Mobile No.: <span id="tel" class="text-bold" style="font-weight: bold;"></span></p>
            </div>
            <div class="col-3 wrap-card" style="border-right: 1px solid #333;">
                <p>Loan date: <span id="loan_date" class="text-bold" style="font-weight: bold;"></span></p>
                <p>Expiry date: <span id="exp_date" class="text-bold" style="font-weight: bold;"></span></p>
                <p>Total amount to be repaid: <span id="total_amount" class="text-bold" style="font-weight: bold;"></span></p>
            </div>
            <div class="col-3 wrap-card" style="border-right: 1px solid #333;">
                <p>Region: <span id="region" class="text-bold" style="font-weight: bold;"></span></p>
                <p>Sub-region: <span id="sub_region" class="text-bold" style="font-weight: bold;"></span></p>
                <p>Interest: <span id="interest" class="text-bold" style="font-weight: bold;"></span></p>
            </div>
            <div class="col-3 wrap-card">
                <p>Posted: <span id="posted" class="text-bold" style="font-weight: bold;"></span></p>
                <p>Approved: <span id="approved" class="text-bold" style="font-weight: bold;"></span></p>
                <p>Disbursed: <span id="disbursed" class="text-bold" style="font-weight: bold;"></span></p>
            </div>
        </div>
      </div>
        <div id="spin" class="col-12 mx-auto mt-5">
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
                    <h3 class="h3">Receipts</h3>
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
        // $('#list').hide()
        $('#header-top').hide()
        $("#success").hide()
        let searchParams = new URLSearchParams(window.location.search)
        let param = searchParams.get('id')
        var mySpan = document.getElementById("region");

        // Set the value of the span element using innerHTML
        mySpan.innerHTML = "This is the new text.";
        // document.getElementById("id").value = "Johnny Bravo";
        // $('#id').val('param')
        // console.log(param)
        let data_arr = []
        let type = 0
        getLoanReceipts(param)
        getLoanDets(param)
    function getLoanReceipts(id){
         $.ajax({
            type: "GET",
            url: "./action.php",
            cache: true,
            // contentType: 'text/html',
            dataType: "html",
            data: {
                action: 'get_receipts-for-loan',
                id: id
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
                // //     // console.log(item.loan)
                //     postLL(item)
                // //     // postLoan(item)
                // })
            }
        });
    } 
    function getLoanDets(id){
         $.ajax({
            type: "GET",
            url: "./action.php",
            cache: true,
            // contentType: 'text/html',
            dataType: "json",
            data: {
                action: 'get_loan_dets',
                id: id
            },
            success: function(data) {
                document.getElementById("client").innerHTML = data.client
                document.getElementById("loan_amount").innerHTML = data.loan_amount
                document.getElementById("tel").innerHTML = data.tel
                document.getElementById("loan_date").innerHTML = data.loan_date
                document.getElementById("exp_date").innerHTML = data.exp_date
                document.getElementById("total_amount").innerHTML = data.total_amount
                document.getElementById("region").innerHTML = data.region
                document.getElementById("sub_region").innerHTML = data.sub_region
                document.getElementById("interest").innerHTML =  data.interest
                document.getElementById("posted").innerHTML = data.loan_Id == null? "false" : "true"
                document.getElementById("approved").innerHTML = data.approved == null? "false" : "true"
                document.getElementById("disbursed").innerHTML =  data.disbursed == null? "false" : "true"
                console.log(data)
            }
        });
    } 
        $('#loans_form').on('submit', 
            function(e){
                e.preventDefault()
                openLoader()
                type = $('#type').val()
                // console.log(type)
                form_data = new FormData(this)
                // console.log(new FormData(this))
                $.ajax({
                    type: "POST",
                    data: form_data,
                    contentType: false,
                    dataType: "json",   
                    cache: false,
                    processData: false,
                    url: "./csv.php",
                    success: function(data) {
                        // console.log(data)
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
            // console.log(data_arr[0])
            console.log("whaaa")
            $.ajax({
                type: "POST",
                url: "./action.php",
                cache: true,
                // contentType: 'html/text',
                data: {
                    action: type==1?'upload-loans':'post_receipts',
                    loans: data_arr,
                    // receipts: data_arr
                },
                success: function(data) {
                        $("#success").show()
                        setInterval(
                            function(){
                                window.location.href = "./";
                            }
                        ,3000);
                }
            })
        })
     $("body").on("click", ".post_loan", function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        var loan_id = $(this).attr('loan');
        console.log(id+" = "+loan_id)
        repaySpecificLoan(id, loan_id)
    });
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
    function repaySpecificLoan(id, loan_id){
        $.ajax({
            type: "GET",
            url: "./action.php",
            cache: true,
            // contentType: 'html/text',
            data: {
                action: 'repay_id',
                id: id
            },
            success: function(data) {
                let item = data[0]
                console.log(item)
                var settings = {
                  "url": "https://palla.techsavanna.technology:7000/fineract-provider/api/v1/loans/"+loan_id+"/transactions?tenantIdentifier=test&command=repayment",
                  "method": "POST",
                  "timeout": 0,
                  "headers": {
                    "Authorization": "Basic YWRtaW46cGFzc3dvcmQ=",
                    "Content-Type": "application/json"
                  },
                  "data": JSON.stringify({
                    "dateFormat": "dd MMMM yyyy",
                    "locale": "en",
                    "transactionDate": item.day,
                    "transactionAmount": item.amount,
                    "paymentTypeId": "1",
                    "note": "",
                    "receiptNumber": ""+item.rct_no+""
                  }),
                };

                $.ajax(settings).done(function (response) {
                  // console.log(response);
                  $.ajax({
                    type: "POST",
                    url: "./action.php",
                    cache: true,
                    // contentType: 'html/text',
                    data: {
                        action: 'posted-receipt',
                        id: item.id,
                        loan_id: loan_id
                    },
                    success: function(data) {
                        console.log(data)
                        getLoanReceipts(param)
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
                            action: 'posted-receipt',
                            error: er.status == 500 ? "Internal server error" : er.responseJSON.errors[0].developerMessage,
                            id: item.id,
                            loan_id: loan_id
                        },
                        success: function(data) {
                            console.log(data)
                            alert("Failed"+er.status == 500 ? "Internal server error" : er.responseJSON.errors[0].developerMessage)
                            setInterval(
                            function(){
                                getLoanReceipts(param)
                            }
                            ,3000);
                        }
                    })
                });
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