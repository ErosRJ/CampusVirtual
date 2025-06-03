<?php
// Incluye el archivo bd.php y maneja errores
$bd_path = "../../bd.php";
if (file_exists($bd_path)) {
    include($bd_path);

    // Verifica si la variable de conexión está definida
    if (isset($conexion)) {
        // Verificar si se ha enviado el formulario para editar un profesor
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar_profesor'])) {
            // Recoge el ID y los nuevos datos del profesor del formulario
            $id_profesor = $_POST['id_profesor']; // Corrección aquí
            $nuevo_nombre = $_POST['nuevo_nombre'];
            $nueva_direccion = $_POST['nueva_direccion'];
            $nuevo_telefono = $_POST['nuevo_telefono'];
            $nuevo_correo = $_POST['nuevo_correo'];
            $nueva_cedula = $_POST['nueva_cedula'];

            $pdf_path = null;
    if (isset($_FILES['nuevo_pdf']) && $_FILES['nuevo_pdf']['error'] === UPLOAD_ERR_OK) {
        $pdf = $_FILES['nuevo_pdf'];
        $pdf_name = uniqid() . "_" . $pdf['name'];
        $pdf_dir = 'pdfs/';
        
        if (!file_exists($pdf_dir)) {
            mkdir($pdf_dir, 0777, true);
        }
        
        $pdf_path = $pdf_dir . $pdf_name;
        if (!move_uploaded_file($pdf['tmp_name'], $pdf_path)) {
            $pdf_path = null; // Si no se puede mover el archivo, ponerlo en null
        }
    }
            // Llama a la función para editar al profesor
            editarProfesor($conexion, $id_profesor, $nuevo_nombre, $nueva_direccion, $nuevo_telefono, $nuevo_correo, $nueva_cedula, $pdf_path);
        }

        // Verificar si se ha proporcionado un ID de profesor válido
        if (isset($_GET['id'])) {
            $id_profesor = $_GET['id'];
            // Consulta para obtener la información del profesor con el ID proporcionado
            $sentencia_profesor = $conexion->prepare("SELECT Nombre_profesor, Direccion, Telefono, Correo, Cedula, Info_pdf FROM profesor WHERE IDprofesor = ?");
            $sentencia_profesor->execute([$id_profesor]);
            $profesor = $sentencia_profesor->fetch(PDO::FETCH_ASSOC);
        } else {
            // Si no se proporciona un ID válido, redirige de vuelta al índice de profesores
            header("Location: index.php");
            exit;
        }
    } else {
        echo "Error: No se pudo establecer la conexión a la base de datos.";
    }
} else {
    echo "Error: No se encontró el archivo de la base de datos.";
}

// Función para editar un profesor existente
function editarProfesor($conexion, $id_profesor, $nuevo_nombre, $nueva_direccion, $nuevo_telefono, $nuevo_correo, $nueva_cedula, $nuevo_pdf_path = null) {
    // Prepara la sentencia SQL para actualizar los datos del profesor
    $sentencia = $conexion->prepare("UPDATE profesor SET Nombre_profesor = ?, Direccion = ?, Telefono = ?, Correo = ?, Cedula = ?, Info_pdf = ? WHERE IDprofesor = ?");
    // Ejecuta la sentencia con los nuevos datos y el ID del profesor
    $sentencia->execute([$nuevo_nombre, $nueva_direccion, $nuevo_telefono, $nuevo_correo, $nueva_cedula, $nuevo_pdf_path, $id_profesor]);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Profesor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-image: url('../../imagenes/fondos/wallhaven-3k9l86_1920x1080.png');
            background-size: auto;
            background-position: center;
            font-family: Arial, sans-serif;
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
        <h1>Editar Profesor</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_profesor" value="<?php echo $id_profesor; ?>">
            <label for="nuevo_nombre">Nuevo nombre del profesor:</label>
            <input type="text" id="nuevo_nombre" name="nuevo_nombre" value="<?php echo $profesor['Nombre_profesor']; ?>" required>
            <label for="nueva_direccion">Nueva dirección:</label>
            <input type="text" id="nueva_direccion" name="nueva_direccion" value="<?php echo $profesor['Direccion']; ?>" required>
            <label for="nuevo_telefono">Nuevo teléfono:</label>
            <input type="text" id="nuevo_telefono" name="nuevo_telefono" value="<?php echo $profesor['Telefono']; ?>" required>
            <label for="nuevo_correo">Nuevo correo:</label>
            <input type="text" id="nuevo_correo" name="nuevo_correo" value="<?php echo $profesor['Correo']; ?>" required>
            <label for="nueva_cedula">Nueva cédula:</label>
            <input type="text" id="nueva_cedula" name="nueva_cedula" value="<?php echo $profesor['Cedula']; ?>" required>

            <label for="nuevo_pdf">Subir nueva Información PDF (opcional):</label>
            <input type="file" id="nuevo_pdf" name="nuevo_pdf" accept="application/pdf"><br>

            <button type="submit" name="editar_profesor">Guardar Cambios</button>
        </form>
        <!-- Botón para regresar al índice -->
        <a href="index.php" class="back-btn">Regresar</a>
    </div>
</body>
</html>
