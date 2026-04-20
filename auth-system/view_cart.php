<?php
session_start();
include "includes/header.php";
include "db.php";

?>

<?php include "navbar.php"; ?>

<div class="cart-container">

<h1 class="auth-heading">Your Cart</h1>
<p class="auth-subheading">Review your selected items</p>

<?php
$total = 0;

if (!empty($_SESSION['cart'])) {

  foreach ($_SESSION['cart'] as $id => $qty) {

    $result = $conn->query("SELECT * FROM products WHERE id=$id");
    $product = $result->fetch_assoc();

    $subtotal = $product['price'] * $qty;
    $total += $subtotal;
?>

  <div class="cart-item">

    <img src="images/<?php echo $product['image']; ?>" class="cart-img">

    <div class="cart-details">
      <div class="cart-name"><?php echo $product['name']; ?></div>
      <div class="cart-price">৳<?php echo $product['price']; ?></div>
      <div class="cart-qty">Quantity: <?php echo $qty; ?></div>
    </div>

    <form method="POST" action="remove_from_cart.php">
      <input type="hidden" name="product_id" value="<?php echo $id; ?>">
      <button class="remove-btn">Remove</button>
    </form>

  </div>

<?php
  }
} else {
  echo "<p>Your cart is empty</p>";
}
?>

<div class="cart-summary">
  <div class="cart-total">Total: ৳<?php echo $total; ?></div>
</div>

</div>

<?php include "includes/footer.php"; ?>