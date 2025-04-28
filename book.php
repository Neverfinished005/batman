<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Book a Flight</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #f0f2f5; /* Light grey background */
      min-height: 100vh;
      color: #333;
      padding-top: 80px;
      background: url('https://png.pngtree.com/thumb_back/fh260/background/20231009/pngtree-close-up-3d-render-of-travel-insurance-booking-aircraft-model-passport-image_13566749.png') no-repeat center center fixed;
    background-size: cover;  /* Ensures the background image covers the entire page */
    background-attachment: fixed;  /* Keeps the image fixed while scrolling */
    }
    .container {
      background: white;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
      max-width: 700px;
      margin: 0 auto;
    }
    .form-group label {
      font-weight: 600;
      margin-bottom: 10px;
    }
    .form-control {
      border-radius: 8px;
      padding: 15px;
      font-size: 1.1em;
      border: 1px solid #ccc;
      transition: border-color 0.3s;
    }
    .form-control:focus {
      border-color: #007bff;
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }
    .btn-custom {
      background-color: #007bff;
      color: white;
      font-weight: 600;
      padding: 12px 25px;
      border-radius: 8px;
      transition: 0.3s;
      font-size: 1.2em;
      border: none;
      width: 100%;
    }
    .btn-custom:hover {
      background-color: #0056b3;
      transform: scale(1.05);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }
    .form-group select {
      font-size: 1em;
    }
    h2 {
      text-align: center;
      font-weight: bold;
      color: #333;
      margin-bottom: 30px;
    }
    .form-group {
      margin-bottom: 20px;
    }

    /* Seat Map Styling */
    .seat-map {
      display: grid;
      grid-template-columns: repeat(6, 50px);
      grid-gap: 10px;
      margin-top: 20px;
    }
    .seat {
      width: 50px;
      height: 50px;
      background-color: #e0e0e0;
      border-radius: 8px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }
    .seat.selected {
      background-color: #007bff;
      color: white;
    }
    .seat:disabled {
      background-color: #ccc;
      cursor: not-allowed;
    }
  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
  <h2>Book a Flight</h2>

  <form action="process_booking.php" method="POST">
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="flight_number">Flight Number</label>
      <input type="text" name="flight_number" id="flight_number" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="travel_date">Travel Date</label>
      <input type="date" name="travel_date" id="travel_date" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="departure_city">Departure City</label>
      <select name="departure_city" id="departure_city" class="form-control" required>
        <option value="">Select Departure</option>
        <option value="Mumbai">Mumbai</option>
        <option value="Delhi">Delhi</option>
        <option value="Paris">Paris</option>
        <!-- More options here -->
      </select>
    </div>
    <div class="form-group">
      <label for="arrival_city">Arrival City</label>
      <select name="arrival_city" id="arrival_city" class="form-control" required>
        <option value="">Select Arrival</option>
        <option value="New York">New York</option>
        <option value="London">London</option>
        <option value="Dubai">Dubai</option>
        <!-- More options here -->
      </select>
    </div>

    <!-- Seat Map -->
    <div class="form-group">
      <label for="seat_selection">Select Seat</label>
      <div id="seat_map" class="seat-map">
        <!-- Seat options will be added dynamically here -->
      </div>
    </div>
    <div class="form-group">
      <label for="flightPrice">Flight Price</label>
      <input type="text" id="flightPrice" name="price" class="form-control" readonly>
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-custom">Book Flight</button>
    </div>
  </form>
</div>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<script>
  $(document).ready(function() {
    // Dynamically generate the seat map (6 rows and 6 columns)
    const seatMap = $('#seat_map');
    const totalSeats = 36; // 6x6 grid
    for (let i = 1; i <= totalSeats; i++) {
      const seat = $('<div class="seat" data-seat="Seat ' + i + '">' + i + '</div>');
      seatMap.append(seat);
    }

    // Seat click event to toggle seat selection
    $(".seat").click(function() {
      if (!$(this).hasClass("selected") && !$(this).prop('disabled')) {
        $(this).addClass("selected");
      } else {
        $(this).removeClass("selected");
      }
    });

    // Handle city selection and price update
    $("#departure_city, #arrival_city").change(function() {
      var departure = $("#departure_city").val();
      var arrival = $("#arrival_city").val();

      if (departure && arrival) {
        $.ajax({
          url: "get_price.php",
          type: "POST",
          data: {departure: departure, arrival: arrival},
          success: function(data) {
            $("#flightPrice").val(data);
          }
        });
      }
    });
  });
</script>

</body>
</html>
