-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 28 sep. 2022 à 03:55
-- Version du serveur :  5.7.24
-- Version de PHP : 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `stampee`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `cat_id` int(11) NOT NULL,
  `cat_nom` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`cat_id`, `cat_nom`) VALUES
(1, 'Animaux'),
(2, 'Voitures'),
(3, 'Nature');

-- --------------------------------------------------------

--
-- Structure de la table `enchere`
--

CREATE TABLE `enchere` (
  `enc_id` int(11) NOT NULL,
  `enc_estimation` decimal(10,0) NOT NULL,
  `enc_dateDebut` datetime NOT NULL,
  `enc_dateFin` datetime NOT NULL,
  `enc_prixPlancher` decimal(10,0) NOT NULL,
  `enc_nombreDeMise` int(11) DEFAULT NULL,
  `enc_coupDeCoeur` tinyint(4) DEFAULT NULL,
  `enc_uti_id_ce` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `enchere`
--

INSERT INTO `enchere` (`enc_id`, `enc_estimation`, `enc_dateDebut`, `enc_dateFin`, `enc_prixPlancher`, `enc_nombreDeMise`, `enc_coupDeCoeur`, `enc_uti_id_ce`) VALUES
(22, '4', '2022-09-20 12:12:00', '2022-10-07 12:12:00', '5', NULL, NULL, 7),
(23, '3', '2022-09-27 21:33:00', '2022-09-27 23:33:00', '1', 21, NULL, 8),
(24, '1000', '2022-09-27 12:12:00', '2022-10-08 06:30:00', '900', 0, NULL, 7),
(25, '1000', '2022-09-22 12:12:00', '2022-10-08 23:12:00', '900', 0, NULL, 7),
(26, '1000', '2022-09-22 12:12:00', '2022-10-08 23:12:00', '900', 0, NULL, 7),
(27, '1000', '2022-09-22 12:12:00', '2022-10-08 23:12:00', '900', 0, NULL, 7),
(28, '1000', '2022-09-22 12:12:00', '2022-10-08 23:12:00', '900', 0, NULL, 7),
(29, '1000', '2022-09-22 12:12:00', '2022-10-08 23:12:00', '900', 0, NULL, 7),
(30, '1000', '2022-09-22 12:12:00', '2022-10-08 23:12:00', '900', 0, NULL, 7),
(31, '1000', '2022-09-22 12:12:00', '2022-10-08 23:12:00', '900', 0, NULL, 7),
(32, '3', '2022-09-29 12:12:00', '2022-10-06 12:12:00', '32', 0, NULL, 7),
(33, '333', '2022-08-31 12:12:00', '2022-09-29 12:12:00', '300', 2, NULL, 7);

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

CREATE TABLE `favoris` (
  `fav_uti_id_ce` int(11) NOT NULL,
  `fav_enc_id_ce` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `img_id` int(11) NOT NULL,
  `img_nom` varchar(500) NOT NULL,
  `img_tim_id_ce` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`img_id`, `img_nom`, `img_tim_id_ce`) VALUES
(13, './ressources/img/photos/timbres/timbre-canadien.png', 12),
(14, './ressources/img/photos/timbres/timbre-stlouis-ours.png', 13),
(15, './ressources/img/photos/timbres/nippon.jpg', 14),
(16, './ressources/img/photos/timbres/evilRobinWilliam.png', 15);

-- --------------------------------------------------------

--
-- Structure de la table `mise`
--

CREATE TABLE `mise` (
  `mis_uti_id_ce` int(11) NOT NULL,
  `mis_enc_id_ce` int(11) NOT NULL,
  `mis_miseActuelle` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mise`
--

INSERT INTO `mise` (`mis_uti_id_ce`, `mis_enc_id_ce`, `mis_miseActuelle`) VALUES
(7, 22, '212'),
(7, 24, '0'),
(7, 25, '0'),
(7, 26, '0'),
(7, 27, '0'),
(7, 28, '0'),
(7, 29, '0'),
(7, 30, '0'),
(7, 31, '0'),
(7, 32, '0'),
(7, 33, '6'),
(8, 23, '42');

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE `pays` (
  `pay_id` int(11) NOT NULL,
  `pay_nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`pay_id`, `pay_nom`) VALUES
(1, 'Canada'),
(2, 'États-Unis'),
(3, 'Mexique'),
(4, 'France'),
(5, 'Brésil'),
(6, 'Australie'),
(7, 'Russie'),
(8, 'Égypte'),
(9, 'Japon'),
(10, 'Norvège'),
(11, 'Suisse'),
(12, 'Pérou');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `rol_id` int(11) NOT NULL,
  `rol_nom` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`rol_id`, `rol_nom`) VALUES
