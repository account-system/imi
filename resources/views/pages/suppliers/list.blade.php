@extends('layouts.app')

@section('after_styles')
<style>

</style>
@endsection

@section('header')
  <section class="content-header">
    <h1>Supplier List</h1>
    <ol class="breadcrumb">
      <li class="active">{{ config('app.name') }}</li>
      <li class="active">Supplier List</li>
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
    /*Supplier type data source*/
    var supplierTypeDataSource  =   <?php echo json_encode($supplierType) ?>;
    supplierTypeDataSource      =   JSON.parse(supplierTypeDataSource);

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
      /*Supplier data source*/
      var gridDataSource = new kendo.data.DataSource({
        transport: {
          read: {
            url: crudBaseUrl + "/supplier/get",
            type: "GET",
            dataType: "json"
          },
          update: {
            url: crudBaseUrl + "/supplier/update",
            type: "POST",
            dataType: "json"
          },
          destroy: {
            url: crudBaseUrl + "/supplier/destroy",
            type: "POST",
            dataType: "json"
          },
          create: {
            url: crudBaseUrl + "/supplier/store",
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
              company_name: { type: "string" },
              contact_name: { type: "string" },
              contact_title: { type: "string" },
              gender: { type: "string" },
              supplier_type_id: { type: "number" },
              phone: { type: "string" },
              email: { type: "string", nullable: true },      
              country_id: { type: "number", nullable: true },   
              city_id: { type: "number", nullable: true },
              region: { type: "string", nullable: true },
              postal_code: { type: "string", nullable: true },
              address: { type: "string", nullable: true },
              detail: { type: "string", nullable: true },
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
        toolbar: [ { name: "create" ,text: "Add New Supplier" }, { template: kendo.template($("#textbox-multi-search").html()) } ],
        columns: [
          { field: "company_name", title: "Company Name" },
          { field: "contact_name", title: "Contact Name" },
          { field: "contact_title",title: "Contact Title"  },
          { field: "gender",title: "Gender", values: genderDataSource  },
          { field: "supplier_type_id", title: "Type", values: supplierTypeDataSource, hidden: true },
          { field: "phone",title: "Phone", hidden: true },
          { field: "email",title: "Email", hidden: true },
          { field: "country_id",title: "Country", values: countryDataSource ,hidden: true },
          { field: "city_id",title: "Province/City", values: cityDataSource ,hidden: true },
          { field: "region",title: "Region" ,hidden: true },
          { field: "postal_code",title: "Postal Code" ,hidden: true },
          { field: "address",title: "Address" ,hidden: true },
          { field: "detail",title: "Detail" ,hidden: true },
          { field: "branch_id", title: "Branch", values: branchDataSource, hidden: true },
          { field: "status", title: "Status", values: statusDataSource ,hidden: true },
          { command: ["edit", "destroy"], title: "&nbsp;Action", menu: false }
        ],
        editable: { mode: "popup", window: { width: "600px" }, template: kendo.template($("#popup-editor-vedor").html()) },
        edit: function (e) {
          //Call function  init dropdownlists
          initDropDownLists();
        
          //Customize popup title and button label 
          if (e.model.isNew()) {
            e.container.data("kendoWindow").title('Add New Supplier');
            $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
          }
          else {
            e.container.data("kendoWindow").title('Edit Supplier');
          }
        } 
      }); 

      /*Event response to key up in textbox multi search*/
      $("#txtMultiSearch").keyup(function(e){  
        var q = $('#txtMultiSearch').val();
        $("#grid").data("kendoGrid").dataSource.filter({
          logic  : "or",
          filters: [
            { field: "company_name", operator: "contains", value: q },
            { field: "contact_name", operator: "contains", value: q },
            { field: "contact_title", operator: "contains", value: q },
            { field: "gender", operator: "eq", value: q },
            { field: "supplier_type_id", operator: "eq", value: q },
            { field: "phone", operator: "contains", value: q },
            { field: "email", operator: "contains", value: q }, 
            { field: "country_id", operator: "eq", value: q },
            { field: "city_id", operator: "eq", value: q },
            { field: "region", operator: "contains", value: q },
            { field: "postal_code", operator: "contains", value: q },
            { field: "address", operator: "contains", value: q },
            { field: "detail", operator: "contains", value: q },
            { field: "branch_id", operator: "eq", value: q },
            { field: "status", operator: "eq", value: q }
          ]
        });
      });
    });

    /*Initialize all dropdownlist*/  
    function initDropDownLists(){
      /*Initialize gender dropdownlist*/
      initGenderDropDownList();

      /*Initialize supplier type dropdownlist*/
      $("#supplierType").kendoDropDownList({
        optionLabel: "Select type...",
        dataValueField: "value",
        dataTextField: "text",
        dataSource: {
          transport: {
            read: {
              url: crudBaseUrl+"/supplier/type/list/filter",
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

  <!-- Customize popup editor supplier --> 
  <script type="text/x-kendo-template" id="popup-editor-vedor">
    <div class="row-12">
      <div class="row-6">
        <div class="col-12">
          <label for="compay_name">Company Name</label>
          <input type="text" name="compay_name" class="k-textbox" placeholder="Enter company name" data-bind="value:company_name" required data-required-msg="The company name field is required" pattern=".{1,60}" validationMessage="The company name may not be greater than 60 characters" style="width: 100%;"/>   
        </div>

        <div class="col-12">
          <label for="contact_name">Contact Name</label>
          <input type="text" class="k-textbox" name="Contact name" placeholder="Enter contact name" data-bind="value:contact_name" required data-required-msg="The contact name field is required" pattern=".{1,60}" validationMessage="The contact name may not be greater than 60 characters" style="width: 100%;"/>   
        </div> 

        <div class="col-12">
          <label for="contact_title">Contact Title</label>
          <input type="text" class="k-textbox" name="contact_title" placeholder="Enter contact title" data-bind="value:contact_title" required data-required-msg="The contact title field is required" pattern=".{1,60}" validationMessage="The contact title may not be greater than 60 characters" style="width: 100%;"/>
        </div>

        <div class="col-12">
          <label for="gender">Gender</label>
          <input id="gender" name="gender" data-bind="value:gender" required data-required-msg="The gender field is required" style="width: 100%;" />
        </div>

        <div class="col-12">
          <label for="supplier_type_id">Type</label>
          <input id="supplierType" name="supplier_type_id" data-bind="value:supplier_type_id" required data-required-msg="The type field is required" style="width: 100%;" />
        </div> 

        <div class="col-12">
          <label for="phone">Phone</label>
          <input type="tel" class="k-textbox" name="phone" data-bind="value:phone" required data-required-msg="The phone field is required" pattern="^[0-9\ \]{9,13}$" placeholder="Enter phone number" validationMessage="Phone number format is not valid" style="width: 100%;"/>
        </div>
        
        <div class="col-12">
          <label for="email">Email</label>
          <input type="email" class="k-textbox" name="email" placeholder="e.g. myname@example.net" data-bind="value:email" data-email-msg="Email format is not valid" pattern=".{0,60}" validationMessage="The email may not be greater than 60 characters" style="width: 100%;"/>
        </div> 

        <div class="col-12">
          <label for="country_id">Country</label>
          <input id="country" name="country_id" data-bind="value:country_id" style="width: 100%;" />
        </div>  

        <div class="col-12">
          <label for="city_id">Province/City</label>
          <input id="city" name="city_id" data-bind="value:city_id"  style="width: 100%;" />
        </div> 
      </div>
      <div class="row-6">        
        <div class="col-12">
          <label for="region">Region</label>
          <input type="text" class="k-textbox" name="region" placeholder="Enter region" data-bind="value:region" pattern=".{0,30}" validationMessage="The Region may not be greater than 30 characters" style="width: 100%;"/>
        </div>
        
        <div class="col-12">
          <label for="postal_code">Postal Code</label>
          <input type="text" class="k-textbox" name="postal_code" placeholder="Enter city" data-bind="value:postal_code" pattern=".{0,30}" validationMessage="The postal code may not be greater than 30 characters" style="width: 100%;"/>
        </div>
        
        <div class="col-12">
          <label for="address">Address</label>
          <textarea class="k-textbox" name="address" placeholder="Enter address" data-bind="value:address" pattern=".{0,200}" validationMessage="The address may not be greater than 200 characters" style="width: 100%; height: 97px;"/></textarea> 
        </div>
        
        <div class="col-12">
          <label for="detail">Detail</label>
          <textarea class="k-textbox" name="detail" placeholder="Enter detail" data-bind="value:detail" pattern=".{0,200}" validationMessage="The detail may not be greater than 200 characters" style="width: 100%; height: 97px;"/></textarea> 
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