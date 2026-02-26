<?php
include "../db.php";

$sql = "
SELECT p.*, b.booking_date, c.full_name
FROM payments p
JOIN bookings b ON p.booking_id = b.booking_id
JOIN clients c ON b.client_id = c.client_id
ORDER BY p.payment_id DESC
";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Payments - Assessment Beginner</title>
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
      <h2 class="fw-light mb-0">Payments</h2>
    </div>

    <div class="card">
      <div class="card-body p-0">
        <table class="table table-borderless mb-0">
          <thead>
            <tr>
              <th class="ps-4">ID</th>
              <th>Client</th>
              <th>Booking ID</th>
              <th>Amount</th>
              <th>Method</th>
              <th class="pe-4">Date</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while($p = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td class="ps-4 text-muted">#<?php echo $p['payment_id']; ?></td>
                  <td class="fw-semibold"><?php echo htmlspecialchars($p['full_name']); ?></td>
                  <td class="text-muted">#<?php echo $p['booking_id']; ?></td>
                  <td class="fw-semibold text-success">₱<?php echo number_format($p['amount_paid'], 2); ?></td>
                  <td>
                    <?php
                      $method = $p['method'];
                      $badge  = match($method) {
                        'CASH'  => 'bg-success-subtle text-success',
                        'GCASH' => 'bg-primary-subtle text-primary',
                        'CARD'  => 'bg-info-subtle text-info',
                        default => 'bg-secondary-subtle text-secondary'
                      };
                    ?>
                    <span class="badge <?php echo $badge; ?>"><?php echo $method; ?></span>
                  </td>
                  <td class="pe-4 text-muted"><?php echo $p['payment_date']; ?></td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center text-muted py-5">
                  <i class="bi bi-credit-card fs-2 d-block mb-2"></i>
                  No payments found.
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