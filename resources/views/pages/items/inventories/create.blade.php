@extends('layouts.app')

@section('after_styles')
<style>
.k-widget .border-box-sizing, 
.k-widget .border-box-sizing * {
    box-sizing: border-box;
}

.tabstrip-content {
  padding-left: 0px !important;
  padding-right: 0px !important;
  height: 120px;
}
</style>
@endsection

@section('header')
  <section class="content-header">
    <h1>
      Add <span class="text-lowercase">item</span>
    </h1>
    <ol class="breadcrumb">
    <li><a href="{{ url('').'/dashboard' }}">{{ config('app.name') }}</a></li>
      <li><a href="{{ url('').'/item' }}" class="text-capitalize">items</a></li>
      <li class="active">Add</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <a href="{{ url('').'/item' }}"><i class="fa fa-angle-double-left"></i> Back to all  <span class="text-lowercase">items</span></a><br><br>
      <form method="POST" action="{{ url('').'/item/inventory/store' }}" accept-charset="UTF-8">
        {{ csrf_field() }}
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Add a new item (inventory)</h3>
          </div>
          <div class="box-body">
            <div class="form-horizontal form-widgets col-sm-12">
              <div class="form-horizontal form-widgets col-sm-6">
                <div class="form-group">
                  <label class="control-label col-sm-4" for="code_barcode">Code/Barcode*</label>
                  <div class="col-sm-8 col-md-6">
                    <input id="code-barcode" name="code" class="k-textbox" style="width: 100%">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="qr_code">QR code</label>
                  <div class="col-sm-8 col-md-6">
                    <input id="qr_code" name="qrCode" class="k-textbox" style="width: 100%">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="sku">SKU</label>
                  <div class="col-sm-8 col-md-6">
                    <input id="sku" name="sku" class="k-textbox" style="width: 100%">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="lot">Lot number</label>
                  <div class="col-sm-8 col-md-6">
                    <input id="lot" name="lotNumber" class="k-textbox" style="width: 100%">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="">Expire date</label>
                  <div class="col-sm-8 col-md-6">
                    <input id="expireDate" name="expireDate" type="text" data-type="date" data-role='datepicker' validationMessage="The expire date field is not valid date" style="width: 100%;"/>
                  </div>
                </div> 
                <div class="form-group">
                  <label class="control-label col-sm-4" for="name">Name*</label>
                  <div class="col-sm-8 col-md-6">
                    <input id="name" name="name" class="k-textbox" style="width: 100%">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="category">category</label>
                  <div class="col-sm-8 col-md-6">
                    <input id="category" name="categoryId" style="width: 100%">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="measure">Unit of measure</label>
                  <div class="col-sm-8 col-md-6">
                    <input id="measure" name="measureId" style="width: 100%">
                  </div>
                </div>
                 <div class="form-group">
                  <label class="control-label col-sm-4" for="discontinue">Discontinue</label>
                  <div class="col-sm-8 col-md-6">
                    <input id="discontinue" name="discontinue" style="width: 100%">
                  </div>
                </div>
              </div>
              <div class="form-horizontal form-widgets col-sm-6">
                <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-8 col-md-6">
                    <img id="imagePreview" src="../../images/no_image.jpg" class="img-rounded" width="150" height="160">
                  </div> 
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-8 col-md-6">
                    <input id="image" name="image"  type="file"> 
                  </div> 
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="branch">Branch</label>
                  <div class="col-sm-8 col-md-6">
                    <input id="branch" name="branchId" style="width: 100%">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4" for="status">Status</label>
                  <div class="col-sm-8 col-md-6">
                    <input id="status" name="status" style="width: 100%">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-horizontal form-widgets col-sm-12">
              <div id="tabstrip">
                <ul>
                  <li class="k-state-active">
                      Inventory information
                  </li>
                  <li>
                      Sale information
                  </li>
                  <li>
                      Purchase information
                  </li>
                </ul>
                <div class="tabstrip-content"> 
                  <div class="border-box-sizing">
                    <div class="form-horizontal form-widgets col-sm-6">
                      <div class="form-group">
                        <label class="control-label col-sm-4" for="inventory_account_id">Inventory account</label>
                        <div class="col-sm-8 col-md-6">
                          <input id="inventoryAccount" name="inventoryAccountId" style="width: 100%">
                        </div>
                      </div> 
                      <div class="form-group">
                        <label class="control-label col-sm-4" for="on_hand">Initial quantity on hand*</label>
                        <div class="col-sm-8 col-md-6">
                          <input id="onHand" name="onHand" type="number" style="width: 100%">
                        </div>
                      </div> 
                    </div>
                    <div class="form-horizontal form-widgets col-sm-6">
                      <div class="form-group">
                        <label class="control-label col-sm-4" for="">As of date*</label>
                        <div class="col-sm-8 col-md-6">
                          <input id="asOfDate" name="asOfDate" type="text" data-type="date" data-role='datepicker' validationMessage="The as of date field is not valid date" style="width: 100%;"/>
                        </div>
                      </div> 
                      <div class="form-group">
                        <label class="control-label col-sm-4" for="">Reorder point</label>
                        <div class="col-sm-8 col-md-6">
                          <input id="reorderPoint" name="reorderPoint" type="number" style="width: 100%">
                        </div>
                      </div>   
                    </div>
                  </div> 
                </div>
                <div class="tabstrip-content">
                  <div class="border-box-sizing">
                    <div class="form-horizontal form-widgets col-sm-6">
                      <div class="form-group">
                        <label class="control-label col-sm-4" for="income_account_id">Income account</label>
                        <div class="col-sm-8 col-md-6">
                          <input id="incomeAccount" name="incomeAccountId" style="width: 100%">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-4" for="price">Price</label>
                        <div class="col-sm-8 col-md-6">
                          <input id="price" name="price" class="k-textbox" style="width: 100%">
                        </div>
                      </div>
                    </div>
                    <div class="form-horizontal form-widgets col-sm-6">
                      
                       <div class="form-group">
                        <label class="control-label col-sm-4" for="sale_info">Desciption</label>
                        <div class="col-sm-8 col-md-6">
                          <textarea id="sale_info" name="saleDescription" class="k-textbox" style="width: 100%"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tabstrip-content">
                  <div class="border-box-sizing">
                    <div class="form-horizontal form-widgets col-sm-6">
                      <div class="form-group">
                        <label class="control-label col-sm-4" for="expense_account_id">Expanse account</label>
                        <div class="col-sm-8 col-md-6">
                          <input id="expenseAccount" name="expenseAccountId" style="width: 100%">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-4" for="price">Cost</label>
                        <div class="col-sm-8 col-md-6">
                          <input id="cost" name="cost" class="k-textbox" style="width: 100%">
                        </div>
                      </div>
                    </div>
                    <div class="form-horizontal form-widgets col-sm-6">
                      <div class="form-group">
                        <label class="control-label col-sm-4" for="purchase_info">Desciption</label>
                        <div class="col-sm-8 col-md-6">
                          <textarea id="purchase_info" name="purchaseDescription" class="k-textbox" style="width: 100%;"></textarea>
                        </div>
                      </div> 
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer">
              <div class="form-horizontal form-widgets col-sm-12 text-right">
                  <button type="submit" class="k-button k-button-icontext k-primary"><span class="k-icon k-i-check"></span>Save</button>
                  <button type="button" class="k-button k-button-icontext"><span class="k-icon k-i-cancel"></span>Cancel</button>
              </div>
          </div>
        </div>
      </form>
    </div>
  </div>   
