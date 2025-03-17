@extends('layouts.master')

<style>
    .HeaderText {
        font-weight: bold;
    }
    </style>

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-0 font-weight-bold text-primary">Organization</h4>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="HeaderText">
                        <span>From</span>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-control">
                        @switch($org->org_bus_type)
                            @case('C')
                                <span>Company Limited</span>
                                @break
                            @case('P')
                                <span>Public Company Limited</span>
                                @break
                            @case('L')
                                <span>Limited Partnership</span>
                                @break
                            @case('F')
                                <span>Foundataion</span>
                                @break
                            @case('A')
                                <span>Association</span>
                                @break
                            @case('O')
                                <span>Other</span>
                                @break
                            @default
                                
                        @endswitch
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="HeaderText">
                        <span>Tax ID</span>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-control">
                        <span>{{$org->org_tax_id}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="HeaderText">
                        <span>Branch</span>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-control">
                        @if($org->org_type == 'H')
                        <span>Head Office</span>
                        @else 
                        <span>Branch No.</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="HeaderText">
                        <span>Name TH</span>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-control">
                        <span>{{ $org->org_name }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="HeaderText">
                        <span>Name EN</span>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-control">
                        <span>{{ $org->org_add_name_en }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="HeaderText">
                        <span>Register Date</span>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-control">
                        <span>{{ date('d/m/Y', strtotime($org->org_register_date));}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="HeaderText">
                        <span>VAT Registered</span>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-control">
                        @if($org->org_register_status == 'N')
                        <span>Non VAT Registered</span>
                        @else
                        <span>VAT Registered</span>
                        @endif
                    </div>
                </div>
            </div>
            <br/>
            <H5>Contact Info</H5>
            <hr/>

            <div class="row">
                <div class="col-sm-4">
                    <div class="HeaderText">
                        <span>Telephone</span>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-control">
                        <span>{{ $org->org_ct_tel }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="HeaderText">
                        <span>Main Email</span>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-control">
                        <span>{{ $org->org_ct_email }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="HeaderText">
                        <span>Fax</span>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-control">
                        <span>{{ $org->org_ct_fax }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="HeaderText">
                        <span>Website</span>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-control">
                        <span>{{ $org->org_ct_website }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="HeaderText">
                        <span>Line</span>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-control">
                        <span>{{ $org->org_ct_tel }}</span>
                    </div>
                </div>
            </div>
            <br/>
            <H5>Address Info</H5>
            <hr/>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-Grup">
                        <span class="HeaderText">Registered Address TH</span>
                        <br/>
                        <span>{{ $org->addressTH }}</span>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-Grup">
                        <span class="HeaderText">Registered Address EN</span>
                        <br/>
                        <span>{{ $org->addresEN }}</span>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-Grup">
                        <span class="HeaderText">Office address</span>
                        <br/>
                        <span>{{ $org->sendDoc }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
   
</script>

@endsection