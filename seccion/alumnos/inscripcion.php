<?php
// Conexión a la base de datos
include("../../bd.php");

session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['alumno_id'])) {
    // Si el usuario no está autenticado, redirigirlo al formulario de inicio de sesión
    header("Location: login.php");
    exit;
}

// Obtener el ID del alumno de la sesión
$alumno_id = $_SESSION['alumno_id'];

// Verificar si se ha enviado el formulario de inscripción
$mensaje = ""; // Para almacenar mensajes de error o confirmación
if (isset($_GET['curso_id'])) {
    // Obtener el ID del curso seleccionado
    $curso_id = $_GET['curso_id'];

     // Contar cuántos cursos está inscrito el alumno
     $stmt_count = $conexion->prepare("SELECT COUNT(*) FROM inscripcion WHERE IDAlumno = :alumno_id");
     $stmt_count->bindParam(':alumno_id', $alumno_id);
     $stmt_count->execute();
     $num_cursos = $stmt_count->fetchColumn();
 
     if ($num_cursos >= 2) {
         $mensaje = "No puedes inscribirte a más de dos cursos.";
     } else {

    // Verificar si el alumno ya está inscrito en el curso
    $stmt_check = $conexion->prepare("SELECT COUNT(*) FROM inscripcion WHERE IDAlumno = :alumno_id AND ID_C = :curso_id");
    $stmt_check->bindParam(':alumno_id', $alumno_id);
    $stmt_check->bindParam(':curso_id', $curso_id);
    $stmt_check->execute();
    $inscrito = $stmt_check->fetchColumn();

    if ($inscrito > 0) {
        // El alumno ya está inscrito
        $mensaje = "Ya estás inscrito en este curso.";
    } else {
    
    // Obtener los detalles del curso seleccionado
    $stmt_curso = $conexion->prepare("SELECT * FROM curso WHERE IDcurso = :curso_id");
    $stmt_curso->bindParam(':curso_id', $curso_id);
    $stmt_curso->execute();
    $curso = $stmt_curso->fetch(PDO::FETCH_ASSOC);

    // Verificar si el curso está en estado "En Curso" antes de proceder con la inscripción
    if ($curso && $curso['Estado_curso'] === 'En Curso') {
        // Obtener el nombre del alumno
        $stmt_alumno = $conexion->prepare("SELECT Nombre_alumno FROM alumnos WHERE IDalumno = :alumno_id");
        $stmt_alumno->bindParam(':alumno_id', $alumno_id);
        $stmt_alumno->execute();
        $nombre_alumno = $stmt_alumno->fetchColumn();

        // Insertar la inscripción en la tabla de inscripciones
        $stmt_inscripcion = $conexion->prepare(
            "INSERT INTO inscripcion (IDAlumno, ID_C, Alumno, Curso, Profesor, Ins_duracion, Ins_estado) 
            VALUES (:alumno_id, :curso_id, :nombre_alumno, :nombre_curso, :nombre_profesor, :duracion_curso, :estado_curso)"
        );
        $stmt_inscripcion->bindParam(':alumno_id', $alumno_id);
        $stmt_inscripcion->bindParam(':curso_id', $curso_id);
        $stmt_inscripcion->bindParam(':nombre_alumno', $nombre_alumno);
        $stmt_inscripcion->bindParam(':nombre_curso', $curso['Nombre_curso']);
        $stmt_inscripcion->bindParam(':nombre_profesor', $curso['Nombre_profesor']);
        $stmt_inscripcion->bindParam(':duracion_curso', $curso['Duracion_curso']);
        $stmt_inscripcion->bindParam(':estado_curso', $curso['Estado_curso']);
        $stmt_inscripcion->execute();
        $mensaje = "Te has inscrito con éxito al curso.";
    } else {
        $mensaje = "El curso no está disponible para inscripción.";
       }
    }
}
}

// Obtener la lista de cursos disponibles
$stmt_cursos = $conexion->prepare("SELECT * FROM curso");
$stmt_cursos->execute();
$cursos = $stmt_cursos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Curso</title>
    <!-- Incluye Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Estilos CSS -->
    <style>
        body {
            background-image: url('../../imagenes/fondos/backiee-259713-landscape.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
        }

        /* Botón de regresar en la esquina superior derecha */
        .top-right-btn {
            position: absolute;
            top: 10px; /* Espacio desde la parte superior */
            right: 10px; /* Espacio desde la parte derecha */
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            background-color: blue;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .top-right-btn:hover {
            background-color: orange;
        }
        
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: transparent;
            border-radius: 10px;
            box-shadow: none;
            font-size: 20px;
            color: white;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: white;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        li:hover {
            background-color: yellow;
            color: black;
        }

        .inscribirse-btn {
            display: block;
            text-decoration: none;
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 10px 20px;
            background-color: blue;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .inscribirse-btn:hover {
            background-color: orange;
        }

        .back-btn {
            display: block;
            text-decoration: none;
            color: white;
            text-align: center;
            padding: 15px 30px;
            background-color: blue;
            border-radius: 5px;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .back-btn:hover {
            background-color: yellow;
            color: black;
        }

        /* Botón para subir al principio de la página */
        .scroll-to-top {
            position: fixed; /* Hacer que permanezca visible */
            bottom: 10px; /* Colocar en la parte inferior */
            right: 10px; /* Colocar en la esquina derecha */
            padding: 10px 15px;
            background-color: blue;
            color: white;
            border-radius: 50%;
            text-align: center;
            cursor: pointer;
            opacity: 0; /* Inicialmente invisible */
            transition: opacity 0.3s; /* Suavidad al aparecer/desaparecer */
        }
        .scroll-to-top:hover {
            background-color: orange;
        }
    </style>
</head>
<body>
    <!-- Botón para regresar en la parte superior derecha -->
    <a href="../inicio/index.php" class="top-right-btn">
        <i class="fas fa-arrow-left"></i> Regresar</a>
    <div class="container">
        <h1>Seleccionar Curso</h1>
        
        <!-- Mostrar mensaje de confirmación o error -->
        <?php if ($mensaje): ?>
            <p><?php echo $mensaje; ?></p>
        <?php endif; ?>

        <ul>
            <?php foreach ($cursos as $curso): ?>
                <li>
                    <h2><?php echo $curso['Nombre_curso']; ?></h2>
                    <p><strong>Nombre del Profesor:</strong> <?php echo $curso['Nombre_profesor']; ?></p>
                    <p><strong>Duración del Curso:</strong> <?php echo $curso['Duracion_curso']; ?></p>
                    <p><strong>Estado del Curso:</strong> <?php echo $curso['Estado_curso']; ?></p>
                    <?php if ($curso['Estado_curso'] === 'En Curso'): ?>
                        <form action="" method="GET">
                            <input type="hidden" name="curso_id" value="<?php echo $curso['IDcurso']; ?>">
                            <button type="submit" class="inscribirse-btn">Inscribirse</button>
                        </form>
                    <?php else: ?>
                        <p>Este curso no está disponible para inscripciones.</p>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <!-- Botón para regresar arriba -->
    <div class="scroll-to-top" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </div>

    <!-- Función para subir al principio -->
    <script>
    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Mostrar el botón para subir cuando se desplaza hacia abajo
    window.onscroll = function() {
        const btn = document.querySelector('.scroll-to-top');
        if (window.scrollY > 200) { // Mostrar después de un cierto desplazamiento
            btn.style.opacity = 1;
        } else {
            btn.style.opacity = 0;
        }
    };
    </script>
</body>
</html>