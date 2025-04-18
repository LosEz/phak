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
                        <span>User Id</span>
                        <input class="form-control" id="usrId" disabled/>
                    </div>
                </div>
                <div class="col-sm-6">
                    
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>First Name</span>
                        <input class="form-control" id="usrFirstname" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>Last Name</span>
                        <input class="form-control" id="usrLastname" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>Email</span>
                        <input class="form-control" id="usrEmail" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>Phone</span>
                        <input class="form-control" id="usrPhone" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>Roles</span>
                        <select class="form-control" id="roleId">
                            @foreach($roles as $key => $r)
                                <option value="{{ $r->role_id }}">{{ $r->role_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                   
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-sm-3">

                </div>
                <div class="col-sm-3">
                    <button type="button" class="form-control btn btn-primary" onclick="saveUsers()">Save</button>
                </div>
                <div class="col-sm-3">
                    <button type="button" class="form-control btn btn-warning" onclick="window.location.href='{{ url('users') }}'">Back</button>
                </div>
                <div class="col-sm-3">

                </div>

            </div>
        </div>
    </div>
</div>

<script>
    
    function saveUsers() {
        loadingShow();

        var usrFirstname = $('#usrFirstname').val();
        var usrLastname = $('#usrLastname').val();
        var usrEmail = $('#usrEmail').val();
        var usrPhone = $('#usrPhone').val();
        var roleId = $('#roleId').val();
        
        $.ajax(
            {
                type: "POST",
                url: '{{URL::to("users/save")}}',
                data:
                {
                    type: "add",
                    usrFirstname: usrFirstname,
                    usrLastname: usrLastname,
                    usrEmail: usrEmail,
                    usrPhone: usrPhone,
                    roleId: roleId,
                    _token: '{!! csrf_token() !!}'
                },
                success: function (result) {
                    window.location.href = "{{ url('users') }}";
                },
                error: function (result) {
                    console.log(result)
                    loadingHide();
                }
            });
    }

</script>

@endsection