@extends('layouts.master')
 
@section('content')
    
    <div class="container-fluid">
    
    <div class="card shadow mb-4">
        <div class="card-body">
            <h2>Stock </h2> 
        </div>
    </div>

     <div class="card shadow mb-4"> 
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>aasdas</label>
                        <input class="form-control">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>aasdas</label>
                        <input class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
     <div class="card shadow mb-4"> 
        <div class="card-body">
            <button onclick="testApi()">Search</button>
        </div>
    </div>

    </div>

    <script>

        function testApi() {
                $.ajax(
                    {
                        type: "GET",
                        url: '{{URL::to("scapping/genData")}}',
                        data:
                        {
                            _token: '{!! csrf_token() !!}'
                        },
                        success: function (result) {
                            console.log(result)
                        },
                        error: function (result) {
                            console.log(result)
                        }
                    });
            }

    </script>




@endsection