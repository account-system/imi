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

      $(document).ready(function () {

        /*Customer type data source*/
      var customerTypeDataSource  =   <?php echo json_encode($customerTypes) ?>;
      customerTypeDataSource      =   JSON.parse(customerTypeDataSource);

      /*Branch data source*/
      var branchDataSource        =   <?php echo json_encode($branches) ?>;
      branchDataSource            =   JSON.parse(branchDataSource);

      /*Country data source*/
      var countryDataSource       =   <?php echo json_encode($countries) ?>;
      countryDataSource           =   JSON.parse(countryDataSource);

      /*City data source*/
      var cityDataSource        =   <?php echo json_encode($cities) ?>;
      cityDataSource            =   JSON.parse(cityDataSource);

      /*Vedor data source*/
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
            customer_type_id: { 
              field: "customer_type_id", 
              type: "number"
            },
            branch_id: { 
              field: "branch_id", 
              type: "number",
              defaultValue: 0
            },
            customer_name: {
                
            },
            gender: { 
              field: "gender", 
              type: "string",
              defaultValue: "Male" 
            },  
            date_of_birth: {
                type: "date",
                format: "yyyy-mm-dd"
            },
            phone: {
                  
            },
            email: {

            },
            relative_contact: {

            },      
            relative_phone: {

            },  
            country_id: {
              field: "country_id", 
              type: "number",
              defaultValue: 0
            },   
            city_id: {
              field: "city_id", 
              type: "number",
              defaultValue: 0      
            },
            region: {
              
            }, 
            postal_code: {
              
            },
            address: {
              
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
      { field: "customer_type_id", title: "Customer Type ", values: customerTypeDataSource },
      { field: "branch_id", title: "Branch", values: branchDataSource },
      { field: "customer_name", title: "Cusotmer Name" },
      { field: "gender", title: "Gender", values: genderDataSource },
      { field: "date_of_birth",title: "Date Of Birth", template: "#= kendo.toString(kendo.parseDate(date_of_birth, 'yyyy-MM-dd'), 'yyyy/MM/dd') #" },
      { field: "phone",title: "Phone" },
      { field: "email",title: "Email" },
      { field: "relative_contact",title: "Relative Contact" },
      { field: "relative_phone",title: "Relative Phone" },
      { field: "country_id",title: "Country", values: countryDataSource },
      { field: "city_id",title: "City", values: cityDataSource },
      { field: "region",title: "Region" },
      { field: "postal_code",title: "Postal Code" },
      { field: "address",title: "Address" },
      { field: "detail",title: "Detail" },
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
      //Call function customer type data binding 
      customerTypeDataBinding();

      //Call function branch data binding 
      branchDataBinding();
      
      //Call function country data binding 
      countryDataBinding();

      //Call function city data binding 
      cityDataBinding();

      //Call function status data binding 
      statusDataBinding();

      //Call function status data binding 
      genderDataBinding();

      //Customize popup title and button label 
      if (e.model.isNew()) {
        e.container.data("kendoWindow").title('Add New Customer');
        $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
      }
      else {
        e.container.data("kendoWindow").title('Edit Customer');
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
          field   : "customer_type_id",
          operator: "contains",
          value   : q
        },
        {
          field   : "branch_id",
          operator: "contains",
          value   : q
        },
        {
          field   : "customer_name",
          operator: "contains",
          value   : q
        },
        {
          field   : "gender",
          operator: "contains",
          value   : q
        },
        {
          field   : "date_of_birth",
          operator: "contains",
          value   : q
        },
        {
          field   : "phone",
          operator: "contains",
          value   : q
        },
        {
          field   : "email",
          operator: "contains",
          value   : q
        },
        {
          field   : "relative_contact",
          operator: "contains",
          value   : q
        },
        {
          field   : "relative_phone",
          operator: "contains",
          value   : q
        },
        {
          field   : "country_id",
          operator: "eq",
          value   : q
        },
        {
          field   : "city_id",
          operator: "eq",
          value   : q
        },
        {
          field   : "region",
          operator: "contains",
          value   : q
        },
        {
          field   : "postal_code",
          operator: "contains",
          value   : q
        },
        {
          field   : "address",
          operator: "contains",
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
//Create customer type dropdownlist 
function customerTypeDataBinding(){
  $("#customerTypes").kendoDropDownList({
    optionLabel: "Select customer Type...",
    dataValueField: "value",
    dataTextField: "text",
    dataSource: {
      transport: {
        read: {
          url: crudBaseUrl+"/customer-type/list/filter",
          type: "GET",
          dataType: "json"
        }
      }
    }
  });

  // $("#dob").kendoDatePicker({
  //   format: "yyyy-mm-dd"
  // }); 
  $("#dob").kendoDatePicker({
  format: "yyyy/MM/dd"
});
}
</script>

<!-- Customize popup editor customer list --> 
<script type="text/x-kendo-template" id="popup-editor-vedor">


  <div class="col-6">
      <label for="customer_type_id">Customer Type</label>
      <input id="customerTypes" name="customer_type_id" data-bind="value:customer_type_id"  style="width: 100%;" />
  </div> 
  
  <div class="col-6">
      <label for="branch_id">Branch</label>
      <input id="branch" name="branch_id" data-bind="value:branch_id" style="width: 100%;" />
  </div>
  
  <div class="col-12">
    <label for="customer_name">Customer Name</label>
    <input type="text" class="k-textbox" name="customer_name" placeholder="Enter Customer Name" data-bind="value:customer_name" style="width: 100%;"/>
  </div>
  
 <div class="col-6">
      <label for="gender">Gender</label>
      <input id="gender" data-bind="value:gender"  style="width: 100%;" />
  </div>
  
  <div class="col-6">
    <label for="date_of_birth">Date Of Birth</label>
    <input id="dob" name="date_of_birth" placeholder="Select date of birth" data-bind="value:date_of_birth" style="width: 100%;"/>
  </div>

  <div class="col-6">
    <label for="phone">Phone</label>
    <input type="text" class="k-textbox" name="Phone" placeholder="Enter Phone Number" data-bind="value:phone" style="width: 100%;"/>
  </div>
  
  <div class="col-6">
    <label for="email">Email</label>
    <input type="text" class="k-textbox" name="Email" placeholder="Enter email address" data-bind="value:email" style="width: 100%;"/>
  </div>  
  
  <div class="col-6">
    <label for="relative_contact">Relative Contact</label>
    <input type="text" class="k-textbox" name="relative_contact" placeholder="Enter Relative Contact" data-bind="value:relative_contact" style="width: 100%;"/>
  </div> 

  <div class="col-6">
    <label for="relative_phone">Relative Phone</label>
    <input type="text" class="k-textbox" name="relative_phone" placeholder="Enter Relative Phone" data-bind="value:relative_phone" style="width: 100%;"/>
  </div> 

  <div class="col-6">
      <label for="country_id">Country</label>
      <input id="country" data-bind="value:country_id"  style="width: 100%;" />
  </div> 
  
  <div class="col-6">
      <label for="city_id">Province/City</label>
      <input id="city" data-bind="value:city_id" disabled="disabled" style="width: 100%;" />
  </div> 
  
  <div class="col-6">
    <label for="region">Region</label>
    <input type="text" class="k-textbox" name="Region" placeholder="Enter region" data-bind="value:region" style="width: 100%;"/>
  </div>
  
  <div class="col-6">
    <label for="postal_code">Postal Code</label>
    <input type="text" class="k-textbox" name="Postal code" placeholder="Enter Postal Code" data-bind="value:city" style="width: 100%;"/>
  </div>

  <div class="col-12">
    <label for="address">Address</label>
    <textarea class="k-textbox" name="Address" placeholder="Enter address" data-bind="value:address" style="width: 100%;"/></textarea> 
  </div>
  
  <div class="col-12">
    <label for="detail">Detail</label>
    <textarea class="k-textbox" name="Detail" placeholder="Enter detail" data-bind="value:detail" style="width: 100%;"/></textarea> 
  </div>

  <div class="col-6">
      <label for="status">Status</label>
      <input id="status" data-bind="value:status"  style="width: 100%;" />
  </div>

</script>  

@endsection()