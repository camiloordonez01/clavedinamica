CREATE TABLE 'users'(
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(45) NULL,
    `password` VARCHAR(45) NULL,
    `first_name` VARCHAR(45) NULL,
    `last_name` VARCHAR(45) NULL,
    `email` VARCHAR(45) NULL,
    PRIMARY KEY (`id`)
);


INSERT INTO permissions (name, slug, description, created_at, updated_at) VALUES ('Navegar libros','libros.index', 'Lista y navega todos los libros del sistema', '2020-10-19 06:00:00', '2020-10-19 06:00:00');
INSERT INTO permissions (name, slug, description, created_at, updated_at) VALUES ('Ver detalle de libros','libros.show', 'Ver en detalle cada libro del sistema', '2020-10-19 06:00:00', '2020-10-19 06:00:00');
INSERT INTO permissions (name, slug, description, created_at, updated_at) VALUES ('Creacion de libros','libros.create', 'Crear cualquier libro en el sistema', '2020-10-19 06:00:00', '2020-10-19 06:00:00');
INSERT INTO permissions (name, slug, description, created_at, updated_at) VALUES ('Edicion de libros','libros.edit', 'Editar cualquier libro en el sistema', '2020-10-19 06:00:00', '2020-10-19 06:00:00');
INSERT INTO permissions (name, slug, description, created_at, updated_at) VALUES ('Eliminar un libro','libros.destroy', 'Eliminar cualquier libro en el sistema', '2020-10-19 06:00:00', '2020-10-19 06:00:00');
