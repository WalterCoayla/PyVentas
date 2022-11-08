-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-11-2022 a las 17:25:25
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_ventas2022`
--

DELIMITER $$
--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `AreaCuadrado` (`Lado` INT) RETURNS INT(11) BEGIN
  return Lado*Lado;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GetNroBoletaMax` () RETURNS INT(11) NO SQL
BEGIN
Declare Contador int DEFAULT 0;
Select max(idboleta) into Contador from boletas;
return Contador;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `idBoletaCliente` (`id` INT) RETURNS INT(11) NO SQL
BEGIN
DECLARE contador int;

Select max(b.idboleta) into contador from boletas b
WHERE b.idcliente=id;

RETURN contador;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `NuevoIdBoleta` () RETURNS INT(11) BEGIN
Declare Contador int DEFAULT 0;

Select max(idboleta) into Contador from boletas;
IF (Contador IS NULL) THEN
	set Contador=0;
end if;	
return Contador+1;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `NuevoNroBoleta` () RETURNS VARCHAR(10) CHARSET latin1 BEGIN
Declare Contador int DEFAULT 0;

Select max(right(nro,8)) into Contador from boletas;
IF (Contador IS NULL) THEN
	set Contador=0;
end if;	
return concat('B-',right(concat('00000000',Contador+1),8)) ;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `NumerosALetras` (`numero` NUMERIC(19,7)) RETURNS VARCHAR(512) CHARSET latin1 BEGIN


DECLARE lcRetorno VARCHAR(512);
DECLARE lnTerna INT;
DECLARE lcMiles VARCHAR(512);
DECLARE lcCadena VARCHAR(512);
DECLARE lnUnidades INT;
DECLARE lnDecenas INT;
DECLARE lnCentenas INT;
DECLARE lnEntero INT;
DECLARE lnDecimal INT;

Set lnEntero = truncate(numero,0);
Set lnDecimal = (numero - lnEntero)*100;

IF lnEntero > 0 THEN
SET lcRetorno = '';
SET lnTerna = 1 ;

WHILE lnEntero > 0 DO

-- Recorro columna por columna
SET lcCadena = '';

SET lnUnidades = RIGHT(lnEntero,1);
SET lnEntero = LEFT(lnEntero,LENGTH(lnEntero)-1) ;

SET lnDecenas = RIGHT(lnEntero,1);
SET lnEntero = LEFT(lnEntero,LENGTH(lnEntero)-1) ;

SET lnCentenas = RIGHT(lnEntero,1);
SET lnEntero = LEFT(lnEntero,LENGTH(lnEntero)-1) ;
-- Analizo las unidades
SET lcCadena =
CASE /* UNIDADES */
WHEN lnUnidades = 1 AND lnTerna = 1 THEN CONCAT('UNO ',lcCadena)
WHEN lnUnidades = 1 AND lnTerna <> 1 THEN CONCAT('UN',lcCadena)
WHEN lnUnidades = 2 THEN CONCAT('DOS ',lcCadena)
WHEN lnUnidades = 3 THEN CONCAT('TRES ',lcCadena)
WHEN lnUnidades = 4 THEN CONCAT('CUATRO ',lcCadena)
WHEN lnUnidades = 5 THEN CONCAT('CINCO ',lcCadena)
WHEN lnUnidades = 6 THEN CONCAT('SEIS ',lcCadena)
WHEN lnUnidades = 7 THEN CONCAT('SIETE ',lcCadena)
WHEN lnUnidades = 8 THEN CONCAT('OCHO ',lcCadena)
WHEN lnUnidades = 9 THEN CONCAT('NUEVE ',lcCadena)
ELSE lcCadena
END ;/* UNIDADES */

