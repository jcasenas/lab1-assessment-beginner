<?php
include "../db.php";

$sql = "
SELECT b.*, c.full_name AS client_name, s.service_name
FROM bookings b
JOIN clients c ON b.client_id = c.client_id
JOIN services s ON b.service_id = s.service_id
ORDER BY b.booking_id DESC
";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Bookings - Assessment Beginner</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
    .navbar { box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
    .card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
    .table thead th { background-color: #f1f3f5; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: #6c757d; border: none; }
    .table tbody tr { transition: background 0.15s; }
    .table tbody tr:hover { background-color: #f8f9fa; }
    .table td { vertical-align: middle; }
  </style>
</head>
<body>

  <?php include "../nav.php"; ?>

  <div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-light mb-0">Bookings</h2>
      <a href="bookings_create.php" class="btn btn-success">
        <i class="bi bi-calendar-plus me-1"></i> Create Booking
      </a>
    </div>

    <div class="card">
      <div class="card-body p-0">
        <table class="table table-borderless mb-0">
          <thead>
            <tr>
              <th class="ps-4">ID</th>
              <th>Client</th>
              <th>Service</th>
              <th>Date</th>
              <th>Hours</th>
              <th>Total</th>
              <th>Status</th>
              <th class="pe-4">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while($b = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td class="ps-4 text-muted">#<?php echo $b['booking_id']; ?></td>
                  <td class="fw-semibold"><?php echo htmlspecialchars($b['client_name']); ?></td>
                  <td class="text-muted"><?php echo htmlspecialchars($b['service_name']); ?></td>
                  <td class="text-muted"><?php echo $b['booking_date']; ?></td>
                  <td class="text-muted"><?php echo $b['hours']; ?> hr(s)</td>
                  <td class="fw-semibold">₱<?php echo number_format($b['total_cost'], 2); ?></td>
                  <td>
                    <?php
                      $status = $b['status'];
                      $badge  = match($status) {
                        'PAID'      => 'bg-success-subtle text-success',
                        'PENDING'   => 'bg-warning-subtle text-warning',
                        'CANCELLED' => 'bg-danger-subtle text-danger',
                        default     => 'bg-secondary-subtle text-secondary'
                      };
                    ?>
                    <span class="badge <?php echo $badge; ?>"><?php echo $status; ?></span>
                  </td>
                  <td class="pe-4">
                    <a href="payment_process.php?booking_id=<?php echo $b['booking_id']; ?>" class="btn btn-sm btn-outline-primary">
                      <i class="bi bi-credit-card me-1"></i> Process Payment
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="text-center text-muted py-5">
                  <i class="bi bi-calendar-x fs-2 d-block mb-2"></i>
                  No bookings found.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>