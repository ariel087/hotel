<?php
header('Content-Type: application/json');
error_reporting(E_ALL); // Report all types of errors
ini_set('display_errors', 1); // Display errors on the browser
require 'db.php';

$bookingId = $_POST['bookingId'] ?? null;
if ($bookingId) {
    $query = "SELECT * FROM tblbooking WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $bookingId);
    $stmt->execute();
    $result = $stmt->get_result();

    $events = [];
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;  // Include the entire row or specific fields
    }

    if (count($events) > 0) {
        // Return the CheckoutDate from the first row
        echo json_encode(['CheckoutDate' => $events[0]['CheckoutDate']]);  
    } else {
        echo json_encode(['CheckoutDate' => null]);  // If no events are found
    }
} else {
    echo json_encode(['CheckoutDate' => null]);  // If bookingId is not provided
}
?>
