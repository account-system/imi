@extends('layouts.app')

@section('after_styles')
<style>

</style>
@endsection

<?php
  $expireDate = str_replace('-', '/', $expire_date);
  $asOfDate   = str_replace('-', '/', $as_of_date);
?>

@section('header')
  <section class="content-header">
    <h1>
      Edit <span class="text-lowercase">item</span>
    </h1>
    <ol class="breadcrumb">
    <li><a href="{{ url('').'/dashboard' }}">{{ config('app.name') }}</a></li>
      <li><a href="{{ url('').'/item' }}" class="text-capitalize">items</a></li>
      <li class="active">Edit</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-offset-2 col-md-8">
      <a href="{{ url('').'/item' }}"><i class="fa fa-angle-double-left"></i> Back to all  <span class="text-lowercase">items</span></a><br><br>
      @if(count($errors) > 0)
        <div class="callout callout-danger">
          <h4>Please fix the following errors:</h4>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <form id="frmInventory" method="POST" action="{{ url('').'/item/inventory/'.$id.'/update' }}" accept-charset="UTF-8">
        {{ csrf_field() }}
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Edit item (inventory)</h3>
          </div>
          <div class="box-body row">
            <div class="col-sm-12">
              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name">Name*</label>
                <input id="name" type="text" name="name" value="{{ $name or old('name') }}" class="k-textbox form-control" style="width: 100%">
                @if ($errors->has('name'))
                  <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('code_barcode') ? ' has-error' : '' }}">
                <label for="code_barcode">Code / Barcode</label>
                <input id="codeBarcode" type="text" name="code_barcode" value="{{ $code_barcode or old('code_barcode') }}" class="k-textbox form-control" style="width: 100%">
                @if ($errors->has('code_barcode'))
                  <span class="help-block">
                    <strong>{{ $errors->first('code_barcode') }}</strong>
                  </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('qr_code') ? ' has-error' : '' }}">
                <label for="qr_code">QR code</label>
                <input id="qrCode" type="text" name="qr_code" value="{{ $qr_code or old('qr_code') }}" class="k-textbox form-control" style="width: 100%">
                @if ($errors->has('qr_code'))
                  <span class="help-block">
                    <strong>{{ $errors->first('qr_code') }}</strong>
                  </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('lot_number') ? ' has-error' : '' }}">
                <label for="lot_number">Lot number</label>
                <input id="lotNumber" type="text" name="lot_number" value="{{ $lot_number or old('lot_number') }}" class="k-textbox form-control" style="width: 100%">
                @if ($errors->has('lot_number'))
                  <span class="help-block">
                    <strong>{{ $errors->first('lot_number') }}</strong>
                  </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('sku') ? ' has-error' : '' }}">
                <label for="sku">SKU</label>
                <input id="sku" type="text" name="sku" value="{{ $sku or old('sku') }}" class="k-textbox form-control" style="width: 100%">
                @if ($errors->has('sku'))
                  <span class="help-block">
                    <strong>{{ $errors->first('sku') }}</strong>
                  </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('expire_date') ? ' has-error' : '' }}">
                <label for="expire_date">Expire date</label>
                <input id="expireDate" type="text" name="expire_date" value="{{ $expireDate or old('expireDate') }}" data-type="date" data-role='datepicker' class="form-control" style="width: 100%;">
                @if ($errors->has('expire_date'))
                  <span class="help-block">
                    <strong>{{ $errors->first('expire_date') }}</strong>
                  </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                <label for="image">Image</label>
                <input id="image" type="file" name="image" accept="image/*" value="{{ $image or old('image') }} " class="form-control"> 
                @if ($errors->has('image'))
                  <span class="help-block">
                    <strong>{{ $errors->first('image') }}</strong>
                  </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                <label for="category_id">category</label>
                <input id="category" type="text" name="category_id" value="{{ $category_id or old('category_id') }}" class="form-control" style="width: 100%">
                @if ($errors->has('category_id'))
                  <span class="help-block">
                    <strong>{{ $errors->first('category_id') }}</strong>
                  </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('measure_id') ? ' has-error' : '' }}">
                <label for="measure_id">Unit of measure</label>
                <input id="measure" type="text" name="measure_id" value="{{ $measure_id or old('measure_id') }}" class="form-control" style="width: 100%">
                @if ($errors->has('measure_id'))
                  <span class="help-block">
                    <strong>{{ $errors->first('measure_id') }}</strong>
                  </span>
                @endif
              </div>
               <div class="form-group{{ $errors->has('discontinue') ? ' has-error' : '' }}">
                <label for="discontinue">Discontinue</label>
                <input id="discontinue" type="text" name="discontinue" value="{{ $discontinue or old('discontinue') }}" class="form-control" style="width: 100%">
                @if ($errors->has('discontinue'))
                  <span class="help-block">
                    <strong>{{ $errors->first('discontinue') }}</strong>
                  </span>
                @endif
              </div>
              <hr style="border-top: 1px solid #dcdcdc;">
              <div class="form-group{{ $errors->has('on_hand') ? ' has-error' : '' }}">
                <label for="on_hand">Initial quantity on hand*</label>
                <input id="onHand" type="number" name="on_hand" value="{{ $on_hand or old('on_hand') }}" style="width: 100%">
                @if ($errors->has('on_hand'))
                  <span class="help-block">
                    <strong>{{ $errors->first('on_hand') }}</strong>
                  </span>
                @endif
              </div> 
              <div class="form-group{{ $errors->has('as_of_date') ? ' has-error' : '' }}">
                <label for="as_of_date">As of date*</label>
                 <input id="asOfDate" type="text" name="as_of_date" value="{{ $asOfDate or old('as_of_date') }}" data-type="date" data-role='datepicker' class="form-control" style="width: 100%;"/>
                 @if ($errors->has('as_of_date'))
                  <span class="help-block">
                    <strong>{{ $errors->first('as_of_date') }}</strong>
                  </span>
                @endif
              </div> 
              <div class="form-group{{ $errors->has('reorder_point') ? ' has-error' : '' }}">
                <label for="reorder_point">Reorder point</label>
                <input id="reorderPoint" type="number" name="reorder_point" value="{{ $reorder_point or old('reorder_point') }}"  style="width: 100%">
                @if ($errors->has('reorder_point'))
                  <span class="help-block">
                    <strong>{{ $errors->first('reorder_point') }}</strong>
                  </span>
                @endif
              </div>  
              <hr style="border-top: 1px solid #dcdcdc;">
              <div class="form-group{{ $errors->has('inventory_account_id') ? ' has-error' : '' }}">
                <label for="inventory_account_id">Inventory asset account</label>
                <input id="inventoryAccount" type="text" name="inventory_account_id" value="{{ $inventory_account_id or old('inventory_account_id') }}" class="form-control" style="width: 100%">
                @if ($errors->has('inventory_account_id'))
                  <span class="help-block">
                    <strong>{{ $errors->first('inventory_account_id') }}</strong>
                  </span>
                @endif
              </div> 
              <hr style="border-top: 1px solid #dcdcdc;">
              <div class="form-group{{ $errors->has('sale_description') ? ' has-error' : '' }}">
                <label for="sale_description">Sale description</label>
                <textarea id="saleDescription" name="sale_description" class="k-textbox form-control" style="width: 100%">{{ $sale_description or old('sale_description') }}</textarea>
                @if ($errors->has('sale_description'))
                  <span class="help-block">
                    <strong>{{ $errors->first('sale_description') }}</strong>
                  </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                <label for="price">Price</label>
                <input id="price" type="number" name="price" value="{{ $price or old('price') }}" style="width: 100%">
                @if ($errors->has('price'))
                  <span class="help-block">
                    <strong>{{ $errors->first('price') }}</strong>
                  </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('income_account_id') ? ' has-error' : '' }}">
                <label for="income_account_id">Income account</label>
                <input id="incomeAccount" type="text" name="income_account_id" value="{{ $income_account_id or old('income_account_id') }}" class="form-control" style="width: 100%">
                @if ($errors->has('income_account_id'))
                  <span class="help-block">
                    <strong>{{ $errors->first('income_account_id') }}</strong>
                  </span>
                @endif
              </div>
              <hr style="border-top: 1px solid #dcdcdc;">
              <div class="form-group{{ $errors->has('purchase_description') ? ' has-error' : '' }}">
                <label for="purchase_description">Purchase description</label>
                <textarea id="purchaseDescription" name="purchase_description" class="k-textbox form-control" style="width: 100%;">{{ $purchase_description or old('purchase_description') }}</textarea>
                @if ($errors->has('purchase_description'))
                  <span class="help-block">
                    <strong>{{ $errors->first('purchase_description') }}</strong>
                  </span>
                @endif
              </div> 
              <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
                <label for="cost">Cost</label>
                <input id="cost" type="number" name="cost" value="{{ $income_account_id or old('income_account_id') }}" style="width: 100%">
                @if ($errors->has('cost'))
                  <span class="help-block">
                    <strong>{{ $errors->first('cost') }}</strong>
                  </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('expense_account_id') ? ' has-error' : '' }}">
                <label for="expense_account_id">Expanse account</label>
                <input id="expenseAccount" type="text" name="expense_account_id" value="{{ $expense_account_id or old('expense_account_id') }}" class="form-control" style="width: 100%">
                @if ($errors->has('expense_account_id'))
                  <span class="help-block">
                    <strong>{{ $errors->first('expense_account_id') }}</strong>
                  </span>
                @endif
              </div>
              <hr style="border-top: 1px solid #dcdcdc;">
              <div class="form-group{{ $errors->has('branch_id') ? ' has-error' : '' }}">
                <label for="branch_id">Branch</label>
                <input id="branch" type="text" name="branch_id" value="{{ $branch_id or old('branch_id') }}" class="form-control" style="width: 100%">
                @if ($errors->has('branch_id'))
                  <span class="help-block">
                    <strong>{{ $errors->first('branch_id') }}</strong>
                  </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                <label for="status">Status</label>
                <input id="status" type="text" name="status" value="{{ $status or old('status') }}" class="form-control" style="width: 100%">
                @if ($errors->has('status'))
                  <span class="help-block">
                    <strong>{{ $errors->first('status') }}</strong>
                  </span>
                @endif
              </div>
            </div>
          </div>
          <div class="box-footer">
            <div id="action" class="action"></div>
          </div>
        </div>
        <input id="hdnSaveAction" name="save_action"  type="hidden">
      </form>
    </div>
  </div>   
