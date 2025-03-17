<?php
session_start();
if ($_SESSION['role'] !== "client") {
    header("Location: login.php");
    exit();
}
echo "<h1>Benvingut Client – Cognom i Cognom</h1>";
echo '<a href="logout.php">Logout</a>';
?>
