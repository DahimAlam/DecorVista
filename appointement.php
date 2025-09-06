<?php
// appointment.php  (no CREATE TABLE here)
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/includes/db.php';

// CSRF
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // CSRF check
  if (!isset($_POST['csrf']) || $_POST['csrf'] !== $_SESSION['csrf_token']) {
    $errors[] = 'Security check failed. Please reload and try again.';
  }

  // Collect
  $name     = trim($_POST['name'] ?? '');
  $email    = trim($_POST['email'] ?? '');
  $phone    = trim($_POST['phone'] ?? '');
  $service  = trim($_POST['service'] ?? '');
  $designer = trim($_POST['designer'] ?? '');
  $date     = trim($_POST['date'] ?? '');
  $time     = trim($_POST['time'] ?? '');
  $notes    = trim($_POST['notes'] ?? '');
  $user_id  = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;

  // Validate
  if ($name === '')                               $errors[] = 'Name is required.';
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
  if ($phone === '')                              $errors[] = 'Phone is required.';
  if ($service === '')                            $errors[] = 'Service is required.';
  if ($date === '')                               $errors[] = 'Preferred date is required.';
  if ($time === '')                               $errors[] = 'Preferred time is required.';

  if ($designer !== '') {
    $notes = ($notes ? $notes . "\n" : '') . "Preferred Designer: " . $designer;
  }

  if (!$errors) {
    // Insert
    $sql = "INSERT INTO appointments
              (user_id, name, email, phone, designer_id, service, preferred_date, preferred_time, notes)
            VALUES (?, ?, ?, ?, NULL, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("isssssss", $user_id, $name, $email, $phone, $service, $date, $time, $notes);
      if ($stmt->execute()) {
        // Flash data for EmailJS after redirect (admin email + details)
        $_SESSION['flash_appt'] = [
          'to_email'       => 'ahtishamfromaptech@gmail.com', // change if needed
          'name'           => $name,
          'email'          => $email,
          'phone'          => $phone,
          'service'        => $service,
          'preferred_date' => $date,
          'preferred_time' => $time,
          'notes'          => $notes
        ];
        // rotate CSRF & redirect
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
        exit;
      } else {
        if ($conn->errno === 1062) {
          $errors[] = 'This time slot is already booked for the selected designer.';
        } else {
          $errors[] = 'Database error while saving appointment.';
        }
      }
      $stmt->close();
    } else {
      $errors[] = 'Failed to prepare statement.';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Book an Appointment – DecorVista</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/appointement.css">
</head>
<body>

<?php include("includes/header.php"); ?>

<?php if (!empty($errors)): ?>
  <div style="max-width:1100px;margin:16px auto;padding:12px 16px;border-radius:12px;background:#fff3f3;color:#a30000;border:1px solid #ffd6d6;font-family:Poppins,system-ui,sans-serif;">
    <?php foreach ($errors as $e): ?>
      <div>• <?= htmlspecialchars($e) ?></div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<!-- Hero -->
<section class="hero">
  <h1>Book an Appointment</h1>
  <p>Consult with our expert designers to bring your dream space to life.</p>
</section>

<!-- Main -->
<main class="container">
  <div class="grid">
    <!-- LEFT: Form card -->
    <section class="card">
      <div class="card-header">
        <span class="badge-soft">Step 1</span>
        <h2 class="title">Tell us about your consultation</h2>
      </div>
      <div class="card-body">
        <form action="" method="post" id="appointmentForm">
          <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
          <div class="row">
            <div class="col-6">
              <label for="name">Full Name <span class="req">*</span></label>
              <input type="text" id="name" name="name" placeholder="e.g., Talha Ahmed" required
                     value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
            </div>
            <div class="col-6">
              <label for="email">Email <span class="req">*</span></label>
              <input type="email" id="email" name="email" placeholder="you@example.com" required
                     value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>

            <div class="col-6">
              <label for="phone">Phone <span class="req">*</span></label>
              <input type="text" id="phone" name="phone" placeholder="+92 3XX XXXXXXX" required
                     value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
            </div>
            <div class="col-6">
              <label for="service">Service <span class="req">*</span></label>
              <select id="service" name="service" required>
                <option value="" disabled <?= empty($_POST['service']) ? 'selected' : '' ?>>Select a service</option>
                <?php
                  $services = [
                    'Living Room Design','Bedroom Makeover','Kitchen Planning',
                    'Office/Workspace','Full Home Consultation','Custom Package'
                  ];
                  foreach ($services as $svc) {
                    $sel = (($_POST['service'] ?? '') === $svc) ? 'selected' : '';
                    echo "<option $sel>".htmlspecialchars($svc)."</option>";
                  }
                ?>
              </select>
              <div class="slot-tip">We’ll tailor the session based on your selection.</div>
            </div>

            <div class="col-6">
              <label for="designer">Preferred Designer (optional)</label>
              <input type="text" id="designer" name="designer" placeholder="Type a designer name (optional)"
                     value="<?= htmlspecialchars($_POST['designer'] ?? '') ?>">
            </div>

            <div class="col-3">
              <label for="date">Preferred Date <span class="req">*</span></label>
              <input type="date" id="date" name="date" required
                     value="<?= htmlspecialchars($_POST['date'] ?? '') ?>">
              <div class="slot-tip">Open: Mon–Sat</div>
            </div>
            <div class="col-3">
              <label for="time">Preferred Time <span class="req">*</span></label>
              <input type="time" id="time" name="time" required
                     value="<?= htmlspecialchars($_POST['time'] ?? '') ?>">
              <div class="slot-tip">Working hours: 09:00–19:00</div>
            </div>

            <div class="col-12">
              <label for="notes">Notes (optional)</label>
              <textarea id="notes" name="notes" placeholder="Tell us about your space, style, budget, or any links/Pinterest boards…"><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>
            </div>
          </div>

          <div class="form-actions">
            <button class="btn" type="submit" name="sub">Request Appointment</button>
            <span class="muted">You’ll get a confirmation email once we schedule it.</span>
          </div>
        </form>
      </div>
    </section>

    <!-- RIGHT: Engaging stack -->
    <aside class="side-stack">
      <section class="card">
        <div class="card-body">
          <h3 class="title sidebar-title"><span class="spark">🌟</span> You’re in good hands</h3>
          <div class="mini-avatars">
            <img src="assets/images/designer-1.jpg" alt="Designer 1">
            <img src="assets/images/designer-2.jpg" alt="Designer 2">
            <img src="assets/images/designer-3.jpg" alt="Designer 3">
            <span class="more">+8</span>
          </div>
          <div class="stars">★★★★★ <span>4.9/5 average (120+ reviews)</span></div>
          <div class="trust-badges">
            <span class="badge-trust">✓ Verified Designers</span>
            <span class="badge-trust">🗓 Flexible Slots</span>
            <span class="badge-trust">💬 Free Pre-Call</span>
          </div>
        </div>
      </section>

      <section class="card">
        <div class="card-body">
          <h3 class="title sidebar-title"><span class="spark">✨</span> What happens next?</h3>
          <div class="timeline">
            <div class="step">
              <div class="dot"><span></span></div>
              <div class="step-head">
                <div class="step-badge">Step 1</div>
                <h4 class="step-title">Review</h4>
              </div>
              <p class="step-desc">We check availability for your chosen <strong>date & time</strong>.</p>
            </div>
            <div class="step">
              <div class="dot"><span></span></div>
              <div class="step-head">
                <div class="step-badge accent">Step 2</div>
                <h4 class="step-title">Match</h4>
              </div>
              <p class="step-desc">We pair you with the <strong>best-fit designer</strong> (or your pick).</p>
            </div>
            <div class="step">
              <div class="dot"><span></span></div>
              <div class="step-head">
                <div class="step-badge">Step 3</div>
                <h4 class="step-title">Confirm</h4>
              </div>
              <p class="step-desc">An <strong>email confirmation</strong> arrives with all the details.</p>
            </div>
          </div>
          <div class="chips">
            <span class="chip">⏱ 45–60 min</span>
            <span class="chip">🏠 Online / In-person</span>
            <span class="chip">🎯 Style-led advice</span>
          </div>
        </div>
      </section>

      <section class="card promise">
        <div class="card-body">
          <div class="promise-head">
            <span class="seal">✓</span>
            <div>
              <h4 class="promise-title">DecorVista Promise</h4>
              <p class="promise-sub">If the first session isn’t a fit, your next one’s <strong>on us</strong>.</p>
            </div>
          </div>
        </div>
      </section>

      <section class="card">
        <div class="card-body">
          <h3 class="title sidebar-title"><span class="spark">❓</span> Quick FAQ</h3>
          <details class="faq"><summary>Can I reschedule my appointment?</summary><p>Yes—free changes up to <strong>24 hours</strong> before your slot.</p></details>
          <details class="faq"><summary>Do you offer on-site visits?</summary><p>Yes, within Karachi. Otherwise we run full <strong>virtual sessions</strong>.</p></details>
          <details class="faq"><summary>What should I prepare?</summary><p>Room photos, rough dimensions, and any <strong>moodboard/Pinterest</strong> links help a lot.</p></details>
        </div>
      </section>

      <section class="card">
        <div class="card-body contact">
          <h3 class="title title-sm">Need help?</h3>
          <ul class="info-points">
            <li>📧 <a href="mailto:support@decorvista.com">support@decorvista.com</a></li>
            <li>📞 <a href="tel:+923000000000">+92 300 0000000</a></li>
            <li>🗓 Mon–Sat, 9:00–19:00 PKT</li>
          </ul>
        </div>
      </section>
    </aside>
  </div>
</main>

<?php
// === Fire EmailJS on success after redirect ===
if (isset($_GET['success']) && $_GET['success'] === '1') {
  $tplParams = $_SESSION['flash_appt'] ?? null;
  unset($_SESSION['flash_appt']); // so refresh won't re-send

  if ($tplParams) {
    $paramsJson = json_encode($tplParams, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    ?>
      <!-- EmailJS SDK -->
      <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
      <script>
        // Init EmailJS with your public key
        emailjs.init({ publicKey: "3QQlYZGY5sYqbiuWH" });

        // Send mail with server-provided template params
        emailjs.send(
          "service_3go3op8",
          "template_0f0ouot",
          <?= $paramsJson ?>
        )
        .then(function(resp){
          console.log("EmailJS OK:", resp);
          alert("Email sent successfully!");
          // Optional: remove ?success=1 from URL after alert
          try {
            const url = new URL(window.location);
            url.searchParams.delete('success');
            window.history.replaceState({}, '', url);
          } catch(e){}
        })
        .catch(function(err){
          console.error("EmailJS error:", err);
          alert("Email could not be sent.");
          try {
            const url = new URL(window.location);
            url.searchParams.delete('success');
            window.history.replaceState({}, '', url);
          } catch(e){}
        });
      </script>
    <?php
  }
}
?>

</body>
</html>
