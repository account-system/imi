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

    /*Country data source*/
    var countryDataSource     =   <?php echo json_encode($countries) ?>;
    countryDataSource         =   JSON.parse(countryDataSource);

    /*City data source*/
    var cityDataSource        =   <?php echo json_encode($cities) ?>;
    cityDataSource            =   JSON.parse(cityDataSource);

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
              id: { editable: false, nullable: true },
              company_name: { 
                type: "string",
                validation: {
                  required: true,
                  companyNameValidation: function (input) {
                      if (input.is("[name='company_name']") && input.val() != "") {
                          input.attr("data-company_namevalidation-msg", "Company name should start with capital letter");
                          return /^[A-Z]/.test(input.val());
                      }
                      return true;
                  },
                  maxlength:function(input) { 
                    if (input.is("[name='name']") && input.val().length > 60) {
                       input.attr("data-maxlength-msg", "Max length is 60");
                       return false;
                    }                                   
                    return true;
                  }
                } 
              },
              name: { type: "string" },
              product_type_id: { type: "number" },
              barcode: { type: "string" },
              price_in: { type: "string" },
              price_out: { type: "string" },
              quantity: { type: "string" },      
              detail: { type: "string", nullable: true },   
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
        toolbar: [ { name: "create" }, { template: kendo.template($("#textbox-multi-search").html()) } ],
        columns: [
          { field: "name", title: "Name" },
          { field: "product_type_id", title: "Type", values: productTypesDataSource, },
          { field: "barcode",title: "Barcode" },
          { field: "price_in",title: "Price In" },
          { field: "price_out",title: "price Out" ,hidden: true },
          { field: "quantity",title: "Quantity" ,hidden: true },
          { field: "detail",title: "Detail" ,hidden: true },
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
            { field: "name", operator: "contains", value: q },
            { field: "product_type_id", operator: "eq", value: q },
            { field: "barcode", operator: "contains", value: q },
            { field: "price_in", operator: "contains", value: q }, 
            { field: "price_out", operator: "eq", value: q },
            { field: "quantity", operator: "eq", value: q },
            { field: "detail", operator: "contains", value: q },
            { field: "status", operator: "eq", value: q }
          ]
        });
      });
    });

    /*Initialize all dropdownlist*/  
    function initDropDownLists(){
      /*Initialize gender dropdownlist*/
      initGenderDropDownList();

      /*Initialize product type dropdownlist*/
      $("#productTypes").kendoDropDownList({
        optionLabel: "Select type...",
        dataValueField: "value",
        dataTextField: "text",
        dataSource: {
          transport: {
            read: {
              url: crudBaseUrl+"/product/type/list/filter",
              type: "GET",
              dataType: "json"
            }
          }
        }
      });

      /*Initialize branch dropdownlist*/
      initBranchDropDownList();

      /*Initialize country dropdownlist*/
      initCountryDropDownList();

      /*Initialize city dropdownlist*/
      initCityDropDownList();

      /*Initialize status dropdownlist*/
      initStatusDropDownList();
    }
  </script>

  <!-- Customize popup editor product --> 
  <script type="text/x-kendo-template" id="popup-editor-vedor">
    <div class="row-12">
      <div class="row-6">
        <div class="col-12">
          <label for="name">Name</label>
          <input type="text" name="name" class="k-textbox" placeholder="Enter product name" data-bind="value:name" required data-required-msg="The product name field is required" pattern=".{1,60}" validationMessage="The product name may not be greater than 60 characters" style="width: 100%;"/>   
        </div>

        <div class="col-12">
          <label for="product_type_id">Type</label>
          <input id="productTypes" name="product_type_id" data-bind="value:product_type_id" required data-required-msg="The type field is required" style="width: 100%;" />
        </div> 
        
        <div class="col-12">
          <label for="barcode">Barcode</label>
          <input type="text" class="k-textbox" name="barcode" placeholder="Enter barcode" data-bind="value:barcode" pattern=".{0,30}" validationMessage="The Region may not be greater than 30 characters" style="width: 100%;"/>
        </div>
        
        <div class="col-12">
          <label for="price_in">Price In</label>
          <input type="string" class="k-textbox" name="price_in" data-bind="value:price_in" placeholder="Enter price in"  required data-required-msg="The price in is required" pattern="^[0-9\ \]{9,13}$" placeholder="Enter price in" validationMessage="price in format is not valid" style="width: 100%;"/>
        </div>

        <div class="col-12">
          <label for="price_out">Price Out</label>
          <input type="string" class="k-textbox" name="price_out" data-bind="value:price_out" placeholder="Enter price out"  required data-required-msg="The price out is required" pattern="^[0-9\ \]{9,13}$" placeholder="Enter price out" validationMessage="price out format is not valid" style="width: 100%;"/>
        </div>
        
        <div class="col-12">
          <label for="quantity">Quantity</label>
          <input type="string" class="k-textbox" name="quantity" data-bind="value:quantity" placeholder="Enter quantity"  required data-required-msg="The quantity is required" pattern="^[0-9\ \]{9,13}$" placeholder="Enter quantity" validationMessage="quantity format is not valid" style="width: 100%;"/>
        </div>

        <div class="col-12">
          <label for="detail">Detail</label>
          <textarea class="k-textbox" name="detail" placeholder="Enter detail" data-bind="value:detail" pattern=".{0,200}" validationMessage="The detail may not be greater than 200 characters" style="width: 100%; height: 97px;"/></textarea> 
        </div>

        <div class="col-12">
          <label for="status">Status</label>
          <input id="status" data-bind="value:status"  style="width: 100%;" />
        </div> 
      </div>
    </div>
  </script>  

@endsection