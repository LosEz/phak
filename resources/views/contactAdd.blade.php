@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Customer > Add</h6>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>Contact Code</span>
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
</div>

<script>
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