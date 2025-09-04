<?php
session_start();
include("includes/db.php");

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role     = $_POST['role'];

    if (!empty($name) && !empty($email) && !empty($password) && !empty($role)) {
       
        $check = $conn->prepare("SELECT * FROM users WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $msg = "Email already exists!";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $name, $email, $password, $role);
            if ($stmt->execute()) {
                if ($role == "designer") {
                    $designer_id = $stmt->insert_id;
                    $conn->query("INSERT INTO designers (user_id) VALUES ($designer_id)");
                }
                $msg = "Registration successful! You can login now.";
            } else {
                $msg = "Error: " . $conn->error;
            }
        }
    } else {
        $msg = "All fields are required!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - DecorVista</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include("includes/header.php"); ?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card card-custom shadow-lg border-0">
        <div class="card-body">
          <h3 class="text-center mb-4 heading-primary">Create Account</h3>
          <?php if($msg): ?><div class="alert alert-info text-center"><?php echo $msg; ?></div><?php endif; ?>
          <form method="POST">
            
            
            <div class="mb-3">
              <label class="form-label">Full Name</label>
              <input type="text" name="name" class="form-control input-custom"
                     pattern="^[A-Za-z ]{3,}$"
                     title="Name must be at least 3 letters and only alphabets"
                     required>
            </div>

            <!-- Email -->
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control input-custom"
                     pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                     title="Enter a valid email address"
                     required>
            </div>

            <!-- Password -->
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" id="password" class="form-control input-custom"
                     pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$"
                     title="Password must be 8+ chars, include 1 uppercase, 1 lowercase, 1 number & 1 special character"
                     required>
              <div class="strength-meter mt-2"><div id="strength-bar"></div></div>
            </div>

            <!-- Role -->
            <div class="mb-3">
              <label class="form-label">Register As</label>
              <select name="role" class="form-select input-custom" required>
                <option value="user">User</option>
                <option value="designer">Designer</option>
              </select>
            </div>

            <button type="submit" class="btn btn-theme w-100">Register</button>
            <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const password = document.getElementById("password");
  const bar = document.getElementById("strength-bar");

  if(password && bar){
    password.addEventListener("input", () => {
      let val = password.value;
      let strength = 0;

      if (/[a-z]/.test(val)) strength++;
      if (/[A-Z]/.test(val)) strength++;
      if (/[0-9]/.test(val)) strength++;
      if (/[@$!%*?&]/.test(val)) strength++;
      if (val.length >= 8) strength++;

      bar.className = "";
      if (strength <= 2 && val.length > 0) {
        bar.classList.add("weak");
      } else if (strength > 2 && strength <= 4) {
        bar.classList.add("medium");
      } else if (strength > 4) {
        bar.classList.add("strong");
      }
    });
  }
});
</script>
</body>
</html>
