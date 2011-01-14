SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Sistema de Log
-- 
CREATE DATABASE `megiddo` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE megiddo;

CREATE TABLE `log` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`file` VARCHAR( 255 ) NOT NULL ,
`message` TEXT NOT NULL ,
`is_error` BOOL NOT NULL DEFAULT '1',
INDEX ( `date` , `is_error` )
) ENGINE = InnoDB;

--
-- Sistema de internacionalização
--
CREATE TABLE IF NOT EXISTS `tag` (
  `id_tag` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) NOT NULL,
  PRIMARY KEY (`id_tag`),
  UNIQUE KEY `tag` (`tag`),
  KEY `tag_2` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `tag_i18n` (
  `id_tag_i18n` int(11) NOT NULL AUTO_INCREMENT,
  `id_tag` int(11) NOT NULL,
  `isolang` varchar(10) NOT NULL,
  `translate` text NOT NULL,
  PRIMARY KEY (`id_tag_i18n`),
  KEY `id_tag` (`id_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Restrições para a tabela `tag_i18n`
--
ALTER TABLE `tag_i18n`
  ADD CONSTRAINT `tag_i18n_ibfk_1` FOREIGN KEY (`id_tag`) REFERENCES `tag` (`id_tag`) ON DELETE CASCADE ON UPDATE CASCADE;
  
--
-- Estrutura da tabela `culture`
--

CREATE TABLE IF NOT EXISTS `culture` (
  `isolang` varchar(255) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`isolang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `culture`
--

INSERT INTO `culture` (`isolang`, `default`) VALUES
('en_US', 0),
('pt_BR', 1);  
