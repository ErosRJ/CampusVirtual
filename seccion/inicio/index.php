<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMART CAMPUS</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="admin/css/styles.css">
    <style>
        body {
            background-image: url('../../imagenes/fondos/backiee-245946-landscape.jpg');
            background-size: cover; /* Ajusta el tamaño de la imagen para que cubra toda la pantalla */
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Times New Roman', times, serif;
            margin: 0;
            padding: 0;
            font-size: 25px;
        }

        nav {
            background-color: blue; /* Cambia el color de fondo de la barra de navegación a azul */
        }

        .nav-link {
            animation: bounce 1s infinite alternate;
            color: white !important; /* Cambia el color del texto de los enlaces de navegación a blanco */
        }

        .smart-campus {
            color: white; /* Cambia el color del texto "2024 SMART CAMPUS" a negro */
        }

        @keyframes bounce {
            from {
                transform: translateY(-5px);
            }
            to {
                transform: translateY(5px);
            }
        }
        
    </style>
</head>
<body>

<!-- Sección de menú de navegación -->
<nav id="inicio" class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-laptop"></i> 
            <i class="fas fa-university"></i><span class="smart-campus"> SMART CAMPUS</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../alumnos/perfil.php">Perfil de Usuario</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../alumnos/inscripcion.php">Inscripción del curso</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../alumnos/miscursos.php">Mis cursos</a>
                </li>
                <li class="nav-item">
                    <a id="logout" class="nav-link" href="../../../index.php">Finalizar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="container-fluid p-0">
    <div class="banner-img" style="position: relative; background: url('../../imagenes/fondos/descargar2.png') center/cover no-repeat; height:500px; background-size: 50% 100%; background-position: center;">
</div>
</section>

<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>
</html>
