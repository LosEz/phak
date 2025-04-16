@extends('layouts.master')

@section('content')

<style>
    .container-header-test {
            display: flex;
            justify-content: space-between; /* ชิดซ้าย-ขวา */
            align-items: center; /* จัดกลางแนวตั้ง */
            width: 100%;
            padding: 10px;
        }

    .left-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        h5, label {
            margin: 0;
        }
        
        button {
            padding: 5px 10px;
            cursor: pointer;
        }
</style>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Cash / Bank / e-Wallet</h6>
        </div>

        <br/>

        <div class="container-header-test">
            <div class="left-group" style="padding-left: 10px; padding-right: 10px;">
                <h5 id="accCount">ช่องทางการเงินทั้งหมด 0 บัญชี</h5>
                <button class="btn btn-primary" onclick="window.location.href='{{ url('cashs') }}/add'"> + เพิ่มช่องทางการเงิน</button>
            </div>
            <label style="text-align: right">ข้อความชิดขวา</label>
        </div>
        <hr/>

        <div id="cashdetail">

        </div>

        {{-- <div style="padding-left: 10px; padding-right: 10px;">
            <div class="row">
                <label class="col-form-label" style="font-size: 22px; font-weight: bold; padding-left: 20px">เงินฝากธนาคาร 10 บัญชี</label>
                <p class="col-form-label" style="padding-top: 12px; padding-left: 20px">รวม 600,000 บาท</p>
            </div>
        </div>
        <br/>
        <div style="padding-left: 10px; padding-right: 10px;">
            <div class="row"> 
                @for ($i = 0; $i < 10; $i++)
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Earnings (Monthly)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div> --}}
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        searchContacts();
    });

    function searchContacts() {
         loadingShow();
         $.ajax({
             type: "GET",
             url: '{{URL::to("cashs/list")}}',
             data: {
                 _token: '{!! csrf_token() !!}'
             },
             success: function(result) {
                 if (result['data'].length > 0) {
                     let data = result['data'];
                    let subData = "";
                    let headData = "";

                    let detail = "";
                    let accountCount = 0;

                    for(let i = 0; i < data.length; i++) {
                        subData = "";
                        headData = "";

                        let head = data[i]['head'];
                        let sub = data[i]['sub'];

                        headData += `<div style="padding-left: 10px; padding-right: 10px;">
                                <div class="row">
                                    <label class="col-form-label" style="font-size: 22px; font-weight: bold; padding-left: 20px">${head}</label>
                                    <p class="col-form-label" style="padding-top: 12px; padding-left: 20px">รวม 600,000 บาท</p>
                                </div>
                            </div>
                            <br/>
                            <div style="padding-left: 10px; padding-right: 10px;">
                                <div class="row">`;

                        for(let j = 0; j < sub.length; j++) {

                            let details = sub[j];

                            subData += `<div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                             <div class="text-xl font-weight-bold text-primary text-uppercase mb-1" style="font-size:20px">
                                                <img src="{{ url('') }}/${details['bankIcon']}" alt="" width="15%">
                                             ${details['headname']}</div>
                                             <div class="h5 mb-0 font-weight-bold text-gray-800">${details['subname']}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="text-s mb-0 font-weight-bold text-gray-800" style="padding-left: 20px;">${details['code']}</div>
                                </div>
                            </div>`;

                            accountCount++;
                        }

                    
                        if(sub.length > 0) {
                            detail += headData + subData + `</div></div><br/><hr/>`; 
                        }
                    }


                    $('#cashdetail').append(detail);
                    $('#accCount').text("ช่องทางการเงินทั้งหมด "+ accountCount + " บัญชี");
                }
                loadingHide();

            },
            error: function(result) {
                console.log(result)
                loadingHide();
            }
        });
    }
</script>

@endsection