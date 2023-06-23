/*BASE DE DATOS BUSCADOR Bootstrap PHP Mysql V1.7*/
SHOW DATABASES;

CREATE DATABASE webSiteStore;
USE webSiteStore;

CREATE TABLE IF NOT EXISTS `sitesInformation`(
	`site_id_pk` INT(11) NOT NULL AUTO_INCREMENT,
	`site_title` VARCHAR(45) NOT NULL,
	`site_description` VARCHAR(200) NOT NULL,
	`site_url` VARCHAR(100) NOT NULL,
	PRIMARY KEY (`site_id_pk`)
);

CREATE TABLE IF NOT EXISTS `keywords`(
    `id_keyword` INT(11) NOT NULL AUTO_INCREMENT,
	`tag_keyword` VARCHAR(45) NOT NULL,
	PRIMARY KEY (`id_keyword`)
);

CREATE TABLE IF NOT EXISTS `users`(
     `user_id` INT(11) NOT NULL AUTO_INCREMENT,
	 `user_mail` VARCHAR(45) UNIQUE NOT NULL,
	 `user_password` VARCHAR(225) NOT NULL,
	 PRIMARY KEY(`user_id`)
);

CREATE TABLE IF NOT EXISTS `sitesInf_keywrd`(
	`id_keywords_fk` INT(11) NOT NULL,
	`id_site_fk` INT(11) NOT NULL,
	CONSTRAINT FOREIGN KEY (`id_keywords_fk`) REFERENCES keywords(`id_keyword`),
	CONSTRAINT FOREIGN KEY (`id_site_fk`) REFERENCES sitesInformation(`site_id_pk`)
);

/*Procedimiento para registrar usuarios*/
DELIMITER //
CREATE PROCEDURE save_user( IN `user_mail` VARCHAR(255), IN `user_password` VARCHAR(255))
BEGIN
  DECLARE encrypted_password VARCHAR(255);
  SET encrypted_password = MD5(`user_password`);

  INSERT INTO `users` (`user_mail`,`user_password`) VALUES (`user_mail`, `encrypted_password`);
END //
DELIMITER ;

SET GLOBAL log_bin_trust_function_creators = 1;

/*Funcion para registrar sitios web*/
DELIMITER // 
CREATE FUNCTION save_sites(`title` VARCHAR(45), `description` VARCHAR(200), `url` VARCHAR(250)) RETURNS INT
BEGIN
    DECLARE `sites_id` INT;
    
    SELECT `site_id_pk` INTO `sites_id` FROM `sitesInformation` WHERE `site_url` = `url`;
    
    IF `sites_id` IS NOT NULL THEN
        RETURN -1; 
    END IF;

    INSERT INTO `sitesInformation` (`site_title`, `site_description`, `site_url`) VALUES (`title`, `description`, `url`);

    SELECT `site_id_pk` INTO `sites_id` FROM `sitesInformation` WHERE `site_url` = `url`;
    RETURN `sites_id`;
END//
DELIMITER ;

/*Funcion para registrar palabras clave*/
DELIMITER //
CREATE FUNCTION save_keyword(`keyword` VARCHAR(255)) RETURNS INT
BEGIN
    DECLARE `keywords_id` INT;
    SELECT `id_keyword` INTO `keywords_id` FROM `keywords` WHERE `keyword` = `tag_keyword`;
    
    IF `keywords_id` IS NOT NULL THEN
        RETURN `keywords_id`; 
    END IF;

    INSERT INTO `keywords` (`tag_keyword`) VALUES (`keyword`);
    SELECT `id_keyword` INTO `keywords_id` FROM `keywords` WHERE `keyword` = `tag_keyword`;
    RETURN `keywords_id`; 
END//
DELIMITER ;

/*Procedimiento para almacenar relaciones*/
DELIMITER //
CREATE PROCEDURE save_site_keyword(IN `id_keyword` INT(11), IN `id_site` INT(11))
BEGIN
  INSERT INTO `sitesInf_keywrd`(`id_keywords_fk`,`id_site_fk`) VALUES (`id_keyword`,`id_site`);
END //
DELIMITER ;

/*Procedimiento para eliminar sitios web*/
DELIMITER // 
CREATE PROCEDURE delete_sites(IN `id` INT(11))
BEGIN 
   DELETE FROM `sitesInformation` WHERE `site_id_pk` = `id`;
   DELETE FROM `sitesInf_keywrd` WHERE `id_site_fk` = `id`;
END //
DELIMITER ;

CALL save_user('jhondoe@correo.com','abcd123');

SELECT save_sites('Portafolio', 'Portafolio Web Daniel Quintero', 'https://danielo27.github.io/Danielo27/');
SELECT save_keyword('portafolio');
CALL save_site_keyword(1,1);
CALL delete_sites(1);

