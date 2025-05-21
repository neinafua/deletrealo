<?php
// Iniciar sesión
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

if (isset($_SESSION['tipo_usuario'])) {
    switch ($_SESSION['tipo_usuario']) {
        case 'estudiante':
            header("Location: pagina_estudiantes.php");
            break;
        case 'docente':
            header("Location: pagina_docentes.php");
            break;
        case 'administrador':
            header("Location: pagina_administrador.php");
            break;
        case 'digitador':
            header("Location: pagina_digitador.php");
            break;
    }
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Deletreo</title>
</head>
<body>
    <h2>Sistema de Deletreo</h2>
    
    <h3>Seleccione su tipo de usuario:</h3>
    <p><a href="loguear/loguear_estudiante.php"><button>Estudiante</button></a></p>
    <p><a href="loguear/loguear_docente.php"><button>Docente</button></a></p>
    <p><a href="loguear/loguear_administrador.php"><button>Administrador</button></a></p>
    <p><a href="loguear/loguear_digitador.php"><button>Digitador</button></a></p>
</body>
</html>