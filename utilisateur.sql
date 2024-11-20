-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 31 mai 2024 à 14:56
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `utilisateur`
--

-- --------------------------------------------------------

--
-- Structure de la table `demandes_conge`
--

CREATE TABLE `demandes_conge` (
  `id_demande` int(11) NOT NULL,
  `date_debut` text NOT NULL,
  `date_fin` date NOT NULL,
  `motif` varchar(255) NOT NULL,
  `email_utilisateur` varchar(255) NOT NULL,
  `statut` varchar(255) NOT NULL,
  `solde_conges` int(30) NOT NULL DEFAULT 30
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `demandes_conge`
--

INSERT INTO `demandes_conge` (`id_demande`, `date_debut`, `date_fin`, `motif`, `email_utilisateur`, `statut`, `solde_conges`) VALUES
(3, '2024-05-30', '2024-06-09', 'Congé pour évènements familiaux', 'hajer@gmail.com', 'rejeter', 30),
(4, '2024-05-07', '2024-05-19', 'Maladie', 'hajer@gmail.com', 'en attente', 30),
(5, '2024-05-01', '2024-05-30', 'Vacances', 'fatma@gmail.com', 'rejeter', 30),
(6, '2024-05-11', '2024-05-14', 'Rendez-vous médical', 'selya@gmail.com', 'approuver', 30),
(8, '2024-05-03', '2024-05-17', 'Vacances', 'olfa@gmail.com', 'approuver', 30),
(14, '2024-07-11', '2024-07-12', 'Congé pour évènements familiaux', 'hajer@gmail.com', 'en attente', 30),
(15, '2024-05-14', '2024-05-15', 'Maladie', 'hajer@gmail.com', 'en attente', 30);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('personnel','administrateur') NOT NULL,
  `solde_conges` int(30) NOT NULL DEFAULT 30
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `email`, `mot_de_passe`, `role`, `solde_conges`) VALUES
(1, 'ben ahmed amine', 'amine@gmail.com', 'essat', 'administrateur', 30),
(2, 'Fatma Benali', 'fatma@gmail.com', 'essat', 'personnel', 0),
(3, 'Hela Benali', 'hela@gmail.com', 'essat', 'personnel', 30),
(4, 'Olfa Benali', 'olfa@gmail.com', 'essat', 'personnel', 15),
(5, 'Selya Benali', 'selya@gmail.com', 'essat', 'personnel', 30),
(6, 'Hajer Benali', 'hajer@gmail.com', 'essat', 'personnel', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `demandes_conge`
--
ALTER TABLE `demandes_conge`
  ADD PRIMARY KEY (`id_demande`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `demandes_conge`
--
ALTER TABLE `demandes_conge`
  MODIFY `id_demande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
