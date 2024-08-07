CREATE DATABASE DRUG_STORE
USE DRUG_STORE

DROP DATABASE DRUG_STORE

-- Tabla presentacion
CREATE TABLE presentacion (
    id_presentacion INT PRIMARY KEY NOT NULL,
    nombre VARCHAR(45)
);

INSERT INTO presentacion (id_presentacion, nombre) VALUES
(1, 'Tableta'),
(2, 'Cápsula'),
(3, 'Jarabe');

-- Tabla almacen
CREATE TABLE almacen (
    id_almacen INT PRIMARY KEY NOT NULL,
    nom_almacen VARCHAR(45),
    direc_almacen VARCHAR(45),
    tipo_almacen VARCHAR(45)
);

INSERT INTO almacen (id_almacen, nom_almacen, direc_almacen, tipo_almacen) VALUES
(1, 'Almacén Principal', 'Calle Lima', 'Principal'),
(2, 'Almacén Secundario', 'San Martin', 'Secundario');

-- Tabla tipo_producto
CREATE TABLE tipo_producto (
    id_tipo_producto INT PRIMARY KEY NOT NULL,
    nombre VARCHAR(45)
);

INSERT INTO tipo_producto (id_tipo_producto, nombre) VALUES
(1, 'Medicamento'),
(2, 'Cuidado personal');

-- Tabla laboratorio
CREATE TABLE laboratorio (
    id_laboratorio INT PRIMARY KEY NOT NULL,
    nombre VARCHAR(45),
    telefono INT,
    correo VARCHAR(45),
    direccion VARCHAR(45),
    ruc VARCHAR(45)
);

INSERT INTO laboratorio (id_laboratorio, nombre, telefono, correo, direccion, ruc) VALUES
(1, 'Laboratorio A', 123456789, 'labo_a@example.com', 'Calle A 111', '12345678901'),
(2, 'Laboratorio B', 987654321, 'labo_b@example.com', 'Calle B 222', '98765432109');

-- Tabla producto
CREATE TABLE producto (
    id_producto INT PRIMARY KEY NOT NULL,
    id_tipo_producto INT REFERENCES tipo_producto (id_tipo_producto) NOT NULL,
    id_presentacion INT REFERENCES presentacion (id_presentacion) NOT NULL,
    id_almacen INT REFERENCES almacen (id_almacen) NOT NULL,
    cantidad INT NOT NULL,
    descripcion VARCHAR(255),
    adicional VARCHAR(255),
    precio FLOAT
);

INSERT INTO producto (id_producto, id_tipo_producto, id_presentacion, id_almacen, id_lote, cantidad, descripcion, adicional, precio) VALUES
(1, 1, 1, 1, 50, 'Paracetamol 500mg', 'Sin receta médica', 5.99),
(2, 2, 2, 2, 30, 'Shampoo revitalizante', 'Para todo tipo de cabello', 8.50);

-- Tabla lote
CREATE TABLE lote (
    id_lote INT PRIMARY KEY NOT NULL,
    id_laboratorio INT REFERENCES laboratorio (id_laboratorio) NOT NULL,
	id_producto INT REFERENCES producto (id_producto) NOT NULL,
    stock INT,
    vencimiento DATE
);

INSERT INTO lote (id_lote, id_laboratorio, id_producto, stock, vencimiento) VALUES
(1, 1, 1, 100, '2024-12-31'),
(2, 2, 2, 50, '2025-06-30');

-- Tabla tipo_usuario
CREATE TABLE tipo_usuario (
    id_tipo_us INT PRIMARY KEY NOT NULL,
    nombre_tipo VARCHAR(45)
);

INSERT INTO tipo_usuario (id_tipo_us, nombre_tipo) VALUES
(1, 'Administrador'),
(2, 'Empleado');

-- Tabla usuario
CREATE TABLE usuario (
    id_usuario INT PRIMARY KEY NOT NULL,
    id_tipo_us INT REFERENCES tipo_usuario (id_tipo_us) NOT NULL,
    nombre_us VARCHAR(45),
    apellido_us VARCHAR(45),
    fec_nacimiento DATE,
    dni_us VARCHAR(8),
    contraseña_us VARCHAR(45),
    telefono_us VARCHAR(45),
    direccion_us VARCHAR(45),
    correo_us VARCHAR(45),
    sexo_us VARCHAR(11),
    extra_us VARCHAR(255)
);

INSERT INTO usuario (id_usuario, id_tipo_us, nombre_us, apellido_us, fec_nacimiento, dni_us, contraseña_us, telefono_us, direccion_us, correo_us, sexo_us, extra_us) VALUES
(1, 1, 'Juan', 'Pérez', '1990-05-15', '12345678', 'contraseña123', '123456789', 'Calle Principal 123', 'juan@example.com', 'Masculino', 'Detalles...'),
(2, 2, 'María', 'Gómez', '1995-08-20', '87654321', 'contraseña456', '987654321', 'Calle Secundaria 456', 'maria@example.com', 'Femenino', 'Detalles...');

