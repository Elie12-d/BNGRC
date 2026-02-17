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

-- Script d'insertion des données du cyclone S3
-- ATTENTION: Ce script doit être exécuté après la création de la base de données et des tables

-- ===========================
-- 1. INSERTION DES RÉGIONS
-- ===========================
INSERT INTO BNGRC_regions (nom) VALUES
('Atsinanana'),
('Vatovavy'),
('Atsimo-Atsinanana'),
('Diana'),
('Menabe');

-- ===========================
-- 2. INSERTION DES VILLES
-- ===========================
INSERT INTO BNGRC_villes (nom, id_region) VALUES
('Toamasina', 1),
('Mananjary', 2),
('Farafangana', 3),
('Nosy Be', 4),
('Morondava', 5);

-- ===========================
-- 3. INSERTION DES CATÉGORIES
-- ===========================
INSERT INTO BNGRC_category (nom) VALUES
('nature'),
('materiel'),
('argent');

-- ===========================
-- 4. INSERTION DES BESOINS
-- ===========================
-- Toamasina (id_ville = 1)
INSERT INTO BNGRC_besoins (nom, quantite, prix_unitaire, id_ville, date_saisie) VALUES
('Riz (kg)', 800, 3000, 1, '2026-02-16'),
('Eau (L)', 1500, 1000, 1, '2026-02-15'),
('Tôle', 120, 25000, 1, '2026-02-16'),
('Bâche', 200, 15000, 1, '2026-02-15'),
('Argent', 12000000, 1, 1, '2026-02-16'),
('Riz (kg)', 500, 3000, 1, '2026-02-15'),
('groupe', 3, 6750000, 1, '2026-02-15');

-- Mananjary (id_ville = 2)
INSERT INTO BNGRC_besoins (nom, quantite, prix_unitaire, id_ville, date_saisie) VALUES
('Huile (L)', 120, 6000, 2, '2026-02-16'),
('Tôle', 80, 25000, 2, '2026-02-15'),
('Clous (kg)', 60, 8000, 2, '2026-02-16'),
('Argent', 6000000, 1, 2, '2026-02-15');

-- Farafangana (id_ville = 3)
INSERT INTO BNGRC_besoins (nom, quantite, prix_unitaire, id_ville, date_saisie) VALUES
('Riz (kg)', 600, 3000, 3, '2026-02-16'),
('Eau (L)', 1000, 1000, 3, '2026-02-15'),
('Bâche', 150, 15000, 3, '2026-02-16'),
('Bois', 100, 10000, 3, '2026-02-15'),
('Argent', 8000000, 1, 3, '2026-02-16');

-- Nosy Be (id_ville = 4)
INSERT INTO BNGRC_besoins (nom, quantite, prix_unitaire, id_ville, date_saisie) VALUES
('Riz (kg)', 300, 3000, 4, '2026-02-15'),
('Haricots', 200, 4000, 4, '2026-02-16'),
('Tôle', 40, 25000, 4, '2026-02-15'),
('Clous (kg)', 30, 8000, 4, '2026-02-16'),
('Argent', 4000000, 1, 4, '2026-02-15');

-- Morondava (id_ville = 5)
INSERT INTO BNGRC_besoins (nom, quantite, prix_unitaire, id_ville, date_saisie) VALUES
('Riz (kg)', 700, 3000, 5, '2026-02-16'),
('Eau (L)', 1200, 1000, 5, '2026-02-15'),
('Bâche', 180, 15000, 5, '2026-02-16'),
('Bois', 150, 10000, 5, '2026-02-15'),
('Argent', 10000000, 1, 5, '2026-02-16');

-- ===========================
-- VÉRIFICATION DES INSERTIONS
-- ===========================
SELECT 'Régions insérées:' AS Info;
SELECT * FROM BNGRC_regions;

SELECT 'Villes insérées:' AS Info;
SELECT * FROM BNGRC_villes;

SELECT 'Catégories insérées:' AS Info;
SELECT * FROM BNGRC_category;

SELECT 'Besoins insérés:' AS Info;
SELECT COUNT(*) AS total_besoins FROM BNGRC_besoins;

SELECT 'Récapitulatif par ville:' AS Info;
SELECT v.nom AS ville, COUNT(b.id) AS nombre_besoins, SUM(b.quantite * b.prix_unitaire) AS valeur_totale
FROM BNGRC_villes v
LEFT JOIN BNGRC_besoins b ON v.id = b.id_ville
GROUP BY v.nom
ORDER BY v.nom;