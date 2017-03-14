@extends('layouts.app')

 @yield('before_styles')

 @section('content')

    <div id="example">
            <div id="grid"></div>
    </div>
@endsection()
		@section('after_scripts')

             <script>
                $(document).ready(function () {
                    var crudServiceBaseUrl = "https://demos.telerik.com/kendo-ui/service",
                        dataSource = new kendo.data.DataSource({
                            transport: {
                                read:  {
                                    url: crudServiceBaseUrl + "/Products",
                                    dataType: "jsonp"
                                },
                                update: {
                                    url: crudServiceBaseUrl + "/Products/Update",
                                    dataType: "jsonp"
                                },
                                destroy: {
                                    url: crudServiceBaseUrl + "/Products/Destroy",
                                    dataType: "jsonp"
                                },
                                create: {
                                    url: crudServiceBaseUrl + "/Products/Create",
                                    dataType: "jsonp"
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
                                    id: "ID",
                                    fields: {
                                        ID: { editable: false, nullable: true },
                                        Name: { validation: { required: true } },
                                        AccountType: { type: "number", validation: { required: true, min: 1} },
                                        Code: { type: "boolean" }                                        
                                    }
                                }
                            }
                        });

                    $("#grid").kendoGrid({
                        dataSource: dataSource,
                        pageable: true,
                        height: 550,
                        toolbar: ["create"],
                        columns: [
                            { field: "Name", title:"Name", format: "{0:c}", width: "250px" },
                            { field: "AccountType", title:"Account Type", width: "120px" },
                            { field: "Code", width: "120px" },
                            { command: ["edit", "destroy"], title: "&nbsp;", width: "110px" }],
                        editable: "popup"
                    });
                });
            </script>

        @endsection()
    
