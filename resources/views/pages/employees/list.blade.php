@extends('layouts.app')

@section('after_styles')
<style>

</style>
@endsection

@section('header')
  <section class="content-header">
    <h1>Employee List</h1>
    <ol class="breadcrumb">
      <li class="active">{{ config('app.name') }}</li>
      <li class="active">Employees</li>
      <li class="active">Employee List</li>
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

      /*employee type data source*/
      var employeeTypeDataSource  =   <?php echo json_encode($employeeTypes) ?>;
      employeeTypeDataSource      =   JSON.parse(employeeTypeDataSource);

      /*Country data source*/
      var countryDataSource       =   <?php echo json_encode($countries) ?>;
      countryDataSource           =   JSON.parse(countryDataSource);
      
      /*City data source*/
      var cityDataSource          =   <?php echo json_encode($cities) ?>;
      cityDataSource              =   JSON.parse(cityDataSource);

      /*Branch data source*/
      var branchDataSource        =   <?php echo json_encode($branches) ?>;
      branchDataSource            =   JSON.parse(branchDataSource);

      /*employee data source*/
      var gridDataSource = new kendo.data.DataSource({
        transport: {
          read:   { url: crudBaseUrl + "/employee/get", type: "GET", dataType: "json" },
          update: { url: crudBaseUrl + "/employee/update", type: "POST", dataType: "json" },
          destroy:{ url: crudBaseUrl + "/employee/destroy", type: "POST", dataType: "json" },
          create: { url: crudBaseUrl + "/employee/store", type: "POST", dataType: "json" },

          parameterMap: function (options, operation) {
            if (operation !== "read" && options.models) {
              return { employees: kendo.stringify(options.models) };
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
            identity_card: { type: "string" },
            first_name: { type: "string" },
            last_name: { type: "string" },
            job_title: { type: "string" },
            employee_type_id: { type: "number" },
            gender: { type: "string" },  
            date_of_birth: { type: "date", defaultValue: null },
            start_work: { type: "date", defaultValue: null },
            end_work: {  type: "date", defaultValue: null  },
            start_contract: {  type: "date", defaultValue: null },
            end_contract: { type: "date", defaultValue: null },
            spouse: { type: "string", defaultValue: 0 },
            minor:  { type: "string", defaultValue: 0  },
            phone:  { type: "string" },
            email:  { type: "string" },
            country_id: { type: "number", nullable: true },   
            city_id: { type: "number", nullable: true },
            region: { type: "string", nullable: true }, 
            postal_code: { type: "string", nullable: true },
            address: { type: "string",  nullable: true },  
            detail: { type: "string",  nullable: true },
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
    toolbar: [
      { name: "create" ,text: "Add New Employee "},
      { template: kendo.template($("#textbox-multi-search").html()) }
    ],
    columns: [
      { field: "identity_card", title: "Identity Card" },
      { field: "first_name", title: "First Name" },
      { field: "last_name", title: "Last Name" },
      { field: "job_title", title: "Job Title" },
      { field: "employee_type_id", title: "Type ", values: employeeTypeDataSource },
      { field: "gender", title: "Gender", values: genderDataSource },
      { field: "date_of_birth",title: "Date Of Birth", format: "{0:yyyy/MM/dd}" },
      { field: "start_work",title: "Start Work", format: "{0:yyyy/MM/dd}" ,hidden: true},
      { field: "end_work",title: "End Work", format: "{0:yyyy/MM/dd}" ,hidden: true},
      { field: "start_contract",title: "Start Contract", format: "{0:yyyy/MM/dd}" ,hidden: true},
      { field: "end_contract",title: "end_contract", format: "{0:yyyy/MM/dd}" ,hidden: true },
      { field: "spouse",title: "Spouse" ,hidden: true },
      { field: "minor",title: "minor" ,hidden: true },
      { field: "phone",title: "Phone" ,hidden: true },
      { field: "email",title: "Email" ,hidden: true },
      { field: "country_id",title: "Country", values: countryDataSource ,hidden: true },
      { field: "city_id",title: "City", values: cityDataSource ,hidden: true },
      { field: "region",title: "Region" ,hidden: true },
      { field: "postal_code",title: "Postal Code" ,hidden: true },
      { field: "address",title: "Address" ,hidden: true },
      { field: "detail",title: "Detail" ,hidden: true },
      { field: "branch_id", title: "Branch", values: branchDataSource ,hidden: true },
      { field: "status", title: "Status", values: statusDataSource ,hidden: true },
      { command: ["edit", "destroy"], title: "Action", menu:false}
    ],
    editable: {
      mode: "popup",
      window: { width: "600px" },
      template: kendo.template($("#popup-editor-vedor").html())
    },
    edit: function (e) { 
      //Customize popup title and button label 
      if (e.model.isNew()) {
        e.container.data("kendoWindow").title('Add New Employee');
        $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
      }
      else {
        e.container.data("kendoWindow").title('Edit Employee');
      }
      ///Call function  init form control
      initFormControl();
    } 
  }); 

  /*Event response to key up in textbox multi search*/
  $("#txtMultiSearch").keyup(function(e){    
    var q = $('#txtMultiSearch').val();
    $("#grid").data("kendoGrid").dataSource.filter({
      logic  : "or",
      filters: [
        { field  : "identity_card", operator: "contains", value : q },
        { field  : "first_name", operator: "contains", value : q },
        { field  : "last_name", operator: "contains",  value  : q },
        { field  : "job_title",  operator: "contains",  value : q },
        { field  : "employee_type_id", operator: "eq", value : q },
        { field  : "gender", operator: "contains", value : q },
        { field  : "date_of_birth", operator: "eq", value : q },
        { field  : "start_work", operator: "eq", value : q },
        { field  : "end_work", operator: "eq", value   : q },
        { field  : "start_contract", operator: "eq", value : q },
        { field  : "end_contract", operator: "eq", value  : q },
        { field  : "spouse",  operator: "contains", value : q  },
        { field  : "minor", operator: "contains", value  : q },
        { field  : "phone", operator: "contains",  value : q  },
        { field  : "email", operator: "contains",  value : q },
        { field  : "country_id",  operator: "eq",  value : q },
        { field  : "city_id",  operator: "eq",  value : q },
        { field  : "region",  operator: "contains",  value : q },
        { field  : "postal_code",  operator: "contains", value : q },
        { field  : "address",  operator: "contains", value : q  },
        { field  : "detail",  operator: "contains",  value : q },
        { field  : "branch_id",  operator: "eq", value : q }
      ]
    });  
  });
});

/*Initailize all form Control */  
function initFormControl(){
  $("#employeeType").kendoDropDownList({
    optionLabel: "Select Employee type...",
    dataValueField: "value",
    dataTextField: "text",
    dataSource: {
      transport: {
        read: {
          url: crudBaseUrl+"/employee/type/list/filter",
          type: "GET",
          dataType: "json"
        }
      }
    }
  }); 

  /*Initailize gender dropdownlist*/
  initGenderDropDownList();

  /*Initailize country dropdownlist*/
  initCountryDropDownList();

  /*Initailize city dropdownlist*/
  initCityDropDownList();

  /*Initailize branch dropdownlist*/
  initBranchDropDownList();

  /*Initailize status dropdownlist*/
  initStatusDropDownList();
  
  /* Date of birth format */
   $("#dob").kendoDatePicker({
    format: "yyyy/MM/dd"
  }).attr("readonly", "readonly"); 

  /* start work format */
   $("#sw").kendoDatePicker({
    format: "yyyy/MM/dd"
  }).attr("readonly", "readonly");

  /* end work format */
   $("#ew").kendoDatePicker({
    format: "yyyy/MM/dd"
  }).attr("readonly", "readonly");

  /* start contract format */
   $("#sc").kendoDatePicker({
    format: "yyyy/MM/dd"
  }).attr("readonly", "readonly");

  /* end contract format */
   $("#ec").kendoDatePicker({
    format: "yyyy/MM/dd"
  }).attr("readonly", "readonly");
}
</script>

<!-- Customize popup editor employee --> 
<script type="text/x-kendo-template" id="popup-editor-vedor">
  
  <div class="row-12">
    <div class="row-6">
      <div class="col-12">
        <label for="identity_card">Identity Card</label>
        <input type="text" class="k-textbox" name="identity_card" placeholder="Enter identity card" data-bind="value:identity_card" pattern=".{1,60}" validationMessage="The identity card may not be greater than 60 characters" style="width: 100%;"/>
      </div>

      <div class="col-12">
        <label for="first_name">First Name</label>
        <input type="text" class="k-textbox" name="first_name" placeholder="Enter first name" data-bind="value:first_name" required data-required-msg="The first name field is required" pattern=".{1,30}" validationMessage="The first name may not be greater than 30 characters" style="width: 100%;"/>
      </div>

      <div class="col-12">
        <label for="last_name">Last Name</label>
        <input type="text" class="k-textbox" name="last_name" placeholder="Enter last name" data-bind="value:last_name" required data-required-msg="The last name field is required" pattern=".{1,30}" validationMessage="The last name may not be greater than 30 characters" style="width: 100%;"/>
      </div>

      <div class="col-12">
        <label for="job_title">Job Title</label>
        <input type="text" class="k-textbox" name="job_title" placeholder="Enter your job title" data-bind="value:job_title" required data-required-msg="The job title field is required" pattern=".{1,30}" validationMessage="The job title may not be greater than 30 characters" style="width: 100%;"/>
      </div>

      <div class="col-12">
          <label for="employee_type_id">Type</label>
          <input id="employeeType" name="employee_type_id" data-bind="value:employee_type_id" required data-required-msg="The type field is required" style="width: 100%;" />
      </div>

      <div class="col-12">
          <label for="gender">Gender</label>
          <input id="gender" name="gender" data-bind="value:gender" required data-required-msg="The gender field is required" style="width: 100%;" />
      </div>

      <div class="col-12">
        <label for="date_of_birth">Date Of Birth</label>
        <input id="dob" name="date_of_birth" placeholder="Select date of birth" data-bind="value:date_of_birth" required data-required-msg="The date of birth field is required" style="width: 100%;"/>
      </div> 

      <div class="col-12">
        <label for="start_work">Start Work</label>
        <input id="sw" name="start_work" placeholder="Select start work" data-bind="value:start_work" style="width: 100%;"/>
      </div> 

      <div class="col-12">
        <label for="end_work">End Work</label>
        <input id="ew" name="end_work" placeholder="Select end work" data-bind="value:end_work" style="width: 100%;"/>
      </div> 
      
      <div class="col-12">
        <label for="start_contract">Start Contract</label>
        <input id="sc" name="start_contract" placeholder="Select start contract" data-bind="value:start_contract" style="width: 100%;"/>
      </div> 

      <div class="col-12">
        <label for="end_contract">End Contract</label>
        <input id="ec" name="end_contract" placeholder="Select end contract" data-bind="value:end_contract" style="width: 100%;"/>
      </div> 
      
      <div class="col-12">
        <label for="spouse">Spouse</label>
        <input type="number" class="k-textbox" name="spouse" placeholder="Enter spouse" data-bind="value:spouse" min="0" max="30" validationMessage="The spouse may not be greater than 30 characters" style="width: 100%;"/>
      </div>

      <div class="col-12">
        <label for="minor">Minor</label>
        <input type="number" class="k-textbox" name="minor" placeholder="Enter minor" data-bind="value:minor" pattern=".{0,30}" validationMessage="The minor may not be greater than 30 characters" style="width: 100%;"/>
      </div>
    </div>
    <div class="row-6">  
      <div class="col-12">
        <label for="phone">Phone</label>
        <input type="tel" class="k-textbox" name="phone" data-bind="value:phone" placeholder="Enter Phone Number"  required data-required-msg="The phone field is required" pattern="^[0-9\ \]{9,13}$" placeholder="Enter phone number" validationMessage="Phone number format is not valid" style="width: 100%;"/>
      </div>

      <div class="col-12">
        <label for="email">Email</label>
        <input type="email" class="k-textbox" name="Email" placeholder="e.g. myname@example.net" data-bind="value:email" data-email-msg="Email format is not valid" pattern=".{0,60}" validationMessage="The email may not be greater than 60 characters" style="width: 100%;"/>
      </div> 

      <div class="col-12">
          <label for="country_id">Country</label>
          <input id="country" data-bind="value:country_id"  style="width: 100%;" />
      </div>  

      <div class="col-12">
          <label for="city_id">Province/City</label>
          <input id="city" data-bind="value:city_id" disabled="disabled" style="width: 100%;" />
      </div> 
      
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