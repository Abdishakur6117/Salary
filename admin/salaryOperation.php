<?php
header('Content-Type: application/json');
require_once '../Connection/connection.php';

$action = $_GET['action'] ?? '';

try {
    $db = new DatabaseConnection();
    $conn = $db->getConnection();
    
    switch ($action) {
    case 'load_employees':
        load_employees($conn);
        break;
    case 'fetch_salary_info_simple':
        fetch_salary_info_simple($conn);
        break;
        
    case 'display_salary':
        display_salary($conn);
        break;
        
    case 'create_salary':
        create_salary($conn);
        break;
        
    case 'update_salary':
        update_salary($conn);
        break;
        
    case 'delete_salary':
        delete_salary($conn);
        break;
        
    default:
        throw new Exception('Invalid action');
}

} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

function load_employees($conn) {
    $stmt = $conn->query("SELECT id, name, salary  FROM employees WHERE status = 'Active'");
    echo json_encode([
    'status' => 'success',
    'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
    ]);
}
function fetch_salary_info_simple($conn) {
    $employee_id = $_POST['employee_id'];
    $month = !empty($_POST['month']) ? $_POST['month'] : date('Y-m'); // fallback to current month if empty

    // Base salary
    $stmt = $conn->prepare("SELECT salary FROM employees WHERE id = ?");
    $stmt->execute([$employee_id]);
    $base_salary = $stmt->fetchColumn() ?: 0;

    // Allowance
    $allow_stmt = $conn->prepare("SELECT SUM(amount) FROM allowances WHERE employee_id = ? AND DATE_FORMAT(date, '%Y-%m') = ?");
    $allow_stmt->execute([$employee_id, $month]);
    $total_allowance = $allow_stmt->fetchColumn() ?: 0;

    // Deduction
    $deduct_stmt = $conn->prepare("SELECT SUM(amount) FROM deductions WHERE employee_id = ? AND DATE_FORMAT(date, '%Y-%m') = ?");
    $deduct_stmt->execute([$employee_id, $month]);
    $total_deduction = $deduct_stmt->fetchColumn() ?: 0;

    // Net salary calculation
    $net_salary = $base_salary + $total_allowance - $total_deduction;

    echo json_encode([
        'status' => 'success',
        'base_salary' => number_format($base_salary, 2),
        'total_allowance' => number_format($total_allowance, 2),
        'total_deduction' => number_format($total_deduction, 2),
        'net_salary' => number_format($net_salary, 2)
    ]);
}
function display_salary($conn) {
    $query = "
        SELECT 
            s.id,
            e.id as employee_id,
            e.name as employee_name,
            s.month,
            s.base_salary,
            s.total_allowance,
            s.total_deduction,
            s.net_salary,
            s.payment_date
        FROM salaries s
        JOIN employees e ON s.employee_id = e.id
    ";
    
    $stmt = $conn->query($query);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
function create_salary($conn) {
    $required = ['employee_id', 'base_salary', 'total_allowance', 'total_deduction', 'net_salary', 'payment_date'];
    $data = [];

    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
        $data[$field] = $_POST[$field];
    }

    // Month value based on payment_date
    $month = date('Y-m', strtotime($data['payment_date']));

    $stmt = $conn->prepare("
        INSERT INTO salaries (
            employee_id, month, base_salary, total_allowance, total_deduction, net_salary, payment_date
        ) VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $success = $stmt->execute([
        $data['employee_id'],
        $month,
        $data['base_salary'],
        $data['total_allowance'],
        $data['total_deduction'],
        $data['net_salary'],
        $data['payment_date']  // Using the POST value instead of NOW()
    ]);

    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Salary recorded successfully'
        ]);
    } else {
        throw new Exception('Failed to record salary');
    }
}

function update_salary($conn) {
    $required = ['edit_id', 'employee_id', 'month', 'base_salary', 'total_allowance', 'total_deduction', 'net_salary', 'payment_date'];
    $data = [];

    // Validate the incoming data
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
        $data[$field] = $_POST[$field];
    }

    // Sanity check for month format: Ensure it's in 'YYYY-MM' format
    if (!preg_match('/^\d{4}-\d{2}$/', $data['month'])) {
        throw new Exception('Invalid month format. Please use YYYY-MM.');
    }

    // Prepare and execute the update query
    $stmt = $conn->prepare("
        UPDATE salaries SET
            employee_id = ?,
            month = ?,
            base_salary = ?,
            total_allowance = ?,
            total_deduction = ?,
            net_salary = ?,
            payment_date = ?
        WHERE id = ?
    ");

    $success = $stmt->execute([
        $data['employee_id'],
        $data['month'],
        $data['base_salary'],
        $data['total_allowance'],
        $data['total_deduction'],
        $data['net_salary'],
        $data['payment_date'],
        $data['edit_id'] // The ID to identify which salary record to update
    ]);

    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Salary updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update salary');
    }
}


function delete_salary($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('Salary ID is required');
    }
    
    $stmt = $conn->prepare("DELETE FROM salaries WHERE id = ?");
    $success = $stmt->execute([$_POST['id']]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Salary deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete Salary');
    }
}
?>