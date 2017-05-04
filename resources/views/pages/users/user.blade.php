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
            <div id="reset" class="k-popup-edit-form"></div>
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
      $(item.branches).each(function(index,branch){
        branches.push(branch.text);
      });
      return branches.join(', ');    
    }

    /*Initialize variable*/
    var wnd,resetTemplate;

    $(document).ready(function(){
      /*User data source*/
      var gridDataSource  = new kendo.data.DataSource({
        transport: {
          read: {
            url: crudBaseUrl + "/user/get/all",
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
              username: { type: "string" }, 
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
          { name: "create", text: "Add New User" }, 
          { template: kendo.template($("#textbox-multi-search").html()) } 
        ],
        columns: [
          { field: "username", title: "User Name" },
          { field: "gender", title: "Gender", values: genderDataSource  },
          { field: "role", title: "Role", values: roleDataSource },
          { field: "branches", title: "Branches", template: multiSelectArrayToString, filterable: false },
          { field: "phone", title: "Phone" },
          { field: "email", title: "Email" },
          { field: "country_id", title: "Country", values: countryDataSource, hidden: true },
          { field: "city_id", title: "Province/City", values: cityDataSource, hidden: true },
          { field: "region", title: "Region", hidden: true },
          { field: "postal_code", title: "Postal Code", hidden: true },
          { field: "address", title: "Address", hidden: true },
          { field: "detail", title: "Detail", hidden: true },
          { field: "status", title: "Status", values: statusDataSource },
          { command: [ "edit", { text: "Reset Password", imageClass: "k-i-gear", iconClass: "k-icon", click:resetPassword } ], title: "&nbsp;Action", menu: false }
        ],
        editable: { mode: "popup", window: { width: "600px" }, template: kendo.template($("#popup-editor-user").html()) },
        edit: function (e) {
          /*Customize popup title and button label */
          if (e.model.isNew()) {
            e.container.data("kendoWindow").title('Add New User');
            $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');

            /*Validate email available*/
            var uservalidator = $("#frmUser").kendoValidator({
              errorTemplate: '<div class="k-widget k-tooltip k-tooltip-validation"' +
              'style="margin:0.5em"><span class="k-icon k-i-warning"> </span>' +
              '#=message#<div class="k-callout k-callout-n"></div></div>',
              rules: {
                available: function(input) {
                  var validate = input.data('available');
                  if (typeof validate !== 'undefined' && validate !== false) {
                    var id = input.attr('id');
                    var cache = availability.cache[id] = availability.cache[id] || {};
                    cache.checking = true;
                    var settings = {
                      url: input.data('availableUrl') || '',
                      message: kendo.template(input.data('availableMsg')) || ''
                    };
                    if (cache.value === input.val() && cache.valid) {
                      return true;
                    }
                    if (cache.value === input.val() && !cache.valid) {
                      cache.checking = false;
                      return false;

                    }
                    availability.check(input, settings);
                    return false;
                  }
                  return true;
                }
              },
              messages: {
                availability: function(input) {
                  var id = input.attr('id');
                  var msg = kendo.template(input.data('availableMsg') || '');
                  var cache = availability.cache[id];
                  if (cache.checking) {
                    return "Checking..."
                  }
                  else {
                    return msg(input.val());
                  }
                }
              }
            }).data('kendoValidator');

            var availability = {
              cache: {},
              check: function(element, settings) {
                var id = element.attr('id');
                var cache = this.cache[id] = this.cache[id] || {};
                $.ajax({
                  type: 'GET',
                  url: settings.url,
                  dataType: 'json',
                  data: { email: element.val() },
                  success: function(data) {
                    cache.valid = data;
                  },
                  failure: function() {
                    cache.valid = true;
                  },
                  complete: function() {
                    uservalidator.validateInput(element);
                    cache.value = element.val();
                 }
               });
              }
            };
          }
          else {
            e.container.data("kendoWindow").title('Edit User');
            /*Validate email available*/
            var uservalidator = $("#frmUser").kendoValidator({
              errorTemplate: '<div class="k-widget k-tooltip k-tooltip-validation"' +
              'style="margin:0.5em"><span class="k-icon k-i-warning"> </span>' +
              '#=message#<div class="k-callout k-callout-n"></div></div>',
              rules: {
                available: function(input) {
                  var validate = input.data('available');
                  if (typeof validate !== 'undefined' && validate !== false) {
                    var id = input.attr('id');
                    var cache = availability.cache[id] = availability.cache[id] || {};
                    cache.checking = true;
                    var settings = {
                      url: input.data('availableUrl') || '',
                      message: kendo.template(input.data('availableMsg')) || ''
                    };
                    if (cache.value === input.val() && cache.valid) {
                      return true;
                    }
                    if (cache.value === input.val() && !cache.valid) {
                      cache.checking = false;
                      return false;

                    }
                    availability.check(input, settings);
                    return false;
                  }
                  return true;
                }
              },
              messages: {
                availability: function(input) {
                  var id = input.attr('id');
                  var msg = kendo.template(input.data('availableMsg') || '');
                  var cache = availability.cache[id];
                  if (cache.checking) {
                    return "Checking..."
                  }
                  else {
                    return msg(input.val());
                  }
                }
              }
            }).data('kendoValidator');

            var availability = {
              cache: {},
              check: function(element, settings) {
                var id = element.attr('id');
                var cache = this.cache[id] = this.cache[id] || {};
                $.ajax({
                  type: 'GET',
                  url: settings.url,
                  dataType: 'json',
                  data: { id: e.model.id, email: element.val() },
                  success: function(data) {
                    cache.valid = data;
                  },
                  failure: function() {
                    cache.valid = true;
                  },
                  complete: function() {
                    uservalidator.validateInput(element);
                    cache.value = element.val();
                 }
               });
              }
            };
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
            { field: "username", operator: "contains", value: q }
          ]
        });
      });

      /*Initialize window reset password*/
      wnd = $("#reset").kendoWindow({
        title: "Reset Password",
        modal: true,
        visible: false,
        resizable: false,
        width: "600px"
      }).data("kendoWindow");

      resetTemplate = kendo.template($("#reset-password").html());

      /*Event reset password*/
      $(document).on('click', '#btnResetPassword', function(){
        var resetPasswordValidator = $('#frmResetPassword').kendoValidator({
          errorTemplate: '<div class="k-widget k-tooltip k-tooltip-validation"' +
              'style="margin:0.5em"><span class="k-icon k-i-warning"> </span>' +
              '#=message#<div class="k-callout k-callout-n"></div></div>',
          rules: {
            matches: function(input) {
              var matches = input.data('matches');
              if (matches) {
                var match = $(matches);
                if ( $.trim(input.val()) === $.trim(match.val()) )  {
                  return true;

                } else {
                  return false;
                }
              }
              return true;
            }
          },
          messages: {
            matches: function(input) {
              return input.data("matchesMsg");
            }
          }
        }).data("kendoValidator");

        if(resetPasswordValidator.validate()){
          $.ajax({
            type: 'POST',
            url: '{{url('')}}' + '/user/'+ $('#user-id').val() +'/reset/password',
            dataTye: 'json',
            data: { password: $('#password').val() },
            success: function(){
              if('{{Auth::user()->id}}' == $('#user-id').val()){
                wnd.close();
                window.location.href = '{{url('')}}' + '/logout';
              }else{
                wnd.close();
              }
            },
            error: function(){
              wnd.close();
            } 
          });
        } 
      });

      /*Event cancel reset password*/
      $(document).on('click', '#btnCancel', function(){
        wnd.center().close();
      });  
    });

    /*Initialize all form control*/  
    function initFormControl(){
      /*Initialize gender dropdownlist*/
      initGenderDropDownList();

      /*Initialize role dropdownlist*/
      $("#role").kendoDropDownList({
        optionLabel: "Select role...",
        dataValueField: "value",
        dataTextField: "text",
        dataSource: roleDataSource 
      });

      /*Initialize branches multiselect*/
      $("#branches").kendoMultiSelect({
        placeholder: "Select branches...",
        dataValueField: "value",
        dataTextField: "text",
        dataSource: branchDataSource,
      });

      /*Initialize country dropdownlist*/
      initCountryDropDownList();

      /*Initialize city dropdownlist*/
      initCityDropDownList();

      /*Initialize status dropdownlist*/
      initStatusDropDownList();
    }

    /*Reset password*/
    function resetPassword(e){
      e.preventDefault();
      var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
      wnd.content(resetTemplate(dataItem));
      wnd.center().open();
    }

  </script>
  <!-- Customize popup editor reset password --> 
  <script type="text/x-kendo-template" id="reset-password">
    <div class="k-edit-form-container">
      <form id="frmResetPassword">
      <input type="hidden" id="user-id" value="#= id #" />
      <div class="row-1-12">
        <div class="col-1-12">
          <label for="password">Password</label>
          <input type="password" class="k-textbox" name="password" id="password" placeholder="Enter password" required data-required-msg="Password is required" pattern=".{6,}" validationMessage="The password must be at least 6 characters" style="width: 100%;" />
        </div>
        <div class="col-1-12">
          <label for="confirm-password">Confirm Password</label>
          <input type="password" class="k-textbox" name="confirm-password" id="confirm-password" placeholder="Confirm password"  required data-required-msg="You must confirm your password" data-matches="\\#password" data-matches-msg="The passwords do not match" style="width: 100%;" />
        </div>
      </div>
      <div class="k-edit-buttons k-state-default">
          <a id="btnResetPassword" role="button" class="k-button k-button-icontext k-primary k-grid-update">
            <span class="k-icon k-i-reset"></span>Reset Password
          </a>
          <butt id="btnCancel" role="button" class="k-button k-button-icontext k-grid-cancel">
            <span class="k-icon k-i-cancel"></span>Cancel
          </a>
      </div>
      </form>
    </div>
  </script>

  <!-- Customize popup editor user --> 
  <script type="text/x-kendo-template" id="popup-editor-user">
    <form id="frmUser">
      <div class="row-12">
        <div class="row-6">
          <div class="col-12">
            <label for="username">User Name</label>
            <input type="text" class="k-textbox" name="username" placeholder="Enter user name" data-bind="value:username" required data-required-msg="The user name field is required" pattern=".{1,30}" validationMessage="The user name may not be greater than 30 characters" style="width: 100%;"/>
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
            <input type="email" id="email" class="k-textbox" name="email" placeholder="e.g. myname@example.net" data-bind="value:email" data-email-msg="Email is not valid" pattern=".{0,60}" validationMessage="The email may not be greater than 60 characters" data-available data-available-url="{{url('')}}/user/validate" data-available-msg="The email has already been taken" style="width: 100%;"/>
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
    </form>
  </script>    
@endsection
