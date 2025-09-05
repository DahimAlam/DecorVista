<?php
session_start();
include("includes/db.php");

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Getting form data
    $name       = trim($_POST['name']);
    $email      = trim($_POST['email']);
    $password   = trim($_POST['password']);
    $contact    = trim($_POST['contact']);
    $cnic       = trim($_POST['cnic_number']);
    $address    = trim($_POST['address']);
    $experience = intval($_POST['experience']);
    $expertise  = $_POST['expertise'];
    $days       = isset($_POST['days']) ? implode(",", $_POST['days']) : "";
    $time       = $_POST['available_time'];
    $portfolio  = trim($_POST['portfolio']);
    $bio        = trim($_POST['bio']);

    // Validate CNIC format
    if (!preg_match("/^[0-9]{5}-[0-9]{7}-[0-9]{1}$/", $cnic)) {
        $msg = "Invalid CNIC format. Please enter as 12345-1234567-1";
    } else {
        // Handle file uploads for CNIC and Profile images
        $cnic_image    = "uploads/designers/cnic/" . time() . "_" . basename($_FILES["cnic_image"]["name"]);
        $profile_image = "uploads/designers/profile/" . time() . "_" . basename($_FILES["profile_image"]["name"]);

        move_uploaded_file($_FILES["cnic_image"]["tmp_name"], $cnic_image);
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $profile_image);

        // Hash the password before storing
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into the database
        $stmt = $conn->prepare("INSERT INTO designers 
        (name, email, contact, cnic, profile_pic, cnic_pic, address, experience_years, expertise, portfolio_link, bio, available_days, available_time, approved, created_at, password) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,1,NOW(),?)");

        $stmt->bind_param(
            "sssssssissssss",
            $name,
            $email,
            $contact,
            $cnic,
            $profile_image,
            $cnic_image,
            $address,
            $experience,
            $expertise,
            $portfolio,
            $bio,
            $days,
            $time,
            $hashed_password // Bind the hashed password
        );

        if ($stmt->execute()) {
            $msg = "Designer account created successfully! You can login now.";
        } else {
            $msg = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Designer Register - DecorVista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script> <!-- EmailJS Script -->
</head>
<body>
    <?php include("includes/header.php"); ?>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-custom shadow-lg border-0">
                    <div class="card-body">
                        <h3 class="text-center mb-4 heading-primary">Become an Interior Designer</h3>
                        <?php if($msg): ?><div class="alert alert-info text-center"><?php echo $msg; ?></div><?php endif; ?>

                        <form method="POST" enctype="multipart/form-data" id="registrationForm">

                            <!-- Full Name -->
                            <input type="text" name="name" class="form-control mb-3 input-custom"
                                   pattern="^[A-Za-z ]{3,}$"
                                   title="Name must be at least 3 letters and only alphabets"
                                   placeholder="Full Name" required>

                            <!-- Email -->
                            <input type="email" name="email" class="form-control mb-3 input-custom"
                                   pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                   title="Enter a valid email address"
                                   placeholder="Email" id="email" required>

                            <!-- Password -->
                            <input type="password" name="password" id="password" class="form-control mb-3 input-custom"
                                   pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$"
                                   title="Password must be 8+ chars, include 1 uppercase, 1 lowercase, 1 number & 1 special character"
                                   placeholder="Password" required>

                            <!-- Contact -->
                            <input type="text" name="contact" class="form-control mb-3 input-custom"
                                   pattern="^[0-9]{10,15}$"
                                   title="Enter valid contact number (10-15 digits)"
                                   placeholder="Contact Number" required>

                            <!-- CNIC -->
                            <input type="text" name="cnic_number" class="form-control mb-3 input-custom"
                                   pattern="[0-9]{5}-[0-9]{7}-[0-9]"
                                   title="CNIC format: 12345-1234567-1"
                                   placeholder="12345-1234567-1" required>
                            <label class="form-label">Upload CNIC Picture</label>
                            <input type="file" name="cnic_image" class="form-control mb-3" accept="image/*" required>

                            <!-- Profile -->
                            <label class="form-label">Upload Profile Picture</label>
                            <input type="file" name="profile_image" class="form-control mb-3" accept="image/*" required>

                            <!-- Address -->
                            <textarea name="address" class="form-control mb-3 input-custom" placeholder="Address" required></textarea>

                            <!-- Experience + Expertise -->
                            <input type="number" name="experience" class="form-control mb-3 input-custom"
                                   placeholder="Years of Experience" min="0" required>
                            <select name="expertise" class="form-select mb-3 input-custom" required>
                                <option value="">Select Expertise</option>
                                <option>Living Room</option>
                                <option>Kitchen</option>
                                <option>Office</option>
                                <option>Bedroom</option>
                                <option>Outdoor Spaces</option>
                            </select>

                            <!-- Availability -->
                            <label class="form-label">Available Days</label><br>
                            <div class="mb-3">
                                <input type="checkbox" name="days[]" value="Mon"> Mon
                                <input type="checkbox" name="days[]" value="Tue"> Tue
                                <input type="checkbox" name="days[]" value="Wed"> Wed
                                <input type="checkbox" name="days[]" value="Thu"> Thu
                                <input type="checkbox" name="days[]" value="Fri"> Fri
                                <input type="checkbox" name="days[]" value="Sat"> Sat
                                <input type="checkbox" name="days[]" value="Sun"> Sun
                            </div>

                            <label class="form-label">Available Timings</label>
                            <select name="available_time" class="form-select mb-3 input-custom" required>
                                <option value="">Select Time</option>
                                <option value="Morning">Morning (9am - 12pm)</option>
                                <option value="Afternoon">Afternoon (12pm - 4pm)</option>
                                <option value="Evening">Evening (4pm - 8pm)</option>
                                <option value="Night">Night (8pm - 11pm)</option>
                            </select>

                            <!-- Portfolio -->
                            <input type="url" name="portfolio" class="form-control mb-3 input-custom" placeholder="Portfolio Link (optional)">

                            <!-- Bio -->
                            <textarea name="bio" class="form-control mb-3 input-custom" placeholder="Short Bio"></textarea>

                            <button type="submit" class="btn btn-theme w-100">Register as Designer</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("includes/footer.php"); ?>
    <!-- EmailJS Initialization Script -->
    <script type="text/javascript">
        (function(){
            emailjs.init("J579UpZEsXdTE-U_c");  // Initialize EmailJS with public key
        })();
    </script>

    <!-- Send Email Function -->
    <script type="text/javascript">
        function sendMail() {
            emailjs.send("service_xp925cn", "template_qu9znpm", {
                name: document.querySelector("[name='name']").value,
                email: document.querySelector("[name='email']").value
            })
            .then(function(response) {
                console.log("Success:", response);
                alert("Email sent successfully!");
            })
            .catch(function(error) {
                console.error("Error:", error);
                alert("Failed to send email.");
            });
        }

        // Form submission event listener
        document.querySelector("#registrationForm").addEventListener("submit", function(event) {
        //  location.reload();  // This will reload the page
            sendMail();  // Call sendMail function to send the email

        });
    </script>

</body>
</html>
