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
-- DONNÉES DE TEST POUR BNGRC
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
INSERT INTO BNGRC_besoins (nom, quantite, prix_unitaire, id_ville) VALUES
-- Antananarivo (id=1) - Inondations quartiers bas
('Riz (masika) kg', 800, 2500, 1),
('Huile végétale litre', 150, 7800, 1),
('Tôle bacico', 200, 42000, 1),
('Ciment (sac 50kg)', 50, 25000, 1),
('Clou (boîte 1kg)', 40, 7500, 1),
('Eau potable (bidon 20L)', 300, 5000, 1),
('Savon (carton)', 100, 22000, 1),

-- Toamasina (id=5) - Cyclone
('Riz (vary gasy) kg', 600, 2800, 5),
('Tôle bacico', 350, 45000, 5),
('Bâche (épaisse)', 80, 38000, 5),
('Clou (charpente) kg', 60, 8000, 5),
('Sucre (kg)', 200, 4000, 5),
('Lait (boîte)', 300, 6000, 5),
('Moustiquaire', 150, 12000, 5),

-- Mahajanga (id=9) - Sécheresse
('Riz (kg)', 500, 2500, 9),
('Farine (kg)', 300, 2800, 9),
('Huile (litre)', 200, 7500, 9),
('Haricot (tsaramaso) kg', 150, 3200, 9),
('Mais (kg)', 400, 1500, 9),
('Biscuit énergétique (carton)', 200, 45000, 9),

-- Fianarantsoa (id=13) - Vague de froid
('Couverture (lamba)', 400, 14000, 13),
('Pull (sweat) lot', 300, 18000, 13),
('Riz (kg)', 400, 2400, 13),
('Sucre (kg)', 150, 4000, 13),
('Huile (litre)', 120, 7600, 13),

-- Antsirabe (id=16) - Grêle
('Tôle bacico', 150, 43000, 16),
('Bâche', 100, 35000, 16),
('Riz (kg)', 250, 2400, 16),
('Clou (boîte)', 30, 7500, 16),
('Vêtements chauds (lot)', 200, 20000, 16),

-- Antsiranana (id=19) - Tempête
('Tôle bacico', 120, 46000, 19),
('Bâche', 60, 38000, 19),
('Riz (kg)', 180, 2600, 19),
('Eau (bidon)', 250, 5000, 19),
('Médicaments (kit)', 50, 75000, 19);

-- 5. Dons reçus (avec dates pour l'ordre chronologique)
INSERT INTO BNGRC_dons (nom, quantite, date_don) VALUES
-- Dons du 10 Février 2026
('Riz (kg)', 1500, '2026-02-10'),
('Huile (litre)', 300, '2026-02-10'),
('Tôle bacico', 200, '2026-02-10'),
('Don en argent (Ar)', 2000000, '2026-02-10'),

-- Dons du 11 Février 2026
('Riz (kg)', 800, '2026-02-11'),
('Haricot (kg)', 250, '2026-02-11'),
('Bâche', 120, '2026-02-11'),
('Ciment (sac)', 100, '2026-02-11'),

-- Dons du 12 Février 2026
('Tôle bacico', 300, '2026-02-12'),
('Sucre (kg)', 200, '2026-02-12'),
('Don en argent (Ar)', 1500000, '2026-02-12'),
('Clou (boîte)', 80, '2026-02-12'),

-- Dons du 13 Février 2026
('Riz (kg)', 600, '2026-02-13'),
('Farine (kg)', 400, '2026-02-13'),
('Couverture', 300, '2026-02-13'),
('Savon (carton)', 150, '2026-02-13'),

-- Dons du 14 Février 2026
('Eau (bidon)', 500, '2026-02-14'),
('Médicaments (kit)', 30, '2026-02-14'),
('Don en argent (Ar)', 800000, '2026-02-14'),
('Vêtements (lot)', 250, '2026-02-14');

INSERT INTO BNGRC_dispatch (id_don, id_besoin, quantite_attribuee, status, date_dispatch) VALUES
-- Distribution normale terminée
(1, 1, 500, 'complete', '2026-02-10 10:30:00'),

-- Distribution en cours (pas encore finalisée)
(1, 5, 150, 'en_cours', '2026-02-10 10:30:01'),

-- Distribution partielle (manque de stock)
(2, 3, 200, 'partiel', '2026-02-11 09:15:00');