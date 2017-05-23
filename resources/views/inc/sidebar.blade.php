@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="https://placehold.it/160x160/00a65a/ffffff/&text={{ mb_substr(Auth::user()->username, 0, 1) }}" class="img-circle" alt="User Image">
          </div>
          <div class="user-info">
            <p>{{ Auth::user()->username }}</p>
            <a href="javascript:void(0);">{{ Auth::user()->role }}</a>
            <br/>
            <a href="javascript:void(0);" id="popover-branch">{{ Auth::user()->branches[0]['text']}}&nbsp;<i class="fa fa-angle-down"></i>
            </a>
          </div>
        </div>
        <!-- Popover container -->
        <div class="popover-container"></div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          <li><a href="{{ url('').'/dashboard' }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

          <!-- ==== Setup Data ============================ -->
          <li class="treeview">
              <a href="#"><i class="fa fa fa-cogs"></i><span>Setup Data</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url('').'/country' }}"><span>Setup Country &amp; City</span></a></li>
              </ul>
          </li>
          <!-- ==== Setup Customer ============================ -->
          <li class="treeview">
              <a href="#"><i class="icon fa fa-desktop"></i><span>Customer</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url('').'/customer/type' }}"><span>Customer Type</span></a></li>
                <li style="border-bottom: 2px inset #ecf0f5;"><a href="{{ url('').'/customer' }}"><span>Customer List</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/receipt-payment') }}"><span>Receipt Payment</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/appointment') }}"><span>Appointment</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/create-invoice') }}"><span>Create Invoice</span></a></li>
              </ul>
          </li>
          <!-- ==== Setup Staff ==================================== -->
          <li class="treeview">
              <a href="#"><i class="icon fa fa-table"></i><span>Employee</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url('').'/employee/type' }}"><span>Employee Type</span></a></li>
                <li><a href="{{ url('').'/employee' }}"><span>Employee List</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/staff-payroll') }}"><span>Employee Payroll </span></a></li>
              </ul>
          </li>
          <!-- ====== Setup Doctor ================================ -->
          <li class="treeview">
              <a href="#"><i class="fa fa-user-md"></i><span>Doctor</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url('').'/doctor/type' }}"><span>Doctor Type</span></a></li>
                <li><a href="{{ url('').'/doctor' }}"><span>Doctor List</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/doctor-expenes') }}"><span>Doctor Expense</span></a></li> 
              </ul>
          </li>
          <!-- ====== Setup Supplier ================================ -->
          <li class="treeview">
              <a href="#"><i class="icon fa fa-file-text-o"></i><span>Supplier</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url('').'/supplier/type' }}"><span>Supplier Type</span></a></li>
                <li style="border-bottom: 2px inset #ecf0f5;"><a href="{{ url('').'/supplier' }}"><span>Supplier List</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/pay-bill') }}"><span>Pay Bill</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/enter-bill') }}"><span>Enter Bill</span></a></li>
              </ul>
          </li>
          <!-- ====== Setup Item ================================ -->
          <li class="treeview">
              <a href="#"><i class="icon fa fa-cubes"></i><span>Product</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url('').'/product/category' }}"><span>Category</span></a></li>
                <li style="border-bottom: 2px inset #ecf0f5;"><a href="{{ url('').'/product' }}"><span>Product List</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/sale') }}"><span>Sale</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/setup-service') }}"><span>Setup Service</span></a></li>
              </ul>
          </li>
          <!-- ====== Account ================================ -->
          <li class="treeview">
              <a href="#"><i class="fa fa-usd"></i><span>Account</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li><a href="{{ url('').'/account' }}"><span>Setup Chart of Account</span></a></li>
                  <li><a href="{{ url('').'/account/income/type' }}"><span>Setup Income Type</span></a></li>
                  <li style="border-bottom: 2px inset #ecf0f5;"><a href="{{ url('').'/account/expense/type' }}"><span>Setup Expense Type</span></a></li>
                  <li><a href="{{ url('').'/account/journal' }}"><span>Post Journal Entry</span></a></li>
                  <li><a href="{{ url('').'/account/income' }}"><span>Post Income</span></a></li>
                  <li><a href="{{ url('').'/account/expense' }}"><span>Post Expense</span></a></li>  
                </ul>
          </li>
            <!-- ====== Report ================================ -->
          <li class="treeview">
              <a href="#"><i class="fa fa-list-alt"></i><span>Report</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                               
                <!-- ====== Account ======================================= -->
               
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/doctor-report') }}"><span>Doctor Report</span></a></li>
                  <li><a href="#"><span>Customer</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url(config('backpack.base.route_prefix').'/appointment-report') }}"><span>Appointment Report</span></a></li>
                        <li><a href="{{ url(config('backpack.base.route_prefix').'/customer-ap') }}"><span>Customer Payment Report(A/P)</span></a></li>
                        <li><a href="{{ url(config('backpack.base.route_prefix').'/customer-report') }}"><span>Customer Report</span></a></li>
                        <li><a href="{{ url(config('backpack.base.route_prefix').'/customer-balance') }}"><span>Customer Balance Report</span></a></li>
                        <li><a href="{{ url(config('backpack.base.route_prefix').'/invoice-register') }}"><span>Invoice Register</span></a></li>
                    </ul>
                  </li>

                <!-- ==== Customer ====================================== -->
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/sale-summary') }}"><span>Sale Summary Report</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/staff-report') }}"><span>Staff Report</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/payroll-report') }}"><span>Payroll Report</span></a></li>
                  <li style="border-bottom: 2px inset #ecf0f5;"><a href="{{ url(config('backpack.base.route_prefix').'/staff-report') }}"><span>Paybill Report</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/vendor-balance-report') }}"><span>Vendor Balance Report</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'bill-detail-report') }}"><span>Bill Detail Report</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/bill-sum-report') }}"><span>Bill Summary Report</span></a></li> 
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/daily-report') }}"><span>Daily Cash Report</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/stock-report') }}"><span>Stock Report</span></a></li>                        
                
                <!-- ======== Financial ==================================== -->
                <li style="border-bottom: 2px inset #ecf0f5;"><a href="#"><span>Financial</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/balance-sheet') }}"><span>Balance Sheet</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/journal') }}"><span>Journal</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/cashflow') }}"><span>Cash Flow</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/general-ledger') }}"><span>General Ledger</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/income-statement') }}"><span>Income Statement</span></a></li>
                </ul>
                </li>
                <!-- ============================== -->
              </ul>
          </li>
           <!-- ====== Users ================================ -->
          <li class="treeview">
              <a href="#"><i class="icon fa fa-user"></i><span>User</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url('').'/user' }}"><span>User List</span></a></li>
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
