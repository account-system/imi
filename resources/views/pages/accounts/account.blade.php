@extends('layouts.app')

@section('after_styles')
<style>
  
</style>
@endsection

@section('header')
  <section class="content-header">
    <h1>Chart of Account</h1>
    <ol class="breadcrumb">
      <li class="active">{{ config('app.name') }}</li>
      <li class="active">Account</li>
      <li class="active">Chart of Account</li>
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
    /*Account type data source foriegnkey column*/
    var accountTypeDataSource =   JSON.parse(<?php echo json_encode($accountTypes) ?>);

    /*account data source foriegnkey column or dropdownlist*/
    var accountDataSource     =   JSON.parse(<?php echo json_encode($accounts) ?>);

    /*user data source foriegnkey column or dropdownlist*/
    var userDataSource        =   JSON.parse(<?php echo json_encode($users) ?>);

    $(document).ready(function(){
      /*Customer data source*/
      var gridDataSource = new kendo.data.DataSource({
        transport: {
          read: {
            url: crudBaseUrl + "/account/get/all",
            type: "GET",
            dataType: "json"
          },
          create: {
            url: crudBaseUrl + "/account/store",
            type: "POST",
            dataType: "json",
            complete: function(){
              reloadAccountDataSource();
            }
          },
          update: {
            url: crudBaseUrl + "/account/update",
            type: "POST",
            dataType: "json",
            complete: function(){
              reloadAccountDataSource();
            }
          },
          destroy: {
            url: crudBaseUrl + "/account/destroy",
            type: "POST",
            dataType: "json"
          },
          parameterMap: function (options, operation) {
            if (operation !== "read" && options.models) {
              return { accounts: kendo.stringify(options.models) };
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
              account_type_id: { type: "number", defaultValue: null },
              parent_account_id: { type: "number", nullable: true },
              code: { type: "string" },  
              name: { type: "string" },
              description: { type: "string", nullable: true }, 
              status: { field: "status", type: "string", defaultValue: "Enabled" },
              created_by: { type: "number", editable: false, nullable: true }, 
              updated_by: { type: "number", editable: false, nullable: true },
              created_at: { type: "date", editable: false, nullable: true }, 
              updated_at: { type: "date", editable: false, nullable: true }              
            }
          }
        }
      });
    
      $("#grid").kendoGrid({
        dataSource: gridDataSource,
        navigatable: true,
        resizable: true,
        reorderable: true,
        groupable: true,
        columnMenu: true,
        filterable: true,
        sortable: { mode: "single", allowUnsort: false },
        pageable: { refresh:true, pageSizes: true, buttonCount: 5 },
        height: 550,
        toolbar: [ 
          { name: "create", text: "Add New Account" },
          { template: kendo.template($("#textbox-multi-search").html()) } 
        ],
        columns: [
          { field: "account_type_id", title: "Account Type", template: "#= account_type_id == null ? '' : accountTypeColumn(account_type_id) #", filterable: { ui: accountTypeColumnFilter }, groupHeaderTemplate: "Account Type: #= accountTypeColumn(value) #" },
          { field: "parent_account_id", title: "Sub of Account",  template: "#= parent_account_id == null ? '' : subOfAccountColumn(parent_account_id) #", filterable: { ui: subOfAccountColumnFilter }, groupHeaderTemplate: "Account Type: #= value == null ? '' : subOfAccountColumn(value) #" },
          { field: "code", title: "Code", groupable: false },
          { field: "name", title: "Name ", groupable: false },
          { field: "description", title: "Description", groupable: false },
          { field: "status", title: "Status", values: statusDataSource },
          { field: "created_by", title: "Created By", hidden: true, template: "#= created_by == null ? '' : userColumn(created_by) #", filterable: { ui: userColumnFilter }, groupHeaderTemplate: "Created By: #= value == null ? '' : userColumn(value) #" },
          { field: "updated_by", title: "Modified By", hidden: true, template: "#= updated_by == null ? '' : userColumn(updated_by) #", filterable: { ui: userColumnFilter }, groupHeaderTemplate: "Modified By: #= value == null ? '' : userColumn(value) #" },
          { field: "created_at", title: "Created At", format: "{0:yyyy/MM/dd h:mm:ss tt}", filterable: { ui: dateTimePickerColumnFilter }, hidden: true, groupable: false },
          { field: "updated_at", title: "Modified At", format: "{0:yyyy/MM/dd h:mm:ss tt}", filterable: { ui: dateTimePickerColumnFilter }, hidden: true, groupable: false },
          { command: ["edit", "destroy"], title: "Action", menu: false }
        ],
        editable: { mode: "popup", window: { width: "600px" }, template: kendo.template($("#popup-editor-chart-of-account").html()) },
        edit: function (e) {
          /*Customize popup title and button label*/
          if (e.model.isNew()) {
            e.container.data("kendoWindow").title('Add New Account');
            $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');

            /*Validate code available*/
            var validator = $("#frmAccount").kendoValidator({
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
                  data: { code: element.val() },
                  success: function(data) {
                    cache.valid = data;
                  },
                  failure: function() {
                    cache.valid = true;
                  },
                  complete: function() {
                    validator.validateInput(element);
                    cache.value = element.val();
                 }
               });
              }
            };
          }
          else {
            e.container.data("kendoWindow").title('Edit Account');
            /*Validate code available*/
            var validator = $("#frmAccount").kendoValidator({
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
                  data: { id: e.model.id, code: element.val() },
                  success: function(data) {
                    cache.valid = data;
                  },
                  failure: function() {
                    cache.valid = true;
                  },
                  complete: function() {
                    validator.validateInput(element);
                    cache.value = element.val();
                 }
               });
              }
            };
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
            { field: "code", operator: "contains", value: q },
          ]
        });  
      });
    });

    /*Initailize all form control*/ 
    function initFormControl(){
      /*Initailize account type dropdownlist*/
      $("#accountType").kendoDropDownList({
        valuePrimitive: true,
        optionLabel: "--Select account type--",
        dataValueField: "accountTypeId",
        dataTextField: "accountTypeName",
        dataSource: { 
          transport: {
            read: {
              url: crudBaseUrl + "/account/type/get/dropdownlist",
              type: "GET",
              dataType: "json"
            }
          },
          group: { field: "class" }
        }
      });

       /*Initailize sub of dropdownlist*/
      $("#subOf").kendoDropDownList({
        valuePrimitive: true,
        optionLabel: "--Select sub of account--",
        dataValueField: "accountId",
        dataTextField: "accountName",
        valueTemplate: "#: data.accountCode +' - '+ data.accountName #",
        template: "#: data.accountCode +' - '+ data.accountName #",
        cascadeFrom: "accountType",
        dataSource: {
          transport: {
            read: {
              url: crudBaseUrl + "/account/get/dropdownlist",
              type: "GET",
              dataType: "json"
            }
          }
        }
      });

      /*Initailize status dropdownlist*/
      initStatusDropDownList();
    }

    /*Display text of created by or modified by foriegnkey column*/
    function userColumn(userId) {
      for (var i = 0; i < userDataSource.length; i++) {
        if (userDataSource[i].id == userId) {
          return userDataSource[i].username;
        }
      }
    }

    /*Display text of account type foriegnkey column*/
    function accountTypeColumn(accountTypeId) {
      for (var i = 0; i < accountTypeDataSource.length; i++) {
        if (accountTypeDataSource[i].accountTypeId == accountTypeId) {
          return accountTypeDataSource[i].accountTypeName;
        }
      }
    }

    /*Display text of sub of foriegnkey column*/
    function subOfAccountColumn(parentAccountId) {
      for (var i = 0; i < accountDataSource.length; i++) {
        if (accountDataSource[i].accountId == parentAccountId) {
          return accountDataSource[i].accountName;
        }
      }
    }

    /*Account type foriegnkey column filter*/
    function accountTypeColumnFilter(element) {
      element.kendoDropDownList({
        optionLabel: "--Select Value--",
        dataValueField: "accountTypeId",
        dataTextField: "accountTypeName",
        dataSource: { data: accountTypeDataSource, group: 'class' }
      });
    }

    /*Sub of foriegnkey column filter*/
    function subOfAccountColumnFilter(element) {
      element.kendoDropDownList({
        valuePrimitive: true,
        optionLabel: "--Select Value--",
        dataValueField: "accountId",
        dataTextField: "accountName",
        dataSource: { 
          transport: {
            read: {
              url: crudBaseUrl + "/account/get/foriegnkeycolumn",
              type: "GET",
              dataType: "json"
            }
          },
          group: { field: "accountTypeName" }
        }
      });
    }

    /*Created by and modified by foriegnkey column filter*/
    function userColumnFilter(element) {
      element.kendoDropDownList({
        valuePrimitive: true,
        optionLabel: "--Select Value--",
        dataValueField: "id",
        dataTextField: "username",
        dataSource: { data: userDataSource, group: 'role' }
      });
    }

    /*datetimepicker column filter*/
    function dateTimePickerColumnFilter(element) {
      element.kendoDateTimePicker({
        format: "{0: yyyy/MM/dd HH:mm:ss tt}",
      });
    } 

    /*Reload account data source*/
    function reloadAccountDataSource(){
      $.ajax({
        type: "GET",
        url: crudBaseUrl + "/account/get/foriegnkeycolumn",
        dataType: "json",
        success: function(data){
          accountDataSource = data;
        },
        error:function(data){

        }
      });
    } 
  </script>

  <!-- Customize popup editor chart of account --> 
  <script type="text/x-kendo-template" id="popup-editor-chart-of-account">
    <form id="frmAccount">
      <div class="row-12">
        <div class="row-6">
          <div class="col-12">
              <label for="account_type_id">Account Type</label>
              <input id="accountType" name="account_type_id" data-bind="value:account_type_id" required data-required-msg="The account type field is required" style="width: 100%;" />
          </div> 
          <div class="col-12">
              <label for="parent_account_id">Sub Of Account</label>
              <input id="subOf" data-bind="value:parent_account_id"  style="width: 100%;" />
          </div> 
          <div class="col-12">
            <label for="code">Code</label>
            <input type="text" id="code" class="k-textbox" name="code" data-bind="value:code" required data-required-msg="The code field is required" pattern=".{1,10}" validationMessage="The code may not be greater than 10 characters" data-available data-available-url="{{url('')}}/account/validate" data-available-msg="The code is not avalible" style="width: 100%;"/>
          </div>  
        </div>
        <div class="row-6"> 
          <div class="col-12">
            <label for="name">Name</label>
            <input type="text" class="k-textbox" name="name" data-bind="value:name" required data-required-msg="The name field is required" pattern=".{1,60}" validationMessage="The name may not be greater than 60 characters" style="width: 100%;"/>
          </div> 
          <div class="col-12">
            <label for="description">Description</label>
            <textarea class="k-textbox" name="description" data-bind="value:description" maxlength="200" style="width: 100%; height: 97px;"></textarea> 
          </div>
          <div class="col-12">
              <label for="status">Status</label>
              <input id="status" data-bind="value:status"  style="width: 100%;" />
          </div>
        </div>
      </div>
    </form>
  </script>

@endsection()