@extends('layouts.app')

@section('after_styles')
<style>
  .customer-photo{
    display: inline-block;
  }
  .customer-photo img{
    width:  52px;
    height: 52px;
  }
  .customer-name {
    display: inline-block;
    vertical-align: middle;
    padding-left: 5px;
  }

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
              name: { type: "string" },
              code_barcode: { type: "string", nullable: true },
              qr_code: { type: "string", nullable: true },
              lot_number: { type: "string", nullable: true },
              sku: { type: "string", nullable: true },
              expire_date: { type: "date", nullable: true }, 
              image: { type: "string", nullable: true },
              category_id: { type: "number", nullable: true },
              measure_id: { type: "number", nullable: true },
              item_type_id: { type: "number" },
              sale_information: { type: "string", nullable: true },
              income_account_id: { type: "number", nullable: true },
              expense_account_id: { type: "number", nullable: true },
              inventory_account_id: { type: "number", nullable: true },
              purchase_information: { type: "string", nullable: true },
              price: { type: "number", nullable: true },
              cost: { type: "number", nullable: true },
              on_hand: { type: "number", nullable: true },
              reorder_point: { type: "number", nullable: true },
              as_of_date: { type: "date", nullable: true }, 
              discontinue: { type: "boolean" ,defaultValue: false},
              branch_id: { type: "number" },  
              status: { type: "string", defaultValue: "Active" },   
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
        height: 750,
        toolbar: [ 
          { template: kendo.template($("#toolbar").html()) },
        ],
        pdf: {
          fileName: "Item Report.pdf"
        },
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
              var row = sheet.rows[rowIndex];e
              // apply the format to the columns found
              for (var cellIndex = 0; cellIndex < dateColumnList.length; cellIndex++) {
                var index = dateColumnList[cellIndex].i;
                row.cells[index].format = dateColumnList[cellIndex].format;
              }
            }
          }
        },
        columns: [
          { 
            template: "<div class='customer-photo'>" +
                          "<img class='img-thumbnail' src='../images/#: data.image != null ? data.image : 'no_image.jpg' #'>"+
                      "</div>" +
                      "<div class='customer-name'>#: name #</div>",
            field: "name",
            title: "Name",
            menu: false,
            width: 240
          }, 
          { field: "code_barcode", title: "Code / Bar Code", hidden: true },
          { field: "qr_code", title: "QR Code", hidden: true },
          { field: "lot_number", title: "Lot Number", hidden: true },
          { field: "sku", title: "SKU" },
          { field: "expire_date", title: "Expire Date", format: "{0:yyyy/MM/dd}", hidden: true },
          { field: "category_id", title: "Category", values: categoryDataSource },
          { field: "measure_id", title: "Unit of Measure", values: measureDataSource, hidden: true },
          { field: "item_type_id", title: "Type", values: itemTypeDataSource },
          { field: "sale_description",title: "Sale Description" },
          { field: "income_account_id", title: "Income Account", values: incomeAccountDataSource, hidden: true },
          { field: "expense_account_id", title: "Expense Account", values: cogsAccountDataSource, hidden: true },
          { field: "inventory_account_id", title: "Inventory Account", values: inventoryAccountDataSource, hidden: true },
          { field: "purchase_description",title: "Purchase Description", hidden: true },
          { field: "price", title: "Sale Price", format: "{0:c}" },
          { field: "cost", title: "Cost", format: "{0:c}" },
          { field: "on_hand", title: "Quantity On Hand" },
          { field: "as_of_date", title: "As of Date", format: "{0:yyyy/MM/dd}", hidden: true },
          { field: "reorder_point", title: "Reorder Point" },
          { field: "discontinue", title: "Discontinue", values: discontinueDataSourece, hidden: true }, 
          { field: "branch_id", title: "Branch", values: branchDataSource, hidden: true },
          { field: "status", title: "Status", values: statusDataSource },
          { field: "created_by", title: "Created By", values: userDataSource, hidden: true },
          { field: "updated_by", title: "Modified By", values: userDataSource, hidden: true },
          { field: "created_at", title: "Created At", format: "{0:yyyy/MM/dd h:mm:ss tt}", exportFormat: "yyyy/MM/dd h:mm:ss AM/PM", filterable: { ui: dateTimePickerColumnFilter }, hidden: true },
          { field: "updated_at", title: "Modified At", format: "{0:yyyy/MM/dd h:mm:ss tt}", exportFormat: "yyyy/MM/dd h:mm:ss AM/PM", filterable: { ui: dateTimePickerColumnFilter }, hidden: true },
          { command: { text: "Edit", imageClass: "k-i-edit", iconClass: "k-icon", click: editService }, title: "&nbsp;Action", menu: false }
        ]
      }); 
      
      /*Event response to key up in textbox search*/
      $(document).on('keyup', '#txtSearch', function(){
        var q = $(this).val();
        $("#grid").data("kendoGrid").dataSource.filter({
          logic  : "or",
          filters: [
            
          ]
        });
      })
    
      /*Initialize button actions*/
      $("#toolbar").kendoToolBar({
        items: [
          {
            type: "splitButton",
            id: "sbtAddNewItem",
            text: "Add new item",
            icon: "add",
            menuButtons: [
              { id: "sbtAddNewService", text: "Add new service" }
            ],
            click: function(e){
              if(e.id === "sbtAddNewItem") {
                window.location.href = "{{url('')}}/item/inventory/create";
              } else {
                window.location.href = "{{url('')}}/item/service/create";
              }
            } 
          },
          { 
            type: "separator" 
          },
          { 
            type: "button", 
            id: "btnExportToExcel",
            text: "Export to excel",
            icon: "excel",
            click: function(e){
              $("#grid").getKendoGrid().saveAsExcel();
            }
          },
          { 
            type: "button", 
            id: "btnExportToPdf",
            text: "Export to pdf",
            icon: "pdf",
            click: function(e){
              $("#grid").getKendoGrid().saveAsPDF();
            }
          },
          { 
            type: "separator" 
          },
          {
            template: "<span class='k-textbox k-space-left' style='width: 100%'><input type='text' id='txtSearch' placeholder='Find items and services'/><a href='javascript:void(0);' class='k-icon k-i-search'>&nbsp;</a></span>",
            overflow: "never"
          },
        ],
      });

      /*Create link edit serve base on row click*/
      function editService(e){
        e.preventDefault();
        var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
        if(dataItem.item_type_id == 1){
          window.location.href = "{{url('')}}/item/inventory/" +  dataItem.id + "/edit";
        }else if(dataItem.item_type_id == 2){
          window.location.href = "{{url('')}}/item/service/" +  dataItem.id + "/edit";
        }
      }
      
    });
    
  </script>

  <!-- Create actions toolbar for input HTML element --> 
  <script type="text/x-kendo-template" id="toolbar">
    <div id="toolbar" class="toolbar"></div>  
  </script> 


@endsection