<?php
header('Content-Type: application/json');
require_once '../Connection/connection.php';

$action = $_GET['action'] ?? '';

try {
    $db = new DatabaseConnection();
    $conn = $db->getConnection();
    
    switch ($action) {
        case 'get_employee':
            get_employee($conn);
            break;
            
        case 'display_allowance':
            display_allowance($conn);
            break;
            
        case 'create_allowance':
            create_allowance($conn);
            break;
            
        case 'update_allowance':
            update_allowance($conn);
            break;
            
        case 'delete_allowance':
            delete_allowance($conn);
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

function get_employee($conn) {
    $stmt = $conn->query("SELECT id, name FROM employees ORDER BY name");
    echo json_encode([
        'status' => 'success',
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
    ]);
}

function display_allowance($conn) {
    $query = "
        SELECT 
            a.id,
            e.id as employee_id,
            e.name as employee_name,
            a.amount,
            a.type,
            a.description,
            a.date
        FROM allowances a
        JOIN employees e ON a.employee_id = e.id
    ";
    
    $stmt = $conn->query($query);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function create_allowance($conn) {
    $required = ['employee_id', 'amount', 'type','description','date'];
    $data = [];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
        $data[$field] = $_POST[$field];
    }
    
    // Insert record
    $stmt = $conn->prepare("
        INSERT INTO allowances 
        (employee_id, amount, type,description,date) 
        VALUES (?, ?, ?, ?, ?)
    ");
    
    $success = $stmt->execute([
        $data['employee_id'],
        $data['amount'],
        $data['type'],
        $data['description'],
        $data['date']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Allowance recorded successfully'
        ]);
    } else {
        throw new Exception('Failed to record Allowance');
    }
}

function update_allowance($conn) {
    // Accept both 'edit_id' and 'id' as the identifier
    $id = $_POST['edit_id'] ?? $_POST['id'] ?? null;
    
    $required = [
        'id' => $id,
        'edit_employee_id' => $_POST['edit_employee_id'] ?? null,
        'edit_amount' => $_POST['edit_amount'] ?? null,
        'edit_type' => $_POST['edit_type'] ?? null,
        'edit_description' => $_POST['edit_description'] ?? null,
        'edit_date' => $_POST['edit_date'] ?? null
    ];
    // Update record
    $stmt = $conn->prepare("
        UPDATE allowances SET
            employee_id = ?,
            amount = ?,
            type = ?,
            description = ?,
            date = ?
        WHERE id = ?
    ");
    
    $success = $stmt->execute([
        $required['edit_employee_id'],
        $required['edit_amount'],
        $required['edit_type'],
        $required['edit_description'],
        $required['edit_date'],
        $required['id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Allowance updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update allowance');
    }
}

function delete_allowance($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('Allowance ID is required');
    }
    
    $stmt = $conn->prepare("DELETE FROM allowances WHERE id = ?");
    $success = $stmt->execute([$_POST['id']]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Allowance deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete allowance');
    }
}
?>