@endsection

@section('after_scripts')     
  <script>
   /*Discontinue data source*/
    var discontinueDataSourece    =   [ {value: false, text: "No"}, {value: true, text: "Yes"} ];

    $(document).ready(function () {

      /*Initailize expire date datepicker*/
      $("#expireDate").kendoDatePicker({
        parseFormats: ["dd/MM/yyyy", "yyyy/MM/dd"],
        format: "yyyy/MM/dd" 
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
      /*Initialize unit of measure dropdownlist*/
      $("#measure").kendoDropDownList({
        filter: "startswith",
        optionLabel: "-Select unit of measure-",
        dataValueField: "value",
        dataTextField: "text",
        dataSource: {
          transport: {
            read: {
              url: crudBaseUrl + "/item/measure/list/dropdownlist",
              type: "GET",
              dataType: "json"
            }
          }
        },
        noDataTemplate: $("#noDataTemplate").html()
      });

      /*Initialize discontinue dropdownlist*/ 
      $("#discontinue").kendoDropDownList({
        dataValueField: "value",
        dataTextField: "text",
        dataSource: discontinueDataSourece
      });

      /*Initialize image upload*/
      $("#image").kendoUpload({
        multiple: false,
        validation: {
          allowedExtensions: [".gif", ".jpg", ".png"]
        },
        select: function(e) {
          var file = e.files[0];
          setTimeout(function(){
            preview(file);
          });
        },
        remove: function() {
          $("#imagePreview").attr("src", "../../images/no_image.jpg");  
        }
      });

      /*Preview image file*/
      function preview(file) {
        var raw     = file.rawFile;
        var reader  = new FileReader();

        if (raw) {
          reader.onloadend = function () {
            $("#imagePreview").attr("src", this.result);
          };
          reader.readAsDataURL(raw);
        }
      }

      /*Initialize branch dropdownlist*/
      initBranchDropDownList();

      /*Initialize status dropdownlist*/
      initStatusDropDownList();

      /*Initialize item inoformation tabstrip*/
      $("#tabstrip").kendoTabStrip({
          animation:  {
              open: {
                  effects: "fadeIn"
              }
          }
      });

      /*Initialize inventory account dropdownlist*/
      $("#inventoryAccount").kendoDropDownList({
        dataValueField: "id",
        dataTextField: "name",
        valueTemplate: "#: data.code + '.' + data.name #",
        template: "#: data.code + '.' + data.name #",
        dataSource: {
          transport: {
            read: {
              url: crudBaseUrl + "/account/type/3/account/dropdownlist",
              type: "GET",
              dataType: "json"
            }
          }
        }
      });

      /*Initialize on hand NumericTextBox*/
      $("#onHand").kendoNumericTextBox({
          format: "0",
          decimals: 0,
          min: 0,
          max: 10000000,
      });

      /*Initailize as of date datepicker*/
      $("#asOfDate").kendoDatePicker({
        parseFormats: ["dd/MM/yyyy", "yyyy/MM/dd"],
        format: "yyyy/MM/dd" 
      });

      /*Initialize reorder poit NumericTextBox*/
      $("#reorderPoint").kendoNumericTextBox({
          format: "0",
          decimals: 0,
          min: 0,
          max: 10000000,
      });

      /*Initialize income account dropdownlist*/
      $("#incomeAccount").kendoDropDownList({
        dataValueField: "id",
        dataTextField: "name",
        valueTemplate: "#: data.code + '.' + data.name #",
        template: "#: data.code + '.' + data.name #",
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

      /*Initialize expense account dropdownlist*/
      $("#expenseAccount").kendoDropDownList({
        dataValueField: "id",
        dataTextField: "name",
        valueTemplate: "#: data.code + '.' + data.name #",
        template: "#: data.code + '.' + data.name #",
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

    });
  </script>
@endsection