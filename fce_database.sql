-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema fce
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema fce
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `fce` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `fce` ;

-- -----------------------------------------------------
-- Table `fce`.`School`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fce`.`School` ;

CREATE TABLE IF NOT EXISTS `fce`.`School` (
  `school` VARCHAR(4) NOT NULL,
  `school_description` VARCHAR(70) NULL,
  PRIMARY KEY (`school`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fce`.`User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fce`.`User` ;

CREATE TABLE IF NOT EXISTS `fce`.`User` (
  `email` VARCHAR(70) NOT NULL,
  `name` VARCHAR(70) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `user_type` VARCHAR(45) NOT NULL,
  `school` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`email`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fce`.`Semester`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fce`.`Semester` ;

CREATE TABLE IF NOT EXISTS `fce`.`Semester` (
  `semester` VARCHAR(11) NOT NULL,
  PRIMARY KEY (`semester`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fce`.`Section`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fce`.`Section` ;

CREATE TABLE IF NOT EXISTS `fce`.`Section` (
  `crn` INT NOT NULL AUTO_INCREMENT,
  `course_code` VARCHAR(7) NOT NULL,
  `faculty_email` VARCHAR(70) NOT NULL,
  `semester` VARCHAR(11) NOT NULL,
  `school` VARCHAR(4) NOT NULL,
  `course_title` VARCHAR(100) NOT NULL,
  `locked` TINYINT(1) NOT NULL DEFAULT 1,
  `mid_evaluation` TINYINT(1) NOT NULL DEFAULT 0,
  `final_evaluation` TINYINT(1) NOT NULL DEFAULT 0,
  `enrolled` INT NOT NULL,
  INDEX `class_semester_id_idx` (`semester` ASC),
  PRIMARY KEY (`crn`),
  INDEX `school_idx` (`school` ASC),
  INDEX `faculty_email_idx` (`faculty_email` ASC),
  CONSTRAINT `semester`
    FOREIGN KEY (`semester`)
    REFERENCES `fce`.`Semester` (`semester`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `school`
    FOREIGN KEY (`school`)
    REFERENCES `fce`.`School` (`school`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `faculty_email`
    FOREIGN KEY (`faculty_email`)
    REFERENCES `fce`.`User` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fce`.`Evaluation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fce`.`Evaluation` ;

CREATE TABLE IF NOT EXISTS `fce`.`Evaluation` (
  `crn` INT NOT NULL,
  `q1` INT NOT NULL,
  `q2` INT NOT NULL,
  `q3` INT NOT NULL,
  `q4` INT NOT NULL,
  `q5` INT NOT NULL,
  `q6` INT NOT NULL,
  `q7` INT NOT NULL,
  `q8` INT NOT NULL,
  `q9` INT NOT NULL,
  `q10` INT NOT NULL,
  `q11` INT NOT NULL,
  `q12` INT NOT NULL,
  `q13` INT NOT NULL,
  `q14` INT NOT NULL,
  `q15` INT NOT NULL,
  `q16` INT NULL,
  `q17` INT NULL,
  `q18` INT NULL,
  `eval_type` VARCHAR(5) NOT NULL,
  INDEX `evaluation_course_code_idx` (`crn` ASC),
  CONSTRAINT `evaluation_course_crn`
    FOREIGN KEY (`crn`)
    REFERENCES `fce`.`Section` (`crn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fce`.`Interface`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fce`.`Interface` ;

CREATE TABLE IF NOT EXISTS `fce`.`Interface` (
  `syllabus` INT NULL,
  `outcome` INT NULL,
  `content` INT NULL,
  `grading` INT NULL,
  `overall` INT NULL,
  `prepared` INT NULL,
  `comprehensive` INT NULL,
  `interesting` INT NULL,
  `relevant` INT NULL,
  `interactive` INT NULL,
  `character` INT NULL,
  `attitude` INT NULL,
  `participation` INT NULL,
  `assignment` INT NULL,
  `achievement` INT NULL,
  `technology` INT NULL,
  `library` INT NULL,
  `support` INT NULL,
  `course` VARCHAR(7) NULL,
  `instructor` VARCHAR(70) NULL,
  `semester` VARCHAR(11) NULL)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fce`.`AccessKeys`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fce`.`AccessKeys` ;

CREATE TABLE IF NOT EXISTS `fce`.`AccessKeys` (
  `key_value` VARCHAR(7) NOT NULL,
  `given_out` TINYINT(1) NOT NULL DEFAULT 0,
  `used` TINYINT(1) NOT NULL DEFAULT 0,
  `key_eval_type` VARCHAR(5) NOT NULL,
  `key_crn` INT NOT NULL,
  PRIMARY KEY (`key_value`),
  INDEX `key_crn_idx` (`key_crn` ASC),
  CONSTRAINT `key_crn`
    FOREIGN KEY (`key_crn`)
    REFERENCES `fce`.`Section` (`crn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `fce`.`School`
-- -----------------------------------------------------
START TRANSACTION;
USE `fce`;
INSERT INTO `fce`.`School` (`school`, `school_description`) VALUES ('SAS', NULL);
INSERT INTO `fce`.`School` (`school`, `school_description`) VALUES ('SBE', NULL);
INSERT INTO `fce`.`School` (`school`, `school_description`) VALUES ('SITC', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `fce`.`User`
-- -----------------------------------------------------
START TRANSACTION;
USE `fce`;
INSERT INTO `fce`.`User` (`email`, `name`, `password`, `user_type`, `school`) VALUES ('admin@aun.edu.ng', 'admin', 'admin', 'admin', 'SAS');

COMMIT;


-- -----------------------------------------------------
-- Data for table `fce`.`Semester`
-- -----------------------------------------------------
START TRANSACTION;
USE `fce`;
INSERT INTO `fce`.`Semester` (`semester`) VALUES ('Spring 2015');

COMMIT;

