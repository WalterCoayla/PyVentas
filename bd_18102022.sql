CREATE TABLE
    Auditoria (
        idauditoria int NOT NULL autoincrement,
        tabla VARCHAR(30) NULL,
        data_new json NULL,
        data_old json NULL,
        usuario VARCHAR(15) NULL,
        ip VARCHAR(32) NULL,
        accion VARCHAR(1) NULL,
        fecha TIMESTAMP NULL
    );

ALTER TABLE Auditoria ADD PRIMARY KEY (idauditoria);

CREATE TABLE
    Boletas (
        idboleta int NOT NULL autoincrement ,
        nro VARCHAR(15) NULL,
        fecha TIMESTAMP NULL,
        total DECIMAL(19, 7) NULL,
        idusuario int NULL
    );

ALTER TABLE Boletas ADD PRIMARY KEY (idboleta);

CREATE TABLE
    Ciudades (
        idciudad int NOT NULL autoincrement,
        nombre VARCHAR(80) NULL,
        idpais int NULL
    );

ALTER TABLE Ciudades ADD PRIMARY KEY (idciudad);

CREATE TABLE
    Clientes (
        nombres VARCHAR(50) NULL,
        apellidos VARCHAR(50) NULL,
        dni VARCHAR(11) NULL,
        idciudad int NULL,
        estado VARCHAR(1) NULL,
        idusuario int NOT NULL
    );

ALTER TABLE Clientes ADD PRIMARY KEY (idusuario);

CREATE TABLE
    DetallesBoletas (
        iddetalle int NOT NULL autoincrement ,
        cantidad int NULL,
        pu DECIMAL(19, 7) NULL,
        subtotal DECIMAL(19, 7) NULL,
        idboleta int NULL,
        idproducto int NULL
    );

ALTER TABLE DetallesBoletas ADD PRIMARY KEY (iddetalle);

CREATE TABLE
    imagenes_producto (
        idimagen int NOT NULL autoincrement ,
        url VARCHAR(50) NULL,
        idproducto int NULL,
        nombre VARCHAR(250) NULL
    );

ALTER TABLE imagenes_producto ADD PRIMARY KEY (idimagen);

CREATE TABLE
    Marcas (
        idmarca int NOT NULL autoincrement ,
        marca VARCHAR(80) NULL
    );

ALTER TABLE Marcas ADD PRIMARY KEY (idmarca);

CREATE TABLE
    Modelos (
        idmodelo int NOT NULL autoincrement ,
        modelo VARCHAR(80) NULL,
        idmarca int NULL
    );

ALTER TABLE Modelos ADD PRIMARY KEY (idmodelo);

CREATE TABLE
    Paises (
        idpais int NOT NULL autoincrement ,
        nombre VARCHAR(50) NULL
    );

ALTER TABLE Paises ADD PRIMARY KEY (idpais);

CREATE TABLE
    Perfiles (
        idperfil int NOT NULL autoincrement ,
        perfil VARCHAR(25) NULL
    );

ALTER TABLE Perfiles ADD PRIMARY KEY (idperfil);

CREATE TABLE
    Productos (
        idproducto int NOT NULL autoincrement ,
        nombre VARCHAR(80) NULL,
        descripcion VARCHAR(250) NULL,
        pu DECIMAL(19, 7) NULL,
        idmodelo int NULL,
        stock int NULL
    );

ALTER TABLE Productos ADD PRIMARY KEY (idproducto);

CREATE TABLE
    Usuarios (
        idusuario int NOT NULL autoincrement ,
        nombre VARCHAR(50) NULL,
        login VARCHAR(15) NULL,
        pasword VARCHAR(100) NULL,
        estado int NULL,
        fechaalta datetime NULL,
        idperfil int NULL,
        email VARCHAR(80) NULL,
        telefono VARCHAR(15) NULL
    );

ALTER TABLE Usuarios ADD PRIMARY KEY (idusuario);

ALTER TABLE Boletas
ADD
    CONSTRAINT R_23 FOREIGN KEY (idusuario) REFERENCES Clientes (idusuario);

ALTER TABLE Ciudades
ADD
    CONSTRAINT Tiene FOREIGN KEY (idpais) REFERENCES Paises (idpais);

ALTER TABLE Clientes
ADD
    CONSTRAINT Vive FOREIGN KEY (idciudad) REFERENCES Ciudades (idciudad);

ALTER TABLE Clientes
ADD
    CONSTRAINT R_22 FOREIGN KEY (idusuario) REFERENCES Usuarios (idusuario);

ALTER TABLE DetallesBoletas
ADD
    CONSTRAINT Tiene1 FOREIGN KEY (idboleta) REFERENCES Boletas (idboleta);

ALTER TABLE DetallesBoletas
ADD
    CONSTRAINT FiguraEn FOREIGN KEY (idproducto) REFERENCES Productos (idproducto);

ALTER TABLE imagenes_producto
ADD
    CONSTRAINT R_20 FOREIGN KEY (idproducto) REFERENCES Productos (idproducto);

ALTER TABLE Modelos
ADD
    CONSTRAINT Tiene2 FOREIGN KEY (idmarca) REFERENCES Marcas (idmarca);

ALTER TABLE Productos
ADD
    CONSTRAINT Es_de FOREIGN KEY (idmodelo) REFERENCES Modelos (idmodelo);

ALTER TABLE Usuarios
ADD
    CONSTRAINT R_19 FOREIGN KEY (idperfil) REFERENCES Perfiles (idperfil);