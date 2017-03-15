@extends('layouts.app')

 @yield('before_styles')

 @section('content')
	 <div id="example">
        <style>
            .k-multicheck-wrap {
                overflow-x: hidden;
            }
        </style>
    <div class="demo-section k-content wide">
        <div id="client"></div>
    </div>
   

@endsection()
@section('after_scripts')

           
            <script>
             $(document).ready(function() {
                    var telerikWebServiceBase ="https://demos.telerik.com/kendo-ui/service/";

                    $("#client").kendoGrid({
                        dataSource: {
                            transport: {
                                read:  {
                                    url: telerikWebServiceBase + "/Products",
                                    dataType: "jsonp"
                                },
                                update: {
                                    url: telerikWebServiceBase + "/Products/Update",
                                    dataType: "jsonp"
                                },
                                destroy: {
                                    url: telerikWebServiceBase + "/Products/Destroy",
                                    dataType: "jsonp"
                                },
                                create: {
                                    url: telerikWebServiceBase + "/Products/Create",
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
                                        AccountType: { type: "search", validation: { required: true, min: 1} },
                                        SubOf: { type: "search", validation: { min: 0, required: true } },
                                        Name: { validation: { required: true } },
                                        Code: { validation: { required: true } },
                                        Description: { validation: { required: true } }
                                        
                                    }
                                }
                            }
                        },
                        filterable: true,
                        pageable: true,
                        height: 550,
                        toolbar: ["create"],
                        columns: [
                        	{ field: "AccountType", title: "Account Type", format: "{0:c}", width: 120, filterable: { multi: true } },
                        	{ field: "SubOf", title: "Sub Of", width: 120, filterable: { multi: true } },
                            { field: "Name", filterable: { multi: true, search: true, search: true } },
                            { field: "Code", title: "Code", width: 120, filterable: { multi: true } },
                            { field: "Description", width: 120, filterable: { multi: true, dataSource: [{ Discontinued: true }, { Discontinued: false }]} },
                            { command: ["edit","destroy"], title: "&nbsp;", width: 180}],
                        editable: "popup"
                    });
});

            </script>


        @endsection()
    