(1, 'Administrateur'),
(2, 'Utilisateur');

-- --------------------------------------------------------

--
-- Structure de la table `timbre`
--

CREATE TABLE `timbre` (
  `tim_id` int(11) NOT NULL,
  `tim_nom` varchar(45) NOT NULL,
  `tim_description` varchar(500) DEFAULT NULL,
  `tim_dateDeCreation` datetime NOT NULL,
  `tim_couleurs` varchar(100) NOT NULL,
  `tim_condition` enum('Parfaite','Excellente','Bonne','Moyenne','Endommagé') NOT NULL,
  `tim_tirage` int(11) DEFAULT NULL,
  `tim_dimensions` varchar(45) DEFAULT NULL,
  `tim_certification` tinyint(4) DEFAULT NULL,
  `tim_enc_id_ce` int(11) NOT NULL,
  `tim_cat_id_ce` int(11) NOT NULL,
  `tim_pay_id_ce` int(11) NOT NULL,
  `tim_uti_id_ce` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `timbre`
--

INSERT INTO `timbre` (`tim_id`, `tim_nom`, `tim_description`, `tim_dateDeCreation`, `tim_couleurs`, `tim_condition`, `tim_tirage`, `tim_dimensions`, `tim_certification`, `tim_enc_id_ce`, `tim_cat_id_ce`, `tim_pay_id_ce`, `tim_uti_id_ce`) VALUES
(12, 'Timbre canadien', 'Timbre du canada', '2022-09-27 16:16:41', 'bleu', 'Parfaite', 2, '12 x 12', 1, 22, 1, 1, 7),
(13, 'Timbre ours', 'asd dgdfg fdg sdgsdgdjytrjfgnytje e w tw ert wertert wt ret wetwert wert wer twert ret ertrtr r trtrr trtrt rtrtetrrtetet egdgdgdg', '2022-09-27 17:33:33', 'Noir et jaune', 'Endommagé', 2, '4 x 4', 0, 23, 1, 5, 8),
(14, 'Timbre Nippon', 'Bulbasaur Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ivysaur Lorem ipsum dolor sit amet, consectetur adipiscing elit. Venusaur Lorem ipsum dolor sit amet, consectetur adipiscing ', '2022-09-27 23:29:26', 'Rose', 'Parfaite', 1, '4 x 4', 1, 32, 3, 9, 7),
(15, 'Timbre Robin Williams', 'Lookout flogging bilge rat main sheet bilge water nipper fluke to go on account heave down clap of thunder. Reef sails six pounders skysail code of conduct sloop cog Yellow Jack gunwalls grog blossom starboard. Swab black jack ahoy Brethren of the Coast schooner poop deck main sheet topmast furl marooned.', '2022-09-27 23:39:22', 'Rouge', 'Excellente', 55, '4 x 4', 1, 33, 3, 6, 7);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `uti_id` int(11) NOT NULL,
  `uti_prenom` varchar(45) NOT NULL,
  `uti_nom` varchar(45) NOT NULL,
  `uti_courriel` varchar(255) NOT NULL,
  `uti_mdp` varchar(255) NOT NULL,
  `uti_dateInscription` varchar(45) NOT NULL,
  `uti_confirmation` varchar(30) NOT NULL,
  `uti_rol_id_ce` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`uti_id`, `uti_prenom`, `uti_nom`, `uti_courriel`, `uti_mdp`, `uti_dateInscription`, `uti_confirmation`, `uti_rol_id_ce`) VALUES
