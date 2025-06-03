<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['alumno_id'])) {
    // Si el usuario no está autenticado, redirigirlo al formulario de inicio de sesión
    header("Location: login.php");
    exit;
}

// Obtener el ID del alumno de la sesión
$alumno_id = $_SESSION['alumno_id'];

// Conexión a la base de datos
include("../../bd.php");

// Obtener los cursos del alumno
$stmt_miscursos = $conexion->prepare("SELECT * FROM inscripcion WHERE IDAlumno = :alumno_id");
$stmt_miscursos->bindParam(':alumno_id', $alumno_id);
$stmt_miscursos->execute();
$miscursos = $stmt_miscursos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Cursos</title>
    <!-- Incluye Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Estilos CSS -->
    <style>
        body {
            background-image: url('../../imagenes/fondos/wallhaven-j5lolw_1920x1080.png');
            background-size: auto;
            background-position: center;
            background-repeat: repeat;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: transparent;
            border-radius: 5px;
            box-shadow: none;
            font-size: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #0056b3;
            color: #fff;
        }

        td {
            background-color: #f2f2f2;
        }

        /* Botón de regreso en la esquina superior derecha */
        .top-right-btn {
            position: absolute;
            top: 10px; /* Espacio desde la parte superior */
            right: 10px; /* Espacio desde la parte derecha */
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            background-color: purple;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .top-right-btn:hover {
            background-color: orange;
        }

        .back-button {
            display: block;
            text-decoration: none;
            color: #fff;
            text-align: center;
            padding: 15px 30px;
            margin-top: 20px;
            background-color: purple;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 18px;
        }

        .back-button:hover {
            background-color: orange;
        }
    </style>
</head>
<body>
    <!-- Botón de regreso en la parte superior derecha -->
    <a href="../inicio/index.php" class="top-right-btn">
        <i class="fas fa-arrow-left"></i> Regresar
    </a>
    <div class="container">
        <h1>Mis Cursos</h1>
        <table>
            <thead>
                <tr>
                    <th>Nombre del Curso</th>
                    <th>Nombre del Profesor</th>
                    <th>Duración del Curso</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($miscursos as $curso): ?>
                    <tr>
                        <td><?php echo $curso['Curso']; ?></td>
                        <td><?php echo $curso['Profesor']; ?></td>
                        <td><?php echo $curso['Ins_duracion']; ?></td>
                        <td><?php echo $curso['Ins_estado']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
