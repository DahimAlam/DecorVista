<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include("../includes/db.php");
include("header.php");
include("sidebar.php");

// Approve Designer
if(isset($_GET['approve'])){
    $id = $_GET['approve'];
    
    // Fetch designer details before updating the status
    $result = $conn->query("SELECT * FROM designers WHERE designer_id='$id'");
    $designer = $result->fetch_assoc();

    // Get designer's name and email
    $designer_name = $designer['name'];
    $designer_email = $designer['email'];

    // Update the designer's status to 'approved'
    $conn->query("UPDATE designers SET status='approved' WHERE designer_id='$id'");

    
    
    // Redirect back to the designers page

// after approval or action
echo "
<script>
    setTimeout(function(){
        window.location = 'designers.php';
    }, 7000); // 5,000 ms = 5 seconds
</script>
";


}

// Reject Designer
if(isset($_GET['reject'])){
    $id = $_GET['reject'];
    $conn->query("UPDATE designers SET status='rejected' WHERE designer_id='$id'");
    echo "
<script>
    setTimeout(function(){
        window.location = 'designers.php';
    }, 5000); // 7,000 ms = 5 seconds
</script>
";
}

// Delete Designer
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->query("DELETE FROM designers WHERE designer_id='$id'");
    echo "<script>alert('Designer Deleted'); window.location='designers.php';</script>";
}

// Fetch all designers
$designers = $conn->query("SELECT * FROM designers ORDER BY designer_id DESC");
?>

<h2 class="mb-4 fw-bold" style="font-family:'Montserrat', sans-serif;">🎨 Manage Designers</h2>

<div style="position:relative;background:#fff;border-radius:12px;box-shadow:0 6px 20px rgba(0,0,0,.06);border:1px solid #ececf5;padding:16px;overflow:hidden;">
  <h5 style="font-weight:700;margin:0 0 12px 0;">📋 Designers List</h5>

  <!-- Scroll area (vertical + horizontal) -->
  <div style="max-height:520px;overflow:auto;">
    <table class="table table-bordered table-striped align-middle"
           style="min-width:1100px;border-collapse:separate;border-spacing:0;">
      <thead>
        <tr>
          <th style="position:sticky;top:0;z-index:2;background:#212529;color:#fff;">ID</th>
          <th style="position:sticky;top:0;z-index:2;background:#212529;color:#fff;">Name</th>
          <th style="position:sticky;top:0;z-index:2;background:#212529;color:#fff;">Email</th>
          <th style="position:sticky;top:0;z-index:2;background:#212529;color:#fff;">CNIC</th>
          <th style="position:sticky;top:0;z-index:2;background:#212529;color:#fff;">Expertise</th>
          <th style="position:sticky;top:0;z-index:2;background:#212529;color:#fff;">Bio</th>
          <th style="position:sticky;top:0;z-index:2;background:#212529;color:#fff;">Status</th>
          <th style="position:sticky;top:0;z-index:2;background:#212529;color:#fff;">Profile Pic</th>
          <th style="position:sticky;top:0;z-index:2;background:#212529;color:#fff;">Portfolio</th>
          <th style="position:sticky;top:0;z-index:2;background:#212529;color:#fff;white-space:nowrap;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $designers->fetch_assoc()): ?>
        <tr>
          <td style="white-space:nowrap;"><?= $row['designer_id'] ?></td>
          <td style="white-space:nowrap;"><?= $row['name'] ?></td>
          <td style="white-space:nowrap;"><?= $row['email'] ?></td>
          <td style="white-space:nowrap;"><?= $row['cnic'] ?></td>
          <td style="white-space:nowrap;"><?= $row['expertise'] ?></td>

          <!-- Bio ellipsis + title full text -->
          <td style="max-width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"
              title="<?= htmlspecialchars($row['bio']) ?>">
            <?= substr($row['bio'],0,50) ?>...
          </td>

          <td style="white-space:nowrap;">
            <?php if($row['status'] == 'approved'): ?>
              <span class="badge bg-success">Approved</span>
            <?php elseif($row['status'] == 'rejected'): ?>
              <span class="badge bg-danger">Rejected</span>
            <?php else: ?>
              <span class="badge bg-warning text-dark">Pending</span>
            <?php endif; ?>
          </td>

          <td>
            <?php if(!empty($row['profile_pic'])): ?>
              <img src="../<?= $row['profile_pic'] ?>" alt="Profile"
                   style="max-width:50px;height:auto;border-radius:6px;">
            <?php endif; ?>
          </td>

          <td>
            <?php if(!empty($row['portfolio'])): ?>
              <a href="../<?= $row['portfolio'] ?>" target="_blank" class="btn btn-sm btn-info">View</a>
            <?php endif; ?>
          </td>

          <td style="white-space:nowrap;">
            <?php if($row['status'] == 'pending'): ?>
              <a href="designers.php?approve=<?= $row['designer_id'] ?>" class="btn btn-sm btn-success">Approve</a>
              <a href="designers.php?reject=<?= $row['designer_id'] ?>" class="btn btn-sm btn-warning">Reject</a>
            <?php endif; ?>
            <a href="designers.php?delete=<?= $row['designer_id'] ?>" class="btn btn-sm btn-danger"
               onclick="return confirm('Delete this designer?');">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>


