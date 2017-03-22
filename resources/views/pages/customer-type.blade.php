@extends('layouts.app')

@section('after_styles')
  <style>
  .toolbar-search {
    float: right;
    margin-right: 12px;
  }
  .fieldlist {
    margin: 0;
    padding: 0;
  }

  .fieldlist li {
      list-style: none;
  }

  .fieldlist li span {
      width: 220px;
  }
  /**/
  .col-12{
    float: left;
    width: 95%;
    padding: 0% 3% 2% 2%;
  }
  .col-6{
    float: left;
    width: 45%;
    padding: 0% 3% 2% 2%;
  }
  .col-3{
    float: left;
    width: 20%;
    padding: 0% 3% 2% 2%;
  }

                
</style>
@endsection

@section('header')
    <section class="content-header">
      <h1>Customer Type</h1>
      <ol class="breadcrumb">
        <li class="active">{{ config('app.name') }}</li>
        <li class="active">Customer</li>
        <li class="active">Type</li>
      </ol>
    </section>
@endsection

@section('content')
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default">
          <div class="box-body">
            <div id="grid"></div>  
          </div><!-- /box-body-->
        </div><!-- /box box-default-->
      </div>
    </div>   
@endsection

@section('after_scripts')
  <script>
    $(document).ready(function () {
      /**
      *It's status data for customer type
      *
      */
      var statuses = [
        {value: "ENABLED", text: "ENABLED"},
        {value: "DISABLED", text: "DISABLED"}
      ];

      var crudServiceBaseUrl = "{{url('')}}",
          dataSource = new kendo.data.DataSource({
              transport: {
                  read:  {
                      url: crudServiceBaseUrl + "/customer-type/get",
                      type: "GET",
                      dataType: "json"
                  },
                  update: {
                      url: crudServiceBaseUrl + "/customer-type/update",
                      type: "Post",
                      dataType: "json"
                  },
                  destroy: {
                      url: crudServiceBaseUrl + "/customer-type/destroy",
                      type: "Post",
                      dataType: "json"
                  },
                  create: {
                      url: crudServiceBaseUrl + "/customer-type/store",
                      type: "Post",
                      dataType: "json"
                  },
                  parameterMap: function(options, operation) {
                      if (operation !== "read" && options.models) {
                          return {models: kendo.stringify(options.models)};
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
                          name: {
                            type: "string"
                          },
                          description: { 
                            nullable: true,
                            type: "string"
                          },
                          status: { type: "string", defaultValue: "ENABLED" 
                          }                     
                      }
                  }
              }
          });

      $("#grid").kendoGrid({
          dataSource: dataSource,
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
          toolbar: [{name: "create"},{template: kendo.template($("#template").html())}],
          columns: [
              { field:"name", title: " Name" },
              { field: "description", title: " Description"},
              { field: "status", values: statuses, title: "Status" },
              { command: ["edit", "destroy"], title: "&nbsp;Action", menu: false }],
          editable: {
            mode: "popup",
            template: kendo.template($("#popup-editor").html())
          },
          edit: function (e) {
            if (e.model.isNew()) {
              createStatusDropDownList();
              e.container.data("kendoWindow").title('Add New Customer Type');
              $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
            }
            else {
              createStatusDropDownList();
              e.container.data("kendoWindow").title('Edit Customer Type');
            }
          }  
      });

      $("#txtMultiSearch").keyup(function(e){
          var q = $('#txtMultiSearch').val();

          $("#grid").data("kendoGrid").dataSource.filter({
            logic  : "or",
            filters: [
              {
                  field   : "name",
                  operator: "contains",
                  value   : q
              },
              {
                  field   : "description",
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

      //Create status DropDownList from input HTML element
      function createStatusDropDownList(){
        $("#status").kendoDropDownList({
            dataTextField: "text",
            dataValueField: "value",
            dataSource: statuses,
            index: 0
        });
      }
    });

    //Create status DropDownList from input HTML element
    
  </script>

  <!-- Create search toolbar for input HTML element --> 
  <script type="text/x-kendo-template" id="template">
      <div class="toolbar-search">
        <ul class="fieldlist">   
          <li>
              <span class="k-textbox k-space-left">
                  <input type="text" id="txtMultiSearch" placeholder="Search..." />
                  <a href="\\#" class="k-icon k-i-search">&nbsp;</a>
              </span>
          </li>  
        </ul>
      </div>
  </script>
  <!-- Customize popup editor --> 
  <script id="popup-editor" type="text/x-kendo-template">
    <div class="col-12">
      <label for="name">Name</label>
      <input type="text" name="name" class="k-textbox" placeholder="Enter name" data-bind="value:name" required validationMessage="Enter {0}" style="width: 100%;"/> 
    </div>
    <div class="col-12">
      <label for="description">Description</label>
      <textarea class="k-textbox" placeholder="Enter name" data-bind="value:description" style="width: 100%;"/></textarea> 
    </div>
    <div class="col-6">
      <label for="status">Status</label>
      <input id="status" data-bind="value:status"  style="width: 100%;" />
    </div>
</script>  
@endsection
