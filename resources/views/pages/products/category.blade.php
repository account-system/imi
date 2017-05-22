@extends('layouts.app')

@section('after_styles')
<style>
                
</style>
@endsection

@section('header')
    <section class="content-header">
      <h1>Category</h1>
      <ol class="breadcrumb">
        <li class="active">{{ config('app.name') }}</li>
        <li class="active">Product</li>
        <li class="active">Category</li>
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
      /*Item type data source*/
      var dataSource = new kendo.data.DataSource({
        transport: {
          read:  {
            url: crudBaseUrl + "/product/category/get",
            type: "GET",
            dataType: "json"
          },
          update: {
            url: crudBaseUrl + "/product/category/update",
            type: "POST",
            dataType: "json"
          },
          destroy: {
            url: crudBaseUrl + "/product/category/destroy",
            type: "POST",
            dataType: "json"
          },
          create: {
            url: crudBaseUrl + "/product/category/store",
            type: "POST",
            dataType: "json"
          },
          parameterMap: function(options, operation) {
              if (operation !== "read" && options.models) {
                  return {categories: kendo.stringify(options.models)};
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
              status: { field: "status", type: "string", defaultValue: "Enabled" },
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
          { name: "create" ,text: "Add New Category" },
          { template: kendo.template($("#textbox-multi-search").html()) } 
        ],
        columns: [
            { field: "name", title: "Name" },
            { field: "description", title: "Description"},
            { field: "status", title: "Status", values: statusDataSource },
            { field: "created_by", title: "Created By", template: "#= created_by == null ? '' : userColumn(created_by) #", filterable: { ui: userColumnFilter }, groupHeaderTemplate: "Created By: #= value == null ? '' : userColumn(value) #" },
            { field: "updated_by", title: "Modified By", template: "#= updated_by == null ? '' : userColumn(updated_by) #", filterable: { ui: userColumnFilter }, groupHeaderTemplate: "Modified By: #= value == null ? '' : userColumn(value) #" },
            { field: "created_at", title: "Created At", format: "{0:yyyy/MM/dd h:mm:ss tt}", filterable: { ui: dateTimePickerColumnFilter } },
            { field: "updated_at", title: "Modified At", format: "{0:yyyy/MM/dd h:mm:ss tt}", filterable: { ui: dateTimePickerColumnFilter } },
            { command: ["edit", "destroy"], title: "&nbsp;Action", menu: false }
        ],
        editable: { mode: "popup", window: { width: "600px" }, template: kendo.template($("#popup-editor-type").html()) },
        edit: function (e) {
          //Customize popup title and button label 
          if (e.model.isNew()) {
            e.container.data("kendoWindow").title('Add New Category');
            $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
          }
          else {
            e.container.data("kendoWindow").title('Edit Category');
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