(7, 'Vincenzo', 'test', 'aptruchon@gmail.com', '$2y$10$pxf6IMqcUU.gvIZoo9wFYevTJMILGSNzuyH78yF1/IIM4eIe3JEeC', '2022-09-21 12:39:36', '', 2),
(8, 'Alex', 'Poulin Truchon', 'truchonable@gmail.com', '$2y$10$eRuimJEoZe9SXduE5V13yObJCSkpqfRcUBR8JR57YoIJWmyIxdR.S', '2022-09-22 10:05:25', '', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`cat_id`);

--
-- Index pour la table `enchere`
--
ALTER TABLE `enchere`
  ADD PRIMARY KEY (`enc_id`),
  ADD KEY `enchere_ibfk_1` (`enc_uti_id_ce`);

--
-- Index pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD PRIMARY KEY (`fav_uti_id_ce`,`fav_enc_id_ce`),
  ADD KEY `fk_utilisateur_has_enchere_enchere1_idx` (`fav_enc_id_ce`),
  ADD KEY `fk_utilisateur_has_enchere_utilisateur_idx` (`fav_uti_id_ce`);

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`img_id`,`img_tim_id_ce`),
  ADD KEY `fk_image_timbre1_idx` (`img_tim_id_ce`);

--
-- Index pour la table `mise`
--
ALTER TABLE `mise`
  ADD PRIMARY KEY (`mis_uti_id_ce`,`mis_enc_id_ce`),
  ADD KEY `fk_utilisateur_has_enchere_enchere2_idx` (`mis_enc_id_ce`),
  ADD KEY `fk_utilisateur_has_enchere_utilisateur1_idx` (`mis_uti_id_ce`);

--
-- Index pour la table `pays`
--
ALTER TABLE `pays`
  ADD PRIMARY KEY (`pay_id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`rol_id`);

--
-- Index pour la table `timbre`
--
ALTER TABLE `timbre`
  ADD PRIMARY KEY (`tim_id`,`tim_enc_id_ce`),
  ADD KEY `fk_timbre_enchere1_idx` (`tim_enc_id_ce`),
  ADD KEY `fk_timbre_categorie1_idx` (`tim_cat_id_ce`),
  ADD KEY `fk_timbre_pays1_idx` (`tim_pay_id_ce`),
  ADD KEY `tim_uti_id_ce` (`tim_uti_id_ce`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`uti_id`,`uti_rol_id_ce`),
  ADD KEY `fk_utilisateur_role1_idx` (`uti_rol_id_ce`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `enchere`
--
ALTER TABLE `enchere`
  MODIFY `enc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `pays`
--
ALTER TABLE `pays`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `rol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `timbre`
--
ALTER TABLE `timbre`
  MODIFY `tim_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `uti_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD CONSTRAINT `fk_utilisateur_has_enchere_enchere1` FOREIGN KEY (`fav_enc_id_ce`) REFERENCES `enchere` (`enc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_utilisateur_has_enchere_utilisateur` FOREIGN KEY (`fav_uti_id_ce`) REFERENCES `utilisateur` (`uti_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `fk_image_timbre1` FOREIGN KEY (`img_tim_id_ce`) REFERENCES `timbre` (`tim_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `mise`
--
ALTER TABLE `mise`
  ADD CONSTRAINT `fk_utilisateur_has_enchere_enchere2` FOREIGN KEY (`mis_enc_id_ce`) REFERENCES `enchere` (`enc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_utilisateur_has_enchere_utilisateur1` FOREIGN KEY (`mis_uti_id_ce`) REFERENCES `utilisateur` (`uti_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `timbre`
--
ALTER TABLE `timbre`
  ADD CONSTRAINT `fk_timbre_categorie1` FOREIGN KEY (`tim_cat_id_ce`) REFERENCES `categorie` (`cat_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_timbre_enchere1` FOREIGN KEY (`tim_enc_id_ce`) REFERENCES `enchere` (`enc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_timbre_pays1` FOREIGN KEY (`tim_pay_id_ce`) REFERENCES `pays` (`pay_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `fk_utilisateur_role1` FOREIGN KEY (`uti_rol_id_ce`) REFERENCES `role` (`rol_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
