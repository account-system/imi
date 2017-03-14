@extends('layouts.app')

@section('header')
    <section class="content-header">
      <h1>Dashboard
        <small>The first page you see after login</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('') }}">{{ config('app.name') }}</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
@endsection

@section('content')
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default">
          <div class="box-header with-border">
            <div class="box-title">Login status</div>
          </div>

          <div class="box-body">
            <div class="row">

            <!-- ======= start small box 1 =========================== -->
              <div class="col-lg-3 col-sx-6">
                <div class="small-box bg-aqua">
                  <div class="inner">
                    <h3>150</h3>
                    <p>Cusomter</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <!-- ======== start small box 2 ========================= -->
              <div class="col-lg-3 col-sx-6">
                <div class="small-box bg-green">
                  <div class="inner">
                   <h3>53<sup style="font-size: 20px">%</sup></h3>
                      <p>Bounce Rate</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <!-- ======== start small box 3 ========================= -->
              <div class="col-lg-6 col-sx-6">
                <div class="small-box bg-yellow">
                  <div class="inner">
                   <h3>53<sup style="font-size: 20px">%</sup></h3>
                      <p>Chart of account</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div><!-- /row-->

          </div><!-- /box-body-->
        </div><!-- /box box-default-->
      </div>
    </div>   
@endsection

@section('after_scripts')
  <script>
    
  </script>    
@endsection
