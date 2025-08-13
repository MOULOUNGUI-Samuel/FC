-- =================================================================
-- SCHÉMA DE BASE DE DONNÉES FCI - VERSION UNIFIÉE AVEC UUIDs ET COMMENTAIRES
-- Architecture centralisée autour de la table 'users'.
-- Chaque attribut est documenté pour une meilleure compréhension.
-- =================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- SUPPRESSION DES TABLES (ORDRE INVERSE DE CRÉATION POUR ÉVITER LES ERREURS DE CONTRAINTE)
-- --------------------------------------------------------

DROP TABLE IF EXISTS `operations`;
DROP TABLE IF EXISTS `loan_installments`;
DROP TABLE IF EXISTS `action_logs`;
DROP TABLE IF EXISTS `cash_register_sessions`;
DROP TABLE IF EXISTS `loans`;
DROP TABLE IF EXISTS `cash_registers`;
DROP TABLE IF EXISTS `accounts`;
DROP TABLE IF EXISTS `permission_role`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `permissions`;
DROP TABLE IF EXISTS `roles`;

-- --------------------------------------------------------
-- GROUPE 1 : TABLES DE CONFIGURATION (SANS DÉPENDANCES)
-- --------------------------------------------------------

--
-- Structure de la table `roles`
--
CREATE TABLE `roles` (
  `id` CHAR(36) NOT NULL PRIMARY KEY COMMENT 'Clé primaire unique (UUID) du rôle.',
  `name` VARCHAR(100) NOT NULL UNIQUE COMMENT 'Nom unique du rôle (ex: Client, Caissier, Superviseur).',
  `description` VARCHAR(255) NULL COMMENT 'Description détaillée du rôle et de ses responsabilités.',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création (géré par Laravel).',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date de dernière mise à jour (géré par Laravel).'
) COMMENT='Définit les rôles des entrées (Client, Caissier, Superviseur, etc.).';

--
-- Structure de la table `permissions`
--
CREATE TABLE `permissions` (
  `id` CHAR(36) NOT NULL PRIMARY KEY COMMENT 'Clé primaire unique (UUID) de la permission.',
  `code` VARCHAR(100) NOT NULL UNIQUE COMMENT 'Code unique de la permission (ex: creer_pret, valider_operation).',
  `description` TEXT NULL COMMENT 'Description de ce que la permission autorise à faire.',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création (géré par Laravel).',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date de dernière mise à jour (géré par Laravel).'
) COMMENT='Définit les actions granulaires possibles dans le système.';

-- --------------------------------------------------------
-- GROUPE 2 : TABLE CENTRALE `users` ET PIVOTS
-- --------------------------------------------------------

--
-- Structure de la table `users` (unifiée)
--
CREATE TABLE `users` (
  `id` CHAR(36) NOT NULL PRIMARY KEY COMMENT 'Clé primaire unique (UUID) de l''utilisateur ou du client.',
  `user_type` ENUM('Client', 'Utilisateur') NOT NULL COMMENT 'Discriminant pour savoir si l''entrée est un Client physique ou un Utilisateur interne.',
  `first_name` VARCHAR(255) NULL COMMENT 'Prénom (principalement pour les Clients de type personne physique).',
  `last_name` VARCHAR(255) NOT NULL COMMENT 'Nom de famille pour un Client, ou raison sociale pour une entité Utilisateur.',
  `username` VARCHAR(255) NULL UNIQUE COMMENT 'Identifiant de connexion unique pour les utilisateurs du système.',
  `profession` VARCHAR(255) NULL COMMENT 'Profession du client (spécifique au type Client).',
  `date_of_birth` DATE NULL COMMENT 'Date de naissance du client (spécifique au type Client).',
  `gender` ENUM('Homme', 'Femme', 'Autre') NULL COMMENT 'Sexe du client (spécifique au type Client).',
  `email` VARCHAR(255) NULL UNIQUE COMMENT 'Adresse e-mail unique pour la communication et la connexion.',
  `phone_number` VARCHAR(50) NOT NULL UNIQUE COMMENT 'Numéro de téléphone principal, obligatoire et unique.',
  `secondary_phone_number` VARCHAR(50) NULL COMMENT 'Numéro de téléphone secondaire ou alternatif.',
  `country` VARCHAR(255) NULL COMMENT 'Pays de résidence.',
  `city` VARCHAR(255) NULL COMMENT 'Ville de résidence.',
  `address` TEXT NULL COMMENT 'Adresse postale complète.',
  `id_card_number` VARCHAR(255) NULL UNIQUE COMMENT 'Numéro de la carte d''identité (spécifique au type Client).',
  `ifu_number` VARCHAR(255) NULL UNIQUE COMMENT 'Numéro IFU (spécifique aux Utilisateurs de type société).',
  `rccm_number` VARCHAR(255) NULL UNIQUE COMMENT 'Numéro RCCM (spécifique aux Utilisateurs de type société).',
  `email_verified_at` TIMESTAMP NULL COMMENT 'Date et heure de la vérification de l''adresse e-mail.',
  `password` VARCHAR(255) NULL COMMENT 'Mot de passe hashé pour l''authentification.',
  `remember_token` VARCHAR(100) NULL COMMENT 'Jeton pour la fonctionnalité "Se souvenir de moi" de Laravel.',
  `google_id` VARCHAR(255) NULL UNIQUE COMMENT 'ID unique fourni par Google pour la connexion sociale (OAuth).',
  `is_active` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Statut du compte (1 pour actif, 0 pour inactif).',
  `role_id` CHAR(36) NULL COMMENT 'Clé étrangère liant à un rôle dans la table `roles`.',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création (géré par Laravel).',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date de dernière mise à jour (géré par Laravel).',
  FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE SET NULL
) COMMENT='Table centrale pour tous les clients et utilisateurs du système.';

