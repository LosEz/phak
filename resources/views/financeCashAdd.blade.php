@extends('layouts.master')

@section('content')

<style>
    .id-input-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px 0;
        }
        .id-input {
            width: 30px;
            height: 40px;
            text-align: center;
            font-size: 18px;
            margin: 0 2px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .dash {
            font-size: 20px;
            margin: 0 5px;
            color: #666;
        }
        .description {
            margin-top: 20px;
            color: #666;
        }
        .input-group {
            display: flex;
            margin: 0 5px;
        }
        .radio-group {
            display: flex;
            gap: 50px;
        }
        .panel {
            display: none;
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

</style>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Cash/Bank/e-Wallet > Add</h6>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-sm-12">
                    <div class="radio-group">
                        <label>ประเภทช่องทางการเงิน</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cateType" value="C"  id="optionA">
                            <label class="form-check-label">เงินสด</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cateType" value="B" checked id="optionB">
                            <label class="form-check-label"">ธนาคาร</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cateType" value="E" id="optionC">
                            <label class="form-check-label"">e-Wallet</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cateType" value="X" id="optionD">
                            <label class="form-check-label"">สำรองรับ/จ่าย</label>
                        </div>
                    </div>
                </div>
            </div>

            <div id="panelA" class="panel">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="cashName">ชื่อช่องทางเงินสด</label>
                            <input id="cashName" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="cashDesc">คำอธิบายช่องทางการเงิน</label>
                            <textarea id="cashDesc" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                    <input type="checkbox" id="cashAccPayTo" checked/> ใช้รับเงิน
                    </div>
                    <div class="col-sm-2">
                    <input type="checkbox" id="cashAccPayFrom" checked/> ใช้จ่ายเงิน
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-sm-4">
        
                    </div>
                    <div class="col-sm-4">
                        <button type="button" class="form-control btn btn-primary" onclick="saveCash()">Save</button>
                    </div>
                    <div class="col-sm-4">
        
                    </div>
                </div>

            </div>

            <div id="panelB" class="panel">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="bankId">ธนาคาร</label>
                            <select id="bankId" class="form-control">
                                @foreach ($banks as $b)
                                    <option value="{{$b->id}}">{{ $b->bank_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="bankType">ประเภทบัญชี</label>
                            <select id="bankType" class="form-control">
                                @foreach ($bankTypes as $bt)
                                    <option value="{{$bt->id}}">{{ $bt->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="bankAccName">ชื่อบัญชีธนาคาร</label>
                            <input type="text" id="bankAccName" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="bankAccNumber">เลขบัญชีธนาคาร</label>
                            <input type="text" id="bankAccNumber" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="bankAccBranchName">ชื่อสาขา</label>
                            <input type="text" id="bankAccBranchName" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="bankAccBranchNumber">เลขที่สาขา</label>
                            <input type="text" id="bankAccBranchNumber" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="bankDesc">คำอธิบายช่องทางการเงิน</label>
                            <textarea id="bankDesc" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                    <input type="checkbox" id="bankAccPayTo" checked/> ใช้รับเงิน
                    </div>
                    <div class="col-sm-2">
                    <input type="checkbox" id="bankAccPayFrom" checked/> ใช้จ่ายเงิน
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-sm-4">
        
                    </div>
                    <div class="col-sm-4">
                        <button type="button" class="form-control btn btn-primary" onclick="saveBank()">Save</button>
                    </div>
                    <div class="col-sm-4">
        
                    </div>
                </div>
            </div>

            <div id="panelC" class="panel">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="gatewayType">รูปแบบผู้ให้บริการ</label>
                            <select id="gatewayType" class="form-control">
                                <option value="1">ผู้ให้บริการชำระเงิน</option>
                                <option value="2">e-Commerce</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="providerId">ผู้ให้บริการ</label>
                            <select id="providerId" class="form-control">
                               @foreach ($provider as $pro)
                                <option value="{{ $pro->id }}">{{ $pro->provider_name }}</option>
                               @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="ewAccName">ชื่อบัญชีที่ใช้บริการ</label>
                            <input type="text" id="ewAccName" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="ewAccNumber">เลขบัญชีที่ใช้บริการ</label>
                            <input type="text" id="ewAccNumber" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="ewAcc">ชื่อบัญชีที่บันทึก</label>
                            <select id="ewAcc" class="form-control">
                                @foreach ($accounts as $acc)
                                    <option value="{{$acc->acc_code}}">{{ $acc->acc_code }} - {{ $acc->acc_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="ewDesc">คำอธิบายช่องทางการเงิน</label>
                            <textarea id="ewDesc" class="form-control"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2">
                    <input type="checkbox" id="ewAccPayTo" checked/> ใช้รับเงิน
                    </div>
                    <div class="col-sm-2">
                    <input type="checkbox" id="ewAccPayFrom" checked/> ใช้จ่ายเงิน
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-sm-4">
        
                    </div>
                    <div class="col-sm-4">
                        <button type="button" class="form-control btn btn-primary" onclick="saveEwallet()">Save</button>
                    </div>
                    <div class="col-sm-4">
        
                    </div>
                </div>
            </div>

            <div id="panelD" class="panel">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exName">ชื่อผู้สำรองจ่าย</label>
                                <input id="exName" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exDesc">คำอธิบายช่องทางการเงิน</label>
                                <textarea id="exDesc" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                        <input type="checkbox" id="exAccPayTo" checked/> ใช้รับเงิน
                        </div>
                        <div class="col-sm-2">
                        <input type="checkbox" id="exAccPayFrom" checked/> ใช้จ่ายเงิน
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-4">
            
                        </div>
                        <div class="col-sm-4">
                            <button type="button" class="form-control btn btn-primary" onclick="saveExpenseClaim()">Save</button>
                        </div>
                        <div class="col-sm-4">
            
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get references to the radio buttons and panels
        const optionA = document.getElementById('optionA');
        const optionB = document.getElementById('optionB');
        const optionC = document.getElementById('optionC');
        const optionD = document.getElementById('optionD');
        const panelA = document.getElementById('panelA');
        const panelB = document.getElementById('panelB');
        const panelC = document.getElementById('panelC');
        const panelD = document.getElementById('panelD');
        
        // Function to toggle panels based on selected radio button
        function togglePanels() {
            if (optionA.checked) {
                panelA.style.display = 'block';
                panelB.style.display = 'none';
                panelC.style.display = 'none';
                panelD.style.display = 'none';
            } else if (optionB.checked) {
                panelA.style.display = 'none';
                panelB.style.display = 'block';
                panelC.style.display = 'none';
                panelD.style.display = 'none';
            } else if (optionC.checked) {
                panelA.style.display = 'none';
                panelB.style.display = 'none';
                panelC.style.display = 'block';
                panelD.style.display = 'none';
            } else {
                panelA.style.display = 'none';
                panelB.style.display = 'none';
                panelC.style.display = 'none';
                panelD.style.display = 'block';
            }
        }
        // Function to toggle panels based on busType radio button
        
        // Add event listeners to radio buttons
        optionA.addEventListener('change', togglePanels);
        optionB.addEventListener('change', togglePanels);
        optionC.addEventListener('change', togglePanels);
        optionD.addEventListener('change', togglePanels);
        // Initialize the display
        togglePanels();
    });
</script>

<script>
    function saveCash() {
        loadingShow();
        let cashName = $('#cashName').val();
        let cashDesc = $('#cashDesc').val();

        if(cashName == "") {
            alertError("กรุณากรอกชื่อช่องทางเงินสด");
            $('#cashName').focus();
            loadingHide();
            return;
        }

        let cashAccPayTo = document.getElementById("cashAccPayTo").checked;
        let cashAccPayFrom = document.getElementById("cashAccPayFrom").checked;

        $.ajax({
            type: "POST",
            url: '{{URL::to("cashs/cashsave")}}',
            data: {
                cashName: cashName,
                cashDesc: cashDesc,
                cashAccPayTo: cashAccPayTo,
                cashAccPayFrom: cashAccPayFrom,
                type: "add",
                _token: '{!! csrf_token() !!}'
            },
            success: function(result) {
                window.location.href = "{{ url('cashs') }}";
                loadingHide();

            },
            error: function(result) {
                console.log(result)
                loadingHide();
            }
        });
    }

    function saveBank() {

        loadingShow();
        let bankId = $('#bankId').val();
        let bankType = $('#bankType').val();
        let bankAccName = $('#bankAccName').val();
        let bankAccNumber = $('#bankAccNumber').val();
        let bankAccBranchName = $('#bankAccBranchName').val();
        let bankAccBranchNumber = $('#bankAccBranchNumber').val();
        let bankDesc = $('#bankDesc').val();
        let bankAccPayTo = document.getElementById("bankAccPayTo").checked;
        let bankAccPayFrom = document.getElementById("bankAccPayFrom").checked;

        if(bankAccName == "") {
            alertError("กรุณากรอกชื่อบัญชีธนาคาร");
            $('#bankAccName').focus();
            loadingHide();
            return;
        }
        if(bankAccNumber == "") {
            alertError("กรุณากรอกเลขบัญชีธนาคาร");
            $('#bankAccNumber').focus();
            loadingHide();
            return;
        }

        $.ajax({
            type: "POST",
            url: '{{URL::to("cashs/banksave")}}',
            data: {
                bankId: bankId,
                bankType: bankType,
                bankAccName: bankAccName,
                bankAccNumber: bankAccNumber,
                bankAccBranchName: bankAccBranchName,
                bankAccBranchNumber: bankAccBranchNumber,
                bankDesc: bankDesc,
                bankAccPayTo: bankAccPayTo,
                bankAccPayFrom: bankAccPayFrom,
                type: "add",
                _token: '{!! csrf_token() !!}'
            },
            success: function(result) {
                window.location.href = "{{ url('cashs') }}";
                loadingHide();

            },
            error: function(result) {
                console.log(result)
                loadingHide();
            }
        });
    }

    function saveEwallet() {
        loadingShow();
        let gatewayType = $('#gatewayType').val();
        let providerId = $('#providerId').val();
        let ewAccName = $('#ewAccName').val();
        let ewAccNumber = $('#ewAccNumber').val();
        let ewAcc = $('#ewAcc').val();
        let ewDesc = $('#ewDesc').val();
        let ewAccPayTo = document.getElementById("ewAccPayTo").checked;
        let ewAccPayFrom = document.getElementById("ewAccPayFrom").checked;

        if(ewAccName == "") {
            alertError("กรุณากรอกชื่อบัญชีที่ใช้บริการ");
            $('#ewAccName').focus();
            loadingHide();
            return;
        }

        $.ajax({
            type: "POST",
            url: '{{URL::to("cashs/ewalletsave")}}',
            data: {
                gatewayType: gatewayType,
                providerId: providerId,
                ewAccName: ewAccName,
                ewAccNumber: ewAccNumber,
                ewAcc: ewAcc,
                ewDesc: ewDesc,
                ewAccPayTo: ewAccPayTo,
                ewAccPayFrom: ewAccPayFrom,
                type: "add",
                _token: '{!! csrf_token() !!}'
            },
            success: function(result) {
                window.location.href = "{{ url('cashs') }}";
                loadingHide();

            },
            error: function(result) {
                console.log(result)
                loadingHide();
            }
        });
    }

    function saveExpenseClaim() {
        loadingShow();
        let exName = $('#exName').val();
        let exDesc = $('#exDesc').val();
        let exAccPayTo = document.getElementById("exAccPayTo").checked;
        let exAccPayFrom = document.getElementById("exAccPayFrom").checked;

        if(exName == "") {
            alertError("กรุณากรอกชื่อผู้ที่สำรองจ่าย");
            $('#exName').focus();
            loadingHide();
            return;
        }

        $.ajax({
            type: "POST",
            url: '{{URL::to("cashs/expenseclaimsave")}}',
            data: {
                exName: exName,
                exDesc: exDesc,
                exAccPayTo: exAccPayTo,
                exAccPayFrom: exAccPayFrom,
                type: "add",
                _token: '{!! csrf_token() !!}'
            },
            success: function(result) {
                window.location.href = "{{ url('cashs') }}";
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