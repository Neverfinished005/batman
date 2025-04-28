<?php include 'db.php'; ?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Track Flight</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind CSS for browser (lightweight) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
   
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            padding-top: 80px;
        }
        #map-container {
            width: 100%;
            max-width: 900px;
            margin: 30px auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        #map {
            height: 450px;
            width: 100%;
        }
        .form-section {
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .form-group label {
            font-weight: 600;
        }
        select.form-control {
            height: 50px;
            border-radius: 10px;
        }
        .btn-custom {
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 8px;
            font-weight: 600;
        }
        .btn-success {
            background-color: #22c55e;
            border: none;
        }
        .btn-danger {
            background-color: #ef4444;
            border: none;
        }
        .btn-success:hover {
            background-color: #16a34a;
        }
        .btn-danger:hover {
            background-color: #dc2626;
        }
        #error-message, #distance-info {
            margin-top: 20px;
            font-weight: bold;
            font-size: 18px;
        }
    </style>

</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">

    <h2 class="text-center text-3xl font-bold mb-6">Track Flight</h2>

    <!-- Form Section -->
    <div class="form-section">
        <div class="form-group">
            <label for="departureCity">Departure City</label>
            <select id="departureCity" class="form-control">
                <option value="" disabled selected>Select departure city</option>
            </select>
        </div>

        <div class="form-group">
            <label for="arrivalCity">Arrival City</label>
            <select id="arrivalCity" class="form-control">
                <option value="" disabled selected>Select arrival city</option>
            </select>
        </div>

        <div class="text-center mt-4">
            <button onclick="plotFlightRoute()" class="btn btn-success btn-custom mr-2">Plot Flight Route</button>
            <button onclick="clearMap()" class="btn btn-danger btn-custom">Clear Map</button>
        </div>
    </div>

    <!-- Map Section -->
    <div id="map-container" class="mt-5">
        <div id="map"></div>
    </div>

    <!-- Error and Distance Info -->
    <div id="error-message" class="text-center text-red-600"></div>
    <div id="distance-info" class="text-center text-green-600"></div>

</div>

<!-- JavaScript -->
<script>
    var map = L.map('map').setView([20, 0], 2);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; OpenStreetMap contributors'
    }).addTo(map);

    var departureMarker, arrivalMarker, flightRouteLine;
    const errorMessageDiv = document.getElementById('error-message');
    const distanceInfoDiv = document.getElementById('distance-info');
    const departureCityDropdown = document.getElementById('departureCity');
    const arrivalCityDropdown = document.getElementById('arrivalCity');

    const cities = [
        "New York", "Los Angeles", "Chicago", "Houston", "Phoenix", "Philadelphia", "San Antonio", "San Diego", "Dallas", "San Jose",
        "London", "Paris", "Tokyo", "Berlin", "Sydney", "Moscow", "Mumbai", "Shanghai", "Toronto", "Rio de Janeiro",
        "Johannesburg", "Cairo", "Dubai", "Singapore", "Hong Kong", "Bangkok", "Kuala Lumpur", "Jakarta", "Rome", "Madrid",
        "Amsterdam", "Stockholm", "Copenhagen", "Oslo", "Helsinki", "Vienna", "Zurich", "Geneva", "Dublin", "Edinburgh",
        "Manchester", "Liverpool", "Glasgow", "Birmingham", "Leeds", "Newcastle", "Sheffield", "Bristol", "Cardiff", "Belfast",
        "Melbourne", "Brisbane", "Perth", "Adelaide", "Auckland", "Wellington", "Christchurch", "Vancouver", "Montreal", "Calgary",
        "Edmonton", "Ottawa", "Quebec City", "Winnipeg", "Halifax", "Victoria", "Saskatoon", "Regina", "Kelowna"
    ];

    function populateCityDropdowns() {
        cities.forEach(city => {
            const option1 = document.createElement("option");
            option1.value = city;
            option1.textContent = city;
            departureCityDropdown.appendChild(option1);

            const option2 = document.createElement("option");
            option2.value = city;
            option2.textContent = city;
            arrivalCityDropdown.appendChild(option2);
        });
    }

    populateCityDropdowns();

    async function geocodeCity(cityName) {
        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(cityName)}&format=json&limit=1`);
            const data = await response.json();
            if (data && data.length > 0) {
                return [parseFloat(data[0].lat), parseFloat(data[0].lon)];
            } else {
                return null;
            }
        } catch (error) {
            console.error("Error during geocoding:", error);
            return null;
        }
    }

    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = deg2rad(lat2 - lat1);
        const dLon = deg2rad(lon2 - lon1);
        const a =
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
            Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }
    function deg2rad(deg) {
        return deg * (Math.PI/180);
    }

    async function plotFlightRoute() {
        errorMessageDiv.textContent = '';
        distanceInfoDiv.textContent = '';

        const departureCity = departureCityDropdown.value;
        const arrivalCity = arrivalCityDropdown.value;

        if (!departureCity || !arrivalCity) {
            errorMessageDiv.textContent = "Please select both cities.";
            return;
        }

        const departureCoords = await geocodeCity(departureCity);
        const arrivalCoords = await geocodeCity(arrivalCity);

        if (!departureCoords || !arrivalCoords) {
            errorMessageDiv.textContent = "City not found!";
            return;
        }

        clearMap();

        departureMarker = L.marker(departureCoords).addTo(map).bindPopup(`Departure: ${departureCity}`).openPopup();
        arrivalMarker = L.marker(arrivalCoords).addTo(map).bindPopup(`Arrival: ${arrivalCity}`);
        flightRouteLine = L.polyline([departureCoords, arrivalCoords], {color: 'blue'}).addTo(map);

        const distance = calculateDistance(departureCoords[0], departureCoords[1], arrivalCoords[0], arrivalCoords[1]);
        distanceInfoDiv.textContent = `Distance: ${distance.toFixed(2)} km`;
        map.fitBounds([departureCoords, arrivalCoords], {padding: [50, 50]});
    }

    function clearMap() {
        if (departureMarker) { map.removeLayer(departureMarker); }
        if (arrivalMarker) { map.removeLayer(arrivalMarker); }
        if (flightRouteLine) { map.removeLayer(flightRouteLine); }
        map.setView([20, 0], 2);
    }
</script>

</body>
</html>
