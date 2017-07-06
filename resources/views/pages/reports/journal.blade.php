@extends('layouts.app')

@section('after_styles')
  <style>
    .k-invalid-msg {
      display: none !important;
    }
    .k-invalid {
      border: 1px solid red;
    }
    .k-widget > span.k-invalid,input.k-invalid {
      border: 1px solid red !important;
    }
  </style>
@endsection

@section('header')
    <section class="content-header">
      <h1>Journal</h1>
      <ol class="breadcrumb">
        <li class="active">{{ config('app.name') }}</li>
        <li class="active">Report</li>
        <li class="active">Journal</li>
      </ol>
    </section>
@endsection

@section('content')
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default">
          <div class="box-body">
            <form id="frmJournalReport">
                <label>Report period</label>
              <div>
                <input id="dateMacro" name="date_macro" />&nbsp;&nbsp;
                <input type="text" data-role='datepicker' id="lowDate" name="low_date" data-type="date" required="required" />&nbsp;&nbsp;
                 <label>to</label>&nbsp;&nbsp;
                <input type="text" data-role='datepicker' id="highDate" name="high_date" data-type="date" required="required" data-greaterdate-field="low_date" data-greaterdate-msg='Retire date should be after Hire date' />&nbsp;&nbsp;
              </div>
            </form>
            </br>
            <div id="grid"></div>  
          </div>
        </div>
      </div>
    </div>   
@endsection

