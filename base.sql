CREATE DATABASE BNGRC;
use BNGRC;
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
    prix_unitaire DOUBLE,
    id_ville INT,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_ville) REFERENCES BNGRC_villes(id)
);
CREATE TABLE BNGRC_dons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    quantite INT NOT NULL,
    date_don DATE
);
CREATE TABLE BNGRC_dispatch (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_don INT NOT NULL,
    id_besoin INT NOT NULL,
    quantite_attribuee INT NOT NULL,
    date_dispatch DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(255) DEFAULT 'en cours',
    FOREIGN KEY (id_don) REFERENCES BNGRC_dons(id),
    FOREIGN KEY (id_besoin) REFERENCES BNGRC_besoins(id)
);
-- ============================================
-- DONNÉES DE TEST POUR BNGRC (VERSION CORRIGÉE)
-- ============================================

-- 1. Utilisateurs
INSERT INTO BNGRC_users (username, password, type) VALUES
('admin', MD5('admin123'), 'admin'),
('rakoto', MD5('rakoto123'), 'user'),
('rabe', MD5('rabe123'), 'user'),
('coordinator', MD5('coord123'), 'admin');

-- 2. Régions
INSERT INTO BNGRC_regions (nom) VALUES
('Analamanga'),
('Atsinanana'),
('Boeny'),
('Haute Matsiatra'),
('Vakinankaratra'),
('Diana'),
('Sava'),
('Itasy');

-- 3. Villes
INSERT INTO BNGRC_villes (nom, id_region) VALUES
-- Analamanga (id=1)
('Antananarivo Renivohitra', 1),
('Ambohidratrimo', 1),
('Anjozorobe', 1),
('Manjakandriana', 1),

-- Atsinanana (id=2)
('Toamasina I', 2),
('Brickaville', 2),
('Vatomandry', 2),
('Mahanoro', 2),

-- Boeny (id=3)
('Mahajanga I', 3),
('Marovoay', 3),
('Ambato-Boeny', 3),
('Mitsinjo', 3),

-- Haute Matsiatra (id=4)
('Fianarantsoa I', 4),
('Ambohimahasoa', 4),
('Ikalamavony', 4),

-- Vakinankaratra (id=5)
('Antsirabe I', 5),
('Betafo', 5),
('Ambatolampy', 5),

-- Diana (id=6)
('Antsiranana I', 6),
('Ambilobe', 6),
('Nosy Be', 6);

