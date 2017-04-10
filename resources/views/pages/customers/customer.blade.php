@extends('layouts.app')

@section('after_styles')
<style>
  
</style>
@endsection

@section('header')
  <section class="content-header">
    <h1>Customer List</h1>
    <ol class="breadcrumb">
      <li class="active">{{ config('app.name') }}</li>
      <li class="active">Customer</li>
      <li class="active">Customer List</li>
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
    /*Customer type data source*/
    var customerTypeDataSource  =   <?php echo json_encode($customerTypes) ?>;
    customerTypeDataSource      =   JSON.parse(customerTypeDataSource);

    /*Country data source*/
    var countryDataSource       =   <?php echo json_encode($countries) ?>;
    countryDataSource           =   JSON.parse(countryDataSource);

    /*City data source*/
    var cityDataSource          =   <?php echo json_encode($cities) ?>;
    cityDataSource              =   JSON.parse(cityDataSource);

    /*Branch data source*/
    var branchDataSource        =   <?php echo json_encode($branches) ?>;
    branchDataSource            =   JSON.parse(branchDataSource);

    $(document).ready(function(){
      /*Customer data source*/
      var gridDataSource = new kendo.data.DataSource({
        transport: {
          read: {
            url: crudBaseUrl + "/customer/get",
            type: "GET",
            dataType: "json"
          },
          update: {
            url: crudBaseUrl + "/customer/update",
            type: "POST",
            dataType: "json"
          },
          destroy: {
            url: crudBaseUrl + "/customer/destroy",
            type: "POST",
            dataType: "json"
          },
          create: {
            url: crudBaseUrl + "/customer/store",
            type: "POST",
            dataType: "json"
          },
          parameterMap: function (options, operation) {
            if (operation !== "read" && options.models) {
              return { customers: kendo.stringify(options.models) };
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
              customer_name: { type: "string" },
              customer_type_id: { type: "number" },
              gender: { type: "string" },  
              date_of_birth: { type: "date", nullable: true },
              phone: { type: "string" , nullable: true },
              email: { type: "string", nullable: true },
              relative_contact: { type: "string", nullable: true },      
              relative_phone: { type: "string", nullable: true },  
              country_id: { type: "number", nullable: true },   
              city_id: { type: "number", nullable: true },
              region: { type: "string", nullable: true }, 
              postal_code: { type: "string", nullable: true },
              address: { type: "string", nullable: true },  
              detail: { type: "string", nullable: true }, 
              branch_id: { type: "number" },
              status: { field: "status", type: "string", defaultValue: "Enabled" }                
            }
          }
        }
      });
    
      $("#grid").kendoGrid({
        dataSource: gridDataSource,
        navigatable: true,
        resizable: true,
        reorderable: true,
        columnMenu: true,
        filterable: true,
        sortable: { mode: "single", allowUnsort: false },
        pageable: { refresh:true, pageSizes: true, buttonCount: 5 },
        height: 550,
        toolbar: [ { name: "create", text: "Add New Customer" },{ template: kendo.template($("#textbox-multi-search").html()) } ],
        columns: [
          { field: "customer_name", title: "Cusotmer Name" },
          { field: "customer_type_id", title: "Type ", values: customerTypeDataSource },
          { field: "gender", title: "Gender", values: genderDataSource },
          { field: "date_of_birth", title: "Date Of Birth", format: "{0:yyyy/MM/dd}" },
          { field: "phone", title: "Phone" },
          { field: "email", title: "Email" },
          { field: "relative_contact", title: "Relative Contact", hidden: true },
          { field: "relative_phone", title: "Relative Phone" , hidden: true },
          { field: "country_id", title: "Country", values: countryDataSource ,hidden: true },
          { field: "city_id", title: "City", values: cityDataSource , hidden: true },
          { field: "region", title: "Region" , hidden: true },
          { field: "postal_code", title: "Postal Code", hidden: true },
          { field: "address", title: "Address", hidden: true },
          { field: "detail", title: "Detail", hidden: true },
          { field: "branch_id", title: "Branch", values: branchDataSource, hidden: true },
          { field: "status", title: "Status", values: statusDataSource, hidden: true },
          { command: ["edit", "destroy"], title: "Action", menu: false }
        ],
        editable: { mode: "popup", window: { width: "600px" }, template: kendo.template($("#popup-editor-vedor").html()) },
        edit: function (e) {
          /*Customize popup title and button label */
          if (e.model.isNew()) {
            e.container.data("kendoWindow").title('Add New Customer');
            $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
          }
          else {
            e.container.data("kendoWindow").title('Edit Customer');
          }

          /*Call function  init form control*/
          initFormControl(); 
        }

      }); 

      /*Event response to key up in textbox multi search*/
      $("#txtMultiSearch").keyup(function(e){
        var q = $('#txtMultiSearch').val();
        $("#grid").data("kendoGrid").dataSource.filter({
          logic  : "or",
          filters: [
            { field: "customer_name", operator: "contains", value: q },
            { field: "customer_type_id", operator: "eq", value: q },
            { field: "gender", operator: "eq", value: q },
            { field: "date_of_birth", operator: "eq", value: q },
            { field: "phone", operator: "contains", value: q },
            { field: "email", operator: "contains", value: q },
            { field: "relative_contact", operator: "contains", value: q },
            { field: "relative_phone", operator: "contains", value: q },
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

    /*Initailize all form control*/ 
    function initFormControl(){
      /*Initailize customer type dropdownlist*/
      $("#customerTypes").kendoDropDownList({
        optionLabel: "Select customer Type...",
        dataValueField: "value",
        dataTextField: "text",
        dataSource: {
          transport: {
            read: {
              url: crudBaseUrl+"/customer/type/list/filter",
              type: "GET",
              dataType: "json"
            }
          }
        }
      });

      /*Initailize gender dropdownlist*/
      initGenderDropDownList();

      /*Initailize date of birth datepicker*/
      $("#dob").kendoDatePicker({
        format: "yyyy/MM/dd"
      }).attr("readonly", "readonly");

      /*Initailize country dropdownlist*/
      initCountryDropDownList();

      /*Initailize city dropdownlist*/
      initCityDropDownList();

      /*Initailize branch dropdownlist*/
      initBranchDropDownList();

      /*Initailize status dropdownlist*/
      initStatusDropDownList();
    }
  </script>

  <!-- Customize popup editor customer list --> 
  <script type="text/x-kendo-template" id="popup-editor-vedor">
    <div class="row-12">
      <div class="row-6">
        <div class="col-12">
          <label for="customer_name">Customer Name</label>
          <input type="text" class="k-textbox" name="customer_name" placeholder="Enter customer name" data-bind="value:customer_name" required data-required-msg="The customer name field is required" pattern=".{1,60}" validationMessage="The customer name may not be greater than 60 characters" style="width: 100%;"/>
        </div>
        
        <div class="col-12">
            <label for="customer_type_id">Type</label>
            <input id="customerTypes" name="customer_type_id" data-bind="value:customer_type_id" required data-required-msg="The type field is required" style="width: 100%;" />
        </div> 

       <div class="col-12">
          <label for="gender">Gender</label>
          <input id="gender" name="gender" data-bind="value:gender" required data-required-msg="The gender field is required" style="width: 100%;" />
        </div>

        <div class="col-12">
          <label for="date_of_birth">Date Of Birth</label>
          <input id="dob" name="date_of_birth" placeholder="Select date of birth" data-bind="value:date_of_birth" style="width: 100%;"/>
        </div>

        <div class="col-12">
          <label for="phone">Phone</label>
          <input type="tel" class="k-textbox" name="Phone" placeholder="Enter phone number" pattern="^[0-9\ \]{9,13}$" validationMessage="Phone number format is not valid" data-bind="value:phone" style="width: 100%;"/>
        </div>
        
        <div class="col-12">
          <label for="email">Email</label>
          <input type="email" class="k-textbox" name="Email" placeholder="e.g. myname@example.net" data-bind="value:email" data-email-msg="Email format is not valid" pattern=".{0,60}" validationMessage="The email may not be greater than 60 characters" style="width: 100%;"/>
        </div>  
        
        <div class="col-12">
          <label for="relative_contact">Relative Contact</label>
          <input type="text" class="k-textbox" name="relative_contact" placeholder="Enter relative contact" data-bind="value:relative_contact" pattern=".{0,60}" validationMessage="The relative contact may not be greater than 60 characters" style="width: 100%;"/>
        </div> 
      
        <div class="col-12">
          <label for="relative_phone">Relative Phone</label>
          <input type="tel" class="k-textbox" name="relative_phone" placeholder="Enter relative phone" data-bind="value:relative_phone" pattern="^[0-9\ \]{9,13}$" validationMessage="Relative phone munber format is not valid" style="width: 100%;"/>
        </div> 

         <div class="col-12">
            <label for="country_id">Country</label>
            <input id="country" data-bind="value:country_id"  style="width: 100%;" />
        </div> 
      </div>
      <div class="row-6"> 
        <div class="col-12">
            <label for="city_id">Province/City</label>
            <input id="city" data-bind="value:city_id" disabled="disabled" style="width: 100%;" />
        </div> 
        
        <div class="col-12">
          <label for="region">Region</label>
          <input type="text" class="k-textbox" name="Region" placeholder="Enter region" data-bind="value:region" data-bind="value:region" pattern=".{0,30}" validationMessage="The Region may not be greater than 30 characters" style="width: 100%;"/>
        </div>
        
        <div class="col-12">
          <label for="postal_code">Postal Code</label>
          <input type="text" class="k-textbox" name="Postal code" placeholder="Enter Postal Code" pattern=".{0,30}" validationMessage="The postal code may not be greater than 30 characters" data-bind="value:postal_code" style="width: 100%;"/>
        </div>

        <div class="col-12">
          <label for="address">Address</label>
          <textarea class="k-textbox" name="Address" placeholder="Enter address" data-bind="value:address" maxlength="200" style="width: 100%; height: 97px;"/></textarea> 
        </div>
        
        <div class="col-12">
          <label for="detail">Detail</label>
          <textarea class="k-textbox" name="Detail" placeholder="Enter detail" data-bind="value:detail" maxlength="200" style="width: 100%; height: 97px;"/></textarea> 
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

@endsection()