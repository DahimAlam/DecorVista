<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include("../includes/db.php");
include("header.php");
include("sidebar.php");

$total_products = $conn->query("SELECT COUNT(*) AS c FROM products")->fetch_assoc()['c'];
$total_users = $conn->query("SELECT COUNT(*) AS c FROM users")->fetch_assoc()['c'];
$total_designers = $conn->query("SELECT COUNT(*) AS c FROM designers")->fetch_assoc()['c'];
$total_orders = $conn->query("SELECT COUNT(*) AS c FROM orders")->fetch_assoc()['c'];

$orders_data = [];
$result = $conn->query("SELECT MONTH(created_at) as m, COUNT(*) as total FROM orders GROUP BY MONTH(created_at)");
for($i=1;$i<=12;$i++){ $orders_data[$i] = 0; }
while($row = $result->fetch_assoc()){
    $orders_data[(int)$row['m']] = (int)$row['total'];
}
$orders_json = json_encode(array_values($orders_data));

$cat_labels = [];
$cat_data = [];
$res = $conn->query("SELECT c.categoryname, COUNT(p.product_id) as total 
                    FROM categories c 
                    LEFT JOIN products p ON p.category_id = c.category_id 
                    GROUP BY c.categoryname");
while($row = $res->fetch_assoc()){
    $cat_labels[] = $row['categoryname'];
    $cat_data[] = $row['total'];
}
$cat_labels_json = json_encode($cat_labels);
$cat_data_json = json_encode($cat_data);
?>

<h2 class="mb-4 fw-bold" style="font-family:'Montserrat', sans-serif;">📊 Dashboard Overview</h2>

<div class="row g-4 mb-4">
  <div class="col-md-3"><div class="dashboard-card card-products"><h4><?= $total_products ?></h4><p>Products</p></div></div>
  <div class="col-md-3"><div class="dashboard-card card-users"><h4><?= $total_users ?></h4><p>Users</p></div></div>
  <div class="col-md-3"><div class="dashboard-card card-designers"><h4><?= $total_designers ?></h4><p>Designers</p></div></div>
  <div class="col-md-3"><div class="dashboard-card card-orders"><h4><?= $total_orders ?></h4><p>Orders</p></div></div>
</div>

<div class="row g-4">
  <div class="col-lg-6">
    <div class="card shadow-sm p-3">
      <h5 class="fw-bold mb-3">📈 Monthly Orders</h5>
      <canvas id="ordersChart" height="200"></canvas>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card shadow-sm p-3">
      <h5 class="fw-bold mb-3">🛒 Products by Category</h5>
      <canvas id="categoriesChart" height="200"></canvas>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('ordersChart'), {
  type: 'line',
  data: {
    labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
    datasets: [{
      label: 'Orders',
      data: <?= $orders_json ?>,
      borderColor: '#6C63FF',
      backgroundColor: 'rgba(108,99,255,0.2)',
      fill: true,
      tension: 0.3
    }]
  }
});
new Chart(document.getElementById('categoriesChart'), {
  type: 'doughnut',
  data: {
    labels: <?= $cat_labels_json ?>,
    datasets: [{ data: <?= $cat_data_json ?>, backgroundColor: ['#6C63FF','#7A5CFF','#FF6584','#43e97b','#38f9d7','#4cafef','#ffa726'] }]
  }
});
</script>

<?php include("footer.php"); ?>
