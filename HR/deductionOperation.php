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
            
        case 'display_deduction':
            display_deduction($conn);
            break;
            
        case 'create_deduction':
            create_deduction($conn);
            break;
            
        case 'update_deduction':
            update_deduction($conn);
            break;
            
        case 'delete_deduction':
            delete_deduction($conn);
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

function display_deduction($conn) {
    $query = "
        SELECT 
            d.id,
            e.id as employee_id,
            e.name as employee_name,
            d.amount,
            d.type,
            d.description,
            d.date
        FROM deductions d
        JOIN employees e ON d.employee_id = e.id
    ";
    
    $stmt = $conn->query($query);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function create_deduction($conn) {
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
        INSERT INTO deductions 
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
            'message' => 'Deduction recorded successfully'
        ]);
    } else {
        throw new Exception('Failed to record Deduction');
    }
}

function update_deduction($conn) {
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
        UPDATE deductions SET
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
            'message' => 'Deduction updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update Deduction');
    }
}

function delete_deduction($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('Deduction ID is required');
    }
    
    $stmt = $conn->prepare("DELETE FROM deductions WHERE id = ?");
    $success = $stmt->execute([$_POST['id']]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Deduction deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete Deduction');
    }
}
?>