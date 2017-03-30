@extends('layouts.app')

@section('after_styles')
  <style>
  .toolbar-search {
    float: right;
  }
  .fieldlist {
    padding-right: 12px;
  }

  .fieldlist li {
      list-style: none;
  }

  .fieldlist li span {
      width: 220px;
  }
  </style>
@endsection

@section('header')
    <section class="content-header">
      <h1>Doctor Type</h1>
      <ol class="breadcrumb">
        <li class="active">{{ config('app.name') }}</li>
        <li class="active">Doctor Type</li>
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

        var crudServiceBaseUrl = "{{url('')}}",
            dataSource = new kendo.data.DataSource({
                transport: {
                    read:  {
                        url: crudServiceBaseUrl + "/doctor-type/get",
                        type: "GET",
                        dataType: "json"
                    },
                    update: {
                        url: crudServiceBaseUrl + "/doctor-type/update",
                        type: "Post",
                        dataType: "json"
                    },
                    destroy: {
                        url: crudServiceBaseUrl + "/doctor-type/destroy",
                        type: "Post",
                        dataType: "json"
                    },
                    create: {
                        url: crudServiceBaseUrl + "/doctor-type/store",
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
                              type: "string",
                              validation: {
                                  required: true,
                                  namevalidation: function (input) {
                                      if (input.is("[name='name']") && input.val() != "") {
                                          input.attr("data-namevalidation-msg", "Name should start with capital letter");
                                          return /^[A-Z]/.test(input.val());
                                      }

                                      return true;
                                  },
                                  maxlength:function(input) { 
                                    if (input.is("[name='name']") && input.val().length > 60) {
                                       input.attr("data-maxlength-msg", "Max length is 60");
                                       return false;
                                    }                                   
                                    return true;
                                  }
                              }
                            },
                            description: { nullable: true, validation: {
                                  descriptionvalidation: function (input) {
                                      if (input.is("[name='description']") && input.val() != "") {
                                          input.attr("data-descriptionvalidation-msg", "description should start with capital letter");
                                          return /^[A-Z]/.test(input.val());
                                      }

                                      return true;
                                  },
                                  maxlength:function(input) { 
                                    if (input.is("[name='description']") && input.val().length > 200) {
                                       input.attr("data-maxlength-msg", "Max length is 200");
                                       return false;
                                    }                                   
                                    return true;
                                  }
                              } 
                            },
                            status: { 
                            field: "status", 
                            type: "string", 
                            defaultValue: "Enabled" 
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
            toolbar: [{name: "create"},{template: kendo.template($("#textbox-multi-search").html())}],
            columns: [
                { field:"name", title: " Name" },
                { field: "description", title: " Description"},
                { field: "status", values: statusDataSource, title: "Status" },
                { command: ["edit", "destroy"], title: "&nbsp;Action", menu: false }],
            editable:{
            mode: "popup",
            window: {
              width: "600px"   
            },
            template: kendo.template($("#popup-editor-type").html())
          },
          edit: function (e) {
            //Call function status Initailize status dropdownlist 
            initStatusDropDownList();

            //Customize popup title and button label 
            if (e.model.isNew()) {
                e.container.data("kendoWindow").title('Add New Doctor Type');
                $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
            }
            else {
                e.container.data("kendoWindow").title('Edit Doctor Type');
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

    });
  </script>   
@endsection
