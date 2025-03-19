<?php
// session_start();
//if ($_SESSION['role'] !== "admin") {
//    header("Location: login.php");
//    exit();
//}
//echo "<h1>Benvingut Admin – Marc Jimenez i Joan Cos</h1>";
//echo '<a href="logout.php">Logout</a>';
    sesssion_start();
    
    if(empty($_SESSION) || $_SESSION["admin"] !=1){
        session_destroy();
        header("location:login.php");
    }
    if(!empty($_POST["logout"])){
        session_destroy();
        header("location:login.php");

    echo "Benvingut admin";
?>
<form method="post">
    <input type="submit" name="logout" value="Sortir">
</form>
