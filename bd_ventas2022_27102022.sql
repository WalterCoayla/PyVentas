-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2022 at 08:57 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bd_ventas2022`
--

DELIMITER $$
--
-- Functions
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

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `auditoria`
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
-- Table structure for table `boletas`
--

CREATE TABLE `boletas` (
  `idboleta` int(11) NOT NULL,
  `nro` varchar(15) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `total` decimal(19,7) DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `boletas`
--

INSERT INTO `boletas` (`idboleta`, `nro`, `fecha`, `total`, `idcliente`) VALUES
(1, 'B-00000001', '2022-10-28 01:45:12', '7535.0000000', 1);

--
-- Triggers `boletas`
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
-- Table structure for table `ciudades`
--

CREATE TABLE `ciudades` (
  `idciudad` int(11) NOT NULL,
  `nombre` varchar(80) DEFAULT NULL,
  `idpais` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ciudades`
--

INSERT INTO `ciudades` (`idciudad`, `nombre`, `idpais`) VALUES
(1, 'Moquegua', 1),
(2, 'Tacna', 1),
(3, 'Cuzco', 1),
(4, 'Brasilia', 2),
(5, 'Bogotá', 3);

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
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
  `email` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`idcliente`, `nombres`, `apellidos`, `dni`, `idciudad`, `login`, `pasword`, `estado`, `email`) VALUES