--
-- Structure de la table pivot `permission_role`
--
CREATE TABLE `permission_role` (
  `permission_id` CHAR(36) NOT NULL COMMENT 'Clé étrangère vers la table `permissions`.',
  `role_id` CHAR(36) NOT NULL COMMENT 'Clé étrangère vers la table `roles`.',
  PRIMARY KEY (`permission_id`, `role_id`),
  FOREIGN KEY (`permission_id`) REFERENCES `permissions`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE
) COMMENT='Assigne les permissions aux rôles (relation Many-to-Many).';

-- --------------------------------------------------------
-- GROUPE 3 : TABLES DÉPENDANT DIRECTEMENT DE `users`
-- --------------------------------------------------------

--
-- Structure de la table `accounts` (comptes financiers)
--
CREATE TABLE `accounts` (
  `id` CHAR(36) NOT NULL PRIMARY KEY COMMENT 'Clé primaire unique (UUID) du compte.',
  `user_id` CHAR(36) NOT NULL COMMENT 'Clé étrangère vers le propriétaire du compte (table `users`).',
  `account_number` VARCHAR(50) NOT NULL UNIQUE COMMENT 'Numéro de compte unique généré pour le client.',
  `name` VARCHAR(255) NOT NULL COMMENT 'Intitulé ou nom du compte (ex: Compte Courant, Épargne Scolaire).',
  `type` ENUM('Principal', 'Epargne', 'Projet', 'Autre') NOT NULL DEFAULT 'Principal' COMMENT 'Catégorise le type de compte.',
  `parent_account_id` CHAR(36) NULL COMMENT 'Lie ce compte à un compte principal (pour les sous-comptes).',
  `ceiling` DECIMAL(15, 2) NULL COMMENT 'Plafond ou montant maximum autorisé sur le compte.',
  `status` ENUM('Actif', 'Bloque', 'Cloture') NOT NULL DEFAULT 'Actif' COMMENT 'Statut actuel du compte (Actif, Bloqué, etc.).',
  `balance` DECIMAL(15, 2) NOT NULL DEFAULT 0.00 COMMENT 'Solde actuel du compte, mis à jour après chaque opération.',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création (géré par Laravel).',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date de dernière mise à jour (géré par Laravel).',
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`parent_account_id`) REFERENCES `accounts`(`id`) ON DELETE SET NULL
) COMMENT='Comptes principaux et sous-comptes des utilisateurs/clients.';

--
-- Structure de la table `cash_registers` (caisses)
--
CREATE TABLE `cash_registers` (
  `id` CHAR(36) NOT NULL PRIMARY KEY COMMENT 'Clé primaire unique (UUID) de la caisse.',
  `user_id` CHAR(36) NOT NULL COMMENT 'Clé étrangère vers l''utilisateur responsable de la caisse (table `users`).',
  `name` VARCHAR(255) NOT NULL COMMENT 'Nom ou libellé de la caisse (ex: Caisse Principale, Caisse Mobile MTN).',
  `type` ENUM('Physique', 'MobileMoney', 'Bancaire') NOT NULL COMMENT 'Nature de la caisse (espèce, compte mobile money, etc.).',
  `balance` DECIMAL(15, 2) NOT NULL DEFAULT 0.00 COMMENT 'Solde actuel de la caisse.',
  `min_threshold` DECIMAL(15, 2) NULL COMMENT 'Seuil minimal d''alerte de la caisse.',
  `max_threshold` DECIMAL(15, 2) NULL COMMENT 'Seuil maximal d''alerte de la caisse.',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création (géré par Laravel).',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date de dernière mise à jour (géré par Laravel).',
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) COMMENT='Caisses physiques ou virtuelles, gérées par un utilisateur.';

