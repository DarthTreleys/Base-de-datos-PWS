<?php
session_start();
$conn = new mysqli("localhost", "root2", "12345", "ASIX2");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id_u, email, password FROM usuaris WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row['email'];
            $_SESSION['role'] = ($email == "admin@example.com") ? "admin" : "client";

            header("Location: " . ($_SESSION['role'] == "admin" ? "admin.php" : "client.php"));
            exit();
        } else {
            echo "Contrasenya incorrecta!";
        }
    } else {
        echo "Usuari no trobat!";
    }
}
?>

<form method="post">
    <input type="text" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Contrasenya">
    <button type="submit">Login</button>
</form>
