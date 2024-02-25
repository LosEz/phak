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
                            <input class="form-control" id="suppCode" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>Supplier Name</span>
                            <input class="form-control" id="suppName" />
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>ชื่อ</span>
                            <input class="form-control" id="firstname" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>นามสกุล</span>
                            <input class="form-control" id="lastname" />
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>แหล่งผลิต</span>
                            <input class="form-control" id="firstname" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>มาตรฐาน GAP</span>
                            <input class="form-control" type="radio" name="gapType[]" />
                            <input class="form-control" type="radio" name="gapType[]" />
                            <input class="form-control" type="radio" name="gapType[]" />
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>GAP Approve Date</span>
                            <input class="form-control" type="date" id="gapDate" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>GAP Expire Date</span>
                            <input class="form-control" type="date" id="gapExpireDate" />
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>ระบุปุ๋ย/สารเคมีที่ใช้</span>
                            <textarea class="form-control" id="chemicals"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>ขนาดแปลง</span>
                            <textarea class="form-control" id="vetPlot"></textarea>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>ที่มาของดินที่ใช้</span>
                            <textarea class="form-control" id="earthHistory"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>ที่มาของดิน</span>
                            <textarea class="form-control" id="originalSoil"></textarea>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-sm-2">

                    </div>
                    <div class="col-sm-8">
                        <button type="button" class="form-control btn btn-primary" onclick="searchSupplier()">Search</button>
                    </div>
                    <div class="col-sm-2">
                    
                    </div>
                   
                </div>
        </div>
    </div>
</div>

    <script>
    var tablelist;
    var items = [];
     function save() {
        loadingShow();
        let suppCode = $('#suppCode').val();
        let suppName = $('#suppName').val();
        let firstname = $('$firstname').val();
        let lastname = $('#lastname').val();
        let 

        $.ajax(
            {
                type: "POST",
                url: '{{URL::to("supplier/save")}}',
                data:
                {
                    suppCodeSearch : suppCodeSearch,
                    suppNameSearch : suppNameSearch,
                    _token: '{!! csrf_token() !!}'
                },
                success: function (result) {
                    tablelist.clear().draw();
                    items = [];
                if (result['suppliers'].length > 0) {
                    let data = result['suppliers'];
                    items = data;

                    for (var i = 0; i < data.length; i++) {
                        tempResp = result['suppliers'][i];
                        var rowNode = tablelist.row.add([
                            (i + 1),
                            tempResp['suppCode'],
                            tempResp['suppName'],
                            tempResp['fullname'],
                            tempResp['gapDate'],
                            tempResp['gapExpireDate'],
                            `<td class="text-center">
                                <button type="button" class="btn btn-info btn-circle" href="{{ url('supplier') }}/view/${  tempResp['suppCode'] })"><i class="fas fa-info"></i></button>
                                <button type="button" class="btn btn-warning btn-circle" href="{{ url('supplier') }}/edit/${  tempResp['suppCode'] })")"><i class="fas fa-edit"></i></button>
                            </td>`

                        ]).draw().node();

                        $(rowNode).find('td').eq(0).addClass('text-center');
                        $(rowNode).find('td').eq(1).addClass('text-center');
                        $(rowNode).find('td').eq(2).addClass('text-left');
                        $(rowNode).find('td').eq(3).addClass('text-right');
                        $(rowNode).find('td').eq(4).addClass('text-center');
                        $(rowNode).find('td').eq(5).addClass('text-center');
                        $(rowNode).find('td').eq(6).addClass('text-center');
                    }
                } 
                loadingHide();

                },
                error: function (result) {
                    console.log(result)
                    loadingHide();
                }
            });
    }
</script>

@endsection
