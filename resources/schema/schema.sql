CREATE TABLE `customers` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `number` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `postal_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `country` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `number` (`number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

-- Creación de la tabla jurisdiction
CREATE TABLE jurisdiction (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    status ENUM('ACTIVE', 'DISABLE') NOT NULL DEFAULT 'ACTIVE'
);

-- Creación de la tabla commune
CREATE TABLE commune (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    idJurisdiction INT NOT NULL,
    CONSTRAINT fk_commune_jurisdiction FOREIGN KEY (idJurisdiction)
        REFERENCES jurisdiction(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- Creación de la tabla signerByCommune
CREATE TABLE signerByCommune (
    signerID INT NOT NULL,
    contractID VARCHAR(255) NOT NULL,
    communeID INT NOT NULL,
    CONSTRAINT fk_signerByCommune_commune FOREIGN KEY (communeID)
        REFERENCES commune(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (signerID, contractID, communeID)
);

-- Insertar la jurisdicción Santiago
INSERT INTO jurisdiction (name) VALUES ('Santiago');

-- Insertar las comunas asociadas a la jurisdicción de Santiago
INSERT INTO commune (name, idJurisdiction) VALUES 
('Cerrillos', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Cerro Navia', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Conchalí', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Estación Central', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Huechuraba', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Independencia', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('La Florida', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('La Reina', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Las Condes', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Lo Barnechea', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Lo Prado', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Macul', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Maipú', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Ñuñoa', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Peñalolén', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Providencia', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Pudahuel', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Quilicura', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Quinta Normal', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Recoleta', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Renca', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Santiago', (SELECT id FROM jurisdiction WHERE name = 'Santiago')),
('Vitacura', (SELECT id FROM jurisdiction WHERE name = 'Santiago'));