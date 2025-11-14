@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Cash/Bank/e-Wallet > Detail</h6>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h3>BSV001 - เงินฝากออมทรัพย์ 1783468340 บจก. ฟาร์มผักอยู่ดี</h3>
                </div>
                <div class="col-sm-6" style="text-align: right;">
                    <button class="btn btn-info" onclick="window.location.href='{{ url('contacts') }}/add'">Add</button>
                </div>
            </div>



            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>Contact Code</span>
                        <input class="form-control" id="conCodeSearch" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>Contact Name</span>
                        <input class="form-control" id="conNameSearch" />
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>Contact Tax Id</span>
                        <input class="form-control" id="conTaxIdSearch" />
                    </div>
                </div>
                <div class="col-sm-6">
                    {{-- <div class="form-group">
                        <span>Contact Name</span>
                        <input class="form-control" id="cusNameSearch" />
                    </div> --}}
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-sm-2">

                </div>
                <div class="col-sm-8">
                    <button type="button" class="form-control btn btn-primary" onclick="searchContacts()">Search</button>
                </div>
                <div class="col-sm-2">

                </div>

            </div>
        </div>
    </div>

    <div class="card ">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Contacts List</h3>
                </div>
                <div class="col-sm-6" style="text-align: right;">
                    <button class="btn btn-info" onclick="window.location.href='{{ url('contacts') }}/add'">Add</button>
                </div>
            </div>

            <br />
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>วันที่</th>
                            <th>เอกสารกระทบยอด</th>
                            <th>ผู้ติดต่อ</th>
                            <th>หมายเหตุ</th>
                            <th>เงินเข้า - ออก</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>

<script>
    var tablelist;
    var items = [];

    document.addEventListener("DOMContentLoaded", function(event) {
        tablelist = $('#dataTable').DataTable({
            "pageLength": 10,
            "bLengthChange": true,
            "ordering": false,
            "info": true
        });
    });

    function searchContacts() {
        loadingShow();
        let conCodeSearch = $('#conCodeSearch').val();
        let conNameSearch = $('#conNameSearch').val();
        let conTaxIdSearch = $('#conTaxIdSearch').val();

        $.ajax({
            type: "POST",
            url: '{{URL::to("contacts/search")}}',
            data: {
                conCodeSearch: conCodeSearch,
                conNameSearch: conNameSearch,
                conTaxIdSearch: conTaxIdSearch,
                _token: '{!! csrf_token() !!}'
            },
            success: function(result) {
                tablelist.clear().draw();
                items = [];
                if (result['contacts'].length > 0) {
                    let data = result['contacts'];
                    items = data;

                    for (var i = 0; i < data.length; i++) {
                        tempResp = result['contacts'][i];
                        var rowNode = tablelist.row.add([
                            (i + 1),
                            tempResp['conCode'],
                            tempResp['conName'],
                            tempResp['contactType'],
                            tempResp['conPhone'],
                            `<td class="text-center">
                                <button type="button" class="btn btn-danger btn-circle" onclick="window.location.href='{{ url('contacts') }}/edit/${tempResp['conId']}'"><i class="fas fa-edit"></i></button>
                            </td>`

                        ]).draw().node();

                        $(rowNode).find('td').eq(0).addClass('text-center');
                        $(rowNode).find('td').eq(1).addClass('text-center');
                        $(rowNode).find('td').eq(2).addClass('text-left');
                        $(rowNode).find('td').eq(3).addClass('text-center');
                        $(rowNode).find('td').eq(4).addClass('text-center');
                        $(rowNode).find('td').eq(5).addClass('text-center');
                    }
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