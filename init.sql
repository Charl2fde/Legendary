CREATE TABLE IF NOT EXISTS moto
(
    id        int UNIQUE auto_increment,
    moto_name VARCHAR(100),
    image_url VARCHAR(500),
    stock     int,
    prix     int
);

CREATE TABLE IF NOT EXISTS users
(
    id       int UNIQUE auto_increment,
    nom      VARCHAR(30),
    prenom   VARCHAR(30),
    adresse  VARCHAR(100),
    num_carte VARCHAR(100),
    date_exp  VARCHAR(100),
    cvv       VARCHAR(100)
);

INSERT INTO moto(moto_name, image_url, stock, prix)
VALUES ('HONDA CB 1000R','../image/moto/honda.png', 10, 10500),
       ('Kawasaki Z900', '../image/moto/kawasaki.png', 10, 6800),
       ('Yamaha MT-09', '../image/moto/ktm.png', 10, 8900),
       ('Suzuki GSX-S1000', '../image/moto/bmw.webp', 10, 12300),
       ('BMW S1000R', '../image/moto/yamaha.webp', 10, 11200),
       ('Ducati Monster 821', '../image/moto/ducati.webp', 10, 9700);