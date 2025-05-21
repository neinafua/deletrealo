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

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_estudiante = $_POST['nombre_estudiante'];
    $apellido_estudiante = $_POST['apellido_estudiante'];
    $email_estudiante = $_POST['email_estudiante'];
    $contrasena = $_POST['contrasena']; // la variable sigue sin ñ por compatibilidad
    $id_grupo = $_POST['id_grupo'];

    $sql = "INSERT INTO estudiante (nombre_estudiante, apellido_estudiante, email_estudiante, contrasena, id_grupo)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nombre_estudiante, $apellido_estudiante, $email_estudiante, $contrasena, $id_grupo);

    if ($stmt->execute()) {
        $mensaje = "Estudiante guardado correctamente.";
    } else {
        $mensaje = "Error al guardar el estudiante: " . $stmt->error;
    }

    $stmt->close();
}

$sql_grupos = "SELECT id_grupo, nombre_grupo FROM grupo";
$resultado_grupo = $conn->query($sql_grupos);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Estudiantes - Deletrealo</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Panel de Registro de Estudiantes</h1>

    <?php if (!empty($mensaje)) echo "<p>$mensaje</p>"; ?>

    <h2>Agregar Nuevo Estudiante</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <p>
            <label for="nombre_estudiante">Nombre del estudiante:</label><br>
            <input type="text" id="nombre_estudiante" name="nombre_estudiante" required>
        </p>
        <p>
            <label for="apellido_estudiante">Apellido del estudiante:</label><br>
            <input type="text" id="apellido_estudiante" name="apellido_estudiante" required>
        </p>
        <p>
            <label for="email_estudiante">Email del estudiante:</label><br>
            <input type="email" id="email_estudiante" name="email_estudiante" required>
        </p>
        <p>
            <label for="contrasena">Contraseña:</label><br>
            <input type="password" id="contrasena" name="contrasena" required>
        </p>
        <p>
            <label for="id_grupo">Grupo:</label><br>
            <select id="id_grupo" name="id_grupo" required>
                <option value="">Seleccione un grupo</option>
                <?php
                if ($resultado_grupo && $resultado_grupo->num_rows > 0) {
                    while($row = $resultado_grupo->fetch_assoc()) {
                        echo "<option value='" . $row["id_grupo"] . "'>" . $row["nombre_grupo"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay grupos registrados</option>";
                }
                ?>
            </select>
        </p>
        <input type="submit" value="Guardar Estudiante">
    </form>

    <p><a href="../pagina_docentes.php?logout=1">Cerrar sesión</a></p>
</body>
</html>
