<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Flights</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Search Flights</h2>
    
    <form method="POST" action="search.php">
        <div class="form-group">
            <label>Departure City:</label>
            <input type="text" name="departure" class="form-control" placeholder="Enter Departure City" required>
        </div>

        <div class="form-group">
            <label>Arrival City:</label>
            <input type="text" name="arrival" class="form-control" placeholder="Enter Arrival City" required>
        </div>

        <button type="submit" name="search" class="btn btn-primary btn-block">Search Flights</button>
    </form>

    <hr>

    <?php
    if (isset($_POST['search'])) {
        $departure = $_POST['departure'];
        $arrival = $_POST['arrival'];

        $sql = "SELECT * FROM flights WHERE departure_city='$departure' AND arrival_city='$arrival'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<h4 class='text-center mb-4'>Available Flights</h4>";
            echo "<table class='table table-bordered'>";
            echo "<tr><th>ID</th><th>Departure</th><th>Arrival</th><th>Price</th><th>Action</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['departure_city'] . "</td>";
                echo "<td>" . $row['arrival_city'] . "</td>";
                echo "<td>$" . number_format($row['price'], 2) . "</td>";
                echo "<td><a href='book.php?flight_id=" . $row['id'] . "' class='btn btn-success btn-sm'>Book Now</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='text-danger text-center'>No flights found.</p>";
        }
    }
    ?>
</div>

</body>
</html>
