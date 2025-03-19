<?php
session_start(); // Iniciar sesión
$conn = new mysqli("200.200.200.10", "root2", "12345", "ASIX2"); // Conectar a la base de datos

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error); // Detener ejecución si hay error de conexión
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Verificar si el formulario fue enviado
    $email = $_POST['email']; // Obtener el email ingresado
    $password = $_POST['password']; // Obtener la contraseña ingresada

    // Preparar la consulta para buscar el usuario en la base de datos
    $stmt = $conn->prepare("SELECT id_u, email, password, is_admin FROM usuaris WHERE email=?");
    $stmt->bind_param("s", $email); // Asignar el email al parámetro de la consulta
    $stmt->execute(); // Ejecutar la consulta
    $result = $stmt->get_result(); // Obtener el resultado de la consulta

    if ($row = $result->fetch_assoc()) { // Verificar si el usuario existe
        if (password_verify($password, $row['password'])) { // Verificar si la contraseña es correcta
            $_SESSION['user'] = $row['email']; // Guardar el email en la sesión
            $_SESSION['role'] = ($row['is_admin'] == 1) ? "admin" : "client"; // Determinar el rol del usuario

            // Redirigir según el rol del usuario
            header("Location: " . ($_SESSION['role'] == "admin" ? "admin.php" : "client.php"));
            exit(); // Finalizar el script para evitar ejecución innecesaria
        } else {
            echo "¡Contraseña incorrecta!"; // Mensaje si la contraseña no es válida
        }
    } else {
        echo "¡Usuario no encontrado!"; // Mensaje si el usuario no existe
    }
    
    $stmt->close(); // Cerrar la consulta preparada
}
$conn->close(); // Cerrar la conexión a la base de datos
?>

<!-- Formulario de inicio de sesión -->
<form method="post">
    <input type="text" name="email" placeholder="Email" required> <!-- Campo para ingresar el email -->
    <input type="password" name="password" placeholder="Contraseña" required> <!-- Campo para ingresar la contraseña -->
    <button type="submit">Login</button> <!-- Botón para enviar el formulario -->
</form>
