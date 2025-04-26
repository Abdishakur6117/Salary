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
            
        case 'display_attendance':
            display_attendance($conn);
            break;
            
        case 'create_attendance':
            create_attendance($conn);
            break;
            
        case 'update_attendance':
            update_attendance($conn);
            break;
            
        case 'delete_attendance':
            delete_attendance($conn);
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

function display_attendance($conn) {
    $query = "
        SELECT 
            a.id,
            e.id as employee_id,
            e.name as employee_name,
            a.date,
            a.status
        FROM attendance a
        JOIN employees e ON a.employee_id = e.id
    ";
    
    $stmt = $conn->query($query);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function create_attendance($conn) {
    $required = ['employee_id', 'date', 'status'];
    $data = [];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
        $data[$field] = $_POST[$field];
    }
    
    // Insert record
    $stmt = $conn->prepare("
        INSERT INTO attendance 
        (employee_id, date, status) 
        VALUES (?, ?, ?)
    ");
    
    $success = $stmt->execute([
        $data['employee_id'],
        $data['date'],
        $data['status']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Attendance recorded successfully'
        ]);
    } else {
        throw new Exception('Failed to record attendance');
    }
}

function update_attendance($conn) {
    // Accept both 'edit_id' and 'id' as the identifier
    $id = $_POST['edit_id'] ?? $_POST['id'] ?? null;
    
    $required = [
        'id' => $id,
        'edit_employee_id' => $_POST['edit_employee_id'] ?? null,
        'edit_date' => $_POST['edit_date'] ?? null,
        'edit_status' => $_POST['edit_status'] ?? null
    ];
    // Update record
    $stmt = $conn->prepare("
        UPDATE attendance SET
            employee_id = ?,
            date = ?,
            status = ?
        WHERE id = ?
    ");
    
    $success = $stmt->execute([
        $required['edit_employee_id'],
        $required['edit_date'],
        $required['edit_status'],
        $required['id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Attendance updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update attendance');
    }
}

function delete_attendance($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('Attendance ID is required');
    }
    
    $stmt = $conn->prepare("DELETE FROM attendance WHERE id = ?");
    $success = $stmt->execute([$_POST['id']]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Attendance deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete attendance');
    }
}
?>