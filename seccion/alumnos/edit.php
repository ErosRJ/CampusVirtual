<?php
// Incluye el archivo bd.php y maneja errores
$bd_path = "../../bd.php";
if (file_exists($bd_path)) {
    include($bd_path);

    // Verifica si la variable de conexión está definida
    if (isset($conexion)) {
        // Verificar si se ha enviado el formulario para editar un alumno
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar_alumno'])) {
            // Recoge el ID y los nuevos datos del alumno del formulario
            $id_alumno = $_POST['id_alumno']; 
            $nuevo_nombre = $_POST['nuevo_nombre'];
            $nuevo_telefono = $_POST['nuevo_telefono'];
            $nuevo_correo = $_POST['nuevo_correo'];
            $nueva_contrasena = $_POST['nueva_contrasena'];
            
            // Llama a la función para editar el alumno
            editarAlumno($conexion, $id_alumno, $nuevo_nombre, $nuevo_telefono, $nuevo_correo, $nueva_contrasena);
        }

        // Verificar si se ha proporcionado un ID de alumno válido
        if (isset($_GET['id'])) {
            $id_alumno = $_GET['id'];
            // Consulta para obtener la información del alumno con el ID proporcionado
            $sentencia_alumno = $conexion->prepare("SELECT Nombre_alumno, Telefono, Correo, Contraseña FROM alumnos WHERE IDalumno = ?");
            $sentencia_alumno->execute([$id_alumno]);
            $alumno = $sentencia_alumno->fetch(PDO::FETCH_ASSOC);
        } else {
            // Si no se proporciona un ID válido, redirige de vuelta al índice de alumnos
            header("Location: index.php");
            exit;
        }
    } else {
        echo "Error: No se pudo establecer la conexión a la base de datos.";
    }
} else {
    echo "Error: No se encontró el archivo de la base de datos.";
}

// Función para editar un alumno existente
function editarAlumno($conexion, $id_alumno, $nuevo_nombre, $nuevo_telefono, $nuevo_correo, $nueva_contrasena) {
    // Prepara la sentencia SQL para actualizar los datos del alumno
    $sentencia = $conexion->prepare("UPDATE alumnos SET Nombre_alumno = ?, Telefono = ?, Correo = ?, Contraseña = ? WHERE IDalumno = ?");
    // Ejecuta la sentencia con los nuevos datos y el ID del alumno
    $sentencia->execute([$nuevo_nombre, $nuevo_telefono, $nuevo_correo, $nueva_contrasena, $id_alumno]);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Información</title>
    <style>
        body {
            background-image: url('../../imagenes/fondos/wallhaven-v9xl9m_1920x1200.png');
            background-size: cover;
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: transparent;
            padding: 20px;
            border-radius: 8px;
            box-shadow: none;
            color: white;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: white;
        }
        label {
            font-size: 18px;
            margin-bottom: 10px;
            display: block;
        }
        input[type="text"], input[type="password"] {
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
        button:hover {
            background-color: blue;
        }
        .back-btn {
            text-decoration: none;
            display: inline-block;
            background-color: #ccc;
            color: black;
            padding: 10px 20px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .back-btn:hover {
            background-color: cyan;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Información</h1>
        <form method="post">
            <input type="hidden" name="id_alumno" value="<?php echo $id_alumno; ?>">
            <label for="nuevo_nombre">Nuevo nombre:</label>
            <input type="text" id="nuevo_nombre" name="nuevo_nombre" value="<?php echo $alumno['Nombre_alumno']; ?>" required>
            <label for="nuevo_telefono">Nuevo teléfono:</label>
            <input type="text" id="nuevo_telefono" name="nuevo_telefono" value="<?php echo $alumno['Telefono']; ?>" required>
            <label for="nuevo_correo">Nuevo correo electrónico:</label>
            <input type="text" id="nuevo_correo" name="nuevo_correo" value="<?php echo $alumno['Correo']; ?>" required>
            <label for="nueva_contrasena">Nueva contraseña:</label>
            <input type="password" id="nueva_contrasena" name="nueva_contrasena" value="<?php echo $alumno['Contraseña']; ?>" required>
            <button type="submit" name="editar_alumno">Guardar Cambios</button>
        </form>
        <!-- Botón para regresar al índice -->
        <a href="perfil.php" class="back-btn">Regresar</a>
    </div>
</body>
</html>
