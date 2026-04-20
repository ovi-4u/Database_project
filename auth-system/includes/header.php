<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Ovir Dukan</title>

<link href="https://fonts.googleapis.com/css2?family=Syne&family=DM+Sans&display=swap" rel="stylesheet">

<!-- 🔥 LINK YOUR CSS -->
<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<!-- BACKGROUND -->
<div class="scene">
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>
  <div class="orb orb-3"></div>
  <div class="orb orb-4"></div>
  <div class="grid-lines"></div>
  <div class="particles" id="particles"></div>
</div>

<!-- MAIN WRAPPER -->
<div class="page-wrapper">