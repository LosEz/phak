@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Organization > Edit</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="organizes/save">
                @csrf
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>รูปแบบธุรกิจ</span>
                        <select class="form-control">
                            <option>Natural Person</option>
                            <option>Juristic Person</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                   
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>เลขภาษี (Tax ID)</span>
                        <input class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                   
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <input type="radio" value="H" name="busCategory[]" checked>
                        <label for="html">Head Office</label>
                        <input type="radio" value="B" name="busCategory[]">
                        <label for="html">Branch No.</label>
                    </div>
                </div>
                <div class="col-sm-6">
                   
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>รูปแบบบริษัท</span>
                        <select class="form-control" name="busType">
                            <option value="C">Company Limited</option>
                            <option value="P">Public Company Limited</option>
                            <option value="L">Limited Partnership</option>
                            <option value="F">Foundation</option>
                            <option value="A">Association</option>
                            <option value="J">Joint Venture</option>
                            <option value="O">Other</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>Name</span>
                        <input class="form-control" name="busName">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                       <span>Business Description</span>
                       <input class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <span>Register Date</span>
                        <input class="form-control" type="date" id="regisDate" />
                     </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <input type="radio" value="R" name="vatRegister[]" checked>
                        <label for="html">Registered</label>
                        <input type="radio" value="N" name="vatRegister[]">
                        <label for="html">Not registered</label>
                    </div>
                </div>
                <div class="col-sm-6">
                   
                </div>
            </div>

            <br/>
            <H5>Contact Info</H5>
            <hr/>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Tel</span>
                        <input class="form-control" id="busTelephone" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Email</span>
                        <input class="form-control" id="busEmail" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Line</span>
                        <input class="form-control" id="busLine" />
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Fax</span>
                        <input class="form-control" id="busFax" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Website</span>
                        <input class="form-control" id="busWeb" />
                    </div>
                </div>
            </div>

            <br />
            <h5>Address Info</h5>
            <hr/>
            <br/>
            <h6>Registed Address TH</h6>
            <hr/>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>อาคาร</span>
                        <input class="form-control" id="busTelephone" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>ห้องเลขที่</span>
                        <input class="form-control" id="busEmail" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>ชั้นที่</span>
                        <input class="form-control" id="busLine" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>หมู่บ้าน</span>
                        <input class="form-control" id="busTelephone" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>บ้านเลขที่</span>
                        <input class="form-control" id="busEmail" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>หมู่ที่</span>
                        <input class="form-control" id="busLine" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>ซอย/ตรอก</span>
                        <input class="form-control" id="busTelephone" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>ถนน</span>
                        <input class="form-control" id="busEmail" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>ประเทศ</span>
                        <input class="form-control" id="busLine" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>แขวง</span>
                        <input class="form-control" id="busTelephone" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>เขต/อำเภอ</span>
                        <input class="form-control" id="busEmail" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>จังหวัด</span>
                        <input class="form-control" id="busLine" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>รหัสไปรษณีย์</span>
                        <input class="form-control" id="busTelephone" />
                    </div>
                </div>
                <div class="col-sm-4">
                    
                </div>
                <div class="col-sm-4">
                    
                </div>
            </div>
            <br/>
            <h6>Registed Address EH</h6>
            <hr/>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Name EN</span>
                        <input class="form-control" id="busTelephone" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Building</span>
                        <input class="form-control" id="busEmail" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Room No.</span>
                        <input class="form-control" id="busLine" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Floor No.</span>
                        <input class="form-control" id="busTelephone" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Village</span>
                        <input class="form-control" id="busEmail" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>House No.</span>
                        <input class="form-control" id="busLine" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Village No.</span>
                        <input class="form-control" id="busTelephone" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Alley/Lane</span>
                        <input class="form-control" id="busEmail" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Road</span>
                        <input class="form-control" id="busLine" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Country</span>
                        <input class="form-control" id="busTelephone" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Sub district</span>
                        <input class="form-control" id="busEmail" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>City</span>
                        <input class="form-control" id="busLine" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Province</span>
                        <input class="form-control" id="busTelephone" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>Postal Code</span>
                        <input class="form-control" id="busTelephone" />
                    </div>
                </div>
                <div class="col-sm-4">
                    
                </div>
            </div>

            <br />
            <hr/>

            <h6>ที่อยู่จัดส่งเอกสาร</h6>
            <hr/>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>อาคาร</span>
                        <input class="form-control" id="busTelephone" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>ห้องเลขที่</span>
                        <input class="form-control" id="busEmail" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>ชั้นที่</span>
                        <input class="form-control" id="busLine" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>หมู่บ้าน</span>
                        <input class="form-control" id="busTelephone" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>บ้านเลขที่</span>
                        <input class="form-control" id="busEmail" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>หมู่ที่</span>
                        <input class="form-control" id="busLine" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>ซอย/ตรอก</span>
                        <input class="form-control" id="busTelephone" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>ถนน</span>
                        <input class="form-control" id="busEmail" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>ประเทศ</span>
                        <input class="form-control" id="busLine" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>แขวง</span>
                        <input class="form-control" id="busTelephone" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>เขต/อำเภอ</span>
                        <input class="form-control" id="busEmail" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>จังหวัด</span>
                        <input class="form-control" id="busLine" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <span>รหัสไปรษณีย์</span>
                        <input class="form-control" id="busTelephone" />
                    </div>
                </div>
                <div class="col-sm-4">
                    
                </div>
                <div class="col-sm-4">
                    
                </div>
            </div>



            <div class="row">
                <div class="col-sm-2">

                </div>
                <div class="col-sm-8">
                    <button type="button" class="form-control btn btn-primary" onclick="searchCustomer()">Search</button>
                </div>
                <div class="col-sm-2">

                </div>

            </div>
        </form>
        </div>
    </div>

</div>


<script>

</script>

@endsection