-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para bdtodolist
CREATE DATABASE IF NOT EXISTS `bdtodolist` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `bdtodolist`;

-- Volcando estructura para tabla bdtodolist.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `IDCAT` int(5) NOT NULL AUTO_INCREMENT,
  `NOMBRECAT` varchar(40) NOT NULL,
  PRIMARY KEY (`IDCAT`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bdtodolist.categorias: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` (`IDCAT`, `NOMBRECAT`) VALUES
	(1, 'Compras'),
	(2, 'Mascotas'),
	(24, 'Ejercicio'),
	(25, 'Entretenimiento'),
	(30, 'Tareas de casa');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;

-- Volcando estructura para tabla bdtodolist.tareas
CREATE TABLE IF NOT EXISTS `tareas` (
  `IDTAREA` int(5) NOT NULL AUTO_INCREMENT,
  `IDUSUARIO` int(5) NOT NULL,
  `IDCATEGORIA` int(5) NOT NULL,
  `TITULO` varchar(40) NOT NULL,
  `IMAGEN` varchar(40) NOT NULL,
  `DESCRIPCION` text NOT NULL,
  `FECHA` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `LUGAR` tinytext NOT NULL,
  `ESTADO` tinytext NOT NULL,
  PRIMARY KEY (`IDTAREA`) USING BTREE,
  KEY `IDUSUARIO` (`IDUSUARIO`),
  KEY `IDCATEGORIA` (`IDCATEGORIA`),
  CONSTRAINT `ENTRADAS_IBFK_1` FOREIGN KEY (`IDUSUARIO`) REFERENCES `usuarios` (`IDUSER`) ON UPDATE CASCADE,
  CONSTRAINT `ENTRADAS_IBFK_2` FOREIGN KEY (`IDCATEGORIA`) REFERENCES `categorias` (`IDCAT`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bdtodolist.tareas: ~8 rows (aproximadamente)
/*!40000 ALTER TABLE `tareas` DISABLE KEYS */;
INSERT INTO `tareas` (`IDTAREA`, `IDUSUARIO`, `IDCATEGORIA`, `TITULO`, `IMAGEN`, `DESCRIPCION`, `FECHA`, `LUGAR`, `ESTADO`) VALUES
	(23, 1, 30, 'Fregar', '1709836462-fila-1-columna-5.jpg', '<p>Fregar los <strong>platos</strong></p>', '2024-04-14 19:50:43', 'Casa', 'Completada'),
	(24, 1, 1, 'Ir al Supermercado', '1709836583-fila-5-columna-4.jpg', '<ol><li>Sandía</li><li>Melón</li><li>Aguacate</li></ol>', '2024-04-14 20:55:57', 'Aldi', 'Completada'),
	(33, 5, 30, 'Viaje', '1709836533-fila-4-columna-2.jpg', '<p>Ayudar a <strong>María </strong>con la planificación del <i>viaje</i></p>', '2024-04-14 19:50:46', 'Sevilla', 'Completada'),
	(35, 2, 24, 'Ir al GYM', '1709836361-fila-3-columna-3.jpg', '<p>Ir al Gimnasio con <strong>Paco</strong></p>', '2024-04-15 20:55:53', 'Gimnasio', 'Pendiente'),
	(40, 2, 25, 'Quedar', '1709836610-fila-3-columna-2.jpg', '<p>Quedar con <strong>Juan</strong></p>', '2024-04-14 19:51:01', 'Parque', 'Pendiente'),
	(54, 2, 30, 'Cocinar', '1709836430-fila-3-columna-5.jpg', '<p><i>Cocinar </i>para el <strong>Lunes</strong></p>', '2024-04-15 20:17:21', 'Cocina', 'Pendiente'),
	(66, 5, 2, 'Comida Perro', '1709836286-fila-5-columna-5.jpg', '<p>Comprar <i>comida </i>para el <strong>perro</strong></p>', '2024-04-14 19:50:53', 'Mercadona', 'Pendiente'),
	(67, 5, 30, 'Regar las plantas', '1709837412-fila-5-columna-1.jpg', '<p>Regar las <strong>plantas </strong>del <i>jardín</i></p>', '2024-04-14 19:50:56', 'Jardín', 'Pendiente');
/*!40000 ALTER TABLE `tareas` ENABLE KEYS */;

-- Volcando estructura para tabla bdtodolist.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `IDUSER` int(5) NOT NULL AUTO_INCREMENT,
  `NICK` varchar(40) NOT NULL,
  `NOMBRE` varchar(40) NOT NULL,
  `APELLIDOS` varchar(40) NOT NULL,
  `EMAIL` varchar(40) NOT NULL,
  `CONTRASENIA` varchar(40) NOT NULL,
  `AVATAR` varchar(50) NOT NULL,
  `ROL` varchar(40) NOT NULL,
  PRIMARY KEY (`IDUSER`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bdtodolist.usuarios: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`IDUSER`, `NICK`, `NOMBRE`, `APELLIDOS`, `EMAIL`, `CONTRASENIA`, `AVATAR`, `ROL`) VALUES
	(1, 'malodo', 'Maria', 'Lopez Dominguez', 'maria@gmail.com', 'maria1234', 'Perfil.jpg', 'admin'),
	(2, 'ninja', 'Antonio', 'Gonzalez', 'antonio@gmail.com', '12345', 'Perfil.jpg', 'user'),
	(5, 'pepe', 'Pepe', 'López', 'pepe@gmail.com', 'pepe1234', 'Wallpaper.jpg', 'admin'),
	(15, 'franmark', 'Fran', 'Marquez', 'fmarz@gmail.com', 'sdf', 'Fondo2.png', 'user'),
	(16, 'juanito', 'Juan', 'Pérez', 'juaniiito@gmail.com', 'juan1234', 'Fondo4.png', 'user'),
	(17, 'admin', 'Administrador', 'Admin', 'admin@gmail.com', 'admin1234', 'Wallpaper.jpg', 'admin'),
	(18, 'jc12', 'jotac', '12', 'jc12@gmail.com', 'jc121234', 'Fondo4.png', 'user');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
