@extends('layouts.app')

@section('after_styles')
  <style>
  
  </style>s
@endsection

@section('header')
    <section class="content-header">
      <h1>Setup Branch</h1>
      <ol class="breadcrumb">
        <li class="active">{{ config('app.name') }}</li>
        <li class="active">Setup Data</li>
        <li class="active">Setup Branch</li>
      </ol>
    </section>
@endsection

@section('content')
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default">
          <div class="box-body">
            <div id="grid"></div>
          </div>
        </div>
      </div>
    </div>   
@endsection

@section('after_scripts')
  <script>
    $(document).ready(function () {
      /*Branch data source*/
      var dataSource = new kendo.data.DataSource({
        transport: {
          read:  {
            url: crudBaseUrl + "/branch/get",
            type: "GET",
            dataType: "json"
          },
          update: {
            url: crudBaseUrl + "/branch/update",
            type: "POST",
            dataType: "json"
          },
          destroy: {
            url: crudBaseUrl + "/branch/destroy",
            type: "POST",
            dataType: "json"
          },
          create: {
            url: crudBaseUrl + "/branch/store",
            type: "POST",
            dataType: "json"
          },
          parameterMap: function(options, operation) {
            if (operation !== "read" && options.models) {
                return {branches: kendo.stringify(options.models)};
            }
          }
        },
        batch: true,
        pageSize: 20,
        schema: {
          model: {
            id: "id",
            fields: {
              id: { editable: false, nullable: true },
              name: { type: "string" },  
              description: { type: "string", nullable: true },
              status: { type: "string", defaultValue: "Enabled" }                      
            }
          }
        }
      });

      $("#grid").kendoGrid({
        dataSource: dataSource,
        navigatable: true,
        resizable: true,
        reorderable: true,
        columnMenu: true,
        filterable: true,
        sortable: { mode: "single", allowUnsort: false },
        pageable: { refresh: true, pageSizes: true, buttonCount: 5 },
        height: 550,
        toolbar: [ 
          { name: "create", text: "Add New Branch" }, 
          { template: kendo.template($("#textbox-multi-search").html()) } 
        ],
        columns: [
          { field: "name", title: " Name" },
          { field: "description", title: " Description" },
          { field: "status", title: "Status", values: statusDataSource },
          { command: ["edit", "destroy"], title: "&nbsp;Action", menu: false }
        ],
        editable:{ mode: "popup", window: { width: "600px" }, template: kendo.template($("#popup-editor-type").html()) },
        edit: function (e) {
          //Customize popup title and button label 
          if (e.model.isNew()) {
            e.container.data("kendoWindow").title('Add New Branch');
            $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
          }
          else {
            e.container.data("kendoWindow").title('Edit Branch');
          }
          /*Initialize status dropdownlist*/
          initStatusDropDownList();
        }  
      });

      $("#txtMultiSearch").keyup(function(e){
        var q = $('#txtMultiSearch').val();
        $("#grid").data("kendoGrid").dataSource.filter({
          logic  : "or",
          filters: [
            { field: "name", operator: "contains", value: q },
            { field: "description", operator: "contains", value: q },
            { field: "status", operator: "eq", value: q }
          ]
        });  
      });
    });
  </script>   
@endsection
