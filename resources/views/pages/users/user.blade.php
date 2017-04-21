@extends('layouts.app')

@section('after_styles')
  <style>
  
  </style>
@endsection

@section('header')
    <section class="content-header">
      <h1>User List</h1>
      <ol class="breadcrumb">
        <li class="active">{{ config('app.name') }}</li>
        <li class="active">User</li>
        <li class="active">User List</li>
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
    /*Role data source*/
    var roleDataSource      =   <?php echo json_encode($roles) ?>;
    
    /*Branch data source*/
    var branchDataSource    =   JSON.parse(<?php echo json_encode($branches) ?>);
   
    /*Country data source*/
    var countryDataSource   =   JSON.parse(<?php echo json_encode($countries) ?>);

    /*City data source*/
    var cityDataSource      =   JSON.parse(<?php echo json_encode($cities) ?>);

    /*Display column branches text in grid*/
    var multiSelectArrayToString = function(item){
      var branches = [];
      $(item.branch_ids).each(function(index,branch){
        branches.push(branch.text);
      });
      return branches.join(', ');    
    }

    $(document).ready(function(){
      /*User data source*/
      var gridDataSource  = new kendo.data.DataSource({
        transport: {
          read: {
            url: crudBaseUrl + "/user/get",
            type: "GET",
            dataType: "json"
          },
          update: {
            url: crudBaseUrl + "/user/update",
            type: "POST",
            dataType: "json"
          },
          destroy: {
            url: crudBaseUrl + "/user/destroy",
            type: "POST",
            dataType: "json"
          },
          create: {
            url: crudBaseUrl + "/user/store",
            type: "POST",
            dataType: "json"
          },
          parameterMap: function (options, operation) {
            if (operation !== "read" && options.models) {
              return { users: kendo.stringify(options.models) };
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
              first_name: { type: "string" }, 
              last_name: { type: "string" }, 
              gender: { type: "string" },  
              role: { type: "string" },
              branches: {},
              phone: { type: "string" },
              email: { type: "string" },
              country_id: { type: "number", nullable: true },   
              city_id: { type: "number", nullable: true },
              region: { type: "string", nullable: true }, 
              postal_code: { type: "string", nullable: true },
              address: { type: "string",  nullable: true },  
              detail: { type: "string",  nullable: true },
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
        pageable: { refresh: true, pageSizes: true, buttonCount: 5 },
        height: 550,
        toolbar: [ 
          { name: "create", text: "Add New Country" }, 
          { template: kendo.template($("#textbox-multi-search").html()) } 
        ],
        columns: [
          { field: "first_name", title: "First Name" },
          { field: "last_name", title: "Last Name" },
          { field: "gender", title: "Gender", values: genderDataSource  },
          { field: "role", title: "Role", values: roleDataSource },
          { field: "branches", title: "Branches", values: branchDataSource, template: multiSelectArrayToString },
          { field: "phone", title: "Phone" },
          { field: "email", title: "Email" },
          { field: "country_id", title: "Country", values: countryDataSource, hidden: true },
          { field: "city_id", title: "Province/City", values: cityDataSource, hidden: true },
          { field: "region", title: "Region", hidden: true },
          { field: "postal_code", title: "Postal Code", hidden: true },
          { field: "address", title: "Address", hidden: true },
          { field: "detail", title: "Detail", hidden: true },
          { field: "status", title: "Status", values: statusDataSource },
          { command: ["edit", "destroy"], title: "&nbsp;Action", menu: false }
        ],
        editable: { mode: "popup", window: { width: "600px" }, template: kendo.template($("#popup-editor-user").html()) },
        edit: function (e) {
          /*Customize popup title and button label */
          if (e.model.isNew()) {
            e.container.data("kendoWindow").title('Add New User');
            $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
          }
          else {
            e.container.data("kendoWindow").title('Edit User');
          }
          /*Initialize form control*/
          initFormControl();
        } 
      }); 

      /*Event response to key up in textbox multi search*/
      $("#txtMultiSearch").keyup(function(e){  
        var q = $('#txtMultiSearch').val();
        $("#grid").data("kendoGrid").dataSource.filter({
          logic  : "or",
          filters: [
            { field: "name", operator: "contains", value: q }
          ]
        });
      });     
    });

    /*Initialize all form control*/  
    function initFormControl(){
      /*Initialize gender dropdownlist*/
      initGenderDropDownList();

      /*Initialize role dropdownlist*/
      $("#role").kendoDropDownList({
        optionLabel: "Select user role...",
        dataValueField: "value",
        dataTextField: "text",
        dataSource: roleDataSource
      });

      /*Initialize branches multiselect*/
      $("#branches").kendoMultiSelect({
        placeholder: "Select branches...",
        dataValueField: "value",
        dataTextField: "text",
        dataSource: branchDataSource
      });

      /*Initialize country dropdownlist*/
      initCountryDropDownList();

      /*Initialize city dropdownlist*/
      initCityDropDownList();

      /*Initialize status dropdownlist*/
      initStatusDropDownList();
    }
  </script>
  <!-- Customize popup editor user --> 
  <script type="text/x-kendo-template" id="popup-editor-user">
    <div class="row-12">
      <div class="row-6">
        <div class="col-12">
          <label for="first_name">First Name</label>
          <input type="text" class="k-textbox" name="first_name" placeholder="Enter first name" data-bind="value:first_name" required data-required-msg="The first name field is required" pattern=".{1,30}" validationMessage="The first name may not be greater than 30 characters" style="width: 100%;"/>
        </div>

        <div class="col-12">
          <label for="last_name">Last Name</label>
          <input type="text" class="k-textbox" name="last_name" placeholder="Enter last name" data-bind="value:last_name" required data-required-msg="The last name field is required" pattern=".{1,30}" validationMessage="The last name may not be greater than 30 characters" style="width: 100%;"/>
        </div>

        <div class="col-12">
          <label for="gender">Gender</label>
          <input id="gender" name="gender" data-bind="value:gender" required data-required-msg="The gender field is required" style="width: 100%;" />
        </div>

        <div class="col-12">
          <label for="role">Role</label>
          <input id="role" name="role" data-bind="value:role" required data-required-msg="The role field is required" style="width: 100%;" />
        </div>

        <div class="col-12">
          <label for="branches">Branches</label>
          <select id="branches" name="branches"  data-bind="value:branches" required data-required-msg="The branches field is required" style="width: 100%;"></select>
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
      </div> 
      <div class="row-6"> 
        <div class="col-12">
          <label for="city_id">Province/City</label>
          <input id="city" name="city_id" data-bind="value:city_id"  style="width: 100%;" />
        </div>  

        <div class="col-12">
          <label for="region">Region</label>
          <input type="text" class="k-textbox" name="region" placeholder="Enter region" data-bind="value:region" pattern=".{0,30}" validationMessage="The region may not be greater than 30 characters" style="width: 100%;"/>
        </div>
        
        <div class="col-12">
          <label for="postal_code">Postal Code</label>
          <input type="text" class="k-textbox" name="postal_code" placeholder="Enter city" data-bind="value:postal_code" pattern=".{0,30}" validationMessage="The postal code may not be greater than 30 characters" style="width: 100%;"/>
        </div>
        
        <div class="col-12">
          <label for="address">Address</label>
          <textarea class="k-textbox" name="address" placeholder="Enter address" data-bind="value:address" maxlength="200" style="width: 100%; height: 97px;"/></textarea> 
        </div>
        
        <div class="col-12">
          <label for="detail">Detail</label>
          <textarea class="k-textbox" name="detail" placeholder="Enter detail" data-bind="value:detail" maxlength="200" style="width: 100%; height: 97px;"/></textarea> 
        </div>

        <div class="col-12">
          <label for="status">Status</label>
          <input id="status" data-bind="value:status"  style="width: 100%;" />
        </div> 
      </div>
    </div>
  </script>    
@endsection
