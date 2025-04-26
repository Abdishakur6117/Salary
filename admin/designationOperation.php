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
        case 'display_designation':
            display_designation($conn);
            break;
            
        case 'create_designation':
            create_designation($conn);
            break;
            
        case 'update_designation':
            update_designation($conn);
            break;
            
        case 'delete_designation':
            delete_designation($conn);
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
function display_designation($conn) {
    $query = "
        SELECT 
            de.id,
            d.id as department_id,
            d.name as department_name,
            de.title
        FROM designations de
        JOIN departments d ON de.department_id = d.id
    ";
    
    $stmt = $conn->query($query);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function create_designation($conn) {
    $required = ['department', 'title'];
    $data = [];

    // Validate input
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
        $data[$field] = $_POST[$field];
    }

    // Check if designation already exists in the same department
    $stmt = $conn->prepare("
        SELECT id FROM designations
        WHERE department_id = ? AND title = ?
    ");
    $stmt->execute([
        $data['department'],
        $data['title']
    ]);

    if ($stmt->rowCount() > 0) {
        throw new Exception('A designation with this title already exists in this department.');
    }

    // Insert record
    $stmt = $conn->prepare("
        INSERT INTO designations (department_id, title)
        VALUES (?, ?)
    ");
    $success = $stmt->execute([
        $data['department'],
        $data['title']
    ]);

    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Designation recorded successfully'
        ]);
    } else {
        throw new Exception('Failed to record Designation');
    }
}


function update_designation($conn) {
    // Accept both 'edit_id' and 'id' as the identifier
    $id = $_POST['edit_id'] ?? $_POST['id'] ?? null;
    
    $required = [
        'id' => $id,
        'department_id' => $_POST['department_id'] ?? null,
        'title' => $_POST['title'] ?? null
    ];
    
    // Validate required fields
    foreach ($required as $field => $value) {
        if (empty($value)) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
    }
    $stmt = $conn->prepare("
    SELECT id FROM designations
    WHERE department_id = ? AND title = ? AND id != ?
      ");
      $stmt->execute([
          $required['department_id'],
          $required['title'],
          $required['id']
      ]);

      if ($stmt->rowCount() > 0) {
          throw new Exception('A designation with this title already exists in this department.');
      }

    
    // Update record
    $stmt = $conn->prepare("
        UPDATE designations SET
            department_id = ?,
            title = ?
        WHERE id = ?
    ");
    
    $success = $stmt->execute([
        $required['department_id'],
        $required['title'],
        $required['id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Designation updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update Designation');
    }
}

function delete_designation($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('Designation ID is required');
    }
    
    $stmt = $conn->prepare("DELETE FROM designations WHERE id = ?");
    $success = $stmt->execute([$_POST['id']]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Designation deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete Designation');
    }
}
?>