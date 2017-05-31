@extends('layouts.app')

@section('after_styles')
<style>

</style>
@endsection

@section('header')
  <section class="content-header">
    <h1>Item List</h1>
    <ol class="breadcrumb">
      <li class="active">{{ config('app.name') }}</li>
      <li class="active">Item</li>
      <li class="active">Item List</li>
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
    /*Item type data source*/
    var itemTypeDataSource        =   JSON.parse(<?php echo json_encode($itemTypes) ?>); 

    /*Cost of Goods Sold account data source*/
    var cogsAccountDataSource     =   JSON.parse(<?php echo json_encode($cogsAccounts) ?>); 

    var discontinueDataSourece    =   [ {value: false, text: "No"}, {value: true, text: "Yes"} ]; 

    /*Income account data source*/
    var incomeAccountDataSource   =   JSON.parse(<?php echo json_encode($incomeAccounts) ?>); 

    /*Measure data source*/
    var measureDataSource         =   JSON.parse(<?php echo json_encode($measures) ?>); 

    /*Category data source*/
    var categoryDataSource        =   JSON.parse(<?php echo json_encode($categories) ?>); 

    /*Branch data source*/
    var branchDataSource          =   JSON.parse(<?php echo json_encode($branches) ?>);

    /*Inventory account data source*/
    var inventoryAccountDataSource=   JSON.parse(<?php echo json_encode($inventoryAccounts) ?>); 

    /*user data source*/
    var userDataSource            =   JSON.parse(<?php echo json_encode($users) ?>);

    $(document).ready(function () {
      /*Item data source*/
      var gridDataSource = new kendo.data.DataSource({
        transport: {
          read: {
            url: crudBaseUrl + "/item/get",
            type: "GET",
            dataType: "json"
          },
          update: {
            url: crudBaseUrl + "/item/update",
            type: "POST",
            dataType: "json"
          },
          destroy: {
            url: crudBaseUrl + "/item/destroy",
            type: "POST",
            dataType: "json"
          },
          create: {
            url: crudBaseUrl + "/item/store",
            type: "POST",
            dataType: "json"
          },
          parameterMap: function (options, operation) {
            if (operation !== "read" && options.models) {
              return { items: kendo.stringify(options.models) };
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
              item_type_id: { type: "number" },
              code: { type: "string" },
              name: { type: "string" },
              purchase_information: { type: "string" },
              cost: { type: "number", nullable: true },
              cogs_account_id: { type: "number", nullable: true },
              discontinue: { type: "boolean" ,defaultValue: false},
              measure_id: { type: "number" },
              category_id: { type: "number" },
              branch_id: { type: "number" },  
              sale_information: { type: "string" },
              price: { type: "number", nullable: true },
              income_account_id: { type: "number" },
              status: { type: "string", defaultValue: "Active" },
              inventory_account_id: { type: "number", nullable: true },
              reorder_point: { type: "number", nullable: true },
              on_hand: { type: "number", nullable: true },
              amount: { type: "number", nullable: true }, 
              as_of_date: { type: "date", nullable: true },     
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
        reorderable: true,
        resizable: true,
        columnMenu: true,
        filterable: true,
        sortable: { mode: "single", allowUnsort: false },
        pageable: { refresh: true, pageSizes: true, buttonCount: 5 },
        height: 550,
        toolbar: [ 
          { name: "create", text: "Add New Item" },
          { name: "excel", text: "Export to Excel" }, 
          { template: kendo.template($("#textbox-multi-search").html()) } 
        ],
        excel: {
          fileName: "Item Report.xlsx",
          filterable: true
        },
        excelExport: function(e) {
          var grid = $("#grid").data("kendoGrid");
          if (grid) {
            // get the date columns from the datasource
            var dateColumnList = [];
            var fields = grid.dataSource.options.schema.model.fields;
            // only check visible columns
            var visibleColumns = grid.columns.filter(function(col) { return col.hidden !== true });
            visibleColumns.forEach(function (col, index) {
              var fieldName = col.field;
              // find matching model
              var match = fields[fieldName];
              // determine if this is a date column that will need a date/time format
              if (match && match.type === 'date') {
                // give each column a format from the grid settings or a default format
                dateColumnList.push(
                {
                i: index, 
                format: col.exportFormat ? col.exportFormat : "yyyy-MM-dd"
                });
              }
            });
            var sheet = e.workbook.sheets[0];
            for (var rowIndex = 1; rowIndex < sheet.rows.length; rowIndex++) {
              var row = sheet.rows[rowIndex];
              // apply the format to the columns found
              for (var cellIndex = 0; cellIndex < dateColumnList.length; cellIndex++) {
                var index = dateColumnList[cellIndex].i;
                row.cells[index].format = dateColumnList[cellIndex].format;
              }
            }
          }
        },
        columns: [
          { field: "item_type_id", title: "Item Type", values: itemTypeDataSource },
          { field: "code", title: "Code" },
          { field: "name",title: "Name" },
          { field: "purchase_information",title: "Purchase Information" },
          { field: "cost", title: "Cost", format: "{0:c}" },
          { field: "cogs_account_id", title: "COGS Account", values: cogsAccountDataSource },
          { field: "discontinue", title: "Discontinue", values: discontinueDataSourece },
          { field: "measure_id", title: "Unit of Measure", values: measureDataSource },
          { field: "category_id", title: "Category", values: categoryDataSource },
          { field: "branch_id", title: "Branch", values: branchDataSource },
          { field: "sale_information",title: "Sale Information" },
          { field: "price", title: "Price", format: "{0:c}" },
          { field: "income_account_id", title: "Income Account", values: incomeAccountDataSource },
          { field: "status", title: "Status", values: statusDataSource },
          { field: "inventory_account_id", title: "Inventory Account", values: inventoryAccountDataSource },
          { field: "reorder_point", title: "Reorder Point" },
          { field: "on_hand", title: "On Hand" },
          { field: "amount", title: "Total Value" },
          { field: "as_of_date", title: "As of Date", format: "{0:yyyy/MM/dd}" },
          { field: "created_by", title: "Created By", values: userDataSource, hidden: true },
          { field: "updated_by", title: "Modified By", values: userDataSource, hidden: true },
          { field: "created_at", title: "Created At", format: "{0:yyyy/MM/dd h:mm:ss tt}", exportFormat: "yyyy/MM/dd h:mm:ss AM/PM", filterable: { ui: dateTimePickerColumnFilter }, hidden: true },
          { field: "updated_at", title: "Modified At", format: "{0:yyyy/MM/dd h:mm:ss tt}", exportFormat: "yyyy/MM/dd h:mm:ss AM/PM", filterable: { ui: dateTimePickerColumnFilter }, hidden: true },
          { command: ["edit", "destroy"], title: "&nbsp;Action", menu: false }
        ],
        editable: { mode: "popup", window: { width: "600px" }, template: kendo.template($("#popup-editor-item").html()) },
        edit: function (e) {
          //Customize popup title and button label 
          if (e.model.isNew()) {
            e.container.data("kendoWindow").title('Add New Item');
            $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
          }
          else {
            e.container.data("kendoWindow").title('Edit Item');
          }

          //Call function  init form controll
          initFormControll();
        } 
      }); 

      /*Event response to key up in textbox multi search*/
      $("#txtMultiSearch").keyup(function(e){  
        var q = $('#txtMultiSearch').val();
        $("#grid").data("kendoGrid").dataSource.filter({
          logic  : "or",
          filters: [
            
          ]
        });
      });
      
    });

    /*Initialize all form controller*/  
    function initFormControll(){
      /*Initialize item type dropdownlist*/
      $("#item-type").kendoDropDownList({
        optionLabel: "-Select item type-",
        dataValueField: "value",
        dataTextField: "text",
        dataSource: {
          transport: {
            read: {
              url: crudBaseUrl + "/item/type/list/dropdownlist",
              type: "GET",
              dataType: "json"
            }
          }
        },
        change:function(){
          var itemType = this.dataItem();
          disableControl(itemType.value);
        }
      });

      /*Initialize COGS account dropdownlist*/
      $("#cogs-account").kendoDropDownList({
        optionLabel: "-Select COGS account-",
        dataValueField: "value",
        dataTextField: "text",
        dataSource: {
          transport: {
            read: {
              url: crudBaseUrl + "/account/type/11/account/dropdownlist",
              type: "GET",
              dataType: "json"
            }
          }
        }
      });

      /*Initialize cost NumericTextBox*/
      $("#cost").kendoNumericTextBox({
          placeholder: "-Select value-",
          format: "c",
          min: 0,
          max: 99999999.99,
          decimals: 2,
          round: false
      });

      /*Initialize discontinue dropdownlist*/ 
      $("#discontinue").kendoDropDownList({
        dataValueField: "value",
        dataTextField: "text",
        dataSource: discontinueDataSourece
      });

      /*Measurce data source*/
      var measureDropDownListDataSource = new kendo.data.DataSource({
          batch: true,
          transport: {
              read: {
                url: crudBaseUrl + "/item/measure/list/dropdownlist",
                type: "GET",
                dataType: "json"
              },
              create: {
                url: crudBaseUrl + "/item/measure/store",
                type: "POST",
                dataType: "json"
              },
              parameterMap: function(options, operation) {
                  if (operation !== "read" && options.models) {
                      return {measures: kendo.stringify(options.models)};
                  }
              }
          },
          schema: {
            model: {
              id: "id",
              fields: {
                id: { type: "number" },
                name: { type: "string" },
                description: { type: "string", nullable: true },
                status: { field: "status", type: "string", defaultValue: "Active" }
              }
            }
          }
      });

      /*Initialize COGS account dropdownlist*/
      $("#measure").kendoDropDownList({
        filter: "startswith",
        optionLabel: "-Select unit of measure-",
        dataValueField: "value",
        dataTextField: "text",
        dataSource: measureDropDownListDataSource,
        noDataTemplate: $("#noDataTemplate").html()
      });

      /*Initialize category dropdownlist*/
      $("#category").kendoDropDownList({
        optionLabel: "-Select category-",
        dataValueField: "value",
        dataTextField: "text",
        dataSource: {
          transport: {
            read: {
              url: crudBaseUrl + "/item/category/list/dropdownlist",
              type: "GET",
              dataType: "json"
            }
          }
        }
      });

      /*Initialize branch dropdownlist*/
      initBranchDropDownList();

      /*Initialize price NumericTextBox*/
      $("#price").kendoNumericTextBox({
          placeholder: "-Select value-",
          format: "c",
          min: 0,
          max: 99999999.99,
          decimals: 2,
          round: false
      });

      /*Initialize income account dropdownlist*/
      $("#income-account").kendoDropDownList({
        optionLabel: "-Select income account-",
        dataValueField: "value",
        dataTextField: "text",
        dataSource: {
          transport: {
            read: {
              url: crudBaseUrl + "/account/type/10/account/dropdownlist",
              type: "GET",
              dataType: "json"
            }
          }
        }
      });

      /*Initialize status dropdownlist*/
      initStatusDropDownList();

      /*Initialize inventory account dropdownlist*/
      $("#inventory-account").kendoDropDownList({
        optionLabel: "-Select inventory account-",
        dataValueField: "value",
        dataTextField: "text",
        dataSource: {
          transport: {
            read: {
              url: crudBaseUrl + "/account/type/6/account/dropdownlist",
              type: "GET",
              dataType: "json"
            }
          }
        }
      });

      /*Initialize reorder poit NumericTextBox*/
      $("#reorder-point").kendoNumericTextBox({
          placeholder: "-Select value-",
          format: "0",
          decimals: 0,
          min: 0,
          max: 99999999,
      });

      /*Initialize quantity NumericTextBox*/
      $("#on-hand").kendoNumericTextBox({
          placeholder: "-Select value-",
          format: "0",
          decimals: 0,
          min: 0,
          max: 99999999,
      });

      /*Initialize amount NumericTextBox*/
      $("#amount").kendoNumericTextBox({
          placeholder: "-Select value-",
          format: "c",
          min: 0,
          max: 99999999.99,
          decimals: 2,
          round: false
      });

      /*Initailize as of datepicker*/
      $("#as-of-date").kendoDatePicker({
        parseFormats: ["dd/MM/yyyy", "yyyy/MM/dd"],
        format: "yyyy/MM/dd" 
      });
    }

    /*Disable control*/
    function disableControl(option){
      var cost              =   $('#cost').data('kendoNumericTextBox');
      var cogsAccount       =   $('#cogs-account').data('kendoDropDownList');
      var price             =   $('#price').data('kendoNumericTextBox');
      var incomeAccount     =   $('#income-account').data('kendoDropDownList');
      var inventoryAccount  =   $('#inventory-account').data('kendoDropDownList');
      var reorderPoint      =   $('#reorder-point').data('kendoNumericTextBox');
      var onHand            =   $('#on-hand').data('kendoNumericTextBox');
      var amount            =   $('#amount').data('kendoNumericTextBox');
      var asOfDate          =   $('#as-of-date').data('kendoDatePicker');

      if (option == 0) {
        cost.enable(false);
        cogsAccount.enable(false);
        price.enable(false);
        incomeAccount.enable(false);
        inventoryAccount.enable(false);
        reorderPoint.enable(false);
        onHand.enable(false);
        amount.enable(false);
        asOfDate.enable(false);
      }else if(option == 1){
        cost.enable();
        cogsAccount.enable();
        price.enable();
        incomeAccount.enable();
        inventoryAccount.enable();
        reorderPoint.enable();
        onHand.enable();
        amount.enable();
        asOfDate.enable();
      }else if(option == 2){
        cost.enable(false);
        cogsAccount.enable(false);
        price.enable();
        incomeAccount.enable();
        inventoryAccount.enable(false);
        reorderPoint.enable(false);
        onHand.enable(false);
        amount.enable(false);
        asOfDate.enable(false);
      }
    }
    function addNew(widgetId, value) {
      var widget = $("#" + widgetId).getKendoDropDownList();
      var dataSource = widget.dataSource;

      if (confirm("Are you sure?")) {
        dataSource.add({
          id: 0,
          name: value,
          description: null,
          status: "Active"
        });

        dataSource.one("sync", function() {
          widget.select(dataSource.view().length - 1);
        });

        dataSource.sync();
        dataSource.read();
        /*dataSource = widget.dataSource.data();
        console.log(dataSource);
        console.log(measureDataSource);
        measureDataSource.unshift({value: dataSource[dataSource.length-1].value, text: dataSource[dataSource.length-1].text });
        console.log(measureDataSource);*/
      }
    };
  </script>

  <!-- Template add new dropdownlist -->
  <script id="noDataTemplate" type="text/x-kendo-tmpl">
    <div>
        No data found. Do you want to add new item - '#: instance.filterInput.val() #' ?
    </div>
    <br />
    <button class="k-button" onclick="addNew('#: instance.element[0].id #', '#: instance.filterInput.val() #')">Add new item</button>
  </script>

  <!-- Customize popup editor item --> 
  <script type="text/x-kendo-template" id="popup-editor-item">
    <div class="row-12">
      <div class="row-6">
        <div class="col-12">
          <label for="item_type_id">Item Type</label>
          <input id="item-type" name="item_type_id" data-bind="value:item_type_id" required data-required-msg="The item type field is required" style="width: 100%;" />
        </div> 

        <div class="col-12">
          <label for="code">Item Code/Bar Code</label>
            <input type="text" name="code" class="k-textbox" data-bind="value:code" required data-required-msg="The code field is required"  pattern=".{0,60}" validationMessage="The code may not be greater than 60 characters" style="width: 100%;"/>   
        </div>

        <div class="col-12">
          <label for="name">Item Name</label>
            <input type="text" name="name" class="k-textbox" data-bind="value:name" required data-required-msg="The name field is required" pattern=".{1,60}" validationMessage="The name may not be greater than 60 characters" style="width: 100%;"/>   
        </div>

        <div class="col-12">
          <label for="measure_id">Unit of Measure</label>
          <input id="measure" name="measure_id" data-bind="value:measure_id" required data-required-msg="The unit of measure field is required" style="width: 100%;" />
        </div> 

        <div class="col-12">
          <label for="category_id">Category</label>
          <input id="category" name="category_id" data-bind="value:category_id" required data-required-msg="The category field is required" style="width: 100%;" />
        </div> 

        <div class="col-12">
          <label for="discontinue">Discontinue</label>
          <input id="discontinue" name="discontinue" data-bind="value:discontinue"  style="width: 100%;" />
        </div> 

        <div class="col-12">
          <label for="sale_information">Sale Information</label>
          <textarea class="k-textbox" name="sale_information" data-bind="value:sale_information" required data-required-msg="The sale information field is required" maxlength="200" style="width: 100%; height: 97px;"/></textarea> 
        </div>

        <div class="col-12">
          <label for="price">Price</label>
          <input id="price" type="number" name="price" data-bind="value:price" style="width: 100%;"/>
        </div>

        <div class="col-12">
          <label for="income_account_id">Income Account</label>
          <input id="income-account" name="income_account_id" data-bind="value:income_account_id" style="width: 100%;" />
        </div>
      </div>
      <div class="row-6">
        <div class="col-12">
          <label for="purchase_information">Purchase Information</label>
          <textarea class="k-textbox" name="purchase_information" data-bind="value:purchase_information" required data-required-msg="The purchase information field is required" maxlength="200" style="width: 100%; height: 97px;"/></textarea> 
        </div>

        <div class="col-12">
          <label for="cost">Cost</label>
          <input id="cost" type="number" name="cost" data-bind="value:cost" style="width: 100%;"/>
        </div>

        <div class="col-12">
          <label for="cogs_account_id">COGS Account</label>
          <input id="cogs-account" name="cogs_account_id" data-bind="value:cogs_account_id" style="width: 100%;" />
        </div>

        <div class="col-12">
          <label for="inventory_account_id">Inventory Account</label>
          <input id="inventory-account" name="inventory_account_id" data-bind="value:inventory_account_id" style="width: 100%;" />
        </div>

        <div class="col-12">
          <label for="reorder_point">Reorder Point</label>
          <input id="reorder-point" type="number" name="reorder_point" data-bind="value:reorder_point" style="width: 100%;"/>
        </div>

        <div class="col-12">
          <label for="on_hand">On Hand</label>
          <input id="on-hand" type="number" name="on_hand" data-bind="value:on_hand" style="width: 100%;"/>
        </div>

        <div class="col-12">
          <label for="amount">Total Value</label>
          <input id="amount" type="number" name="amount" data-bind="value:amount" style="width: 100%;"/>
        </div>

        <div class="col-12">
          <label for="as_of_date">As of Date</label>
          <input type="text" data-type="date" id="as-of-date" name="as_of_date" data-bind="value:as_of_date" data-role='datepicker' validationMessage="The as of date is not valid date" style="width: 100%;"/>
        </div>

        <div class="col-12">
          <label for="branch_id">Branch</label>
          <input id="branch" name="branch_id" data-bind="value:branch_id" required data-required-msg="The branch field is required" style="width: 100%;" />
        </div>

         <div class="col-12">
          <label for="status">Status</label>
          <input id="status" name="status" data-bind="value:status"  style="width: 100%;" />
        </div>
      </div>
    </div>
  </script>  

@endsection