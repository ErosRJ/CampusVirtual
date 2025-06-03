<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipo e Integrantes</title>
    <style>
        body {
            background-image: url('../../imagenes/fondos/backiee-243156-landscape.jpg');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            text-align: center;
            color: white;
        }

        .team-members {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 50px;
        }

        .member {
            width: 200px;
        }

        .member img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .member-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .member-name {
            font-size: 18px;
            color: white;
        }
    </style>
</head>
<body>

<h1>Equipo Conformado por:</h1>

<div class="team-members">
    <div class="member">
        <img src="../../imagenes/equipo/b0a9cbed-9407-42ee-bba9-54a82d148b05.webp" alt="Directors">
        <div class="member-title">Scrum Master</div>
        
    <div class="member">
        <img src="../../imagenes/equipo/610131b9-f179-43ba-8f78-7d219a1d2fe6.webp" alt="Marketing Head">
        <div class="member-title">Product Manager</div>

    <div class="member">
        <img src="../../imagenes/equipo/b54864fb-1b22-4213-be63-3c3b40659e6c.webp" alt="Design Head">
        <div class="member-title">Software Developers</div>
</div>
</body>
</html>
