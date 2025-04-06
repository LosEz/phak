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
            <h6 class="m-0 font-weight-bold text-primary">Contact > Add</h6>
        </div>

        <div class="card-body">
            <h5>ข้อมูลกิจการ</h5>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>ประเภทผู้ติดต่อ</span>
                        <select class="form-control" id="contactType">
                            <option value="">-- กรุณาเลือก --</option>
                            <option value="C">ลูกค้า</option>
                            <option value="S">ผู้ขาย</option>
                            <option value="N">ไม่ระบุ</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>รหัสผู้ติดต่อ</span>
                        <input class="form-control" id="contactCode" value="{{ $nextCode }}"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="radio-group">
                        <lable>เลขทะเบียน 13 หลัก</lable>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="nation" value="T" checked>
                            <label class="form-check-label">ไทย</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="nation" value="N">
                            <label class="form-check-label"">ต่างประเทศ</label>
                          </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="">
                        <!-- ส่วนที่ 1: 1 หลัก -->
                            <input type="text" class="id-input" id="digit1" maxlength="1" data-next="digit2">
                
                        <span class="dash">-</span>
                        
                        <!-- ส่วนที่ 2: 4 หลัก -->
                            <input type="text" class="id-input" id="digit2" maxlength="1" data-next="digit3">
                            <input type="text" class="id-input" id="digit3" maxlength="1" data-next="digit4">
                            <input type="text" class="id-input" id="digit4" maxlength="1" data-next="digit5">
                            <input type="text" class="id-input" id="digit5" maxlength="1" data-next="digit6">
    
                        <span class="dash">-</span>
                        
                        <!-- ส่วนที่ 3: 5 หลัก -->
                            <input type="text" class="id-input" id="digit6" maxlength="1" data-next="digit7">
                            <input type="text" class="id-input" id="digit7" maxlength="1" data-next="digit8">
                            <input type="text" class="id-input" id="digit8" maxlength="1" data-next="digit9">
                            <input type="text" class="id-input" id="digit9" maxlength="1" data-next="digit10">
                            <input type="text" class="id-input" id="digit10" maxlength="1" data-next="digit11">
        
                        <span class="dash">-</span>
                        
                        <!-- ส่วนที่ 4: 3 หลัก -->
                            <input type="text" class="id-input" id="digit11" maxlength="1" data-next="digit12">
                            <input type="text" class="id-input" id="digit12" maxlength="1" data-next="digit13">
                            <input type="text" class="id-input" id="digit13" maxlength="1">
                     
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-sm-12">
                    <div class="radio-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="busType" value="H" checked id="busTypeH">
                            <label class="form-check-label">สำนักงานใหญ่</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="busType" value="B" id="busTypeB">
                            <label class="form-check-label"">สาขา</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="busType" value="N" id="busTypeN">
                            <label class="form-check-label"">ไม่ระบุ</label>
                        </div>
                        <div>
                            {{-- <button class="btn btn-sm btn-info" >ค้นหา</button> --}}
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div id="panelBranch" class="panel">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <span>สาขา</span>
                            <input class="form-control" id="busBranch"/>
                        </div>
                    </div>
                </div>
            </div>
            <br/>

            <div class="row">
                <div class="col-sm-12">
                    <div class="radio-group">
                        <label>ชื่อกิจการ</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="busCateType" value="N" checked id="optionA">
                            <label class="form-check-label">นิติบุคคล</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="busCateType" value="B" id="optionB">
                            <label class="form-check-label"">บุคคลธรรมดา</label>
                        </div>
                    </div>
                </div>
            </div>

            <div id="panelA" class="panel">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="businessType">นิติบุคคล</label>
                            <select id="businessType" class="form-control">
                                <option value="0">-- กรุณาเลือก --</option>
                                <option value="1">บริษัทจำกัด</option>
                                <option value="2">บริษัทมหาชนจำกัด</option>
                                <option value="3">ห้างหุ้นส่วนจำกัด</option>
                                <option value="4">มูลนิธิ</option>
                                <option value="5">สมาคม</option>
                                <option value="6">กิจการร่วมค้า</option>
                                <option value="7">อื่น ๆ</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="textA1">ชื่อกิจการ</label>
                            <input type="text" id="busName" class="form-control" />
                        </div>
                    </div>
                </div>
            </div>

            <div id="panelB" class="panel">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for=" individualType">บุคคลธรรมดา</label>
                            <select id=" individualType" class="form-control">
                                <option value="1">บุคคลธรรมดา</option>
                                <option value="2">ห้างหุ้นส่วนสามัญ</option>
                                <option value="3">ร้านค้า</option>
                                <option value="4">คณะบุคคล</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="textB1">คำนำหน้า</label>
                            <input type="text" id="titleName" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="textB1">ชื่อจริง</label>
                            <input type="text" id="firstname" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="textB1">นามสกุล</label>
                            <input type="text" id="lastname" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <hr/>
            <h5>ที่อยุ่จดทะเบียน</h5>
            <br/>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <span>ผู้ติดต่อ</span>
                        <input class="form-control" id="contactName"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <span>ที่อยู่</span>
                        <input class="form-control" id="contactAddress" />
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>แขวง/ตำบล</span>
                        <input class="form-control" id="contactSubDistrict"/>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>เขตอำเภอ</span>
                        <input class="form-control" id="contactDistrict"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>จังหวัด</span>
                        <input class="form-control" id="contactProvince" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>รหัสไปรษณีย์</span>
                        <input class="form-control" id="contactPost" />
                    </div>
                </div>
            </div>
            <hr/>
            <h5>ธนาคาร</h5>
            <br />
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>ธนาคาร</span>
                        <input class="form-control" id="contactBank"/>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>ชื่อบัญชี</span>
                        <input class="form-control" id="contactBankName"/>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>เลขบัญชี</span>
                        <input class="form-control" id="contactBankNumber"/>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>สาขา</span>
                        <input class="form-control" id="contactBankBranch"/>
                    </div>
                </div>
            </div>
            <br />
            <h5>ช่องทางติดต่อ</h5>
            <br />
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>อีเมล</span>
                        <input class="form-control" id="contactEmail"/>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>เบอร์โทร</span>
                        <input class="form-control" id="contactPhone"/>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>เว็บไซต์</span>
                        <input class="form-control" id="contactWeb"/>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>เบอร์แฟกซ์</span>
                        <input class="form-control" id="contactFax"/>
                    </div>
                </div>
            </div>
            
            <br />

            <div class="row">
                <div class="col-sm-2">

                </div>
                <div class="col-sm-4">
                    <button type="button" class="form-control btn btn-primary" onclick="saveData()">Save</button>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="form-control btn btn-danger" onclick="window.location.href='{{ url('contacts') }}'">Cancel</button>
                </div>
                <div class="col-sm-2">

                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // สร้าง array ของ input ทั้งหมด
        const inputs = [];
        for (let i = 1; i <= 13; i++) {
            inputs.push(document.getElementById(`digit${i}`));
        }
        
        // ฟังก์ชันสำหรับย้ายไปยัง input ถัดไป
        function moveToNext(current, nextFieldId) {
            if (current.value.length === current.maxLength) {
                document.getElementById(nextFieldId).focus();
            }
        }
        
        // ฟังก์ชันสำหรับตรวจสอบว่ามีแต่ตัวเลขเท่านั้น
        function validateNumber(input) {
            input.value = input.value.replace(/[^0-9]/g, '');
        }
        
        // เพิ่ม event listeners สำหรับแต่ละ input
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                validateNumber(input);
                if (input.dataset.next) {
                    moveToNext(input, input.dataset.next);
                }
            });
            
            // อนุญาตให้ใช้ปุ่ม Backspace เพื่อย้อนกลับได้
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && input.value.length === 0) {
                    const currentIndex = parseInt(input.id.replace('digit', ''));
                    if (currentIndex > 1) {
                        const prevInput = document.getElementById(`digit${currentIndex - 1}`);
                        prevInput.focus();
                    }
                }
            });
        });
        
        // เริ่มต้นโฟกัสที่ input แรก
        inputs[0].focus();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get references to the radio buttons and panels
        const optionA = document.getElementById('optionA');
        const optionB = document.getElementById('optionB');
        const panelA = document.getElementById('panelA');
        const panelB = document.getElementById('panelB');

        const busTypeH = document.getElementById('busTypeH');
        const busTypeB = document.getElementById('busTypeB');
        const busTypeN = document.getElementById('busTypeN');
        const panelBranch = document.getElementById('panelBranch');
        
        // Function to toggle panels based on selected radio button
        function togglePanels() {
            if (optionA.checked) {
                panelA.style.display = 'block';
                panelB.style.display = 'none';
            } else {
                panelA.style.display = 'none';
                panelB.style.display = 'block';
            }
        }

        // Function to toggle branch panel based on busTypeB radio button
        if (busTypeB.checked) {
            panelBranch.style.display = 'block';
        } else {
            panelBranch.style.display = 'none';
        }
        busTypeB.addEventListener('change', function() {
            if (busTypeB.checked) {
                panelBranch.style.display = 'block';
            } else {
                panelBranch.style.display = 'none';
            }
        });
        busTypeH.addEventListener('change', function() {
            if (busTypeH.checked) {
                panelBranch.style.display = 'none';
            }
        });
        busTypeN.addEventListener('change', function() {
            if (busTypeN.checked) {
                panelBranch.style.display = 'none';
            }
        });
        // Function to toggle panels based on busType radio button
        
        // Add event listeners to radio buttons
        optionA.addEventListener('change', togglePanels);
        optionB.addEventListener('change', togglePanels);
        
        // Initialize the display
        togglePanels();
    });
