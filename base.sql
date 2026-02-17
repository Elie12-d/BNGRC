CREATE DATABASE IF NOT EXISTS BNGRC;
USE BNGRC;

CREATE TABLE BNGRC_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    type VARCHAR(255) DEFAULT 'user'
);

CREATE TABLE BNGRC_regions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

CREATE TABLE BNGRC_villes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    id_region INT,
    FOREIGN KEY (id_region) REFERENCES BNGRC_regions(id)
);

CREATE TABLE BNGRC_besoins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    quantite INT NOT NULL,
    date_saisie DATETIME DEFAULT CURRENT_TIMESTAMP,
    prix_unitaire DOUBLE,
    id_ville INT,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_ville) REFERENCES BNGRC_villes(id)
);

CREATE TABLE BNGRC_category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

CREATE TABLE BNGRC_dons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    quantite INT NOT NULL,
    id_category INT,
    date_don DATE,
    FOREIGN KEY (id_category) REFERENCES BNGRC_category(id)
    
);

CREATE TABLE BNGRC_dispatch (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_don INT NOT NULL,
    id_besoin INT NOT NULL,
    quantite_attribuee INT NOT NULL,
    date_dispatch DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(255) DEFAULT 'partiel',
    FOREIGN KEY (id_don) REFERENCES BNGRC_dons(id),
    FOREIGN KEY (id_besoin) REFERENCES BNGRC_besoins(id)
);
CREATE TABLE BNGRC_achat(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_don INT NOT NULL,
    nom_don VARCHAR(255),
    quantite INT NOT NULL,
    prix_unitaire DOUBLE,
    pourcentage DOUBLE,
    FOREIGN KEY (id_don) REFERENCES BNGRC_dons(id)
);

INSERT INTO BNGRC_regions (nom) VALUES 
('Atsinanana'),      -- Pour Toamasina
('Vatovavy'),         -- Pour Mananjary
('Atsimo-Atsinanana'), -- Pour Farafangana
('Diana'),            -- Pour Nosy Be
('Menabe');           -- Pour Morondava

INSERT INTO BNGRC_villes (nom, id_region) VALUES 
('Toamasina', 1),
('Mananjary', 2),
('Farafangana', 3),
('Nosy Be', 4),
('Morondava', 5);

INSERT INTO BNGRC_category (nom) VALUES 
('nature'),
('materiel'),
('argent');

INSERT INTO BNGRC_dons (nom, quantite, id_category, date_don) VALUES 
-- Dons du 2026-02-16
('Argent', 5000000, 3, '2026-02-16'),
('Argent', 3000000, 3, '2026-02-16'),
('Riz (kg)', 400, 1, '2026-02-16'),
('Eau (L)', 600, 1, '2026-02-16'),

-- Dons du 2026-02-17
('Argent', 4000000, 3, '2026-02-17'),
('Argent', 1500000, 3, '2026-02-17'),
('Argent', 6000000, 3, '2026-02-17'),
('Tôle', 50, 2, '2026-02-17'),
('Bâche', 70, 2, '2026-02-17'),
('Haricots', 100, 1, '2026-02-17'),
('Haricots', 88, 1, '2026-02-17'),

-- Dons du 2026-02-18
('Riz (kg)', 2000, 1, '2026-02-18'),
('Tôle', 300, 2, '2026-02-18'),
('Eau (L)', 5000, 1, '2026-02-18'),

-- Dons du 2026-02-19
('Argent', 20000000, 3, '2026-02-19'),
('Bâche', 500, 2, '2026-02-19');

INSERT INTO BNGRC_besoins (nom, quantite, date_saisie, prix_unitaire, id_ville, date_creation) VALUES 
-- Toamasina (id_ville = 1)
('Riz (kg)', 800, '2026-02-16', 3000, 1, '2026-02-16'),
('Eau (L)', 1500, '2026-02-15', 1000, 1, '2026-02-15'),
('Tôle', 120, '2026-02-16', 25000, 1, '2026-02-16'),
('Bâche', 200, '2026-02-15', 15000, 1, '2026-02-15'),
('Argent', 12000000, '2026-02-16', 1, 1, '2026-02-16'),
('groupe', 3, '2026-02-15', 6750000, 1, '2026-02-15'),

-- Mananjary (id_ville = 2)
('Riz (kg)', 500, '2026-02-15', 3000, 2, '2026-02-15'),
('Huile (L)', 120, '2026-02-16', 6000, 2, '2026-02-16'),
('Tôle', 80, '2026-02-15', 25000, 2, '2026-02-15'),
('Clous (kg)', 60, '2026-02-16', 8000, 2, '2026-02-16'),
('Argent', 6000000, '2026-02-15', 1, 2, '2026-02-15'),

-- Farafangana (id_ville = 3)
('Riz (kg)', 600, '2026-02-16', 3000, 3, '2026-02-16'),
('Eau (L)', 1000, '2026-02-15', 1000, 3, '2026-02-15'),
('Bâche', 150, '2026-02-16', 15000, 3, '2026-02-16'),
('Bois', 100, '2026-02-15', 10000, 3, '2026-02-15'),
('Argent', 8000000, '2026-02-16', 1, 3, '2026-02-16'),

-- Nosy Be (id_ville = 4)
('Riz (kg)', 300, '2026-02-15', 3000, 4, '2026-02-15'),
('Haricots', 200, '2026-02-16', 4000, 4, '2026-02-16'),
('Tôle', 40, '2026-02-15', 25000, 4, '2026-02-15'),
('Clous (kg)', 30, '2026-02-16', 8000, 4, '2026-02-16'),
('Argent', 4000000, '2026-02-15', 1, 4, '2026-02-15'),

-- Morondava (id_ville = 5)
('Riz (kg)', 700, '2026-02-16', 3000, 5, '2026-02-16'),
('Eau (L)', 1200, '2026-02-15', 1000, 5, '2026-02-15'),
('Bâche', 180, '2026-02-16', 15000, 5, '2026-02-16'),
('Bois', 150, '2026-02-15', 10000, 5, '2026-02-15'),
('Argent', 10000000, '2026-02-16', 1, 5, '2026-02-16');
