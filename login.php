<?php
include("bd.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre_usuario"]) && isset($_POST["contrasenia_usuario"]) && isset($_POST["clave_usuario"])) {
    $nombre_usuario = $_POST["nombre_usuario"];
    $contrasenia_usuario = $_POST["contrasenia_usuario"];
    $clave_usuario = $_POST["clave_usuario"];

    // Consulta para verificar si existen las credenciales en la base de datos
    $stmt = $conexion->prepare("SELECT IDuser FROM usuarios WHERE Nombre_user = :nombre_usuario AND Contraseña_user = :contrasenia_usuario AND Clave_user = :clave_usuario");
    $stmt->bindParam(':nombre_usuario', $nombre_usuario);
    $stmt->bindParam(':contrasenia_usuario', $contrasenia_usuario);
    $stmt->bindParam(':clave_usuario', $clave_usuario);
    $stmt->execute();
    $usuario_id = $stmt->fetchColumn();

    if ($usuario_id) {
        // Si las credenciales son correctas, almacenar el ID del usuario en la sesión
        $_SESSION['usuario_id'] = $usuario_id;
        header("location: index.php");
        exit;
    } else {
        $mensaje_error = "Nombre de usuario, contraseña o clave incorrectos";
    }

    // Cerrar la conexión
    $stmt = null;
    $conexion = null;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0"> <!-- Cache-Control para evitar almacenamiento -->
    <meta http-equiv="Pragma" content="no-cache"> <!-- Pragma para compatibilidad con navegadores más antiguos -->
    
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', Times, serif;
            background-image: url('imagenes/fondos/wallhaven-nkq5e1_1920x1080.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 300px;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background-color: white;
            font-size: 18px;
            color: black;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }
         /* Estilos para el botón "SAMRT CAMPUS" */
         .btn-smart-campus {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-smart-campus:hover {
            background-color: #272727;
        }
    </style>
</head>
<body>
    <!-- Botón "SAMRT CAMPUS" -->
    <a href="../index.php" class="btn-smart-campus">SMART CAMPUS</a>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <?php if(isset($mensaje_error)) echo "<div class='error-message'>$mensaje_error</div>"; ?>
            <label for="nombre_usuario">Nombre de Usuario</label>
            <input type="text" name="nombre_usuario" id="nombre_usuario" required><br>
            <label for="contrasenia_usuario">Contraseña</label>
            <input type="password" name="contrasenia_usuario" id="contrasenia_usuario" required><br>
            <label for="clave_usuario">Clave</label>
            <input type="password" name="clave_usuario" id="clave_usuario" required><br>
            <input type="submit" value="Iniciar Sesión">
        </form>
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
