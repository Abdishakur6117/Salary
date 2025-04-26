<?php
header('Content-Type: application/json');
require_once '../Connection/connection.php';

$action = $_GET['action'] ?? '';

try {
    $db = new DatabaseConnection();
    $conn = $db->getConnection();
    
    switch ($action) {            
        case 'display_user':
            display_user($conn);
            break;
            
        case 'create_user':
            create_user($conn);
            break;
            
        case 'update_user':
            update_user($conn);
            break;
            
        case 'delete_user':
            delete_user($conn);
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

function display_user($conn) {
    $query = "
        SELECT 
            id,
            username,
            role,
            created_at
        FROM users 
    ";
    
    $stmt = $conn->query($query);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function create_user($conn) {
    $required = ['username', 'password', 'confirmPassword','role'];
    $data = [];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
        $data[$field] = $_POST[$field];
    }
    
    // Check for duplicate username and email
    $stmt = $conn->prepare("
        SELECT id FROM users 
        WHERE username = ?  
    ");
    $stmt->execute([$data['username']]);
    if ($stmt->rowCount() > 0) {
        throw new Exception('users record already exists for this username');
    }

    if ($data['password'] !== $data['confirmPassword']) {
    throw new Exception('Passwords do not match');
    }


    
    // Insert record
    $stmt = $conn->prepare("
        INSERT INTO users 
        (username, password, role) 
        VALUES (?, ?, ?)
    ");
    
    $success = $stmt->execute([
        $data['username'],
        $data['password'],
        $data['role']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'users recorded successfully'
        ]);
    } else {
        throw new Exception('Failed to record user');
    }
}

function update_user($conn) {
    // Accept both 'edit_id' and 'id' as the identifier
    $id = $_POST['edit_id'] ?? $_POST['id'] ?? null;
    
    $required = [
        'id' => $id,
        'username' => $_POST['edit_username'] ?? null,
        'role' => $_POST['edit_role'] ?? null
    ];
    
    // Validate required fields
    foreach ($required as $field => $value) {
        if (empty($value)) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
    }
    
        // Check for duplicate (excluding current record)
        $stmt = $conn->prepare("
            SELECT id FROM users 
            WHERE username = ?  AND id != ?
        ");
        $stmt->execute([
            $required['username'],
            $required['id']
        ]);
        if ($stmt->rowCount() > 0) {
            throw new Exception('A user with this username already exists.');
        }
    
    // Update record
    $stmt = $conn->prepare("
        UPDATE users SET
            username = ?,
            role = ?
        WHERE id = ?
    ");
    
    $success = $stmt->execute([
        $required['username'],
        $required['role'],
        $required['id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'User updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update Users');
    }
}

function delete_user($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('User ID is required');
    }
    
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $success = $stmt->execute([$_POST['id']]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'user deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete user');
    }
}
?>