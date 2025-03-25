<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "client") {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "123", "ASIX2");
if ($conn->connect_error) {
    die("Connexió fallida: " . $conn->connect_error);
}

$_SESSION['id_u'] = $_SESSION['id_u'] ?? 1; // Asignar un ID de usuario para pruebas

?>

<h1>Benvingut Client – Marc Jimenes i Joan Cos</h1>
<a href="logout.php">Logout</a>

<hr>

<!-- Formulari per afegir comentaris -->
<form method="post">
    <label>Missatge: <input type="text" name="missatge" placeholder="Escriu un missatge" required></label>
    <button type="submit" name="enviar">Enviar</button>
</form>

<?php
if (isset($_POST['enviar'])) {
    $missatge = htmlspecialchars($_POST['missatge']);
    $id_u = $_SESSION['id_u'];
    $stmt = $conn->prepare("INSERT INTO comentaris (missatge, id_u) VALUES (?, ?)");
    $stmt->bind_param("si", $missatge, id_u);
    $stmt->execute();
}

// Mostrar comentaris
$result = $conn->query("SELECT missatge FROM comentaris");
while ($row = $result->fetch_assoc()) {
    echo "<p>" . htmlspecialchars($row['missatge']) . "</p>";
}
?>

<hr>

<!-- Formulari de buscador -->
<form method="post">
    <input type="text" name="search" placeholder="Buscar comentaris">
    <button type="submit" name="buscar">Buscar</button>
</form>

<?php
if (isset($_POST['buscar'])) {
    $search = "%" . $_POST['search'] . "%";
    $stmt = $conn->prepare("SELECT missatge FROM comentaris WHERE missatge LIKE ?");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo "<p>" . htmlspecialchars($row['missatge']) . "</p>";
    }
}
?>

<hr>

<!-- Formulari per pujar imatges -->
<form method="post" enctype="multipart/form-data">
    <input type="file" name="fitxer" required>
    <button type="submit" name="pujar">Pujar</button>
</form>

<?php
if (isset($_POST['pujar']) && isset($_FILES['fitxer'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fitxer"]["name"]);
    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
    
    // Comprovar que és una imatge
    if (getimagesize($_FILES["fitxer"]["tmp_name"])) {
        if (move_uploaded_file($_FILES["fitxer"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO fitxers (ruta_fitxer, tipus_fitxer, id_u) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $target_file, $file_type, $_SESSION['id_u']);
            $stmt->execute();
            echo "<p>Imatge pujada correctament:</p><img src='$target_file' width='200'>";
        } else {
            echo "Error en pujar l'arxiu.";
        }
    } else {
        echo "Només es permeten imatges.";
    }
}
?>
