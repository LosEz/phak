@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Role > Edit</h6>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>Role Name</span>
                        <input class="form-control" id="roleName" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>Role Status</span>
                        <select class="form-control" id="roleStatus">
                            <option value="A" selected>Active</option>
                            <option value="D">Deactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <span>Permission</span>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="text-center">
                                        <th>No.</th>
                                        <th>Func Name</th>
                                        <th>View</th>
                                        <th>Add</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                        <th>Import</th>
                                        <th>Export</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($permissions as $key => $p)
                                        <tr class="text-center" >
                                           <td>{{ $key + 1}} <input class="hide" name="funcId" value="{{$p->func_id}}"/></td>
                                           <td class="text-left">{{ $f->func_name }}</td> 
                                           <td><input type="checkbox" name="per_view" value="{{$p->is_view}}"/></td> 
                                           <td><input type="checkbox" name="per_add" value="{{$p->is_add}}"/></td> 
                                           <td><input type="checkbox" name="per_edit" value="{{$p->is_edit}}"/></td> 
                                           <td><input type="checkbox" name="per_delete" value="{{$p->is_delete}}"/></td> 
                                           <td><input type="checkbox" name="per_import" value="{{$p->is_import}}"/></td> 
                                           <td><input type="checkbox" name="per_export" value="{{$p->is_export}}"/></td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-sm-3">

                </div>
                <div class="col-sm-3">
                    <button type="button" class="form-control btn btn-primary" onclick="saveRole()">Save</button>
                </div>
                <div class="col-sm-3">
                    <button type="button" class="form-control btn btn-warning" onclick="window.location.href='{{ url('roles') }}'">Back</button>
                </div>
                <div class="col-sm-3">

                </div>

            </div>
        </div>
    </div>

</div>

<script>
    var tablelist;
    var items = [];

    document.addEventListener("DOMContentLoaded", function(event) {
        tablelist = $('#dataTable').DataTable({
            "pageLength": 100,
            "bLengthChange": false,
            "ordering": false,
            "info": false,
            "searching": false, 
            "paging": false
        });
    });

    function saveRole() {
        loadingShow();

        var roleName = $('#roleName').val();
        var roleStatus = $('#roleStatus').val();

        if(roleName === '') {
            alert("role name is required.");
            return "";
        }

        var funcId = []
        var checkboxes = document.querySelectorAll('input[name="funcId"]')
        for (var i = 0; i < checkboxes.length; i++) {
            funcId.push(checkboxes[i].value);
        }

        var perView = []
        var checkboxes = document.querySelectorAll('input[name="per_view"]')
        for (var i = 0; i < checkboxes.length; i++) {
            perView.push(checkboxes[i].checked);
        }

        var perAdd = []
        var checkboxes = document.querySelectorAll('input[name="per_add"]')
        for (var i = 0; i < checkboxes.length; i++) {
            perAdd.push(checkboxes[i].checked);
        }

        var perEdit = []
        var checkboxes = document.querySelectorAll('input[name="per_edit"]')
        for (var i = 0; i < checkboxes.length; i++) {
            perEdit.push(checkboxes[i].checked);
        }

        var perDelete = []
        var checkboxes = document.querySelectorAll('input[name="per_delete"]')
        for (var i = 0; i < checkboxes.length; i++) {
            perDelete.push(checkboxes[i].checked);
        }

        var perImport = []
        var checkboxes = document.querySelectorAll('input[name="per_import"]')
        for (var i = 0; i < checkboxes.length; i++) {
            perImport.push(checkboxes[i].checked);
        }

        var perExport = []
        var checkboxes = document.querySelectorAll('input[name="per_export"]')
        for (var i = 0; i < checkboxes.length; i++) {
            perExport.push(checkboxes[i].checked);
        }

        $.ajax(
            {
                type: "POST",
                url: '{{URL::to("roles/saveAdd")}}',
                data:
                {
                    roleName: roleName,
                    roleStatus: roleStatus,
                    funcId: funcId,
                    perView: perView,
                    perAdd: perAdd,
                    perEdit: perEdit,
                    perDelete: perDelete,
                    perImport: perImport,
                    perExport: perExport,
                    _token: '{!! csrf_token() !!}'
                },
                success: function (result) {
                    window.location.href = "{{ url('roles') }}";
                },
                error: function (result) {
                    console.log(result)
                    loadingHide();
                }
            });
    }

</script>

@endsection