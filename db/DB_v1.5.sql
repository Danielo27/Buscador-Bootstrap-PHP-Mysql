/*BASE DE DATOS BUSCADOR Bootstrap PHP Mysql V1.5*/
SHOW DATABASES;
CREATE DATABASE 'searchengine';
USE DATABASE 'searchengine';

CREATE TABLE `SearchEngine`.`MetaInf` ( 
	`id_metainf_pk` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'id de la pagina' ,
	 `title_metainf` VARCHAR(45) NOT NULL COMMENT 'titulo de la pagina' ,
	  `description_metainf` VARCHAR(200) NOT NULL COMMENT 'descripcion de la pagina' ,
	   `link_metainf` VARCHAR(100) NOT NULL COMMENT 'link de la pagina' ,
	    PRIMARY KEY (`id_metainf_pk`)
	    ) ENGINE = MyISAM COMMENT = 'Tabla para almacenar informacion de las paginas';

CREATE TABLE `SearchEngine`.`keywords` (
 `id_keywords` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'id_palabra clave' , 
 `tags_keywords` VARCHAR(45) NOT NULL COMMENT 'tags o palabra clave' , 
 PRIMARY KEY (`id_keywords`)
 ) ENGINE = MyISAM COMMENT = 'tabla para almacenar las palabras claves de cada pagina';

CREATE TABLE `SearchEngine`.`SearchEngineRelation`(
	 `id_keywords_fk` INT(11) NOT NULL COMMENT 'llaves foraneas', 
	 `id_metainf_fk` INT(11) NOT NULL COMMENT 'llaves foraneas',
	 CONSTRAINT FOREIGN KEY (`id_keywords_fk`) REFERENCES KeyWords(`id_keywords_pk`),
	 CONSTRAINT FOREIGN KEY (`id_metainf_fk`)  REFERENCES MetaInf(`id_keywords_pk`) 
)ENGINE = MyISAM COMMENT = 'tabla intermedia para almacenar llaves foraneas';

CREATE TABLE `searchengine`.`loggin` ( 
	`userid_lg` INT NOT NULL AUTO_INCREMENT COMMENT 'id usuario admin' , 
	`mail_lg` VARCHAR(45) NOT NULL COMMENT 'correo administrador' , 
	`password` VARCHAR(200) NOT NULL COMMENT 'contraseña del administrador' , 
	PRIMARY KEY (`userid_lg`)) ENGINE = MyISAM;

INSERT INTO `loggin` (`userid_lg`, `mail_lg`, `password`) 
VALUES (NULL, 'admin@gmail.com', MD5('abcd123'));