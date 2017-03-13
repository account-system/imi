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

                  <!-- ======= section 2 =================================================== -->
                  <div id="example">

                      <div id="grid"></div>  

                  </div>

                  </div><!-- /box-body-->
                </div><!-- /box box-default-->
            </div>
        </div>
   
@endsection
@section('after_scripts')
  
   <script>
    $(document).ready(function () {
      var crudServiceBaseUrl = "https://demos.telerik.com/kendo-ui/service",
        dataSource = new kendo.data.DataSource({
        transport: {
        read:  {
          url: crudServiceBaseUrl + "/Products",
          dataType: "jsonp"
        },
        update: {
          url: crudServiceBaseUrl + "/Products/Update",
          dataType: "jsonp"
        },
        destroy: {
          url: crudServiceBaseUrl + "/Products/Destroy",
          dataType: "jsonp"
        },
        create: {
          url: crudServiceBaseUrl + "/Products/Create",
          dataType: "jsonp"
        },
        parameterMap: function(options, operation) {
          if (operation !== "read" && options.models) {
            return {models: kendo.stringify(options.models)};
            }
          }
        },
          batch: true,
          pageSize: 20,
          schema: {
             model: {
                id: "ProductID",
                fields: {
                ProductID: { editable: false, nullable: true },
                ProductName: { validation: { required: true } },
                UnitPrice: { type: "number", validation: { required: true, min: 1} },
                Discontinued: { type: "boolean" },
                UnitsInStock: { type: "number", validation: { min: 0, required: true } }
              }
            }
          }
        });

        $("#grid").kendoGrid({
                  dataSource: dataSource,
                  navigatable: true,
                  pageable: true,
                  height: 550,
                  toolbar: ["create", "save", "cancel"],
                  columns: [
                            "ProductName",
                            { field: "UnitPrice", title: "Unit Price", format: "{0:c}", width: 120 },
                            { field: "UnitsInStock", title: "Units In Stock", width: 120 },
                            { field: "test", width: 120 },
                            { field: "test1", width: 120 },
                            { field: "Discontinued", width: 120 },
                            { command: "destroy", title: "&nbsp;", width: 150 }],
                        editable: true
        });
      });
  </script>    

@endsection

@section('after_scripts')
<script>
   
</script>
@endsection
