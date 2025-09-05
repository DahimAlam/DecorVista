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
    // $conn->query("UPDATE designers SET status='approved' WHERE designer_id='$id'");

    
    
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
    // $conn->query("UPDATE designers SET status='rejected' WHERE designer_id='$id'");
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

<div class="card shadow-sm p-4">
  <h5 class="fw-bold mb-3">📋 Designers List</h5>
  <table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>CNIC</th>
        <th>Expertise</th>
        <th>Bio</th>
        <th>Status</th>
        <th>Profile Pic</th>
        <th>Portfolio</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $designers->fetch_assoc()): ?>
      <tr>
        <td><?= $row['designer_id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['cnic'] ?></td>
        <td><?= $row['expertise'] ?></td>
        <td><?= substr($row['bio'],0,50) ?>...</td>
        <td>
          <?php if($row['status'] == 'approved'): ?>
            <span class="badge bg-success">Approved</span>
          <?php elseif($row['status'] == 'rejected'): ?>
            <span class="badge bg-danger">Rejected</span>
          <?php else: ?>
            <span class="badge bg-warning text-dark">Pending</span>
          <?php endif; ?>
        </td>
        <td><img src="../uploads/designers/<?= $row['profile_pic'] ?>" width="50"></td>
        <td><a href="../uploads/designers/<?= $row['portfolio'] ?>" target="_blank" class="btn btn-sm btn-info">View</a></td>
        <td>
          <?php if($row['status'] == 'pending'): ?>
            <a href="designers.php?approve=<?= $row['designer_id'] ?>" class="btn btn-sm btn-success">Approve</a>
            <a href="designers.php?reject=<?= $row['designer_id'] ?>" class="btn btn-sm btn-warning">Reject</a>
          <?php endif; ?>
          <a href="designers.php?delete=<?= $row['designer_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this designer?');">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
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

        emailjs.send("service_7c6frxe", "template_94qfwkh", {
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
