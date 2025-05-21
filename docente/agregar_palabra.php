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

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_palabra = $_POST['nombre_palabra'];
    $etimologia = $_POST['etimologia'];
    $significado = $_POST['significado'];
    $id_categoria = $_POST['id_categoria'];
    $id_nivel = $_POST['id_nivel'];
    
    // Preparar la consulta SQL
    $sql = "INSERT INTO palabra (nombre_palabra, etimologia, significado, id_categoria, id_nivel) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $nombre_palabra, $etimologia, $significado, $id_categoria, $id_nivel);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        $mensaje = "Palabra guardada correctamente";
    } else {
        $mensaje = "Error al guardar la palabra: " . $stmt->error;
    }
    
    $stmt->close();
}

// Consulta para obtener las categorías disponibles
$sql_categorias = "SELECT id_categoria, nombre_categoria FROM categoria";
$resultado_categorias = $conn->query($sql_categorias);

// Consulta para obtener los niveles disponibles
$sql_niveles = "SELECT id_nivel, nombre_nivel FROM nivel";
$resultado_niveles = $conn->query($sql_niveles);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Deletreo - Digitador</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Sistema de Deletreo - Panel de Digitador</h1>
    
    <?php if(isset($mensaje)) echo "<p>$mensaje</p>"; ?>
    
    <h2>Agregar Nueva Palabra</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <p>
            <label for="nombre_palabra">Nombre de la Palabra:</label><br>
            <input type="text" id="nombre_palabra" name="nombre_palabra" required>
        </p>
        
        <p>
            <label for="etimologia">Etimología:</label><br>
            <textarea id="etimologia" name="etimologia" rows="3" cols="50"></textarea>
        </p>
        
        <p>
            <label for="significado">Significado:</label><br>
            <textarea id="significado" name="significado" rows="3" cols="50" required></textarea>
        </p>
        
        <p>
            <label for="id_categoria">Categoría:</label><br>
            <select id="id_categoria" name="id_categoria" required>
                <option value="">Seleccione una categoría</option>
                <?php 
                if ($resultado_categorias && $resultado_categorias->num_rows > 0) {
                    while($row = $resultado_categorias->fetch_assoc()) {
                        echo "<option value='" . $row["id_categoria"] . "'>" . $row["nombre_categoria"] . "</option>";
                    }
                }
                ?>
            </select>
        </p>
        
        <p>
            <label for="id_nivel">Nivel:</label><br>
            <select id="id_nivel" name="id_nivel" required>
                <option value="">Seleccione un nivel</option>
                <?php 
                if ($resultado_niveles && $resultado_niveles->num_rows > 0) {
                    while($row = $resultado_niveles->fetch_assoc()) {
                        echo "<option value='" . $row["id_nivel"] . "'>" . $row["nombre_nivel"] . "</option>";
                    }
                }
                ?>
            </select>
        </p>
        
        <p>
            <input type="submit" value="Guardar Palabra">
        </p>
    </form>


<a href="../pagina_docentes.php?logout=1">Cerrar sesión</a>
    
</body>
</html>