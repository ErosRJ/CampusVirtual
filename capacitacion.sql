-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-05-2024 a las 03:42:06
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `capacitacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `IDalumno` int(11) NOT NULL,
  `Nombre_alumno` varchar(35) NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `Correo` varchar(25) NOT NULL,
  `Contraseña` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`IDalumno`, `Nombre_alumno`, `Telefono`, `Correo`, `Contraseña`) VALUES
(1, 'Samuel Cervantes Barceinas', '123456677', 'alan312@gmail.com', 'alan312'),
(2, 'Oscar Torres García ', '3345681200', 'oscar12@gmail.com', 'oscar117'),
(3, 'Fermín Hernández Corona  ', '4489076511', 'fermin221@gmail.com', 'fermin22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `IDcurso` int(11) NOT NULL,
  `Nombre_curso` varchar(30) NOT NULL,
  `Imagen_curso` varchar(255) NOT NULL,
  `Nombre_profesor` varchar(35) NOT NULL,
  `Duracion_curso` varchar(35) NOT NULL,
  `Estado_curso` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`IDcurso`, `Nombre_curso`, `Imagen_curso`, `Nombre_profesor`, `Duracion_curso`, `Estado_curso`) VALUES
(1, 'Fundamentos de Redes', '../../imagenes/materiasFundamentos de Redes.png', 'Samuel Castillo García ', '12 Semanas', 'En Curso'),
(2, 'Programación I', '../../imagenes/materiasProgramación I.png', 'Ismael Castillo Pérez', '12 Semanas', 'En Curso'),
(3, 'Ingeniería de Software', '../../imagenes/materiasingsoft.png', 'José Ramírez Romero', '12 Semanas', 'En Curso'),
(4, 'Programación II', '../../imagenes/materiasProgramación II.png', 'Ismael Castillo Pérez', '12 Semanas', 'En Curso'),
(5, 'Administración Gerencial', '../../imagenes/materiasadmistracion.png', 'José Ramírez Romero', '12 Semanas', 'Pendiente'),
(6, 'Introducción a las TIC`s', '../../imagenes/materiasIntroducción a las Tic`s.png', 'Luna Pérez Torres  ', '12 Semanas', 'En Curso'),
(7, 'Fundamentos de Base de Datos', '../../imagenes/materias/FBD.png', 'Patricia Rodríguez Salinas', '12 Semanas', 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `duracion`
--

CREATE TABLE `duracion` (
  `IDduracion` int(11) NOT NULL,
  `Semanas` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `duracion`
--

INSERT INTO `duracion` (`IDduracion`, `Semanas`) VALUES
(1, '12 Semanas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `IDestado` int(11) NOT NULL,
  `Estado` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`IDestado`, `Estado`) VALUES
(1, 'En Curso'),
(2, 'Pendiente'),
(3, 'Finalizado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `IDinscripcion` int(11) NOT NULL,
  `IDAlumno` int(11) NOT NULL,
  `ID_C` int(11) NOT NULL,
  `Alumno` varchar(35) NOT NULL,
  `Curso` varchar(35) NOT NULL,
  `Profesor` varchar(35) NOT NULL,
  `Ins_duracion` varchar(30) NOT NULL,
  `Ins_estado` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripcion`
--

