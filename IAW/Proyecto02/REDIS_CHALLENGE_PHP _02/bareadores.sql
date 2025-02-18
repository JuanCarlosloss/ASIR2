CREATE DATABASE olivos_db;
USE olivos_db;

-- Tabla de Vareadores
CREATE TABLE vareadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

-- Tabla de Olivos
CREATE TABLE olivos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ubicacion VARCHAR(255) NOT NULL
);

-- Tabla intermedia para relación M:N
CREATE TABLE vareadores_olivos (
    vareador_id INT,
    olivo_id INT,
    PRIMARY KEY (vareador_id, olivo_id),
    FOREIGN KEY (vareador_id) REFERENCES vareadores(id) ON DELETE CASCADE,
    FOREIGN KEY (olivo_id) REFERENCES olivos(id) ON DELETE CASCADE
);
CREATE TABLE configuracion_cache (
    id INT PRIMARY KEY AUTO_INCREMENT,
    politica ENUM('write_through', 'invalidacion', 'ttl', 'lazy_loading', 'gilran') NOT NULL,
    ttl INT DEFAULT 30 -- TTL por defecto (60 segundos)
);