-- Analizo las decenas
SET lcCadena =
CASE /* DECENAS */
WHEN lnDecenas = 1 THEN
CASE lnUnidades
WHEN 0 THEN 'DIEZ '
WHEN 1 THEN 'ONCE '
WHEN 2 THEN 'DOCE '
WHEN 3 THEN 'TRECE '
WHEN 4 THEN 'CATORCE '
WHEN 5 THEN 'QUINCE '
ELSE CONCAT('DIECI',lcCadena)
END
WHEN lnDecenas = 2 AND lnUnidades = 0 THEN CONCAT('VEINTE ',lcCadena)
WHEN lnDecenas = 2 AND lnUnidades <> 0 THEN CONCAT('VEINTI',lcCadena)
WHEN lnDecenas = 3 AND lnUnidades = 0 THEN CONCAT('TREINTA ',lcCadena)
WHEN lnDecenas = 3 AND lnUnidades <> 0 THEN CONCAT('TREINTA Y ',lcCadena)
WHEN lnDecenas = 4 AND lnUnidades = 0 THEN CONCAT('CUARENTA ',lcCadena)
WHEN lnDecenas = 4 AND lnUnidades <> 0 THEN CONCAT('CUARENTA Y ',lcCadena)
WHEN lnDecenas = 5 AND lnUnidades = 0 THEN CONCAT('CINCUENTA ',lcCadena)
WHEN lnDecenas = 5 AND lnUnidades <> 0 THEN CONCAT('CINCUENTA Y ',lcCadena)
WHEN lnDecenas = 6 AND lnUnidades = 0 THEN CONCAT('SESENTA ',lcCadena)
WHEN lnDecenas = 6 AND lnUnidades <> 0 THEN CONCAT('SESENTA Y ',lcCadena)
WHEN lnDecenas = 7 AND lnUnidades = 0 THEN CONCAT('SETENTA ',lcCadena)
WHEN lnDecenas = 7 AND lnUnidades <> 0 THEN CONCAT('SETENTA Y ',lcCadena)
WHEN lnDecenas = 8 AND lnUnidades = 0 THEN CONCAT('OCHENTA ',lcCadena)
WHEN lnDecenas = 8 AND lnUnidades <> 0 THEN CONCAT('OCHENTA Y ',lcCadena)
WHEN lnDecenas = 9 AND lnUnidades = 0 THEN CONCAT('NOVENTA ',lcCadena)
WHEN lnDecenas = 9 AND lnUnidades <> 0 THEN CONCAT('NOVENTA Y ',lcCadena)
ELSE lcCadena
END ;/* DECENAS */

-- Analizo las centenas
SET lcCadena =
CASE /* CENTENAS */
WHEN lnCentenas = 1 AND lnUnidades = 0 AND lnDecenas = 0 THEN CONCAT('CIEN ',lcCadena)
WHEN lnCentenas = 1 AND NOT(lnUnidades = 0 AND lnDecenas = 0) THEN CONCAT('CIENTO ',lcCadena)
WHEN lnCentenas = 2 THEN CONCAT('DOSCIENTOS ',lcCadena)
WHEN lnCentenas = 3 THEN CONCAT('TRESCIENTOS ',lcCadena)
WHEN lnCentenas = 4 THEN CONCAT('CUATROCIENTOS ',lcCadena)
WHEN lnCentenas = 5 THEN CONCAT('QUINIENTOS ',lcCadena)
WHEN lnCentenas = 6 THEN CONCAT('SEISCIENTOS ',lcCadena)
WHEN lnCentenas = 7 THEN CONCAT('SETECIENTOS ',lcCadena)
WHEN lnCentenas = 8 THEN CONCAT('OCHOCIENTOS ',lcCadena)
WHEN lnCentenas = 9 THEN CONCAT('NOVECIENTOS ',lcCadena)
ELSE lcCadena
END ;/* CENTENAS */



