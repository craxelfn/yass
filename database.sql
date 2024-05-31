-- Table des Services
CREATE TABLE Services (
    service_id VARCHAR(50) PRIMARY KEY ,
    responsable int,
    nombre_vehicules INT
);

-- Table des Véhicules
CREATE TABLE Vehicules (
    vehicule_id VARCHAR(50) PRIMARY KEY,
    service_id VARCHAR(50),
    marque VARCHAR(50),
    nombre_places INT DEFAULT 5,
    est_occupe BOOLEAN DEFAULT FALSE,
    est_supprimer BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (service_id) REFERENCES Services(service_id)
);



-- Table des Missions
CREATE TABLE Ville (
    nom VARCHAR(50) PRIMARY KEY
);

CREATE TABLE Missions (
    mission_id INT PRIMARY KEY AUTO_INCREMENT,
    conducteur_id INT ,
    service_id VARCHAR(50),
    vehicule_id VARCHAR(50),
    destination VARCHAR(50),
    date_heure DATETIME,
    nombre_places_reserves INT DEFAULT 4 ,
    statut VARCHAR(20),
    est_supprimer BOOLEAN DEFAULT FALSE,
    deletedby VARCHAR(50) DEFAULT 'admin', 
    FOREIGN KEY (service_id) REFERENCES Services(service_id),
    FOREIGN KEY (vehicule_id) REFERENCES Vehicules(vehicule_id),
    FOREIGN KEY (destination) REFERENCES Ville(nom),
    FOREIGN KEY (conducteur_id) REFERENCES Utilisateurs(utilisateur_id)
);



CREATE TABLE Utilisateurs (
    utilisateur_id INT PRIMARY KEY AUTO_INCREMENT,
    nom_utilisateur VARCHAR(50),
    user_image VARCHAR(190) DEFAULT 'avatar.PNG' , 
    phone_NUM VARCHAR(10),
    mot_de_passe VARCHAR(255), -- Stocker le mot de passe de manière sécurisée
    email VARCHAR(100),
    service_id VARCHAR(50) , 
    role VARCHAR(20), 
    FOREIGN KEY (service_id) REFERENCES Services(service_id),
); 

CREATE TABLE Reservations (
    reservation_id INT PRIMARY KEY AUTO_INCREMENT,
    mission_id INT,
    utilisateur_id INT,
    role VARCHAR(50) default  'passager' , 
    FOREIGN KEY (mission_id) REFERENCES Missions(mission_id),
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(utilisateur_id)
);
