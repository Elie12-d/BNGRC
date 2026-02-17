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
('Analamanga'),
('Atsinanana'),
('Haute Matsiatra'),
('Boeny'),
('Diana');

INSERT INTO BNGRC_villes (nom, id_region) VALUES
('Antananarivo', 1),
('Ambohidratrimo', 1),
('Toamasina', 2),
('Fenerive Est', 2),
('Fianarantsoa', 3),
('Ambalavao', 3),
('Mahajanga', 4),
('Ambato Boeny', 4),
('Antsiranana', 5),
('Nosy Be', 5);

INSERT INTO BNGRC_users (username, password, type) VALUES
('admin', 'admin123', 'admin'),
('bngrc_agent1', 'agent123', 'agent'),
('bngrc_agent2', 'agent123', 'agent'),
('user1', 'user123', 'user'),
('user2', 'user123', 'user');

INSERT INTO BNGRC_category(nom) VALUES
('en nature'),
('en materiaux'),
('en argent');

INSERT INTO BNGRC_dons (nom, quantite, id_category, date_don) VALUES
('Riz', 500, 1, '2026-02-01'),
('Haricots', 200, 1, '2026-02-02'),
('Huile', 120, 1, '2026-02-03'),
('Paracetamol', 300, 2, '2026-02-03'),
('Serum physiologique', 100, 2, '2026-02-04'),
('Tee shirt', 250, 3, '2026-02-04'),
('Couverture', 80, 3, '2026-02-05'),
('Eau potable', 1000, 1, '2026-02-05'),
('Bidon 20L', 150, 2, '2026-02-06'),
('Tente', 30, 3, '2026-02-06');

INSERT INTO BNGRC_besoins (nom, quantite, prix_unitaire, id_ville, date_creation) VALUES
('Riz', 300, 2500, 1, '2026-02-07 08:10:00'),
('Haricots', 150, 3500, 1, '2026-02-07 08:15:00'),
('Eau potable', 500, 500, 3, '2026-02-07 09:00:00'),
('Paracetamol', 200, 300, 3, '2026-02-07 09:10:00'),
('Couverture', 50, 20000, 5, '2026-02-07 10:00:00'),
('Tente', 10, 150000, 7, '2026-02-07 10:30:00'),
('Bidon 20L', 80, 8000, 9, '2026-02-07 11:00:00'),
('Tee shirt', 120, 5000, 10, '2026-02-07 11:15:00');

INSERT INTO BNGRC_dispatch (id_don, id_besoin, quantite_attribuee, status) VALUES
(1, 1, 250, 'partiel'),
(1, 1, 50, 'complet'),
(2, 2, 150, 'complet'),
(8, 3, 400, 'partiel'),
(8, 3, 100, 'complet'),
(4, 4, 180, 'partiel'),
(4, 4, 20, 'complet'),
(7, 5, 50, 'complet'),
(10, 6, 10, 'complet'),
(9, 7, 80, 'complet'),
(6, 8, 120, 'complet');

INSERT INTO BNGRC_besoins (nom, quantite, prix_unitaire, id_ville, date_creation) VALUES
('Matelas', 1, 30000, 1, '2026-02-08 08:00:00'),
('Matelas', 3, 30000, 2, '2026-02-08 08:00:00'),
('Matelas', 5, 30000, 3, '2026-02-08 08:00:00');

INSERT INTO BNGRC_dons (nom, quantite, id_category, date_don) VALUES
('Matelas', 6, 1, '2026-02-08');
