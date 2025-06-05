<?php
// Incluye el archivo bd.php y maneja errores
$bd_path = "../../bd.php";
if (file_exists($bd_path)) {
    include($bd_path);

    // Verifica si la variable de conexión está definida
    if (isset($conexion)) {
        // Consulta para obtener los estados
        $sentencia_estados = $conexion->prepare("SELECT IDEstado, Estado FROM `estado`");
        $sentencia_estados->execute();
        $lista_estados = $sentencia_estados->fetchAll(PDO::FETCH_ASSOC);

        // Consulta para obtener los cursos
        $sentencia_cursos = $conexion->prepare("SELECT IDCurso, Nombre_curso, Estado_curso FROM `curso`");
        $sentencia_cursos->execute();
        $lista_cursos = $sentencia_cursos->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Lista de Cursos</title>
    <!-- Estilos CSS -->
    <style>
        body {
            background-image: url('../../imagenes/fondos/wallhaven-kw1ye6_1920x1080.png');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px; /* Borde redondeado */
            transform: translateX(50px);
        }
        .header {
            background-color: #00cbcc; 
            color: #fff; /* Texto blanco para la barra superior */
            text-align: center;
            padding: 20px;
            border-radius: 10px 10px 0 0; /* Borde redondeado solo en la parte superior */
        }
        h1 {
            font-size: 24px;
            margin: 0;
            color: white; /* Color verde para el título */
            margin-bottom: 20px; /* Espacio inferior para separar el título de la tabla */
            font-size: 35px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px; /* Borde redondeado */
            overflow: hidden;
            margin-top: 20px; /* Espacio superior para separar la tabla del título */
        }
        th, td {
            padding: 15px;
            border-bottom: 1px solid #4db6ac; /* Borde inferior verde oscuro */
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
            <h1>Lista de Estado de los Cursos</h1>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID Curso</th>
                    <th>Nombre del Curso</th>
                    <th>Estado del Curso</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista_cursos as $curso) { ?>
                    <tr>
                        <td><?php echo $curso['IDCurso']; ?></td>
                        <td><?php echo $curso['Nombre_curso']; ?></td>
                        <td><?php echo $curso['Estado_curso']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
