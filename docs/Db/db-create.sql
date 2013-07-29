SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `phpskel` ;
CREATE SCHEMA IF NOT EXISTS `phpskel` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `phpskel` ;

-- -----------------------------------------------------
-- Table `phpskel`.`app`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `phpskel`.`app` ;

CREATE  TABLE IF NOT EXISTS `phpskel`.`app` (
  `name` VARCHAR(20) NULL ,
  `version` VARCHAR(45) NULL )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `phpskel`.`db`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `phpskel`.`db` ;

CREATE  TABLE IF NOT EXISTS `phpskel`.`db` (
  `version` VARCHAR(20) NULL )
ENGINE = InnoDB;

USE `phpskel` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
