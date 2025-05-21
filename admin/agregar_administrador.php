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
    $nombre_administrador = $_POST['nombre_administrador'];
    $contraseña = $_POST['contraseña'];
    $email_administrador = $_POST['email_administrador'];

    $sql = "INSERT INTO administrador (email_administrador, contraseña, nombre_administrador) 
            VALUES (?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email_administrador, $contraseña, $nombre_administrador);
    
    if ($stmt->execute()) {
        $mensaje = "Cuenta de administrador guardada correctamente";
    } else {
        $mensaje = "Error al guardar la cuenta de administrador: " . $stmt->error;
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
    <h1>Sistema de Deletreo - Panel de Administrador</h1>

    <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>
    
    <h2>Agregar Nueva cuenta administrador</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <p>
            <label for="nombre_administrador">Nombre del administrador:</label><br>
            <input type="text" id="nombre_administrador" name="nombre_administrador" required>
        </p>
        <p>
            <label for="email_administrador">Email del administrador:</label><br>
            <input type="email" id="email_administrador" name="email_administrador" required>
        </p>
        <p>
            <label for="contraseña">Contraseña:</label><br>
            <input type="password" id="contraseña" name="contraseña" required>
        </p>
        <p>
            <input type="submit" value="Guardar cuenta de administrador">
        </p>
    </form>

<a href="../pagina_administrador.php?logout=1">Cerrar sesión</a>
</body>
</html>
