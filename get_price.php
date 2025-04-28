<?php
include 'db.php'; 

if (isset($_POST['departure']) && isset($_POST['arrival'])) {
    $departure = $_POST['departure'];
    $arrival = $_POST['arrival'];

    $query = "SELECT price FROM flights WHERE departure_city = '$departure' AND arrival_city = '$arrival' LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['price'];
    } else {
        echo "Not available";
    }
} else {
    echo "Invalid request";
}
?>
