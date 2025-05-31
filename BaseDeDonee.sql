-- Créer la base de données
DROP DATABASE IF EXISTS sportify ;
CREATE DATABASE sportify;
USE sportify;

-- Table des utilisateurs (clients, spécialistes, admins)
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('client', 'specialiste', 'admin') NOT NULL DEFAULT 'client',
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table des spécialistes (extension de la table users)
DROP TABLE IF EXISTS `specialistes`;
CREATE TABLE IF NOT EXISTS `specialistes` (
    id INT PRIMARY KEY,
    cv TEXT,
    telephone VARCHAR(20),
    adresse VARCHAR(255),
    FOREIGN KEY (id) REFERENCES users(id) ON DELETE CASCADE
);

-- Disponibilités hebdomadaires des spécialistes
DROP TABLE IF EXISTS `disponibilites`;
CREATE TABLE IF NOT EXISTS `disponibilites` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    specialiste_id INT NOT NULL,
    jour_semaine ENUM('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche') NOT NULL,
    heure_debut TIME NOT NULL,
    heure_fin TIME NOT NULL,
    FOREIGN KEY (specialiste_id) REFERENCES specialistes(id) ON DELETE CASCADE
);

-- Rendez-vous entre clients et spécialistes
DROP TABLE IF EXISTS `rendezvous`;
CREATE TABLE IF NOT EXISTS `rendezvous` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    specialiste_id INT NOT NULL,
    date_rdv DATE NOT NULL,
    heure_rdv TIME NOT NULL,
    statut ENUM('confirmé', 'en attente', 'annulé') DEFAULT 'en attente',
    FOREIGN KEY (client_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (specialiste_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Messages de chat entre utilisateurs
DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    expediteur_id INT NOT NULL,
    destinataire_id INT NOT NULL,
    contenu TEXT NOT NULL,
    date_envoi DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (expediteur_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (destinataire_id) REFERENCES users(id) ON DELETE CASCADE
);
