@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Users</h6>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>User Code</span>
                        <input class="form-control" id="usrCode" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>User Name</span>
                        <input class="form-control" id="usrName" />
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-sm-2">

                </div>
                <div class="col-sm-8">
                    <button type="button" class="form-control btn btn-primary" onclick="searchUsers()">Search</button>
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
                    <h3>Role List</h3>
                </div>
                <div class="col-sm-6" style="text-align: right;">
                    <button class="btn btn-info" onclick="window.location.href='/phak/public/users/add'">Add</button>
                </div>
            </div>

            <br />
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Role Code</th>
                            <th>Role Name</th>
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

    function searchRole() {
        loadingShow();
        let roleName = $('#roleName').val();

        $.ajax({
            type: "POST",
            url: '{{URL::to("role/search")}}',
            data: {
                roleName: roleName,
                _token: '{!! csrf_token() !!}'
            },
            success: function(result) {
                tablelist.clear().draw();
                items = [];
                if (result['roles'].length > 0) {
                    let data = result['roles'];
                    items = data;

                    for (var i = 0; i < data.length; i++) {
                        tempResp = result['roles'][i];
                        var rowNode = tablelist.row.add([
                            (i + 1),
                            tempResp['roleId'],
                            tempResp['roleName'],
                            `<td class="text-center">
                                <button type="button" class="btn btn-info btn-circle" onclick="window.location='/role/add'"><i class="fas fa-info"></i></button>
                            </td>`

                        ]).draw().node();

                        $(rowNode).find('td').eq(0).addClass('text-center');
                        $(rowNode).find('td').eq(1).addClass('text-center');
                        $(rowNode).find('td').eq(2).addClass('text-left');
                        $(rowNode).find('td').eq(3).addClass('text-center');
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