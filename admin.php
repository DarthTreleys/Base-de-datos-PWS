<?php
session_start();
if ($_SESSION['role'] !== "admin") {
    header("Location: login.php");
    exit();
}
echo "<h1>Benvingut Admin – Marc Jimenez i Joan Cos</h1>";
echo '<a href="logout.php">Logout</a>';
?>