-- 4. Besoins (avec dates pour l'ordre chronologique)
INSERT INTO BNGRC_besoins (nom, quantite, prix_unitaire, id_ville, date_creation) VALUES
-- Antananarivo (id=1) - Inondations (10 Février)
('Riz', 800, 2500, 1, '2026-02-10 08:00:00'),
('Huile', 150, 7800, 1, '2026-02-10 08:00:00'),
('Tôle', 200, 42000, 1, '2026-02-10 08:00:00'),
('Ciment', 50, 25000, 1, '2026-02-10 08:00:00'),
('Clou', 40, 7500, 1, '2026-02-10 08:00:00'),
('Eau', 300, 5000, 1, '2026-02-10 08:00:00'),
('Savon', 100, 22000, 1, '2026-02-10 08:00:00'),

-- Toamasina (id=5) - Cyclone (11 Février)
('Riz', 600, 2800, 5, '2026-02-11 09:00:00'),
('Tôle', 350, 45000, 5, '2026-02-11 09:00:00'),
('Bâche', 80, 38000, 5, '2026-02-11 09:00:00'),
('Clou', 60, 8000, 5, '2026-02-11 09:00:00'),
('Sucre', 200, 4000, 5, '2026-02-11 09:00:00'),
('Lait', 300, 6000, 5, '2026-02-11 09:00:00'),
('Moustiquaire', 150, 12000, 5, '2026-02-11 09:00:00'),

-- Mahajanga (id=9) - Sécheresse (12 Février)
('Riz', 500, 2500, 9, '2026-02-12 10:00:00'),
('Farine', 300, 2800, 9, '2026-02-12 10:00:00'),
('Huile', 200, 7500, 9, '2026-02-12 10:00:00'),
('Haricot', 150, 3200, 9, '2026-02-12 10:00:00'),
('Mais', 400, 1500, 9, '2026-02-12 10:00:00'),
('Biscuit', 200, 45000, 9, '2026-02-12 10:00:00'),

-- Fianarantsoa (id=13) - Froid (13 Février)
('Couverture', 400, 14000, 13, '2026-02-13 11:00:00'),
('Pull', 300, 18000, 13, '2026-02-13 11:00:00'),
('Riz', 400, 2400, 13, '2026-02-13 11:00:00'),
('Sucre', 150, 4000, 13, '2026-02-13 11:00:00'),
('Huile', 120, 7600, 13, '2026-02-13 11:00:00'),

-- Antsirabe (id=16) - Grêle (14 Février)
('Tôle', 150, 43000, 16, '2026-02-14 12:00:00'),
('Bâche', 100, 35000, 16, '2026-02-14 12:00:00'),
('Riz', 250, 2400, 16, '2026-02-14 12:00:00'),
('Clou', 30, 7500, 16, '2026-02-14 12:00:00'),
('Vêtements', 200, 20000, 16, '2026-02-14 12:00:00'),

-- Antsiranana (id=19) - Tempête (15 Février)
('Tôle', 120, 46000, 19, '2026-02-15 13:00:00'),
('Bâche', 60, 38000, 19, '2026-02-15 13:00:00'),
('Riz', 180, 2600, 19, '2026-02-15 13:00:00'),
('Eau', 250, 5000, 19, '2026-02-15 13:00:00'),
('Médicaments', 50, 75000, 19, '2026-02-15 13:00:00');

-- 5. Dons reçus (avec dates pour l'ordre chronologique)
INSERT INTO BNGRC_dons (nom, quantite, date_don) VALUES
-- Dons du 9 Février 2026 (arrivés avant les besoins)
('Riz', 1000, '2026-02-09'),
('Huile', 200, '2026-02-09'),
('Tôle', 150, '2026-02-09'),

-- Dons du 10 Février 2026
('Riz', 1500, '2026-02-10'),
('Huile', 300, '2026-02-10'),
('Tôle', 200, '2026-02-10'),
('Argent', 2000000, '2026-02-10'),

-- Dons du 11 Février 2026
('Riz', 800, '2026-02-11'),
('Haricot', 250, '2026-02-11'),
('Bâche', 120, '2026-02-11'),
('Ciment', 100, '2026-02-11'),

-- Dons du 12 Février 2026
('Tôle', 300, '2026-02-12'),
('Sucre', 200, '2026-02-12'),
('Argent', 1500000, '2026-02-12'),
('Clou', 80, '2026-02-12'),

-- Dons du 13 Février 2026
('Riz', 600, '2026-02-13'),
('Farine', 400, '2026-02-13'),
('Couverture', 300, '2026-02-13'),
('Savon', 150, '2026-02-13'),

-- Dons du 14 Février 2026
('Eau', 500, '2026-02-14'),
('Médicaments', 30, '2026-02-14'),
('Argent', 800000, '2026-02-14'),
('Vêtements', 250, '2026-02-14'),

-- Dons du 15 Février 2026
('Riz', 700, '2026-02-15'),
('Lait', 200, '2026-02-15'),
('Moustiquaire', 100, '2026-02-15');

-- 6. Dispatch (distributions déjà effectuées)
INSERT INTO BNGRC_dispatch (id_don, id_besoin, quantite_attribuee, status, date_dispatch) VALUES
-- Distribution du 10 Février (don du 9/02)
(1, 1, 500, 'complete', '2026-02-10 10:30:00'),  -- Riz → Tana
(1, 8, 500, 'complete', '2026-02-10 10:30:01'),  -- Riz → Toamasina (reste)

-- Distribution du 11 Février
(4, 2, 150, 'partiel', '2026-02-11 09:15:00'),   -- Huile → Tana (partiel)
(5, 3, 200, 'partiel', '2026-02-11 09:15:01'),   -- Tôle → Tana

-- Distribution du 12 Février
(10, 9, 80, 'en_cours', '2026-02-12 14:20:00');   -- Bâche → Toamasina

-- INSERT INTO BNGRC_dons (nom, quantite, date_don) VALUES
-- ('Clou', 20, '2026-02-10');