-- Analizo los millares
SET lcCadena =
CASE /* TERNA */
WHEN lnTerna = 1 THEN lcCadena
WHEN lnTerna = 2 AND (lnUnidades + lnDecenas + lnCentenas <> 0) THEN CONCAT(lcCadena,' MIL ')
WHEN lnTerna = 3 AND (lnUnidades + lnDecenas + lnCentenas <> 0) AND lnUnidades = 1 AND lnDecenas = 0 AND lnCentenas = 0 THEN CONCAT(lcCadena,' MILLON ')
WHEN lnTerna = 3 AND (lnUnidades + lnDecenas + lnCentenas <> 0) AND NOT (lnUnidades = 1 AND lnDecenas = 0 AND lnCentenas = 0) THEN CONCAT(lcCadena,' MILLONES ')
WHEN lnTerna = 4 AND (lnUnidades + lnDecenas + lnCentenas <> 0) THEN CONCAT(lcCadena,' MIL MILLONES ')
WHEN lnTerna = 5 AND (lnUnidades + lnDecenas + lnCentenas <> 0) AND lnUnidades = 1 AND lnDecenas = 0 AND lnCentenas = 0 THEN CONCAT(lcCadena,' BILLON ')
WHEN lnTerna = 5 AND (lnUnidades + lnDecenas + lnCentenas <> 0) AND NOT (lnUnidades = 1 AND lnDecenas = 0 AND lnCentenas = 0) THEN CONCAT(lcCadena,' BILLONES ')
WHEN lnTerna = 6 AND (lnUnidades + lnDecenas + lnCentenas <> 0) THEN CONCAT(lcCadena,' MIL BILLONES ')
WHEN lnTerna = 7 AND (lnUnidades + lnDecenas + lnCentenas <> 0) AND lnUnidades = 1 AND lnDecenas = 0 AND lnCentenas = 0 THEN CONCAT(lcCadena,' TRILLON ')
WHEN lnTerna = 7 AND (lnUnidades + lnDecenas + lnCentenas <> 0) AND NOT (lnUnidades = 1 AND lnDecenas = 0 AND lnCentenas = 0) THEN CONCAT(lcCadena,' TRILLONES ')
WHEN lnTerna = 8 AND (lnUnidades + lnDecenas + lnCentenas <> 0) THEN CONCAT(lcCadena,' MIL TRILLONES ')
ELSE ''
END ;/* MILLARES */


-- Armo el retorno columna a columna
SET lcRetorno = CONCAT(lcCadena,lcRetorno);

SET lnTerna = lnTerna + 1;

END WHILE ; /* WHILE */
ELSE
SET lcRetorno = 'CERO' ;
END IF ;

return concat(RTRIM(lcRetorno),' y ',lnDecimal,'/100') ;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

CREATE TABLE `auditoria` (
  `idauditoria` int(11) NOT NULL,
  `tabla` varchar(30) DEFAULT NULL,
  `data_new` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data_new`)),
  `data_old` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data_old`)),
  `usuario` varchar(15) DEFAULT NULL,
  `ip` varchar(32) DEFAULT NULL,
  `accion` varchar(1) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boletas`
--

CREATE TABLE `boletas` (
  `idboleta` int(11) NOT NULL,
  `nro` varchar(15) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `total` decimal(19,7) DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `boletas`
--

INSERT INTO `boletas` (`idboleta`, `nro`, `fecha`, `total`, `idcliente`) VALUES
(1, 'B-00000001', '2022-10-28 01:45:12', '7535.0000000', 1),
(2, 'B-00000002', '2022-10-28 02:19:01', '7535.0000000', 1),
(3, 'B-00000020', '2022-10-28 21:26:35', '8700.0000000', 1),
(4, 'B-00000021', '2022-10-28 21:39:53', '2615.0000000', 1),
(5, 'B-00000022', '2022-10-28 23:23:25', '10660.0000000', 1),
(6, 'B-00000023', '2022-11-05 04:52:19', '8035.0000000', 1),
(7, 'B-00000024', '2022-11-05 05:16:55', '2570.0000000', 1),
(8, 'B-00000025', '2022-11-05 05:20:18', '9906.1000000', 1),
(9, 'B-00000026', '2022-11-07 21:41:30', '147.5000000', 1),
(10, 'B-00000027', '2022-11-07 23:14:22', '94.4000000', 1);

--
-- Disparadores `boletas`
--
DELIMITER $$
CREATE TRIGGER `NuevaBoleta` BEFORE INSERT ON `boletas` FOR EACH ROW begin
	set new.idboleta=NuevoIdBoleta();
    set new.nro=NuevoNroBoleta();
    set new.fecha=now();
 end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE `ciudades` (
  `idciudad` int(11) NOT NULL,
  `nombre` varchar(80) DEFAULT NULL,
  `idpais` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ciudades`
--

INSERT INTO `ciudades` (`idciudad`, `nombre`, `idpais`) VALUES
(1, 'Moquegua', 1),
(2, 'Tacna', 1),
(3, 'Cuzco', 1),
(4, 'Brasilia', 2),
(5, 'Bogotá', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `idcliente` int(11) NOT NULL,
  `nombres` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `dni` varchar(11) DEFAULT NULL,
  `idciudad` int(11) DEFAULT NULL,
  `login` varchar(15) DEFAULT NULL,
  `pasword` varchar(100) DEFAULT NULL,
  `estado` varchar(1) DEFAULT NULL,
  `email` varchar(80) NOT NULL,
  `direccion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idcliente`, `nombres`, `apellidos`, `dni`, `idciudad`, `login`, `pasword`, `estado`, `email`, `direccion`) VALUES
