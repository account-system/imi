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
                <li><a href="{{ url('').'/customer-type' }}"><span>Customer Type</span></a></li>
                <li style="border-bottom: 2px inset #ecf0f5;"><a href="{{ url(config('backpack.base.route_prefix').'/customerlist') }}"><span>Customer List</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/custar') }}"><span>Customer A/R</span></a></li>
                <li style="border-bottom: 2px inset #ecf0f5;"><a href="{{ url(config('backpack.base.route_prefix').'/custpayment') }}"><span>Customer Payment</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/appointment') }}"><span>Appointment</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/appointmentreport') }}"><span>Appointment Report</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/invoice') }}"><span>Issue Invoice</span></a></li>
              </ul>
          </li>
          <!-- ==== Setup Staff ==================================== -->
          <li class="treeview">
              <a href="#"><i class="icon fa fa-table"></i><span>Staff</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url(config('backpack.base.route_prefix').'/setupstaff') }}"><span>Staff List</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/staffpayroll') }}"><span>Staff Payroll </span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/staffreport') }}"><span>Staff Report</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/payrollreport') }}"><span>Payroll Report</span></a></li>
              </ul>
          </li>
          <!-- ====== Setup Doctor ================================ -->
          <li class="treeview">
              <a href="#"><i class="fa fa-user-md"></i><span>Doctor</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url(config('backpack.base.route_prefix').'/doctortype') }}"><span>Doctor Type</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/doctorlist') }}"><span>Doctor List</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/doctorexspen') }}"><span>Doctor Expense</span></a></li> 
                <li><a href="{{ url(config('backpack.base.route_prefix').'/doctorreport') }}"><span>Doctor Report</span></a></li> 
              </ul>
          </li>
          <!-- ====== Setup vendor ================================ -->
          <li class="treeview">
              <a href="#"><i class="icon fa fa-file-text-o"></i><span>Vendor</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url(config('backpack.base.route_prefix').'/vendortype') }}"><span>Vendor Type</span></a></li>
                <li style="border-bottom: 2px inset #ecf0f5;"><a href="{{ url(config('backpack.base.route_prefix').'/vendorlist') }}"><span>Vendor List</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/vendorpayment') }}"><span>Vendor Payment(A/P)</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/vendorpaymentreport') }}"><span>Vendor Payment Report</span></a></li>
                <li style="border-bottom: 2px inset #ecf0f5;"><a href="{{ url(config('backpack.base.route_prefix').'/vendorbalancereport') }}"><span>Vendor Balance Report</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/purchase') }}"><span>Purchase</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/vendorpayment') }}"><span>Purchase Detail Report</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/purchasesummary') }}"><span>Purchase Summary Report</span></a></li> 
              </ul>
          </li>
          <!-- ====== Setup Item ================================ -->
          <li class="treeview">
              <a href="#"><i class="icon fa fa-cubes"></i><span>Item</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li style="border-bottom: 2px inset #ecf0f5;"><a href="{{ url(config('backpack.base.route_prefix').'/service') }}"><span>Setup Service</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/producttpye') }}"><span>Product Type</span></a></li>
                <li style="border-bottom: 2px inset #ecf0f5;"><a href="{{ url(config('backpack.base.route_prefix').'/productlist') }}"><span>Product List</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/stockuot') }}"><span>Stock Out</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/stock') }}"><span>Stock Report</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/stockoutdetail') }}"><span>Stock Out Detail Report</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/salereport') }}"><span>Stock Out Summary Report</span></a></li>
              </ul>
          </li>
          <!-- ====== Account ================================ -->
          <li class="treeview">
              <a href="#"><i class="fa fa-usd"></i><span>Account</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/accounttype') }}"><span>Account Type</span></a></li>
                  <li><a href="{{ url('').'/accounts/chart' }}"><span>Chart Account</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/journalentry') }}"><span>Make Journal Entry</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/poseexspen') }}"><span>Pose Exspen</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/poseincome') }}"><span>Pose Income</span></a></li>
                </ul>
          </li>
            <!-- ====== Report ================================ -->
          <li class="treeview">
              <a href="#"><i class="fa fa-list-alt"></i><span>Report</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                               
                <!-- ====== Account ======================================= -->
                <li style="border-bottom: 2px inset #ecf0f5;"><a href="#"><span>Account</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/accpayable') }}"><span>Account Payable</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/Journal') }}"><span>Journal</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/generalledger') }}"><span>General Ledger</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/trailbalance') }}"><span>Trail Balance</span></a></li>
                </ul>
                </li>

                <!-- ==== Customer ====================================== -->
                <li style="border-bottom: 2px inset #ecf0f5;"><a href="#"><span>Customer</span> <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/custreport') }}"><span>Customer Report</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/custbalance') }}"><span>Customer Balance Report</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/invoice') }}"><span>Daily Case Report</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix').'/payment') }}"><span>Issue Invcoice Report</span></a></li>
                  </ul>
                </li>          
                
                <!-- ======== Financial ==================================== -->
                <li style="border-bottom: 2px inset #ecf0f5;"><a href="#"><span>Financial</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/exspen') }}"><span>Exspen</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/income') }}"><span>Income</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/cashflow') }}"><span>Cash Flow</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/balence') }}"><span>Balance Sheet</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix').'/income-statement') }}"><span>Income Statement</span></a></li>
                </ul>
                </li>
                <!-- ============================== -->
              </ul>
          </li>
           <!-- ====== Users ================================ -->
          <li class="treeview">
              <a href="#"><i class="icon fa fa-user"></i><span>Users</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url(config('backpack.base.route_prefix').'/listuser') }}"><span>List Users</span></a></li>
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
