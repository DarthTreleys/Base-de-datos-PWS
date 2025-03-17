--
-- Base de dades: `ASIX2`
--
CREATE DATABASE IF NOT EXISTS `ASIX2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
USE `ASIX2`;

-- --------------------------------------------------------

--
-- Estructura de la taula `comentaris`
--

DROP TABLE IF EXISTS `comentaris`;
CREATE TABLE IF NOT EXISTS `comentaris` (
  `id_c` int(11) NOT NULL AUTO_INCREMENT,
  `missatge` varchar(200) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_u` int(11) NOT NULL,
  PRIMARY KEY (`id_c`),
  KEY `comentari_usuari` (`id_u`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `fitxers`
--

DROP TABLE IF EXISTS `fitxers`;
CREATE TABLE IF NOT EXISTS `fitxers` (
  `id_f` int(11) NOT NULL AUTO_INCREMENT,
  `ruta_fitxer` varchar(300) NOT NULL,
  `tipus_fitxer` varchar(50) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_u` int(11) NOT NULL,
  PRIMARY KEY (`id_f`),
  KEY `fitxer_usuari` (`id_u`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `usuaris`
--

DROP TABLE IF EXISTS `usuaris`;
CREATE TABLE IF NOT EXISTS `usuaris` (
  `id_u` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_u`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Restriccions per a les taules bolcades
--

--
-- Restriccions per a la taula `comentaris`
--
ALTER TABLE `comentaris`
  ADD CONSTRAINT `comentari_usuari` FOREIGN KEY (`id_u`) REFERENCES `usuaris` (`id_u`);

--
-- Restriccions per a la taula `fitxers`
--
ALTER TABLE `fitxers`
  ADD CONSTRAINT `fitxer_usuari` FOREIGN KEY (`id_u`) REFERENCES `usuaris` (`id_u`);
COMMIT;
