<?php
include "../db.php";

// SOFT DELETE
if (isset($_GET['delete_id'])) {
  $delete_id = $_GET['delete_id'];
  mysqli_query($conn, "UPDATE services SET is_active=0 WHERE service_id=$delete_id");
  header("Location: services_list.php");
  exit;
}

$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Services - Assessment Beginner</title>
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
      <h2 class="fw-light mb-0">Services</h2>
      <a href="services_add.php" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Service
      </a>
    </div>

    <div class="card">
      <div class="card-body p-0">
        <table class="table table-borderless mb-0">
          <thead>
            <tr>
              <th class="ps-4">ID</th>
              <th>Name</th>
              <th>Rate</th>
              <th>Status</th>
              <th class="pe-4">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td class="ps-4 text-muted">#<?php echo $row['service_id']; ?></td>
                  <td class="fw-semibold"><?php echo htmlspecialchars($row['service_name']); ?></td>
                  <td class="text-muted">₱<?php echo number_format($row['hourly_rate'], 2); ?></td>
                  <td>
                    <?php if ($row['is_active'] == 1): ?>
                      <span class="badge bg-success-subtle text-success">Active</span>
                    <?php else: ?>
                      <span class="badge bg-secondary-subtle text-secondary">Inactive</span>
                    <?php endif; ?>
                  </td>
                  <td class="pe-4">
                    <a href="services_edit.php?id=<?php echo $row['service_id']; ?>" class="btn btn-sm btn-outline-primary me-1">
                      <i class="bi bi-pencil-fill me-1"></i> Edit
                    </a>
                    <?php if ($row['is_active'] == 1): ?>
                      <a href="services_list.php?delete_id=<?php echo $row['service_id']; ?>"
                         class="btn btn-sm btn-outline-danger"
                         onclick="return confirm('Deactivate this service?')">
                        <i class="bi bi-slash-circle me-1"></i> Deactivate
                      </a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center text-muted py-5">
                  <i class="bi bi-gear fs-2 d-block mb-2"></i>
                  No services found.
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