-- --------------------------------------------------------
-- GROUPE 4 : TABLES AVEC PLUS DE DÉPENDANCES
-- --------------------------------------------------------

--
-- Structure de la table `loans` (dossiers de crédit)
--
CREATE TABLE `loans` (
  `id` CHAR(36) NOT NULL PRIMARY KEY COMMENT 'Clé primaire unique (UUID) du prêt.',
  `debtor_account_id` CHAR(36) NOT NULL COMMENT 'Clé étrangère vers le compte qui reçoit le crédit (table `accounts`).',
  `loan_number` VARCHAR(50) NOT NULL UNIQUE COMMENT 'Numéro de référence unique pour le dossier de prêt.',
  `amount_granted` DECIMAL(15, 2) NOT NULL COMMENT 'Montant du capital accordé.',
  `annual_interest_rate` DECIMAL(5, 2) NOT NULL COMMENT 'Taux d''intérêt annuel en pourcentage (ex: 12.50).',
  `request_date` DATE NOT NULL COMMENT 'Date de la demande de prêt.',
  `approval_date` DATE NULL COMMENT 'Date de l''approbation du prêt par un gestionnaire.',
  `disbursement_date` DATE NULL COMMENT 'Date du déboursement effectif des fonds.',
  `duration_in_months` INT NOT NULL COMMENT 'Durée totale du prêt en mois.',
  `status` ENUM('Demande', 'Approuve', 'Debourse', 'Rembourse', 'En_Retard', 'Refuse') NOT NULL COMMENT 'Statut actuel du dossier de prêt.',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création (géré par Laravel).',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date de dernière mise à jour (géré par Laravel).',
  FOREIGN KEY (`debtor_account_id`) REFERENCES `accounts`(`id`) ON DELETE CASCADE
) COMMENT='Dossiers de crédit des clients.';

--
-- Structure de la table `cash_register_sessions`
--
CREATE TABLE `cash_register_sessions` (
  `id` CHAR(36) NOT NULL PRIMARY KEY COMMENT 'Clé primaire unique (UUID) de la session.',
  `cash_register_id` CHAR(36) NOT NULL COMMENT 'Clé étrangère vers la caisse concernée (table `cash_registers`).',
  `opening_user_id` CHAR(36) NOT NULL COMMENT 'Clé étrangère vers l''utilisateur qui a ouvert la session (table `users`).',
  `opening_time` DATETIME NOT NULL COMMENT 'Date et heure exactes de l''ouverture de la session.',
  `initial_balance` DECIMAL(15, 2) NOT NULL COMMENT 'Solde de la caisse au moment de l''ouverture.',
  `closing_user_id` CHAR(36) NULL COMMENT 'Clé étrangère vers l''utilisateur qui a fermé la session (table `users`).',
  `closing_time` DATETIME NULL COMMENT 'Date et heure exactes de la fermeture de la session.',
  `theorical_final_balance` DECIMAL(15, 2) NULL COMMENT 'Solde final calculé (solde initial + entrées - sorties).',
  `real_final_balance` DECIMAL(15, 2) NULL COMMENT 'Solde final réellement constaté lors du comptage.',
  `difference` DECIMAL(15, 2) NULL COMMENT 'Écart entre le solde théorique et le solde réel.',
  `justification` TEXT NULL COMMENT 'Explication en cas d''écart de caisse.',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création (géré par Laravel).',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date de dernière mise à jour (géré par Laravel).',
  FOREIGN KEY (`cash_register_id`) REFERENCES `cash_registers`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`opening_user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`closing_user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) COMMENT='Sessions d''ouverture et de clôture des caisses.';

--
-- Structure de la table `action_logs`
--
CREATE TABLE `action_logs` (
  `id` CHAR(36) NOT NULL PRIMARY KEY COMMENT 'Clé primaire unique (UUID) du journal.',
  `user_id` CHAR(36) NULL COMMENT 'Clé étrangère vers l''utilisateur ayant effectué l''action (table `users`).',
  `action` VARCHAR(255) NOT NULL COMMENT 'Description courte de l''action effectuée (ex: CONNEXION_REUSSIE, MODIFICATION_CLIENT).',
  `details` TEXT NULL COMMENT 'Détails supplémentaires sur l''action, en format JSON par exemple.',
  `ip_address` VARCHAR(45) NULL COMMENT 'Adresse IP de l''utilisateur au moment de l''action.',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date et heure exactes de l''action.'
) COMMENT='Journal des actions des utilisateurs pour la traçabilité et l''audit.';

