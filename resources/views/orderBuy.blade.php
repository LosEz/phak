@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Buy Order</h6>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Order ID</span>
                        <input class="form-control" id="orderIdSearch" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Create Date From</span>
                        <input type="date" id="fromDate" class="form-control">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Create Date To</span>
                        <input type="date" id="toDate" class="form-control">
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-sm-2">

                </div>
                <div class="col-sm-8">
                    <button type="button" class="form-control btn btn-primary" onclick="searchOrder()">Search</button>
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
                    <h3>Buy Order List</h3>
                </div>
                <div class="col-sm-6" style="text-align: right;">
                    <a class="btn btn-info" href="{{ url('buyOrder') }}/add">Add</a>
                </div>
            </div>

            <br />
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Order ID</th>
                            <th>Create Date</th>
                            <th>Delivery Date</th>
                            <th>Action</th>
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

    function searchOrder() {
        loadingShow();
        let orderIdSearch = $('#orderIdSearch').val();
        let fromDate = $('#fromDate').val();
        let toDate = $('#toDate').val();

        $.ajax({
            type: "POST",
            url: '{{URL::to("buyOrder/search")}}',
            data: {
                orderIdSearch: orderIdSearch,
                fromDate: fromDate,
                toDate: toDate,
                _token: '{!! csrf_token() !!}'
            },
            success: function(result) {
                tablelist.clear().draw();
                items = [];
                if (result['orderBuy'].length > 0) {
                    let data = result['orderBuy'];
                    items = data;

                    for (var i = 0; i < data.length; i++) {
                        tempResp = result['orderBuy'][i];

                        let deliDate = "";

                        if( tempResp['deliveryDate'] == "") {
                            `<td class="text-center">
                                <button type="button" class="btn btn-info btn-circle" target="_blank" onclick='window.location.href="{{ url("orderBuy") }}/view/${tempResp['orderId']}'><i class="fas fa-info"></i></button>
                                <button type="button" class="btn btn-warning btn-circle" target="_blank" onclick='window.location.href="{{ url("orderBuy") }}/edit/${tempResp['orderId']}'><i class="fas fa-edit"></i></button>
                            </td>`
                        } else {
                            deliDate = tempResp['deliveryDate'];
                        }

                        var rowNode = tablelist.row.add([
                            (i + 1),
                            tempResp['orderId'],
                            tempResp['createDate'],
                            deliDate,
                            `<td class="text-center">
                                <button type="button" class="btn btn-info btn-circle" target="_blank" onclick='window.location.href="{{ url("orderBuy") }}/view/${tempResp['orderId']}'><i class="fas fa-info"></i></button>
                                <button type="button" class="btn btn-warning btn-circle" target="_blank" onclick='window.location.href="{{ url("orderBuy") }}/edit/${tempResp['orderId']}'><i class="fas fa-edit"></i></button>
                            </td>`

                        ]).draw().node();

                        $(rowNode).find('td').eq(0).addClass('text-center');
                        $(rowNode).find('td').eq(1).addClass('text-center');
                        $(rowNode).find('td').eq(2).addClass('text-center');
                        $(rowNode).find('td').eq(3).addClass('text-center');
                        $(rowNode).find('td').eq(4).addClass('text-center');
                    }
                }
                alertSuccess(result.message);
                loadingHide();

            },
            error: function(result) {
                alertError(result.responseJSON.message);
                loadingHide();
            }
        });
    }

</script>

@endsection