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

      /*Vedor type data source*/
      var employeeTypeDataSource  =   <?php echo json_encode($employeeTypes) ?>;
      employeeTypeDataSource      =   JSON.parse(employeeTypeDataSource);

      /*Branch data source*/
      var branchDataSource        =   <?php echo json_encode($branches) ?>;
      branchDataSource            =   JSON.parse(branchDataSource);

      /*Country data source*/
      var countryDataSource       =   <?php echo json_encode($countries) ?>;
      countryDataSource           =   JSON.parse(countryDataSource);
      console.log(countryDataSource);

      /*Vedor data source*/
      var gridDataSource = new kendo.data.DataSource({
        transport: {
          read: {
            url: crudBaseUrl + "/employee-list/get",
            type: "GET",
            dataType: "json"
          },
          update: {
            url: crudBaseUrl + "/employee-list/update",
            type: "POST",
            dataType: "json"
          },
          destroy: {
            url: crudBaseUrl + "/employee-list/destroy",
            type: "POST",
            dataType: "json"
          },
          create: {
            url: crudBaseUrl + "/employee-list/store",
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
            vendor_type_id: { 
              field: "employee_type_id", 
              type: "number"
            },
            name: {
                
            },
            sex: {
                  
            },
            identity_card: {
                  
            },
            position: {

            },
            address: {

            },
            phone: {

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
      { field: "name", title: "Name" },
      { field: "sex",title: "Sex"  },
      { field: "identity_card" title: "Identity Card" },
      { field: "position",title: "Position" },
      { field: "address",title: "Address" },
      { field: "phone",title: "Phone" },
      { field: "status", title: "Status", values: statusDataSource },
      { command: ["edit", "destroy"], title: "Action"}
    ],
    editable: {
      mode: "popup",
      window: {
        width: "600px"   
      },
      template: kendo.template($("#popup-editor-vedor").html())
    },
    edit: function (e) {
      //Call function vendor type data binding 
      employeeTypeDataBinding();

      //Call function branch data binding 
      branchDataBinding();
      
      //Call function country data binding 
      countryDataBinding();

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
          field   : "sex",
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
          field   : "address",
          operator: "eq",
          value   : q
        },
        {
          field   : "phone",
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

//Create Employee type dropdownlist 
function employeeTypeDataBinding(){
  $("#employeeType").kendoDropDownList({
    optionLabel: "Select Employee type...",
    dataValueField: "value",
    dataTextField: "text",
    dataSource: {
      transport: {
        read: {
          url: crudBaseUrl+"/employee-type/list/filter",
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
      <input id="employeeType" name="employee_type_id" data-bind="value:employee_type_id"  style="width: 100%;" />
  </div> 
  
  <div class="col-6">
      <label for="name">Name</label>
      <input id="name" data-bind="value:name" style="width: 100%;" />
  </div> 
  
  <div class="col-6">
    <label for="sex">Sex</label>
    <input type="text" class="k-textbox" name="sex" placeholder="Enter sex" data-bind="value:sex" style="width: 100%;"/>
  </div>
  
  <div class="col-6">
    <label for="identity_card">Identity Card</label>
    <input type="text" class="k-textbox" name="identity_card" placeholder="Enter Identity Card" data-bind="value:identity_card" style="width: 100%;"/>
  </div>
  
  <div class="col-6">
    <label for="position">Position</label>
    <input type="text" class="k-textbox" name="position" placeholder="Enter position" data-bind="value:position" style="width: 100%;"/>
  </div>

  <div class="col-12">
    <label for="address">Address</label>
    <textarea class="k-textbox" name="Address" placeholder="Enter address" data-bind="value:address" style="width: 100%;"/></textarea> 
  </div>

  <div class="col-6">
    <label for="phone">Phone</label>
    <input type="text" class="k-textbox" name="Phone" placeholder="Enter phone number" data-bind="value:phone" style="width: 100%;"/>
  </div>
  
  <div class="col-6">
      <label for="status">Status</label>
      <input id="status" data-bind="value:status"  style="width: 100%;" />
  </div>

</script>  
@endsection