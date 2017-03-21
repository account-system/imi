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
      <h1>Vendor Lists</h1>
      <ol class="breadcrumb">
        <li class="active">{{ config('app.name') }}</li>
        <li class="active">Vendor</li>
        <li class="active">Lists</li>
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
                    read: {
                        url: crudServiceBaseUrl + "/vendor-lists/get",
                        type: "GET",
                        dataType: "json"
                    },
                    update: {
                        url: crudServiceBaseUrl + "/vendor-lists/update",
                        type: "POST",
                        dataType: "json"
                    },
                    destroy: {
                        url: crudServiceBaseUrl + "/vendor-lists/destroy",
                        type: "POST",
                        dataType: "json"
                    },
                    create: {
                        url: crudServiceBaseUrl + "/vendor-lists/store",
                        type: "POST",
                        dataType: "json"
                    },
                    parameterMap: function (options, operation) {
                        if (operation !== "read" && options.models) {
                            return { models: kendo.stringify(options.models) };
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
                        vendor_type_id: { type: "string", validation: { required: true, min: 1} },
                        branch_id: { type: "string", validation: { required: true, min: 1} },
                        company_name: {
                            validation: {
                              required: false,
                              nullable:true,
                                    // campanynamevalidation: function (input) {
                                    //     if (input.is("[name='company_name']") && input.val() != "") {
                                    //         input.attr("data-campanynamevalidation-msg", "Product Name should start with capital letter");
                                    //         return /^[A-Z]/.test(input.val());
                                    //     }
                                    //     return true;
                                    // }
                              },
                              maxlength:function(input) { 
                                  if (input.is("[name='company_name']") && input.val().length > 60) {
                                     input.attr("data-maxlength-msg", "Max length is 200");
                                     return false;
                                  }                                   
                                  return true;
                                }
                            },
                            contact_name: {
                              validation: {
                                required: false,
                                nullable:true,
                                  // contactnamevalidation: function (input) {
                                  //       if (input.is("[name='contact_name']") && input.val() != "") {
                                  //           input.attr("data-contactnamevalidation-msg", "Product Name should start with capital letter");
                                  //           return /^[A-Z]/.test(input.val());
                                  //       }

                                  //       return true;
                                  //   }
                                },
                            maxlength:function(input) { 
                                if (input.is("[name='contact_name']") && input.val().length > 60) {
                                   input.attr("data-maxlength-msg", "Max length is 200");
                                   return false;
                                }                                   
                                return true;
                              }
                            },
                            cantact_title: {
                              validation: {
                                required: false,
                                nullable:true,
                                  // cantacttitlevalidation: function (input) {
                                  //       if (input.is("[name='cantact_title']") && input.val() != "") {
                                  //           input.attr("data-cantacttitlevalidation-msg", "Product Name should start with capital letter");
                                  //           return /^[A-Z]/.test(input.val());
                                  //       }

                                  //       return true;
                                  //   }
                                },
                            maxlength:function(input) { 
                              if (input.is("[name='cantact_title']") && input.val().length > 60) {
                                   input.attr("data-maxlength-msg", "Max length is 200");
                                   return false;
                                }                                   
                                return true;
                              }
                            },
                            phone: {type: "string", validation: { required: true, min: 1}},
                            email: {
                                validation: {
                                    required: false, 
                                    nullable:true, 
                                },
                            maxlength:function(input) { 
                              if (input.is("[name='email']") && input.val().length > 60) {
                                   input.attr("data-maxlength-msg", "Max length is 60");
                                   return false;
                                }                                   
                                return true;
                              }
                            },    
                            fax: {
                                validation: {
                                    required: false,
                                    nullable: true,
                                    // faxvalidation: function (input) {
                                    //     if (input.is("[name='fax']") && input.val() != "") {
                                    //         input.attr("data-faxvalidation-msg", "Product Name should start with capital letter");
                                    //         return /^[A-Z]/.test(input.val());
                                    //     }

                                    //     return true;
                                    // }
                                },
                            maxlength:function(input) { 
                                if (input.is("[name='fax']") && input.val().length > 30) {
                                   input.attr("data-maxlength-msg", "Max length is 30");
                                   return false;
                                }                                   
                                return true;
                              }
                            },
                            country: {
                                validation: {
                                    required: false,
                                    nullable: true,
                                    // countryvalidation: function (input) {
                                    //     if (input.is("[name='country']") && input.val() != "") {
                                    //         input.attr("data-countryvalidation-msg", "Product Name should start with capital letter");
                                    //         return /^[A-Z]/.test(input.val());
                                    //     }

                                    //     return true;
                                    // }
                                },
                             maxlength:function(input) { 
                                if (input.is("[name='country']") && input.val().length > 30) {
                                   input.attr("data-maxlength-msg", "Max length is 30");
                                   return false;
                                }                                   
                                return true;
                              }
                            },   
                            city: {
                                validation: {
                                    required: false,
                                    nullable: true,
                                    // cityvalidation: function (input) {
                                    //     if (input.is("[name='city']") && input.val() != "") {
                                    //         input.attr("data-cityvalidation-msg", "Product Name should start with capital letter");
                                    //         return /^[A-Z]/.test(input.val());
                                    //     }

                                    //     return true;
                                    // }
                                },
                             maxlength:function(input) { 
                                if (input.is("[name='city']") && input.val().length > 30) {
                                   input.attr("data-maxlength-msg", "Max length is 30");
                                   return false;
                                }                                   
                                return true;
                              }
                            },
                            region: {
                                validation: {
                                    required: false,
                                    nullable: true,
                                    // regionvalidation: function (input) {
                                    //     if (input.is("[name='region']") && input.val() != "") {
                                    //         input.attr("data-regionvalidation-msg", "Product Name should start with capital letter");
                                    //         return /^[A-Z]/.test(input.val());
                                    //     }
                                    //     return true;
                                    // }
                                },
                             maxlength:function(input) { 
                                if (input.is("[name='region']") && input.val().length > 30) {
                                   input.attr("data-maxlength-msg", "Max length is 30");
                                   return false;
                                }                                   
                                return true;
                              }
                            },
                            postal_code: {
                                validation: {
                                    required: false,
                                    nullable: true,
                                    // postalcodevalidation: function (input) {
                                    //     if (input.is("[name='postal_code']") && input.val() != "") {
                                    //         input.attr("data-postalcodevalidation-msg", "Product Name should start with capital letter");
                                    //         return /^[A-Z]/.test(input.val());
                                    //     }
                                    //     return true;
                                    // }
                                },
                             maxlength:function(input) { 
                                if (input.is("[name='postal_code']") && input.val().length > 30) {
                                   input.attr("data-maxlength-msg", "Max length is 30");
                                   return false;
                                }                                   
                                return true;
                              }
                            },
                            address: {
                                validation: {
                                    required: false,
                                    nullable: true,
                                    // addressvalidation: function (input) {
                                    //     if (input.is("[name='address']") && input.val() != "") {
                                    //         input.attr("data-addressvalidation-msg", "Product Name should start with capital letter");
                                    //         return /^[A-Z]/.test(input.val());
                                    //     }
                                    //     return true;
                                    // }
                                },
                            maxlength:function(input) { 
                              if (input.is("[name='address']") && input.val().length > 200) {
                                 input.attr("data-maxlength-msg", "Max length is 30");
                                 return false;
                              }                                   
                              return true;
                            }
                          },
                            detail: {
                                validation: {
                                    required: false,
                                    nullable: true,
                                    // detailvalidation: function (input) {
                                    //     if (input.is("[name='detail']") && input.val() != "") {
                                    //         input.attr("data-detailvalidation-msg", "Product Name should start with capital letter");
                                    //         return /^[A-Z]/.test(input.val());
                                    //     }
                                    //     return true;
                                    // }
                                },
                                 maxlength:function(input) { 
                                    if (input.is("[name='detail']") && input.val().length > 200) {
                                       input.attr("data-maxlength-msg", "Max length is 30");
                                       return false;
                                    }                                   
                                    return true;
                                  }
                            },   
                            status: { field: "status", type: "string", defaultValue: "ENABLED" 
                            } //end filde                       
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
                { field: "vendor_type_id", title: " Vendor Id" },
                { field: "branch_id", title: "Branch Id" },
                { field: "company_name", title: " Company Name" },
                { field: "contact_name", title: "Contact Name" },
                { field: "cantact_title",title: "Contact Title"  },
                { field: "phone",title: "phone" },
                { field: "email",title: "Email" },
                { field: "fex",title: "Fax" },
                { field: "country",title: "Country" },
                { field: "city",title: "City" },
                { field: "region",title: "Region" },
                { field: "postal_code",title: "Postal Code" },
                { field: "address",title: "Address" },
                { field: "detail",title: "Detail" },
                { field: "status", title: "Status" },
                { command: ["edit", "destroy"], title: "Action"}],
             editable: "popup",
             edit: function (e) {
              if (e.model.isNew()) {
                  e.container.data("kendoWindow").title('Add New Vendor List');
                  $(".k-grid-update").html('<span class="k-icon k-i-check"></span>Save');
              }
              else {
                  e.container.data("kendoWindow").title('Edit Vendor List');
              }
            } 
         }); 
      $("#txtMultiSearch").keyup(function(e){
         
            var q = $('#txtMultiSearch').val();

            $("#grid").data("kendoGrid").dataSource.filter({
              logic  : "or",
              filters: [
                {
                    field   : "company_name",
                    operator: "contains",
                    value   : q
                },
                {
                    field   : "contact_name",
                    operator: "contains",
                    value   : q
                },
                 {
                    field   : "cantact_title",
                    operator: "contains",
                    value   : q
                },
                {
                    field   : "phone",
                    operator: "contains",
                    value   : q
                },
                {
                    field   : "email",
                    operator: "contains",
                    value   : q
                },
                {
                    field   : "fex",
                    operator: "contains",
                    value   : q
                },
                {
                    field   : "country",
                    operator: "contains",
                    value   : q
                },
                {
                    field   : "city",
                    operator: "contains",
                    value   : q
                },
                {
                    field   : "region",
                    operator: "contains",
                    value   : q
                },
                {
                    field   : "postal_code",
                    operator: "contains",
                    value   : q
                },
                {
                    field   : "address",
                    operator: "contains",
                    value   : q
                },
                {
                    field   : "detail",
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
@endsection