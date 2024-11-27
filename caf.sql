DROP DATABASE IF EXISTS caf;

CREATE DATABASE caf;

USE caf;

CREATE TABLE usuario(
    usuario_id int primary key auto_increment,
    usuario varchar(255) not null,
    passwd varchar(255) not null
);

CREATE TABLE cliente(
    cliente_id int primary key auto_increment,
    nombre varchar(255),
    telefono varchar(10)
);

CREATE TABLE ticket(
    ticket_id int primary key auto_increment,
    cliente_id int,
    fecha_compra date,
    fecha_entrega date,
    anticipo decimal(10,2),
    precio_total decimal(10,2),
    estado varchar(255) default 'En proceso',
    FOREIGN KEY (cliente_id) REFERENCES cliente(cliente_id)
);  

CREATE TABLE servicio(
    servicio_id int primary key auto_increment,
    nombre varchar(255),
    descripcion text,
    precio decimal(10,2)
);

CREATE TABLE servicio_ticket(
    servicio_ticket_id int primary key auto_increment,
    ticket_id int,
    servicio_id int,
    articulo varchar(255),
    imagen varchar(2000),
    comentario text,
    FOREIGN KEY (ticket_id) references ticket(ticket_id),
    FOREIGN KEY (servicio_id) references servicio(servicio_id)
);

CREATE TABLE cotizaciones(
    cotizacion_id int primary key auto_increment,
    nombre varchar(255),
    apellidos varchar(255),
    telefono varchar(10),
    comentarios text,
    imagen varchar(255),
    fecha date
);

INSERT INTO servicio(nombre, descripcion, precio) VALUES 
("Exterior","Limpieza zona exterior + Cinta + Media suela",150),
("Completa","Limpieza exterior + Interior + Cintas + Media suela + Desodorante + Desinfección con ósmosis",200),
("Exterior","Limpieza completa + Hidratación de piel + Retoque en detalles + Limpieza de suela simple + Resanado",250),
("Infantil","Limpieza exterior + Interior + Cintas + Media suela + Desodorante + Desinfección con ósmosis",60),
("Boleado","Hidratación de piel + Boleado + Limpieza de suela simple",60),
("Gorras","Limpieza Completa",60),
("Mochilas - CH","Limpieza zona exterior + Interior",170),
("Mochilas - M/G","Limpieza zona exterior + Interior",250),
("Bolsas - CH","Limpieza a detalle + Hidratación de piel",170),
("Bolsas - M/G","Limpieza a detalle + Hidratación de piel",250),
("Resanado","Resanado en resgaduras en piel + retoque de pintura en detalles (No incluye limpieza)",150),
("Blanqueamiento","Desoxidación QUÍMICA en media suela",120),
("Retoque en Boost","Blanqueamiento en boost con retoque de color. (Duración aproximada 1 mes)",120),
("Retoque1","Detallado en raspones",80),
("Retoque2","Retoque/Renovación de color",180),
("Retoque3","Cambio total de color",200),
("Reparacion1","Costuras",80),
("Reparacion2","Pegado de suela completa",170),
("Reparacion3","Costura de suela completa",200),
("Reparacion4","Cambio de cierres",120),
("Reparacion5","Velcro",90),
("Reparacion6","Hormado",150),
("Reparacion7","Tapas de tacón",150),
("Reparacion8","Tapas de zapato/bota",200),
("Reparacion9","Repelente contra agua",120);


INSERT INTO cliente(nombre, telefono) VALUES
("Arturo Vargas","1234567891"),
("Juan Perez","1234567892"),
("Pedro Lopez","1234567893"),
("Maria Hernandez","1234567894"),
("Josefina Ramirez","1234567895"),
("Ricardo Rodriguez","1234567896"),
("Luisa Martinez","1234567897"),
("Fernando Gonzalez","1234567898"),
("Sofia Jimenez","1234567899"),
("Alejandro Garcia","1234567800");

INSERT INTO ticket (cliente_id, fecha_compra, fecha_entrega, anticipo, precio_total) VALUES
(1, CURDATE(), CURDATE() + INTERVAL 3 DAY, 50.00, 150.00),
(2, CURDATE(), CURDATE() + INTERVAL 4 DAY, 100.00, 150.00),
(3, CURDATE(), CURDATE() + INTERVAL 3 DAY, 30.00, 200.00),
(4, CURDATE(), CURDATE() + INTERVAL 4 DAY, 75.00, 170.00);

INSERT INTO servicio_ticket (ticket_id, servicio_id, articulo, imagen, comentario) VALUES
(1, 3, 'Zapatos', 'imagenes/tickets/imagen_zapatos.jpg', 'Resanado incluido'),
(2, 11, 'Zapatos de cuero', 'imagenes/tickets/imagen_cuero.jpg', 'Resanado en piel'),
(3, 6, 'Gorra deportiva', 'imagenes/tickets/imagen_gorra.jpg', 'Limpieza completa'),
(4, 9, 'Bolsa pequeña', 'imagenes/tickets/imagen_bolsa.jpg', 'Limpieza a detalle e hidratación');


insert into usuario(usuario, passwd) values ('admin', 'admin');