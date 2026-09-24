-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 18, 2026 at 06:58 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `schema`
--
CREATE DATABASE IF NOT EXISTS `schema` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci;
USE `schema`;

-- --------------------------------------------------------

--
-- Table structure for table `historial`
--

CREATE TABLE `historial` (
  `idHistorial` int NOT NULL,
  `idUsuario` int NOT NULL,
  `idUsuarioPelicula` int DEFAULT NULL,
  `idUsuarioSerie` int DEFAULT NULL,
  `idUsuarioTemporada` int DEFAULT NULL,
  `idUsuarioEpisodio` int DEFAULT NULL,
  `idUsuarioJuego` int DEFAULT NULL,
  `idUsuarioLibro` int DEFAULT NULL,
  `nombreHistorial` varchar(1000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `accionHistorial` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `fechaHistorial` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Table structure for table `juegos`
--

CREATE TABLE `juegos` (
  `idJuego` int NOT NULL,
  `idApi` int NOT NULL,
  `nombreJuego` varchar(1000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `desarrolladorJuego` varchar(3000) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `editorJuego` varchar(3000) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `anoJuego` int DEFAULT NULL,
  `franquiciaJuego` varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `generoJuego` varchar(3000) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `plataformasJuego` varchar(2000) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `dlcJuego` varchar(5000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `expansionJuego` varchar(3000) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `duracionJuego` varchar(10) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `ratingAvgJuego` decimal(2,1) DEFAULT NULL,
  `posterJuego` varchar(500) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `sinopsisJuego` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Table structure for table `libros`
--

CREATE TABLE `libros` (
  `idLibro` int NOT NULL,
  `idApi` varchar(500) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `nombreLibro` varchar(1000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `autorLibro` varchar(1000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `anoLibro` int DEFAULT NULL,
  `generoLibro` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `temaLibro` text COLLATE utf8mb3_spanish_ci,
  `paginasLibro` int DEFAULT NULL,
  `edicionesLibro` int DEFAULT NULL,
  `idiomaLibro` text COLLATE utf8mb3_spanish_ci,
  `ratingAvgLibro` decimal(2,1) DEFAULT NULL,
  `posterLibro` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `sinopsisLibro` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Table structure for table `peliculas`
--

CREATE TABLE `peliculas` (
  `idPelicula` int NOT NULL,
  `idApi` int NOT NULL,
  `nombrePelicula` varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `directorPelicula` varchar(2000) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `actorPelicula` varchar(5000) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `guionistaPelicula` varchar(3000) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `generoPelicula` varchar(3000) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `anoPelicula` int DEFAULT NULL,
  `companiaPelicula` varchar(3000) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `duracionPelicula` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `ratingAvgPelicula` decimal(2,1) DEFAULT NULL,
  `paisPelicula` varchar(1000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `idiomaPelicula` varchar(3000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `posterPelicula` varchar(500) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `sinopsisPelicula` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Table structure for table `series`
--

CREATE TABLE `series` (
  `idSerie` int NOT NULL,
  `idApi` int NOT NULL,
  `nombreSerie` varchar(1000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `creadorSerie` varchar(2000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `directorSerie` varchar(3000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `actorSerie` varchar(5000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `companiaSerie` varchar(1000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `guionistaSerie` varchar(3000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `generoSerie` text COLLATE utf8mb3_spanish_ci,
  `anoSerie` int DEFAULT NULL,
  `temporadasSerie` int DEFAULT NULL,
  `episodiosSerie` int DEFAULT NULL,
  `ratingAvgSerie` decimal(2,1) DEFAULT NULL,
  `paisSerie` varchar(1000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `idiomaSerie` text COLLATE utf8mb3_spanish_ci,
  `posterSerie` varchar(500) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `sinopsisSerie` text COLLATE utf8mb3_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Table structure for table `seriesepisodios`
--

CREATE TABLE `seriesepisodios` (
  `idEpisodio` int NOT NULL,
  `idApi` int NOT NULL,
  `idTemporada` int NOT NULL,
  `nombreEpisodio` varchar(1000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `numeroEpisodio` int DEFAULT NULL,
  `directorEpisodio` varchar(2000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `actorEpisodio` varchar(4000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `guionistaEpisodio` varchar(4000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `anoEpisodio` int DEFAULT NULL,
  `duracionEpisodio` varchar(10) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `ratingAvgEpisodio` decimal(2,1) DEFAULT NULL,
  `posterEpisodio` varchar(500) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `sinopsisEpisodio` text COLLATE utf8mb3_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seriestemporadas`
--

CREATE TABLE `seriestemporadas` (
  `idTemporada` int NOT NULL,
  `idApi` int NOT NULL,
  `idSerie` int NOT NULL,
  `nombreTemporada` varchar(2000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `numeroTemporada` int DEFAULT NULL,
  `directorTemporada` varchar(2000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `guionistaTemporada` varchar(3000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `actorTemporada` varchar(5000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `episodiosTemporada` int DEFAULT NULL,
  `anoTemporada` int DEFAULT NULL,
  `ratingAvgTemporada` decimal(2,1) DEFAULT NULL,
  `posterTemporada` varchar(500) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `sinopsisTemporada` text COLLATE utf8mb3_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int NOT NULL,
  `username` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `nombreUsuario` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `contrasena` varchar(250) COLLATE utf8mb3_spanish_ci NOT NULL,
  `avatar` varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Table structure for table `usuariosxepisodios`
--

CREATE TABLE `usuariosxepisodios` (
  `idUsuarioEpisodio` int NOT NULL,
  `idUsuario` int NOT NULL,
  `idEpisodio` int NOT NULL,
  `ratingEpisodio` decimal(2,1) DEFAULT NULL,
  `favEpisodio` tinyint(1) DEFAULT '0',
  `pendienteEpisodio` tinyint(1) DEFAULT '0',
  `fechaEpisodio` date DEFAULT NULL,
  `notasEpisodio` text COLLATE utf8mb3_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuariosxjuegos`
--

CREATE TABLE `usuariosxjuegos` (
  `idUsuarioJuego` int NOT NULL,
  `idUsuario` int NOT NULL,
  `idJuego` int NOT NULL,
  `ratingJuego` decimal(2,1) DEFAULT NULL,
  `favJuego` tinyint(1) DEFAULT '0',
  `pendienteJuego` tinyint(1) DEFAULT '0',
  `fechaInicioJuego` date DEFAULT NULL,
  `fechaJuego` date DEFAULT NULL,
  `plataformaJuego` varchar(50) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `notasJuego` text COLLATE utf8mb3_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Table structure for table `usuariosxlibros`
--

CREATE TABLE `usuariosxlibros` (
  `idUsuarioLibro` int NOT NULL,
  `idUsuario` int NOT NULL,
  `idLibro` int NOT NULL,
  `ratingLibro` decimal(2,1) DEFAULT NULL,
  `favLibro` tinyint(1) DEFAULT '0',
  `pendienteLibro` tinyint(1) DEFAULT '0',
  `fechaInicioLibro` date DEFAULT NULL,
  `fechaLibro` date DEFAULT NULL,
  `notasLibro` text COLLATE utf8mb3_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Table structure for table `usuariosxpeliculas`
--

CREATE TABLE `usuariosxpeliculas` (
  `idUsuarioPelicula` int NOT NULL,
  `idUsuario` int NOT NULL,
  `idPelicula` int NOT NULL,
  `ratingPelicula` decimal(2,1) DEFAULT NULL,
  `favPelicula` tinyint(1) DEFAULT '0',
  `pendientePelicula` tinyint(1) DEFAULT '0',
  `fechaPelicula` date DEFAULT NULL,
  `notasPelicula` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Table structure for table `usuariosxseries`
--

CREATE TABLE `usuariosxseries` (
  `idUsuarioSerie` int NOT NULL,
  `idUsuario` int NOT NULL,
  `idSerie` int NOT NULL,
  `ratingSerie` decimal(2,1) DEFAULT NULL,
  `favSerie` tinyint(1) DEFAULT '0',
  `pendienteSerie` tinyint(1) DEFAULT '0',
  `fechaSerie` date DEFAULT NULL,
  `estadoSerie` varchar(500) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `notasSerie` text COLLATE utf8mb3_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Table structure for table `usuariosxtemporadas`
--

CREATE TABLE `usuariosxtemporadas` (
  `idUsuarioTemporada` int NOT NULL,
  `idUsuario` int NOT NULL,
  `idTemporada` int NOT NULL,
  `ratingTemporada` decimal(2,1) DEFAULT NULL,
  `favTemporada` tinyint(1) DEFAULT '0',
  `pendienteTemporada` tinyint(1) DEFAULT '0',
  `fechaTemporada` date DEFAULT NULL,
  `notasTemporada` text COLLATE utf8mb3_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`idHistorial`),
  ADD KEY `FK idUsuario historial` (`idUsuario`) USING BTREE;

--
-- Indexes for table `juegos`
--
ALTER TABLE `juegos`
  ADD PRIMARY KEY (`idJuego`),
  ADD UNIQUE KEY `idApiJuego` (`idApi`);

--
-- Indexes for table `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`idLibro`),
  ADD UNIQUE KEY `idApiLibro` (`idApi`) USING BTREE;

--
-- Indexes for table `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`idPelicula`),
  ADD UNIQUE KEY `idApiPelicula` (`idApi`) USING BTREE;

--
-- Indexes for table `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`idSerie`),
  ADD UNIQUE KEY `idApiSerie` (`idApi`) USING BTREE;

--
-- Indexes for table `seriesepisodios`
--
ALTER TABLE `seriesepisodios`
  ADD PRIMARY KEY (`idEpisodio`),
  ADD UNIQUE KEY `idApi Episodio` (`idApi`),
  ADD UNIQUE KEY `UnicasEpisodio` (`idTemporada`,`numeroEpisodio`);

--
-- Indexes for table `seriestemporadas`
--
ALTER TABLE `seriestemporadas`
  ADD PRIMARY KEY (`idTemporada`),
  ADD UNIQUE KEY `idApi Temporada` (`idApi`) USING BTREE,
  ADD UNIQUE KEY `UnicasTemporada` (`idSerie`,`numeroTemporada`) USING BTREE,
  ADD KEY `FK idSerie seriestemporadas` (`idSerie`) USING BTREE;

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `usuariosxepisodios`
--
ALTER TABLE `usuariosxepisodios`
  ADD PRIMARY KEY (`idUsuarioEpisodio`),
  ADD UNIQUE KEY `UnicasEpisodio` (`idEpisodio`,`idUsuario`),
  ADD KEY `FK idUsuario usuariosxepisodios` (`idUsuario`),
  ADD KEY `FK idEpisodio` (`idEpisodio`) USING BTREE;

--
-- Indexes for table `usuariosxjuegos`
--
ALTER TABLE `usuariosxjuegos`
  ADD PRIMARY KEY (`idUsuarioJuego`),
  ADD UNIQUE KEY `UnicasJuego` (`idUsuario`,`idJuego`) USING BTREE,
  ADD KEY `Fk idUsuario usuariosxjuegos` (`idUsuario`),
  ADD KEY `FK idJuego` (`idJuego`) USING BTREE;

--
-- Indexes for table `usuariosxlibros`
--
ALTER TABLE `usuariosxlibros`
  ADD PRIMARY KEY (`idUsuarioLibro`),
  ADD UNIQUE KEY `UnicasLibro` (`idLibro`,`idUsuario`) USING BTREE,
  ADD KEY `FK idUsuario usuariosxlibros` (`idUsuario`),
  ADD KEY `FK idLibro` (`idLibro`) USING BTREE;

--
-- Indexes for table `usuariosxpeliculas`
--
ALTER TABLE `usuariosxpeliculas`
  ADD PRIMARY KEY (`idUsuarioPelicula`),
  ADD UNIQUE KEY `UnicasPelicula` (`idUsuario`,`idPelicula`) USING BTREE,
  ADD KEY `FK idPelicula` (`idPelicula`) USING BTREE,
  ADD KEY `FK idUsuario usuariosxpeliculas` (`idUsuario`);

--
-- Indexes for table `usuariosxseries`
--
ALTER TABLE `usuariosxseries`
  ADD PRIMARY KEY (`idUsuarioSerie`),
  ADD UNIQUE KEY `UnicasSerie` (`idSerie`,`idUsuario`),
  ADD KEY `FK idUsuario usuariosxseries` (`idUsuario`),
  ADD KEY `FK idSerie` (`idSerie`) USING BTREE;

--
-- Indexes for table `usuariosxtemporadas`
--
ALTER TABLE `usuariosxtemporadas`
  ADD PRIMARY KEY (`idUsuarioTemporada`),
  ADD UNIQUE KEY `UnicasTemporada` (`idTemporada`,`idUsuario`),
  ADD KEY `FK idUsuario usuariosxtemporadas` (`idUsuario`),
  ADD KEY `FK idTemporada` (`idTemporada`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `historial`
--
ALTER TABLE `historial`
  MODIFY `idHistorial` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=954;

--
-- AUTO_INCREMENT for table `juegos`
--
ALTER TABLE `juegos`
  MODIFY `idJuego` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `libros`
--
ALTER TABLE `libros`
  MODIFY `idLibro` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `idPelicula` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1181;

--
-- AUTO_INCREMENT for table `series`
--
ALTER TABLE `series`
  MODIFY `idSerie` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `seriesepisodios`
--
ALTER TABLE `seriesepisodios`
  MODIFY `idEpisodio` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `seriestemporadas`
--
ALTER TABLE `seriestemporadas`
  MODIFY `idTemporada` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usuariosxepisodios`
--
ALTER TABLE `usuariosxepisodios`
  MODIFY `idUsuarioEpisodio` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `usuariosxjuegos`
--
ALTER TABLE `usuariosxjuegos`
  MODIFY `idUsuarioJuego` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `usuariosxlibros`
--
ALTER TABLE `usuariosxlibros`
  MODIFY `idUsuarioLibro` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `usuariosxpeliculas`
--
ALTER TABLE `usuariosxpeliculas`
  MODIFY `idUsuarioPelicula` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2186;

--
-- AUTO_INCREMENT for table `usuariosxseries`
--
ALTER TABLE `usuariosxseries`
  MODIFY `idUsuarioSerie` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `usuariosxtemporadas`
--
ALTER TABLE `usuariosxtemporadas`
  MODIFY `idUsuarioTemporada` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `FK idUsuario historial` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `seriesepisodios`
--
ALTER TABLE `seriesepisodios`
  ADD CONSTRAINT `FK idTemporada seriesepisodios` FOREIGN KEY (`idTemporada`) REFERENCES `seriestemporadas` (`idTemporada`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `seriestemporadas`
--
ALTER TABLE `seriestemporadas`
  ADD CONSTRAINT `FK idSerie seriestemporadas` FOREIGN KEY (`idSerie`) REFERENCES `series` (`idSerie`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `usuariosxepisodios`
--
ALTER TABLE `usuariosxepisodios`
  ADD CONSTRAINT `FK idEpisodio usuariosxepisodios` FOREIGN KEY (`idEpisodio`) REFERENCES `seriesepisodios` (`idEpisodio`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK idUsuario usuariosxepisodios` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `usuariosxjuegos`
--
ALTER TABLE `usuariosxjuegos`
  ADD CONSTRAINT `FK idJuego usuariosxjuegos` FOREIGN KEY (`idJuego`) REFERENCES `juegos` (`idJuego`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK idUsuario usuariosxjuegos` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `usuariosxlibros`
--
ALTER TABLE `usuariosxlibros`
  ADD CONSTRAINT `FK idLibro usuariosxlibros` FOREIGN KEY (`idLibro`) REFERENCES `libros` (`idLibro`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK idUsuario usuariosxlibros` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `usuariosxpeliculas`
--
ALTER TABLE `usuariosxpeliculas`
  ADD CONSTRAINT `FK idPelicula usuariosxpeliculas` FOREIGN KEY (`idPelicula`) REFERENCES `peliculas` (`idPelicula`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK idUsuario usuariosxpeliculas` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `usuariosxseries`
--
ALTER TABLE `usuariosxseries`
  ADD CONSTRAINT `FK idSerie usuariosxseries` FOREIGN KEY (`idSerie`) REFERENCES `series` (`idSerie`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK idUsuario usuariosxseries` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `usuariosxtemporadas`
--
ALTER TABLE `usuariosxtemporadas`
  ADD CONSTRAINT `FK idTemporada usuariosxtemporadas` FOREIGN KEY (`idTemporada`) REFERENCES `seriestemporadas` (`idTemporada`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK idUsuario usuariosxtemporadas` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
