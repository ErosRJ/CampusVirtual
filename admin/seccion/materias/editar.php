<?php
// Incluye el archivo bd.php y maneja errores
$bd_path = "../../bd.php";
if (file_exists($bd_path)) {
    include($bd_path);

    // Verifica si la variable de conexión está definida
    if (isset($conexion)) {
        // Verificar si se ha enviado el formulario para editar una materia
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar_materia'])) {
            // Recoge el ID y el nuevo nombre de la materia del formulario
            $id_materia = $_POST['id_materia']; // Corrección aquí
            $nuevo_nombre = $_POST['nuevo_nombre'];

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
            // Llama a la función para editar la materia
            editarMateria($conexion, $id_materia, $nuevo_nombre, $pdf_path);

            // Volver a obtener la información actualizada de la materia
            $sentencia_materia = $conexion->prepare("SELECT Nombre_materia, Temario_pdf FROM materia WHERE IDmateria = ?");
            $sentencia_materia->execute([$id_materia]);
            $materia = $sentencia_materia->fetch(PDO::FETCH_ASSOC);
        }

        // Verificar si se ha proporcionado un ID de materia válido
        if (isset($_GET['id'])) {
            $id_materia = $_GET['id'];
            // Consulta para obtener la información de la materia con el ID proporcionado
            $sentencia_materia = $conexion->prepare("SELECT Nombre_materia FROM materia WHERE IDmateria = ?");
            $sentencia_materia->execute([$id_materia]);
            $materia = $sentencia_materia->fetch(PDO::FETCH_ASSOC);
        } else {
            // Si no se proporciona un ID válido, redirige de vuelta al índice de materias
            header("Location: index.php");
            exit;
        }
    } else {
        echo "Error: No se pudo establecer la conexión a la base de datos.";
    }
} else {
    echo "Error: No se encontró el archivo de la base de datos.";
}

// Función para editar una materia existente
function editarMateria($conexion, $id_materia, $nuevo_nombre, $nuevo_pdf_path = null) {
    if ($nuevo_pdf_path) { 
    // Prepara la sentencia SQL para actualizar el nombre de la materia
    $sentencia = $conexion->prepare("UPDATE materia SET Nombre_materia = ?, Temario_pdf = ? WHERE IDmateria = ?");
    // Ejecuta la sentencia con el nuevo nombre y el ID de la materia
    $sentencia->execute([$nuevo_nombre, $nuevo_pdf_path, $id_materia]);
} else {
    // Si no hay archivo nuevo, solo actualiza el nombre de la materia
    $sentencia = $conexion->prepare("UPDATE materia SET Nombre_materia = ? WHERE IDmateria = ?");
    $sentencia->execute([$nuevo_nombre, $id_materia]);
}
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Materia</title>
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
        <h1>Editar Materia</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_materia" value="<?php echo $id_materia; ?>">
            <label for="nuevo_nombre">Nuevo nombre de la materia:</label>
            <input type="text" id="nuevo_nombre" name="nuevo_nombre" value="<?php echo $materia['Nombre_materia']; ?>" required>
            
            <label for="nuevo_pdf">Subir nuevo Temario PDF (opcional):</label>
            <input type="file" id="nuevo_pdf" name="nuevo_pdf" accept="application/pdf"><br> <!-- Campo para cargar PDF -->
            
            <button type="submit" name="editar_materia">Guardar Cambios</button>
        </form>
        <!-- Botón para regresar al índice -->
        <a href="index.php" class="back-btn">Regresar</a>
    </div>
</body>
</html>
