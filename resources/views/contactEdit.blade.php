@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Customer</h6>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>Customer Code</span>
                        <input class="form-control" id="cusCodeSearch" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>Customer Name</span>
                        <input class="form-control" id="cusNameSearch" />
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-sm-2">

                </div>
                <div class="col-sm-8">
                    <button type="button" class="form-control btn btn-primary" onclick="searchCustomer()">Search</button>
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
                    <h3>Customer List</h3>
                </div>
                <div class="col-sm-6" style="text-align: right;">
                    <button class="btn btn-info" onclick="addModal()">Add</button>
                </div>
            </div>

            <br />
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Customer Code</th>
                            <th>Customer Name</th>
                            <th>Customer Group</th>
                            <th>Customer Phone</th>
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

<div id="addEditModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title">Add Customer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>Customer Code</span>
                            <input class="form-control" id="cusCode" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>Customer Name</span>
                            <input class="form-control" id="cusName" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>Customer Firstname</span>
                            <input class="form-control" id="cusFirstname" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>Customer Lastname</span>
                            <input class="form-control" id="cusLastname" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>Customer Group</span>
                            <select class="form-control" id="cusGroupCode">
                                <option value="">Please select customer group</option>
                                <option value="L">Large</option>
                                <option value="M">Medium</option>
                                <option value="S">Small</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>Customer Phone</span>
                            <input class="form-control" id="cusPhone" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>Customer Email</span>
                            <input class="form-control" id="cusEmail" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>Customer Address</span>
                            <textarea class="form-control" id="cusAddress"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="addBtn" type="submit" class="btn btn-success" onclick="saveData('add')">Submit</button>
                <button id="editBtn" type="submit" class="btn btn-success hide" onclick="saveData('edit')">Submit</button>
                <button type="submit" class="btn btn-danger" data-dismiss="modal">Cancel</button>
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

    function searchCustomer() {
        loadingShow();
        let cusCodeSearch = $('#cusCodeSearch').val();
        let cusNameSearch = $('#cusNameSearch').val();

        $.ajax({
            type: "POST",
            url: '{{URL::to("customer/search")}}',
            data: {
                cusCodeSearch: cusCodeSearch,
                cusNameSearch: cusNameSearch,
                _token: '{!! csrf_token() !!}'
            },
            success: function(result) {
                tablelist.clear().draw();
                items = [];
                if (result['customers'].length > 0) {
                    let data = result['customers'];
                    items = data;

                    for (var i = 0; i < data.length; i++) {
                        tempResp = result['customers'][i];
                        var rowNode = tablelist.row.add([
                            (i + 1),
                            tempResp['cusCode'],
                            tempResp['cusName'],
                            tempResp['cusGroup'],
                            tempResp['cusPhone'],
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

    function addModal() {

        $('#title').html("Add Customer");
        $('#cusCode').val("").prop('disabled', true);
        $('#cusName').val("");
        $('#cusGroupCode').val("");
        $('#cusFirstname').val("");
        $('#cusLastname').val("");
        $('#cusPhone').val("");
        $('#cusEmail').val("");
        $('#cusAddress').val("");
        $('#addBtn').removeClass('hide');
        $('#editBtn').addClass('hide');
        $('#addEditModal').modal();
ß
        actionDisabled(false);
    }

    function editModal(id, checkDisabled) {
        let data = items[id];
        $('#title').html("Edit Product : " + data['cusName']);
        $('#cusCode').val(data['cusCode']).prop('disabled', true);
        $('#cusName').val(data['cusName']);
        $('#cusGroupCode').val(data['cusGroup']);
        $('#cusFirstname').val(data['cusFirstname']);
        $('#cusLastname').val(data['cusLastname']);
        $('#cusPhone').val(data['cusPhone']);
        $('#cusEmail').val(data['cusEmail']);
        $('#cusAddress').val(data['cusAddress']);
        $('#editBtn').removeClass('hide');
        $('#addBtn').addClass('hide');

        actionDisabled(checkDisabled);

        $('#addEditModal').modal();
    }

    function actionDisabled(checkDisabled) {
        $('#cusName').prop('disabled', checkDisabled);
        $('#cusGroupCode').prop('disabled', checkDisabled);
        $('#cusFirstname').prop('disabled', checkDisabled);
        $('#cusLastname').prop('disabled', checkDisabled);
        $('#cusPhone').prop('disabled', checkDisabled);
        $('#cusEmail').prop('disabled', checkDisabled);
        $('#cusAddress').prop('disabled', checkDisabled);

        if (checkDisabled) {
            $('#editBtn').addClass('hide');
        }
    }

    function saveData(type) {
        loadingShow();
        let cusCode = $('#cusCode').val();
        let cusName = $('#cusName').val();
        let cusGroupCode = $('#cusGroupCode').val();
        let cusFirstname = $('#cusFirstname').val();
        let cusLastname = $('#cusLastname').val();
        let cusPhone = $('#cusPhone').val();
        let cusEmail = $('#cusEmail').val();
        let cusAddress = $('#cusAddress').val();

        $.ajax({
            type: "POST",
            url: '{{URL::to("customer/addEdit")}}',
            data: {
                cusCode: cusCode,
                cusName: cusName,
                cusGroupCode: cusGroupCode,
                cusFirstname: cusFirstname,
                cusLastname: cusLastname,
                cusPhone: cusPhone,
                cusEmail: cusEmail,
                cusAddress: cusAddress,
                type: type,
                _token: '{!! csrf_token() !!}'
            },
            success: function(result) {
                $("#addEditModal").modal('hide');
                searchCustomer();

            },
            error: function(result) {
                console.log(result.responseText);
                loadingHide();
            }
        });
    }
</script>

@endsection