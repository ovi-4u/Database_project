<?php
session_start();
include "includes/header.php";
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

/* ====== DATA ====== */

// total products
$productCount = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];

// cart items
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;

// user name
$user = $_SESSION['user'];
?>

<?php include "navbar.php"; ?>

<div class="dashboard-container">

  <div class="dashboard-header">
    <div class="dashboard-title">Welcome, <?php echo $user; ?> 👋</div>
    <div class="dashboard-sub">Here’s what’s happening in your store</div>
  </div>

  <div class="stats-grid">

    <div class="stat-card">
      <div class="stat-title">Products</div>
      <div class="stat-value"><?php echo $productCount; ?></div>
    </div>

    <div class="stat-card">
      <div class="stat-title">Items in Cart</div>
      <div class="stat-value"><?php echo $cartCount; ?></div>
    </div>

    <div class="stat-card">
      <div class="stat-title">User</div>
      <div class="stat-value"><?php echo $user; ?></div>
    </div>

  </div>

  <div class="dashboard-actions">

    <a href="products.php">
      <button class="dashboard-btn">Browse Products</button>
    </a>

    <a href="view_cart.php">
      <button class="dashboard-btn">View Cart</button>
    </a>

    <a href="profile.php">
      <button class="dashboard-btn">Profile</button>
    </a>

  </div>

</div>

<?php include "includes/footer.php"; ?>