INSERT INTO `inscripcion` (`IDinscripcion`, `IDAlumno`, `ID_C`, `Alumno`, `Curso`, `Profesor`, `Ins_duracion`, `Ins_estado`) VALUES
(2, 1, 1, 'Samuel Cervantes Barceinas', 'Fundamentos de Redes', 'Samuel Castillo García ', '12 Semanas', 'En Curso'),
(3, 2, 3, 'Oscar Torres García ', 'Ingeniería de Software', 'José Ramírez Romero', '12 Semanas', 'En Curso'),
(4, 3, 4, 'Fermín Hernández Corona  ', 'Programación II', 'Ismael Castillo Pérez', '12 Semanas', 'En Curso'),
(15, 3, 1, 'Fermín Hernández Corona  ', 'Fundamentos de Redes', 'Samuel Castillo García ', '12 Semanas', 'En Curso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia`
--

CREATE TABLE `materia` (
  `IDmateria` int(11) NOT NULL,
  `Nombre_materia` varchar(35) NOT NULL,
  `Temario_pdf` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materia`
--

INSERT INTO `materia` (`IDmateria`, `Nombre_materia`, `Temario_pdf`) VALUES
(1, 'Programación I', 'pdfs/6636ab069b483_Programación I.pdf'),
(2, 'Programación II', 'pdfs/6636c49e070b3_Programación II.pdf'),
(3, 'Fundamentos de Redes', 'pdfs/6636c4b95bf8b_Fundamentos de Redes.pdf'),
(4, 'Ingeniería de Software', 'pdfs/6636c4c8b863e_Ingeniería de Software.pdf'),
(5, 'Taller de Base de Datos', 'pdfs/6636c4da7df8c_Taller de Base de Datos.pdf'),
(6, 'Administración Gerencial', 'pdfs/6636c4eaa3b94_Administración Gerencial.pdf'),
(7, 'Fundamentos de Base de Datos', 'pdfs/6636c4faa28d7_Fundamentos de Base de Datos.pdf'),
(8, 'Introducción a las TIC`s', 'pdfs/6636c5082e0ad_Introducción a las TIC\'s.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `IDprofesor` int(11) NOT NULL,
  `Nombre_profesor` varchar(50) NOT NULL,
  `Direccion` varchar(30) NOT NULL,
  `Telefono` int(11) NOT NULL,
  `Correo` varchar(30) NOT NULL,
  `Cedula` int(7) NOT NULL,
  `Info_pdf` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`IDprofesor`, `Nombre_profesor`, `Direccion`, `Telefono`, `Correo`, `Cedula`, `Info_pdf`) VALUES
(1, 'Samuel Castillo García ', 'Lima', 1234566771, 'samuel03@gmail.com', 2257898, 'pdfs/6636d8b335b8c_Samauel.pdf'),
(2, 'Ismael Castillo Pérez', 'calle qcb', 2147483647, 'ismael09@gmail.com', 7845632, 'pdfs/663701d7b2bc7_Ismael.pdf'),
(3, 'José Ramírez Romero', 'calle pizza', 224561290, 'jose33@gmail.com', 988121, 'pdfs/6637021186fcb_José.pdf'),
(4, 'Luna Pérez Torres  ', 'Calle flores #11', 1298347600, 'luna82@gmail.com', 2209145, 'pdfs/66370233ea4f9_Luna.pdf'),
(5, 'Patricia Rodríguez Salinas', 'calle pinos #3', 459823115, 'patricia78@gmail.com', 2976452, 'pdfs/6636f00e8253c_Patricia.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `IDuser` int(11) NOT NULL,
  `Nombre_user` varchar(20) NOT NULL,
  `Contraseña_user` varchar(15) NOT NULL,
  `Clave_user` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`IDuser`, `Nombre_user`, `Contraseña_user`, `Clave_user`) VALUES
(1, 'Gerente', 'capacitacion', 'tony22');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`IDalumno`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`IDcurso`);

--
-- Indices de la tabla `duracion`
--
ALTER TABLE `duracion`
  ADD PRIMARY KEY (`IDduracion`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`IDestado`);

--
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`IDinscripcion`);

--
-- Indices de la tabla `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`IDmateria`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`IDprofesor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`IDuser`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `IDalumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `IDcurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `duracion`
--
ALTER TABLE `duracion`
  MODIFY `IDduracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `IDestado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `IDinscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `materia`
--
ALTER TABLE `materia`
  MODIFY `IDmateria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `profesor`
--
ALTER TABLE `profesor`
  MODIFY `IDprofesor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `IDuser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
