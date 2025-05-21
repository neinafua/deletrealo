<?php
session_start();

// Verificar si el usuario está logueado como administrador
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 'administrador') {
    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador - Deletrealo</title>
</head>
<body>
    <h1>Panel de Administrador</h1>
    
    <h2>Gestión de Usuarios</h2>
    <ul>
        <li><a href="admin/agregar_administrador.php">Agregar Administrador</a></li>
        <li><a href="admin/agregar_digitador.php">Agregar Digitador</a></li>
        <li><a href="admin/agregar_docente.php">Agregar Docente</a></li>
        <li><a href="admin/agregar_estudiante.php">Agregar Estudiante</a></li>
    </ul>
    
    <h2>Gestión de Instituciones</h2>
    <ul>
        <li><a href="admin/agregar_colegio.php">Agregar Colegio</a></li>
        <li><a href="admin/agregar_sede.php">Agregar Sede</a></li>
        <li><a href="admin/agregar_grupo.php">Agregar Grupo</a></li>
    </ul>
    
    <h2>Gestión de Contenido</h2>
    <ul>
        <li><a href="admin/agregar_palabra.php">Agregar Palabra</a></li>
    </ul>
    
    <p><a href="index.php?logout=1">Cerrar sesión</a></p>
</body>
</html>