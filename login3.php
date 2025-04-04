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
    $email = htmlspecialchars($_POST['email']); // Evitar XSS
    $password = htmlspecialchars($_POST['password']); // Evitar XSS

    $stmt = $conn->prepare("SELECT * FROM usuaris WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultat = $stmt->get_result();

    while ($fila_bbdd = $resultat->fetch_assoc()) {
        if ($email == $fila_bbdd['email']) {
            if ($password != $fila_bbdd['password']) {
                echo "Esa contraseña no es correcta";
            } else {
                $_SESSION['id_usuari'] = $fila_bbdd["id_u"];
                if ($fila_bbdd["is_admin"] != 0) {
                    header("location:usuari.php");
                } else {
                    header("location:admin.php");
                }
                exit();
            }
        }
    }

    $stmt->close();
}

$conn->close();
?>

<!-- Formulario de inicio de sesión -->
<form method="post">
    <input type="text" name="email" placeholder="Email" required> <!-- Campo para ingresar el email -->
    <input type="password" name="password" placeholder="Contraseña" required> <!-- Campo para ingresar la contraseña -->
    <button type="submit">Login</button> <!-- Botón para enviar el formulario -->
</form>
