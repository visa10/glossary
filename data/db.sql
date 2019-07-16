CREATE TABLE IF NOT EXISTS `cоuntries` (
  `id_country` INT(11) NOT NULL AUTO_INCREMENT,
  `country_name` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id_country`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS `cites` (
  `id_city` INT(11) NOT NULL AUTO_INCREMENT,
  `id_country` INT(11) NOT NULL,
  `city_name` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`id_city`),
  FOREIGN KEY (id_country) 
    REFERENCES cоuntries(id_country)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS `cоuntries` (
  `id_country` INT(11) NOT NULL AUTO_INCREMENT,
  `country_name` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id_country`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS `invites` (
  `invite` VARCHAR(6) NOT NULL,
  `status` INT(1) NOT NULL DEFAULT 0,
  `date_status_` TIMESTAMP NOT NULL DEFAULT 0,
  PRIMARY KEY (`invite`),
  UNIQUE (invite)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` INT(11) NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(20) NOT NULL,
  `password` VARCHAR(20) NOT NULL,
  `phone` VARCHAR(15) NOT NULL,
  `id_city` INT(11) NOT NULL,
  `invate` VARCHAR(255) NOT NULL,    
  PRIMARY KEY (`id_user`),

  FOREIGN KEY (id_city)
      REFERENCES cites(id_city),
  FOREIGN KEY (invate)
      REFERENCES invites(invite)
  
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

INSERT INTO cоuntries VALUES (1, 'Украина');
INSERT INTO cоuntries VALUES (2, 'Россия');

INSERT INTO cites VALUES (1, 1, 'Харьков');
INSERT INTO cites VALUES (2, 1, 'Одесса');
INSERT INTO cites VALUES (3, 1, 'Киев');
INSERT INTO cites VALUES (4, 1, 'Днепропетровск');
INSERT INTO cites VALUES (5, 1, 'Донецк');
INSERT INTO cites VALUES (6, 1, 'Львов');

INSERT INTO cites VALUES (7, 2, 'Москва');
INSERT INTO cites VALUES (8, 2, 'Санкт-Петербург');
INSERT INTO cites VALUES (9, 2, 'Белгород');
INSERT INTO cites VALUES (10, 2, 'Курск');
INSERT INTO cites VALUES (11, 2, 'Ульяновск');


INSERT INTO  `invites` (`invite`) VALUES ('123466');
INSERT INTO invites (invite) VALUES ('123416');
INSERT INTO invites (invite) VALUES ('654321');





