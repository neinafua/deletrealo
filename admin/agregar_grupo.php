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

$mensaje = ""; // Mensaje para mostrar al guardar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_grupo = $_POST['nombre_grupo'];
    $id_grado = $_POST['id_grado'];
    $id_jornada = $_POST['id_jornada'];

    $sql = "INSERT INTO grupo (nombre_grupo, id_grado, id_jornada)
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $nombre_grupo, $id_grado, $id_jornada);

    if ($stmt->execute()) {
        $mensaje = "Grupo guardado correctamente.";
    } else {
        $mensaje = "Error al guardar el grupo: " . $stmt->error;
    }

    $stmt->close();
}

// Obtener grados
$sql_grados = "SELECT id_grado, nombre_grado FROM grado";
$resultado_grado = $conn->query($sql_grados);

// Obtener jornadas
$sql_jornadas = "SELECT id_jornada, nombre_jornada FROM jornada";
$resultado_jornada = $conn->query($sql_jornadas);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Grupo - Deletrealo</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Registro de Grupo</h1>

    <?php if (!empty($mensaje)) echo "<p>$mensaje</p>"; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <p>
            <label for="nombre_grupo">Nombre del grupo:</label><br>
            <input type="text" id="nombre_grupo" name="nombre_grupo" required>
        </p>

        <p>
            <label for="id_grado">Grado:</label><br>
            <select id="id_grado" name="id_grado" required>
                <option value="">Seleccione un grado</option>
                <?php
                if ($resultado_grado && $resultado_grado->num_rows > 0) {
                    while($row = $resultado_grado->fetch_assoc()) {
                        echo "<option value='" . $row["id_grado"] . "'>" . $row["nombre_grado"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay grados registrados</option>";
                }
                ?>
            </select>
        </p>

        <p>
            <label for="id_jornada">Jornada:</label><br>
            <select id="id_jornada" name="id_jornada" required>
                <option value="">Seleccione una jornada</option>
                <?php
                if ($resultado_jornada && $resultado_jornada->num_rows > 0) {
                    while($row = $resultado_jornada->fetch_assoc()) {
                        echo "<option value='" . $row["id_jornada"] . "'>" . $row["nombre_jornada"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay jornadas registradas</option>";
                }
                ?>
            </select>
        </p>

        <input type="submit" value="Guardar Grupo">
    </form>

    <p><a href="../pagina_administrador.php?logout=1">Cerrar sesión</a></p>
</body>
</html>
