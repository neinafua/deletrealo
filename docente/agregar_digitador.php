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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_digitador = $_POST['nombre_digitador'];
    $contraseña = $_POST['contraseña'];
    $email_digitador = $_POST['email_digitador'];

    $sql = "INSERT INTO digitador (email_digitador, contraseña, nombre_digitador) 
            VALUES (?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email_digitador, $contraseña, $nombre_digitador);
    
    if ($stmt->execute()) {
        $mensaje = "Cuenta de digitador guardada correctamente";
    } else {
        $mensaje = "Error al guardar la cuenta de digitador: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Deletreo - Administrador</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Sistema de Deletreo - Panel de digitador</h1>

    <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>
    
    <h2>Agregar Nueva cuenta de digitador</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <p>
            <label for="nombre_digitador">Nombre del digitador:</label><br>
            <input type="text" id="nombre_digitador" name="nombre_digitador" required>
        </p>
        <p>
            <label for="email_digitador">Email del digitador:</label><br>
            <input type="email" id="email_digitador" name="email_digitador" required>
        </p>
        <p>
            <label for="contraseña">Contraseña:</label><br>
            <input type="password" id="contraseña" name="contraseña" required>
        </p>
        <p>
            <input type="submit" value="Guardar cuenta de digitador">
        </p>
    </form>

    <a href="../pagina_docentes.php?logout=1">Cerrar sesión</a>
</body>
</html>
