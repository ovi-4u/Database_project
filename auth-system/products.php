<?php
include "includes/header.php";
include "db.php";

$result = $conn->query("SELECT * FROM products");
?>

<?php include "navbar.php"; ?>

<div class="auth-card" style="max-width:1000px;">

<h1 class="auth-heading">Products</h1>

<div style="display:flex; gap:20px; flex-wrap:wrap; margin-top:20px;">

<?php while($row = $result->fetch_assoc()): ?>

  <div style="
    width:220px;
    background: rgba(10,20,40,0.6);
    border:1px solid rgba(100,160,255,0.2);
    border-radius:20px;
    padding:15px;
    backdrop-filter: blur(20px);
  ">

    <img src="images/<?php echo $row['image']; ?>" style="width:100%; border-radius:10px;">

    <h3 style="margin-top:10px;"><?php echo $row['name']; ?></h3>
    <p>৳<?php echo $row['price']; ?></p>

    <form method="POST" action="cart.php">
      <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
      <button class="btn-primary">Add to Cart</button>
    </form>

  </div>

<?php endwhile; ?>

</div>
</div>

<?php include "includes/footer.php"; ?>