
-- Insérer des données dans la table Client
INSERT INTO clients (NumClient, Nom, Prenom, address,tel, status) VALUES
(1, 'Diop', 'Marie', 'Rue de la Paix Dakar',772892388, 'actif'),
(2, 'Ndiaye', 'Amadou', 'Avenue de la République Thiès',782583645, 'suspendu'),
(3, 'Faye', 'Awa', 'Route de Rufisque Dakar',702354878, 'actif'),
(4, 'Sarr', 'Mamadou', 'Thiès ville',758833245, 'actif');



-- Insérer des données dans la table DemandePrêt
INSERT INTO demandesprets (Num_ordre, Montant, Duree,NumClient) VALUES
(1001, 5000.00, 24,1),
(1002, 12000.00, 36,2),
(1003, 7500.00, 18,3),
(1004, 15000.00, 48,4);



-- Insérer des données dans la table Remboursement
INSERT INTO Remboursement (Num_Rem, Montant, Date_R) VALUES
(3001, 220.00, '2025-01-03'),
(3002, 345.00, '2025-01-05'),
(3003, 450.00, '2025-01-10'),
(3004, 250.00, '2025-02-03');

-- Insérer des données dans la table Taxe
INSERT INTO Taxe (Num_taxe, Date_T, Montant) VALUES
(4001, '2025-01-03', 4.00),
(4002, '2025-01-05', 7.00),
(4003, '2025-01-10', 10.00),
(4004, '2025-02-03', 5.00);




-- Insérer des données dans la table Prêt
INSERT INTO Prets (Num_Prets, Montant, Taux, Duree, Montant_mens, Num_Rem, NumClient, Num_taxe, status) VALUES
(2001, 5000.00, 5.0, 24, 220.00, 3001, 1, 4001, 'actif'),
(2002, 12000.00, 4.5, 36, 345.00, 3002, 2, 4002, 'refusé'),
(2003, 7500.00, 6.0, 18, 450.00, 3003, 3, 4003, 'actif');
