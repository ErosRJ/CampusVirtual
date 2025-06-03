<?php
include("../../bd.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["correo"]) && isset($_POST["contrasena"])) {
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    // Consulta para verificar si existen las credenciales en la base de datos
    $stmt = $conexion->prepare("SELECT IDalumno FROM alumnos WHERE Correo = :correo AND Contraseña = :contrasena");
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':contrasena', $contrasena);
    $stmt->execute();
    $alumno_id = $stmt->fetchColumn();

    if ($alumno_id) {
        // Si las credenciales son correctas, almacenar el ID del alumno en la sesión
        $_SESSION['alumno_id'] = $alumno_id;
        header("location: ../inicio/index.php");
        exit;
    } else {
        $mensaje_error = "Correo electrónico o contraseña incorrectos";
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
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', Times, serif;
            background-image: url('../../imagenes/fondos/backiee-193314.jpg');
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <?php if(isset($mensaje_error)) echo "<div class='error-message'>$mensaje_error</div>"; ?>
            <label for="correo">Correo Electrónico</label>
            <input type="text" name="correo" id="correo" required><br>
            <label for="contrasena">Contraseña</label>
            <input type="password" name="contrasena" id="contrasena" required><br>
            <input type="submit" value="Iniciar Sesión">
        </form>
    </div>
</body>
</html>
