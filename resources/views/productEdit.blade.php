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
                <h6 class="m-0 font-weight-bold text-primary">Product > Edit</h6>
            </div>

            <div class="card-body">
                <h5>เพิ่มสินค้าใหม่</h5>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="radio-group">
                            <label>ประเภท</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pgId" value="1" disabled
                                    @if ($product->pg_id == 1)
                                    checked
                                    @endif
                                    id="optionA">
                                <label class="form-check-label">สินค้า</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pgId" value="2" disabled
                                    @if ($product->pg_id == 2)
                                    checked
                                    @endif
                                    id="optionB">
                                <label class="form-check-label"">บริการ</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="panelA" class="panel">
                    <h5>ข้อมูลสินค้า</h5>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>รหัสสินค้า</span>
                                <input class="form-control" id="productCode"    @if ($product->pg_id == 1) value="{{$product->p_code}}" @endif disabled/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>ชื่อสินค้า</span>
                                <input class="form-control" id="productName" @if ($product->pg_id == 1) value="{{ $product->p_name }}" @endif disabled/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>หน่วย</span>
                                <select class="form-control" id="productUnitId">
                                    <option value="">-- กรุณาเลือก --</option>
                                    @foreach ($unit as $u)
                                        @if($u->unit_id == $product->unit_id)
                                            <option value="{{ $u->unit_id }}" @if ($product->pg_id == 1) selected @endif>{{ $u->unit_type }}</option>
                                        @else
                                            <option value="{{ $u->unit_id }}">{{ $u->unit_type }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <span>คำบรรยายสินค้า</span>
                                <textarea class="form-control" id="productDesc" rows="3">@if ($product->pg_id == 1) {{ $product->p_desc }} @endif</textarea>
                            </div>
                        </div>
                    </div>
                    <br />
                </div>

                <div id="panelB" class="panel">
                    <h5>ข้อมูลบริการ</h5>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>รหัสบริการ</span>
                                <input class="form-control" id="serviceCode" @if ($product->pg_id == 2) value="{{$product->p_code}}" @endif disabled/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>ชื่อบริการ</span>
                                <input class="form-control" id="serviceName" @if ($product->pg_id == 2) value="{{$product->p_name}}" @endif disabled/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>หน่วย</span>
                                <select class="form-control" id="serviceUnitId">
                                    <option value="">-- กรุณาเลือก --</option>
                                    @foreach ($unit as $u)
                                        @if($u->unit_id == $product->unit_id)
                                            <option value="{{ $u->unit_id }}" @if ($product->pg_id == 2) selected @endif>{{ $u->unit_type }}</option>
                                        @else
                                            <option value="{{ $u->unit_id }}">{{ $u->unit_type }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <span>คำบรรยายบริการ</span>
                                <textarea class="form-control" id="serviceDesc" rows="3">@if ($product->pg_id == 2) {{ $product->p_desc }} @endif</textarea>
                            </div>
                        </div>
                    </div>
                    <br />
                </div>

                <hr />
                <h5>ข้อมูลราคามาตรฐาน</h5>
                <br />
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>ราคาขาย/หน่วย</span>
                            <input class="form-control" id="pSalePrice" value="{{ $product->p_sale_price}}"/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>อัตราภาษีมูลค่าเพิ่ม</span>
                            <select class="form-control" id="pSaleVatRate">
                                <option value="" @if ($product->p_sale_vat_rate == null || $product->p_sale_vat_rate == '') selected @endif>ไม่มี Vat</option>
                                <option value="0" @if ($product->p_sale_vat_rate == "0") selected @endif>Vat 0%</option>
                                <option value="7" @if ($product->p_sale_vat_rate == "7") selected @endif>Vat 7%</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>ราคาซื้อ/หน่วย</span>
                            <input class="form-control" id="pBuyPrice" value="{{ $product->p_purchase_price }}"/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>อัตราภาษีมูลค่าเพิ่ม</span>
                            <select class="form-control" id="pBuyVatRate">
                                <option value=""  @if ($product->p_purchase_vat_rate == null || $product->p_purchase_vat_rate == '') selected @endif>ไม่มี Vat</option>
                                <option value="0" @if ($product->p_purchase_vat_rate == "0") selected @endif>Vat 0%</option>
                                <option value="7" @if ($product->p_purchase_vat_rate == "7") selected @endif>Vat 7%</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br />

                <hr />
                <h5>ข้อมูลการบันทึกบัญชี</h5>
                <br />

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>บันทึกบัญชีขาย</span>
                            <select class="form-control" id="pSaleAcc">
                                @foreach ($accSale as $a)
                                    @if ($a->acc_code == $product->p_acc_sale)
                                        <option value="{{ $a->acc_code }}" selected>{{ $a->acc_code}} - {{ $a->acc_name }}</option>
                                    @else
                                        <option value="{{ $a->acc_code }}">{{ $a->acc_code}} - {{ $a->acc_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>บันทึกบัญชีซื้อ</span>
                            <select class="form-control" id="pBuyAcc">
                                @foreach ($accPurchase as $b)
                                    @if ($b->acc_code == $product->p_acc_purchase)
                                        <option value="{{ $b->acc_code }}" selected>{{ $b->acc_code}} - {{ $b->acc_name }}</option>
                                    @else
                                        <option value="{{ $b->acc_code }}">{{ $b->acc_code}} - {{ $b->acc_name }}</option>
                                    @endif
                                @endforeach
                            </select>
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
                        <button type="button" class="form-control btn btn-danger"
                            onclick="window.location.href='{{ url('products') }}'">Cancel</button>
                    </div>
                    <div class="col-sm-2">

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
            const panelA = document.getElementById('panelA');
            const panelB = document.getElementById('panelB');

            // Function to toggle panels based on selected radio button
            function togglePanels() {
                if (optionA.checked) {
                    panelA.style.display = 'block';
                    panelB.style.display = 'none';
                    generateCode();
                } else {
                    panelA.style.display = 'none';
                    panelB.style.display = 'block';
                    generateCode();
                }
            }

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

            let pId = "{{ $product->p_id }}";
            let pgId = $("input[type='radio'][name='pgId']:checked").val();
            let productName = "";
            let productDesc = "";
            let productUnit = "";
            let productCode = "";
            let pSalePrice = $('#pSalePrice').val();
            let pSaleVatRate = $('#pSaleVatRate').val();
            let pBuyPrice = $('#pBuyPrice').val();
            let pBuyVatRate = $('#pBuyVatRate').val();
            let pSaleAcc = $('#pSaleAcc').val();
            let pBuyAcc = $('#pBuyAcc').val();

            if (pgId === "") {
                alertError("กรุณาเลือกประเภท");
                return "";
            }

            if(pgId == "1") { 
                productCode = $('#productCode').val();
                productName = $('#productName').val();
                productUnit = $('#productUnitId').val();
                productDesc = $('#productDesc').val();

            } else {
                productCode = $('#serviceCode').val();
                productName = $('#serviceName').val();
                productUnit = $('#serviceUnitId').val();
                productDesc = $('#serviceDesc').val();
            }

            if (productName === '') {
                alertError("กรุณากรอกชื่อสินค้า");
                loadingHide();
                return "";
            }

            if (productUnit === '') {
                alertError("กรุณาเลือกหน่วย");
                loadingHide();
                return "";
            }

            if (productDesc === '') {
                alertError("กรุณากรอกคำบรรยายสินค้า");
                loadingHide();
                return "";
            }

            if (pSalePrice === '') {
                alertError("กรุณากรอกราคาขาย");
                loadingHide();
                return "";
            }
            if (pBuyPrice === '') {
                alertError("กรุณากรอกราคาซื้อ");
                loadingHide();
                return "";
            }


            $.ajax({
                type: "POST",
                url: '{{ URL::to('products/addEdit') }}',
                data: {
                    pId: pId,
                    productName: productName,
                    productUnit: productUnit,
                    productDesc: productDesc,
                    pSalePrice: pSalePrice,
                    pSaleVatRate: pSaleVatRate,
                    pBuyPrice: pBuyPrice,
                    pBuyVatRate: pBuyVatRate,
                    pSaleAcc: pSaleAcc,
                    pBuyAcc: pBuyAcc,
                    type: "edit",
                    _token: '{!! csrf_token() !!}'
                },
                success: function(result) {
                    window.location.href = "{{ url('products') }}";
                },
                error: function(result) {
                    alertError(result.responseJSON.message);
                    loadingHide();
                }
            });
        }
    </script>
@endsection
