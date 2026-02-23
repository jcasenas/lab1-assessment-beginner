<?php
// index.php
require_once __DIR__ . "/db.php";

// --- Clients ---
$r = mysqli_query($conn, "SELECT COUNT(*) AS c FROM `clients`");
$clients = $r ? (int)mysqli_fetch_assoc($r)['c'] : 0;

// --- Services ---
$r = mysqli_query($conn, "SELECT COUNT(*) AS c FROM `services`");
$services = $r ? (int)mysqli_fetch_assoc($r)['c'] : 0;

// --- Bookings ---
$r = mysqli_query($conn, "SELECT COUNT(*) AS c FROM `bookings`");
$bookings = $r ? (int)mysqli_fetch_assoc($r)['c'] : 0;

// --- Revenue ---
$r = mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid), 0) AS s FROM `payments`");
$revenue = $r ? (float)mysqli_fetch_assoc($r)['s'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard - Assessment Beginner</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
    .navbar { box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
    .card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); transition: all 0.2s ease; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0,0,0,0.1); }
    .card-icon { font-size: 2.5rem; opacity: 0.9; }
    .card-title { font-size: 0.95rem; color: #6c757d; margin-bottom: 0.4rem; }
    .card-value { font-size: 2.2rem; font-weight: 600; }
  </style>
</head>
<body>

  <!-- Navbar -->
  <?php
    $nav_path = __DIR__ . "/nav.php";
    if (file_exists($nav_path)) {
        include $nav_path;
    } else {
        echo "<!-- DEBUG: nav.php not found at: " . $nav_path . " -->";
    }
  ?>

  <div class="container py-5">
    <h2 class="mb-4 fw-light text-center">Dashboard Overview</h2>

    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="card text-center h-100">
          <div class="card-body">
            <i class="bi bi-people-fill text-primary card-icon mb-3"></i>
            <div class="card-title">Total Clients</div>
            <div class="card-value"><?php echo $clients; ?></div>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="card text-center h-100">
          <div class="card-body">
            <i class="bi bi-gear-wide-connected text-success card-icon mb-3"></i>
            <div class="card-title">Total Services</div>
            <div class="card-value"><?php echo $services; ?></div>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="card text-center h-100">
          <div class="card-body">
            <i class="bi bi-calendar-check text-info card-icon mb-3"></i>
            <div class="card-title">Total Bookings</div>
            <div class="card-value"><?php echo $bookings; ?></div>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="card text-center h-100">
          <div class="card-body">
            <i class="bi bi-currency-dollar text-warning card-icon mb-3"></i>
            <div class="card-title">Total Revenue</div>
            <div class="card-value">₱<?php echo number_format($revenue, 2); ?></div>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-5 text-center">
      <h5 class="mb-3 text-muted">Quick Actions</h5>
      <a href="/assessment_beginner/pages/clients_add.php" class="btn btn-outline-primary mx-2">Add Client</a>
      <a href="/assessment_beginner/pages/bookings_create.php" class="btn btn-outline-success mx-2">Create Booking</a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>