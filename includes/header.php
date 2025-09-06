<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>DecorVista</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Poppins&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container" style="padding-top:0px ; padding-bottom:0px">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="assets/images/logo.jpg" alt="DecorVista" height="40" class="me-2">
      <span class="fw-bold text-primary heading-primary">DecorVista</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="gallery.php">Gallery</a></li>
        <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>

        <?php if(isset($_SESSION['role']) && $_SESSION['role']=='designer'): ?>
          <li class="nav-item"><a class="nav-link" href="designer/dashboard.php">Dashboard</a></li>
        <?php elseif(isset($_SESSION['role']) && $_SESSION['role']=='admin'): ?>
          <li class="nav-item"><a class="nav-link" href="admin/dashboard.php">Admin Panel</a></li>
        <?php elseif(isset($_SESSION['role']) && $_SESSION['role']=='user'): ?>
          <li class="nav-item"><a class="nav-link" href="user/dashboard.php">My Account</a></li>
        <?php endif; ?>

        <?php if(isset($_SESSION['user_id'])): ?>
          <li class="nav-item ms-lg-3"><a class="btn btn-danger rounded-pill px-3" href="logout.php">Logout</a></li>
        <?php else: ?>
          <li class="nav-item ms-lg-2"><a class="btn btn-theme rounded-pill px-3" href="login.php">Login</a></li>
          <li class="nav-item ms-lg-2"><a class="btn btn-theme rounded-pill px-3" href="register.php">Register</a></li>
          <li class="nav-item ms-lg-2"><a class="btn btn-theme rounded-pill px-3" href="designer_register.php">Become a Designer</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container my-5">
