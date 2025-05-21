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
    $nombre_docente = $_POST['nombre_docente'];
    $apellido_docente = $_POST['apellido_docente'];
    $email_docente = $_POST['email_docente'];
    $contrasena = $_POST['contrasena'];
    $id_grupo = $_POST['id_grupo'];
    $id_sede = $_POST['id_sede'];

    $sql = "INSERT INTO docente (nombre_docente, apellido_docente, email_docente, contrasena, id_grupo, id_sede)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $nombre_docente, $apellido_docente, $email_docente, $contrasena, $id_grupo, $id_sede);

    if ($stmt->execute()) {
        $mensaje = "Docente guardado correctamente";
    } else {
        $mensaje = "Error al guardar el docente: " . $stmt->error;
    }

    $stmt->close();
}

// Consulta para obtener los grupos
$sql_grupos = "SELECT id_grupo, nombre_grupo FROM grupo";
$resultado_grupo = $conn->query($sql_grupos);

// Consulta para obtener las sedes
$sql_sedes = "SELECT id_sede, nombre_sede FROM sede";
$resultado_sede = $conn->query($sql_sedes);

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
    <h1>Sistema de Deletreo - Panel de Docentes</h1>

    <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>

    <h2>Agregar Nuevo Docente</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <p>
            <label for="nombre_docente">Nombre del docente:</label><br>
            <input type="text" id="nombre_docente" name="nombre_docente" required>
        </p>
        <p>
            <label for="apellido_docente">Apellido del docente:</label><br>
            <input type="text" id="apellido_docente" name="apellido_docente" required>
        </p>
        <p>
            <label for="email_docente">Email del docente:</label><br>
            <input type="email" id="email_docente" name="email_docente" required>
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
        <p>
            <label for="id_sede">Sede:</label><br>
            <select id="id_sede" name="id_sede" required>
                <option value="">Seleccione una sede</option>
                <?php
                if ($resultado_sede && $resultado_sede->num_rows > 0) {
                    while($row = $resultado_sede->fetch_assoc()) {
                        echo "<option value='" . $row["id_sede"] . "'>" . $row["nombre_sede"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay sedes registradas</option>";
                }
                ?>
            </select>
        </p>
        <input type="submit" value="Guardar Docente">
    </form>

    <a href="../pagina_administrador.php?logout=1">Cerrar sesión</a>
</body>
</html>