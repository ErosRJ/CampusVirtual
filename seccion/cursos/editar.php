<?php
// Incluye el archivo bd.php y maneja errores
$bd_path = "../../bd.php";
if (file_exists($bd_path)) {
    include($bd_path);

    // Verifica si la variable de conexión está definida
    if (isset($conexion)) {
        // Verificar si se ha enviado el formulario para editar un curso
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar_curso'])) {
            // Recoge el ID y los nuevos datos del curso del formulario
            $id_curso = $_POST['id_curso'];
            $nuevo_nombre = $_POST['nuevo_nombre'];
            $nuevo_profesor = $_POST['nuevo_profesor'];
            $nueva_duracion = $_POST['nueva_duracion'];
            $nuevo_estado = $_POST['nuevo_estado'];

            // Procesar la nueva imagen si se ha subido
            $imagen_curso = '';
            if (isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['error'] == 0) {
                $directorio_imagenes = "../../imagenes/materias";
                $nombre_archivo = basename($_FILES['nueva_imagen']['name']);
                $ruta_imagen = $directorio_imagenes . $nombre_archivo;

                // Mover la imagen al directorio de destino
                if (move_uploaded_file($_FILES['nueva_imagen']['tmp_name'], $ruta_imagen)) {
                    $imagen_curso = $ruta_imagen;
                } else {
                    echo "Error al subir la imagen.";
                }
            }

            // Llama a la función para editar el curso con la imagen (si se subió)
            editarCurso($conexion, $id_curso, $nuevo_nombre, $nuevo_profesor, $nueva_duracion, $nuevo_estado, $imagen_curso);
        }

        // Verificar si se ha proporcionado un ID de curso válido
        if (isset($_GET['id'])) {
            $id_curso = $_GET['id'];
            // Consulta para obtener la información del curso con el ID proporcionado
            $sentencia_curso = $conexion->prepare("SELECT * FROM curso WHERE IDcurso = ?");
            $sentencia_curso->execute([$id_curso]);
            $curso = $sentencia_curso->fetch(PDO::FETCH_ASSOC);
        } else {
            // Si no se proporciona un ID válido, redirige al índice de cursos
            header("Location: index.php");
            exit;
        }
    } else {
        echo "Error: No se pudo establecer la conexión a la base de datos.";
    }
} else {
    echo "Error: No se encontró el archivo de la base de datos.";
}

// Función para editar un curso existente, incluida la imagen
function editarCurso($conexion, $id_curso, $nuevo_nombre, $nuevo_profesor, $nueva_duracion, $nuevo_estado, $imagen_curso) {
    if ($imagen_curso) {
        // Si hay una nueva imagen, incluye en la actualización
        $sentencia = $conexion->prepare("UPDATE curso SET Nombre_curso = ?, Nombre_profesor = ?, Duracion_curso = ?, Estado_curso = ?, Imagen_curso = ? WHERE IDcurso = ?");
        $sentencia->execute([$nuevo_nombre, $nuevo_profesor, $nueva_duracion, $nuevo_estado, $imagen_curso, $id_curso]);
    } else {
        // Si no hay nueva imagen, actualiza sin cambiar la imagen
        $sentencia = $conexion->prepare("UPDATE curso SET Nombre_curso = ?, Nombre_profesor = ?, Duracion_curso = ?, Estado_curso = ? WHERE IDcurso = ?");
        $sentencia->execute([$nuevo_nombre, $nuevo_profesor, $nueva_duracion, $nuevo_estado, $id_curso]);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Curso</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-image: url('../../imagenes/fondos/wallhaven-3k9l86_1920x1080.png');
            background-size: auto;
            background-position: center;
            font-family: "Arial", sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        label {
            font-size: 18px;
            margin-bottom: 10px;
            display: block;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }
        button {
            background-color: blue;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .back-btn {
            text-decoration: none;
            display: inline-block;
            background-color: orange;
            color: #333;
            padding: 10px 20px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .back-btn:hover {
            background-color: #bbb;
        }
    </style>
</head>
<body>
<div class="container">
        <h1>Editar Curso</h1>
        <!-- Asegúrate de usar enctype="multipart/form-data" para permitir la subida de archivos -->
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_curso" value="<?php echo $id_curso; ?>">
            <label for="nuevo_nombre">Nuevo nombre del curso:</label>
            <input type="text" id="nuevo_nombre" name="nuevo_nombre" value="<?php echo $curso['Nombre_curso']; ?>" required>
            <label para="nuevo_profesor">Nuevo profesor:</label>
            <input type="text" id="nuevo_profesor" name="nuevo_profesor" value="<?php echo $curso['Nombre_profesor']; ?>" required>
            <label para="nueva_duracion">Nueva duración:</label>
            <input type="text" id="nueva_duracion" name="nueva_duracion" value="<?php echo $curso['Duracion_curso']; ?>" required>
            <label para="nuevo_estado">Nuevo estado:</label>
            <input type="text" id="nuevo_estado" name="nuevo_estado" value="<?php echo $curso['Estado_curso']; ?>" required>
            <label para="nueva_imagen">Subir nueva imagen del curso (opcional):</label>
            <input type="file" id="nueva_imagen" name="nueva_imagen"> <!-- Permite subir una nueva imagen -->
            <button type="submit" name="editar_curso">Guardar Cambios</button>
        </form>
        <!-- Botón para regresar al índice de cursos -->
        <a href="index.php" class="back-btn">Regresar</a>
    </div>
</body>
</html>