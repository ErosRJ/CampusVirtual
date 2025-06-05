<?php
// Incluye el archivo bd.php y maneja errores
$bd_path = "../../bd.php";
if (file_exists($bd_path)) {
    include($bd_path);

    // Verifica si la variable de conexión está definida
    if (isset($conexion)) {
        // Consulta para obtener los datos de los alumnos
        $sentencia_alumnos = $conexion->prepare("SELECT IDalumno, Nombre_alumno, Telefono, Correo FROM alumnos");
        $sentencia_alumnos->execute();
        $lista_alumnos = $sentencia_alumnos->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "Error: No se pudo establecer la conexión a la base de datos.";
    }
} else {
    echo "Error: No se encontró el archivo de la base de datos.";
}
?>

<?php include('../../templates/header.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Alumnos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Estilos CSS -->
    <style>
        body {
            background-image: url('../../imagenes/fondos/wallhaven-kw1ye6_1920x1080.png');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #000; /* Cambia el color del texto a negro */
        }

        .container {
            max-width: 800px;
            margin: 20px auto; /* Centramos horizontalmente y agregamos espacio superior */
            margin-left: 380px; /* Desplazamos hacia la derecha */
            padding: 20px;
            border-radius: 10px; /* Redondeamos esquinas */
        }

        .header {
            background-color: #00cbcc; /* Color verde oscuro para el encabezado */
            color: #fff; /* Texto blanco */
            text-align: center;
            padding: 20px;
            border-radius: 10px 10px 0 0; /* Borde redondeado solo en la parte superior */
            transform: translateX(-100px);
        }

        h2 {
            margin: 0; /* Elimina el margen del título */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; /* Espacio superior para separar la tabla del encabezado */
            transform: translateX(-100px);
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid white; /* Borde inferior verde oscuro */
            text-align: left;
            color: #fff; /* Texto blanco */
        }

        th {
            background-color: #00cbcc; /* Color verde oscuro para el encabezado de la tabla */
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1); /* Color de fondo blanco transparente para filas pares */
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Color de fondo blanco semi-transparente al pasar el ratón */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Lista de Alumnos</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID Alumno</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista_alumnos as $alumno) { ?>
                    <tr>
                        <td><?php echo $alumno['IDalumno']; ?></td>
                        <td><?php echo $alumno['Nombre_alumno']; ?></td>
                        <td><?php echo $alumno['Telefono']; ?></td>
                        <td><?php echo $alumno['Correo']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
