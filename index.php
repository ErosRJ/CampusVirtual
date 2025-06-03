<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0"> <!-- Cache-Control para evitar almacenamiento -->
    <meta http-equiv="Pragma" content="no-cache"> <!-- Pragma para compatibilidad con navegadores más antiguos -->
    <title>SMART CAMPUS</title>
    <!-- Incluye la biblioteca de iconos Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-image: url('admin/imagenes/fondos/wallhaven-rd3vgm_1920x1080.png');
            background-size: auto;
            background-position: center;
            background-repeat: repeat;
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', Times, serif;
            font-size: 25px;
        }

        .container {
            position: relative;
            width: 100%;
            min-height: 100vh;
            overflow: hidden;
        }

        .navigation {
            position: fixed;
            top: 0;
            left: 0;
            width: 150px;
            height: 100%;
            background-color: #131c46;
            color: white;
            padding: 20px;
            font-style: italic;
        }

        .navigation a {
            color: white;
            text-decoration: none;
        }

        .navigation h2 {
            color: white;
            margin-top: 0;
        }

        .navigation ul {
            list-style-type: none;
            padding: 0;
        }

        .navigation ul li {
            padding: 10px 0;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .custom-btn {
            padding: 10px 20px;
            border-radius: 10px;
            border: none;
            outline: none;
            background-color: transparent;
            color: white;
            font-size: 20px;
            text-decoration: none;
            transition: transform 0.3s;
            display: flex;
            align-items: center;
        }

        .custom-btn i {
            margin-right: 10px;
        }

        .custom-btn:hover {
            transform: scale(1.1);
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .iframe-container {
            width: 100%;
            height: 80vh;
            border: none;
            background: #fff;
            transform: translateX(-30px);
        }

        footer {
            text-align: center;
            color: white;
        }
    </style>

    <script>
        function cargarPagina(ruta) {
            var iframe = document.getElementById("iframe-contenido");
            iframe.src = ruta;
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="navigation">
            <h2>SMART CAMPUS</h2>
            <ul>
    
                <li>
                    <button class="custom-btn" onclick="cargarPagina('admin/seccion/principal/nosotros.php')">
                        <i class="fas fa-info-circle"></i> Nosotros
                    </button>
                </li>

                <li>
                    <button class="custom-btn" onclick="cargarPagina('admin/seccion/principal/equipo.php')">
                        <i class="fas fa-users"></i> Equipo
                    </button>
                </li>
                
                <li>
                    <a href="admin/login.php" class="custom-btn">
                        <i class="fas fa-cog"></i> Admin
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="content">
            <iframe id="iframe-contenido" class="iframe-container" src="admin/seccion/principal/inicio.php"></iframe>
        </div>
        
        <footer>
            <p>&copy; 2024 SMART CAMPUS, todos los derechos reservados.</p>
        </footer>
    </div>
     <!-- Scripts para evitar que el usuario vuelva a la página anterior -->
     <script>
        // Este código evita que el usuario use el botón de retroceso
        history.pushState(null, null, location.href); // Agrega una entrada al historial para que el usuario no pueda regresar
        window.onpopstate = function() {
            history.go(1); // Si el usuario intenta retroceder, redirige hacia adelante
        };
    </script>
</body>
</html>
