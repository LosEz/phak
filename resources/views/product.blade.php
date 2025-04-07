@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Product</h6>
        </div>

        <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <span>Product Code</span>
                            <input class="form-control" id="proCodeSearch" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <span>Product Name</span>
                            <input class="form-control" id="proNameSearch" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <span>Product Group</span>
                            <select class="form-control" id="prodGroupSearch">
                                <option value="">All</option>
                                @foreach($productGroup as $group)
                                <option value="{{ $group->prodGroupCode }}">{{ $group->prodGroupName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <span>Category</span>
                            <select class="form-control" id="cateSearch">
                                <option value="">All</option>
                                @foreach($category as $cate)
                                <option value="{{ $cate->cateCode }}">{{ $cate->cateName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <span>Unit type</span>
                            <select class="form-control" id="unitSearch">
                                   <option value="">All</option>
                                @foreach($unit as $u)
                                <option value="{{ $u->id }}">{{ $u->unitType }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-sm-2">

                    </div>
                    <div class="col-sm-8">
                        <button type="button" class="form-control btn btn-primary" onclick="searchProduct()">Search</button>
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
                    <button class="btn btn-info" onclick="addModal()">Add</button>
                </div>
            </div>
           
            <br/>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Product Gtoup</th>
                            <th>Catgory</th>
                            <th>Unit Type</th>
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
        let proCodeSearch = $('#proCodeSearch').val();
        let proNameSearch = $('#proNameSearch').val();
        let prodGroupSearch = $('#prodGroupSearch').val();
        let cateSearch = $('#cateSearch').val();
        let unitSearch = $('#unitSearch').val();

        $.ajax(
            {
                type: "POST",
                url: '{{URL::to("products/search")}}',
                data:
                {
                    proCodeSearch : proCodeSearch,
                    proNameSearch : proNameSearch,
                    prodGroupSearch : prodGroupSearch,
                    cateSearch : cateSearch,
                    unitSearch : unitSearch,
                    _token: '{!! csrf_token() !!}'
                },
                success: function (result) {
                    tablelist.clear().draw();
                    items = [];
                if (result['products'].length > 0) {
                    let data = result['products'];
                    items = data;

                    for (var i = 0; i < data.length; i++) {
                        tempResp = result['products'][i];
                        var rowNode = tablelist.row.add([
                            (i + 1),
                            tempResp['proCode'],
                            tempResp['proName'],
                            tempResp['proGroupName'],
                            tempResp['cateType'],
                            tempResp['unitType'],
                            `<td class="text-center">
                                <button type="button" class="btn btn-info btn-circle" onclick="editModal('${ i }', true)"><i class="fas fa-info"></i></button>
                                <button type="button" class="btn btn-warning btn-circle" onclick="editModal('${ i }', false)"><i class="fas fa-edit"></i></button>
                            </td>`

                        ]).draw().node();

                        $(rowNode).find('td').eq(0).addClass('text-center');
                        $(rowNode).find('td').eq(1).addClass('text-center');
                        $(rowNode).find('td').eq(2).addClass('text-left');
                        $(rowNode).find('td').eq(3).addClass('text-center');
                        $(rowNode).find('td').eq(4).addClass('text-center');
                        $(rowNode).find('td').eq(5).addClass('text-center');
                        $(rowNode).find('td').eq(6).addClass('text-center');
                    }
                } 
                loadingHide();

                },
                error: function (result) {
                    alertError(result.responseJSON.message);
                    loadingHide();
                }
            });
    }
</script>

@endsection
