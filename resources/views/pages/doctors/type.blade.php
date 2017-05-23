@extends('layouts.app')

@section('after_styles')
  <style>

  </style>
@endsection

@section('header')
    <section class="content-header">
      <h1>Doctor Type</h1>
      <ol class="breadcrumb">
        <li class="active">{{ config('app.name') }}</li>
        <li class="active">Doctor</li>
        <li class="active">Doctor Type</li>
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
    /*user data source*/
    var userDataSource = JSON.parse(<?php echo json_encode($users) ?>);

    $(document).ready(function () {
      /*Doctor type data source*/
      var dataSource = new kendo.data.DataSource({
        transport: {
          read:  {
            url: crudBaseUrl + "/doctor/type/get",
            type: "GET",
            dataType: "json"
          },
          update: {
            url: crudBaseUrl + "/doctor/type/update",
            type: "POST",
            dataType: "json"
          },
          destroy: {
            url: crudBaseUrl + "/doctor/type/destroy",
            type: "POST",
            dataType: "json"
          },
          create: {
            url: crudBaseUrl + "/doctor/type/store",
            type: "POST",
            dataType: "json"
          },
          parameterMap: function(options, operation) {
            if (operation !== "read" && options.models) {
              return {doctors: kendo.stringify(options.models)};
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
              status: { type: "string", defaultValue: "Active" },
              created_by: { type: "number", editable: false, nullable: true }, 
              updated_by: { type: "number", editable: false, nullable: true },
              created_at: { type: "date", editable: false, nullable: true }, 
              updated_at: { type: "date", editable: false, nullable: true }                      
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
          { name: "create", text: "Add New Doctor Type" },
          { template: kendo.template($("#textbox-multi-search").html()) }
        ],
        columns: [
          { field: "name", title: "Name" },
          { field: "description", title: "Description" },
          { field: "status", title: "Status", values: statusDataSource },
          { field: "created_by", title: "Created By", values: userDataSource },
          { field: "updated_by", title: "Modified By", values: userDataSource },
          { field: "created_at", title: "Created At", format: "{0:yyyy/MM/dd h:mm:ss tt}", filterable: { ui: dateTimePickerColumnFilter } },
          { field: "updated_at", title: "Modified At", format: "{0:yyyy/MM/dd h:mm:ss tt}", filterable: { ui: dateTimePickerColumnFilter } },
          { command: ["edit", "destroy"], title: "&nbsp;Action", menu: false }
        ],
        editable:{ mode: "popup", window: { width: "600px" }, template: kendo.template($("#popup-editor-type").html()) },
        edit: function (e) {
          //Customize popup title and button label 
          if (e.model.isNew()) {
            e.container.data("kendoWindow").title('Add New Doctor Type');
            $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
          }
          else {
            e.container.data("kendoWindow").title('Edit Doctor Type');
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
