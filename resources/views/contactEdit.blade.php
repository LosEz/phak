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
            <h6 class="m-0 font-weight-bold text-primary">Contact > Edit</h6>
        </div>

        <div class="card-body">
            <h5>ข้อมูลกิจการ</h5>

            <input type="hidden" id="contactId" value="{{ collect(request()->segments())->last() }}" />

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>ประเภทผู้ติดต่อ</span>
                        <select class="form-control" id="contactType">
                            <option value="">-- กรุณาเลือก --</option>
                            <option value="C" @if($contact->ct_contact_type == 'C') selected @endif>ลูกค้า</option>
                            <option value="S" @if($contact->ct_contact_type == 'S') selected @endif>ผู้ขาย</option>
                            <option value="N" @if($contact->ct_contact_type == 'N') selected @endif>ไม่ระบุ</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>รหัสผู้ติดต่อ</span>
                        <label class="form-control" id="contactCode">{{ $contact->ct_contact_code }}</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="radio-group">
                        <lable>เลขทะเบียน 13 หลัก</lable>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="nation" value="T" disabled
                            @if ($contact->ct_nation == 'T')
                            checked
                            @endif
                            >
                            <label class="form-check-label">ไทย</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="nation" value="N" disabled
                            @if ($contact->ct_nation == 'N')
                            checked
                            @endif
                            >
                            <label class="form-check-label"">ต่างประเทศ</label>
                          </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="">
                        <!-- ส่วนที่ 1: 1 หลัก -->
                            <input type="text" class="id-input" id="digit1" maxlength="1" data-next="digit2" value="{{ substr($contact->ct_bus_tax_id, 0, 1) }}" disabled>  
                
                        <span class="dash">-</span>
                        
                        <!-- ส่วนที่ 2: 4 หลัก -->
                            <input type="text" class="id-input" id="digit2" maxlength="1" data-next="digit3" value="{{ substr($contact->ct_bus_tax_id, 1, 1) }}" disabled>
                            <input type="text" class="id-input" id="digit3" maxlength="1" data-next="digit4" value="{{ substr($contact->ct_bus_tax_id, 2, 1) }}" disabled>
                            <input type="text" class="id-input" id="digit4" maxlength="1" data-next="digit5" value="{{ substr($contact->ct_bus_tax_id, 3, 1) }}" disabled>
                            <input type="text" class="id-input" id="digit5" maxlength="1" data-next="digit6" value="{{ substr($contact->ct_bus_tax_id, 4, 1) }}" disabled>
    
                        <span class="dash">-</span>
                        
                        <!-- ส่วนที่ 3: 5 หลัก -->
                            <input type="text" class="id-input" id="digit6" maxlength="1" data-next="digit7" value="{{ substr($contact->ct_bus_tax_id, 5, 1) }}" disabled>
                            <input type="text" class="id-input" id="digit7" maxlength="1" data-next="digit8" value="{{ substr($contact->ct_bus_tax_id, 6, 1) }}" disabled>
                            <input type="text" class="id-input" id="digit8" maxlength="1" data-next="digit9" value="{{ substr($contact->ct_bus_tax_id, 7, 1) }}" disabled>
                            <input type="text" class="id-input" id="digit9" maxlength="1" data-next="digit10" value="{{ substr($contact->ct_bus_tax_id, 8, 1) }}" disabled>
                            <input type="text" class="id-input" id="digit10" maxlength="1" data-next="digit11" value="{{ substr($contact->ct_bus_tax_id, 9, 1) }}" disabled>
        
                        <span class="dash">-</span>
                        
                        <!-- ส่วนที่ 4: 3 หลัก -->
                            <input type="text" class="id-input" id="digit11" maxlength="1" data-next="digit12" value="{{ substr($contact->ct_bus_tax_id, 10, 1) }}" disabled>
                            <input type="text" class="id-input" id="digit12" maxlength="1" data-next="digit13" value="{{ substr($contact->ct_bus_tax_id, 11, 1) }}" disabled>
                            <input type="text" class="id-input" id="digit13" maxlength="1" value="{{ substr($contact->ct_bus_tax_id, 12, 1) }}" disabled>
                     
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-sm-12">
                    <div class="radio-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="busType" value="H" id="busTypeH"
                            @if ($contact->ct_bus_type == 'H')
                            checked
                            @endif
                            >
                            <label class="form-check-label">สำนักงานใหญ่</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="busType" value="B" id="busTypeB"
                            @if ($contact->ct_bus_type == 'B')
                            checked
                            @endif
                            >
                            <label class="form-check-label"">สาขา</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="busType" value="N" id="busTypeN"
                            @if ($contact->ct_bus_type == 'N')
                            checked
                            @endif
                            >
                            <label class="form-check-label"">ไม่ระบุ</label>
                        </div>
                        <div>
                            {{-- <button class="btn btn-sm btn-info" >ค้นหา</button> --}}
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div id="panelBranch" @if ($contact->ct_bus_type == 'N')
            style="display: block;"
            @else
            style="display: none;"
            @endif class="panel" >
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <span>สาขา</span>
                            <input class="form-control" id="busBranch" value="{{ $contact->ct_bus_branch }}"/>
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
                            <input class="form-check-input" type="radio" name="busCateType" value="N" id="optionA"
                            @if ($contact->ct_bus_cate_type == 'N')
                            checked
                            @endif
                            >
                            <label class="form-check-label">นิติบุคคล</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="busCateType" value="B" id="optionB"
                            @if ($contact->ct_bus_cate_type == 'B')
                            checked
                            @endif
                            >
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
                                <option value="0" @if ($contact->ct_business_type == '') selected @endif>-- กรุณาเลือก --</option>
                                <option value="1" @if ($contact->ct_business_type == '1') selected @endif>บริษัทจำกัด</option>
                                <option value="2" @if ($contact->ct_business_type == '2') selected @endif>บริษัทมหาชนจำกัด</option>
                                <option value="3" @if ($contact->ct_business_type == '3') selected @endif>ห้างหุ้นส่วนจำกัด</option>
                                <option value="4" @if ($contact->ct_business_type == '4') selected @endif>มูลนิธิ</option>
                                <option value="5" @if ($contact->ct_business_type == '5') selected @endif>สมาคม</option>
                                <option value="6" @if ($contact->ct_business_type == '6') selected @endif>กิจการร่วมค้า</option>
                                <option value="7" @if ($contact->ct_business_type == '7') selected @endif>อื่น ๆ</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="textA1">ชื่อกิจการ</label>
                            <input type="text" id="busName" class="form-control" value="{{ $contact->ct_bus_name }}"/>
                        </div>
                    </div>
                </div>
            </div>

            <div id="panelB" class="panel">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="individualType">บุคคลธรรมดา</label>
                            <select id="individualType" class="form-control">
                                <option value="0" @if ($contact->ct_individual_type == '') selected @endif>-- กรุณาเลือก --</option>
                                <option value="1" @if ($contact->ct_individual_type == '1') selected @endif>บุคคลธรรมดา</option>
                                <option value="2" @if ($contact->ct_individual_type == '2') selected @endif>ห้างหุ้นส่วนสามัญ</option>
                                <option value="3" @if ($contact->ct_individual_type == '3') selected @endif>ร้านค้า</option>
                                <option value="4" @if ($contact->ct_individual_type == '4') selected @endif>คณะบุคคล</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="textB1">คำนำหน้า</label>
                            <input type="text" id="titleName" class="form-control" value="{{ $contact->ct_title_name }}"/>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="textB1">ชื่อจริง</label>
                            <input type="text" id="firstName" class="form-control" value="{{ $contact->ct_first_name }}"/>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="textB1">นามสกุล</label>
                            <input type="text" id="lastName" class="form-control" value="{{ $contact->ct_last_name }}"/>
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
                        <input class="form-control" id="contactName" value="{{ $contact->ct_addr_contact_name }}"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <span>ที่อยู่</span>
                        <input class="form-control" id="contactAddress" value="{{ $contact->ct_addr_address }}"/>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>แขวง/ตำบล</span>
                        <input class="form-control" id="contactSubDistrict" value="{{ $contact->ct_addr_sub_district}}" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>เขตอำเภอ</span>
                        <input class="form-control" id="contactDistrict" value="{{ $contact->ct_addr_district}}"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>จังหวัด</span>
                        <input class="form-control" id="contactProvince" value="{{ $contact->ct_addr_province}}"/>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>รหัสไปรษณีย์</span>
                        <input class="form-control" id="contactPost" value="{{ $contact->ct_addr_postcode}}"/>
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
                        <input class="form-control" id="contactBank" value="{{ $contact->ct_bank_name}}"/>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>ชื่อบัญชี</span>
                        <input class="form-control" id="contactBankName" value="{{ $contact->ct_bank_account_name}}"/>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>เลขบัญชี</span>
                        <input class="form-control" id="contactBankNumber" value="{{ $contact->ct_bank_account_number}}"/>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>สาขา</span>
                        <input class="form-control" id="contactBankBranch" value="{{ $contact->ct_bank_branch}}"/>
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
                        <input class="form-control" id="contactEmail" value="{{ $contact->ct_contact_email}}"/>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>เบอร์โทร</span>
                        <input class="form-control" id="contactPhone" value="{{ $contact->ct_contact_phone}}"/>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>เว็บไซต์</span>
                        <input class="form-control" id="contactWeb" value="{{ $contact->ct_contact_website}}"/>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>เบอร์แฟกซ์</span>
                        <input class="form-control" id="contactFax" value="{{ $contact->ct_contact_fax}}"/>
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
        let contactId = $('#contactId').val();
        let contactType = $('#contactType').val();
        let busType = $("input[type='radio'][name='busType']:checked").val();
        let busCateType = $("input[type='radio'][name='busCateType']:checked").val();
        let businessType = $('#businessType').val();
        let busBranch = $('#busBranch').val();
        let busName = $('#busName').val();
        let titleName = $('#titleName').val();
        let firstName = $('#firstName').val();
        let lastName = $('#lastName').val();
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
            firstName = "";
            lastName = "";
            individualType = "0";
        } else {
            businessType = "0";
            busName = "";
        }

        $.ajax({
            type: "POST",
            url: '{{URL::to("contacts/addEdit")}}',
            data: {
                contactId: contactId,
                contactType: contactType,
                busType: busType,
                busCateType: busCateType,
                busBranch: busBranch,
                businessType: businessType,
                busName: busName,
                individualType: individualType,
                titleName: titleName,
                firstName: firstName,
                lastName: lastName,
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
                type: "edit",
                _token: '{!! csrf_token() !!}'
            },
            success: function(result) {
                window.location.href = "{{ url('contacts') }}";
            },
            error: function(result) {
                console.log(result.responseText);
                loadingHide();
            }
        });
    }


    
</script>

@endsection