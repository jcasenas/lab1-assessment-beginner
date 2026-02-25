<?php
include "../db.php";

$clients  = mysqli_query($conn, "SELECT * FROM clients ORDER BY full_name ASC");
$services = mysqli_query($conn, "SELECT * FROM services WHERE is_active=1 ORDER BY service_name ASC");

if (isset($_POST['create'])) {
  $client_id    = $_POST['client_id'];
  $service_id   = $_POST['service_id'];
  $booking_date = $_POST['booking_date'];
  $hours        = $_POST['hours'];

  $s    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT hourly_rate FROM services WHERE service_id=$service_id"));
  $rate = $s['hourly_rate'];
  $total = $rate * $hours;

  mysqli_query($conn, "INSERT INTO bookings (client_id, service_id, booking_date, hours, hourly_rate_snapshot, total_cost, status)
    VALUES ($client_id, $service_id, '$booking_date', $hours, $rate, $total, 'PENDING')");

  header("Location: bookings_list.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Create Booking - Assessment Beginner</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
    .navbar { box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
    .card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
  </style>
</head>
<body>

  <?php include "../nav.php"; ?>

  <div class="container py-5">
    <div class="d-flex align-items-center mb-4">
      <a href="bookings_list.php" class="btn btn-sm btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
      </a>
      <h2 class="fw-light mb-0">Create Booking</h2>
    </div>

    <div class="card">
      <div class="card-body p-4">
        <form method="post">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Client</label>
              <select name="client_id" class="form-select">
                <?php while($c = mysqli_fetch_assoc($clients)): ?>
                  <option value="<?php echo $c['client_id']; ?>"><?php echo htmlspecialchars($c['full_name']); ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Service</label>
              <select name="service_id" class="form-select">
                <?php while($s = mysqli_fetch_assoc($services)): ?>
                  <option value="<?php echo $s['service_id']; ?>">
                    <?php echo htmlspecialchars($s['service_name']); ?> (₱<?php echo number_format($s['hourly_rate'], 2); ?>/hr)
                  </option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Date</label>
              <input type="date" name="booking_date" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Hours</label>
              <input type="number" name="hours" min="1" value="1" class="form-control">
            </div>
          </div>

          <div class="mt-4 d-flex gap-2">
            <button type="submit" name="create" class="btn btn-success">
              <i class="bi bi-calendar-plus me-1"></i> Create Booking
            </button>
            <a href="bookings_list.php" class="btn btn-outline-secondary">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>