-- Tabla detalle_venta
CREATE TABLE detalle_venta (
    id_det_venta INT PRIMARY KEY NOT NULL,
    id_lote INT REFERENCES lote (id_lote) NOT NULL,
    id_producto INT REFERENCES producto (id_producto) NOT NULL,
    id_laboratorio INT REFERENCES laboratorio (id_laboratorio) NOT NULL,
    det_cantidad INT NOT NULL
);

INSERT INTO detalle_venta (id_det_venta, id_lote, id_producto, id_laboratorio, det_cantidad) VALUES
(1, 1, 1, 1, 5),
(2, 2, 2, 2, 2);

-- Tabla cliente
CREATE TABLE cliente (
    id_cliente INT PRIMARY KEY NOT NULL,
    nombre VARCHAR(45),
    apellido VARCHAR(45),
    telefono VARCHAR(45),
    correo VARCHAR(45),
    direccion VARCHAR(45)
);

INSERT INTO cliente (id_cliente, nombre, apellido, telefono, correo, direccion) VALUES
(1, 'Roberto', 'García', '987654321', 'roberto@example.com', 'Calle Principal 123'),
(2, 'Laura', 'Fernández', '123456789', 'laura@example.com', 'Calle Secundaria 456');

-- Tabla venta
CREATE TABLE venta (
    id_venta INT PRIMARY KEY NOT NULL,
    id_usuario INT REFERENCES usuario (id_usuario) NOT NULL,
    id_det_venta INT REFERENCES detalle_venta (id_det_venta) NOT NULL,
    id_cliente INT REFERENCES cliente (id_cliente) NOT NULL,
    fecha DATE,
    total FLOAT
);

INSERT INTO venta (id_venta, id_usuario, id_det_venta, id_cliente, fecha, total) VALUES
(1, 1, 1, 1, '2024-05-02', 29.95),
(2, 2, 2, 2, '2024-05-01', 17.00);

-- Tabla venta_producto
CREATE TABLE venta_producto (
    id_venta_prod INT PRIMARY KEY NOT NULL,
    id_producto INT REFERENCES producto (id_producto) NOT NULL,
    id_venta INT REFERENCES venta (id_venta) NOT NULL,
    cantidad INT,
    subtotal FLOAT
);

INSERT INTO venta_producto (id_venta_prod, id_producto, id_venta, cantidad, subtotal) VALUES
(1, 1, 1, 5, 29.95),
(2, 2, 2, 2, 17.00);

-- Tabla empleado
CREATE TABLE empleado (
    id_empleado INT PRIMARY KEY NOT NULL,
	id_usuario INT REFERENCES usuario (id_usuario) NOT NULL,
    nombre VARCHAR(45),
    apellido VARCHAR(45),
    fec_contratacion DATE,
    salario FLOAT,
    cargo VARCHAR(45)    
);

INSERT INTO empleado (id_empleado, id_usuario, nombre, apellido, fec_contratacion, salario, cargo) VALUES
(1, 1, 'Carlos', 'López', '2022-01-15', 1500.00, 'Cajero'),
(2, 2, 'Ana', 'Martínez', '2023-03-20', 1800.00, 'Farmacéutico');

-- Tabla compra
CREATE TABLE compra (
    id_compra INT PRIMARY KEY NOT NULL,
    id_laboratorio INT REFERENCES laboratorio (id_laboratorio) NOT NULL,
    fecha DATE,
    total FLOAT
);

INSERT INTO compra (id_compra, id_laboratorio, fecha, total) VALUES
(1, 1, '2024-04-30', 250.00),
(2, 2, '2024-05-01', 350.00);

-- Tabla detalle_compra
CREATE TABLE detalle_compra (
    id_det_compra INT PRIMARY KEY NOT NULL,
    id_lote INT REFERENCES lote (id_lote) NOT NULL,
    id_compra INT REFERENCES compra (id_compra) NOT NULL,
    cantidad INT,
    precio_unitario FLOAT
);

INSERT INTO detalle_compra (id_det_compra, id_lote, id_compra, cantidad, precio_unitario) VALUES
(1, 1, 1, 100, 2.50),
(2, 2, 2, 50, 3.50);

-- Tabla stock
CREATE TABLE stock (
    id_stock INT PRIMARY KEY NOT NULL,
    id_almacen INT REFERENCES almacen (id_almacen) NOT NULL,
    id_producto INT REFERENCES producto (id_producto) NOT NULL,
	id_lote INT REFERENCES lote (id_lote) NOT NULL,
    cantidad INT
);

INSERT INTO stock (id_stock, id_almacen, id_producto, id_lote, cantidad) VALUES
(1, 1, 1, 1, 100),
(2, 2, 2, 2, 50);

-- Tabla movimiento_stock
CREATE TABLE movimiento_stock (
    id_movimiento INT PRIMARY KEY NOT NULL,
    id_stock INT REFERENCES stock (id_stock) NOT NULL,
    tipo_movimiento VARCHAR(45), -- "venta", "compra"
    cantidad INT,
    fecha DATE
);

INSERT INTO movimiento_stock (id_movimiento, id_stock, tipo_movimiento, cantidad, fecha) VALUES
(1, 1, 'venta', -5, '2024-05-02'),
(2, 2, 'venta', -2, '2024-05-01');