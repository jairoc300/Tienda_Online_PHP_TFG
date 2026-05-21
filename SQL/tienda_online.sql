CREATE DATABASE tienda_online;
SET NAMES UTF8;
CREATE DATABASE IF NOT EXISTS tienda_online;
USE tienda_online;

DROP TABLE IF EXISTS usuarios;
CREATE TABLE IF NOT EXISTS usuarios(
    id int(255) auto_increment not null,
    nombre varchar(100) not null,
    apellidos varchar(255),
    email varchar(255) not null,
    password varchar(255) not null,
    rol varchar(20),
    CONSTRAINT pk_usuarios PRIMARY KEY(id),
    CONSTRAINT uq_email UNIQUE(email)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS categorias;
CREATE TABLE IF NOT EXISTS categorias(
    id int(255) auto_increment not null,
    nombre varchar(100) not null,
    CONSTRAINT pk_categorias PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS productos;
CREATE TABLE IF NOT EXISTS productos(
    id int(255) auto_increment not null,
    categoria_id int(255) not null,
    nombre varchar(100) not null,
    descripcion text,
    precio float(100,2) not null,
    stock int(255) not null,
    oferta varchar(2),
    fecha date not null,
    imagen varchar(255),
    CONSTRAINT pk_productos PRIMARY KEY(id),
    CONSTRAINT fk_producto_categoria FOREIGN KEY(categoria_id) REFERENCES categorias(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS pedidos;
CREATE TABLE IF NOT EXISTS pedidos(
    id int(255) auto_increment not null,
    usuario_id int(255) not null,
    provincia varchar(100) not null,
    localidad varchar(100) not null,
    direccion varchar(255) not null,
    coste float(200,2) not null,
    estado varchar(20) not null,
    fecha date,
    hora time,
    CONSTRAINT pk_pedidos PRIMARY KEY(id),
    CONSTRAINT fk_pedido_usuario FOREIGN KEY(usuario_id) REFERENCES usuarios(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS lineas_pedidos;
CREATE TABLE IF NOT EXISTS lineas_pedidos(
    id int(255) auto_increment not null,
    pedido_id int(255) not null,
    producto_id int(255) not null,
    unidades int(255) not null,
    CONSTRAINT pk_lineas_pedidos PRIMARY KEY(id),
    CONSTRAINT fk_linea_pedido FOREIGN KEY(pedido_id) REFERENCES pedidos(id),
    CONSTRAINT fk_linea_producto FOREIGN KEY(producto_id) REFERENCES productos(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

ALTER TABLE lineas_pedidos
DROP FOREIGN KEY fk_linea_producto,
ADD FOREIGN KEY (producto_id) REFERENCES productos (id) ON DELETE CASCADE;

ALTER TABLE productos
DROP FOREIGN KEY fk_producto_categoria,
ADD FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE;

-- Insertando nuevas categorías
INSERT INTO categorias (nombre) VALUES
('Monitores'),
('Portátiles'),
('Teclados'),
('Ratones');

-- Insertando productos de ejemplo
-- Monitores
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES
(1, 'Monitor LG 24MP59G', 'Monitor LG de 24 pulgadas con tecnología IPS para gaming', 200.00, 50, NULL, CURDATE(), 'lg_24mp59g.jpg'),
(1, 'Monitor Samsung Curvo', 'Monitor curvo de Samsung de 27 pulgadas', 300.00, 30, '10%', CURDATE(), 'samsung_curvo.jpg'),
(1, 'Monitor Dell Ultrasharp', 'Monitor Dell de 32 pulgadas Ultrasharp con resolución 4K', 450.00, 20, NULL, CURDATE(), 'dell_ultrasharp.jpg'),
(1, 'Monitor Asus ProArt', 'Monitor Asus ProArt para profesionales de la creatividad', 600.00, 15, '5%', CURDATE(), 'asus_proart.jpg');

-- Portátiles
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES
(2, 'Portátil HP Pavilion 15', 'Portátil HP Pavilion de 15.6 pulgadas ideal para trabajo y juego', 700.00, 40, NULL, CURDATE(), 'hp_pavilion15.jpg'),
(2, 'MacBook Pro 16', 'Apple MacBook Pro de 16 pulgadas con chip M1', 2400.00, 30, NULL, CURDATE(), 'macbook_pro16.jpg'),
(2, 'Dell XPS 13', 'Dell XPS 13 ultraligero y potente con pantalla 4K', 1000.00, 25, '5%', CURDATE(), 'dell_xps13.jpg'),
(2, 'Lenovo ThinkPad X1 Carbon', 'Lenovo ThinkPad X1 Carbon, ultraligero y robusto', 1500.00, 20, NULL, CURDATE(), 'thinkpad_x1carbon.jpg');

-- Teclados
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES
(3, 'Teclado Mecánico Corsair K95', 'Teclado mecánico Corsair K95 RGB Platinum', 170.00, 50, '10%', CURDATE(), 'corsair_k95.jpg'),
(3, 'Teclado Logitech K380', 'Teclado Logitech K380 multi-dispositivo Bluetooth', 40.00, 60, NULL, CURDATE(), 'logitech_k380.jpg'),
(3, 'Teclado Razer BlackWidow', 'Teclado mecánico Razer BlackWidow Elite', 130.00, 40, NULL, CURDATE(), 'razer_blackwidow.jpg'),
(3, 'Teclado Apple Magic Keyboard', 'Apple Magic Keyboard con diseño minimalista', 90.00, 30, NULL, CURDATE(), 'apple_magic.jpg');

-- Ratones
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES
(4, 'Ratón Logitech MX Master 3', 'Ratón inalámbrico Logitech MX Master 3 para avanzada productividad', 100.00, 45, NULL, CURDATE(), 'logitech_mxmaster3.jpg'),
(4, 'Ratón Razer DeathAdder V2', 'Ratón Razer DeathAdder V2, óptimo para gaming', 50.00, 60, '15%', CURDATE(), 'razer_deathadderv2.jpg'),
(4, 'Ratón Corsair Harpoon', 'Ratón gaming Corsair Harpoon RGB Wireless', 60.00, 30, NULL, CURDATE(), 'corsair_harpoon.jpg'),
(4, 'Apple Magic Mouse 2', 'Apple Magic Mouse 2 con superficie táctil', 80.00, 40, NULL, CURDATE(), 'apple_magicmouse2.jpg');


INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES
(1, 'Monitor LG 24MP59G-P', 'Monitor LG de 24 pulgadas 1920x1080 IPS LED antirreflejos', 189.99, 45, NULL, CURDATE(), '1.jpg'),
(1, 'Monitor Samsung 27 UR590C', 'Monitor curvo Samsung 27" 4K UHD VA 3840x2160', 349.99, 32, '12%', CURDATE(), '2.jpg'),
(1, 'Monitor Dell UltraSharp U2723DE', 'Monitor Dell 27" 2560x1440 IPS profesional USB-C', 499.99, 25, NULL, CURDATE(), '3.jpg'),
(1, 'Monitor ASUS ProArt PA247CV', 'Monitor ASUS 24" 1920x1200 IPS 100% sRGB profesional', 279.99, 18, '8%', CURDATE(), '4.jpg'),
(1, 'Monitor BenQ PD2500Q', 'Monitor BenQ 25" 2560x1440 QHD IPS diseño gráfico', 449.99, 20, NULL, CURDATE(), '5.jpg'),
(1, 'Monitor LG 32UP550 4K', 'Monitor LG 32" 4K UHD IPS Thunderbolt 3 monitor profesional', 799.99, 15, '10%', CURDATE(), '6.jpg');

INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES
(2, 'HP Pavilion 15-eh1078ca', 'HP Pavilion 15.6" Ryzen 7 5700U 16GB RAM 512GB SSD', 649.99, 35, NULL, CURDATE(), '7.jpg'),
(2, 'MacBook Pro 14 M2', 'Apple MacBook Pro 14" M2 Pro 16GB 512GB gris espacial', 1999.99, 28, NULL, CURDATE(), '8.jpg'),
(2, 'Dell XPS 13 Plus 9320', 'Dell XPS 13 Plus 13.4" OLED FHD Intel Core i7 16GB 512GB', 1299.99, 22, '5%', CURDATE(), '9.jpg'),
(2, 'Lenovo ThinkPad X1 Carbon', 'Lenovo ThinkPad X1 Carbon 14" Intel i7 16GB 512GB SSD', 1449.99, 19, NULL, CURDATE(), '10.jpg'),
(2, 'ASUS VivoBook 15 F515EA', 'ASUS VivoBook 15.6" Intel i5-1135G7 8GB 512GB FHD', 499.99, 40, '15%', CURDATE(), '11.jpg'),
(2, 'Acer Aspire 5 A515-56', 'Acer Aspire 5 15.6" Intel i7 16GB 512GB NVMe SSD', 749.99, 30, NULL, CURDATE(), '12.jpg');

-- Teclados (5 productos)
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES
(3, 'Corsair K95 RGB Platinum', 'Teclado mecánico Corsair K95 RGB Platinum XT Cherry MX', 199.99, 48, '10%', CURDATE(), '13.jpg'),
(3, 'Logitech G Pro X 60', 'Teclado mecánico gaming Logitech G Pro X 60 RGB inalámbrico', 149.99, 55, NULL, CURDATE(), '14.jpg'),
(3, 'Razer BlackWidow V3 Pro', 'Teclado mecánico Razer BlackWidow V3 Pro RGB inalámbrico', 159.99, 42, '8%', CURDATE(), '15.jpg'),
(3, 'SteelSeries Apex Pro', 'Teclado mecánico SteelSeries Apex Pro OmniPoint ajustable', 199.99, 35, NULL, CURDATE(), '16.jpg'),
(3, 'Keychron K2 Pro', 'Teclado mecánico Keychron K2 Pro RGB Hot-swap Bluetooth', 99.99, 60, '12%', CURDATE(), '17.jpg');

-- Ratones (5 productos)  
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES
(4, 'Logitech MX Master 3S', 'Ratón Logitech MX Master 3S inalámbrico multi-dispositivo', 99.99, 50, NULL, CURDATE(), '18.jpg'),
(4, 'Razer DeathAdder V3', 'Ratón gaming Razer DeathAdder V3 sensor Focus Pro 30K', 69.99, 58, '15%', CURDATE(), '19.jpg'),
(4, 'Corsair M65 RGB Elite', 'Ratón gaming Corsair M65 RGB Elite 18000 DPI avanzado', 79.99, 44, NULL, CURDATE(), '20.jpg'),
(4, 'SteelSeries Prime Wireless', 'Ratón gaming SteelSeries Prime Wireless RGB inalámbrico', 79.99, 38, '10%', CURDATE(), '21.jpg'),
(4, 'Logitech G502 HERO Gaming', 'Ratón gaming Logitech G502 HERO 25600 DPI con cable', 59.99, 65, NULL, CURDATE(), '22.jpg');

-- Tabla para logs de acciones administrativas
DROP TABLE IF EXISTS admin_logs;
CREATE TABLE IF NOT EXISTS admin_logs(
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    accion VARCHAR(255) NOT NULL,
    fecha DATETIME NOT NULL,
    detalles TEXT,
    FOREIGN KEY (admin_id) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Usuarios
INSERT INTO usuarios (nombre, apellidos, email, password, rol) 
VALUES ('admin', 'admin', 'admin@gmail.com', '$2y$04$XZoQNRD0kF1kJ1Re1W2NRODn6.I5.2Z0Wp/j94vimGJ/Klubz18de', 'admin');