<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db.php';  // Database connection file

$bookingId = $_POST['bookingId'] ?? null;
$extendDate = $_POST['extendDate'] ?? null;

if ($bookingId && $extendDate) {
    $query = "UPDATE tblbooking SET extendDate = ? WHERE ID = ?";
    $stmt = $conn->prepare($query);
    
    // Bind parameters and execute the query
    $stmt->bind_param("si", $extendDate, $bookingId);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>