@section('after_scripts')
  <script>

    $(document).ready(function(){
      
      var errorTemplate = '<div class="k-widget k-tooltip k-tooltip-validation"' +
                          'style="margin:0.5em"><span class="k-icon k-warning"> </span>' +
                          '#=message#<div class="k-callout k-callout-n"></div></div>'

      var validator = $("#frmJournalReport").kendoValidator({
        errorTemplate: errorTemplate
      }).data("kendoValidator");

      $("#age").kendoNumericTextBox();

      var tooltip = $("#frmJournalReport").kendoTooltip({
        filter: ".k-invalid",
        content: function(e) {
          var name = e.target.attr("name") || e.target.closest(".k-widget").find(".k-invalid:input").attr("name");
          var errorMessage = $("#frmJournalReport").find("[data-for=" + name + "]");

          return '<span class="k-icon k-warning"> </span>' + errorMessage.text();
        },
        show: function() {
          this.refresh();
        }
      });

      $("#dateMacro").kendoDropDownList({
          value: "thismonthtodate",
          dataTextField: "text",
          dataValueField: "value",
          dataSource: dateMacroDataSource,
          change: function(){

            var date  = new Date(),
            firstDate = lastDate = quarter = yesterday = null,
            dateMacro = this.value(),
            lowDate   = $("#lowDate").data('kendoDatePicker'),
            highDate  = $("#highDate").data('kendoDatePicker'); 

            switch(dateMacro){
              case "all":
                lowDate.enable(false);
                lowDate.value("");
                highDate.enable(false);
                highDate.value("");
                journalReportSubmit();
                break;
              case 'custom':
                lowDate.enable();
                lowDate.value("");
                highDate.enable();
                highDate.value("");
                journalReportSubmit();
                break;
              case 'today':
                lowDate.enable();
                lowDate.value(date);
                highDate.enable();
                highDate.value(date);
                break;
              case 'thisweek':
                firstDate = date.getDate() - date.getDay();
                lastDate  = firstDate + 6;
                lowDate.enable();
                lowDate.value(new Date(new Date().setDate(firstDate)));
                highDate.enable();
                highDate.value(new Date(new Date().setDate(lastDate)));
                break;
              case 'thisweektodate':
                firstDate = date.getDate() - date.getDay();
                lowDate.enable();
                lowDate.value(new Date(new Date().setDate(firstDate)));
                highDate.enable();
                highDate.value(date);
                break;
              case 'thismonth':
                firstDate = new Date(date.getFullYear(), date.getMonth(), 1);
                lastDate  = new Date(date.getFullYear(), date.getMonth() + 1, 0);
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable();
                highDate.value(lastDate);
                break;
              case 'thismonthtodate':
                firstDate = new Date(date.getFullYear(), date.getMonth(), 1);
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable();
                highDate.value(date);
                break;
              case 'thisquarter':
                quarter   = Math.floor((date.getMonth() / 3)); 
                firstDate = new Date(date.getFullYear(), quarter * 3, 1);
                lastDate  = new Date(firstDate.getFullYear(), firstDate.getMonth() + 3, 0);
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable();
                highDate.value(lastDate);
                break;
              case 'thisquartertodate':
                quarter   = Math.floor((date.getMonth() / 3)); 
                firstDate = new Date(date.getFullYear(), quarter * 3, 1);
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable();
                highDate.value(date);
                break;
              case 'thisyear':
                firstDate = new Date(date.getFullYear(), 0, 1);
                lastDate  = new Date(new Date(date.getFullYear(), 12, 1) -1);
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable();
                highDate.value(lastDate);
                break;
              case 'thisyeartodate':
                firstDate = new Date(date.getFullYear(), 0, 1);
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable();
                highDate.value(date);
                break;
              case 'yesterday':
                yesterday = new Date(date.setDate(date.getDate() - 1));
                lowDate.enable();
                lowDate.value(yesterday);
                highDate.enable();
                highDate.value(yesterday);
                break;
              case 'recent':
                firstDate = new Date(date.getFullYear(), date.getMonth(), 1);
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable();
                highDate.value(date);
                break;
              case 'lastweek':
                firstDate = date.getDate() - (date.getDay() + 7);
                lastDate  = firstDate + 6;
                lowDate.enable();
                lowDate.value(new Date(new Date().setDate(firstDate)));
                highDate.enable();
                highDate.value(new Date(new Date().setDate(lastDate)));
                break;
              case 'lastweektodate':
                firstDate = date.getDate() - (date.getDay() + 7);
                lowDate.enable();
                lowDate.value(new Date(new Date().setDate(firstDate)));
                highDate.enable();
                highDate.value(date);
                break;
              case 'lastmonth':
                firstDate = new Date(date.getFullYear(), date.getMonth() -1, 1);
                lastDate  = new Date(date.getFullYear(), date.getMonth(), 0);
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable();
                highDate.value(lastDate);
                break;
              case 'lastmonthtodate':
                firstDate = new Date(date.getFullYear(), date.getMonth() -1, 1);
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable();
                highDate.value(date);
                break;
              case 'lastquarter':
                quarter   = Math.floor((date.getMonth() / 3));
                firstDate = new Date(date.getFullYear(), quarter * 3 - 3, 1);
                lastDate  = new Date(firstDate.getFullYear(), firstDate.getMonth() + 3, 0);
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable();
                highDate.value(lastDate);
                break;
              case 'lastquartertodate':
                quarter   = Math.floor((date.getMonth() / 3));
                firstDate = new Date(date.getFullYear(), quarter * 3 - 3, 1);
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable();
                highDate.value(date);
                break;
              case 'lastyear':
                firstDate = new Date(date.getFullYear() - 1, 0, 1);
                lastDate  = new Date(new Date(date.getFullYear() - 1, 12, 1) -1);
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable();
                highDate.value(lastDate);
                break;
              case 'lastyeartodate':
                firstDate = new Date(date.getFullYear() - 1, 0, 1);
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable();
                highDate.value(date);
                break;
              case 'since30daysago':
                firstDate = new Date(new Date().setDate((date.getDate() - 30)));
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable(false);
                highDate.value("");  
                break;
              case 'since60daysago':
                 firstDate = new Date(new Date().setDate((date.getDate() - 60)));
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable(false);
                highDate.value("");
                break;
              case 'since90daysago':
                 firstDate = new Date(new Date().setDate((date.getDate() - 90)));
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable(false);
                highDate.value("");
                break;
              case 'since365daysago':
                 firstDate = new Date(new Date().setDate((date.getDate() - 365)));
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable(false);
                highDate.value("");
                break;
              case 'nextweek':
                firstDate = (date.getDate() + 7) - date.getDay();
                lastDate  = firstDate + 6;
                lowDate.enable();
                lowDate.value(new Date(new Date().setDate(firstDate)));
                highDate.enable();
                highDate.value(new Date(new Date().setDate(lastDate)));
                break;
              case 'nextfourweeks':
                firstDate = (date.getDate() + 7) - date.getDay();
                lastDate  = firstDate + (6 * 4) + 3;
                lowDate.enable();
                lowDate.value(new Date(new Date().setDate(firstDate)));
                highDate.enable();
                highDate.value(new Date(new Date().setDate(lastDate)));
                break;
              case 'nextmonth':
                firstDate = new Date(date.getFullYear(), date.getMonth() + 1, 1);
                lastDate  = new Date(date.getFullYear(), date.getMonth() + 2, 0);
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable();
                highDate.value(lastDate);
                break;
              case 'nextquarter':
                quarter   = Math.floor((date.getMonth() / 3)); 
                firstDate = new Date(date.getFullYear(), quarter * 3 + 3, 1);
                lastDate  = new Date(firstDate.getFullYear(), firstDate.getMonth() + 3, 0);
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable();
                highDate.value(lastDate);
                break;
              case 'nextyear':
                firstDate = new Date(date.getFullYear() + 1, 0, 1);
                lastDate  = new Date(new Date(date.getFullYear() + 1, 12, 1) -1);
                lowDate.enable();
                lowDate.value(firstDate);
                highDate.enable();
                highDate.value(lastDate);
                break;
            }
          }
      });
    
      var start = $("#lowDate").kendoDatePicker({
        value: new Date(new Date().getFullYear(), new Date().getMonth(), 1),
        format: "dd/MM/yyyy",
        change: function(){

        }
      }).data("kendoDatePicker");

      var end = $("#highDate").kendoDatePicker({
        value: new Date(),
        format: "dd/MM/yyyy",
        change: function(){
          journalReportSubmit();
        }
      }).data("kendoDatePicker");

      /*Submit form report journal*/    
      function journalReportSubmit(){
        var validator = $("#frmJournalReport").kendoValidator().data("kendoValidator");
        if (validator.validate()) {
          var data = $('#frmJournalReport').serialize();
          $.ajax({
            type: 'get',
            url: '{{url('')}}' + '/report/journal/get',
            dataType: 'json',
            data: data,
            success: function(data){
              viewJournalReport(data);
            },
            error: function(data){

            }

          });
        }  
      } 

      /*View journal report*/
      function viewJournalReport(data){
        $("#grid").kendoGrid({
            dataSource: {
              data: data,
              schema: {
                id: "id",
                model: {
                  fields: {
                    id: { editable: false, nullable: true },
                    date: { type: "date" },
                    transactionType: { type: "string" },
                    referenceNumer: { type: "string" },
                    name: { type: "string" },
                    memo: { type: "string" },
                    account: { type: "string" },
                    debit: { type: "number" },
                    credit: { type: "number" },
                    createdBy: { type: "string" },
                    updatedBy: { type: "string" },
                    createdAt: { type: "date" },
                    updatedAt: { type: "date" }
                  }
                }
              },
              pageSize: 20
            },
            columnMenu: true,
            scrollable: true,
            sortable: true,
            filterable: true,
            pageable: {
                input: true,
                numeric: false
            },
            columns: [
                { field: "date", title: "DATE", format: "{0:dd/MM/yyyy}" },
                { field: "transactionType", title: "TRANSACTION TYPE" },
                { field: "referenceNumber", title: "NO." },
                { field: "name", title: "NAME" },
                { field: "memo", title: "MEMO/DESCRIPTION" },
                { field: "account", title: "ACCOUNT" },
                { field: "debit", title: "DEBIT", format: "{0:c}" },
                { field: "credit", title: "CREDIT", format: "{0:c}" },
                { field: "createdAt", title: "CREATED", format: "{0:dd/MM/yyyy h:mm:ss tt}", hidden: true },
                { field: "createdBy", title: "CREATED BY", hidden: true },
                { field: "updatedAt", title: "LAST MODIFIED", format: "{0:dd/MM/yyyy h:mm:ss tt}", hidden: true },
                { field: "updatedBy", title: "LAST MODIFIED BY", hidden: true },
            ]
        });
      }
    });
  </script>
@endsection