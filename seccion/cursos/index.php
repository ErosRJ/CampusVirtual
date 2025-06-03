<?php
// Incluye el archivo bd.php y maneja errores
$bd_path = "../../bd.php";
if (file_exists($bd_path)) {
    include($bd_path);

    // Función para crear un nuevo curso con imagen
    function crearCurso($conexion, $nombre_materia, $nombre_profesor,$duracion, $estado, $imagen_curso) {
        // Prepara la sentencia SQL para insertar el nuevo curso
        $sentencia = $conexion->prepare("INSERT INTO curso (Nombre_curso, Nombre_profesor, Duracion_curso, Estado_curso, Imagen_curso) VALUES (?, ?, ?, ?, ?)");
        // Ejecuta la sentencia con los datos del curso proporcionados, incluida la ruta de la imagen
        $sentencia->execute([$nombre_materia, $nombre_profesor, $duracion, $estado, $imagen_curso]);
    }

    // Verifica si la variable de conexión está definida
    if (isset($conexion)) {
        // Verificar si se ha enviado el formulario para crear un nuevo curso
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nuevo_curso'])) {
            // Recoge los datos del curso del formulario
            $nombre_materia = $_POST['nombre_materia'];
            $nombre_profesor = $_POST['nombre_profesor'];
            $duracion = $_POST['duracion'];
            $estado = $_POST['estado'];

            // Procesar la imagen si se ha subido
            $imagen_curso = '';
            if (isset($_FILES['imagen_curso']) && $_FILES['imagen_curso']['error'] == 0) {
                // Definir la ruta de almacenamiento de la imagen
                $directorio_imagenes = "../../imagenes/materias/";
                $nombre_archivo = basename($_FILES['imagen_curso']['name']);
                $ruta_imagen = $directorio_imagenes . $nombre_archivo;

                // Mover la imagen subida al directorio de destino
                if (move_uploaded_file($_FILES['imagen_curso']['tmp_name'], $ruta_imagen)) {
                    $imagen_curso = $ruta_imagen;
                } else {
                    echo "Error al subir la imagen.";
                }
            }

            // Llama a la función para crear el curso con la ruta de la imagen
            crearCurso($conexion, $nombre_materia, $nombre_profesor, $duracion, $estado, $imagen_curso);
        }

        // Consulta para obtener las materias
        $sentencia_materias = $conexion->prepare("SELECT Nombre_materia FROM materia");
        $sentencia_materias->execute();
        $lista_materias = $sentencia_materias->fetchAll(PDO::FETCH_ASSOC);

        // Consulta para obtener los profesores
        $sentencia_profesores = $conexion->prepare("SELECT Nombre_profesor FROM profesor");
        $sentencia_profesores->execute();
        $lista_profesores = $sentencia_profesores->fetchAll(PDO::FETCH_ASSOC);

        // Consulta para obtener la duracion del curso
        $sentencia_duracion = $conexion->prepare("SELECT Semanas FROM duracion");
        $sentencia_duracion->execute();
        $lista_duracion = $sentencia_duracion->fetchAll(PDO::FETCH_ASSOC);

        // Consulta para obtener los estados
        $sentencia_estados = $conexion->prepare("SELECT Estado FROM estado");
        $sentencia_estados->execute();
        $lista_estados = $sentencia_estados->fetchAll(PDO::FETCH_ASSOC);

        // Consulta para obtener los cursos y su imagen
        $sentencia_cursos = $conexion->prepare("SELECT IDcurso, Nombre_curso, Nombre_profesor, Duracion_curso, Estado_curso, Imagen_curso FROM curso");
        $sentencia_cursos->execute();
        $lista_cursos = $sentencia_cursos->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "Error: No se pudo establecer la conexión a la base de datos.";
    }
} else {
    echo "Error: No se encontró el archivo de la base de datos.";
}

function eliminarCurso($conexion, $id_curso) {
    $sentencia = $conexion->prepare("DELETE FROM curso WHERE IDcurso = ?");
    $sentencia->execute([$id_curso]);
}

