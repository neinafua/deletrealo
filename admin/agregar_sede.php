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
    $nombre_sede = $_POST['nombre_sede'];
    $id_colegio = $_POST['id_colegio'];

    $sql = "INSERT INTO sede (nombre_sede, id_colegio)
            VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre_sede, $id_colegio); // Corregí a "ss" ya que id_colegio parece ser VARCHAR

    if ($stmt->execute()) {
        $mensaje = "sede guardada correctamente";
    } else {
        $mensaje = "Error al guardar la sede: " . $stmt->error;
    }

    $stmt->close();
}

// Consulta para obtener los colegios
$sql_colegios = "SELECT id_colegio, nombre_colegio FROM colegio";
$resultado_colegio = $conn->query($sql_colegios);

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
    <h1>Sistema de Deletreo - Panel de sede</h1>

    <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>

    <h2>Agregar Nueva sede</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <p>
            <label for="nombre_sede">Nombre de la sede:</label><br>
            <input type="text" id="nombre_sede" name="nombre_sede" required>
        </p>
        <p>
            <label for="id_colegio">colegio:</label><br>
            <select id="id_colegio" name="id_colegio" required>
                <option value="">Seleccione un colegio</option>
                <?php
                if ($resultado_colegio && $resultado_colegio->num_rows > 0) {
                    while($row = $resultado_colegio->fetch_assoc()) {
                        echo "<option value='" . $row["id_colegio"] . "'>" . $row["nombre_colegio"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay colegios registrados</option>";
                }
                ?>
            </select>
        </p>
        <input type="submit" value="Guardar Sede">
    </form>

    <a href="../pagina_administrador.php?logout=1">Cerrar sesión</a>
</body>
</html>