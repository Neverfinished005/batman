<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    background: url('https://png.pngtree.com/thumb_back/fh260/background/20240522/pngtree-airplane-ceiling-interior-of-console-image_15692659.jpg') no-repeat center center fixed;
    background-size: cover;  
    background-attachment: fixed;  
}
.container {
    background-color: #ffffff;
    
    background-size: cover;  
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 30px;
}

    table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }
    th, td {
        text-align: center;
        padding: 12px 15px;
    }
    th {
        background-color:rgb(104, 68, 158);
        color: white;
        font-size: 16px;
    }
    td {
        background-color:rgb(255, 255, 255);
        color: #333;
        font-size: 14px;
    }
    tr:nth-child(even) td { background-color: #e9ecef; }
    tr:hover { background-color:rgb(255, 255, 255); }
    @media (max-width: 767px) {
        h2 { font-size: 28px; }
        table { font-size: 12px; }
    }
</style>

</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h2>My Bookings</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Flight Number</th>
                <th>Travel Date</th>
                <th>Departure City</th>
                <th>Arrival City</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = $conn->query("SELECT * FROM bookings ORDER BY id DESC");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['flight_number']}</td>
                    <td>{$row['travel_date']}</td>
                    <td>" . (isset($row['departure_city']) ? $row['departure_city'] : 'N/A') . "</td>
                    <td>" . (isset($row['arrival_city']) ? $row['arrival_city'] : 'N/A') . "</td>
                    <td>" . (isset($row['price']) ? $row['price'] : 'N/A') . "</td>
                  </tr>";
        }        
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
