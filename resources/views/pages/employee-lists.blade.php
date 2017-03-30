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

      /*Branch data source*/
      var branchDataSource      =   <?php echo json_encode($branches) ?>;
      branchDataSource          =   JSON.parse(branchDataSource);

      /*Country data source*/
      var countryDataSource     =   <?php echo json_encode($countries) ?>;
      countryDataSource         =   JSON.parse(countryDataSource);
      
      /*City data source*/
      var cityDataSource        =   <?php echo json_encode($cities) ?>;
      cityDataSource            =   JSON.parse(cityDataSource);

      /*employee data source*/
      var gridDataSource = new kendo.data.DataSource({
        transport: {
          read: {
            url: crudBaseUrl + "/employee-lists/get",
            type: "GET",
            dataType: "json"
          },
          update: {
            url: crudBaseUrl + "/employee-lists/update",
            type: "POST",
            dataType: "json"
          },
          destroy: {
            url: crudBaseUrl + "/employee-lists/destroy",
            type: "POST",
            dataType: "json"
          },
          create: {
            url: crudBaseUrl + "/employee-lists/store",
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
            employee_type_id: { 
              field: "employee_type_id", 
              type: "number",
            },
            name: {
                  
            },
            gender: {
                  
            },
            identity_card: {

            },
            position: {

            },
            phone: {

            },
            address: {

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
      { field: "employee_type_id", title: "Employee Type", values: employeeTypeDataSource },
      { field: "name",title: "Name" },
      { field: "gender",title: "Gender" },
      { field: "identity_card",title: "identity_card" },
       { field: "position",title: "Position", hidden: true },
      { field: "phone",title: "Phone", hidden: true },
      { field: "address",title: "Address", hidden: true},
      { field: "status", title: "Status", values: statusDataSource, hidden: true},
      { command: ["edit", "destroy"], title: "Action", menu:false}
    ],
    editable: {
      mode: "popup",
      window: {
        width: "600px"   
      },
      template: kendo.template($("#popup-editor-vedor").html())
    },
    edit: function (e) {
      //Call function Employee type data binding 
      employeeTypeDataBinding();

      //Call function branch data binding 
      branchDataBinding();
      
      //Call function country data binding 
      countryDataBinding();

      //Call function city data binding 
      cityDataBinding();

      //Call function status data binding 
      statusDataBinding();

      //Customize popup title and button label 
      if (e.model.isNew()) {
        e.container.data("kendoWindow").title('Add New Employee');
        $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
      }
      else {
        e.container.data("kendoWindow").title('Edit Employee');
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
          field   : "employee_type_id",
          operator: "contains",
          value   : q
        },
        {
          field   : "name",
          operator: "contains",
          value   : q
        },
        {
          field   : "gender",
          operator: "contains",
          value   : q
        },
        {
          field   : "identity_card",
          operator: "contains",
          value   : q
        },
        {
          field   : "position",
          operator: "contains",
          value   : q
        }, 
        {
          field   : "phone",
          operator: "eq",
          value   : q
        },
        {
          field   : "address",
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

//Create employee type dropdownlist 
function employeeTypeDataBinding(){
  $("#employeeType").kendoDropDownList({
    optionLabel: "Select Employee type...",
    dataValueField: "value",
    dataTextField: "text",
    dataSource: {
      transport: {
        read: {
          url: crudBaseUrl+"/employee-types/list/filter",
          type: "GET",
          dataType: "json"
        }
      }
    }
  }); 
}

</script>

<!-- Customize popup editor employee --> 
<script type="text/x-kendo-template" id="popup-editor-vedor">
  
  <div class="col-6">
      <label for="employee_type_id">Employee Type</label>
      <input id="employeeType" name="employee_type_id" data-bind="value:employee_type_id" required data-required-msg="The field Employee type is required" style="width: 100%;" />
  </div> 
    
  <div class="col-6">
    <label for="name">Name</label>
    <input type="text" class="k-textbox" name="name" placeholder="Enter name" data-bind="value:name" required data-max-msg="Enter value max 60 string" style="width: 100%;"/>
  </div>
  
  <div class="col-6">
    <label for="gender">Gender</label>
    <input type="text" class="k-textbox" name="Gender" placeholder="Enter Gender" data-bind="value:gender" style="width: 100%;"/>
  </div>
  
  <div class="col-6">
    <label for="identity_card">Identity Card</label>
    <input type="text" class="k-textbox" name="identity_card" placeholder="Enter Identity Card" data-bind="value:phone" style="width: 100%;"/>
  </div>
  
  <div class="col-6">
    <label for="phone">Phone</label>
    <input type="text" class="k-textbox" name="phone" placeholder="Enter phone" data-bind="value:phone" style="width: 100%;"/>
  </div>  

  <div class="col-12">
    <label for="address">Address</label>
    <textarea class="k-textbox" name="Address" placeholder="Enter address" data-bind="value:address" style="width: 100%;"/></textarea> 
  </div>
  
  <div class="col-6">
      <label for="status">Status</label>
      <input id="status" data-bind="value:status"  style="width: 100%;" />
  </div>

</script>  

@endsection