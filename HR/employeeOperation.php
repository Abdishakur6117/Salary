<?php
header('Content-Type: application/json');
require_once '../Connection/connection.php';

$action = $_GET['action'] ?? '';

try {
    $db = new DatabaseConnection();
    $conn = $db->getConnection();
    
    switch ($action) {
       case 'get_department':
            get_department($conn);
            break;  
            
        case 'get_designation':
            get_designation($conn);
            break;  
            
        case 'display_employee':
            display_employee($conn);
            break;
            
        case 'create_employee':
            create_employee($conn);
            break;
            
        case 'update_employee':
            update_employee($conn);
            break;
            
        case 'delete_employee':
            delete_employee($conn);
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

function get_department($conn) {
    $stmt = $conn->query("SELECT id, name FROM departments ORDER BY name");
    echo json_encode([
        'status' => 'success',
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
    ]);
}
function get_designation($conn) {
    $stmt = $conn->query("SELECT id, title FROM designations ORDER BY title");
    echo json_encode([
        'status' => 'success',
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
    ]);
}
function display_employee($conn) {
    $query = "
        SELECT 
            e.id,
            e.name,
            e.email,
            e.phone,
            e.address,
            e.hire_date,
            d.id AS department_id,
            d.name AS department_name,
            de.id AS designation_id,
            de.title AS designation_name,
            e.salary,
            e.status
        FROM employees e
        JOIN departments d ON e.department_id = d.id
        JOIN designations de ON e.designation_id = de.id
    ";
    
    $stmt = $conn->query($query);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function create_employee($conn) {
    $required = ['name', 'email', 'phone','address','hire_date','department_id','designation_id','salary','status'];
    $data = [];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
        $data[$field] = $_POST[$field];
    }    
    // Check for duplicate
    $stmt = $conn->prepare("
        SELECT id FROM employees 
        WHERE email = ?
    ");
    $stmt->execute([$data['email']]);
    if ($stmt->rowCount() > 0) {
        throw new Exception('Employee record already exists for this Email');
    }
    
    // Insert record
    $stmt = $conn->prepare("
        INSERT INTO employees 
        (name, email, phone,address,hire_date,department_id,designation_id,salary, status) 
        VALUES (?, ?, ?,?,?,?,?,?,?)
    ");
    
    $success = $stmt->execute([
        $data['name'],
        $data['email'],
        $data['phone'],
        $data['address'],
        $data['hire_date'],
        $data['department_id'],
        $data['designation_id'],
        $data['salary'],
        $data['status']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Employee recorded successfully'
        ]);
    } else {
        throw new Exception('Failed to record Employee');
    }
}

function update_employee($conn) {
    // Accept both 'edit_id' and 'id' as the identifier
    $id = $_POST['edit_id'] ?? $_POST['id'] ?? null;
    
    $required = [
        'id' => $id,
        'edit_name' => $_POST['edit_name'] ?? null,
        'edit_email' => $_POST['edit_email'] ?? null,
        'edit_phone' => $_POST['edit_phone'] ?? null,
        'edit_address' => $_POST['edit_address'] ?? null,
        'edit_hire_date' => $_POST['edit_hire_date'] ?? null,
        'edit_department_id' => $_POST['edit_department_id'] ?? null,
        'edit_designation_id' => $_POST['edit_designation_id'] ?? null,
        'edit_salary' => $_POST['edit_salary'] ?? null,
        'edit_status' => $_POST['edit_status'] ?? null
    ];
    
    // Validate required fields
    foreach ($required as $field => $value) {
        if (empty($value)) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
    }
    // Check for duplicate (excluding current record)
    $stmt = $conn->prepare("
        SELECT id FROM employees 
        WHERE email = ?  AND id != ?
    ");
    $stmt->execute([
        $required['edit_email'],
        $required['id']
    ]);
    if ($stmt->rowCount() > 0) {
        throw new Exception('employee record already exists for this email');
    }
    
    // Update record
    $stmt = $conn->prepare("
        UPDATE employees SET
            name = ?,
            email = ?,
            phone = ?,
            address = ?,
            hire_date = ?,
            department_id = ?,
            designation_id = ?,
            salary = ?,
            status = ?
        WHERE id = ?
    ");
    
    $success = $stmt->execute([
        $required['edit_name'],
        $required['edit_email'],
        $required['edit_phone'],
        $required['edit_address'],
        $required['edit_hire_date'],
        $required['edit_department_id'],
        $required['edit_designation_id'],
        $required['edit_salary'],
        $required['edit_status'],
        $required['id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'employee updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update employee');
    }
}

function delete_employee($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('Employee ID is required');
    }
    
    $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
    $success = $stmt->execute([$_POST['id']]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Employee deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete Employee');
    }
}
?>