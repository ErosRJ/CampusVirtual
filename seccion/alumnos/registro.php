<?php
include("../../bd.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre_completo"]) && isset($_POST["telefono"]) && isset($_POST["correo"]) && isset($_POST["contrasena"])) {
    $nombre_completo = $_POST["nombre_completo"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    // Preparar la consulta para insertar datos en la tabla
    $stmt = $conexion->prepare("INSERT INTO alumnos (Nombre_alumno, Telefono, Correo, Contraseña) VALUES (:nombre_completo, :telefono, :correo, :contrasena)");
    $stmt->bindParam(':nombre_completo', $nombre_completo);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':contrasena', $contrasena);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<script>alert('Usuario registrado exitosamente');</script>";
    } else {
        echo "<script>alert('Error al registrar usuario');</script>";
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
    <title>Registro de Usuario</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', Times, serif; /* Cambio de tipo de letra */
            background-image: url('../../imagenes/fondos/wallhaven-zmvrmo_1920x1080.png'); /* Cambia la URL de la imagen de fondo */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            color: white;
        }

        .container {
            width: 100%;
            max-width: 500px;
            margin: 50px auto; /* Mueve el contenedor hacia abajo */
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px; /* Ajusta el tamaño de la fuente */
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background-color: white; /* Cambia el color de fondo a blanco */
            font-size: 18px; /* Ajusta el tamaño de la fuente */
            color: black; /* Cambia el color del texto a negro */
        }

        label {
            color: rgba(255, 255, 255, 0.8); /* Cambia el color del texto de sombra */
            font-size: 16px; /* Ajusta el tamaño del texto */
            margin-bottom: 5px; /* Espacio entre el texto y el cuadro de texto */
            display: block; /* Hace que el texto aparezca en una línea diferente */
            text-align: left; /* Alinea el texto a la izquierda */
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

        .back-button {
            background-color: transparent;
            border: 2px solid white;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
        }

        .back-button:hover {
            background-color: white;
            color: black;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registro de Usuario</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="nombre_completo">Nombre Completo</label>
            <input type="text" name="nombre_completo" id="nombre_completo" required><br>
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" id="telefono" required><br>
            <label for="correo">Correo Electrónico</label>
            <input type="email" name="correo" id="correo" required><br>
            <label for="contrasena">Contraseña</label>
            <input type="password" name="contrasena" id="contrasena" required><br>
            <input type="submit" value="Registrarse">
        </form>
    </div>
</body>
</html>
