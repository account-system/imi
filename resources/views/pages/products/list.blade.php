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
    /*Product type data source*/
    var productTypesDataSource  =   <?php echo json_encode($productTypes) ?>;
    productTypesDataSource      =   JSON.parse(productTypesDataSource);

    /*Branch data source*/
    var branchDataSource      =   <?php echo json_encode($branches) ?>;
    branchDataSource          =   JSON.parse(branchDataSource);


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
              unit_sale_price: { type: "number" },
              quantity: { type: "number" },
              quantity_per_unit: { type: "string", nullable: true },
              discontinue: { type: "number" ,defaultValue: 0},      
              description: { type: "string", nullable: true },  
              branch_id: { type: "number" }, 
              status: { type: "string", defaultValue: "Enabled" }                
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
        pageable: { refresh:true, pageSizes: true, buttonCount: 5 },
        height: 550,
        toolbar: [ { name: "create", text: "Add New Product" }, { template: kendo.template($("#textbox-multi-search").html()) } ],
        columns: [
          { field: "code", title: "Code" },
          { field: "name",title: "Name" },
          { field: "category_id", title: "Category", values: productTypesDataSource, },
          { field: "unit_price",title: "Unit Price" ,format: "{0:c}" },
          { field: "unit_sale_price",title: "Unit Sale Price",format: "{0:c}" },
          { field: "quantity",title: "Quantity" },
          { field: "quantity_per_unit",title: "Quantity Per Unit" },
          { field: "discontinue",title: "Discontinue", values: discontinueDataSource ,hidden: true },
          { field: "description",title: "Description" ,hidden: true },
          { field: "branch_id",title: "Branch", values: branchDataSource ,hidden: true },
          { field: "status", title: "Status", values: statusDataSource ,hidden: true },
          { command: ["edit", "destroy"], title: "&nbsp;Action", menu: false }
        ],
        editable: { mode: "popup", window: { width: "600px" }, template: kendo.template($("#popup-editor-vedor").html()) },
        edit: function (e) {
          //Call function  init dropdownlists
          initDropDownLists();
        
          //Customize popup title and button label 
          if (e.model.isNew()) {
            e.container.data("kendoWindow").title('Add New Product');
            $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
          }
          else {
            e.container.data("kendoWindow").title('Edit Product');
          }
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
            { field: "unit_price", operator: "contains", value: q },
            { field: "unit_sale_price", operator: "contains", value: q }, 
            { field: "quantity", operator: "contains", value: q },
            { field: "quantity_per_unit", operator: "contains", value: q },
            { field: "discontinue", operator: "eq", value: q },
            { field: "description", operator: "contains", value: q },
            { field: "branh_id", operator: "eq", value: q },
            { field: "status", operator: "eq", value: q }
          ]
        });
      });
    });

    /*Initialize all dropdownlist*/  
    function initDropDownLists(){
      /*Initialize category dropdownlist*/
      $("#category").kendoDropDownList({
        optionLabel: "Select category...",
        dataValueField: "value",
        dataTextField: "text",
        dataSource: {
          transport: {
            read: {
              url: crudBaseUrl+"/product/category/list/filter",
              type: "GET",
              dataType: "json"
            }
          }
        }
      });

      /*Initialize discontinue dropdownlist*/ 
      initDiscontinueDropDownList();

      /*Initialize branch dropdownlist*/
      initBranchDropDownList();

      /*Initialize status dropdownlist*/
      initStatusDropDownList();
    }
  </script>

  <!-- Customize popup editor product --> 
  <script type="text/x-kendo-template" id="popup-editor-vedor">
    <div class="row-12">
      <div class="row-6">
        <div class="col-12">
          <label for="code">Code</label>
            <input type="text" name="code" class="k-textbox" placeholder="Enter product code" data-bind="value:code" required data-required-msg="The product code field is required" pattern=".{1,60}" validationMessage="The product code may not be greater than 60 characters" style="width: 100%;"/>   
        </div>

        <div class="col-12">
          <label for="name">Name</label>
            <input type="text" name="name" class="k-textbox" placeholder="Enter product name" data-bind="value:name" required data-required-msg="The product name field is required" pattern=".{1,60}" validationMessage="The product name may not be greater than 60 characters" style="width: 100%;"/>   
        </div>

        <div class="col-12">
          <label for="category_id">Category</label>
          <input id="category" name="category_id" data-bind="value:category_id" required data-required-msg="The category field is required" style="width: 100%;" />
        </div> 
        
        <div class="col-12">
          <label for="unit_price">Unit Price</label>
          <input type="number" class="k-textbox" name="unit_price" placeholder="Enter unit price" data-bind="value:unit_price" pattern=".{1,10}" validationMessage="The unit price may not be greater than 30 characters" style="width: 100%;"/>
        </div>
        
        <div class="col-12">
          <label for="unit_sale_price">Unit Sale Price</label>
          <input type="number" class="k-textbox" name="unit_sale_price" data-bind="value:unit_sale_price" placeholder="Enter unit sale price" pattern=".{1,10}" placeholder="Enter unit sale price" validationMessage="unit sale price format is not valid" style="width: 100%;"/>
        </div>

        <div class="col-12">
          <label for="quantity">Quantity</label>
          <input type="number" class="k-textbox" name="quantity" data-bind="value:quantity" placeholder="Enter quantity"  required data-required-msg="The quantity is required" pattern=".{1,10}" placeholder="Enter quantity" validationMessage="quantity format is not valid" style="width: 100%;"/>
        </div>
      </div>
      <div class="col-6">
        <div class="col-12">
          <label for="quantity_per_unit">Quantity Per Unit</label>
          <input type="string" class="k-textbox" name="quantity_per_unit" data-bind="value:quantity_per_unit" placeholder="Enter quantity per unit" pattern=".{0,60}" placeholder="Enter quantity per unit" validationMessage="quantity per unit format is not valid" style="width: 100%;"/>
        </div>
        
        <div class="col-12">
          <label for="discontinue">Discontinue</label>
          <input id="discontinue" data-bind="value:discontinue"  style="width: 100%;" />
        </div> 

        <div class="col-12">
          <label for="description">Description</label>
          <textarea class="k-textbox" name="description" placeholder="Enter description" data-bind="value:description" maxlength="200" style="width: 100%; height: 97px;"/></textarea> 
        </div>
        
        <div class="col-12">
          <label for="branch_id">Branch</label>
          <input id="branch" name="branch_id" data-bind="value:branch_id" required data-required-msg="The branch field is required" style="width: 100%;" />
        </div>

        <div class="col-12">
          <label for="status">Status</label>
          <input id="status" data-bind="value:status"  style="width: 100%;" />
        </div> 
      </div>
    </div>
  </script>  

@endsection