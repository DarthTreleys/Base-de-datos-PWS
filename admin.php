<?php
session_start();
if ($_SESSION['role'] !== "admin") {
    header("Location: login.php");
    exit();
}
echo "<h1>Benvingut Admin – Cognom i Cognom</h1>";
echo '<a href="logout.php">Logout</a>';
?>
