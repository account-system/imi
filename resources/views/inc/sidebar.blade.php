@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="https://placehold.it/160x160/00a65a/ffffff/&text={{ mb_substr(Auth::user()->name, 0, 1) }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ Auth::user()->name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          <li><a href="{{ url('').'/dashboard' }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

          <!-- ==== Setup Customer ============================ -->
          <li class="treeview">
              <a href="#"><i class="icon fa fa-desktop"></i><span>Customer</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url('').'/customer-type' }}"><i class="ion ion-person-add"></i> <span>Customer Type</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/customerlist') }}"><i class="fa fa-th-list"></i> <span>Customer List</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/custreport') }}"><i class="fa  fa-cog"></i> <span>Customer Report</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/custbalance') }}"><i class="fa  fa-gear"></i> <span>Customer Balance Report</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/custpayment') }}"><i class="fa  fa-gear"></i> <span>Customer Payment</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/custar') }}"><i class="fa  fa-gear"></i> <span>Customer Payment Report(A/R)</span></a></li>
                <li style="border-bottom: 2px inset #eee;"><a href="{{ url(config('backpack.base.route_prefix').'/custpayment') }}"><i class="fa  fa-gear"></i> <span>Customer Payment</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/appointment') }}"><i class="fa fa-calendar"></i> <span>Appointment</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/appointmentreport') }}"><i class="fa fa-calendar"></i> <span>Appointment Report</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/invoice') }}"><i class="fa fa-file-text-o"></i> <span>Issue Invoice</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/payment') }}"><i class="fa fa-usd"></i> <span>Issue Invcoice Report</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/invoice') }}"><i class="fa fa-external-link"></i> <span>Daily Case Report</span></a></li>
              </ul>
          </li>
          <!-- ==== Setup Staff ==================================== -->
          <li class="treeview">
              <a href="#"><i class="icon fa fa-table"></i><span>Staff</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url(config('backpack.base.route_prefix').'/setupstaff') }}"><i class="fa fa-th-list"></i> <span>Staff List</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/staffpayroll') }}"><i class="fa fa-male"></i> <span>Staff Payroll </span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/staffreport') }}"><i class="fa fa-external-link"></i> <span>Staff Report</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/payrollreport') }}"><i class="fa fa-cog"></i> <span>Payroll Report</span></a></li>
              </ul>
          </li>
          <!-- ====== Setup Doctor ================================ -->
          <li class="treeview">
              <a href="#"><i class="fa fa-user-md"></i><span>Doctor</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url(config('backpack.base.route_prefix').'/doctortype') }}"><i class="fa fa-child"></i> <span>Doctor Type</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/doctorlist') }}"><i class="fa fa fa-th-list"></i> <span>Doctor List</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/doctorexspen') }}"><i class="fa fa-cog"></i> <span>Doctor Expense</span></a></li> 
                <li><a href="{{ url(config('backpack.base.route_prefix').'/doctorreport') }}"><i class="fa fa-cog"></i> <span>Doctor Report</span></a></li> 
              </ul>
          </li>
          <!-- ====== Setup vendor ================================ -->
          <li class="treeview">
              <a href="#"><i class="icon fa fa-file-text-o"></i><span>Vendor</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url(config('backpack.base.route_prefix').'/vendortype') }}"><i class="ion ion-ios-people-outline"></i> <span>Vendor Type</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/vendorlist') }}"><i class="fa fa fa-th-list"></i> <span>Vendor List</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/vendorpayment') }}"><i class="fa fa fa-th-list"></i> <span>Vendor Payment(A/P)</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/vendorpaymentreport') }}"><i class="fa fa fa-th-list"></i> <span>Vendor Payment Report</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/vendorbalancereport') }}"><i class="fa fa fa-th-list"></i> <span>Vendor Balance Report</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/purchase') }}"><i class="ion ion-ios-cart-outline"></i> <span>Purchase</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/vendorpayment') }}"><i class="fa fa-external-link"></i> <span>Purchase Detail Report</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/purchasesummary') }}"><i class="fa fa-cog"></i> <span>Purchase Summary Report</span></a></li> 
              </ul>
          </li>
          <!-- ====== Setup Item ================================ -->
          <li class="treeview">
              <a href="#"><i class="icon fa fa-cubes"></i><span>Item</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url(config('backpack.base.route_prefix').'/service') }}"><i class="fa fa-gears"></i> <span>Setup Service</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/producttpye') }}"><i class="fa  fa-expeditedssl"></i> <span>Product Type</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/productlist') }}"><i class="fa fa fa-th-list"></i> <span>Product List</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/stockuot') }}"><i class="fa fa-shopping-cart"></i> <span>Stock Out</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/stock') }}"><i class="fa fa-cog"></i> <span>Stock Report</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/stockoutdetail') }}"><i class="fa fa-cog"></i> <span>Stock Out Detail Report</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/salereport') }}"><i class="fa fa-external-link"></i> <span>Stock Out Summary Report</span></a></li>
              </ul>
          </li>

          <!-- ====== Report ================================ -->
          <li class="treeview">
              <a href="#"><i class="fa fa-leanpub"></i><span>Report</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url(config('backpack.base.route_prefix').'/journal') }}"><i class="fa fa-bar-chart-o"></i> <span>Journal</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/accpayable') }}"><i class="fa fa-bar-chart-o"></i> <span>Account Payable</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/generalledger') }}"><i class="fa fa-bar-chart-o"></i> <span>General Ledger</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/balence') }}"><i class="fa fa-area-chart"></i> <span>Balance Sheet</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/cashflow') }}"><i class="fa  fa-pie-chart"></i> <span>Cash Flow</span></a></li>
                 <li><a href="{{ url(config('backpack.base.route_prefix').'/income') }}"><i class="fa fa-money"></i> <span>Income Statement</span></a></li>
              </ul>
          </li>
          <!-- ====== Account ================================ -->
          <li class="treeview">
              <a href="#"><i class="fa fa-book"></i><span>Account</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url(config('backpack.base.route_prefix').'/accounttype') }}"><i class="fa fa-user-plus"></i> <span>Account Type</span></a></li>
                <li><a href="{{ url('').'/accounts/chart' }}"><i class="fa fa-bar-chart"></i> <span>Chart Account</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/journalentry') }}"><i class="fa fa-database"></i> <span>Journal Entry</span></a></li>
              </ul>
          </li>
           <!-- ====== Users ================================ -->
          <li class="treeview">
              <a href="#"><i class="icon fa fa-user"></i><span>Users</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url(config('backpack.base.route_prefix').'/listuser') }}"><i class="fa fa-th-list"></i> <span>List Users</span></a></li>
              </ul>
          </li>
          <!-- ============================================= -->
          <li class="treeview">
            <a href="#"><i class="fa fa fa-th-list"></i><span>License</span> <i class="fa fa-angle-left pull-right"></i></a>
          </li>
          <!-- ======================================= -->
          <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
