<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador del sitio web</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 20px;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-color: #e6ffe6; /* Fondo suave para el cuerpo */
            color: white; /* Color del texto principal */
        }

        .navbar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh; /* La altura de la ventana */
            width: 200px; /* Ancho de la barra */
            background-color: #333; /* Color oscuro para la barra */
            padding-top: 20px; /* Espacio en la parte superior */
            z-index: 1; /* Mantener la barra por encima del contenido */
        }

        .navbar h2 {
            color: white; /* Texto blanco para que contraste con la barra */
            text-align: center; /* Centrar el título */
            margin-bottom: 30px; /* Espacio para el título */
        }

        .navbar ul {
            list-style-type: none;
            padding: 0;
            margin: 0; /* Eliminar márgenes y padding extra */
        }

        .navbar ul li {
            padding: 10px; /* Espacio para cada elemento */
            text-align: center; /* Centrar el contenido */
        }

        .navbar ul li a {
            text-decoration: none; /* Sin subrayado */
            color: white; /* Texto blanco */
            font-size: 18px; /* Tamaño de texto */
            padding: 10px; /* Espacio interno */
            display: block; /* Hacer que el enlace ocupe todo el espacio */
            transition: background-color 0.3s; /* Suavizar el cambio de color */
        }

        .navbar ul li a:hover {
            background-color: #555; /* Color más claro en hover */
        }

    
    </style>
</head>
<body>
    <div class="navbar">
        <h2>SMART CAMPUS</h2>
        <ul>
            <li><a href="../materias/index.php"><i class="fas fa-book"></i> Materias</a></li>
            <li><a href="../profesores/index.php"><i class="fas fa-chalkboard-teacher"></i> Profesores</a></li>
            <li><a href="../estados/index.php"><i class="fas fa-tasks"></i> Estado</a></li>
            <li><a href="../cursos/index.php"><i class="fas fa-book-open"></i> Cursos</a></li>
            <li><a href="../alumnos/index.php"><i class="fas fa-users"></i> Alumnos</a></li>
            <li><a href="../../../index.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
        </ul>
    </div>
</body>
</html>
