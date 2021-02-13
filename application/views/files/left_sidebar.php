<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-text mx-3">ETI PANEL</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link <?php if($this->uri->segment(3)=='dashboard'){ echo 'active'; } ?>" href="<?php echo base_url() ?>admin/user/dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Interface
      </div>t
      
      <!-- Nav Item - Pages Collapse Menu -->
      <?php if($this->session->userdata['admin_in']['role'] == 1 || $this->session->userdata['admin_in']['role'] == 2){ ?>
      <li class="nav-item">
        <a class="nav-link <?php if($this->uri->segment(3)=='department'){ echo 'active'; } ?>" href="<?php echo base_url() ?>admin/user/department">
          <i class="fas fa-fw fa-list"></i>
          <span>Department</span>
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link <?php if($this->uri->segment(3)=='designation'){ echo 'active'; } ?>" href="<?php echo base_url() ?>admin/user/designation">
          <i class="fas fa-fw fa-list"></i>
          <span>Designation</span>
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link <?php if($this->uri->segment(3)=='technology'){ echo 'active'; } ?>" href="<?php echo base_url() ?>admin/user/technology">
          <i class="fas fa-fw fa-cogs"></i>
          <span>Technology</span>
        </a>
      </li>
      <?php } ?>
      
      
      <!-- Account Module -->
      <?php if($this->session->userdata['admin_in']['role'] == 1 || $this->session->userdata['admin_in']['role'] == 2 || $this->session->userdata['admin_in']['role'] == 4){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAccount" aria-expanded="true" aria-controls="collapseAccount">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Account Section</span>
        </a>
        <div id="collapseAccount" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Account Section:</h6>
            <a class="collapse-item <?php if($this->uri->segment(3)=='site_survey_list_approved_by_coordinator_and_project_manager'){ echo 'active'; } ?>" href="<?php echo base_url(); ?>admin/User/site_survey_list_approved_by_coordinator_and_project_manager">Site Survey Expense</a>
            <a class="collapse-item <?php if($this->uri->segment(3)=='site_survey_list_where_partial_paid'){ echo 'active'; } ?>" href="<?php echo base_url(); ?>admin/User/site_survey_list_where_partial_paid">Partial Paid Survey List</a>
            <a class="collapse-item <?php if($this->uri->segment(3)=='all_site_survey_list'){ echo 'active'; } ?>" href="<?php echo base_url() ?>admin/user/all_site_survey_list">All Location Vist List</a>
            <a class="collapse-item <?php if($this->uri->segment(3)=='all_expense_sheet'){ echo 'active'; } ?>" href="<?php echo base_url() ?>admin/user/all_expense_sheet">All Expense Sheet</a>
            <a class="collapse-item <?php if($this->uri->segment(3)=='salaryStep2'){ echo 'active'; } ?>" href="<?php echo base_url(); ?>admin/User/salaryStep2">Pay Salary</a>
            <a class="collapse-item <?php if($this->uri->segment(3)=='paidSalaryList'){ echo 'active'; } ?>" href="<?php echo base_url(); ?>admin/User/paidSalaryList">Monthly Salary List</a>
          </div>
        </div>
      </li>
      <?php } ?>
      
      
      <!-- Nav Item - Pages Collapse Menu -->
      <?php if($this->session->userdata['admin_in']['role'] == 1 || $this->session->userdata['admin_in']['role'] == 2 || $this->session->userdata['admin_in']['role'] == 5){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
          <i class="fas fa-fw fa-cog"></i>
          <span>Site Location Visit</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="collapseThree" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Location / Spot Visit :</h6>
            <a class="collapse-item <?php if($this->uri->segment(3)=='site_survey_list'){ echo 'active'; } ?>" href="<?php echo base_url() ?>admin/user/site_survey_list">Location Visiting List</a>
            <a class="collapse-item <?php if($this->uri->segment(3)=='all_site_survey_list'){ echo 'active'; } ?>" href="<?php echo base_url() ?>admin/user/all_site_survey_list">All Location Vist List</a>
            <!--<a class="collapse-item <?php if($this->uri->segment(3)=='site_survey_list_approved_by_coordinator'){ echo 'active'; } ?>" href="<?php echo base_url() ?>admin/user/site_survey_list_approved_by_coordinator">Coordi. Approved List</a>-->
          </div>
        </div>
      </li>
      <?php } ?>
      
      
      
      <!-- Project manager Module -->
      <?php if($this->session->userdata['admin_in']['role'] == 1 || $this->session->userdata['admin_in']['role'] == 2){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePM" aria-expanded="true" aria-controls="collapsePM">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Project Manager</span>
        </a>
        <div id="collapsePM" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">PM Section:</h6>
            <a class="collapse-item <?php if($this->uri->segment(3)=='site_survey_list_approved_by_coordinator'){ echo 'active'; } ?>" href="<?php echo base_url(); ?>admin/User/site_survey_list_approved_by_coordinator">Site Survey Expense</a>
            <a class="collapse-item <?php if($this->uri->segment(3)=='all_site_survey_list'){ echo 'active'; } ?>" href="<?php echo base_url() ?>admin/user/all_site_survey_list">All Location Vist List</a>
          </div>
        </div>
      </li>
      <?php } ?>
      
      
      <!-- Hr Employee Module -->
      <?php if($this->session->userdata['admin_in']['role'] == 1 || $this->session->userdata['admin_in']['role'] == 2 || $this->session->userdata['admin_in']['role'] == 3){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseemp" aria-expanded="true" aria-controls="collapseemp">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Employee</span>
        </a>
        <div id="collapseemp" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Employee:</h6>
            <a class="collapse-item <?php if($this->uri->segment(3)=='add_employee'){ echo 'active'; } ?>" href="<?php echo base_url(); ?>admin/User/add_employee">Register Employee</a>
            <a class="collapse-item <?php if($this->uri->segment(3)=='employee_list'){ echo 'active'; } ?>" href="<?php echo base_url(); ?>admin/User/employee_list">Active Employee List</a>
            <a class="collapse-item <?php if($this->uri->segment(3)=='all_employee_list'){ echo 'active'; } ?>" href="<?php echo base_url(); ?>admin/User/all_employee_list">All Employee List</a>
            <a class="collapse-item <?php if($this->uri->segment(3)=='terminated_employee_list'){ echo 'active'; } ?>" href="<?php echo base_url(); ?>admin/User/terminated_employee_list">Terminated Employee List</a>
            <a class="collapse-item <?php if($this->uri->segment(3)=='createSalary'){ echo 'active'; } ?>" href="<?php echo base_url(); ?>admin/User/createSalary">Generate Salary</a>
            <a class="collapse-item <?php if($this->uri->segment(3)=='paidSalaryList'){ echo 'active'; } ?>" href="<?php echo base_url(); ?>admin/User/paidSalaryList">Monthly Salary List</a>
          </div>
        </div>
      </li>
      <?php } ?>
      
      
      <!-- Activate Login Account -->
      <?php if($this->session->userdata['admin_in']['role'] == 1 || $this->session->userdata['admin_in']['role'] == 2 || $this->session->userdata['admin_in']['role'] == 3){ ?>
      <li class="nav-item">
        <a class="nav-link <?php if($this->uri->segment(3)=='employeeLoginActivation'){ echo 'active'; } ?>" href="<?php echo base_url(); ?>admin/User/employeeLoginActivation">
          <i class="fas fa-user fa-sm fa-fw mr-2"></i>
          <span>Activate Login Account</span></a>
      </li>
      <?php } ?>
      
      <!-- Employee Location Activity Modules -->
      <?php if($this->session->userdata['admin_in']['role'] == 1 || $this->session->userdata['admin_in']['role'] == 2 || $this->session->userdata['admin_in']['role'] == 3 || $this->session->userdata['admin_in']['role'] == 5){ ?>
      <li class="nav-item">
        <a class="nav-link <?php if($this->uri->segment(3)=='employeeLocationActivity'){ echo 'active'; } ?>" href="<?php echo base_url(); ?>admin/User/employeeLocationActivity">
          <i class="fas fa-user fa-sm fa-fw mr-2"></i>
          <span>Location Activity</span></a>
      </li>
      <?php } ?>
      
      
      <?php if($this->session->userdata['admin_in']['role'] == 1 || $this->session->userdata['admin_in']['role'] == 2){ ?>
      <li class="nav-item">
        <a class="nav-link <?php if($this->uri->segment(3)=='coordinator'){ echo 'active'; } ?>" href="<?php echo base_url() ?>admin/user/coordinator">
          <i class="fas fa-fw fa-user-secret"></i>
          <span>Create Coordinator</span>
        </a>
      </li>
      <?php } ?>
      <?php if($this->session->userdata['admin_in']['role'] == 1 || $this->session->userdata['admin_in']['role'] == 2 || $this->session->userdata['admin_in']['role'] == 4){ ?>
      <li class="nav-item">
        <a class="nav-link <?php if($this->uri->segment(3)=='client'){ echo 'active'; } ?>" href="<?php echo base_url() ?>admin/user/client">
          <i class="fas fa-fw fa-users"></i>
          <span>Our Client</span>
        </a>
      </li>
      <?php } ?>
      <?php if($this->session->userdata['admin_in']['role'] == 1 || $this->session->userdata['admin_in']['role'] == 2 || $this->session->userdata['admin_in']['role'] == 4){ ?>
      <li class="nav-item">
        <a class="nav-link <?php if($this->uri->segment(3)=='project'){ echo 'active'; } ?>" href="<?php echo base_url() ?>admin/user/project">
          <i class="fas fa-fw fa-table"></i>
          <span>Project</span>
        </a>
      </li>
      <?php } ?>
      <?php if($this->session->userdata['admin_in']['role'] == 1 || $this->session->userdata['admin_in']['role'] == 2|| $this->session->userdata['admin_in']['role'] == 5 || $this->session->userdata['admin_in']['role'] == 3){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseteam" aria-expanded="true" aria-controls="collapseteam">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Team Lead</span>
        </a>
        <div id="collapseteam" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Team Lead:</h6>
            <a class="collapse-item <?php if($this->uri->segment(3)=='teamLead'){ echo 'active'; } ?>" href="<?php echo base_url(); ?>admin/User/teamLead">Assign Team Leader</a>
          </div>
        </div>
      </li>
      <?php } ?>
      
      <?php if($this->session->userdata['admin_in']['role'] == 1 || $this->session->userdata['admin_in']['role'] == 2){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdmin" aria-expanded="true" aria-controls="collapseAdmin">
          <i class="fas fa-fw fa-cog"></i>
          <span>Admin Master</span>
        </a>
        <div id="collapseAdmin" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Assign Panel</h6>
            <a class="collapse-item  <?php if($this->uri->segment(3)=='assignPanelToCoordinator'){ echo 'active'; } ?>" href="<?php echo base_url() ?>admin/user/assignPanelToCoordinator">Panel To Coordintor</a>
            <a class="collapse-item  <?php if($this->uri->segment(3)=='all_site_survey_list_details_with_expense'){ echo 'active'; } ?>" href="<?php echo base_url() ?>admin/user/all_site_survey_list_details_with_expense">survey expense list</a>
          </div>
        </div>
      </li>
      <?php } ?>
      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Utilities:</h6>
            <a class="collapse-item" href="utilities-color.html">Colors</a>
            <a class="collapse-item" href="utilities-border.html">Borders</a>
            <a class="collapse-item" href="utilities-animation.html">Animations</a>
            <a class="collapse-item" href="utilities-other.html">Other</a>
          </div>
        </div>
      </li>
      
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Login Screens:</h6>
            <a class="collapse-item" href="login.html">Login</a>
            <a class="collapse-item" href="register.html">Register</a>
            <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Other Pages:</h6>
            <a class="collapse-item" href="404.html">404 Page</a>
            <a class="collapse-item" href="blank.html">Blank Page</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item active">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>