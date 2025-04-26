<?php
header('Content-Type: application/json');
require_once '../Connection/connection.php';

$action = $_GET['action'] ?? '';

try {
    $db = new DatabaseConnection();
    $conn = $db->getConnection();
    
    switch ($action) {            
        case 'display_department':
            display_department($conn);
            break;
            
        case 'create_department':
            create_department($conn);
            break;
            
        case 'update_department':
            update_department($conn);
            break;
            
        case 'delete_department':
            delete_department($conn);
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

function display_department($conn) {
    $query = "
        SELECT 
            id,
            name,
            description
        FROM departments 
    ";
    
    $stmt = $conn->query($query);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function create_department($conn) {
    $required = ['department_name', 'description'];
    $data = [];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
        $data[$field] = $_POST[$field];
    }
    // Insert record
    $stmt = $conn->prepare("
        INSERT INTO departments 
        (name, description) 
        VALUES (?, ?)
    ");
    
    $success = $stmt->execute([
        $data['department_name'],
        $data['description']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Department recorded successfully'
        ]);
    } else {
        throw new Exception('Failed to record Department');
    }
}

function update_department($conn) {
    // Accept both 'edit_id' and 'id' as the identifier
    $id = $_POST['edit_id'] ?? $_POST['id'] ?? null;
    
    $required = [
        'id' => $id,
        'name' => $_POST['edit_department_name'] ?? null,
        'description' => $_POST['edit_description'] ?? null
    ];
    
    // Validate required fields
    foreach ($required as $field => $value) {
        if (empty($value)) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
    }
    
    // Update record
    $stmt = $conn->prepare("
        UPDATE departments SET
            name = ?,
            description = ?
        WHERE id = ?
    ");
    
    $success = $stmt->execute([
        $required['name'],
        $required['description'],
        $required['id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Department updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update Department');
    }
}

function delete_department($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('Department ID is required');
    }
    
    $stmt = $conn->prepare("DELETE FROM departments WHERE id = ?");
    $success = $stmt->execute([$_POST['id']]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Department deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete Department');
    }
}
?>