<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $flight_number = $_POST['flight_number'];
    $travel_date = $_POST['travel_date'];
    $departure_city = $_POST['departure_city']; // <-- this is important
    $arrival_city = $_POST['arrival_city'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO bookings (name, email, flight_number, travel_date, departure_city, arrival_city, price) VALUES (?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssssd", $name, $email, $flight_number, $travel_date, $departure_city, $arrival_city, $price);

    if ($stmt->execute()) {
        header("Location: mybooking.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid Request";
}
?>
