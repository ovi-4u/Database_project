<?php
session_start();
include "includes/header.php";
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$name = $_SESSION['user'];

// get user info
$stmt = $conn->prepare("SELECT * FROM users WHERE name=?");
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<?php include "navbar.php"; ?>

<div class="profile-container">

<div class="profile-card">

  <div class="profile-header">
    <div class="profile-title">Your Profile</div>
    <div class="profile-sub">Manage your account details</div>
  </div>

  <form class="profile-form" method="POST" action="update_profile.php">

    <div>
      <div class="profile-label">Name</div>
      <input type="text" name="name" class="profile-input"
             value="<?php echo $user['name']; ?>">
    </div>

    <div>
      <div class="profile-label">Email</div>
      <input type="email" name="email" class="profile-input"
             value="<?php echo $user['email']; ?>">
    </div>

    <button class="btn-primary profile-btn">Save Changes</button>

  </form>

</div>

</div>

<?php include "includes/footer.php"; ?>