@endsection

@section('after_scripts')     
  <script>
   /*Discontinue data source*/
    var discontinueDataSourece    =   [ {value: 0, text: "No"}, {value: 1, text: "Yes"} ];

    $(document).ready(function () {

      /*Initailize expire date datepicker*/
      $("#expireDate").kendoDatePicker({
        parseFormats: ["dd/MM/yyyy", "yyyy/MM/dd"],
        format: "yyyy/MM/dd" 
      });

      /*Initialize image upload*/
      initImageUpload();

      /*Initialize category dropdownlist*/
      initCategoryDropDownList();

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
            dataType: "json",
            complete: function(result){
              var data = result.responseJSON[0];
              $("#measure").data('kendoDropDownList').dataSource.read().then(function(){
                var measure =  $("#measure").data('kendoDropDownList');
                measure.select(function(dataItem){
                  return dataItem.value === data.id;
                });
              });
            }
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

      /*Initialize unit of measure dropdownlist*/
      $("#measure").kendoDropDownList({
        filter: "startswith",
        optionLabel: "-Select unit of measure-",
        dataValueField: "value",
        dataTextField: "text",
        dataSource: measureDropDownListDataSource,
        noDataTemplate: $("#noDataTemplate").html()
      });

      /*Initialize discontinue dropdownlist*/ 
      $("#discontinue").kendoDropDownList({
        dataValueField: "value",
        dataTextField: "text",
        dataSource: discontinueDataSourece
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
        format: "yyyy/MM/dd",
        dateInput: true
      });

      /*Initialize reorder poit NumericTextBox*/
      $("#reorderPoint").kendoNumericTextBox({
          format: "0",
          decimals: 0,
          min: 0,
          max: 10000000,
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

      /*Initialize price numerictextbox*/
      $("#price").kendoNumericTextBox({
          format: "c",
          min: 0,
          max: 99999999.99,
          decimals: 2,
          round: false
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

      /*Initialize cost numerictextbox*/
      $("#cost").kendoNumericTextBox({
          format: "c",
          min: 0,
          max: 99999999.99,
          decimals: 2,
          round: false
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

      /*Initialize branch dropdownlist*/
      initBranchDropDownList();

      /*Initialize status dropdownlist*/
      initStatusDropDownList();

      /*Initialize button actions*/
      $("#action").kendoToolBar({
        items: [
          {
            type: "splitButton",
            id: "sbtSaveAndBack",
            text: "Save and back",
            icon: "save",
            menuButtons: [
              { id: "sbtSaveAndEdit", text: "Save and edit this item" },
              { id: "sbtSaveAndNew", text: "Save and new item" },
            ],
            click: splitButtonClickHandler
          },
          {
            type: "button",
            id: "btnCancel",
            text: "Cancel",
            icon: "cancel",
            click: buttonClickHandler
          }
        ],
      });

      /*Action split button handler*/
      function splitButtonClickHandler(e){
        if(e.id==="sbtSaveAndBack"){
          $('#hdnSaveAction').val("save_and_back");
          $('#frmInventory').submit();
        }else if(e.id==="sbtSaveAndEdit"){
          $('#hdnSaveAction').val("save_and_edit");
          $('#frmInventory').submit();
        }else if(e.id==="sbtSaveAndNew"){
          $('#hdnSaveAction').val("save_and_new");
          $('#frmInventory').submit();
        }
      }

      /*Action cancel handler*/
      function buttonClickHandler(e){
        if(e.id==="btnCancel"){
          window.location.href = "{{url('')}}/item";
        }
      }

    });
  </script>
@endsection