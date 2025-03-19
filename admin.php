<?php
// session_start();
//if ($_SESSION['role'] !== "admin") {
//    header("Location: login.php");
//    exit();
//}
//echo "<h1>Benvingut Admin – Marc Jimenez i Joan Cos</h1>";
//echo '<a href="logout.php">Logout</a>';

//Hace falta hacer un select a la base de datos, para guardar en una variable el valor del atributo de usuario "isadmin" en el caso de que sea 0 o 1

$admin
(select * from usuaris where is_admin = 1) == $admin

    sesssion_start();
    $conn = new mysqli("200.200.200.10", "root2", "12345", "ASIX2");
    //if(empty($_SESSION) || $_SESSION["admin"] !=1){
        //session_destroy();
        //header("location:login.php");
    //}
    //if(!empty($_POST["logout"])){
       //session_destroy();
        //header("location:login.php");

    echo "Benvingut admin";
?>
<form method="post">
    <input type="submit" name="logout" value="Sortir">
</form>
