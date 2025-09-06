<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/header.php';

$prefill_name  = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$prefill_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
?>

<section class="page-header bg-light">
  <div class="container">
    <nav aria-label="breadcrumb" class="mb-2">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Contact</li>
      </ol>
    </nav>
    <h1 class="page-title">Contact Us</h1>
  </div>
</section>

<section class="section-padding">
  <div class="container">
    <div id="contactAlert" class="alert d-none" role="alert"></div>

    <div class="row g-4">
      <div class="col-lg-5">
        <div class="card shadow-sm h-100">
          <div class="card-body p-4">
            <h3 class="section-heading">Get in touch</h3>
            <p class="text-muted mb-4">Questions about products, bookings, or orders? Send us a message—we typically reply in 24–48 hours.</p>

            <div class="d-flex align-items-start mb-3">
              <i class="bi bi-geo-alt fs-4 me-3"></i>
              <div>
                <strong>Address</strong>
                <div class="text-muted">DecorVista HQ, Karachi, Pakistan</div>
              </div>
            </div>

            <div class="d-flex align-items-start mb-3">
              <i class="bi bi-envelope fs-4 me-3"></i>
              <div>
                <strong>Email</strong>
                <div class="text-muted">support@decorvista.com</div>
              </div>
            </div>

            <div class="d-flex align-items-start mb-4">
              <i class="bi bi-telephone fs-4 me-3"></i>
              <div>
                <strong>Phone</strong>
                <div class="text-muted">+92 300 0000000</div>
              </div>
            </div>

            <h4 class="h6 text-uppercase mb-3">Follow us</h4>
            <div class="d-flex gap-2">
              <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-facebook"></i></a>
              <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-instagram"></i></a>
              <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-twitter-x"></i></a>
              <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-youtube"></i></a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="card shadow-sm">
          <div class="card-body p-4">
            <h3 class="section-heading">Send a message</h3>

            <form id="contactForm" class="needs-validation" novalidate>
              <input type="text" name="website" id="website" class="d-none" tabindex="-1" autocomplete="off">

              <div class="row g-3">
                <div class="col-md-6">
                  <label for="name" class="form-label">Full Name</label>
                  <input type="text" class="form-control rounded-3" id="name" name="name"
                         value="<?php echo htmlspecialchars($prefill_name); ?>" required minlength="2" maxlength="100">
                  <div class="invalid-feedback">Please enter your name.</div>
                </div>

                <div class="col-md-6">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control rounded-3" id="email" name="email"
                         value="<?php echo htmlspecialchars($prefill_email); ?>" required maxlength="120">
                  <div class="invalid-feedback">Please enter a valid email.</div>
                </div>

                <div class="col-12">
                  <label for="subject" class="form-label">Subject</label>
                  <input type="text" class="form-control rounded-3" id="subject" name="subject"
                         required minlength="3" maxlength="150">
                  <div class="invalid-feedback">Subject is required (min 3 characters).</div>
                </div>

                <div class="col-12">
                  <label for="message" class="form-label">Message</label>
                  <textarea class="form-control rounded-3" id="message" name="message" rows="6"
                            required minlength="10" maxlength="2000"></textarea>
                  <div class="invalid-feedback">Please enter at least 10 characters.</div>
                </div>

                <div class="col-12 d-flex gap-2">
                  <button type="submit" id="sendBtn" class="btn btn-primary rounded-3 px-4">
                    <span class="btn-text">Send Message</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                  </button>
                  <button type="reset" class="btn btn-outline-secondary rounded-3 px-4">Clear</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="card shadow-sm mt-4">
          <div class="ratio ratio-16x9">
            <iframe
              src="https://www.google.com/maps?q=Karachi%20Pakistan&output=embed"
              loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="rounded-bottom">
            </iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
<script>
  (() => {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
      form.addEventListener('submit', evt => {
        if (!form.checkValidity()) { evt.preventDefault(); evt.stopPropagation(); }
        form.classList.add('was-validated');
      }, false);
    });
  })();

  const EMAILJS_PUBLIC_KEY = 'vuBiJ6zCuiqqqeO6Z';
  const EMAILJS_SERVICE_ID = 'service_clez12p';
  const EMAILJS_TEMPLATE_ID = 'template_x7ovkcq';

  emailjs.init({ publicKey: EMAILJS_PUBLIC_KEY });

  const form    = document.getElementById('contactForm');
  const alertEl = document.getElementById('contactAlert');
  const sendBtn = document.getElementById('sendBtn');
  const btnText = sendBtn.querySelector('.btn-text');
  const spinner = sendBtn.querySelector('.spinner-border');

  function setSending(v){
    if(v){ sendBtn.disabled = true; spinner.classList.remove('d-none'); btnText.textContent = 'Sending...'; }
    else { sendBtn.disabled = false; spinner.classList.add('d-none'); btnText.textContent = 'Send Message'; }
  }
  function showAlert(type, msg){
    alertEl.className = 'alert alert-' + type;
    alertEl.textContent = msg;
    alertEl.classList.remove('d-none');
    setTimeout(() => alertEl.classList.add('d-none'), 8000);
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    if (!form.checkValidity()) return;

    if (document.getElementById('website').value.trim() !== '') {
      showAlert('success', 'Thanks! Your message has been sent.');
      form.reset(); form.classList.remove('was-validated'); return;
    }

    const params = {
      from_name: document.getElementById('name').value.trim(),
      reply_to:  document.getElementById('email').value.trim(),
      subject:   document.getElementById('subject').value.trim(),
      message:   document.getElementById('message').value.trim(),
      year:      new Date().getFullYear(),
      title:     document.getElementById('subject').value.trim() // if your template still uses {{title}}
    };

    try {
      setSending(true);
      const res = await emailjs.send(EMAILJS_SERVICE_ID, EMAILJS_TEMPLATE_ID, params);
      // Success
      showAlert('success', `Message sent (status ${res.status}). Thanks!`);
      form.reset(); form.classList.remove('was-validated');
    } catch (err) {
      console.error('EmailJS error object:', err);

      const status = err?.status || err?.code || 'unknown';
      const text   = err?.text || err?.message || JSON.stringify(err);

      let friendly = 'Unable to send right now.';
      if (status === 401 || /user id/i.test(text)) friendly = 'EmailJS Public Key missing/invalid.';
      if (status === 404 || /service/i.test(text)) friendly = 'EmailJS Service ID galat hai.';
      if (status === 422 || /template/i.test(text)) friendly = 'Template ID/variables mismatch.';
      if (status === 412 || /insufficient|scope/i.test(text)) friendly = 'Gmail API: insufficient authentication scopes.';
      
      showAlert('danger', `${friendly} (status ${status}) — ${text}`);
    } finally {
      setSending(false);
    }
  });
</script>
