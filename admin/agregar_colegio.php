<?php
session_start();

// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "deletrealo";

// --- CONEXIÓN REMOTA ---
/*$servername = "sql109.infinityfree.com";
$username = "if0_38862569";
$password = "CP263jUEsm"; 
$dbname = "if0_38862569_deletrealo";*/
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$mensaje = ""; // Inicializa la variable mensaje

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_colegio = $_POST['nombre_colegio'];

    $sql = "INSERT INTO colegio (nombre_colegio)
            VALUES (?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre_colegio); // 

    if ($stmt->execute()) {
        $mensaje = "colegio guardada correctamente";
    } else {
        $mensaje = "Error al guardar el colegio: " . $stmt->error;
    }

    $stmt->close();
}


// Cierra la conexión después de realizar todas las operaciones necesarias
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Deletreo - Administrador</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Sistema de Deletreo - Panel de colegio</h1>

    <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>

    <h2>Agregar Nuevo colegio</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <p>
            <label for="nombre_colegio">Nombre de el colegio:</label><br>
            <input type="text" id="nombre_colegio" name="nombre_colegio" required>
        </p>
        <input type="submit" value="Guardar colegio">
    </form>

    <a href="../pagina_administrador.php?logout=1">Cerrar sesión</a>
</body>
</html>