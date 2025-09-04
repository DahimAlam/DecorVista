<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include("../includes/db.php");
include("header.php");
include("sidebar.php");

if(!isset($_GET['id'])){
    echo "<script>alert('No product selected'); window.location='products.php';</script>";
    exit();
}

$id = $_GET['id'];

// Fetch product
$product = $conn->query("SELECT * FROM products WHERE product_id='$id'")->fetch_assoc();
if(!$product){
    echo "<script>alert('Product not found'); window.location='products.php';</script>";
    exit();
}

// Fetch categories
$categories = $conn->query("SELECT * FROM categories");

// Handle Update
if(isset($_POST['update_product'])){
    $name = $_POST['productname'];
    $price = $_POST['price'];
    $desc = $_POST['description'];
    $cat = $_POST['category_id'];
    $featured = isset($_POST['featured']) ? 1 : 0;

    $img_name = $product['image']; // default old image
    if(!empty($_FILES['image']['name'])){
        $img_name = $_FILES['image']['name'];
        $img_tmp = $_FILES['image']['tmp_name'];
        $target = "../uploads/products/" . $img_name;
        move_uploaded_file($img_tmp, $target);
    }

    $sql = "UPDATE products 
            SET productname='$name', price='$price', description='$desc', 
                category_id='$cat', image='$img_name', featured='$featured' 
            WHERE product_id='$id'";

    if($conn->query($sql)){
        echo "<script>alert('Product Updated Successfully'); window.location='products.php';</script>";
    } else {
        echo "<script>alert('Error updating product');</script>";
    }
}
?>

<h2 class="mb-4 fw-bold" style="font-family:'Montserrat', sans-serif;">✏️ Edit Product</h2>

<div class="card shadow-sm p-4 mb-4">
  <form method="POST" enctype="multipart/form-data">
    <div class="row g-3">
      <div class="col-md-6">
        <label>Product Name</label>
        <input type="text" name="productname" class="form-control" value="<?= $product['productname'] ?>" required>
      </div>
      <div class="col-md-6">
        <label>Price</label>
        <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['price'] ?>" required>
      </div>
      <div class="col-md-12">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="3" required><?= $product['description'] ?></textarea>
      </div>
      <div class="col-md-6">
        <label>Category</label>
        <select name="category_id" class="form-control" required>
          <?php while($cat = $categories->fetch_assoc()): ?>
            <option value="<?= $cat['category_id'] ?>" <?= ($product['category_id'] == $cat['category_id']) ? 'selected' : '' ?>>
              <?= $cat['categoryname'] ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-6">
        <label>Product Image</label><br>
        <img src="../uploads/products/<?= $product['image'] ?>" width="80" class="mb-2"><br>
        <input type="file" name="image" class="form-control">
      </div>
      <div class="col-md-6 mt-3">
        <input type="checkbox" name="featured" value="1" <?= $product['featured'] ? 'checked' : '' ?>> Featured Product
      </div>
      <div class="col-md-12 mt-3">
        <button type="submit" name="update_product" class="btn btn-primary">Update Product</button>
        <a href="products.php" class="btn btn-secondary">Back</a>
      </div>
    </div>
  </form>
</div>

<?php include("footer.php"); ?>