(1, 'Walter', 'Coayla', '04431751', 1, 'wcoayla', '123456', '1', 'walter.coayla@gmail.com'),
(2, 'Juan', 'Perez sdfasdfas', '12345678', 4, 'jperez', '102030', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `detallesboletas`
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
-- Dumping data for table `detallesboletas`
--

INSERT INTO `detallesboletas` (`iddetalle`, `cantidad`, `pu`, `subtotal`, `idboleta`, `idproducto`) VALUES
(6, 3, '2500.0000000', '7500.0000000', 1, 2),
(7, 1, '35.0000000', '35.0000000', 1, 3);

--
-- Triggers `detallesboletas`
--
DELIMITER $$
CREATE TRIGGER `SetNroBoleta` BEFORE INSERT ON `detallesboletas` FOR EACH ROW begin
	set new.idboleta = GetNroBoletaMax();
 end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `imagenes_producto`
--

CREATE TABLE `imagenes_producto` (
  `idimagen` int(11) NOT NULL,
  `url` varchar(50) DEFAULT NULL,
  `idproducto` int(11) DEFAULT NULL,
  `nombre` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `imagenes_producto`
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
-- Table structure for table `marcas`
--

CREATE TABLE `marcas` (
  `idmarca` int(11) NOT NULL,
  `marca` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `marcas`
--

INSERT INTO `marcas` (`idmarca`, `marca`) VALUES
(1, 'HP'),
(2, 'Lenovo'),
(3, 'Dell'),
(4, 'LG');

-- --------------------------------------------------------

--
-- Table structure for table `modelos`
--

CREATE TABLE `modelos` (
  `idmodelo` int(11) NOT NULL,
  `modelo` varchar(80) DEFAULT NULL,
  `idmarca` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modelos`
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
-- Table structure for table `paises`
--

CREATE TABLE `paises` (
  `idpais` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paises`
--

INSERT INTO `paises` (`idpais`, `nombre`) VALUES
(1, 'Perú'),
(2, 'Brasil'),
(3, 'Colombia'),
(4, 'Canada');

-- --------------------------------------------------------

--
-- Table structure for table `perfiles`
--

CREATE TABLE `perfiles` (
  `idperfil` int(11) NOT NULL,
  `perfil` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `perfiles`
--

INSERT INTO `perfiles` (`idperfil`, `perfil`) VALUES
(1, 'Administrador'),
(2, 'Cliente'),
(3, 'Vendedor'),
(4, 'Almacen');

-- --------------------------------------------------------

--
-- Table structure for table `productos`
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
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`idproducto`, `nombre`, `descripcion`, `pu`, `idmodelo`, `stock`) VALUES
(1, 'Laptop - ThinkBook', 'Procesador\r\nProcesador Intel® Core™ i7-12700H de 12? Generación (E-núcleos a de hasta 3.50 GHz P-núcleos a de hasta 4.70 GHz)\r\n\r\nSistema Operativo\r\nWindows 11 Home Single Language 64\r\n\r\nPantalla\r\n17.3\" 3K (3072 x 1440), IPS, Anti Reflejante, Táctil, ', '8000.0000000', 6, 10),
(2, 'Laptop HP 15-EF2507LA', 'Rendimiento	\r\nSistema Operativo	Windows 11 Home\r\nProcesador	AMD Ryzen™ 5 5500U (velocidad de ráfaga máxima de hasta 4,0 GHz, 8 MB de caché L3, 6 núcleos y 12 subprocesos)\r\nMemoria	8 GB de RAM DDR4-3200 MHz (1 x 8 GB)\r\nAlmacenamiento	Unidad de estado ', '2500.0000000', 1, 5),
(3, 'Teclado', 'Teclado Ergonómico', '35.0000000', 2, 25),
(4, 'Ratón', 'Ratón inalámbrico', '45.0000000', 7, 0),
(5, 'Monitor', 'Monitor de 27\", pantalla LCD', '350.0000000', 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
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
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nombre`, `login`, `pasword`, `estado`, `fechaalta`, `idperfil`, `email`, `telefono`) VALUES
(1, 'Walter Coayla', 'walter', '123456', 1, '2022-10-10 16:23:57', 1, 'walter.coayla@gmail.com', '990220266');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_ciudades`
-- (See below for the actual view)
--
CREATE TABLE `v_ciudades` (
`idciudad` int(11)
,`ciudad` varchar(80)
,`idpais` int(11)
,`pais` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_clientes`
-- (See below for the actual view)
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
-- Stand-in structure for view `v_graf_modelos_x_marca`
-- (See below for the actual view)
--
CREATE TABLE `v_graf_modelos_x_marca` (
`marca` varchar(80)
,`cant` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_producto`
-- (See below for the actual view)
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
-- Stand-in structure for view `v_producto01`
-- (See below for the actual view)
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
-- Structure for view `v_ciudades`
--
DROP TABLE IF EXISTS `v_ciudades`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ciudades`  AS SELECT `ciudades`.`idciudad` AS `idciudad`, `ciudades`.`nombre` AS `ciudad`, `ciudades`.`idpais` AS `idpais`, `paises`.`nombre` AS `pais` FROM (`ciudades` join `paises` on(`ciudades`.`idpais` = `paises`.`idpais`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_clientes`
--
DROP TABLE IF EXISTS `v_clientes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_clientes`  AS SELECT `clientes`.`idcliente` AS `idcliente`, `clientes`.`nombres` AS `nombres`, `clientes`.`apellidos` AS `apellidos`, concat(`clientes`.`nombres`,' ',`clientes`.`apellidos`) AS `nombrecliente`, `clientes`.`dni` AS `dni`, `clientes`.`idciudad` AS `idciudad`, `ciudades`.`nombre` AS `ciudad`, `paises`.`nombre` AS `pais` FROM ((`clientes` join `ciudades` on(`clientes`.`idciudad` = `ciudades`.`idciudad`)) join `paises` on(`paises`.`idpais` = `ciudades`.`idpais`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_graf_modelos_x_marca`
--
DROP TABLE IF EXISTS `v_graf_modelos_x_marca`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_graf_modelos_x_marca`  AS SELECT `ma`.`marca` AS `marca`, count(`mo`.`idmodelo`) AS `cant` FROM (`marcas` `ma` join `modelos` `mo` on(`ma`.`idmarca` = `mo`.`idmarca`)) GROUP BY `ma`.`marca` ;

-- --------------------------------------------------------

--
-- Structure for view `v_producto`
--
DROP TABLE IF EXISTS `v_producto`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_producto`  AS SELECT `p`.`idproducto` AS `idproducto`, `p`.`nombre` AS `nombre`, `p`.`descripcion` AS `descripcion`, `p`.`pu` AS `pu`, `p`.`idmodelo` AS `idmodelo`, `m`.`modelo` AS `modelo`, `m`.`idmarca` AS `idmarca`, `ma`.`marca` AS `marca`, `p`.`stock` AS `stock` FROM ((`productos` `p` join `modelos` `m` on(`p`.`idmodelo` = `m`.`idmodelo`)) join `marcas` `ma` on(`ma`.`idmarca` = `m`.`idmarca`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_producto01`
--
DROP TABLE IF EXISTS `v_producto01`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_producto01`  AS SELECT `p`.`idproducto` AS `idproducto`, `p`.`nombre` AS `nombre`, `p`.`descripcion` AS `descripcion`, `p`.`pu` AS `pu`, `p`.`idmodelo` AS `idmodelo`, `p`.`stock` AS `stock`, `mo`.`modelo` AS `modelo`, `mo`.`idmarca` AS `idmarca`, `ma`.`marca` AS `marca`, `im`.`url` AS `url` FROM (((`productos` `p` join `modelos` `mo` on(`p`.`idmodelo` = `mo`.`idmodelo`)) join `marcas` `ma` on(`mo`.`idmarca` = `ma`.`idmarca`)) left join `imagenes_producto` `im` on(`p`.`idproducto` = `im`.`idproducto`)) GROUP BY `p`.`idproducto`, `p`.`nombre`, `p`.`descripcion`, `p`.`pu`, `p`.`idmodelo`, `p`.`stock`, `mo`.`modelo`, `mo`.`idmarca`, `ma`.`marca` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`idauditoria`);

--
-- Indexes for table `boletas`
--
ALTER TABLE `boletas`
  ADD PRIMARY KEY (`idboleta`),
  ADD KEY `Obtiene` (`idcliente`);

--
-- Indexes for table `ciudades`
--
ALTER TABLE `ciudades`
  ADD PRIMARY KEY (`idciudad`),
  ADD KEY `Tiene` (`idpais`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idcliente`),
  ADD KEY `Vive` (`idciudad`);

--
-- Indexes for table `detallesboletas`
--
ALTER TABLE `detallesboletas`
  ADD PRIMARY KEY (`iddetalle`),
  ADD KEY `Tiene1` (`idboleta`),
  ADD KEY `FiguraEn` (`idproducto`);

--
-- Indexes for table `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  ADD PRIMARY KEY (`idimagen`),
  ADD KEY `R_20` (`idproducto`);

--
-- Indexes for table `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`idmarca`);

--
-- Indexes for table `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`idmodelo`),
  ADD KEY `Tiene2` (`idmarca`);

--
-- Indexes for table `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`idpais`);

--
-- Indexes for table `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`idperfil`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `Es_de` (`idmodelo`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `R_19` (`idperfil`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detallesboletas`
--
ALTER TABLE `detallesboletas`
  MODIFY `iddetalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  MODIFY `idimagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `boletas`
--
ALTER TABLE `boletas`
  ADD CONSTRAINT `Obtiene` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`);

--
-- Constraints for table `ciudades`
--
ALTER TABLE `ciudades`
  ADD CONSTRAINT `Tiene` FOREIGN KEY (`idpais`) REFERENCES `paises` (`idpais`);

--
-- Constraints for table `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `Vive` FOREIGN KEY (`idciudad`) REFERENCES `ciudades` (`idciudad`);

--
-- Constraints for table `detallesboletas`
--
ALTER TABLE `detallesboletas`
  ADD CONSTRAINT `FiguraEn` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`),
  ADD CONSTRAINT `Tiene1` FOREIGN KEY (`idboleta`) REFERENCES `boletas` (`idboleta`);

--
-- Constraints for table `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  ADD CONSTRAINT `R_20` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`);

--
-- Constraints for table `modelos`
--
ALTER TABLE `modelos`
  ADD CONSTRAINT `Tiene2` FOREIGN KEY (`idmarca`) REFERENCES `marcas` (`idmarca`);

--
-- Constraints for table `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `Es_de` FOREIGN KEY (`idmodelo`) REFERENCES `modelos` (`idmodelo`);

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `R_19` FOREIGN KEY (`idperfil`) REFERENCES `perfiles` (`idperfil`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
