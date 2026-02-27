<?php
include "../db.php";

$message = "";

if (isset($_POST['save'])) {
  $service_name = $_POST['service_name'];
  $description  = $_POST['description'];
  $hourly_rate  = $_POST['hourly_rate'];
  $is_active    = $_POST['is_active'];

  if ($service_name == "" || $hourly_rate == "") {
    $message = "Service name and hourly rate are required!";
  } else if (!is_numeric($hourly_rate) || $hourly_rate <= 0) {
    $message = "Hourly rate must be a number greater than 0.";
  } else {
    $sql = "INSERT INTO services (service_name, description, hourly_rate, is_active)
            VALUES ('$service_name', '$description', '$hourly_rate', '$is_active')";
    mysqli_query($conn, $sql);
    header("Location: services_list.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Service - Assessment Beginner</title>
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
      <a href="services_list.php" class="btn btn-sm btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
      </a>
      <h2 class="fw-light mb-0">Add Service</h2>
    </div>

    <?php if ($message): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <div class="card">
      <div class="card-body p-4">
        <form method="post">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Service Name <span class="text-danger">*</span></label>
              <input type="text" name="service_name" class="form-control" placeholder="Enter service name">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Hourly Rate (₱) <span class="text-danger">*</span></label>
              <input type="text" name="hourly_rate" class="form-control" placeholder="0.00">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Active?</label>
              <select name="is_active" class="form-select">
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Description</label>
              <textarea name="description" rows="4" class="form-control" placeholder="Enter service description"></textarea>
            </div>
          </div>

          <div class="mt-4 d-flex gap-2">
            <button type="submit" name="save" class="btn btn-primary">
              <i class="bi bi-check-lg me-1"></i> Save Service
            </button>
            <a href="services_list.php" class="btn btn-outline-secondary">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>