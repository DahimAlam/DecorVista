<?php
// Admin Header Include
if(!isset($_SESSION)) { session_start(); }
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel - DecorVista</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/admin.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(90deg,#6C63FF,#7A5CFF);">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" style="font-family: 'Montserrat', sans-serif;" href="index.php">DecorVista Admin</a>
      <div class="d-flex">
        <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
      </div>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row">
