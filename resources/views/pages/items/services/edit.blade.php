@extends('layouts.app')

@section('after_styles')
<style>

</style>
@endsection

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
      <form id="frmService" method="POST" action="{{ url('').'/item/service/'.$id.'/update' }}" accept-charset="UTF-8">
        {{ csrf_field() }}
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Edit item (service)</h3>
          </div>
          <div class="box-body row">
              <div class="col-sm-12">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                  <label for="name">Name*</label>
                  <input id="name" name="name" value="{{ $name or old('name') }}" class="k-textbox form-control" style="width: 100%">
                  @if ($errors->has('name'))
                    <span class="help-block">
                      <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group{{ $errors->has('sku') ? ' has-error' : '' }}">
                  <label for="sku">SKU</label>
                  <input id="sku" name="sku" value="{{ $sku or old('sku') }}" class="k-textbox form-control" style="width: 100%">
                  @if ($errors->has('sku'))
                    <span class="help-block">
                      <strong>{{ $errors->first('sku') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                  <label for="image">Image</label>
                  <input id="image" name="image" accept="image/*" value="{{ $image or old('image') }}" type="file" class="form-control" style="width: 100%"> 
                  @if ($errors->has('image'))
                    <span class="help-block">
                      <strong>{{ $errors->first('image') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                  <label for="category_id">Category</label>
                  <input id="category" name="category_id" value="{{$category_id or old('category_id') }}" class="form-control" style="width: 100%">
                  @if ($errors->has('category_id'))
                    <span class="help-block">
                      <strong>{{ $errors->first('category_id') }}</strong>
                    </span>
                  @endif
                </div>
                <hr style="border-top: 1px solid #dcdcdc;">
                <div class="form-group{{ $errors->has('sale_description') ? ' has-error' : '' }}">
                  <label for="sale_description">Sale description</label>
                  <textarea id="saleDescription" name="sale_description" class="k-textbox" style="width: 100%">{{ $sale_description or old('sale_description') }}</textarea>
                  @if ($errors->has('sale_description'))
                    <span class="help-block">
                      <strong>{{ $errors->first('sale_description') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                  <label for="price">Price</label>
                  <input id="price" name="price" value="{{ $price or old('price') }}" type="number"  style="width: 100%">
                  @if ($errors->has('price'))
                    <span class="help-block">
                      <strong>{{ $errors->first('price') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group{{ $errors->has('income_account_id') ? ' has-error' : '' }}">
                  <label for="income_account_id">Income account</label>
                  <input id="incomeAccount" name="income_account_id" value="{{ $income_account_id or old('income_account_id') }}" class="form-control" style="width: 100%">
                  @if ($errors->has('income_account_id'))
                    <span class="help-block">
                      <strong>{{ $errors->first('income_account_id') }}</strong>
                    </span>
                  @endif
                </div>
                <hr style="border-top: 1px solid #dcdcdc;">
                <div class="form-group{{ $errors->has('branch') ? ' has-error' : '' }}">
                  <label for="branch">Branch</label>
                  <input id="branch" name="branch_id" value="{{ $branch_id or old('branch_id') }}" class="form-control" style="width: 100%">
                  @if ($errors->has('branch'))
                    <span class="help-block">
                      <strong>{{ $errors->first('branch') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                  <label for="status">Status</label>
                  <input id="status" name="status" value="{{ $status or old('status') }}" class="form-control" style="width: 100%">
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
    $(document).ready(function () {
      /*Initialize category dropdownlist*/
      initCategoryDropDownList();

      /*Initialize image upload*/
      initImageUpload();

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

      /*Initialize branch dropdownlist*/
      initBranchDropDownList();

      /*Initialize status dropdownlist*/
      initStatusDropDownList();

      /*Initialize button action*/
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
          $('#frmService').submit();
        }else if(e.id==="sbtSaveAndEdit"){
          $('#hdnSaveAction').val("save_and_edit");
          $('#frmService').submit();
        }else if(e.id==="sbtSaveAndNew"){
          $('#hdnSaveAction').val("save_and_new");
          $('#frmService').submit();
        }
      }

      /*Action cancel handler*/
      function buttonClickHandler(e){
        if(e.id==="btnCancel"){
          window.location.href = "{{url('')}}/item"
        }
      }
    });
  </script>
@endsection