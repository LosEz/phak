@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Supplier</h6>
        </div>

        <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>Supplier Code</span>
                            <input class="form-control" id="suppCodeSearch" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>Supplier Name</span>
                            <input class="form-control" id="suppNameSearch" />
                        </div>
                    </div>
                </div>
                <br/>
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

    <div class="card ">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Product List</h3>
                </div>
                <div class="col-sm-6" style="text-align: right;">
                    <button class="btn btn-info" href="{{ url('supplier') }}/add">Add</button>
                </div>
            </div>
           
            <br/>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Supplier Code</th>
                            <th>Supplier Name</th>
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

     document.addEventListener("DOMContentLoaded", function (event) {
        tablelist = $('#dataTable').DataTable({
             "pageLength": 10,
             "bLengthChange": true,
             "ordering": false,
             "info": true
         });
    });

     function searchProduct() {
        loadingShow();
        let suppCodeSearch = $('#suppCodeSearch').val();
        let suppNameSearch = $('#suppNameSearch').val();

        $.ajax(
            {
                type: "POST",
                url: '{{URL::to("supplier/search")}}',
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
