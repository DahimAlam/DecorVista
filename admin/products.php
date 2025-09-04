<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include("../includes/db.php");
include("header.php");
include("sidebar.php");

// Handle Add Product
if(isset($_POST['add_product'])){
    $name = $_POST['productname'];
    $price = $_POST['price'];
    $desc = $_POST['description'];
    $cat = $_POST['category_id'];
    $featured = isset($_POST['featured']) ? 1 : 0;

    // Image Upload
    $img_name = $_FILES['image']['name'];
    $img_tmp = $_FILES['image']['tmp_name'];
    $target = "../uploads/products/" . $img_name;
    move_uploaded_file($img_tmp, $target);

    $sql = "INSERT INTO products (productname, price, description, image, category_id, featured, created_at) 
            VALUES ('$name','$price','$desc','$img_name','$cat','$featured',NOW())";
    $conn->query($sql);
    echo "<script>alert('Product Added Successfully'); window.location='products.php';</script>";
}

// Handle Delete Product
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->query("DELETE FROM products WHERE product_id='$id'");
    echo "<script>alert('Product Deleted'); window.location='products.php';</script>";
}

// Fetch products
$products = $conn->query("SELECT p.*, c.categoryname FROM products p 
                          LEFT JOIN categories c ON p.category_id=c.category_id ORDER BY p.product_id DESC");

// Fetch categories for dropdown
$categories = $conn->query("SELECT * FROM categories");
?>

<h2 class="mb-4 fw-bold" style="font-family:'Montserrat', sans-serif;">🛒 Manage Products</h2>

<!-- Add Product Form -->
<div class="card shadow-sm p-4 mb-4">
  <h5 class="fw-bold mb-3">➕ Add New Product</h5>
  <form method="POST" enctype="multipart/form-data">
    <div class="row g-3">
      <div class="col-md-6">
        <label>Product Name</label>
        <input type="text" name="productname" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label>Price</label>
        <input type="number" step="0.01" name="price" class="form-control" required>
      </div>
      <div class="col-md-12">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="3" required></textarea>
      </div>
      <div class="col-md-6">
        <label>Category</label>
        <select name="category_id" class="form-control" required>
          <option value="">-- Select Category --</option>
          <?php while($cat = $categories->fetch_assoc()): ?>
            <option value="<?= $cat['category_id'] ?>"><?= $cat['categoryname'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-6">
        <label>Product Image</label>
        <input type="file" name="image" class="form-control" required>
      </div>
      <div class="col-md-6 mt-3">
        <input type="checkbox" name="featured" value="1"> Featured Product
      </div>
      <div class="col-md-12 mt-3">
        <button type="submit" name="add_product" class="btn btn-success">Add Product</button>
      </div>
    </div>
  </form>
</div>

<!-- Products List -->
<div class="card shadow-sm p-4">
  <h5 class="fw-bold mb-3">📋 Product List</h5>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Category</th>
        <th>Image</th>
        <th>Featured</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $products->fetch_assoc()): ?>
      <tr>
        <td><?= $row['product_id'] ?></td>
        <td><?= $row['productname'] ?></td>
        <td>$<?= number_format($row['price'],2) ?></td>
        <td><?= $row['categoryname'] ?></td>
        <td><img src="../uploads/products/<?= $row['image'] ?>" width="60"></td>
        <td><?= $row['featured'] ? "Yes" : "No" ?></td>
        <td>
          <a href="products_edit.php?id=<?= $row['product_id'] ?>" class="btn btn-sm btn-primary">Edit</a>
          <a href="products.php?delete=<?= $row['product_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?');">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include("footer.php"); ?>
