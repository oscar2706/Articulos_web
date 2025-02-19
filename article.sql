-- MySQL Script generated by MySQL Workbench
-- Sat Mar 30 19:14:58 2019
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Article
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema Article
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Article` DEFAULT CHARACTER SET utf8 ;
USE `Article` ;

-- -----------------------------------------------------
-- Table `Article`.`Autor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Article`.`Autor` (
  `idAutor` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `contraseña` VARCHAR(45) NOT NULL,
  `fechaNacimiento` DATE NOT NULL,
  PRIMARY KEY (`idAutor`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Article`.`Tema`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Article`.`Tema` (
  `idTema` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `cantidadGusta` INT NOT NULL,
  PRIMARY KEY (`idTema`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Article`.`Articulo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Article`.`Articulo` (
  `idArticulo` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(45) NOT NULL,
  `subtitulo` VARCHAR(45) NOT NULL,
  `contenido` VARCHAR(45) NOT NULL,
  `fecha` DATE NOT NULL,
  `idAutor` INT NOT NULL,
  `idTema` INT NOT NULL,
  PRIMARY KEY (`idArticulo`),
  INDEX `fk_Articulo_Autor_idx` (`idAutor` ASC) ,
  INDEX `fk_Articulo_Tema1_idx` (`idTema` ASC) ,
  CONSTRAINT `fk_Articulo_Autor`
    FOREIGN KEY (`idAutor`)
    REFERENCES `Article`.`Autor` (`idAutor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Articulo_Tema1`
    FOREIGN KEY (`idTema`)
    REFERENCES `Article`.`Tema` (`idTema`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Article`.`gusta_Articulo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Article`.`gusta_Articulo` (
  `idAutor` INT NOT NULL,
  `idArticulo` INT NOT NULL,
  `gusta` TINYINT NOT NULL,
  PRIMARY KEY (`idAutor`, `idArticulo`),
  INDEX `fk_Autor_has_Articulo_Articulo1_idx` (`idArticulo` ASC) ,
  INDEX `fk_Autor_has_Articulo_Autor1_idx` (`idAutor` ASC) ,
  CONSTRAINT `fk_Autor_has_Articulo_Autor1`
    FOREIGN KEY (`idAutor`)
    REFERENCES `Article`.`Autor` (`idAutor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Autor_has_Articulo_Articulo1`
    FOREIGN KEY (`idArticulo`)
    REFERENCES `Article`.`Articulo` (`idArticulo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
