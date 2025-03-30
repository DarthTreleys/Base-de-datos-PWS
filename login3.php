<?php
session_start(); // Iniciar sesión

$ip = "200.200.200.10";
$usuari = "root";
$contrasenya = "12345";
$basededatos = "ASIX2";

$conn = new mysqli("localhost", "root2", "12345", "ASIX2"); 
// Conectar a la base de datos

// Verificar conexión
if ($_SERVER['REQUEST_METHOD'] == "POST") { // Verificar si el formulario fue enviado
    $email = $_POST['email']; // Obtener el email ingresado
    $password = $_POST['password']; // Obtener la contraseña ingresada

    $stmt = $conn->prepare("SELECT * FROM usuaris WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultat = $stmt->get_result();

    while ($fila_bbdd = $resultat->fetch_assoc()) {
        if ($_POST['email'] == $fila_bbdd['email']) {
            if ($_POST['password'] != $fila_bbdd['password']) {
                echo " esa contraseña no es correcta ";
            } else {
                $_SESSION['id_usuari'] = $fila_bbdd["id_u"];
                if ($fila_bbdd["is_admin"] != 0) {
                    header("location:usuari.php");
                } else {
                    header("location:admin.php");
                }
            }
        }
    }

    $stmt->close();
}

$conn->close();
?>
