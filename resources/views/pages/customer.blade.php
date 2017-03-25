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
      console.log(countryDataSource);

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
            name: {
                
            },
            type: {
                  
            },
            barcode: {
                  
            },
            sex: {

            },
            tel: {
            },      
            address: {
            },
            email: {
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
      { field: "name", title: "Name" },
      { field: "type",title: "Type" },
      { field: "barcode",title: "Barcode" },
      { field: "sex",title: "Sex"},
      { field: "tel",title: "Tel" },
      { field: "address",title: "Address" },
      { field: "email",title: "Email" },
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

      //Call function status data binding 
      statusDataBinding();

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
          field   : "name",
          operator: "contains",
          value   : q
        },
        {
          field   : "type",
          operator: "contains",
          value   : q
        },
        {
          field   : "barcode",
          operator: "contains",
          value   : q
        },
        {
          field   : "sex",
          operator: "contains",
          value   : q
        },
        {
          field   : "tel",
          operator: "contains",
          value   : q
        },
        {
          field   : "address",
          operator: "contains",
          value   : q
        },
        {
          field   : "email",
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
}
</script>

<!-- Customize popup editor customer list --> 
<script type="text/x-kendo-template" id="popup-editor-vedor">


  <div class="col-6">
      <label for="customer_type_id">Customer Type</label>
      <input id="customerTypes" name="customer_type_id" data-bind="value:customer_type_id"  style="width: 100%;" />
  </div> 
  
  
  <div class="col-6">
    <label for="name">Name</label>
    <input type="text" class="k-textbox" name="name" placeholder="Enter name" data-bind="value:name" style="width: 100%;"/>
  </div>
  
  <div class="col-6">
    <label for="type">Type</label>
    <input type="text" class="k-textbox" name="type" placeholder="Enter type" data-bind="value:type" style="width: 100%;"/>
  </div>
  
  <div class="col-6">
    <label for="type">Barcode</label>
    <input type="text" class="k-textbox" name="barcode" placeholder="Enter Barcode" data-bind="value:type" style="width: 100%;"/>
  </div>

  <div class="col-6">
    <label for="tel">Tel</label>
    <input type="text" class="k-textbox" name="tel" placeholder="Enter phone number" data-bind="value:tel" style="width: 100%;"/>
  </div>
  
  <div class="col-6">
    <label for="email">Email</label>
    <input type="text" class="k-textbox" name="Email" placeholder="Enter email address" data-bind="value:email" style="width: 100%;"/>
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