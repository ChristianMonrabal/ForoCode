CREATE DATABASE forocode;
USE forocode;

CREATE TABLE Usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    nombre_real VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO Usuarios (username, nombre_real, email, password)
VALUES ('admin', 'Administrador', 'admin@forocode.com', '$2y$10$BHurAxvbcvVDNiatSBjzK.YjiVQYs1l339TOFgIukmTheaXG9xRxS');