(1, 'Walter', 'Coayla Mamani', '04431751', 1, 'wcoayla', '123456', '1', 'walter.coayla@gmail.com', 'ASOC. JOSE OLAYA Ñ-49'),
(2, 'Juan', 'Perez sdfasdfas', '12345678', 4, 'jperez', '102030', '0', 'jperez@gmail.com', 'CALLE MOQUEGUA 123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallesboletas`
--

CREATE TABLE `detallesboletas` (
  `iddetalle` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `pu` decimal(19,7) DEFAULT NULL,
  `subtotal` decimal(19,7) DEFAULT NULL,
  `idboleta` int(11) DEFAULT NULL,
  `idproducto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detallesboletas`
--

INSERT INTO `detallesboletas` (`iddetalle`, `cantidad`, `pu`, `subtotal`, `idboleta`, `idproducto`) VALUES
(6, 3, '2500.0000000', '7500.0000000', 1, 2),
(7, 1, '35.0000000', '35.0000000', 1, 3),
(8, 3, '2500.0000000', '7500.0000000', 2, 2),
(9, 1, '35.0000000', '35.0000000', 2, 3),
(10, 1, '8000.0000000', '8000.0000000', 3, 1),
(11, 2, '350.0000000', '700.0000000', 3, 5),
(12, 1, '2500.0000000', '2500.0000000', 4, 2),
(13, 2, '35.0000000', '70.0000000', 4, 3),
(14, 1, '45.0000000', '45.0000000', 4, 4),
(15, 1, '8000.0000000', '8000.0000000', 5, 1),
(16, 1, '2500.0000000', '2500.0000000', 5, 2),
(17, 2, '35.0000000', '70.0000000', 5, 3),
(18, 2, '45.0000000', '90.0000000', 5, 4),
(19, 1, '2500.0000000', '2500.0000000', 5, 2),
(20, 1, '35.0000000', '35.0000000', 5, 3),
(21, 1, '8000.0000000', '8000.0000000', 6, 1),
(22, 1, '35.0000000', '35.0000000', 6, 3),
(23, 1, '2500.0000000', '2500.0000000', 7, 2),
(24, 2, '35.0000000', '70.0000000', 7, 3),
(25, 1, '8000.0000000', '8000.0000000', 8, 1),
(26, 1, '45.0000000', '45.0000000', 8, 4),
(27, 1, '350.0000000', '350.0000000', 8, 5),
(28, 1, '35.0000000', '35.0000000', 9, 3),
(29, 2, '45.0000000', '90.0000000', 9, 4),
(30, 1, '35.0000000', '35.0000000', 10, 3),
(31, 1, '45.0000000', '45.0000000', 10, 4);

--
-- Disparadores `detallesboletas`
--
DELIMITER $$
CREATE TRIGGER `SetNroBoleta` BEFORE INSERT ON `detallesboletas` FOR EACH ROW begin
	set new.idboleta = GetNroBoletaMax();
 end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_producto`
--

CREATE TABLE `imagenes_producto` (
  `idimagen` int(11) NOT NULL,
  `url` varchar(50) DEFAULT NULL,
  `idproducto` int(11) DEFAULT NULL,
  `nombre` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `imagenes_producto`
--

INSERT INTO `imagenes_producto` (`idimagen`, `url`, `idproducto`, `nombre`) VALUES
(1, 'hp01.jpg', 2, 'Primera imagen'),
(2, 'hp02.jpg', 2, 'Imagen 02'),
(3, 'hp03.jpg', 2, 'imagen 3'),
(4, 'hp04.jpg', 2, 'imagen 4'),
(5, 'lenovo01.jpg', 1, 'imagen 01'),
(6, 'lenovo02.jpg', 1, 'imagen 02'),
(7, 'teclado01.jpg', 3, 'Teclado 01'),
(8, 'teclado02.jpg', 3, 'Teclado 02'),
(9, 'teclado03.jpg', 3, 'Teclado 03'),
(10, 'mouse01.jpg', 4, 'mouse 01'),
(11, 'mouse02.jpg', 4, 'mouse 02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `idmarca` int(11) NOT NULL,
  `marca` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`idmarca`, `marca`) VALUES
(1, 'HP'),
(2, 'Lenovo'),
(3, 'Dell'),
(4, 'LG');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos`
--

CREATE TABLE `modelos` (
  `idmodelo` int(11) NOT NULL,
  `modelo` varchar(80) DEFAULT NULL,
  `idmarca` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `modelos`
--

INSERT INTO `modelos` (`idmodelo`, `modelo`, `idmarca`) VALUES
(1, 'ef2507la', 1),
(2, 'dw1085la', 1),
(3, 'Vostro 3405', 3),
(4, 'Latitude 7480', 3),
(5, 'ThinkPad E15', 2),
(6, 'ThinkBook Plus', 2),
(7, '14z90p', 4),
(8, 'Gram', 4),
(9, 'Modelo 123', 1),
(10, 'Modelo 234', 1),
(11, '22233', 2),
(12, '444', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `idpais` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`idpais`, `nombre`) VALUES
(1, 'Perú'),
(2, 'Brasil'),
(3, 'Colombia'),
(4, 'Canada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE `perfiles` (
  `idperfil` int(11) NOT NULL,
  `perfil` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`idperfil`, `perfil`) VALUES
(1, 'Administrador'),
(2, 'Cliente'),
(3, 'Vendedor'),
(4, 'Almacen');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idproducto` int(11) NOT NULL,
  `nombre` varchar(80) DEFAULT NULL,
  `descripcion` varchar(8000) DEFAULT NULL,
  `pu` decimal(19,7) DEFAULT NULL,
  `idmodelo` int(11) DEFAULT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idproducto`, `nombre`, `descripcion`, `pu`, `idmodelo`, `stock`) VALUES
(1, 'Laptop - ThinkBook', 'Procesador\r\nProcesador Intel® Core™ i7-12700H de 12? Generación (E-núcleos a de hasta 3.50 GHz P-núcleos a de hasta 4.70 GHz)\r\n\r\nSistema Operativo\r\nWindows 11 Home Single Language 64\r\n\r\nPantalla\r\n17.3\" 3K (3072 x 1440), IPS, Anti Reflejante, Táctil, ', '8000.0000000', 6, 10),
(2, 'Laptop HP 15-EF2507LA', 'Rendimiento	\r\nSistema Operativo	Windows 11 Home\r\nProcesador	AMD Ryzen™ 5 5500U (velocidad de ráfaga máxima de hasta 4,0 GHz, 8 MB de caché L3, 6 núcleos y 12 subprocesos)\r\nMemoria	8 GB de RAM DDR4-3200 MHz (1 x 8 GB)\r\nAlmacenamiento	Unidad de estado ', '2500.0000000', 1, 5),
(3, 'Teclado', 'Teclado Ergonómico', '35.0000000', 2, 25),
(4, 'Ratón', 'Ratón inalámbrico', '45.0000000', 7, 0),
(5, 'Monitor', 'Monitor de 27\", pantalla LCD', '350.0000000', 6, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `login` varchar(15) DEFAULT NULL,
  `pasword` varchar(100) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `fechaalta` datetime DEFAULT NULL,
  `idperfil` int(11) DEFAULT NULL,
  `email` varchar(80) NOT NULL,
  `telefono` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nombre`, `login`, `pasword`, `estado`, `fechaalta`, `idperfil`, `email`, `telefono`) VALUES
(1, 'Walter Coayla', 'walter', '123456', 1, '2022-10-10 16:23:57', 1, 'walter.coayla@gmail.com', '990220266');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_boletas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_boletas` (
`idboleta` int(11)
,`nro` varchar(15)
,`fecha` timestamp
,`total` decimal(19,7)
,`enLetras` varchar(512)
,`idcliente` int(11)
,`cantidad` int(11)
,`pu` decimal(19,7)
,`subtotal` decimal(19,7)
,`idproducto` int(11)
,`nombreprod` varchar(80)
,`descripcion` varchar(8000)
,`idmodelo` int(11)
,`modelo` varchar(80)
,`marca` varchar(80)
,`nombrecli` varchar(50)
,`apellidocli` varchar(50)
,`direccion` varchar(100)
,`email` varchar(80)
,`dni` varchar(11)
,`nombreciudad` varchar(80)
,`nombrepais` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_ciudades`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_ciudades` (
`idciudad` int(11)
,`ciudad` varchar(80)
,`idpais` int(11)
,`pais` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_clientes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_clientes` (
`idcliente` int(11)
,`nombres` varchar(50)
,`apellidos` varchar(50)
,`nombrecliente` varchar(101)
,`dni` varchar(11)
,`idciudad` int(11)
,`ciudad` varchar(80)
,`pais` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_graf_modelos_x_marca`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_graf_modelos_x_marca` (
`marca` varchar(80)
,`cant` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_producto`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_producto` (
`idproducto` int(11)
,`nombre` varchar(80)
,`descripcion` varchar(8000)
,`pu` decimal(19,7)
,`idmodelo` int(11)
,`modelo` varchar(80)
,`idmarca` int(11)
,`marca` varchar(80)
,`stock` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_producto01`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_producto01` (
`idproducto` int(11)
,`nombre` varchar(80)
,`descripcion` varchar(8000)
,`pu` decimal(19,7)
,`idmodelo` int(11)
,`stock` int(11)
,`modelo` varchar(80)
,`idmarca` int(11)
,`marca` varchar(80)
,`url` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `v_boletas`
--
DROP TABLE IF EXISTS `v_boletas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_boletas`  AS SELECT `b`.`idboleta` AS `idboleta`, `b`.`nro` AS `nro`, `b`.`fecha` AS `fecha`, `b`.`total` AS `total`, `NumerosALetras`(`b`.`total`) AS `enLetras`, `b`.`idcliente` AS `idcliente`, `db`.`cantidad` AS `cantidad`, `db`.`pu` AS `pu`, `db`.`subtotal` AS `subtotal`, `db`.`idproducto` AS `idproducto`, `p`.`nombre` AS `nombreprod`, `p`.`descripcion` AS `descripcion`, `p`.`idmodelo` AS `idmodelo`, `m`.`modelo` AS `modelo`, `ma`.`marca` AS `marca`, `cl`.`nombres` AS `nombrecli`, `cl`.`apellidos` AS `apellidocli`, `cl`.`direccion` AS `direccion`, `cl`.`email` AS `email`, `cl`.`dni` AS `dni`, `ci`.`nombre` AS `nombreciudad`, `pa`.`nombre` AS `nombrepais` FROM (((((((`boletas` `b` join `detallesboletas` `db` on(`b`.`idboleta` = `db`.`idboleta`)) join `productos` `p` on(`db`.`idproducto` = `p`.`idproducto`)) join `modelos` `m` on(`p`.`idmodelo` = `m`.`idmodelo`)) join `marcas` `ma` on(`m`.`idmarca` = `ma`.`idmarca`)) join `clientes` `cl` on(`b`.`idcliente` = `cl`.`idcliente`)) join `ciudades` `ci` on(`ci`.`idciudad` = `cl`.`idciudad`)) join `paises` `pa` on(`ci`.`idpais` = `pa`.`idpais`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_ciudades`
--
DROP TABLE IF EXISTS `v_ciudades`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ciudades`  AS SELECT `ciudades`.`idciudad` AS `idciudad`, `ciudades`.`nombre` AS `ciudad`, `ciudades`.`idpais` AS `idpais`, `paises`.`nombre` AS `pais` FROM (`ciudades` join `paises` on(`ciudades`.`idpais` = `paises`.`idpais`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_clientes`
--
DROP TABLE IF EXISTS `v_clientes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_clientes`  AS SELECT `clientes`.`idcliente` AS `idcliente`, `clientes`.`nombres` AS `nombres`, `clientes`.`apellidos` AS `apellidos`, concat(`clientes`.`nombres`,' ',`clientes`.`apellidos`) AS `nombrecliente`, `clientes`.`dni` AS `dni`, `clientes`.`idciudad` AS `idciudad`, `ciudades`.`nombre` AS `ciudad`, `paises`.`nombre` AS `pais` FROM ((`clientes` join `ciudades` on(`clientes`.`idciudad` = `ciudades`.`idciudad`)) join `paises` on(`paises`.`idpais` = `ciudades`.`idpais`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_graf_modelos_x_marca`
--
DROP TABLE IF EXISTS `v_graf_modelos_x_marca`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_graf_modelos_x_marca`  AS SELECT `ma`.`marca` AS `marca`, count(`mo`.`idmodelo`) AS `cant` FROM (`marcas` `ma` join `modelos` `mo` on(`ma`.`idmarca` = `mo`.`idmarca`)) GROUP BY `ma`.`marca` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_producto`
--
DROP TABLE IF EXISTS `v_producto`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_producto`  AS SELECT `p`.`idproducto` AS `idproducto`, `p`.`nombre` AS `nombre`, `p`.`descripcion` AS `descripcion`, `p`.`pu` AS `pu`, `p`.`idmodelo` AS `idmodelo`, `m`.`modelo` AS `modelo`, `m`.`idmarca` AS `idmarca`, `ma`.`marca` AS `marca`, `p`.`stock` AS `stock` FROM ((`productos` `p` join `modelos` `m` on(`p`.`idmodelo` = `m`.`idmodelo`)) join `marcas` `ma` on(`ma`.`idmarca` = `m`.`idmarca`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_producto01`
--
DROP TABLE IF EXISTS `v_producto01`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_producto01`  AS SELECT `p`.`idproducto` AS `idproducto`, `p`.`nombre` AS `nombre`, `p`.`descripcion` AS `descripcion`, `p`.`pu` AS `pu`, `p`.`idmodelo` AS `idmodelo`, `p`.`stock` AS `stock`, `mo`.`modelo` AS `modelo`, `mo`.`idmarca` AS `idmarca`, `ma`.`marca` AS `marca`, `im`.`url` AS `url` FROM (((`productos` `p` join `modelos` `mo` on(`p`.`idmodelo` = `mo`.`idmodelo`)) join `marcas` `ma` on(`mo`.`idmarca` = `ma`.`idmarca`)) left join `imagenes_producto` `im` on(`p`.`idproducto` = `im`.`idproducto`)) GROUP BY `p`.`idproducto`, `p`.`nombre`, `p`.`descripcion`, `p`.`pu`, `p`.`idmodelo`, `p`.`stock`, `mo`.`modelo`, `mo`.`idmarca`, `ma`.`marca` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`idauditoria`);

--
-- Indices de la tabla `boletas`
--
ALTER TABLE `boletas`
  ADD PRIMARY KEY (`idboleta`),
  ADD KEY `Obtiene` (`idcliente`);

--
-- Indices de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD PRIMARY KEY (`idciudad`),
  ADD KEY `Tiene` (`idpais`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idcliente`),
  ADD KEY `Vive` (`idciudad`);

--
-- Indices de la tabla `detallesboletas`
--
ALTER TABLE `detallesboletas`
  ADD PRIMARY KEY (`iddetalle`),
  ADD KEY `Tiene1` (`idboleta`),
  ADD KEY `FiguraEn` (`idproducto`);

--
-- Indices de la tabla `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  ADD PRIMARY KEY (`idimagen`),
  ADD KEY `R_20` (`idproducto`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`idmarca`);

--
-- Indices de la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`idmodelo`),
  ADD KEY `Tiene2` (`idmarca`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`idpais`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`idperfil`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `Es_de` (`idmodelo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `R_19` (`idperfil`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detallesboletas`
--
ALTER TABLE `detallesboletas`
  MODIFY `iddetalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  MODIFY `idimagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `boletas`
--
ALTER TABLE `boletas`
  ADD CONSTRAINT `Obtiene` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`);

--
-- Filtros para la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD CONSTRAINT `Tiene` FOREIGN KEY (`idpais`) REFERENCES `paises` (`idpais`);

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `Vive` FOREIGN KEY (`idciudad`) REFERENCES `ciudades` (`idciudad`);

--
-- Filtros para la tabla `detallesboletas`
--
ALTER TABLE `detallesboletas`
  ADD CONSTRAINT `FiguraEn` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`),
  ADD CONSTRAINT `Tiene1` FOREIGN KEY (`idboleta`) REFERENCES `boletas` (`idboleta`);

--
-- Filtros para la tabla `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  ADD CONSTRAINT `R_20` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`);

--
-- Filtros para la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD CONSTRAINT `Tiene2` FOREIGN KEY (`idmarca`) REFERENCES `marcas` (`idmarca`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `Es_de` FOREIGN KEY (`idmodelo`) REFERENCES `modelos` (`idmodelo`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `R_19` FOREIGN KEY (`idperfil`) REFERENCES `perfiles` (`idperfil`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
