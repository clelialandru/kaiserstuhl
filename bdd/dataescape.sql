-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 29 avr. 2024 à 18:53
-- Version du serveur : 5.7.33
-- Version de PHP : 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dataescape`
--

-- --------------------------------------------------------

--
-- Structure de la table `commander`
--

CREATE TABLE `commander` (
  `id_commande` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL,
  `id_package` int(11) NOT NULL,
  `date` date NOT NULL,
  `adresse_postal` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `escape_game`
--

CREATE TABLE `escape_game` (
  `id_game` int(11) NOT NULL,
  `nom` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `localisation` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` decimal(10,0) NOT NULL,
  `duree` time NOT NULL,
  `parking` tinyint(1) NOT NULL,
  `accebilite` tinyint(1) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `linkYTB` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `escape_game`
--

INSERT INTO `escape_game` (`id_game`, `nom`, `localisation`, `adresse`, `prix`, `duree`, `parking`, `accebilite`, `latitude`, `longitude`, `linkYTB`) VALUES
(1, 'Vinea Flamara', 'Ihringen', 'August-Meier-Weg 1, 79241 Ihringen, Allemagne', '105', '06:00:00', 0, 1, 48.0479, 7.64924, 'https://youtu.be/nB4EnEo39N8'),
(2, 'Exemple2', 'Climbach', '1er rue de Bitche, 67510 Climbach, France', '200', '02:00:00', 1, 0, 49.0173, 7.84526, ''),
(3, 'Gourde', 'Mulhouse sur brurne', '3 Rue des Frères Lumière, 68100 Mulhouse', '130', '01:00:00', 1, 1, 47.7309, 7.3007, '');

-- --------------------------------------------------------

--
-- Structure de la table `info_general`
--

CREATE TABLE `info_general` (
  `id_info` int(11) NOT NULL,
  `num_tel` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `info_general`
--

INSERT INTO `info_general` (`id_info`, `num_tel`, `mail`, `adresse`) VALUES
(2, '07668 996660', 'booking@we-escape.de', 'adresse');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(11) NOT NULL,
  `nom` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` text COLLATE utf8mb4_unicode_ci,
  `role` enum('client','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_tel` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `nom`, `prenom`, `mdp`, `email`, `role`, `num_tel`) VALUES
(1, 'KOCHERT', 'Nicolas', '5778b11ffee03de0b5ce042383fcb4ae30820f144a9d04a8945b5edf676a05bd', 'kochert.nicolas@gmail.com', 'admin', NULL),
(2, 'LANDRU\r\n', 'Clélia', '5778b11ffee03de0b5ce042383fcb4ae30820f144a9d04a8945b5edf676a05bd', 'clelia.landru@uha.fr', 'admin', NULL),
(3, 'HAUPTMANN-HERBETTE', 'Ludovic', '5778b11ffee03de0b5ce042383fcb4ae30820f144a9d04a8945b5edf676a05bd', 'ludovic.hauptmann-herbette@uha.fr', 'admin', NULL),
(4, 'PERNAUT', 'Jean-Pierre', '0d5f8b383a98e095654df2112e4c48bacbd12ae35cfc0fe50145bebca7b513fa', 'pernault@gmail.com', 'client', '01.23.45.67.89');

-- --------------------------------------------------------

--
-- Structure de la table `package`
--

CREATE TABLE `package` (
  `id_package` int(11) NOT NULL,
  `nom` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` decimal(10,0) NOT NULL,
  `temps_livré` int(11) NOT NULL,
  `type` enum('carte','cadeau') COLLATE utf8mb4_unicode_ci NOT NULL,
  `hauteur` float NOT NULL,
  `largeur` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `package`
--

INSERT INTO `package` (`id_package`, `nom`, `prix`, `temps_livré`, `type`, `hauteur`, `largeur`) VALUES
(1, 'Carte cadeau', '0', 0, 'carte', 0, 0),
(2, 'Puzzle El Nico test', '144', 21, 'cadeau', 0, 0),
(3, 'David', '1444', 3, 'cadeau', 2, 3),
(4, 'cailloux', '2', 93, 'cadeau', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `reserver`
--

CREATE TABLE `reserver` (
  `id_reservation` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL,
  `id_game` int(11) NOT NULL,
  `nbr_personne` int(11) NOT NULL,
  `date` date NOT NULL,
  `crenaux` enum('8:00','10:00','14:00','16:00','18:00') COLLATE utf8mb4_unicode_ci NOT NULL,
  `annulation` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reserver`
--

INSERT INTO `reserver` (`id_reservation`, `id_membre`, `id_game`, `nbr_personne`, `date`, `crenaux`, `annulation`) VALUES
(1, 4, 1, 2, '2024-04-30', '10:00', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commander`
--
ALTER TABLE `commander`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `id_membre` (`id_membre`),
  ADD KEY `id_package` (`id_package`);

--
-- Index pour la table `escape_game`
--
ALTER TABLE `escape_game`
  ADD PRIMARY KEY (`id_game`);

--
-- Index pour la table `info_general`
--
ALTER TABLE `info_general`
  ADD PRIMARY KEY (`id_info`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Index pour la table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`id_package`);

--
-- Index pour la table `reserver`
--
ALTER TABLE `reserver`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `id_membre` (`id_membre`),
  ADD KEY `id_game` (`id_game`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commander`
--
ALTER TABLE `commander`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `escape_game`
--
ALTER TABLE `escape_game`
  MODIFY `id_game` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `info_general`
--
ALTER TABLE `info_general`
  MODIFY `id_info` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `package`
--
ALTER TABLE `package`
  MODIFY `id_package` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `reserver`
--
ALTER TABLE `reserver`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commander`
--
ALTER TABLE `commander`
  ADD CONSTRAINT `commander_ibfk_1` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`),
  ADD CONSTRAINT `commander_ibfk_2` FOREIGN KEY (`id_package`) REFERENCES `package` (`id_package`);

--
-- Contraintes pour la table `reserver`
--
ALTER TABLE `reserver`
  ADD CONSTRAINT `reserver_ibfk_1` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`),
  ADD CONSTRAINT `reserver_ibfk_2` FOREIGN KEY (`id_game`) REFERENCES `escape_game` (`id_game`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;