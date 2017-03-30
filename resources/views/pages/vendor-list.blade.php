@extends('layouts.app')

@section('after_styles')
<style>

</style>
@endsection

@section('header')
  <section class="content-header">
    <h1>Vendor List</h1>
    <ol class="breadcrumb">
      <li class="active">{{ config('app.name') }}</li>
      <li class="active">Vendor List</li>
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

    /*Vedor type data source*/
    var vendorTypeDataSource  =   <?php echo json_encode($vendorTypes) ?>;
    vendorTypeDataSource      =   JSON.parse(vendorTypeDataSource);

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

      /*Vendor data source*/
      var gridDataSource = new kendo.data.DataSource({
        transport: {
          read: {
            url: crudBaseUrl + "/vendor-list/get",
            type: "GET",
            dataType: "json"
          },
          update: {
            url: crudBaseUrl + "/vendor-list/update",
            type: "POST",
            dataType: "json"
          },
          destroy: {
            url: crudBaseUrl + "/vendor-list/destroy",
            type: "POST",
            dataType: "json"
          },
          create: {
            url: crudBaseUrl + "/vendor-list/store",
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
              field: "vendor_type_id", 
              type: "number",
            },
            branch_id: { 
              field: "branch_id", 
              type: "number"
            },
            company_name: {
                
            },
            contact_name: {
                  
            },
            cantact_title: {
                  
            },
            phone: {

            },
            email: {
            },      
            country_id: {
              field: "country_id", 
              type: "number"
            },   
            city_id: {
              field: "city_id", 
              type: "number"
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
      { field: "company_name", title: "Company Name" },
      { field: "contact_name", title: "Contact Name" },
      { field: "contact_title",title: "Contact Title"  },
      { field: "vendor_type_id", title: "Vendor Type", values: vendorTypeDataSource },
      { field: "branch_id", title: "Branch", values: branchDataSource },
      { field: "phone",title: "Phone" ,hidden: true },
      { field: "email",title: "Email" ,hidden: true },
      { field: "country_id",title: "Country", values: countryDataSource ,hidden: true },
      { field: "city_id",title: "City", values: cityDataSource ,hidden: true },
      { field: "region",title: "Region" ,hidden: true },
      { field: "postal_code",title: "Postal Code" ,hidden: true },
      { field: "address",title: "Address" ,hidden: true },
      { field: "detail",title: "Detail" ,hidden: true },
      { field: "status", title: "Status", values: statusDataSource ,hidden: true },
      { command: ["edit", "destroy"], title: "&nbsp;Action", menu: false }
    ],
    editable: {
      mode: "popup",
      window: {
        width: "600px"   
      },
      template: kendo.template($("#popup-editor-vedor").html())
    },
    edit: function (e) {
      //Call function  init dropdownlists
      initDropDownLists();
    
      //Customize popup title and button label 
      if (e.model.isNew()) {
        e.container.data("kendoWindow").title('Add New Vendor');
        $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
      }
      else {
        e.container.data("kendoWindow").title('Edit Vendor');
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
          field   : "company_name",
          operator: "contains",
          value   : q
        },
        {
          field   : "contact_name",
          operator: "contains",
          value   : q
        },
        {
          field   : "cantact_title",
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

/*Initailize all dropdownlist*/  
function initDropDownLists(){
  /*Initailize vendor type dropdownlist*/
  $("#vendorType").kendoDropDownList({
    optionLabel: "Select vendor type...",
    dataValueField: "value",
    dataTextField: "text",
    dataSource: {
      transport: {
        read: {
          url: crudBaseUrl+"/vendor-type/list/filter",
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

<!-- Customize popup editor vendor --> 
<script type="text/x-kendo-template" id="popup-editor-vedor">

  <div class="col-12">
    <label for="compay_name">Company Name</label>
    <input type="text" name="compay_name" class="k-textbox" placeholder="Enter company name" data-bind="value:company_name" required data-required-msg="The field company name is required" required data-max-msg="Enter value max 60 string" style="width: 100%;"/> 
    <span class="k-invalid-msg" data-for="compay_name"></span>
  </div>
  
  <div class="col-6">
    <label for="contact_name">Contact Name</label>
    <input type="text" class="k-textbox" name="Contact name" placeholder="Enter contact name" data-bind="value:contact_name" required data-required-msg="The field contact name is required" style="width: 100%;"/>
  </div>
  
  <div class="col-6">
    <label for="contact_title">Contact Title</label>
    <input type="text" class="k-textbox" name="contact_title" placeholder="Enter contact title" data-bind="value:contact_title" required data-required-msg="The field contact title is required" style="width: 100%;"/>
  </div>

  <div class="col-6">
      <label for="vendor_type_id">Vendor Type</label>
      <input id="vendorType" name="vendor_type" data-bind="value:vendor_type_id" required data-required-msg="The field vendor type is required" style="width: 100%;" />
      <span class="k-invalid-msg" data-for="vendor_type_id"></span>
  </div> 
  
  <div class="col-6">
      <label for="branch_id">Branch</label>
      <input id="branch" name="branch_id" data-bind="value:branch_id" required data-required-msg="The field branch is required" style="width: 100%;" />
      <span class="k-invalid-msg" data-for="branch_id"></span>
  </div> 
  
  <div class="col-6">
    <label for="phone">Phone</label>
    <input type="text" class="k-textbox" name="phone" placeholder="Enter phone number" data-bind="value:phone" style="width: 100%;"/>
  </div>
  
  <div class="col-6">
    <label for="email">Email</label>
    <input type="text" class="k-textbox" name="email" placeholder="Enter email address" data-bind="value:email" style="width: 100%;"/>
  </div>  
  
  <div class="col-6">
      <label for="country_id">Country</label>
      <input id="country" name="country_id" data-bind="value:country_id"  style="width: 100%;" />
      <span class="k-invalid-msg" data-for="country_id"></span>
  </div> 
  
  <div class="col-6">
      <label for="city_id">Province/City</label>
      <input id="city" name="city_id" data-bind="value:city_id"  style="width: 100%;" />
      <span class="k-invalid-msg" data-for="city_id"></span>
  </div> 
  
  <div class="col-6">
    <label for="region">Region</label>
    <input type="text" class="k-textbox" name="region" placeholder="Enter region" data-bind="value:region" style="width: 100%;"/>
  </div>
  
  <div class="col-6">
    <label for="postal_code">Postal Code</label>
    <input type="text" class="k-textbox" name="postal_code" placeholder="Enter city" data-bind="value:postal_code" style="width: 100%;"/>
  </div>
  
  <div class="col-12">
    <label for="address">Address</label>
    <textarea class="k-textbox" name="address" placeholder="Enter address" data-bind="value:address" style="width: 100%;"/></textarea> 
  </div>
  
  <div class="col-12">
    <label for="detail">Detail</label>
    <textarea class="k-textbox" name="detail" placeholder="Enter detail" data-bind="value:detail" style="width: 100%;"/></textarea> 
  </div>

  <div class="col-6">
      <label for="status">Status</label>
      <input id="status" data-bind="value:status"  style="width: 100%;" />
  </div>

</script>  

@endsection