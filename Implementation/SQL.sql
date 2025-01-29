DROP DATABASE IF EXISTS gestion_pretsbank;
CREATE DATABASE IF NOT EXISTS gestion_pretsbank;
USE gestion_pretsbank;


CREATE TABLE IF NOT EXISTS Clients(
        NumClient   Int  Auto_increment  NOT NULL ,
        nom         Varchar (150) ,
        prenom      Varchar (150) ,
        address     Varchar (100) ,
        tel         Varchar (15) ,
        status      ENUM ('actif','suspendu') 
        
	,CONSTRAINT Clients_PK PRIMARY KEY (NumClient)

);



CREATE TABLE IF NOT EXISTS DemandesPrets(
        Num_ordre   Int  Auto_increment  NOT NULL ,
        Montant     Double ,
        Duree       Int,
        NumClient   Int  
	,CONSTRAINT DemandesPrets_PK PRIMARY KEY (Num_ordre)
        ,CONSTRAINT DemandesPrets_Clients_FK FOREIGN KEY (NumClient) REFERENCES Clients(NumClient)
);



CREATE TABLE IF NOT EXISTS Remboursement(
        Num_Rem   Int  Auto_increment  NOT NULL ,
        Montant   Double ,
        Date_R      Date
	,CONSTRAINT Remboursement_PK PRIMARY KEY (Num_Rem)
);


CREATE TABLE IF NOT EXISTS Taxe(
        Num_taxe   Int  Auto_increment  NOT NULL ,
        Date_T       Date ,
        Montant    Double
	,CONSTRAINT Taxe_PK PRIMARY KEY (Num_taxe)
);



CREATE TABLE IF NOT EXISTS Prets(
        Num_Prets      Int  Auto_increment  NOT NULL ,
        Montant        Double ,
        Taux           Double ,
        Duree          Int ,
        Montant_mens   Double ,
        Status         ENUM ('actif','révisé') ,
        Num_Rem        Int NOT NULL ,
        NumClient      Int NOT NULL ,
        Num_taxe       Int NOT NULL
	,CONSTRAINT Prets_PK PRIMARY KEY (Num_Prets)

	,CONSTRAINT Prets_Remboursement_FK FOREIGN KEY (Num_Rem) REFERENCES Remboursement(Num_Rem)
	,CONSTRAINT Prets_Clients0_FK FOREIGN KEY (NumClient) REFERENCES Clients(NumClient)
	,CONSTRAINT Prets_Taxe1_FK FOREIGN KEY (Num_taxe) REFERENCES Taxe(Num_taxe)
);

