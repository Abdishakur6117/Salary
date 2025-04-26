<?php
session_start();

// Check if the user is logged in and has the 'Admin' role
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'Admin') {
    // Redirect to login page if not logged in or not an Admin
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     
</head>
<body class="hold-transition sidebar-mini layout-fixed">

   <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../index.php" class="nav-link">Home</a>
      </li>
   
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
            <i class="fas fa-user-circle"></i>
            <strong><?php echo $_SESSION['user'] ?? 'User'; ?></strong>
        </a>
        <li>
            <a class="dropdown-item" href="../logout.php" onclick="return confirm('Are you sure you want to logout?');">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </a>
        </li>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
     <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="../index.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../admin/user.php" class="nav-link">
                  <i class="fas fa-list nav-icon"></i>
                  <p>User List</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-university"></i>
              <p>
                Departments
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../admin/department.php" class="nav-link">
                  <i class="fas fa-list nav-icon"></i>
                  <p>Department List</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>
                Designations
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../admin/designation.php" class="nav-link">
                  <i class="fas fa-list nav-icon"></i>
                  <p>Designation List</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Employees
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../admin/employee.php" class="nav-link">
                  <i class="fas fa-list nav-icon"></i>
                  <p>Employee List</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-clipboard-check"></i>
              <p>
                Attendance
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../admin/Attendance.php" class="nav-link">
                  <i class="fas fa-list nav-icon"></i>
                  <p>Attendance List</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-hand-holding-usd"></i>
              <p>
                Allowances
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../admin/allowance.php" class="nav-link">
                  <i class="fas fa-list nav-icon"></i>
                  <p>Allowance List</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-minus-circle"></i>
              <p>
                Deductions
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../admin/deduction.php" class="nav-link">
                  <i class="fas fa-list nav-icon"></i>
                  <p>Deduction List</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-money-bill-wave"></i>
              <p>
                Salaries
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../admin/salary.php" class="nav-link">
                  <i class="fas fa-list nav-icon"></i>
                  <p>Salary List</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-bar"></i>
              <p>
                Reports
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../admin/employee_report.php" class="nav-link">
                  <i class="fas fa-file-alt nav-icon"></i>
                  <p>Employee Report</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>

            
       
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Salary</h1>
            </div>
            <div class="col-sm-6">
              <button type="button" class="btn btn-primary float-right" id="insertModal">
                <i class="fas fa-plus"></i> Add New Salary
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Salary List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="userTable" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Employee Name</th>
                        <th>Month</th>
                        <th>Base Salary</th>
                        <th>Total Allowance</th>
                        <th>Total Deduction</th>
                        <th>Salary</th>
                        <th>Payment Date</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
  </div>

  <!-- User Modal -->

            <div class="modal fade" id="salaryModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" >Add New Salary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                          <div class="modal-body">
                              <form id="salaryForm" method="POST">
                                      <div class="row">
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label for="employee_id">Employee Name</label>
                                                  <select name="employee_id" id="employee_id" class="form-control">
                                                      <option value="">Select Employee</option>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label for="month">Month (YYYY-MM):</label>
                                                  <input type="month" name="month" id="month" class="form-control">
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label for="base_salary">Base Salary:</label>
                                                  <input type="text" id="base_salary" name="base_salary" class="form-control" readonly>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label for="total_allowance">Total Allowance:</label>
                                                  <input type="text" id="total_allowance" name="total_allowance" class="form-control" readonly>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label for="total_deduction">Total Deduction:</label>
                                                  <input type="text" id="total_deduction" name="total_deduction" class="form-control" readonly>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label for="net_salary">Net Salary:</label>
                                                  <input type="text" id="net_salary" name="net_salary" class="form-control" readonly>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label for="payment">Payment Date:</label>
                                                  <input type="date" id="payment_date" name="payment_date" class="form-control">
                                              </div>
                                          </div>
                                      </div>
                                      <div class="form-group text-right">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-primary">Save</button>
                                      </div>
                              </form>

                          </div>
                          

                      </div>

              </div>

          </div>

          <!-- insert/.modal -->
           <!--  update modal-->
            <div class="modal fade" id="edit_salaryModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Update  Salary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                          <div class="modal-body">
                              <form id="edit_salaryForm" method="POST">
                                      <div class="row">
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label for="employee_id">Employee Name</label>
                                                  <input type="text" name="edit_id" id="edit_id" class="form-control">
                                                  <select name="edit_employee_id" id="edit_employee_id" class="form-control">
                                                      <option value="">Select Employee</option>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label for="month">Month (YYYY-MM):</label>
                                                  <input type="month" name="edit_month" id="edit_month" class="form-control">
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label for="base_salary">Base Salary:</label>
                                                  <input type="text" id="edit_base_salary" name="base_salary" class="form-control" readonly>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label for="total_allowance">Total Allowance:</label>
                                                  <input type="text" id="edit_total_allowance" name="total_allowance" class="form-control" readonly>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label for="total_deduction">Total Deduction:</label>
                                                  <input type="text" id="edit_total_deduction" name="total_deduction" class="form-control" readonly>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label for="net_salary">Net Salary:</label>
                                                  <input type="text" id="edit_net_salary" name="net_salary" class="form-control" readonly>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label for="payment">Payment Date:</label>
                                                  <input type="date" id="edit_payment_date" name="edit_payment_date" class="form-control">
                                              </div>
                                          </div>
                                      </div>
                                      <div class="form-group text-right">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                      </div>
                              </form>


                          </div>
                          

                      </div>

              </div>

          </div>

    <footer class="main-footer">
      <strong>Copyright &copy; 2015-2023 <a href="https://https://www.Group J/">Group J</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
      </div>
    </footer>


  <!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../dist/js/pages/dashboard.js"></script>

  <!-- Additional script for DataTables -->
  <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

  <script>
  $(document).ready(function() {
    // Initialize modals and load data
    $('#insertModal').click(function() {
        $('#salaryModal').modal('show');
        $('#salaryForm')[0].reset();
    });
    
    // Initial data loading
    displayData();
    loadEmployee();
    // // Load Employee for dropdown
    function loadEmployee() {
      $.ajax({
          url: 'salaryOperation.php?action=load_employees',
          method: 'GET',
          dataType: 'json',
          success: function(response) {
              if (response.status === 'success' && response.data) {
                  const $select = $('#employee_id, #edit_employee_id');
                  $select.empty().append('<option value="">Select Employee</option>');

                  // Kaydi macluumaadka employee ID iyo salary
                  response.data.forEach(employee => {
                      $select.append(
                          $('<option>', {
                              value: employee.id,
                              text: employee.name,
                              'data-salary': employee.salary  // <- Save salary as data attribute
                          })
                      );
                  });

                  // Add change event once loaded
                  $select.off('change').on('change', function () {
                      const selected = $(this).find('option:selected');
                      const salary = selected.data('salary') || '';
                      $('#base_salary').val(salary);  // Fill base salary input
                  });

              } else {
                  showError('Failed to load employees.');
              }
          },
          error: function() {
              showError('Network error loading employees.');
          }
      });
    }

    // When either employee or month changes, fetch salary info
    $('#employee_id, #month').on('change', function () {
        const employeeId = $('#employee_id').val();
        const month = $('#month').val() || new Date().toISOString().slice(0, 7);

        if (employeeId && month) {
            $.post('salaryOperation.php?action=fetch_salary_info_simple', {
                employee_id: employeeId,
                month: month
            }, function (data) {
                if (data.status === 'success') {
                    $('#base_salary').val(data.base_salary);
                    $('#total_allowance').val(data.total_allowance);
                    $('#total_deduction').val(data.total_deduction);
                    $('#net_salary').val(data.net_salary);
                } else {
                    alert('Failed to fetch salary data');
                }
            }, 'json');
        }
    });

    //insert
    $('#salaryForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            type: 'POST',
            url: 'salaryOperation.php?action=create_salary',
            data: $(this).serialize(),
            dataType: "json",
            success: function(res) {
                if (res.status === 'success') {
                    showSuccess(res.message, function() {
                        $('#salaryModal').modal('hide');
                        displayData();
                    });
                } else {
                    showError(res.message);
                }
            },
            error: function() {
                showError('An error occurred while submitting the form.');
            }
        });
    });

    //edit  When either employee or month changes, fetch salary info
    $('#edit_employee_id, #edit_month').on('change', function () {
      const employeeId = $('#edit_employee_id').val();
      const month = $('#edit_month').val() || new Date().toISOString().slice(0, 7);

      if (employeeId && month) {
          $.post('salaryOperation.php?action=fetch_salary_info_simple', {
              employee_id: employeeId,
              month: month
          }, function (data) {
              if (data.status === 'success') {
                  $('#edit_base_salary').val(data.base_salary);
                  $('#edit_total_allowance').val(data.total_allowance);
                  $('#edit_total_deduction').val(data.total_deduction);
                  $('#edit_net_salary').val(data.net_salary);
              } else {
                  alert('Failed to fetch salary data');
              }
          }, 'json');
      }
    });

    //all fill form
    $(document).on('click', '.editBtn', function () {
      // Ka hel xogta button-ka
      const employeeId = $(this).data('employee_id');
      const month = $(this).data('month');
      const baseSalary = $(this).data('base_salary');
      const totalAllowance = $(this).data('total_allowance');
      const totalDeduction = $(this).data('total_deduction');
      const netSalary = $(this).data('net_salary');
      const paymentDate = $(this).data('payment_date');
      const id = $(this).data('id'); // ID of the record

      // Set values to modal form inputs
      $('#edit_employee_id').val(employeeId);
      $('#edit_month').val(month);
      $('#edit_base_salary').val(baseSalary);
      $('#edit_total_allowance').val(totalAllowance);
      $('#edit_total_deduction').val(totalDeduction);
      $('#edit_net_salary').val(netSalary);
      $('#edit_payment_date').val(paymentDate);
      $('#edit_id').val(id); // Set ID if needed for further updates

      // Trigger the change to fetch updated salary if needed
      $('#edit_employee_id').trigger('change');
      $('#edit_month').val(month);

      // Show the modal
      $('#edit_salaryModal').modal('show');
    });

    //update
    $('#edit_salaryForm').submit(function(e) {
        e.preventDefault();
        const submitBtn = $(this).find('[type="submit"]');
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        
        // Prepare data with correct field names
        const formData = {
            edit_id: $('#edit_id').val(),
            employee_id: $('#edit_employee_id').val(),
            month: $('#edit_month').val(),
            base_salary: $('#edit_base_salary').val(),
            total_allowance: $('#edit_total_allowance').val(),
            total_deduction: $('#edit_total_deduction').val(),
            net_salary: $('#edit_net_salary').val(),
            payment_date: $('#edit_payment_date').val()
        };
        
        $.ajax({
            url: 'salaryOperation.php?action=update_salary',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    showSuccess(response.message, function() {
                        $('#edit_salaryModal').modal('hide');
                        displayData();
                    });
                } else {
                    showError(response.message);
                }
            },
            error: function(xhr) {
                showError('An error occurred: ' + xhr.statusText);
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('Update salary');
            }
        });
    });

    //delete
    $(document).on('click', '.deleteBtn', function() {
        const salary_id = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: 'salaryOperation.php?action=delete_salary',
                    data: { id: salary_id },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            showSuccess(res.message, function() {
                                displayData();
                            });
                        } else {
                            showError(res.message);
                        }
                    },
                    error: function() {
                        showError('An error occurred while deleting.');
                    }
                });
            }
        });
    });

    // Display attendance data in table
    function displayData() {
        $.ajax({
            url: 'salaryOperation.php?action=display_salary',
            dataType: 'json',
            success: function(rows) {
                let tableData = '';
                rows.forEach(row => {
                    tableData += `
                    <tr>
                        <td>${row.id}</td>
                        <td>${row.employee_name}</td>
                        <td>${row.month}</td>
                        <td>${row.base_salary}</td>
                        <td>${row.total_allowance}</td>
                        <td>${row.total_deduction}</td>
                        <td>${row.net_salary}</td>
                        <td>${row.payment_date}</td>
                        <td>
                            <button class="btn btn-warning btn-sm editBtn" 
                                data-id="${row.id}" 
                                data-employee_id="${row.employee_id}"
                                data-month="${row.month}"
                                data-base_salary="${row.base_salary}"
                                data-total_allowance="${row.total_allowance}"
                                data-total_deduction="${row.total_deduction}"
                                data-net_salary="${row.net_salary}"
                                data-payment_date="${row.payment_date}">
                                Edit
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-id="${row.id}">
                                Delete
                            </button>
                        </td>
                    </tr>`;
                });
                
                if($.fn.DataTable.isDataTable('#userTable')) {
                    $('#userTable').DataTable().destroy();
                }
                
                $('#userTable tbody').html(tableData);
                initDataTable();
            },
            error: function() {
                showError('Failed to load Users data');
            }
        });
    }

    
    // Initialize DataTable
    function initDataTable() {
        $('#userTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            responsive: true
        });
    }
    
    // Helper function to show success messages
    function showSuccess(message, callback) {
        Swal.fire({
            title: 'Success!',
            text: message,
            icon: 'success',
            confirmButtonText: 'OK',
            timer: 3000
        }).then(callback);
    }
    
    // Helper function to show error messages
    function showError(message) {
        Swal.fire({
            title: 'Error!',
            text: message,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
  });
  </script>
</body>
</html>