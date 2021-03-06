@extends('layouts.app')

@section('after_styles')
  <style>
  
  </style>
@endsection

@section('header')
    <section class="content-header">
      <h1>Employee Type</h1>
      <ol class="breadcrumb">
        <li class="active">{{ config('app.name') }}</li>
        <li class="active">Employee</li>
        <li class="active">Employee Type</li>
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
    /*user data source */
    var userDataSource = JSON.parse(<?php echo json_encode($users) ?>);

    $(document).ready(function () {
      /*Employee type data source*/
      var dataSource = new kendo.data.DataSource({
        transport: {
          read:  {
            url: crudBaseUrl + "/employee/type/get",
            type: "GET",
            dataType: "json"
          },
          update: {
            url: crudBaseUrl + "/employee/type/update",
            type: "Post",
            dataType: "json"
          },
          destroy: {
            url: crudBaseUrl + "/employee/type/destroy",
            type: "Post",
            dataType: "json"
          },
          create: {
            url: crudBaseUrl + "/employee/type/store",
            type: "Post",
            dataType: "json"
          },
          parameterMap: function(options, operation) {
            if (operation !== "read" && options.models) {
              return {employees: kendo.stringify(options.models)};
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
        reorderable: true,
        resizable: true,
        columnMenu: true,
        filterable: true,
        sortable: { mode: "single", allowUnsort: false },
        pageable: { refresh: true, pageSizes: true, buttonCount: 5 },
        height: 550,
        toolbar: [ 
          { name: "create", text: "Add New Employee Type" }, 
          { template: kendo.template($("#textbox-multi-search").html()) } 
        ],
        columns: [
          { field:"name", title: " Name" },
          { field: "description", title: " Description"},
          { field: "status", values: statusDataSource, title: "Status" },
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
            e.container.data("kendoWindow").title('Add New Employee Type');
            $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
          }
          else {
            e.container.data("kendoWindow").title('Edit Employee Type');
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

    /*Display text of created by or modified by foriegnkey column*/
    function userColumn(userId) {
      for (var i = 0; i < userDataSource.length; i++) {
        if (userDataSource[i].id == userId) {
          return userDataSource[i].username;
        }
      }
    }

    /*Created by and modified by foriegnkey column filter*/
    function userColumnFilter(element) {
      element.kendoDropDownList({
        valuePrimitive: true,
        optionLabel: "--Select Value--",
        dataValueField: "id",
        dataTextField: "username",
        dataSource: { data: userDataSource, group: 'role' }
      });
    }

    /*datetimepicker column filter*/
    function dateTimePickerColumnFilter(element) {
      element.kendoDateTimePicker({
        format: "{0: yyyy/MM/dd HH:mm:ss tt}",
      });
    } 
  </script>   
@endsection
