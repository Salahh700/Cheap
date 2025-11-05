drop table if exists users;

create database cheap;   

use cheap;

Create table users (

    id_user INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL

);

Create Table produits(

    id_produit INT AUTO_INCREMENT PRIMARY KEY,
    nom_produit VARCHAR(100) NOT NULL,
    description_produit TEXT NOT NULL,
    prix_produit DECIMAL(6, 2) NOT NULL,
    stock_produit INT NOT NULL DEFAULT 0,
    image_produit VARCHAR(255) DEFAULT NULL,
    plateforme_produit VARCHAR(50) NOT NULL

);

Create table comptes(

    id_compte INT AUTO_INCREMENT PRIMARY KEY,
    identifiant_compte VARCHAR(50) NOT NULL UNIQUE,
    password_compte VARCHAR(100) NOT NULL

);

--Trigger pour incrémenter le stock lors de l'insertion d'un compte

DELIMITER //

CREATE TRIGGER increment_stock
AFTER INSERT ON comptes
FOR EACH ROW
BEGIN
    UPDATE produits
    SET stock_produit = stock_produit + 1
    WHERE id_produit = NEW.id_produit;
END //

DELIMITER ;

-- Trigger pour décrémenter le stock lors de la suppression d'un compte

DELIMITER //

CREATE TRIGGER decrement_stock
AFTER DELETE ON comptes
FOR EACH ROW
BEGIN
    UPDATE produits
    SET stock_produit = stock_produit - 1
    WHERE id_produit = OLD.id_produit;
END //

DELIMITER ;

Create table commandes(

    id_commande INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_produit INT NOT NULL,
    date_commande DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_produit) REFERENCES produits(id_produit) ON DELETE CASCADE ON UPDATE CASCADE

);

CREATE TABLE livraisons (
    id_livraison INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_compte INT,
    date_livraison DATETIME DEFAULT CURRENT_TIMESTAMP
);


DELIMITER $$

CREATE TRIGGER decrement_stock_after_insert
AFTER INSERT ON commandes
FOR EACH ROW
BEGIN
    UPDATE produits
    SET stock_produit = stock_produit - 1
    WHERE id_produit = NEW.id_produit;
END $$

DELIMITER ;


ALTER TABLE comptes ADD statut ENUM('disponible', 'indisponible') DEFAULT 'disponible';


ALTER TABLE commandes
ADD id_compte INT;


ALTER TABLE commandes
FOREIGN KEY (id_compte)
REFERENCES comptes(id_compte)
ON DELETE SET NULL
ON UPDATE CASCADE;


ALTER TABLE commandes
MODIFY id_compte INT NOT NULL;


DELIMITER $$

CREATE TRIGGER prevent_negative_stock
BEFORE UPDATE ON produits
FOR EACH ROW
BEGIN
    IF NEW.stock_produit < 0 THEN
        SET NEW.stock_produit = 0;
    END IF;
END$$

DELIMITER ;


BEGIN
    -- Si le compte devient disponible (et qu’il ne l’était pas avant), on augmente le stock
    IF NEW.statut_compte = 'disponible' AND OLD.statut_compte <> 'disponible' THEN
        UPDATE produits
        SET stock_produit = stock_produit + 1
        WHERE id_produit = NEW.id_produit;
    END IF;

    -- Si le compte devient indisponible (et qu’il était disponible avant), on diminue le stock
    IF NEW.statut_compte = 'indisponible' AND OLD.statut_compte = 'disponible' THEN
        UPDATE produits
        SET stock_produit = stock_produit - 1
        WHERE id_produit = NEW.id_produit;
    END IF;
END$$

DELIMITER ;

--Creation de la colonne reset_token dans la table users pour le reset de mot de passe
ALTER TABLE users ADD reset_token VARCHAR(255) DEFAULT NULL;
ALTER TABLE users ADD reset_token_expiry DATETIME DEFAULT NULL;
-- Ajout d'un index unique sur la colonne reset_token
CREATE UNIQUE INDEX idx_reset_token ON users(reset_token);
-- Ajout d'une colonne pour la date de création du compte