<?php
session_start();

// Check if the user is logged in and has the 'Admin' role
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'HR') {
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
            <a href="../HR_dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
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
                <a href="../HR/department.php" class="nav-link">
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
                <a href="../HR/designation.php" class="nav-link">
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
                <a href="../HR/employee.php" class="nav-link">
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
                <a href="../HR/Attendance.php" class="nav-link">
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
                <a href="../HR/allowance.php" class="nav-link">
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
                <a href="../HR/deduction.php" class="nav-link">
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
                <a href="../HR/salary.php" class="nav-link">
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
                <a href="../HR/employee_report.php" class="nav-link">
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
              <h1 class="m-0">Designation</h1>
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
                  <h3 class="card-title">Designation List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="userTable" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Department Name</th>
                        <th>Title</th>
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

            <div class="modal fade" id="designationModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" >Add New Designation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                          <div class="modal-body">
                                        <form id="designationForm" method="POST" action="" >
                                          <div class="row">
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                <label for="department">Department Name </label>
                                                <select name="department" id="department"  class="form-control">
                                                  <option value="">select Department</option>
                                                </select>
                                              </div>
                                            </div>
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                <label for="department">Title </label>
                                                <input type="text" class="form-control" id="title" name="title">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" >Save</button>
                                          </div>
                                        </form> 
                          </div>
                          

                      </div>

              </div>

          </div>

          <!-- insert/.modal -->
           <!--  update modal-->
            <div class="modal fade" id="edit_designationModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Update  Designation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                          <div class="modal-body">
                                        <form id="edit_designationForm" method="POST" action="" >
                                          <div class="row">
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                <label for="department">Department Name </label>
                                                <input type="hidden" class="form-control" id="edit_id" name="edit_id">
                                                <select name="edit_department" id="edit_department"  class="form-control">
                                                  <option value="">select Department</option>
                                                </select>
                                              </div>
                                            </div>
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                <label for="department">Title </label>
                                                <input type="text" class="form-control" id="edit_title" name="edit_title">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" >Update</button>
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
        $('#designationModal').modal('show');
        $('#designationForm')[0].reset();
    });
    
    // Initial data loading
    displayData();
    loadDepartment();
    // Load Department for dropdown
    function loadDepartment() {
        $.ajax({
            url: 'designationOperation.php?action=get_department',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success' && response.data) {
                    const $select = $('#department, #edit_department');
                    $select.empty().append('<option value="">Select Department</option>');
                    
                    response.data.forEach(department => {
                        $select.append($('<option>', {
                            value: department.id,
                            text: department.name
                        }));
                    });
                } else {
                    showError('Failed to load departments');
                }
            },
            error: function() {
                showError('Network error loading departments');
            }
        });
    }
    
    // Create attendance record
    $('#designationForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            type: 'POST',
            url: 'designationOperation.php?action=create_designation',
            data: $(this).serialize(),
            dataType: "json",
            success: function(res) {
                if (res.status === 'success') {
                    showSuccess(res.message, function() {
                        $('#designationModal').modal('hide');
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
    
    // Edit attendance record
    $(document).on('click', '.editBtn', function() {
        const userData = {
            id: $(this).data('id'),
            department_id: $(this).data('department_id'),
            title: $(this).data('title')
        };
        
        $('#edit_id').val(userData.id);
        $('#edit_department').val(userData.department_id);
        $('#edit_title').val(userData.title);
        
        $('#edit_designationModal').modal('show');
    });
    // Update this part in your JavaScript
    $('#edit_designationForm').submit(function(e) {
        e.preventDefault();
        const submitBtn = $(this).find('[type="submit"]');
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        
        // Prepare data with correct field names
        const formData = {
            edit_id: $('#edit_id').val(),
            department_id: $('#edit_department').val(),
            title: $('#edit_title').val()
        };
        
        $.ajax({
            url: 'designationOperation.php?action=update_designation',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    showSuccess(response.message, function() {
                        $('#edit_designationModal').modal('hide');
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
                submitBtn.prop('disabled', false).html('Update designation');
            }
        });
    });
    
    // Delete attendance record
    $(document).on('click', '.deleteBtn', function() {
        const designation_id = $(this).data('id');
        
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
                    url: 'designationOperation.php?action=delete_designation',
                    data: { id: designation_id },
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
            url: 'designationOperation.php?action=display_designation',
            dataType: 'json',
            success: function(rows) {
                let tableData = '';
                rows.forEach(row => {
                    tableData += `
                    <tr>
                        <td>${row.id}</td>
                        <td>${row.department_name}</td>
                        <td>${row.title}</td>
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