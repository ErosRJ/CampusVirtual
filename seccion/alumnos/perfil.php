<?php
include("../../bd.php");

session_start();

// Verificar si el alumno ha iniciado sesión
if (!isset($_SESSION['alumno_id'])) {
    // Si no ha iniciado sesión, redireccionar al formulario de inicio de sesión
    header("location: login.php");
    exit;
}

// Obtener el ID del alumno de la sesión
$alumno_id = $_SESSION['alumno_id'];

// Realizar una consulta para obtener los datos del alumno
$stmt = $conexion->prepare("SELECT Nombre_alumno, Telefono, Correo FROM alumnos WHERE IDalumno = :alumno_id");
$stmt->bindParam(':alumno_id', $alumno_id);
$stmt->execute();
$alumno = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar si se encontraron datos del alumno
if (!$alumno) {
    echo "No se encontraron datos del alumno.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <!-- Importar Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Importar Bootstrap para estilos mejorados -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- CSS personalizado -->
    <style>
        body {
            background-image: url('../../imagenes/fondos/backiee-292926.jpg');
            background-size: cover;
            background-position: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 50px;
            margin: 0;
        }

        .profile-container {
            max-width: 500px;
            margin: 50px auto;
            background-color: transparente;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
        }

        h1 {
            font-size: 35px;
            color: white;
            margin-bottom: 20px;
        }

        p {
            color: white;
            font-size: 25px;
            margin-bottom: 15px;
        }

        .btn {
            font-size: 1.2em;
            padding: 15px 25px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: orange;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #00bcd4;
            /* Se eliminó el giro */
        }

        .btn-secondary {
            background-color: #2ecc71;
            color: white;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #27ae60;
            /* Se eliminó el giro */
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h1>Perfil de Usuario</h1>
        <p><strong>Nombre:</strong> <?php echo $alumno['Nombre_alumno']; ?></p>
        <p><strong>Teléfono:</strong> <?php echo $alumno['Telefono']; ?></p>
        <p><strong>Correo:</strong> <?php echo $alumno['Correo']; ?></p>
        
        <!-- Botón para editar perfil con icono de edición -->
        <a href="../../seccion/alumnos/edit.php?id=<?php echo $alumno_id; ?>" class="btn btn-primary">
            <i class="fas fa-edit"></i> Editar Perfil
        </a>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <!-- Botón para regresar con icono de flecha hacia la izquierda -->
        <a href="../inicio/index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Regresar
        </a>
    </div>

    <!-- Importar Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
