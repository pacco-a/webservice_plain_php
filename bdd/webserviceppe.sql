-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : Dim 25 avr. 2021 à 20:28
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `webserviceppe`
--

-- --------------------------------------------------------

--
-- Structure de la table `cabinet`
--

CREATE TABLE `cabinet` (
  `id` tinyint(4) NOT NULL,
  `nom` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `cabinet`
--

INSERT INTO `cabinet` (`id`, `nom`) VALUES
(1, 'cabinet_1'),
(2, 'cabinet_2'),
(3, 'cabinet_3');

-- --------------------------------------------------------

--
-- Structure de la table `medecin`
--

CREATE TABLE `medecin` (
  `id` tinyint(3) NOT NULL,
  `nom` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `medecin`
--

INSERT INTO `medecin` (`id`, `nom`) VALUES
(1, 'medecin_1'),
(2, 'medecin_2'),
(3, 'medecin_3');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` tinyint(3) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(50) NOT NULL,
  `current_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `current_token`) VALUES
(1, 'pacco', 'pacco', '13202351-d658-4e6e-a509-c9e493445ef2/29-04-2021'),
(2, 'gab', 'test', 'f625aea9-2402-43b6-bde2-2c736d8c9960/28-04-2021'),
(3, 'theo', 'theo', '7819399c-590b-42e1-9d05-014db609fa7d/05-05-2021');

-- --------------------------------------------------------

--
-- Structure de la table `visite`
--

CREATE TABLE `visite` (
  `id` tinyint(4) NOT NULL,
  `id_visiteur` tinyint(3) NOT NULL,
  `id_cabinet` tinyint(4) NOT NULL,
  `id_medecin` tinyint(3) NOT NULL,
  `date_visite` date NOT NULL,
  `sur_rdv` tinyint(1) NOT NULL,
  `heure_arrivee` tinyint(4) NOT NULL,
  `heure_debut` tinyint(4) NOT NULL,
  `heure_depart` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `visite`
--

INSERT INTO `visite` (`id`, `id_visiteur`, `id_cabinet`, `id_medecin`, `date_visite`, `sur_rdv`, `heure_arrivee`, `heure_debut`, `heure_depart`) VALUES
(2, 2, 2, 2, '2021-12-01', 0, 12, 13, 14),
(3, 1, 2, 2, '2021-12-01', 0, 12, 13, 14),
(4, 3, 2, 2, '2021-12-01', 0, 12, 13, 14);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cabinet`
--
ALTER TABLE `cabinet`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `medecin`
--
ALTER TABLE `medecin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `visite`
--
ALTER TABLE `visite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cabinet` (`id_cabinet`),
  ADD KEY `id_medecin` (`id_medecin`),
  ADD KEY `id_visiteur` (`id_visiteur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cabinet`
--
ALTER TABLE `cabinet`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `medecin`
--
ALTER TABLE `medecin`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `visite`
--
ALTER TABLE `visite`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `visite`
--
ALTER TABLE `visite`
  ADD CONSTRAINT `visite_ibfk_1` FOREIGN KEY (`id_cabinet`) REFERENCES `cabinet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visite_ibfk_2` FOREIGN KEY (`id_medecin`) REFERENCES `medecin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visite_ibfk_3` FOREIGN KEY (`id_visiteur`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