</script>

<script>
    function saveData() {
        loadingShow();
        let contactType = $('#contactType').val();
        let contactCode = $('#contactCode').val();
        let nation = $("input[type='radio'][name='nation']:checked").val();

        let taxId = '';
        for (let i = 1; i <= 13; i++) {
            taxId += document.getElementById(`digit${i}`).value;
        }

        if(taxId.length < 13) {
            alertError("กรุณากรอกเลขประจำตัวผู้เสียภาษีให้ครบ 13 หลัก");
            loadingHide();
            return;
        }
        if(contactType === '') {
            alertError("กรุณาเลือกประเภทผู้ติดต่อ");
            loadingHide();
            return;
        }
        if(contactCode === '') {
            alertError("กรุณากรอกรหัสผู้ติดต่อ");
            loadingHide();
            return;
        }

        let busType = $("input[type='radio'][name='busType']:checked").val();
        let busCateType = $("input[type='radio'][name='busCateType']:checked").val();
        let businessType = $('#businessType').val();
        let busBranch = $('#busBranch').val();
        let busName = $('#busName').val();
        let titleName = $('#titleName').val();
        let firstname = $('#firstname').val();
        let lastname = $('#lastname').val();
        let individualType = $('#individualType').val();
        let contactName = $('#contactName').val();
        let contactAddress = $('#contactAddress').val();
        let contactSubDistrict = $('#contactSubDistrict').val();
        let contactDistrict = $('#contactDistrict').val();
        let contactProvince = $('#contactProvince').val();
        let contactPost = $('#contactPost').val();
        let contactEmail = $('#contactEmail').val();
        let contactPhone = $('#contactPhone').val();
        let contactWeb = $('#contactWeb').val();
        let contactFax = $('#contactFax').val();
        let contactBank = $('#contactBank').val();
        let contactBankName = $('#contactBankName').val();
        let contactBankNumber = $('#contactBankNumber').val();
        let contactBankBranch = $('#contactBankBranch').val();

        if(busType == 'H') {
            busBranch = "";
        }

        if(busCateType == 'N') {
            titleName = "";
            firstname = "";
            lastname = "";
            individualType = "0";
        } else {
            businessType = "0";
            busName = "";
        }

        $.ajax({
            type: "POST",
            url: '{{URL::to("contacts/addEdit")}}',
            data: {
                contactType: contactType,
                contactCode: contactCode,
                nation: nation,
                taxId: taxId,
                busType: busType,
                busCateType: busCateType,
                businessType: busCateType,
                busBranch: busBranch,
                busName: busName,
                titleName: titleName,
                firstName: firstname,
                lastName: lastname,
                individualType: individualType,
                contactName: contactName,
                contactAddress: contactAddress,
                contactSubDistrict: contactSubDistrict,
                contactDistrict: contactDistrict,
                contactProvince: contactProvince,
                contactPost: contactPost,
                contactEmail: contactEmail,
                contactPhone: contactPhone,
                contactWeb: contactWeb,
                contactFax: contactFax,
                contactBank: contactBank,
                contactBankName: contactBankName,
                contactBankNumber: contactBankNumber,
                contactBankBranch: contactBankBranch,
                type: "add",
                _token: '{!! csrf_token() !!}'
            },
            success: function(result) {
                window.location.href = "{{ url('contacts') }}";
            },
            error: function(result) {
                alertError(result.responseJSON.message);
                loadingHide();
            }
        });
    }


    
</script>

@endsection