@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Product</h6>
        </div>

        <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>Supplier Code</span>
                            <input class="form-control" id="suppCode" value="{{$supp->suppCode}}" disabled/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>Supplier Name</span>
                            <input class="form-control" id="suppName" value="{{$supp->suppName}}" disabled/>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>ชื่อ</span>
                            <input class="form-control" id="firstname" value="{{$supp->firstname}}"/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>นามสกุล</span>
                            <input class="form-control" id="lastname" value="{{$supp->lastname}}"/>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>แหล่งผลิต</span>
                            <input class="form-control" id="sourceProduct" value="{{$supp->sourceProduct}}"/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>มาตรฐาน GAP</span><br/>
                            <input type="radio" name="fav_language" value="C" @if($supp->gapType == "C") checked @endif>
                            <label for="gapComplete">ได้รับ</label><br>
                            <input type="radio" name="fav_language" value="P" @if($supp->gapType == "P") checked @endif>
                            <label for="gapProcess">กำลังดำเนินการ</label><br>
                            <input type="radio" name="fav_language" value="U" @if($supp->gapType == "U") checked @endif>
                            <label for="gapUncomplete">ยังไม่ได้รับ</label>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>GAP Approve Date</span>
                            <input class="form-control" type="date" id="gapAppDate" value="{{$supp->gapAppDate}}"/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>GAP Expire Date</span>
                            <input class="form-control" type="date" id="gapExpireDate" value="{{$supp->gapExpireDate}}"/>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>ระบุปุ๋ย/สารเคมีที่ใช้</span>
                            <textarea class="form-control" id="chemicals">{{$supp->chemicals}}</textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>ขนาดแปลง</span>
                            <textarea class="form-control" id="vetPlot">{{$supp->vetPlot}}</textarea>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>ที่มาของดินที่ใช้</span>
                            <textarea class="form-control" id="earthHistory">{{$supp->earthHistory}}</textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>ที่มาของดิน</span>
                            <textarea class="form-control" id="originalSoil">{{$supp->originalSoil}}</textarea>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-sm-2">

                    </div>
                    <div class="col-sm-8">
                        <button type="button" class="form-control btn btn-primary" onclick="save()">Save</button>
                    </div>
                    <div class="col-sm-2">
                    
                    </div>
                   
                </div>
        </div>
    </div>
</div>

    <script>
     function save() {
        loadingShow();
        let suppCode = $('#suppCode').val();
        let suppName = $('#suppName').val();
        let firstname = $('#firstname').val();
        let lastname = $('#lastname').val();
        let sourceProduct = $('#sourceProduct').val();
        let gapAppDate = $('#gapAppDate').val();
        let gapExpireDate = $('#gapExpireDate').val();
        let chemicals = $('#chemicals').val();
        let vetPlot = $('#vetPlot').val();
        let earthHistory = $('#earthHistory').val();
        let originalSoil = $('#originalSoil').val();
        let gapType = $("input:radio[name=fav_language]:checked").val();
        
        $.ajax(
            {
                type: "POST",
                url: '{{URL::to("supplier/save")}}',
                data:
                {
                    suppCode : suppCode,
                    suppName : suppName,
                    firstname : firstname,
                    lastname : lastname,
                    sourceProduct : sourceProduct,
                    gapType : gapType,
                    gapAppDate : gapAppDate,
                    gapExpireDate : gapExpireDate,
                    chemicals : chemicals,
                    vetPlot : vetPlot,
                    earthHistory : earthHistory,
                    originalSoil : originalSoil,
                    type : "edit",
                    _token: '{!! csrf_token() !!}'
                },
                success: function (result) {
                    window.location.href = "{{ url('supplier') }}";
                },
                error: function (result) {
                    console.log(result)
                    loadingHide();
                }
            });
    }
</script>

@endsection
