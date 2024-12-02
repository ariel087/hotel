<?php
header('Content-Type: application/json');
error_reporting(E_ALL); // Report all types of errors
ini_set('display_errors', 1); // Display errors on the browser
$conn = mysqli_connect("localhost","root","","hoteldb") or die(mysql_error());

$bookingId = $_POST['bookingId'] ?? null;
if ($bookingId) {
    $query = "SELECT * FROM tblbooking WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $bookingId);
    $stmt->execute();
    $result = $stmt->get_result();

    $events = [];
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }

    echo json_encode($events);
    
} else {
    echo json_encode([]);
}
?>
