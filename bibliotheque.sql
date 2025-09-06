-- Création de la base de données
CREATE DATABASE IF NOT EXISTS Bibliotheque;
USE Bibliotheque;

-- ============================
--  Table Administrateur
-- ============================
CREATE TABLE Administrateur (
    id_administrateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(12) NOT NULL
);

INSERT INTO `administrateur` (`nom`, `prenom`,`email`, `mot_de_passe`) 
VALUES 
('BONOU', 'Mahuna Justus','justusbonou@gmail.com', '$2y$10$uynBN06CbawQ6zasWUNXw.rAXkC6ScMZZD8Cc/DOOz7WWrd6SzcPi'),
('KPOKOUTA', 'Abel', 'abelkpokouta@gmail.com', '$2y$10$Iu0aMsec8/VQThz4.SK29uHzz20Ll6YDBazAaMQkqBHvO14PPotiy'),
('AGBODO', 'Josué', 'josueagbodo@gmail.com', '$2y$10$Ef7YL0K5bXcvyJpuIBXhcuZOXvwIXQFjDHMzUSYmhnJqXjKejafdS');
-- ============================
--  Table Utilisateur
-- ============================
CREATE TABLE Utilisateur (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    sexe VARCHAR(10) NOT NULL,
    naissance DATE NOT NULL,
    statut VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL
);

INSERT INTO `utilisateur` (`nom`, `prenom`, `sexe`, `naissance`, `statut`, `email`, `mot_de_passe`) 
VALUES
('BONOU', 'Justus', 'Homme', '2005-08-12', 'Étudiant', 'justus@example.com', '$2y$10$pQg.YJ4UGxlxJg/8TEUsn.KfPi6Wft9C060AQtksrS8iSTuzV49C6'),
('KOUASSI', 'Alice', 'Femme', '2007-07-23', 'Étudiant', 'alice@example.com', '$2y$10$PpWtQYzfo5pNN0Q.VfoS/e2lZRxfk1iN6OVIkr1WeFf0EIKFYlqq6'),
('AKOU', 'David', 'Homme', '2003-01-14', 'Professeur', 'david@example.com', '$2y$10$mu9hTjLFJPUur8MCdoJXNuqInaGlxK2upAaPqMpErs/kyL/6KLDwK'),
('TCHAGNA', 'Mireille', 'Femme', '2001-03-31', 'Professionnel', 'mireille@example.com', '$2y$10$qvwW.hYojC0rPUnxHSdRR.4Dtx7Sqv9yr8eczflBxvDO/T1duvAjO'),
('HOUNGBO', 'Eric', 'Homme', '2005-09-11', 'Étudiant', 'eric@example.com', '$2y$10$nk3xNFBRQPOcdYEUJ85PmOYjdVSpTwpkE5.9uTCuRiX05U0HO35S6');

-- ============================
--  Table Categorie
-- ============================
CREATE TABLE Categorie (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom_categorie VARCHAR(50) NOT NULL
);

INSERT INTO Categorie (nom_categorie) VALUES
('Littérature classique'),
('Dystopie'),
('Fantastique'),
('Philosophie'),
('Jeunesse');

-- ============================
--  Table Livre
-- ============================
CREATE TABLE Livre (
    id_livre INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT,
    id_administrateur INT,
    titre VARCHAR(255) NOT NULL,
    auteur VARCHAR(100) NOT NULL,
    annee_edition INT NOT NULL,
    nombre_pages INT DEFAULT 0,
    disponibilite BOOLEAN DEFAULT 1,
    id_categorie INT,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    FOREIGN KEY (id_administrateur) REFERENCES Administrateur(id_administrateur)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    FOREIGN KEY (id_categorie) REFERENCES Categorie(id_categorie)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

INSERT INTO Livre (id_utilisateur,id_administrateur, titre, auteur, annee_edition, nombre_pages, disponibilite, id_categorie) VALUES
(1,1,'Le Petit Prince','Antoine de Saint-Exupéry',1943,120,1,1),
(2,2,'1984','George Orwell',1949,95,1,2),
(4,1,'Les Misérables','Victor Hugo',1862,85,0,1),
(5,2,'Le Comte de Monte-Cristo','Alexandre Dumas',1844,60,1,1),
(5,2,'Harry Potter à l''école des sorciers','J.K. Rowling',1997,221,1,3);

-- ============================
--  Table Resume
-- ============================
CREATE TABLE Resume (
    id_resume INT AUTO_INCREMENT PRIMARY KEY,
    id_livre INT NOT NULL,
    id_utilisateur INT,
    contenu TEXT NOT NULL,
    FOREIGN KEY (id_livre) REFERENCES Livre(id_livre)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

INSERT INTO Resume (id_livre, id_utilisateur, contenu) VALUES
(1,1,'Un petit garçon découvre l''amitié et la vie sur différentes planètes.'),
(2,2,'Une dystopie où le régime totalitaire contrôle la pensée et la liberté.'),
(3,1,'La vie tragique des misérables en France au XIXe siècle.'),
(4,2,'Un homme injustement emprisonné cherche vengeance.'),
(5,1,'Les aventures d''un jeune sorcier à l''école de magie.');

-- ============================
--  Table Commentaire
-- ============================
CREATE TABLE Commentaire (
    id_commentaire INT AUTO_INCREMENT PRIMARY KEY,
    id_resume INT NOT NULL,
    id_utilisateur INT NOT NULL,
    contenu TEXT NOT NULL,
    note INT CHECK (note >= 1 AND note <= 5),
    FOREIGN KEY (id_resume) REFERENCES Resume(id_resume)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

INSERT INTO Commentaire (id_resume, id_utilisateur, contenu, note) VALUES
(1,3,'Très poétique et touchant',5),
(2,4,'Un classique à lire absolument',5),
(3,5,'Un peu long mais captivant',4),
(4,3,'Histoire de vengeance passionnante',5),
(5,4,'Magique et captivant',5);

-- ============================
--  Table Emprunt
-- ============================
CREATE TABLE Emprunt (
    id_emprunt INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_livre INT NOT NULL,
    date_emprunt DATE NOT NULL,
    date_retour DATE,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_livre) REFERENCES Livre(id_livre)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

INSERT INTO Emprunt (id_utilisateur, id_livre, date_emprunt, date_retour) VALUES
(3,3,'2025-08-01','2025-08-15'),
(4,2,'2025-08-03','2025-08-17'),
(5,1,'2025-08-05','2025-08-19');

-- ============================
--  Table Reservation
-- ============================
CREATE TABLE Reservation (
    id_reservation INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_livre INT NOT NULL,
    date_reservation DATE NOT NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_livre) REFERENCES Livre(id_livre)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

INSERT INTO Reservation (id_utilisateur, id_livre, date_reservation) VALUES
(3,5,'2025-08-20'),
(4,1,'2025-08-21'),
(5,3,'2025-08-22');
