CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    email VARCHAR(40) UNIQUE,
    name VARCHAR(20),
    lastname VARCHAR(20),
    password VARCHAR(80),
    status VARCHAR(15),
    rol VARCHAR(15),
    money FLOAT DEFAULT 0
);

INSERT INTO users (name, lastname, email, password, status, rol)
VALUES
    ('John', 'Doe', 'john@example.com', 'password123', 'active', 'user'),
    ('Jane', 'Doe', 'jane@example.com', 'password456', 'active', 'admin');

CREATE TABLE IF NOT EXISTS img_rute (
    id SERIAL PRIMARY KEY,
    rute VARCHAR(40) UNIQUE,
    name VARCHAR(20)
);

INSERT INTO img_rute (rute, name)
VALUES
    ('img/imagen.jpg', 'miimagen');

CREATE TABLE IF NOT EXISTS categorys (
    id VARCHAR(20) PRIMARY KEY,
    id_img INT,
    name VARCHAR(20) UNIQUE,
    status VARCHAR(20),
    description TEXT
);

INSERT INTO categorys (id, id_img, name, status, description)
VALUES
    ('fruits', 1, 'frutas', 'active', 'venta frutas'),
    ('clothes', 1, 'ropa', 'active', 'venta ropa');

CREATE TABLE IF NOT EXISTS products (
    id SERIAL PRIMARY KEY,
    id_img INT,
    id_category VARCHAR(20),
    name VARCHAR(20) UNIQUE,
    description VARCHAR(60),
    status VARCHAR(20),
    price FLOAT,
    amount INT,
    id_currency INT
);

INSERT INTO products (id_img, id_category, name, status, price, amount, id_currency, description)
VALUES
    (1, 'clothes', 'papel', 'active', 10, 5, 1, 'hojas de papel');