-- --------------------------------------------------------
-- GROUPE 5 : TABLES LES PLUS DÉPENDANTES
-- --------------------------------------------------------

--
-- Structure de la table `loan_installments` (échéances)
--
CREATE TABLE `loan_installments` (
  `id` CHAR(36) NOT NULL PRIMARY KEY COMMENT 'Clé primaire unique (UUID) de l''échéance.',
  `loan_id` CHAR(36) NOT NULL COMMENT 'Clé étrangère vers le prêt concerné (table `loans`).',
  `due_date` DATE NOT NULL COMMENT 'Date à laquelle l''échéance doit être payée.',
  `principal_amount` DECIMAL(15, 2) NOT NULL COMMENT 'Part du capital à rembourser dans cette échéance.',
  `interest_amount` DECIMAL(15, 2) NOT NULL COMMENT 'Part des intérêts à payer dans cette échéance.',
  `total_amount` DECIMAL(15, 2) NOT NULL COMMENT 'Montant total de l''échéance (capital + intérêts).',
  `status` ENUM('A_Payer', 'Payee', 'En_Retard', 'Payee_Partiel') NOT NULL DEFAULT 'A_Payer' COMMENT 'Statut de paiement de l''échéance.',
  `paid_amount` DECIMAL(15, 2) DEFAULT 0.00 COMMENT 'Montant effectivement payé pour cette échéance.',
  `payment_date` DATETIME NULL COMMENT 'Date du paiement effectif de l''échéance.',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création (géré par Laravel).',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date de dernière mise à jour (géré par Laravel).',
  FOREIGN KEY (`loan_id`) REFERENCES `loans`(`id`) ON DELETE CASCADE
) COMMENT='Tableau d''amortissement détaillé pour chaque crédit.';

--
-- Structure de la table `operations`
--
CREATE TABLE `operations` (
  `id` CHAR(36) NOT NULL PRIMARY KEY COMMENT 'Clé primaire unique (UUID) de l''opération.',
  `user_id` CHAR(36) NOT NULL COMMENT 'Clé étrangère vers l''utilisateur qui a réalisé l''opération (table `users`).',
  `cash_register_session_id` CHAR(36) NULL COMMENT 'Clé étrangère vers la session de caisse active lors de l''opération.',
  `type` ENUM('Depot', 'Retrait', 'Transfert_Client', 'Transfert_Caisse', 'Frais', 'Paiement_Credit') NOT NULL COMMENT 'Nature de la transaction financière.',
  `amount` DECIMAL(15, 2) NOT NULL COMMENT 'Montant de l''opération.',
  `description` TEXT NOT NULL COMMENT 'Libellé ou motif détaillé de l''opération.',
  `source_account_id` CHAR(36) NULL COMMENT 'Compte source des fonds (si applicable).',
  `source_cash_register_id` CHAR(36) NULL COMMENT 'Caisse source des fonds (si applicable).',
  `destination_account_id` CHAR(36) NULL COMMENT 'Compte de destination des fonds (si applicable).',
  `destination_cash_register_id` CHAR(36) NULL COMMENT 'Caisse de destination des fonds (si applicable).',
  `related_loan_id` CHAR(36) NULL COMMENT 'Lie l''opération à un prêt (ex: pour un déboursement ou un remboursement).',
  `status` ENUM('Validee', 'Annulee') NOT NULL DEFAULT 'Validee' COMMENT 'Statut de l''opération.',
  `cancellation_user_id` CHAR(36) NULL COMMENT 'Utilisateur qui a annulé l''opération.',
  `cancellation_time` DATETIME NULL COMMENT 'Date et heure de l''annulation.',
  `operation_date` DATETIME NOT NULL COMMENT 'Date et heure effectives de l''opération.',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création (géré par Laravel).',
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date de dernière mise à jour (géré par Laravel).',
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`cash_register_session_id`) REFERENCES `cash_register_sessions`(`id`),
  FOREIGN KEY (`source_account_id`) REFERENCES `accounts`(`id`),
  FOREIGN KEY (`source_cash_register_id`) REFERENCES `cash_registers`(`id`),
  FOREIGN KEY (`destination_account_id`) REFERENCES `accounts`(`id`),
  FOREIGN KEY (`destination_cash_register_id`) REFERENCES `cash_registers`(`id`),
  FOREIGN KEY (`related_loan_id`) REFERENCES `loans`(`id`),
  FOREIGN KEY (`cancellation_user_id`) REFERENCES `users`(`id`)
) COMMENT='Table centrale qui enregistre toutes les transactions financières.';


COMMIT;