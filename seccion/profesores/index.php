<?php
// Incluye el archivo bd.php y maneja errores
$bd_path = "../../bd.php";
if (file_exists($bd_path)) {
    include($bd_path);

    // Función para crear un nuevo profesor
    function crearProfesor($conexion, $nombre_profesor, $direccion, $telefono, $correo, $cedula, $info_pdf = null) {
        // Prepara la sentencia SQL para insertar el nuevo profesor
        $sentencia = $conexion->prepare("INSERT INTO profesor (Nombre_profesor, Direccion, Telefono, Correo, Cedula, Info_pdf) VALUES (?, ?, ?, ?, ?, ?)");
        // Ejecuta la sentencia con los datos del profesor proporcionados
        $sentencia->execute([$nombre_profesor, $direccion, $telefono, $correo, $cedula, $info_pdf]);
    }

    // Verifica si la variable de conexión está definida
    if (isset($conexion)) {

        // Verificar si se ha enviado el formulario para crear un nuevo profesor
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nuevo_profesor'])) {
            // Recoge los datos del profesor del formulario
            $nombre_profesor = $_POST['nombre_profesor'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $cedula = $_POST['cedula'];

            $pdf_path = null;
    if (isset($_FILES['info_pdf']) && $_FILES['info_pdf']['error'] === UPLOAD_ERR_OK) {
        $pdf = $_FILES['info_pdf'];
        $pdf_name = uniqid() . "_" . $pdf['name']; // Generar un nombre único para evitar conflictos
        $pdf_dir = 'pdfs/'; // Directorio donde se guardarán los archivos PDF
        
        if (!file_exists($pdf_dir)) {
            mkdir($pdf_dir, 0777, true); // Crea el directorio si no existe
        }
        
        $pdf_path = $pdf_dir . $pdf_name;
        if (move_uploaded_file($pdf['tmp_name'], $pdf_path)) {
            // El archivo se movió con éxito al directorio de destino
        } else {
            $pdf_path = null; // Si hubo un error al mover el archivo
        }
    }
            // Llama a la función para crear el profesor
            crearProfesor($conexion, $nombre_profesor, $direccion, $telefono, $correo, $cedula, $pdf_path);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_profesor'])) {
            $id_profesor = $_POST['id_profesor'];
            eliminarProfesor($conexion, $id_profesor);
        }

        // Consulta para obtener los profesores
        $sentencia_profesores = $conexion->prepare("SELECT IDprofesor, Nombre_profesor, Direccion, Telefono, Correo, Cedula, Info_pdf FROM `profesor`");
        $sentencia_profesores->execute();
        $lista_profesores = $sentencia_profesores->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>

<?php include('../../templates/header.php'); ?> 

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Profesores</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Estilos CSS -->
    <style>
        body {
            background-image: url('../../imagenes/fondos/wallhaven-kw1ye6_1920x1080.png'); /* Cambia la imagen de fondo */
            background-size: contain;
            background-position: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #3b3b3b; /* Cambio de color de fondo */
            color: #fff; /* Cambio de color del texto */
            display: flex;
            justify-content: center; /* Centra horizontalmente */
            align-items: center; /* Centra verticalmente */
            min-height: 100vh;
        }

        
        .header {
            font-size: 30px;
            color: #fff;
            text-align: center;
            padding: -70px;
            transform: translateX(30px);

        }
        .form-table-container {
            width: 110%;
            margin-top: 20px;
            text-align: center; /* Centra horizontalmente */
        }
        table {
            width: 90%;
            border-collapse: collapse;
            margin-top: 20px;
            transform: translateX(230px);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #4db6ac; /* Cambio de color de las líneas de la tabla */
        }

        th {
            background-color: #00cbcc; /* Cambio de color de fondo del encabezado de la tabla */
            color: #fff;
            font-size: 18px;
        }
        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1); /* Cambio de color de fondo de filas pares con transparencia */
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
            background-color: #efb810; /* Cambio de color al pasar el mouse sobre el botón */
        }
        .edit-btn {
            background-color: #004d40; /* Cambio de color del botón de edición */
            color: #fff;
        }
        .delete-btn {
            background-color: #b71c1c; /* Cambio de color del botón de eliminación */
            color: #fff;
        }
        .edit-btn:hover, .delete-btn:hover {
            background-color: #efb810; /* Cambio de color al pasar el mouse sobre los botones */
        }
        input[type="text"], button[type="submit"] {
            background-color: rgba(255, 255, 255, 0.1); /* Cambio de color de fondo del campo de texto y del botón */
            color: #fff; /* Cambio de color del texto */
            border: 1px solid #4db6ac; /* Cambio de color del borde del campo de texto y del botón */
            border-radius: 5px; /* Añade bordes redondeados */
            padding: 15px; /* Ajusta el rellado */
            margin-bottom: 10px; /* Espaciado inferior */
            width: 90%; /* Ajusta el ancho del campo de texto */
            max-width: 400px; /* Establece un ancho máximo para el campo de texto */
            font-size: 20px; /* Ajusta el tamaño del texto */
        }
        input[type="text"]::placeholder {
            color: rgba(255, 255, 255, 0.5); /* Cambio de color del marcador de posición */
        }
        input[type="text"]:focus {
            outline: none; /* Elimina el resaltado al enfocar */
        }

        .pdf-btn {
            background-color: red; /* Un color naranja para el botón */
            color: #fff; /* Texto blanco para contraste */
            padding: 10px 10px; /* Tamaño del botón */
            border-radius: 5px; /* Bordes redondeados */
            text-decoration: none; /* Eliminar subrayado del enlace */
            transition: all 0.3s; /* Efecto de transición */
        }
        
        .pdf-btn:hover {
            background-color: #ff9800; /* Color más claro al pasar el mouse */
            color: #fff; /* Mantener el texto blanco */
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Lista de Profesores</h2>
        </div>
        <!-- Formulario y tabla en un solo contenedor -->
        <div class="form-table-container">
            <!-- Formulario para agregar un nuevo profesor -->
            <div class="form-container">
                <form method="post" enctype="multipart/form-data">
                    <input type="text" id="nombre_profesor" name="nombre_profesor" placeholder="Nombre del profesor" required><br>
                    <input type="text" id="direccion" name="direccion" placeholder="Dirección" required><br>
                    <input type="text" id="telefono" name="telefono" placeholder="Teléfono" required><br>
                    <input type="text" id="correo" name="correo" placeholder="Correo" required><br>
                    <input type="text" id="cedula" name="cedula" placeholder="Cédula" required><br>
                    <input type="file" name="info_pdf" accept="application/pdf"><br>
                    <button type="submit" class="btn" name="nuevo_profesor">Crear Profesor</button>
                </form>
            </div>
            <!-- Contenedor de la tabla para centrarla y agregar desplazamiento horizontal si es necesario -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID Profesor</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Cédula</th>
                            <th>Más Información</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lista_profesores as $profesor) { ?>
                            <tr>
                                <td><?php echo $profesor['IDprofesor']; ?></td>
                                <td><?php echo $profesor['Nombre_profesor']; ?></td>
                                <td><?php echo $profesor['Direccion']; ?></td>
                                <td><?php echo $profesor['Telefono']; ?></td>
                                <td><?php echo $profesor['Correo']; ?></td>
                                <td><?php echo $profesor['Cedula']; ?></td>
                                
                                <td>
                                <?php if ($profesor['Info_pdf']) { ?>
                                    <a class="pdf-btn" href="<?php echo $profesor['Info_pdf']; ?>" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Ver PDF </a> <!-- Agregar icono y usar clase CSS -->
                                    <?php } else { ?> No disponible <?php } ?>
                                </td>

                                <td>
                                    <!-- Icono para editar profesor -->
                                    <form action="editar.php?id=<?php echo $profesor['IDprofesor']; ?>" method="post" style="display: inline;">
                                    <button type="submit" class="btn edit-btn"><i class="fas fa-edit"></i></button>
                                    </form>
                                    <!-- Icono para eliminar profesor con confirmación -->
                                    <form method="post" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este profesor?');" style="display: inline;">
                                        <input type="hidden" name="id_profesor" value="<?php echo $profesor['IDprofesor']; ?>">
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


<?php
    } else {
        echo "Error: No se pudo establecer la conexión a la base de datos.";
    }
} else {
    echo "Error: No se encontró el archivo de la base de datos.";
}
?>