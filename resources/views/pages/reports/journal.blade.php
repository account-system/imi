@extends('layouts.app')

@section('after_styles')
  <style>
  
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
            <form id="frmReportPeriod">
                <label>Report period</label>
              <div>
                <input id="dateMacro"/>&nbsp;&nbsp;
                <input id="lowDate"/>&nbsp;&nbsp;
                 <label>to</label>&nbsp;&nbsp;
                <input id="highDate"/>&nbsp;&nbsp;
              </div>
            </form>
            <div id="grid"></div>  
          </div>
        </div>
      </div>
    </div>   
@endsection

@section('after_scripts')
  <script>
    $(document).ready(function(){
      $("#dateMacro").kendoDropDownList({
          value: "thismonthtodate",
          dataTextField: "text",
          dataValueField: "value",
          dataSource: dateMacroDataSource,
          change: function(){

            var value   = this.value();
            var lowDate = $("#lowDate").data('kendoDatePicker');
            var highDate= $("#highDate").data('kendoDatePicker'); 

            switch(value){
              case "all":
                lowDate.enable(false);
                lowDate.value("");
                highDate.enable(false);
                highDate.value("");
                break;
              case 'custom':
                lowDate.enable();
                lowDate.value("");
                highDate.enable();
                highDate.value("");
                break;
              case 'today':
                lowDate.enable();
                lowDate.value(new Date());
                highDate.enable();
                highDate.value(new Date());
                break;
              case 'thisweek':
                lowDate.enable();
                lowDate.value(new Date(new Date().setDate(new Date().getDate() - new Date().getDay())));
                highDate.enable();
                highDate.value(new Date(new Date().setDate((new Date().getDate() - new Date().getDay()) + 6)));
                break;
              case 'thisweektodate':
                lowDate.enable();
                lowDate.value(new Date(new Date().setDate(new Date().getDate() - new Date().getDay())));
                highDate.enable();
                highDate.value(new Date());
                break;
              case 'thismonth':
                lowDate.enable();
                lowDate.value(new Date(new Date().getFullYear(), new Date().getMonth(), 1));
                highDate.enable();
                highDate.value(new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0));
                break;
              case 'thismonthtodate':
                lowDate.enable();
                lowDate.value(new Date(new Date().getFullYear(), new Date().getMonth(), 1));
                highDate.enable();
                highDate.value(new Date());
                break;
              case 'thisquarter':
                lowDate.enable();
                lowDate.value(new Date());
                highDate.enable();
                highDate.value(new Date());
                break;
              case 'thisquartertodate':
                
                break;
              case 'thisyear':
                
                break;
              case 'thisyeartodate':
                
                break;
              case 'yesterday':
                
                break;
              case 'recent':
                
                break;
              case 'lastweek':
                
                break;
              case 'lastweektodate':
                
                break;
              case 'lastmonth':
                
                break;
              case 'lastmonthtodate':
                
                break;
              case 'lastquarter':
                
                break;
              case 'lastquartertodate':
                
                break;
              case 'lastyear':
                
                break;
              case 'lastyeartodate':
                
                break;
              case 'since30daysago':
                
                break;
              case 'since60daysago':
                
                break;
              case 'since90daysago':
                
                break;
              case 'since365daysago':
                
                break;
              case 'nextweek':
                
                break;
              case 'nextfourweeks':
                
                break;
              case 'nextmonth':
                
                break;
              case 'nextquarter':
                
                break;
              case 'nextyear':
                
                break;
            }
          }
      });

      $("#lowDate").kendoDatePicker({
        value: new Date(new Date().getFullYear(), new Date().getMonth(), 1),
        format: "dd/MM/yyyy",
      });

      $("#highDate").kendoDatePicker({
        value: new Date(),
        format: "dd/MM/yyyy",
      });     
    });
  </script>
@endsection