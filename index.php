<!DOCTYPE html>
<html lang="en">
<head>
    <title>Administrador del sitio web</title>
    <!-- Meta y CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0"> <!-- Cache-Control para evitar almacenamiento -->
    <meta http-equiv="Pragma" content="no-cache"> <!-- Pragma para compatibilidad con navegadores más antiguos -->
    <!-- Bootstrap CSS v5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <!-- Contenido principal -->
    <section id="id" class="container mt-4 text-center">
        <div class="jumbotron bg-dark text-white">
            <br />
            <h2>Bienvenid@ al Administrador</h2>
            <p>Este espacio es para administrar el sitio web.</p>
            <br />
            <a href="seccion/materias/index.php" class="btn btn-primary">Ver Menú</a>
        </div>
    </section>

    <!-- Imagen decorativa -->
    <img src="imagenes/fondos/wallhaven-eovv3r_1920x1080.png" alt="Descripción de la imagen" width="1000" height="600" style="position: absolute; top: 300px; left: 170px;">

    <!-- Scripts para evitar que el usuario vuelva a la página anterior -->
    <script>
        // Este código evita que el usuario use el botón de retroceso
        history.pushState(null, null, location.href); // Agrega una entrada al historial para que el usuario no pueda regresar
        window.onpopstate = function() {
            history.go(1); // Si el usuario intenta retroceder, redirige hacia adelante
        };
    </script>
    
    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
