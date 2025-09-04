<?php
include('includes/header.php');
include('includes/db.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DecorVista - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- Hero Section -->
<section class="hero d-flex align-items-center justify-content-center text-center text-white" style="height:100vh; background:linear-gradient(rgba(108,99,255,.6),rgba(122,92,255,.6)), url('assets/images/hero-bg.jpg') center/cover no-repeat;">
  <div data-aos="fade-up">
    <h1 class="display-2 fw-bold">Design Your Dream Home</h1>
    <p class="lead mb-4">Inspiration, Products & Top Designers — All in One Place</p>
    <a href="#gallery" class="btn btn-gradient btn-lg m-2">Explore Gallery</a>
    <a href="#designers" class="btn btn-light btn-lg m-2">Find Designers</a>
  </div>
</section>

<!-- Inspiration Gallery -->
<section id="gallery" class="home-section bg-light">
  <div class="container">
    <h2 class="text-center mb-5" data-aos="fade-up">Inspiration Gallery</h2>
    <div class="row g-4">
      <?php
      $gallery = mysqli_query($conn,"SELECT * FROM gallery LIMIT 6");
      while($g = mysqli_fetch_assoc($gallery)){ ?>
        <div class="col-md-4" data-aos="zoom-in">
          <div class="card shadow-sm card-hover">
            <img src="uploads/gallery/<?php echo $g['image']; ?>" class="card-img-top" alt="<?php echo $g['title']; ?>">
            <div class="card-body">
              <h5 class="card-title"><?php echo $g['title']; ?></h5>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="text-center mt-4">
      <a href="gallery.php" class="btn btn-gradient">View Full Gallery</a>
    </div>
  </div>
</section>

<!-- Featured Products -->
<section id="products" class="section-padding">
  <div class="container">
    <h2 class="text-center mb-5" data-aos="fade-up">Featured Products</h2>
    <div class="row g-4">
      <?php
      $products = mysqli_query($conn,"SELECT * FROM products WHERE featured=1 LIMIT 8");
      while($p = mysqli_fetch_assoc($products)){ ?>
        <div class="col-md-3" data-aos="flip-left">
          <div class="card shadow-sm card-hover h-100">
            <img src="uploads/products/<?php echo $p['image']; ?>" class="card-img-top" alt="<?php echo $p['productname']; ?>">
            <div class="card-body">
              <h5 class="card-title"><?php echo $p['productname']; ?></h5>
              <p class="text-muted">$<?php echo $p['price']; ?></p>
              <a href="product_details.php?id=<?php echo $p['product_id']; ?>" class="btn btn-gradient w-100">View Details</a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section>

<!-- Top Interior Designers -->
<section id="designers" class="section-padding bg-light">
  <div class="container">
    <h2 class="text-center mb-5" data-aos="fade-up">Top Interior Designers</h2>
    <div class="row g-4">
      <?php
      $designers = mysqli_query($conn,"SELECT * FROM designers WHERE approved=1 LIMIT 6");
      while($d = mysqli_fetch_assoc($designers)){ ?>
        <div class="col-md-4" data-aos="fade-up">
          <div class="card shadow-sm card-hover h-100">
            <img src="uploads/designers/<?php echo $d['profile_pic']; ?>" class="card-img-top" alt="<?php echo $d['name']; ?>">
            <div class="card-body">
              <h5 class="card-title"><?php echo $d['name']; ?></h5>
              <p class="mb-1"><strong>Expertise:</strong> <?php echo $d['expertise']; ?></p>
              <p class="text-muted small">Experience: <?php echo $d['experience_years']; ?> Years</p>
              <a href="book_consultation.php?designer=<?php echo $d['designer_id']; ?>" class="btn btn-gradient w-100">Book Appointment</a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section>

<!-- Why Choose Us -->
<section class="section-padding text-center">
  <div class="container">
    <h2 class="mb-5" data-aos="fade-up">Why Choose DecorVista?</h2>
    <div class="row g-4">
      <div class="col-md-3" data-aos="zoom-in">
        <i class="bi bi-shield-check display-4 text-primary"></i>
        <h5 class="mt-3">Verified Designers</h5>
        <p>Work only with trusted, vetted professionals.</p>
      </div>
      <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
        <i class="bi bi-bag-check display-4 text-primary"></i>
        <h5 class="mt-3">Curated Products</h5>
        <p>Exclusive products from top brands & artisans.</p>
      </div>
      <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
        <i class="bi bi-calendar-check display-4 text-primary"></i>
        <h5 class="mt-3">Easy Consultations</h5>
        <p>Book appointments that suit your schedule.</p>
      </div>
      <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
        <i class="bi bi-stars display-4 text-primary"></i>
        <h5 class="mt-3">Trusted Reviews</h5>
        <p>Real reviews from verified homeowners.</p>
      </div>
    </div>
  </div>
</section>

<!-- Stats Section -->
<section class="section-padding bg-dark text-white text-center">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-3" data-aos="fade-up">
        <h2 class="display-4 counter" data-target="120">0</h2>
        <p>Approved Designers</p>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
        <h2 class="display-4 counter" data-target="350">0</h2>
        <p>Products Listed</p>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
        <h2 class="display-4 counter" data-target="500">0</h2>
        <p>Consultations Booked</p>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
        <h2 class="display-4 counter" data-target="980">0</h2>
        <p>Happy Clients</p>
      </div>
    </div>
  </div>
</section>

<!-- How It Works -->
<section class="section-padding">
  <div class="container">
    <h2 class="text-center mb-5" data-aos="fade-up">How It Works</h2>
    <div class="row g-4 text-center">
      <div class="col-md-3" data-aos="fade-right">
        <i class="bi bi-search display-4 text-primary"></i>
        <h5 class="mt-3">Browse</h5>
        <p>Explore our galleries & products.</p>
      </div>
      <div class="col-md-3" data-aos="fade-up">
        <i class="bi bi-heart display-4 text-primary"></i>
        <h5 class="mt-3">Select</h5>
        <p>Save favorites & shortlist designs.</p>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
        <i class="bi bi-calendar-event display-4 text-primary"></i>
        <h5 class="mt-3">Book</h5>
        <p>Schedule a consultation with designers.</p>
      </div>
      <div class="col-md-3" data-aos="fade-left">
        <i class="bi bi-chat-square-heart display-4 text-primary"></i>
        <h5 class="mt-3">Review</h5>
        <p>Share your experience with the community.</p>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials -->
<section id="testimonials" class="section-padding bg-light">
  <div class="container">
    <h2 class="text-center mb-5" data-aos="fade-up">What Our Clients Say</h2>
    <div id="reviewCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <?php
        $reviews = mysqli_query($conn,"SELECT r.comment, r.rating, u.username 
                                        FROM reviews r 
                                        JOIN users u ON r.user_id=u.user_id 
                                        ORDER BY r.review_id DESC LIMIT 6");
        $active = true;
        while($rev = mysqli_fetch_assoc($reviews)){ ?>
          <div class="carousel-item <?php echo $active ? 'active':''; ?>">
            <div class="card shadow-sm p-4 mx-auto" style="max-width:700px;">
              <p class="mb-3">"<?php echo $rev['comment']; ?>"</p>
              <h6>- <?php echo $rev['username']; ?> (<?php echo $rev['rating']; ?> ★)</h6>
            </div>
          </div>
        <?php $active=false; } ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#reviewCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#reviewCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
  </div>
</section>

<!-- Blog Preview -->
<section id="blog" class="section-padding">
  <div class="container">
    <h2 class="text-center mb-5" data-aos="fade-up">Latest Articles & Trends</h2>
    <div class="row g-4">
      <?php
      $blogs = mysqli_query($conn,"SELECT * FROM blog ORDER BY blog_id DESC LIMIT 3");
      while($b = mysqli_fetch_assoc($blogs)){ ?>
        <div class="col-md-4" data-aos="fade-up">
          <div class="card shadow-sm card-hover h-100">
            <img src="uploads/blog/<?php echo $b['image']; ?>" class="card-img-top" alt="<?php echo $b['title']; ?>">
            <div class="card-body">
              <h5 class="card-title"><?php echo $b['title']; ?></h5>
              <p class="text-muted small"><?php echo substr($b['content'],0,100); ?>...</p>
              <a href="blog_details.php?id=<?php echo $b['blog_id']; ?>" class="btn btn-gradient">Read More</a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section>

<!-- About Us -->
<section id="about" class="section-padding bg-light">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6" data-aos="fade-right">
        <img src="assets/images/about.jpg" class="img-fluid rounded shadow" alt="About DecorVista">
      </div>
      <div class="col-md-6" data-aos="fade-left">
        <h2>About DecorVista</h2>
        <p>DecorVista is your one-stop solution for interior design. From discovering inspirational galleries to buying curated products and booking consultations with top designers, we provide a seamless experience to transform your living spaces.</p>
        <p>Our mission is to bring professional design services within reach of every homeowner, making interior design accessible, enjoyable, and personalized.</p>
        <a href="about.php" class="btn btn-gradient">Learn More</a>
      </div>
    </div>
  </div>
</section>

<!-- Contact Us -->
<section id="contact" class="section-padding">
  <div class="container">
    <h2 class="text-center mb-5" data-aos="fade-up">Get in Touch</h2>
    <div class="row">
      <div class="col-md-6" data-aos="fade-right">
        <form action="save_contact.php" method="POST">
          <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
          </div>
          <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
          </div>
          <div class="mb-3">
            <textarea name="message" class="form-control" rows="5" placeholder="Your Message" required></textarea>
          </div>
          <button type="submit" class="btn btn-gradient">Send Message</button>
        </form>
      </div>
      <div class="col-md-6" data-aos="fade-left">
        <iframe src="https://maps.google.com/maps?q=Karachi&t=&z=13&ie=UTF8&iwloc=&output=embed" 
          width="100%" height="350" style="border:0;" allowfullscreen loading="lazy"></iframe>
      </div>
    </div>
  </div>
</section>

<!-- Newsletter Signup -->
<section class="section-padding bg-dark text-white text-center">
  <div class="container">
    <h2 class="mb-4" data-aos="fade-up">Subscribe to Our Newsletter</h2>
    <form action="save_newsletter.php" method="POST" class="row justify-content-center" data-aos="fade-up">
      <div class="col-md-6">
        <div class="input-group">
          <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
          <button class="btn btn-gradient">Subscribe</button>
        </div>
      </div>
    </form>
  </div>
</section>

<!-- CTA Strip -->
<section class="py-5 text-center text-white" style="background:linear-gradient(45deg,#6C63FF,#7A5CFF);">
  <div class="container" data-aos="zoom-in">
    <h2 class="mb-3">Ready to Transform Your Home?</h2>
    <a href="register.php" class="btn btn-light btn-lg">Get Started</a>
  </div>
</section>

<?php include('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({duration:1000, once:true});
  // Counter animation
  const counters=document.querySelectorAll('.counter');
  counters.forEach(counter=>{
    counter.innerText='0';
    const update=()=>{
      const target=+counter.getAttribute('data-target');
      const c=+counter.innerText;
      const inc=target/200;
      if(c<target){counter.innerText=`${Math.ceil(c+inc)}`;setTimeout(update,10);}
      else{counter.innerText=target;}
    };
    update();
  });
</script>
</body>
</html>
