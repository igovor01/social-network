-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 12, 2019 at 08:48 AM
-- Server version: 5.5.54
-- PHP Version: 5.3.10-1ubuntu3.26

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Table structure for table `Cards`
--

CREATE TABLE IF NOT EXISTS `Cards` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(250) NOT NULL,
  `ImageUrl` varchar(250) NOT NULL,
  `Description` text NOT NULL,
  `Liked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `Cards`
--

INSERT INTO `Cards` (`ID`, `Title`, `ImageUrl`, `Description`, `Liked`) VALUES
(2, 'Kozjak', 'images/newsHeadings/kozjak.jpg', 'Kozjak je planina koja sa sjeverne strane okružuje grad Kaštela. Njegova je južna padina vrlo strma i klisurasta, a sjeverni kameniti obronci postupno prelaze u valovitu visoravan Dalmatinske Zagore.', 0),
(3, 'Cetina', 'images/newsHeadings/cetina.jpg', 'Cetina izvire na nadmorskoj visini od 385 m u sjeverozapadnim obroncima Dinare blizu sela Cetina, 7 km sjeverno od Vrlike, a po kojem je rijeka i dobila ime. Izvor Cetine je jezero duboko preko stotinu metara.', 0),
(4, 'Primošten', 'images/newsHeadings/primosten.jpg', 'Tijekom turske invazije 1542., otočić na kojemu se nalazi Primošten je bio zaštićen zidovima i kulama i sa pomičnim mostom koji ga je spajao s kopnom. Kad su se Turci povukli, most je zamijenjen nasipom, a naselje je nazvano "Primošten", od riječi "primostiti" (premostiti).', 0),
(5, 'Katedrala', 'images/newsHeadings/sibenik.jpg', 'Katedrala Sv. Jakova u Šibeniku najznačajnije je graditeljsko ostvarenje 15. i 16. st. na tlu Hrvatske. Zbog svojih iznimnih vrijednosti katedrala je 2000. godine uvrštena u UNESCO-ov popis svjetskog kulturnog nasljeđa.', 1),
(6, 'Svilaja', 'images/newsHeadings/svilaja.jpg', 'Svilaja je planina u Dalmatinskoj Zagori, usporedna s višim sjevernijim lancem Dinara-Troglav. Pruža se smjerom sjeverozapad-jugoistok između Sinjskoga i Petrovog polja u dužini oko 30 km.', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
