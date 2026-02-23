<?php
include "../db.php";
$result = mysqli_query($conn, "SELECT * FROM clients ORDER BY client_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Clients - Assessment Beginner</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
    .navbar { box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
    .card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
    .table thead th { background-color: #f1f3f5; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; border: none; }
    .table td { vertical-align: middle; font-size: 0.95rem; }
    .table tbody tr:hover { background-color: #f8f9fa; }
  </style>
</head>
<body>

<?php include "../nav.php"; ?>

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-light mb-0">Clients</h2>
    <a href="clients_add.php" class="btn btn-primary">
      <i class="bi bi-person-plus-fill me-1"></i> Add Client
    </a>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead>
          <tr>
            <th class="px-4 py-3">ID</th>
            <th class="py-3">Name</th>
            <th class="py-3">Email</th>
            <th class="py-3">Phone</th>
            <th class="py-3">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td class="px-4"><?php echo $row['client_id']; ?></td>
              <td><?php echo htmlspecialchars($row['full_name']); ?></td>
              <td><?php echo htmlspecialchars($row['email']); ?></td>
              <td><?php echo htmlspecialchars($row['phone']); ?></td>
              <td>
                <a href="clients_edit.php?id=<?php echo $row['client_id']; ?>" class="btn btn-sm btn-outline-primary">
                  <i class="bi bi-pencil-fill me-1"></i> Edit
                </a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>