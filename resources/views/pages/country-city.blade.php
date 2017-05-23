@extends('layouts.app')

@section('after_styles')
<style>

</style>
@endsection

@section('header')
  <section class="content-header">
    <h1>Setup Country &amp; City</h1>
    <ol class="breadcrumb">
      <li class="active">{{ config('app.name') }}</li>
      <li class="active">Setup Data</li>
      <li class="active">Setup Country &amp; City</li>
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
    /*user data source*/
    var userDataSource = JSON.parse(<?php echo json_encode($users) ?>);

    $(document).ready(function () {
      /*Country data source*/
      var gridDataSource = new kendo.data.DataSource({
        transport: {
          read: {
            url: crudBaseUrl + "/country/get",
            type: "GET",
            dataType: "json"
          },
          update: {
            url: crudBaseUrl + "/country/update",
            type: "POST",
            dataType: "json"
          },
          destroy: {
            url: crudBaseUrl + "/country/destroy",
            type: "POST",
            dataType: "json"
          },
          create: {
            url: crudBaseUrl + "/country/store",
            type: "POST",
            dataType: "json"
          },
          parameterMap: function (options, operation) {
            if (operation !== "read" && options.models) {
              return { countries: kendo.stringify(options.models) };
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
              description: { type: "string", nullable: true },   
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
        detailInit: detailInit,
        sortable: { mode: "single", allowUnsort: false },
        pageable: { refresh:true, pageSizes: true, buttonCount: 5 },
        height: 550,
        toolbar: [ 
          { name: "create", text: "Add New Country" }, 
          { template: kendo.template($("#textbox-multi-search").html()) } 
        ],
        columns: [
          { field: "name", title: "Name" },
          { field: "description", title: "Description" },
          { field: "status", title: "Status", values: statusDataSource },
          { field: "created_by", title: "Created By", values: userDataSource },
          { field: "updated_by", title: "Modified By", values: userDataSource },
          { field: "created_at", title: "Created At", format: "{0:yyyy/MM/dd h:mm:ss tt}", filterable: { ui: dateTimePickerColumnFilter } },
          { field: "updated_at", title: "Modified At", format: "{0:yyyy/MM/dd h:mm:ss tt}", filterable: { ui: dateTimePickerColumnFilter } },
          { command: ["edit", "destroy"], title: "&nbsp;Action", menu: false }
        ],
        editable: { mode: "popup", window: { width: "600px" }, template: kendo.template($("#popup-editor-type").html()) },
        edit: function (e) {
          /*Customize popup title and button label */
          if (e.model.isNew()) {
            e.container.data("kendoWindow").title('Add New Country');
            $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
          }
          else {
            e.container.data("kendoWindow").title('Edit Country');
          }
          /*Initialize status dropdownlist*/
          initStatusDropDownList();
        } 
      }); 

      /*Event response to key up in textbox multi search*/
      $("#txtMultiSearch").keyup(function(e){  
        var q = $('#txtMultiSearch').val();
        $("#grid").data("kendoGrid").dataSource.filter({
          logic  : "or",
          filters: [
            { field: "name", operator: "contains", value: q },
            { field: "description", operator: "contains", value: q },
            { field: "status", operator: "eq", value: q }
          ]
        });
      });

      /*City data source*/
      function detailInit(event){
        var countryId = event.data.id;
        $("<div/>").appendTo(event.detailCell).kendoGrid({
          dataSource: {
            transport: {
              read: {
                url: crudBaseUrl + "/city/list/all/" + countryId,
                type: "GET",
                dataType: "json"
              },
              update: {
                url: crudBaseUrl + "/city/update",
                type: "POST",
                dataType: "json"
              },
              destroy: {
                url: crudBaseUrl + "/city/destroy",
                type: "POST",
                dataType: "json"
              },
              create: {
                url: crudBaseUrl + "/city/store",
                type: "POST",
                dataType: "json"
              },
              parameterMap: function (options, operation) {
                if (operation !== "read" && options.models) {
                  return { cities: kendo.stringify(options.models) };
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
                  master_detail_id: { defaultValue: countryId },
                  name: { type: "string" }, 
                  description: { type: "string", nullable: true },   
                  status: { type: "string", defaultValue: "Active" },
                  created_by: { type: "number", editable: false, nullable: true }, 
                  updated_by: { type: "number", editable: false, nullable: true },
                  created_at: { type: "date", editable: false, nullable: true }, 
                  updated_at: { type: "date", editable: false, nullable: true }                    
                }
              }
            },
          }, 
          navigatable: true,
          reorderable: true,
          resizable: true,
          columnMenu: true,
          filterable: true,
          sortable: { mode: "single", allowUnsort: false },
          pageable: { refresh:true, pageSizes: true, buttonCount: 5 },
          toolbar: [ { name: "create", text: "Add New City"} ],
          columns: [
            { field: "name", title: "Name" },
            { field: "description", title: "Description" },
            { field: "status", title: "Status", values: statusDataSource },
            { field: "created_by", title: "Created By", values: userDataSource },
            { field: "updated_by", title: "Modified By", values: userDataSource },
            { field: "created_at", title: "Created At", format: "{0:yyyy/MM/dd h:mm:ss tt}", filterable: { ui: dateTimePickerColumnFilter } },
            { field: "updated_at", title: "Modified At", format: "{0:yyyy/MM/dd h:mm:ss tt}", filterable: { ui: dateTimePickerColumnFilter } },
            { command: ["edit", "destroy"], title: "&nbsp;Action", menu: false }
          ],
          editable: { mode: "popup", window: { width: "600px" }, template: kendo.template($("#popup-editor-type").html()) },
          edit: function (e) {
            /*Customize popup title and button label*/
            if (e.model.isNew()) {
              e.container.data("kendoWindow").title('Add New City');
              $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
            }
            else {
              e.container.data("kendoWindow").title('Edit City');
            }

            /*Initialize status dropdownlist*/
            initStatusDropDownList();
          } 
        });
      }
    });
  </script>  

@endsection