<?php include("footer.php"); ?>





<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script> <!-- EmailJS Script -->







<?php 
include("../includes/db.php"); // DB connection include karo

if(isset($_GET['approve'])){
    $id = $_GET['approve'];

    // Designer ka data DB se nikaalo
    $result = $conn->query("SELECT email FROM designers WHERE designer_id = '$id'");

    if($result && $result->num_rows > 0){
        $designer = $result->fetch_assoc();
        $designer_email = $designer['email']; // DB se email
    } else {
        $designer_email = ""; // fallback
    }
}

if(isset($_GET['reject'])){
    $rid = $_GET['reject'];

    // Designer ka data DB se nikaalo
    $result = $conn->query("SELECT email FROM designers WHERE designer_id = '$rid'");

    if($result && $result->num_rows > 0){
        $designer = $result->fetch_assoc();
        $designer_email = $designer['email']; // DB se email

        // PHP se JS code print karo
        echo "<script>console.log('".$designer_email."');</script>";
    } else {
        $designer_email = ""; // fallback
    }
}

?>


<!-- EmailJS Initialization Script -->
<script type="text/javascript">
    (function(){
        emailjs.init("J579UpZEsXdTE-U_c");  // Initialize EmailJS with public key
    })();

    // Function to send email
    function sendMail() {
        let emailValue = "<?php echo isset($designer_email) ? $designer_email : ''; ?>";

        emailjs.send("service_xp925cn", "template_6tsn17k", {
            name: "sham",
            email: emailValue
        })
        .then(function(response) {
            console.log("✅ Success:", response);
            alert("Email sent successfully to " + emailValue);
        })
        .catch(function(error) {
            console.error("❌ Error:", error);
            alert("Failed to send email.");
        });
    }

    // Agar approve ki query string lagi ho to automatic call karo
    <?php if(isset($_GET['approve'])): ?>
        sendMail();
    <?php endif; ?>
</script>





<!-- EmailJS Initialization Script -->
<script type="text/javascript">
    (function(){
        emailjs.init("3QQlYZGY5sYqbiuWH");  // Initialize EmailJS with public key
    })();

    // Function to send email
    function sendMail() {
        let emailValue = "<?php echo isset($designer_email) ? $designer_email : ''; ?>";

        emailjs.send("service_3go3op8","template_94qfwkh", {
            name: "sham",
            email: emailValue
        })
        .then(function(response) {
            console.log("✅ Success:", response);
            alert("Email sent successfully to " + emailValue);
        })
        .catch(function(error) {
            console.error("❌ Error:", error);
            alert("Failed to send email.");
        });
    }

    // Agar approve ki query string lagi ho to automatic call karo
    <?php if(isset($_GET['reject'])): ?>
        sendMail();
    <?php endif; ?>
</script>











</body>
</html>
