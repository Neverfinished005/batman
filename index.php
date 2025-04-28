<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flight Booking - Home</title>

  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: 'Inter', sans-serif;
    background: url('https://discoverydmc.com/blog/wp-content/uploads/2016/03/Emirates-flight-to-yangon.jpg') no-repeat center center fixed;
    background-size: cover;
    color: #333;
}

    nav {
        position: fixed;
        width: 100%;
        background:rgb(0, 0, 0);
        padding: 15px 0;
        z-index: 1000;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }
    nav a {
        color: white;
        margin: 0 20px;
        text-decoration: none;
        font-weight: 600;
        font-size: 18px;
        padding: 8px 16px;
        border-radius: 5px;
        transition: background 0.3s;
    }
    nav a:hover {
        background:rgb(0, 0, 0);
    }
    .content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding-top: 180px;
        min-height: 100vh;
    }
    .content h1 {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 20px;
        color:rgb(0, 0, 0);
    }
    .content p {
        font-size: 20px;
        margin-bottom: 30px;
        color: #555;
    }
    .btn-custom {
        background:rgb(0, 0, 0);
        color: white;
        padding: 14px 32px;
        font-weight: 600;
        font-size: 18px;
        border-radius: 30px;
        text-decoration: none;
        display: inline-block;
        transition: background 0.3s, transform 0.3s;
    }
    .btn-custom:hover {
        background:rgb(0, 0, 0);
        transform: scale(1.05);
    }
</style>

</head>
<body>


<nav>
  <a href="index.php">Home</a>
  <a href="mybooking.php">My Booking</a>
  <a href="book.php">Book Flight</a>
  <a href="track.php">Track Flight</a>
  <a href="Search.php">search</a>

  
</nav>


<div class="content">
  <h1>Welcome to Flight Booking!</h1>
  <p>Book flights easily, quickly, and safely with us.</p>
  <a href="book.php" class="btn-custom">Book Now</a>
</div>

</body>
</html>