// Verificar si se ha enviado el formulario para eliminar un curso
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_curso'])) {
    $id_curso = $_POST['id_curso'];
    eliminarCurso($conexion, $id_curso);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Estilos CSS -->
    <style>
        body {
            background-image: url('../../imagenes/fondos/wallhaven-kw1ye6_1920x1080.png');
            background-size: contain;
            background-position: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #3b3b3b; /* Cambia el color de fondo */
            color: white; /* Cambia el color del texto */
            display: flex;
            justify-content: center; /* Centra horizontalmente */
            align-items: center; /* Centra verticalmente */
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            width: 100%; /* Agrega para que el contenedor ocupe todo el ancho disponible */
            padding: 20px;
            border-radius: 10px;
            margin-left: 200px; /* Ajusta el margen izquierdo */
            transform: translateX(-10px);
        }
        .header {
            color: white;
            text-align: center;
            padding: -70px;
            font-size: 35px;
        }
        .form-table-container {
            text-align: center; /* Centra horizontalmente */
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #4db6ac; /* Cambia el color de las líneas de la tabla */
        }
        th {
            background-color: #00cbcc; /* Cambia el color de fondo del encabezado de la tabla */
        }
        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1); /* Cambia el color de fondo de filas pares con transparencia */
        }
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }
        .btn {
            padding: 12px 20px; /* Ajusta el tamaño del botón */
            margin: 0 2px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #efb810; /* Cambia el color al pasar el mouse sobre el botón */
        }
        .edit-btn {
            background-color: #004d40; /* Cambia el color del botón de edición */
            color: #fff;
        }
        .delete-btn {
            background-color: #b71c1c; /* Cambia el color del botón de eliminación */
            color: #fff;
        }
        .edit-btn:hover, .delete-btn:hover {
            background-color: #efb810; /* Cambia el color al pasar el mouse sobre los botones */
        }

        /* Aumentar el tamaño del texto para las etiquetas */
        label {
            font-size: 20px; /* Aumentar el tamaño de la fuente para las etiquetas */
            margin-bottom: 10px;
            display: block;
        }

        /* Cambiar el tamaño del cuadro para elegir archivo */
        input[type="file"], select, input[type="text"] {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid #4db6ac;
            border-radius: 5px;
            padding: 15px; /* Mayor padding para aumentar el tamaño */
            font-size: 20px; /* Aumentar el tamaño de la fuente */
            width: 80%; /* Hacer que el ancho del campo sea total */
            margin-bottom: 15px;
        }

        input[type="text"], button[type="submit"], select {
            background-color: rgba(255, 255, 255, 0.1); /* Cambia el color de fondo del campo de texto y del botón */
            color: #fff; /* Cambia el color del texto */
            border: 1px solid #4db6ac; /* Cambia el color del borde del campo de texto y del botón */
            border-radius: 5px; /* Agrega bordes redondeados */
            padding: 15px; /* Ajusta el rellado */
            margin-bottom: 10px; /* Espaciado inferior */
            width: 90%; /* Ajusta el ancho del campo de texto */
            max-width: 400px; /* Establece un ancho máximo para el campo de texto */
            font-size: 20px; /* Ajusta el tamaño del texto */
        }
        input[type="text"]::placeholder {
            color: rgba(255, 255, 255, 0.5); /* Cambia el color del marcador de posición */
        }
        /* Nuevos estilos para opciones seleccionadas en el formulario */
        select option {
            color: #000; /* Cambia el color del texto a negro */
        }
        input[type="text"]:focus, select:focus {
            outline: none; /* Elimina el resaltado al enfocar */
        }
    </style>
</head>
<body>
<?php include('../../templates/header.php'); ?>
    <!-- Contenido principal -->
    <div class="container">
        <div class="header">
            <h2>Crear Curso</h2>
        </div>
        <div class="form-table-container">
            <div class="form-container">
                <!-- Asegúrate de permitir la subida de archivos con `enctype="multipart/form-data"` -->
                <form method="post" enctype="multipart/form-data">
                    <select id="nombre_materia" name="nombre_materia" required>
                        <option value="">Selecciona una materia</option>
                        <?php foreach ($lista_materias as $materia) { ?>
                            <option value="<?php echo $materia['Nombre_materia']; ?>"><?php echo $materia['Nombre_materia']; ?></option>
                        <?php } ?>
                    </select><br>

                    <select id="nombre_profesor" name="nombre_profesor" required>
                        <option value="">Selecciona un profesor</option>
                        <?php foreach ($lista_profesores as $profesor) { ?>
                            <option value="<?php echo $profesor['Nombre_profesor']; ?>"><?php echo $profesor['Nombre_profesor']; ?></option>
                        <?php } ?>
                    </select><br>

                    <select id="duracion" name="duracion" required>
                        <option value="">Selecciona la Duración</option>
                        <?php foreach ($lista_duracion as $duracion) { ?>
                            <option value="<?php echo $duracion['Semanas']; ?>"><?php echo $duracion['Semanas']; ?></option>
                        <?php } ?>
                    </select><br>
    
                    <select id="estado" name="estado" required>
                        <option value="">Selecciona un estado</option>
                        <?php foreach ($lista_estados as $estado) { ?>
                            <option value="<?php echo $estado['Estado']; ?>"><?php echo $estado['Estado']; ?></option>
                        <?php } ?>
                    </select><br>

                    <!-- Campo para subir la imagen del curso -->
                    <label for="imagen_curso">Subir imagen del curso:</label>
                    <input type="file" name="imagen_curso" id="imagen_curso"><br>
                    <button type="submit" class="btn" name="nuevo_curso">Crear Curso</button>
                </form>
            </div>

            <!-- Contenedor de la tabla -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>IDcurso</th>
                            <th>Nombre del Curso</th>
                            <th>Profesor</th>
                            <th>Duración</th>
                            <th>Estado</th>
                            <th>Imagen</th> <!-- Nueva columna para la imagen -->
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($lista_cursos as $curso) { ?>
                        <tr>
                            <td><?php echo $curso['IDcurso']; ?></td>
                            <td><?php echo $curso['Nombre_curso']; ?></td>
                            <td><?php echo $curso['Nombre_profesor']; ?></td>
                            <td><?php echo $curso['Duracion_curso']; ?></td>
                            <td><?php echo $curso['Estado_curso']; ?></td>
                            <!-- Mostrar la imagen si existe -->
                            <td>
                                <?php if (!empty($curso['Imagen_curso'])) { ?>
                                    <img src="<?php echo $curso['Imagen_curso']; ?>" alt="Imagen del curso" width="50" height="50"> <!-- Tamaño de imagen reducido -->
                                <?php } else { ?>
                                    Sin imagen
                                <?php } ?>
                            </td>
                            <td>
                                <!-- Iconos para acciones -->
                                <form action="editar.php?id=<?php echo $curso['IDcurso']; ?>" method="post" style="display: inline;">
                                    <button type="submit" class="btn edit-btn"><i class="fas fa-edit"></i></button>
                                </form>
                                <form method="post" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este curso?');" style="display: inline;">
                                    <input type="hidden" name="id_curso" value="<?php echo $curso['IDcurso']; ?>">
                                    <button type="submit" class="btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
