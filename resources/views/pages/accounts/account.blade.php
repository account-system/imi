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
              account_type_id: { type: "number" },
              parent_account_id: { type: "number", nullable: true },
              code: { type: "number", defaultValue: null },  
              name: { type: "string" },
              description: { type: "string", nullable: true }, 
              status: { field: "status", type: "string", defaultValue: "Active" },
              opening_balance_amount: { field: "opening_balance_amount", type: "number", defaultValue: null },
              as_of_date: { field: "as_of_date", type: "date", defaultValue: null },
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
          { field: "code", title: "Account Code", groupable: false },
          { field: "name", title: "Account Name ", groupable: false },
          { field: "description", title: "Description", groupable: false },
          { field: "account_type_id", title: "Account Type", values: accountTypeDataSource },
          { field: "parent_account_id", title: "Sub of Account",  template: "#= parent_account_id == null ? '' : subOfAccountColumn(parent_account_id) #", filterable: { ui: subOfAccountColumnFilter }, groupHeaderTemplate: "Account Type: #= value == null ? '' : subOfAccountColumn(value) #" },
          { field: "status", title: "Status", values: statusDataSource },
          { field: "created_by", title: "Created By", values: userDataSource, hidden: true },
          { field: "updated_by", title: "Modified By", values: userDataSource, hidden: true },
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
            /*Call function  init form control*/
            initFormControl();
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
            /*Call function  init form control*/
            initFormControl();
            /*Disable account type*/
            var accountType = $('#accountType').data('kendoDropDownList');
            accountType.enable(false);
            /*Hide controls*/
            $('#amount').parent().parent().parent().hide();
            $('#as-of-date').parent().parent().parent().hide();

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
        optionLabel: "-Select account type-",
        dataValueField: "accountTypeId",
        dataTextField: "accountTypeName",
        dataSource: { 
          transport: {
            read: {
              url: crudBaseUrl + "/account/type/get/dropdownlist",
              type: "GET",
              dataType: "json"
            }
          }
        },
        dataBound: function(){
          //Get object account type
          var accountType           = this.dataItem();
          //List id of account type with opening balance account 
          var ListAccountTypeId     = [1, 3, 4, 9]; 
          //Initalize object controls
          var codeNumericTextBox    = $('#code').data("kendoNumericTextBox");
          var amountNumericTextBox  = $('#amount').data('kendoNumericTextBox');
          var asOfDateDatePicker    = $('#as-of-date').data('kendoDatePicker');   
          
          if (accountType.accountTypeId == '') {
            //Remove attribute from element code numerictextbox
            codeNumericTextBox.element.removeAttr('placeholder');
            //Disable controls 
            amountNumericTextBox.enable(false);
            asOfDateDatePicker.enable(false);
          }else{
            //Add attribute to element code numerictextbox
            codeNumericTextBox.element.attr('placeholder', accountType.minCode + ' - ' + accountType.maxCode);
            if (ListAccountTypeId.indexOf(accountType.accountTypeId) != -1) {
              amountNumericTextBox.enable();
              asOfDateDatePicker.enable(); 
            }else{
              amountNumericTextBox.enable(false);
              asOfDateDatePicker.enable(false);
            }
          }
          $("#code").parents('span').parents('span').attr('style','width:100%;');
        },
        change: function(){
           //Get object account type
          var accountType           = this.dataItem();
          //List id of account type with opening balance account 
          var ListAccountTypeId     = [1, 3, 4, 9]; 
          //Initalize object controls
          var codeNumericTextBox    = $('#code').data("kendoNumericTextBox");
          var amountNumericTextBox  = $('#amount').data('kendoNumericTextBox');
          var asOfDateDatePicker    = $('#as-of-date').data('kendoDatePicker');   

          if (accountType.accountTypeId == '') {
            //Remove attribute from element code numerictextbox
            codeNumericTextBox.element.removeAttr('placeholder');
            codeNumericTextBox.value('');
            //Disable controls 
            amountNumericTextBox.enable(false);
            asOfDateDatePicker.enable(false);
          }else{
            //Add attribute to element code numerictextbox
            codeNumericTextBox.element.attr('placeholder', accountType.minCode + ' - ' + accountType.maxCode);
            codeNumericTextBox.value('');

            if (ListAccountTypeId.indexOf(accountType.accountTypeId) != -1) {
              amountNumericTextBox.enable();
              asOfDateDatePicker.enable(); 
            }else{
              amountNumericTextBox.enable(false);
              asOfDateDatePicker.enable(false);
            }
          }
          $("#code").parents('span').parents('span').attr('style','width:100%;');
        }
      });

      /*Initailize sub of account dropdownlist*/
      $("#subOf").kendoDropDownList({
        valuePrimitive: true,
        optionLabel: "-Select sub of account-",
        dataValueField: "accountId",
        dataTextField: "accountName",
        valueTemplate: "#: data.accountCode + '.' + data.accountName #",
        template: "#: data.accountCode + '.' + data.accountName #",
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

      /*Call account code NumericTextBox*/
      initAccountCodeNumericTextBox();

      /*Initailize status dropdownlist*/
      initStatusDropDownList();

      /*Initialize amount NumericTextBox*/
      $("#amount").kendoNumericTextBox({
          format: "c",
          min: 0,
          max: 99999999.99,
          decimals: 2,
          round: false,
          change:function(){
            /*Call requird as of date numerictextbox*/
            requiredAsOfDate();
          }
      });

      /*Initailize as of datepicker*/
      $("#as-of-date").kendoDatePicker({
        parseFormats: ["dd/MM/yyyy", "yyyy/MM/dd"],
        format: "yyyy/MM/dd" 
      });
    }

    /*Requird as of date datepicker*/
    function requiredAsOfDate(){
      var amount    = $('#amount').data('kendoNumericTextBox');
      var asOfDate  = $('#as-of-date').data('kendoDatePicker');  
      if (amount.value() > 0) {
        asOfDate.element.attr('required','required');
        asOfDate.element.attr('data-required-msg', 'The as of date field is required');  
      }else{
        asOfDate.element.removeAttr('required');
        asOfDate.element.removeAttr('data-required-msg');  
      }
    }

    /*Initialize account code NumericTextBox*/
    function initAccountCodeNumericTextBox(){
      $("#code").kendoNumericTextBox({
          format: "0",
          min: 0,
          max: 10000000,
          decimals: 0,
      }); 
    }

    /*Display text of sub of foriegnkey column*/
    function subOfAccountColumn(parentAccountId) {
      for (var i = 0; i < accountDataSource.length; i++) {
        if (accountDataSource[i].accountId == parentAccountId) {
          return accountDataSource[i].accountCode + '.' +accountDataSource[i].accountName;
        }
      }
    }

    /*Sub of foriegnkey column filter*/
    function subOfAccountColumnFilter(element) {
      element.kendoDropDownList({
        valuePrimitive: true,
        optionLabel: "-Select value-",
        dataValueField: "accountId",
        dataTextField: "accountName",
        valueTemplate: "#: data.accountCode + '.' + data.accountName #",
        template: "#: data.accountCode + '.' + data.accountName #",
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
            <label for="code">Account Code</label>
            <input type="number" id="code" name="code" data-bind="value:code" required data-required-msg="The account code field is required" data-available data-available-url="{{url('')}}/account/validate" data-available-msg="The code is not avalible" style="width: 100%;"/>
          </div> 
          <div class="col-12">
            <label for="name">Account Name</label>
            <input type="text" class="k-textbox" name="name" data-bind="value:name" required data-required-msg="The name field is required" pattern=".{1,60}" validationMessage="The name may not be greater than 60 characters" style="width: 100%;"/>
          </div>  
        </div>
        <div class="row-6"> 
          <div class="col-12">
            <label for="description">Description</label>
            <textarea class="k-textbox" name="description" data-bind="value:description" maxlength="200" style="width: 100%; height: 97px;"></textarea> 
          </div>
          <div class="col-12">
              <label for="status">Status</label>
              <input id="status" data-bind="value:status"  style="width: 100%;" />
          </div>
          <div class="col-12">
            <label for="amount">Opening Balance Amount</label>
            <input id="amount" type="number" name="amount" data-bind="value:amount" style="width: 100%;"/>
          </div>
          <div class="col-12">
            <label for="as_of_date">As of Date</label>
            <input type="text" data-type="date" id="as-of-date" name="as_of_date" data-bind="value:as_of_date" data-role='datepicker' validationMessage="The as of date is not valid date" style="width: 100%;"/>
          </div>  
        </div>
      </div>
    </form>
  </script>

@endsection()