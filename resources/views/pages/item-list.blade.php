@extends('layouts.app')

@section('after_styles')
<style>

</style>
@endsection

@section('header')
  <section class="content-header">
    <h1>Category List</h1>
    <ol class="breadcrumb">
      <li class="active">{{ config('app.name') }}</li>
      <li class="active">Category List</li>
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

      /*category data source*/
      var categoriesDataSource  =   <?php echo json_encode($category) ?>;
      categoriesDataSource      =   JSON.parse(categoriesDataSource);

      /*Branch data source*/
      var branchDataSource      =   <?php echo json_encode($branches) ?>;
      branchDataSource          =   JSON.parse(branchDataSource);

      /*Country data source*/
      var countryDataSource     =   <?php echo json_encode($countries) ?>;
      countryDataSource         =   JSON.parse(countryDataSource);
      
      /*City data source*/
      var cityDataSource        =   <?php echo json_encode($cities) ?>;
      cityDataSource            =   JSON.parse(cityDataSource);

      /*category data source*/
      var gridDataSource = new kendo.data.DataSource({
        transport: {
          read: {
            url: crudBaseUrl + "/item-list/get",
            type: "GET",
            dataType: "json"
          },
          update: {
            url: crudBaseUrl + "/item-list/update",
            type: "POST",
            dataType: "json"
          },
          destroy: {
            url: crudBaseUrl + "/item-list/destroy",
            type: "POST",
            dataType: "json"
          },
          create: {
            url: crudBaseUrl + "/item-list/store",
            type: "POST",
            dataType: "json"
          },
          parameterMap: function (options, operation) {
            if (operation !== "read" && options.models) {
              return { models: kendo.stringify(options.models) };
            }
          }
      },
      batch: true,
      pageSize: 20,
      schema: {
        model: {
          id: "id",
          fields: {
            id: { 
              editable: false,
              nullable: true 
            },
            name: {
                  
            }, 
            category_type_id: { 
              field: "category_type_id", 
              type: "number",
            },
            barcode: {

            },
            stock_in: {

            },
            stock_out: {

            },
            detail: {

            },
            status: { 
              field: "status", 
              type: "string",
              defaultValue: "Enabled" 
            }                
          }
        }
      }
    });

  $("#grid").kendoGrid({
    dataSource: gridDataSource,
    navigatable: true,
    resizable: true,
    columnMenu: true,
    filterable: true,
    sortable: {
    mode: "single",
    allowUnsort: false
    },
    pageable: {
      refresh:true,
      pageSizes: true,
      buttonCount: 5
    },
    height: 550,
    toolbar: [
      { name: "create" },
      { template: kendo.template($("#textbox-multi-search").html()) }
    ],
    columns: [
      { field: "name",title: "Name" },
      { field: "category_type_id", title: "Type", values: categoriesDataSource },
      { field: "barcode",title: "Barcode" },
      { field:"stock_in",title: "Stock In"},
      { field: "stock_out",title: "StockOut" },
      { field: "detail",title: "Detail", hidden: true },
      { field: "status", title: "Status", values: statusDataSource, hidden: true },
      { command: ["edit", "destroy"], title: "Action", menu: false }
    ],
    editable: {
      mode: "popup",
      window: {
        width: "600px"   
      },
      template: kendo.template($("#popup-editor-vedor").html())
    },
    edit: function (e) {
      ///Call function  init dropdownlists
      initDropDownLists();

      //Customize popup title and button label 
      if (e.model.isNew()) {
        e.container.data("kendoWindow").title('Add New Item');
        $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
      }
      else {
        e.container.data("kendoWindow").title('Edit Item');
      }
    } 
  }); 

  /*Event response to key up in textbox multi search*/
  $("#txtMultiSearch").keyup(function(e){
     
    var q = $('#txtMultiSearch').val();

    $("#grid").data("kendoGrid").dataSource.filter({
      logic  : "or",
      filters: [
        {
          field   : "name",
          operator: "contains",
          value   : q
        },
        {
          field   : "category_type_id",
          operator: "contains",
          value   : q
        },
        {
          field   : "barcode",
          operator: "contains",
          value   : q
        },
        {
          field   : "stock_in",
          operator: "contains",
          value   : q
        }, 
        {
          field   : "stock_out",
          operator: "content",
          value   : q
        },
        {
          field   : "detail",
          operator: "contains",
          value   : q
        },
        {
          field   : "status",
          operator: "eq",
          value   : q
        }
      ]
    });  
  });
});

/*Initailize all dropdownlist*/  
function initDropDownLists(){
  $("#category").kendoDropDownList({
    optionLabel: "Select category type...",
    dataValueField: "value",
    dataTextField: "text",
    dataSource: {
      transport: {
        read: {
          url: crudBaseUrl+"/categories-list/list/filter",
          type: "GET",
          dataType: "json"
        }
      }
    }
  }); 
  /*Initailize branch dropdownlist*/
  initBranchDropDownList();

  /*Initailize country dropdownlist*/
  initCountryDropDownList();

  /*Initailize city dropdownlist*/
  initCityDropDownList();

  /*Initailize status dropdownlist*/
  initStatusDropDownList();


}

</script>

<!-- Customize popup editor employee --> 
<script type="text/x-kendo-template" id="popup-editor-vedor">
    
  <div class="col-6">
    <label for="name">Name</label>
    <input type="text" class="k-textbox" name="name" placeholder="Enter name" data-bind="value:name" required data-max-msg="Enter value max 60 string" style="width: 100%;"/>
  </div>

  <div class="col-6">
      <label for="category_type_id">Type</label>
      <input id="category" name="category_type_id" data-bind="value:category_type_id" required data-required-msg="The field category is required" style="width: 100%;" />
  </div> 
  
  <div class="col-6">
    <label for="barcode">Barcode</label>
    <input type="text" class="k-textbox" name="barcode" placeholder="Enter barcode" data-bind="value:barcode" style="width: 100%;"/>
  </div>
  
  <div class="col-6">
    <label for="stock_in">Stock In</label>
    <input type="text" class="k-textbox" name="stock_in" placeholder="Enter stock in" data-bind="value:stock_in" style="width: 100%;"/>
  </div>  

  <div class="col-6">
    <label for="stock_out">Stock Out</label>
    <input type="text" class="k-textbox" name="stock_out" placeholder="Enter stock out" data-bind="value:stock_out" style="width: 100%;"/>
  </div>  
  
  <div class="col-12">
    <label for="detail">Detail</label>
    <textarea class="k-textbox" name="detail" placeholder="Enter Detail" data-bind="value:detail" style="width: 100%;"/></textarea> 
  </div>

  <div class="col-6">
      <label for="status">Status</label>
      <input id="status" data-bind="value:status"  style="width: 100%;" />
  </div>

</script>  

@endsection