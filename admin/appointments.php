<?php
// admin/appointments.php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php"); exit();
}

require_once __DIR__ . "/../includes/db.php";
include __DIR__ . "/header.php";
include __DIR__ . "/sidebar.php";

/* ---------- CSRF token ---------- */
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf = $_SESSION['csrf_token'];

/* ---------- Delete handler (POST) ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  if (!isset($_POST['csrf']) || $_POST['csrf'] !== $_SESSION['csrf_token']) {
    $_SESSION['flash_error'] = "Security check failed.";
    header("Location: appointments.php"); exit();
  }
  $delId = (int)$_POST['delete_id'];
  if ($delId > 0) {
    $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ?");
    $stmt->bind_param("i", $delId);
    if ($stmt->execute()) {
      $_SESSION['flash_ok'] = "Appointment #{$delId} deleted.";
    } else {
      $_SESSION['flash_error'] = "Failed to delete. Please try again.";
    }
    $stmt->close();
  }
  // rotate CSRF
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  header("Location: appointments.php"); exit();
}

/* ---------- Fetch appointments (newest first) ---------- */
$result = $conn->query("
  SELECT id, name, email, phone, service, preferred_date, preferred_time, status, notes, created_at
  FROM appointments
  ORDER BY id DESC
");
?>
<h2 class="mb-4 fw-bold" style="font-family:'Montserrat', sans-serif;">🗓 Manage Appointments</h2>

<?php if (!empty($_SESSION['flash_ok'])): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['flash_ok']); ?></div>
  <?php unset($_SESSION['flash_ok']); ?>
<?php endif; ?>
<?php if (!empty($_SESSION['flash_error'])): ?>
  <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['flash_error']); ?></div>
  <?php unset($_SESSION['flash_error']); ?>
<?php endif; ?>

<div class="card shadow-sm p-4">
  <h5 class="fw-bold mb-3">📋 Appointments (Important Fields)</h5>
  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Customer</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Service</th>
          <th>Preferred</th>
          <th>Status</th>
          <th>Notes (preview)</th>
          <th>Created</th>
          <th style="width:110px;">Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <?php
            $prefDate = $row['preferred_date'] ? date('d M Y', strtotime($row['preferred_date'])) : '-';
            $prefTime = $row['preferred_time'] ? date('H:i', strtotime($row['preferred_time'])) : '';
            $preferred = trim($prefDate . ' ' . $prefTime);
            $notesPreview = mb_strimwidth((string)$row['notes'], 0, 60, '…', 'UTF-8');
          ?>
          <tr>
            <td><?php echo (int)$row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            <td><?php echo htmlspecialchars($row['service']); ?></td>
            <td><?php echo htmlspecialchars($preferred); ?></td>
            <td>
              <?php if ($row['status'] === 'confirmed'): ?>
                <span class="badge bg-success">Confirmed</span>
              <?php elseif ($row['status'] === 'cancelled'): ?>
                <span class="badge bg-danger">Cancelled</span>
              <?php else: ?>
                <span class="badge bg-warning text-dark">Pending</span>
              <?php endif; ?>
            </td>
            <td title="<?php echo htmlspecialchars($row['notes']); ?>">
              <?php echo htmlspecialchars($notesPreview); ?>
            </td>
            <td><?php echo htmlspecialchars(date('d M Y H:i', strtotime($row['created_at']))); ?></td>
            <td>
              <form method="post" onsubmit="return confirm('Delete appointment #<?php echo (int)$row['id']; ?>?');">
                <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
                <input type="hidden" name="delete_id" value="<?php echo (int)$row['id']; ?>">
                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="10" class="text-center text-muted">No appointments found.</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . "/footer.php"; ?>
