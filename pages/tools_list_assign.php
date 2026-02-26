<?php
include "../db.php";

$message      = "";
$message_type = "success";

// ASSIGN TOOL
if (isset($_POST['assign'])) {
  $booking_id = $_POST['booking_id'];
  $tool_id    = $_POST['tool_id'];
  $qty        = $_POST['qty_used'];

  $toolRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT quantity_available FROM tools WHERE tool_id=$tool_id"));

  if ($qty > $toolRow['quantity_available']) {
    $message      = "Not enough available tools!";
    $message_type = "danger";
  } else {
    mysqli_query($conn, "INSERT INTO booking_tools (booking_id, tool_id, qty_used) VALUES ($booking_id, $tool_id, $qty)");
    mysqli_query($conn, "UPDATE tools SET quantity_available = quantity_available - $qty WHERE tool_id=$tool_id");
    $message = "Tool assigned successfully!";
  }
}

$tools    = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
$bookings = mysqli_query($conn, "SELECT booking_id FROM bookings ORDER BY booking_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tools - Assessment Beginner</title>
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
    <h2 class="fw-light mb-4">Tools / Inventory</h2>

    <?php if ($message): ?>
      <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
        <i class="bi bi-<?php echo $message_type === 'success' ? 'check-circle' : 'exclamation-triangle'; ?>-fill me-2"></i>
        <?php echo $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- Available Tools Table -->
    <div class="card mb-4">
      <div class="card-body p-0">
        <div class="px-4 pt-4 pb-2">
          <h5 class="fw-semibold mb-0">Available Tools</h5>
        </div>
        <table class="table table-borderless mb-0">
          <thead>
            <tr>
              <th class="ps-4">Tool Name</th>
              <th>Total</th>
              <th class="pe-4">Available</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($tools) > 0): ?>
              <?php while($t = mysqli_fetch_assoc($tools)): ?>
                <tr>
                  <td class="ps-4 fw-semibold"><?php echo htmlspecialchars($t['tool_name']); ?></td>
                  <td class="text-muted"><?php echo $t['quantity_total']; ?></td>
                  <td class="pe-4">
                    <?php
                      $avail = $t['quantity_available'];
                      $color = $avail == 0 ? 'bg-danger-subtle text-danger' : ($avail <= 2 ? 'bg-warning-subtle text-warning' : 'bg-success-subtle text-success');
                    ?>
                    <span class="badge <?php echo $color; ?>"><?php echo $avail; ?></span>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="3" class="text-center text-muted py-5">
                  <i class="bi bi-tools fs-2 d-block mb-2"></i>
                  No tools found.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Assign Tool Form -->
    <div class="card">
      <div class="card-body p-4">
        <h5 class="fw-semibold mb-4">Assign Tool to Booking</h5>
        <form method="post">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label fw-semibold">Booking ID</label>
              <select name="booking_id" class="form-select">
                <?php while($b = mysqli_fetch_assoc($bookings)): ?>
                  <option value="<?php echo $b['booking_id']; ?>">#<?php echo $b['booking_id']; ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Tool</label>
              <select name="tool_id" class="form-select">
                <?php
                  $tools2 = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
                  while($t2 = mysqli_fetch_assoc($tools2)):
                ?>
                  <option value="<?php echo $t2['tool_id']; ?>">
                    <?php echo htmlspecialchars($t2['tool_name']); ?> (Avail: <?php echo $t2['quantity_available']; ?>)
                  </option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Qty Used</label>
              <input type="number" name="qty_used" min="1" value="1" class="form-control">
            </div>
          </div>
          <div class="mt-4">
            <button type="submit" name="assign" class="btn btn-primary">
              <i class="bi bi-wrench me-1"></i> Assign Tool
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>