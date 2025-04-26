<?php
session_start();
require_once '../Connection/connection.php'; // Assumes this sets $pdo
$db = new DatabaseConnection();
$pdo = $db->getConnection();

header('Content-Type: application/json'); // Ensures JSON response

// Security check
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'HR') {
    echo json_encode(['data' => [], 'error' => 'Unauthorized access']);
    exit;
}

$searchTerm = $_POST['searchTerm'] ?? '';

try {
    $query = "SELECT e.id, e.name, e.email, e.phone, e.address, e.hire_date, 
                     d.name AS department_name, des.title AS designation_name, 
                     s.base_salary, e.status
              FROM employees e
              JOIN departments d ON e.department_id = d.id
              JOIN designations des ON e.designation_id = des.id
              LEFT JOIN salaries s ON e.id = s.employee_id
              WHERE e.name LIKE :search OR e.email LIKE :search OR e.phone LIKE :search";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['search' => "%$searchTerm%"]);

    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['data' => $employees]);

} catch (Exception $e) {
    echo json_encode(['data' => [], 'error' => $e->getMessage()]);
}
?>
