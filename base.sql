-- ============================================
-- CRÉATION DE LA BASE DE DONNÉES
-- ============================================
CREATE DATABASE IF NOT EXISTS BNGRC;
USE BNGRC;

-- ============================================
-- CRÉATION DES TABLES
-- ============================================

-- Table des utilisateurs
CREATE TABLE BNGRC_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    type VARCHAR(255) DEFAULT 'user'
);

-- Table des régions
CREATE TABLE BNGRC_regions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

-- Table des villes
CREATE TABLE BNGRC_villes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    id_region INT,
    FOREIGN KEY (id_region) REFERENCES BNGRC_regions(id)
);

-- Table des besoins (corrigée : date_saisie a maintenant un type)
CREATE TABLE BNGRC_besoins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    quantite INT NOT NULL,
    date_saisie DATETIME DEFAULT CURRENT_TIMESTAMP, -- ✅ Type ajouté
    prix_unitaire DOUBLE,
    id_ville INT,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_ville) REFERENCES BNGRC_villes(id)
);

-- Table des dons
CREATE TABLE BNGRC_dons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    quantite INT NOT NULL,
    date_don DATE
);

-- Table des dispatchs
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

-- ============================================
-- DONNÉES DE TEST (VERSION RÉDUITE)
-- ============================================

-- 1. Utilisateurs (4)
INSERT INTO BNGRC_users (username, password, type) VALUES
('admin', MD5('admin123'), 'admin'),
('rakoto', MD5('rakoto123'), 'user'),
('rabe', MD5('rabe123'), 'user'),
('coordinator', MD5('coord123'), 'admin');

-- 2. Régions (3 principales pour tester)
INSERT INTO BNGRC_regions (nom) VALUES
('Analamanga'),
('Atsinanana'),
('Boeny');

-- 3. Villes (2 par région)
INSERT INTO BNGRC_villes (nom, id_region) VALUES
-- Analamanga (id=1)
('Antananarivo', 1),
('Ambohidratrimo', 1),
-- Atsinanana (id=2)
('Toamasina', 2),
('Brickaville', 2),
-- Boeny (id=3)
('Mahajanga', 3),
('Marovoay', 3);

-- 4. Besoins (10 besoins répartis)
INSERT INTO BNGRC_besoins (nom, quantite, prix_unitaire, id_ville, date_creation) VALUES
-- Antananarivo (id=1)
('Riz', 500, 2500, 1, '2026-02-10 08:00:00'),
('Huile', 100, 7800, 1, '2026-02-10 08:00:00'),
('Tôle', 50, 42000, 1, '2026-02-10 08:00:00'),

-- Toamasina (id=3)
('Riz', 300, 2800, 3, '2026-02-11 09:00:00'),
('Tôle', 80, 45000, 3, '2026-02-11 09:00:00'),
('Bâche', 30, 38000, 3, '2026-02-11 09:00:00'),

-- Mahajanga (id=5)
('Riz', 400, 2500, 5, '2026-02-12 10:00:00'),
('Farine', 200, 2800, 5, '2026-02-12 10:00:00'),
('Huile', 80, 7500, 5, '2026-02-12 10:00:00'),
('Sucre', 100, 4000, 5, '2026-02-12 10:00:00');

-- 5. Dons (10 dons répartis)
INSERT INTO BNGRC_dons (nom, quantite, date_don) VALUES
-- Dons du 9 Février
('Riz', 600, '2026-02-09'),
('Huile', 150, '2026-02-09'),
('Tôle', 100, '2026-02-09'),

-- Dons du 10 Février
('Riz', 400, '2026-02-10'),
('Argent', 1000000, '2026-02-10'),
('Bâche', 50, '2026-02-10'),

-- Dons du 11 Février
('Riz', 300, '2026-02-11'),
('Farine', 150, '2026-02-11'),
('Sucre', 80, '2026-02-11'),

-- Dons du 12 Février
('Tôle', 70, '2026-02-12');  -- ✅ Plus de doublon !

-- 6. Dispatch (5 distributions pour tester)
INSERT INTO BNGRC_dispatch (id_don, id_besoin, quantite_attribuee, status, date_dispatch) VALUES
-- Don de riz (id=1) vers besoins
(1, 1, 400, 'complete', '2026-02-10 10:30:00'), -- Riz → Tana
(1, 4, 200, 'partiel', '2026-02-10 10:30:01'),  -- Riz → Toamasina

-- Don d'huile (id=2) vers besoins
(2, 2, 100, 'complete', '2026-02-11 09:15:00'), -- Huile → Tana

-- Don de tôle (id=3) vers besoins
(3, 3, 50, 'complete', '2026-02-11 14:20:00'),  -- Tôle → Tana
(3, 5, 30, 'partiel', '2026-02-11 14:20:01');   -- Tôle → Toamasina