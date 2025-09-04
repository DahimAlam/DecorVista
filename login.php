<?php
session_start();
include("includes/db.php");

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND password=? LIMIT 1");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['role'] = $row['role'];

        if ($row['role'] == 'admin') {
            header("Location: admin/dashboard.php"); exit;
        } elseif ($row['role'] == 'designer') {
            header("Location: designer/dashboard.php"); exit;
        } else {
            header("Location: user/dashboard.php"); exit;
        }
    } else {
        $msg = "Invalid email or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - DecorVista</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include("includes/header.php"); ?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card card-custom shadow-lg border-0">
        <div class="card-body">
          <h3 class="text-center mb-4 heading-primary">Login</h3>
          <?php if($msg): ?><div class="alert alert-danger"><?php echo $msg; ?></div><?php endif; ?>
          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control input-custom" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control input-custom" required>
            </div>
            <button type="submit" class="btn btn-theme w-100">Login</button>
            <p class="text-center mt-3">Don't have an account? <a href="register.php">Register</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
</body>
</html>
