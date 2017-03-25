<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Encrypted CSRF token for Laravel, in order for Ajax requests to work --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ isset($title) ? $title.' :: '.config('app.name') : config('app.name')}}</title>

    @yield('before_styles')

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/iCheck/flat/blue.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/morris/morris.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/daterangepicker/daterangepicker-bs3.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/pace/pace.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/pnotify/pnotify.custom.min.css') }}">
    
    <!-- Kendo UI style -->
     <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/bootstrap/css/kendo.common-bootstrap.min.css">
     <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/bootstrap/css/kendo.bootstrap.min.css">
     <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/bootstrap/css/kendo.bootstrap.mobile.min.css">
     
    <!-- BackPack Base CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/backpack/backpack.base.css') }}">

    <!-- Global css use in this application -->
    <style type="text/css">

    .toolbar-search {
        float: right;
        margin-right: 12px;
      }
      .fieldlist {
        margin: 0;
        padding: 0;
      }

      .text-box-search{
        width: 220px;
      }    
      
      /*Column grid*/
      .col-12{
        float: left;
        width: 97%;
        padding: 0% 2% 2% 1%;
      }
      .col-6{
        float: left;
        width: 47%;
        padding: 0% 2% 2% 1%;
      }
      .col-3{
        float: left;
        width: 23%;
        padding: 0% 2% 2% 1%;
      }
      input.k-textbox{
        text-indent: .5em;
      }
      .k-edit-form-container{
        width: 100%; 
      }

    </style>

    @yield('after_styles')

</head>
<body class="hold-transition {{ config('app.skin') }} sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="{{ url('') }}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">{!! config('app.logo_mini') !!}</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">{!! config('app.logo_lg') !!}</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>

          @include('inc.menu')
        </nav>
      </header>

      <!-- =============================================== -->

      @include('inc.sidebar')

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
         @yield('header')

        <!-- Main content -->
        <section class="content">

          @yield('content')

        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <footer class="main-footer">
        @if (config('app.show_powered_by'))
            <div class="pull-right hidden-xs">Powered by <a target="_blank" href="http://cstcambodia.com">CST Cambodia</a>
            </div>
        @endif
        Handcrafted by <a target="_blank" href="{{ config('app.developer_link') }}">{{ config('app.developer_name') }}</a>.
      </footer>
    </div>
    <!-- ./wrapper -->

    @yield('before_scripts')
    
    <!-- jQuery -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('vendor/adminlte') }}/bootstrap/js/kendo.all.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/plugins/pace/pace.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/plugins/fastclick/fastclick.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/dist/js/app.min.js"></script>

     <!-- jQuery fullscreen -->
    <script src="{{ asset('js/jquery.fullscreen.min.js') }}"></script>

    <!-- page script -->
    <script type="text/javascript">
      
      /*Global variable use in this application*/

      //crud base url
      var crudBaseUrl = "{{url('')}}";

      //It's status data
      var statusDataSource = [
        {value: "Enabled", text: "Enabled"},
        {value: "Disabled", text: "Disabled"}
      ];

      // To make Pace works on Ajax calls
      $(document).ajaxStart(function() { Pace.restart(); });

      // Ajax calls should always have the CSRF token attached to them, otherwise they won't work
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      
      // Set active state on menu element
      var current_url = window.location.href;
      $("ul.sidebar-menu li a").each(function() {
        if ($(this).attr('href').startsWith(current_url) || current_url.startsWith($(this).attr('href')))
        {
          $(this).parents('li').addClass('active');
        }
      });

      // Set event fullsscreen
      $("#fullscreen").click(function(){
        if($('body').fullscreen()){
          $.fullscreen.exit();
          return false;
        }else{
          $('body').fullscreen();
          return false;   
        }     
      });

      //Create status dropdownlist
      function statusDataBinding()
      {
        $("#status").kendoDropDownList({
          dataValueField: "value",
          dataTextField: "text",
          dataSource: statusDataSource  
        });
      }

      //Create branch dropdownlist 
      function branchDataBinding(){
        $("#branch").kendoDropDownList({
          optionLabel: "Select branch...",
          dataValueField: "value",
          dataTextField: "text",
          dataSource: {
            transport: {
              read: {
                url: crudBaseUrl+"/branch/list/filter",
                type: "GET",
                dataType: "json"
              }
            }
          }
        }); 
      }

      //Create country dropdownlist 
      function countryDataBinding(){
        $("#country").kendoDropDownList({
          filter: "startswith",
          optionLabel: "Select country...",
          dataValueField: "value",
          dataTextField: "text",
          dataSource: {
            batch: true,
            transport: {
              read: {
                url: crudBaseUrl + "/country/list/filter",
                type: "GET",
                dataType: "json"
              },
              create: {
                url: crudBaseUrl + "/country/store",
                type: "POST",
                dataType: "jsonp"
              },
              parameterMap: function(options, operation) {
                if (operation !== "read" && options.models) {
                  return {models: kendo.stringify(options.models)};
                }
              }
            },
            schema: {
              model: {
                id: "id",
                fields: {
                  id: { type: "number"},
                  name: { type: "string" },
                  description: {type: "string", nullable: true},
                  status: {type: "string", defaultValue: "Enabled"}
                }
              }
            }
          },
          noDataTemplate: $("#noDataCountryTemplate").html()
        }); 
      }

      /*Create new country*/
      function addNew(widgetId, value) {
        var widget = $("#" + widgetId).getKendoDropDownList();
        var dataSource = widget.dataSource;

        if (confirm("Are you sure?")) {
          dataSource.add({
            id: 0,
            name: value,
            description: null,
            status: 'Enabled'
          });

          dataSource.one("sync", function() {
              widget.select(dataSource.view().length - 1);
          });

          dataSource.sync();
          dataSource.read();
        } 
      }

    </script>

    <!-- Create new country when no data found --> 
    <script id="noDataCountryTemplate" type="text/x-kendo-tmpl">
        <div>
            No data found. Do you want to add new country - '#: instance.filterInput.val() #' ?
        </div>
        <br />
        <button class="k-button" onclick="addNew('#: instance.element[0].id #', '#: instance.filterInput.val() #')">Add new country</button>
    </script>

    <!-- Create textbox multi search toolbar for input HTML element --> 
    <script type="text/x-kendo-template" id="textbox-multi-search">
      <div class="toolbar-search">
        <span class="k-textbox k-space-left text-box-search">
            <input type="text" id="txtMultiSearch" placeholder="Search..." />
            <a href="\\#" class="k-icon k-i-search">&nbsp;</a>
        </span>
      </div>
  </script> 

  <!-- Customize popup editor type --> 
  <script id="popup-editor-type" type="text/x-kendo-template">
    <div class="col-12">
      <label for="name">Name</label>
      <input type="text" name="Name" class="k-textbox" placeholder="Enter name" data-bind="value:name" required  style="width: 100%;"/> 
    </div>
    <div class="col-12">
      <label for="description">Description</label>
      <textarea class="k-textbox" name="Description" placeholder="Enter description" data-bind="value:description" style="width: 100%;"/></textarea> 
    </div>
    <div class="col-6">
      <label for="status">Status</label>
      <input id="status" data-bind="value:status"  style="width: 100%;" />
    </div>
</script>     

    @include('inc.alerts')

    @yield('after_scripts')

    <!-- JavaScripts -->
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    
</body>
</html>
