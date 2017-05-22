@extends('layouts.app')

@section('after_styles')
<style>

</style>
@endsection

@section('header')
  <section class="content-header">
    <h1>Product List</h1>
    <ol class="breadcrumb">
      <li class="active">{{ config('app.name') }}</li>
      <li class="active">Product</li>
      <li class="active">Product List</li>
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
    /*Category data source*/
    var categoryDataSource  =   JSON.parse(<?php echo json_encode($categories) ?>); 

    /*Branch data source*/
    var branchDataSource    =   JSON.parse(<?php echo json_encode($branches) ?>);

    /*user data source*/
    var userDataSource      =   JSON.parse(<?php echo json_encode($users) ?>);

    $(document).ready(function () {
      /*Product data source*/
      var gridDataSource = new kendo.data.DataSource({
        transport: {
          read: {
            url: crudBaseUrl + "/product/get",
            type: "GET",
            dataType: "json"
          },
          update: {
            url: crudBaseUrl + "/product/update",
            type: "POST",
            dataType: "json"
          },
          destroy: {
            url: crudBaseUrl + "/product/destroy",
            type: "POST",
            dataType: "json"
          },
          create: {
            url: crudBaseUrl + "/product/store",
            type: "POST",
            dataType: "json"
          },
          parameterMap: function (options, operation) {
            if (operation !== "read" && options.models) {
              return { products: kendo.stringify(options.models) };
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
              code: { type: "string", nullable: true },
              name: { type: "string" },
              category_id: { type: "number" },
              unit_price: { type: "number" },
              sale_price: { type: "number" },
              quantity: { type: "number" },
              quantity_per_unit: { type: "string", nullable: true },
              discontinue: { type: "boolean" ,defaultValue: false},      
              description: { type: "string", nullable: true },  
              branch_id: { type: "number" }, 
              status: { type: "string", defaultValue: "Enabled" },
              created_by: { type: "number", editable: false, nullable: true }, 
              updated_by: { type: "number", editable: false, nullable: true },
              created_at: { type: "date", editable: false, nullable: true }, 
              updated_at: { type: "date", editable: false, nullable: true }                      
            }
          }
        }
      });

      $("#grid").kendoGrid({
        dataSource: gridDataSource,
        navigatable: true,
        reorderable: true,
        resizable: true,
        columnMenu: true,
        filterable: true,
        sortable: { mode: "single", allowUnsort: false },
        pageable: { refresh: true, pageSizes: true, buttonCount: 5 },
        height: 550,
        toolbar: [ 
          { name: "create", text: "Add New Product" },
          { name: "excel", text: "Export to Excel" }, 
          { template: kendo.template($("#textbox-multi-search").html()) } 
        ],
        excel: {
          fileName: "Product Report.xlsx",
          filterable: true
        },
        columns: [
          { field: "code", title: "Code" },
          { field: "name",title: "Name" },
          { field: "category_id", title: "Category", values: categoryDataSource },
          { field: "unit_price", title: "Unit Price", format: "{0:c}" },
          { field: "sale_price", title: "Sale Price", format: "{0:c}" },
          { field: "quantity", title: "Quantity" },
          { field: "quantity_per_unit", title: "Quantity Per Unit", hidden: true},
          { field: "discontinue", title: "Discontinue", values: booleanDataSource },
          { field: "description", title: "Description", hidden: true },
          { field: "branch_id", title: "Branch", values: branchDataSource, hidden: true },
          { field: "status", title: "Status", values: statusDataSource, hidden: true },
          { field: "created_by", title: "Created By", hidden: true, template: "#= created_by == null ? '' : userColumn(created_by) #", filterable: { ui: userColumnFilter } },
          { field: "updated_by", title: "Modified By", hidden: true, template: "#= updated_by == null ? '' : userColumn(updated_by) #", filterable: { ui: userColumnFilter } },
          { field: "created_at", title: "Created At", format: "{0:yyyy/MM/dd h:mm:ss tt}", filterable: { ui: dateTimePickerColumnFilter }, hidden: true },
          { field: "updated_at", title: "Modified At", format: "{0:yyyy/MM/dd h:mm:ss tt}", filterable: { ui: dateTimePickerColumnFilter }, hidden: true },
          { command: ["edit", "destroy"], title: "&nbsp;Action", menu: false }
        ],
        editable: { mode: "popup", window: { width: "600px" }, template: kendo.template($("#popup-editor-product").html()) },
        edit: function (e) {
          //Customize popup title and button label 
          if (e.model.isNew()) {
            e.container.data("kendoWindow").title('Add New Product');
            $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
          }
          else {
            e.container.data("kendoWindow").title('Edit Product');
          }

          //Call function  init form controll
          initFormControll();
        } 
      }); 

      /*Event response to key up in textbox multi search*/
      $("#txtMultiSearch").keyup(function(e){  
        var q = $('#txtMultiSearch').val();
        $("#grid").data("kendoGrid").dataSource.filter({
          logic  : "or",
          filters: [
            { field: "code", operator: "contains", value: q },
            { field: "name", operator: "contains", value: q },
            { field: "category_id", operator: "eq", value: q },
            { field: "unit_price", operator: "eq", value: q },
            { field: "sale_price", operator: "eq", value: q }, 
            { field: "quantity", operator: "eq", value: q },
            { field: "quantity_per_unit", operator: "contains", value: q },
            { field: "discontinue", operator: "eq", value: q },
            { field: "description", operator: "contains", value: q },
            { field: "branh_id", operator: "eq", value: q },
            { field: "status", operator: "eq", value: q }
          ]
        });
      });
      
    });

    /*Initialize all form controller*/  
    function initFormControll(){
      /*Initialize category dropdownlist*/
      $("#type").kendoDropDownList({
        optionLabel: "--Select category--",
        dataValueField: "value",
        dataTextField: "text",
        dataSource: {
          transport: {
            read: {
              url: crudBaseUrl + "/product/category/list/filter",
              type: "GET",
              dataType: "json"
            }
          }
        }
      });

      /*Initialize unit price NumericTextBox*/
      $("#unitPrice").kendoNumericTextBox({
          placeholder: "--Select a value--",
          format: "c",
          min: 0,
          max: 99999999.99,
          decimals: 2,
          round: false
      });

      /*Initialize sale price NumericTextBox*/
      $("#salePrice").kendoNumericTextBox({
          placeholder: "--Select a value--",
          format: "c",
          min: 0,
          max: 99999999.99,
          decimals: 2,
          round: false
      });

      /*Initialize quantity NumericTextBox*/
      $("#quantity").kendoNumericTextBox({
          placeholder: "--Select a value--",
          format: "0",
          decimals: 0,
          min: 0,
          max: 99999999,
      });

      /*Initialize discontinue dropdownlist*/ 
      $("#discontinue").kendoDropDownList({
        dataValueField: "value",
        dataTextField: "text",
        dataSource: booleanDataSource  
      });

      /*Initialize branch dropdownlist*/
      initBranchDropDownList();

      /*Initialize status dropdownlist*/
      initStatusDropDownList();
    }

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

  <!-- Customize popup editor product --> 
  <script type="text/x-kendo-template" id="popup-editor-product">
    <div class="row-12">
      <div class="row-6">
        <div class="col-12">
          <label for="code">Code</label>
            <input type="text" name="code" class="k-textbox" data-bind="value:code"  pattern=".{0,60}" validationMessage="The code may not be greater than 60 characters" style="width: 100%;"/>   
        </div>

        <div class="col-12">
          <label for="name">Name</label>
            <input type="text" name="name" class="k-textbox" data-bind="value:name" required data-required-msg="The name field is required" pattern=".{1,60}" validationMessage="The name may not be greater than 60 characters" style="width: 100%;"/>   
        </div>

        <div class="col-12">
          <label for="category_id">Category</label>
          <input id="type" name="category_id" data-bind="value:category_id" required data-required-msg="The type field is required" style="width: 100%;" />
        </div> 
        
        <div class="col-12">
          <label for="unit_price">Unit Price</label>
          <input id="unitPrice" type="number" name="unit_price" data-bind="value:unit_price" required data-required-msg="The unit price field is required" style="width: 100%;"/>
        </div>
        
        <div class="col-12">
          <label for="sale_price">Sale Price</label>
          <input id="salePrice" type="number" name="sale_price" data-bind="value:sale_price" required data-required-msg="The sale price field is required" style="width: 100%;"/>
        </div>

        <div class="col-12">
          <label for="quantity">Quantity</label>
          <input id="quantity" type="number" name="quantity" data-bind="value:quantity" required data-required-msg="The quantity field is required" style="width: 100%;"/>
        </div>
      </div>
      <div class="row-6">
        <div class="col-12">
          <label for="quantity_per_unit">Quantity Per Unit</label>
          <input type="text" class="k-textbox" name="quantity_per_unit" data-bind="value:quantity_per_unit" pattern=".{0,60}" validationMessage="The quantity per unit may not be greater than 60 characters" style="width: 100%;"/>
        </div>
        
        <div class="col-12">
          <label for="discontinue">Discontinue</label>
          <input id="discontinue" name="discontinue" data-bind="value:discontinue"  style="width: 100%;" />
        </div> 

        <div class="col-12">
          <label for="description">Description</label>
          <textarea class="k-textbox" name="description" data-bind="value:description" maxlength="200" style="width: 100%; height: 97px;"/></textarea> 
        </div>
        
        <div class="col-12">
          <label for="branch_id">Branch</label>
          <input id="branch" name="branch_id" data-bind="value:branch_id" required data-required-msg="The branch field is required" style="width: 100%;" />
        </div>

        <div class="col-12">
          <label for="status">Status</label>
          <input id="status" name="status" data-bind="value:status"  style="width: 100%;" />
        </div> 
      </div>
    </div>
  </script>  

@endsection