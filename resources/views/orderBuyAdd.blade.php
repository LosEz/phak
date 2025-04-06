@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Product</h6>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>Order Buy ID</span>
                        <input class="form-control" disabled />
                    </div>
                </div>
            </div>

            <br />

            <div class="row">
                <div class="col-sm-6">
                    <h3>Product List</h3>
                </div>
                <div class="col-sm-6" style="text-align: right;">
                    <a class="btn btn-info" onclick="addRow()">Add</a>
                </div>
            </div>

            <br />
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>Suppliers</th>
                            <th>Products</th>
                            <th width="15%">Amount</th>
                            <th width="15%">Price</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="rowTable">

                    </tbody>

                </table>
            </div>
        </div>

        <br />

        <div class="row">
            <div class="col-sm-2">

            </div>
            <div class="col-sm-6">
                <button type="button" class="form-control btn btn-primary" onclick="save()">Save</button>
            </div>
            <div class="col-sm-2">
                <button type="button" class="form-control btn btn-warning" onclick='window.location.href="{{ url('buyOrder') }}"'>Back</button>
            </div>
            <div class="col-sm-2">

            </div>

        </div>

        <br />
    </div>

</div>

<script>
    let countRow = 0;

    var suppJson = @json($supppliers, JSON_PRETTY_PRINT);
    var suppList = "<option value='0'>Please select suppliers</option>";

    var prdtJson = @json($products, JSON_PRETTY_PRINT);
    var prdtList = "<option value='0'>Please select products</option>";
    
    document.addEventListener("DOMContentLoaded", function(event) {
        for(let i = 0; i < suppJson.length; i++) {
            suppList += `<option value="${suppJson[i]['supId']}">${suppJson[i]['supName']}</option>`;
        }

        for(let i = 0; i < prdtJson.length; i++) {
            prdtList += `<option value="${prdtJson[i]['prodId']}">${prdtJson[i]['prodName']}</option>`;
        }

        addRow();
    });

    function addRow() {
        countRow++; 
        let row = `<tr id='row_${countRow}'>`;
        row += `<td >
                    <select id="${countRow}_supp" class="form-control">
                        ${suppList}
                    </select>
                </td>
                <td >
                    <select id="${countRow}_prod" class="form-control">
                        ${prdtList}
                    </select>
                </td>
                <td>
                    <input id="${countRow}_amount" class="form-control">
                </td>
                <td>
                    <input id="${countRow}_price" class="form-control">
                </td>
                <td>
                    <button type="button" class="form-control btn btn-danger" onclick="removeRow(${countRow})">
                        <i class="fas fa-fw fa-trash"></i>
                    </button>
                </td>`;
        row += "</tr>";

        $('#rowTable').append(row);

    }

    function removeRow(count) {
        let row = "#" + "row_" + count;
        $(row).remove();
    }

    function save() {
        loadingShow();

        var orderList = new Array();
       
        for(let i = 1; i <= countRow; i++) {
            var supp = $("#" + i + "_supp").val();
            var prod = $("#" + i + "_prod").val();
            var amount = $("#" +i+ "_amount").val();
            var price = $("#" + i + "_price").val();

            if(supp !== undefined && supp !== "0") {
                orderList.push({
                    supp: supp,
                    prod: prod,
                    amount: amount,
                    price: price
                 });
            } else {
                alert("Please select suppliers");
                return false;
            }
        }

        $.ajax({
            type: "POST",
            url: '{{URL::to("buyOrder/save")}}',
            data: {
                orderList: orderList,
                type: "add",
                _token: '{!! csrf_token() !!}'
            },
            success: function(result) {
                alertSuccess(result.message);
                window.location.href = "{{ url('buyOrder') }}";
            },
            error: function(result) {
                alertError(result.responseJSON.message);
                loadingHide();
            }
        });
    }
</script>

@endsection