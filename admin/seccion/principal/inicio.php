<?php
// Incluye el archivo bd.php y maneja errores
$bd_path = "../../bd.php";
if (file_exists($bd_path)) {
    include($bd_path);

    // Consulta para obtener información de los cursos con imágenes
    $sentencia = $conexion->prepare("SELECT IDcurso, Nombre_curso, Nombre_profesor, Duracion_curso, Imagen_curso FROM curso WHERE Imagen_curso IS NOT NULL");
    $sentencia->execute();
    $cursos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

} else {
    die("Error: No se encontró el archivo de la base de datos.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida</title>
    <!-- Añadir CSS para diseño atractivo -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: white;
            color: black;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .welcome-title {
            font-size: 36px;
            color: black;
            margin-top: 20px;
        }

        .carousel-container {
            overflow: hidden;
            white-space: nowrap;
            margin-top: 20px;
        }

        .carousel {
            display: inline-block;
            animation: scroll 45s linear infinite; /* Ajustar velocidad y repetición */
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-100%);
            }
        }

        .carousel img {
            height: 300px;
            margin-right: 60px;
            cursor: pointer;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .carousel img:hover {
            transform: scale(1.05); /* Efecto de escala al pasar el ratón */
        }

        .modal {
            display: none; /* Ocultar por defecto */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.9); /* Fondo oscuro y opacidad */
        }

        .modal-content {
            background-color: white;
            margin: 10% auto; /* Centrar el modal */
            padding: 20px;
            border: 1px solid #888;
            border-radius: 10px;
            width: 80%;
            max-width: 600px; /* Ancho máximo */
            text-align: left; /* Alinear texto a la izquierda */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        .modal-buttons {
            margin-top: 20px;
            text-align: center; /* Centrar los botones */
        }

        .modal-buttons button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s; /* Transición para hover */
        }

        .modal-buttons button:hover {
            background-color: #0056b3; /* Cambio de color al hover */
        }
    </style>
</head>
<body>
    <div class="welcome-title">¡Bienvenid@ a Nuestro Sitio Web!</div>
    <div class="welcome-title">Descubre nuestros cursos y expande tus habilidades</div>

    <div class="carousel-container">
        <div class="carousel">
            <?php
            if (!empty($cursos)) {
                foreach ($cursos as $curso) {
                    if (!empty($curso['Imagen_curso'])) {
                        echo '<img src="' . $curso['Imagen_curso'] . '" alt="Imagen del curso" onclick="mostrarModal(' . htmlspecialchars(json_encode($curso)) . ')">';
                    }
                }
            }
            ?>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <h2 id="modalNombreCurso"></h2>
            <p id="modalNombreProfesor"></p>
            <p id="modalDuracionCurso"></p>
            <div class="modal-buttons">
                <button onclick="inscribirse()">Inscribirse</button>
                <button onclick="registrarse()">Registrarse</button>
            </div>
        </div>
    </div>

    <script>
        function mostrarModal(curso) {
            var modal = document.getElementById("myModal");
            var nombreCurso = document.getElementById("modalNombreCurso");
            var nombreProfesor = document.getElementById("modalNombreProfesor");
            var horarioCurso = document.getElementById("modalDuracionCurso");

            nombreCurso.textContent = "Nombre del Curso: " + curso.Nombre_curso;
            nombreProfesor.textContent = "Nombre del Profesor: " + curso.Nombre_profesor;
            horarioCurso.textContent = "Duración del Curso: " + curso.Duracion_curso;

            modal.style.display = "block";
        }

        function cerrarModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            var modal = document.getElementById("myModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Redirigir a páginas y cerrar el modal
        function inscribirse() {
            cerrarModal(); // Cierra el modal antes de redirigir
            window.location.href = "../../../admin/seccion/alumnos/login.php";
        }

        function registrarse() {
            cerrarModal(); // Cierra el modal antes de redirigir
            window.location.href = "../../../admin/seccion/alumnos/registro.php";
        }
    </script>
</body>
</html>
