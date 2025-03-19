<?php
session_start();
$conn = new mysqli("localhost", "root2", "12345", "ASIX2");

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id_u, email, password, is_admin FROM usuaris WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row['email'];
            $_SESSION['role'] = ($row['is_admin'] == 1) ? "admin" : "client";

            header("Location: " . ($_SESSION['role'] == "admin" ? "admin.php" : "client.php"));
            exit();
        } else {
            echo "¡Contraseña incorrecta!";
        }
    } else {
        echo "¡Usuario no encontrado!";
    }
    
    $stmt->close();
}
$conn->close();
?>

<form method="post">
    <input type="text" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Login</button>
</form>
