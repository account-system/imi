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
    $(document).ready(function () {

      var vendorTypeDataSource  =   <?php echo json_encode($vendorTypeList) ?>;
      vendorTypeDataSource      =   JSON.parse(vendorTypeDataSource);

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
                        type: "number"
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
                      country: {
                      },   
                      city: {
                              
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
                        defaultValue: "ENABLED" 
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
      { field: "branch_id", title: "Branch" },
      { field: "phone",title: "phone" },
      { field: "email",title: "Email" },
      { field: "country_id",title: "Country" },
      { field: "city",title: "City" },
      { field: "region",title: "Region" },
      { field: "postal_code",title: "Postal Code" },
      { field: "address",title: "Address" },
      { field: "detail",title: "Detail" },
      { field: "status", title: "Status" },
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
      vendorTypeDataBinding();

      //Call function branch data binding 
      branchDataBinding();
      
      //Call function country data binding 
      countryDataBinding();

      //Call function status data binding 
      statusDataBinding();

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
          field   : "fex",
          operator: "contains",
          value   : q
        },
        {
          field   : "country",
          operator: "contains",
          value   : q
        },
        {
          field   : "city",
          operator: "contains",
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

//Create vendor type dropdownlist 
function vendorTypeDataBinding(){
  $("#vendorType").kendoDropDownList({
    optionLabel: "Select vendor type...",
    dataValueField: "value",
    dataTextField: "text",
    dataSource: {
      transport: {
        read: {
          url: crudBaseUrl+"/vendor-type/list",
          type: "GET",
          dataType: "json"
        }
      }
    }
  }); 
}
</script>

<!-- Customize popup editor vendor --> 
<script type="text/x-kendo-template" id="popup-editor-vedor">
  <div class="col-12">
    <label for="compay_name">Company Name</label>
    <input type="text" name="Company name" class="k-textbox" placeholder="Enter company name" data-bind="value:company_name" required  style="width: 100%;"/> 
  </div>
  <div class="col-6">
      <label for="vendor_type_id">Vendor Type</label>
      <input id="vendorType" name="vendor_type_id" data-bind="value:vendor_type_id"  style="width: 100%;" />
  </div> 
  <div class="col-6">
      <label for="branch_id">Branch</label>
      <input id="branch" data-bind="value:branch_id" style="width: 100%;" />
  </div> 
  <div class="col-6">
    <label for="contact_name">Contact Name</label>
    <input type="text" class="k-textbox" name="Contact name" placeholder="Enter contact name" data-bind="value:contact_name" style="width: 100%;"/>
  </div>
  <div class="col-6">
    <label for="contact_title">Contact Title</label>
    <input type="text" class="k-textbox" name="Contact title" placeholder="Enter contact title" data-bind="value:contact_title" style="width: 100%;"/>
  </div>
  <div class="col-6">
    <label for="phone">Phone</label>
    <input type="text" class="k-textbox" name="Phone" placeholder="Enter phone number" data-bind="value:phone" style="width: 100%;"/>
  </div>
  <div class="col-6">
    <label for="email">Email</label>
    <input type="text" class="k-textbox" name="Email" placeholder="Enter email address" data-bind="value:email" style="width: 100%;"/>
  </div>  
  <div class="col-6">
      <label for="country_id">Country</label>
      <input id="country" data-bind="value:country"  style="width: 100%;" />
  </div> 
  <div class="col-6">
    <label for="city">City</label>
    <input type="text" class="k-textbox" name="City" placeholder="Enter city" data-bind="value:city" style="width: 100%;"/>
  </div>
  <div class="col-6">
    <label for="region">Region</label>
    <input type="text" class="k-textbox" name="Region" placeholder="Enter region" data-bind="value:region" style="width: 100%;"/>
  </div>
  <div class="col-6">
    <label for="postal_code">Postal Code</label>
    <input type="text" class="k-textbox" name="Postal code" placeholder="Enter city" data-bind="value:city" style="width: 100%;"/>
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
@endsection