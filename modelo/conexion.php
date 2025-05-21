<?php
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

// Función para crear una conexión a la base de datos
function conectar_db() {
    global $servername, $username, $password, $dbname;
    
    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
    return $conn;
}
?>