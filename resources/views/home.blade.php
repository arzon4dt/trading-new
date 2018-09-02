@extends('layouts.app')
@section('content')
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Info box -->
                <!-- ============================================================== -->
                <div class="card-group">
                    <!-- Card -->
                    <div class="card">
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="d-flex align-items-center">
                                <div class="m-r-10">
                                    <span class="btn btn-circle btn-lg bg-danger">
                                        <i class="ti-clipboard text-white"></i>
                                    </span>
                                </div>
                                <div>
                                    New projects
                                </div>
                                <div class="ml-auto">
                                    <h2 class="m-b-0 font-light">23</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card -->
                    <!-- Card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="m-r-10">
                                    <span class="btn btn-circle btn-lg btn-info">
                                        <i class="ti-wallet text-white"></i>
                                    </span>
                                </div>
                                <div>
                                    Total Earnings

                                </div>
                                <div class="ml-auto">
                                    <h2 class="m-b-0 font-light">113</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card -->
                    <!-- Card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="m-r-10">
                                    <span class="btn btn-circle btn-lg bg-success">
                                        <i class="ti-shopping-cart text-white"></i>
                                    </span>
                                </div>
                                <div>
                                    Total Sales

                                </div>
                                <div class="ml-auto">
                                    <h2 class="m-b-0 font-light">43</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card -->
                    <!-- Card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="m-r-10">
                                    <span class="btn btn-circle btn-lg bg-warning">
                                        <i class="mdi mdi-currency-usd text-white"></i>
                                    </span>
                                </div>
                                <div>
                                    Profit

                                </div>
                                <div class="ml-auto">
                                    <h2 class="m-b-0 font-light">63</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card -->
                    <!-- Column -->


                </div>
                <!-- ============================================================== -->
                <!-- Info box -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Email campaign chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Candle Stick Chart</h4>
                                        <h5 class="card-subtitle">Money Exchange</h5>
                                    </div>
                                </div>
                                <div id="candlestickchart" style="height: 600px"></div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Email campaign chart -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
@endsection
