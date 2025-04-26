<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
            padding: 30px;
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            margin-bottom: 40px;
            border-radius: 12px;
            border: none;
            box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        }
        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-top: 25px;
        }
        .table th {
            background: #2c3e50;
            color: white;
        }
        .btn-print {
            margin-top: 30px;
        }
        @media print {
            .btn-print { display: none; }
        }
    </style>
</head>
<body>
  <?php
session_start();
require_once '../Connection/connection.php';

$db = new DatabaseConnection();
$pdo = $db->getConnection();

// Admin check
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'HR') {
    echo "Unauthorized access";
    exit();
}

// Get employee ID from URL
$employeeId = $_GET['id'] ?? null;
if (!$employeeId) {
    echo "Invalid employee ID.";
    exit();
}

// Fetch employee info
$employeeQuery = "SELECT e.id, e.name, e.email, e.phone, e.address, e.hire_date, d.name AS department_name, des.title AS designation_name, e.status
                  FROM employees e
                  JOIN departments d ON e.department_id = d.id
                  JOIN designations des ON e.designation_id = des.id
                  WHERE e.id = :id";
$stmt = $pdo->prepare($employeeQuery);
$stmt->execute(['id' => $employeeId]);
$employee = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$employee) {
    echo "Employee not found.";
    exit();
}

// Fetch salaries
$salaryStmt = $pdo->prepare("SELECT * FROM salaries WHERE employee_id = ?");
$salaryStmt->execute([$employee['id']]);
$salaries = $salaryStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch attendance
$attStmt = $pdo->prepare("SELECT date, status FROM attendance WHERE employee_id = ? ORDER BY date DESC LIMIT 30");
$attStmt->execute([$employee['id']]);
$attendance = $attStmt->fetchAll(PDO::FETCH_ASSOC);
?>


<h2 class="text-center mb-5">Employee Report</h2>

<div class="card">
    <div class="card-body">
        <h4 class="mb-3 text-primary"><?= htmlspecialchars($employee['name']) ?> 
            <small class="text-muted">| <?= htmlspecialchars($employee['designation_name']) ?></small>
        </h4>

        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Email:</strong> <?= $employee['email'] ?></p>
                <p><strong>Phone:</strong> <?= $employee['phone'] ?></p>
                <p><strong>Status:</strong> <?= $employee['status'] ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Address:</strong> <?= $employee['address'] ?></p>
                <p><strong>Hire Date:</strong> <?= $employee['hire_date'] ?></p>
                <p><strong>Department:</strong> <?= $employee['department_name'] ?></p>
                <p><strong>Designation:</strong> <?= $employee['designation_name'] ?></p>
            </div>
        </div>

        <?php if (count($salaries)): ?>
            <div class="section-title">💰 Salary History</div>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Base Salary</th>
                        <th>Allowance</th>
                        <th>Deduction</th>
                        <th>Net Salary</th>
                        <th>Payment Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($salaries as $salary): ?>
                        <tr>
                            <td><?= $salary['month'] ?></td>
                            <td>$<?= number_format($salary['base_salary'], 2) ?></td>
                            <td>$<?= number_format($salary['total_allowance'], 2) ?></td>
                            <td>$<?= number_format($salary['total_deduction'], 2) ?></td>
                            <td><strong>$<?= number_format($salary['net_salary'], 2) ?></strong></td>
                            <td><?= $salary['payment_date'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <?php if (count($attendance)): ?>
            <div class="section-title">📅 Attendance (Last 30 Days)</div>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($attendance as $att): ?>
                        <tr>
                            <td><?= $att['date'] ?></td>
                            <td><?= $att['status'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<div class="text-center">
    <button class="btn btn-primary btn-print" onclick="window.print()">
        <i class="fas fa-print"></i> Print Report
    </button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
