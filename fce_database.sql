-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema fce
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `fce` ;

-- -----------------------------------------------------
-- Schema fce
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `fce` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `fce` ;

-- -----------------------------------------------------
-- Table `fce`.`schools`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fce`.`schools` ;

CREATE TABLE IF NOT EXISTS `fce`.`schools` (
  `school` VARCHAR(4) NOT NULL,
  `school_description` VARCHAR(70) NULL,
  PRIMARY KEY (`school`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fce`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fce`.`users` ;

CREATE TABLE IF NOT EXISTS `fce`.`users` (
  `email` VARCHAR(70) NOT NULL,
  `name` VARCHAR(70) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `school` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`email`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fce`.`semesters`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fce`.`semesters` ;

CREATE TABLE IF NOT EXISTS `fce`.`semesters` (
  `semester` VARCHAR(11) NOT NULL,
  `year` VARCHAR(4) NOT NULL,
  PRIMARY KEY (`semester`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fce`.`evaluations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fce`.`evaluations` ;

CREATE TABLE IF NOT EXISTS `fce`.`evaluations` (
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
  `eval_type` VARCHAR(5) NOT NULL)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fce`.`sections`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fce`.`sections` ;

CREATE TABLE IF NOT EXISTS `fce`.`sections` (
  `crn` INT NOT NULL AUTO_INCREMENT,
  `course_code` VARCHAR(7) NOT NULL,
  `semester` VARCHAR(11) NOT NULL,
  `school` VARCHAR(4) NOT NULL,
  `course_title` VARCHAR(100) NOT NULL,
  `class_time` VARCHAR(70) NOT NULL,
  `location` VARCHAR(50) NOT NULL,
  `locked` TINYINT(1) NOT NULL DEFAULT 1,
  `enrolled` INT NOT NULL,
  `mid_evaluation` TINYINT(1) NOT NULL DEFAULT 0,
  `final_evaluation` TINYINT(1) NOT NULL DEFAULT 0,
  INDEX `class_semester_id_idx` (`semester` ASC),
  PRIMARY KEY (`crn`),
  INDEX `school_idx` (`school` ASC),
  CONSTRAINT `semester`
    FOREIGN KEY (`semester`)
    REFERENCES `fce`.`semesters` (`semester`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `school`
    FOREIGN KEY (`school`)
    REFERENCES `fce`.`schools` (`school`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fce`.`eval_interface`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fce`.`eval_interface` ;

CREATE TABLE IF NOT EXISTS `fce`.`eval_interface` (
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
-- Table `fce`.`accesskeys`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fce`.`accesskeys` ;

CREATE TABLE IF NOT EXISTS `fce`.`accesskeys` (
  `key_value` VARCHAR(7) NOT NULL,
  `given_out` TINYINT(1) NOT NULL DEFAULT 0,
  `used` TINYINT(1) NOT NULL DEFAULT 0,
  `key_eval_type` VARCHAR(5) NOT NULL,
  `key_crn` INT NOT NULL,
  PRIMARY KEY (`key_value`),
  INDEX `key_crn_idx` (`key_crn` ASC),
  CONSTRAINT `key_crn`
    FOREIGN KEY (`key_crn`)
    REFERENCES `fce`.`sections` (`crn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fce`.`course_assignments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fce`.`course_assignments` ;

CREATE TABLE IF NOT EXISTS `fce`.`course_assignments` (
  `crn` INT NOT NULL,
  `faculty_email` VARCHAR(70) NOT NULL,
  PRIMARY KEY (`crn`, `faculty_email`),
  INDEX `faculty_email_idx` (`faculty_email` ASC),
  CONSTRAINT `section_crn`
    FOREIGN KEY (`crn`)
    REFERENCES `fce`.`sections` (`crn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `faculty_email`
    FOREIGN KEY (`faculty_email`)
    REFERENCES `fce`.`users` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fce`.`roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fce`.`roles` ;

CREATE TABLE IF NOT EXISTS `fce`.`roles` (
  `role` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`role`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fce`.`user_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fce`.`user_roles` ;

CREATE TABLE IF NOT EXISTS `fce`.`user_roles` (
  `user_email` VARCHAR(70) NOT NULL,
  `user_role` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`user_email`, `user_role`),
  INDEX `user_role_idx` (`user_role` ASC),
  CONSTRAINT `user_email`
    FOREIGN KEY (`user_email`)
    REFERENCES `fce`.`users` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `user_role`
    FOREIGN KEY (`user_role`)
    REFERENCES `fce`.`roles` (`role`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `fce`.`schools`
-- -----------------------------------------------------
START TRANSACTION;
USE `fce`;
INSERT INTO `fce`.`schools` (`school`, `school_description`) VALUES ('SAS', 'School of Arts and Sciences');
INSERT INTO `fce`.`schools` (`school`, `school_description`) VALUES ('SBE', 'School of Business and Entrepreneurship');
INSERT INTO `fce`.`schools` (`school`, `school_description`) VALUES ('SITC', 'School of Information Technology and Communication');

COMMIT;


-- -----------------------------------------------------
-- Data for table `fce`.`users`
-- -----------------------------------------------------
START TRANSACTION;
USE `fce`;
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('admin@aun.edu.ng', 'admin', 'admin', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('mfonkam@aun.edu.ng', 'Mathias Fonkam', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('jacob.jacob@aun.edu.ng', 'Jacob Udo-Udo Jacob', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('abdul.mousa@aun.edu.ng', 'Abdul Amin Mousa', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('joseph.rishante@aun.edu.ng', 'Joseph Sule Rishante', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('abba@aun.edu.ng', 'Abubakar Abba Tahir', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('presly.obukoada@aun.edu.ng', 'Presly Ogheneruke Obukoadata', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('abiodun.adeniyi@aun.edu.ng', 'Abiodun Gabriel Adeniyi', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('daniel.@aun.edu.ng', 'Daniel Barkley', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('wasiq.khan@aun.edu.ng', 'Wasiq N. Khan', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('john.leonard@aun.edu.ng', 'John Erwyn Leonard', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('sicy francis@aun.edu.ng', 'Sicy Francis', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('agatha.ukata@aun.edu.ng', 'Agatha Ada Ukata', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('brian.reed@aun.edu.ng', 'Brian Keith Reed', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('grace.malgwi@aun.edu.ng', 'Grace Joshua Malgwi', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('hannah.mugambi@aun.edu.ng', 'Hannah Mweru Mugambi', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('mariana.silva@aun.edu.ng', 'Mariana Silva', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('steve.devitt@aun.edu.ng', 'Steve L Devitt', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('ikechukwu.eke@aun.edu.ng', 'Ikechukwu Williams Eke', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('tristan.purvis@aun.edu.ng', 'Tristan Michael Purvis', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('alzouma.gado@aun.edu.ng', 'Gado Alzouma', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('pavel.ushakov@aun.edu.ng', 'Pavel Vladimirovich Ushakov', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('emilienne.akpan@aun.edu.ng', 'Emilienne Idorenyin Akpan', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('biyasa.abraham@aun.edu.ng', 'Abraham Biyasa', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('yusuf.mamman@aun.edu.ng', 'Mamman Yusuf Dabari', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('amy.drambi@aun.edu.ng', 'Amy Christina Drambi', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('muhammad.dauda@aun.edu.ng', 'Muhammad Ashraf Dauda', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('regina.mousa@aun.edu.ng', 'Regina Benneh Mousa', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('bill.hansen@aun.edu.ng', 'William Walter Hansen', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('kimberly.sims@aun.edu.ng', 'Kimberly Sims', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('loveday.gbara@aun.edu.ng', 'Loveday Gbara', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('lucky.imade@aun.edu.ng', 'Lucky Osagie Imade', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('patrick.fay@aun.edu.ng', 'Patrick Vincent Fay', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('adewale.james@aun.edu.ng', 'James A Adewale', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('jamiu.olumoh@aun.edu.ng', 'Jamiu Shehu Olumoh', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('fokam@aun.edu.ng', 'Jean Marcel Fokam', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('quarcoo@aun.edu.ng', 'Joseph Quarcoo', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('osho.ajayi@aun.edu.ng', 'Osho Olushola Ajayi', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('charles.reith@aun.edu.ng', 'Charles Reith', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('hayatu.raji@aun.edu.ng', 'Hayatu Muhammad Raji', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('jay.siebert@aun.edu.ng', 'Jay Dee Siebert', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('jennifer.tyndall@aun.edu.ng', 'Jennifer Alena Vincent', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('jessica.boyd@aun.edu.ng', 'Jessica May Boyd', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('lynne.baker@aun.edu.ng', 'Lynne Baker', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('okeoghene.okoro@aun.edu.ng', 'Oke-Oghene Christiana Okoro', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('friday.ogwu@aun.edu.ng', 'Friday Adejoh Ogwu', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('bolade.agboola@aun.edu.ng', 'Bolade Oyeyinka Agboola', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('linus.okoro@aun.edu.ng', 'Linus Ndubuike Okoro', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('obioma.uche@aun.edu.ng', 'Obioma Uchenna Uche', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('wan.jahng@aun.edu.ng', 'Wan Jin Jahng', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('ifeoma.joseph@aun.edu.ng', 'Ifeoma Virginia Joseph', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('victoria.adams@aun.edu.ng', 'Feyisayo Victoria Adams', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('abel.ajibesin@aun.edu.ng', 'Abel Ajibesin', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('aquaye@aun.edu.ng', 'Ago KM Quaye', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('nwokoma@aun.edu.ng', 'Anele Nwokoma', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('apkar.salatian@aun.edu.ng', 'Apkar Salatian', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('francis.adepoju@aun.edu.ng', 'Francis Adepoju', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('babatunde.ogunleye@aun.edu.ng', 'Babatunde Samuel Ogunleye', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('chioma@aun.edu.ng', 'Chioma Obianuju Anadozie', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('emmanuel.ukpe@aun.edu.ng', 'Emmanuel Ukpe', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('egunsola.olubola@aun.edu.ng', 'Egunsola Kehinde Olubola', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('hieu.vu@aun.edu.ng', 'Hieu Dinh Vu', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('olusegun.ogundapo@aun.edu.ng', 'Olusegun Ogundapo', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('augustine.nsang@aun.edu.ng', 'Augustine Shey Nsang', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('charles.nche@aun.edu.ng', 'Charles Fon Nche', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('ferdinand.che@aun.edu.ng', 'Ferdinand N Che', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('andrei.dragunov@aun.edu.ng', 'Andrei S Dragunov', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('evgeny.arkhipov@aun.edu.ng', 'Evgeny Arkhipov', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('alexey.vedishchev@aun.edu.ng', 'Alexey Alexandrovick Vedishchev', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('emmanuel.nicholas@aun.edu.ng', 'Emmanuel  Nicholas', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('ash.hussaini@aun.edu.ng', 'Abubakar Sadiq Hussaini', 'fce', 'SITC');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('linus.osuagwu@qun.edu.ng', 'Linus Chukwuenye Osuagwu', 'fce', 'SBE');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('samuel.akanno@aun.edu.ng', 'Samuel N Akanno', 'fce', 'SBE');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('martin.burt@gmail.com', 'Martin Burt', 'fce', 'SBE');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('ibro.danjuma@aun.edu.ng', 'Ibrahim Danjuma', 'fce', 'SBE');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('abdulsalam.dauda@aun.edu.ng', 'Abdulsalam Dauda', 'fce', 'SBE');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('fardeen.dodo@aun.edu.ng', 'Fardeen Abdulrahman Dodo', 'fce', 'SBE');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('ifeatu.uzodinma@aun.edu.ng', 'Ifeatu Uzodinma', 'fce', 'SBE');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('kamarudeen.bello@aun.edu.ng', 'Kamarudeen Babatunde Bello', 'fce', 'SBE');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('fodio.musa@aun.edu.ng', 'Fodio Musa', 'fce', 'SBE');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('alfredo.ocampo@aun.edu.ng', 'Alfredo Ocampo', 'fce', 'SBE');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('shulammite.paul@aun.edu.ng', 'Shulammite Paul', 'fce', 'SBE');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('tende.sam@aun.edu.ng', 'Sam Tende', 'fce', 'SBE');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('jacob.shehu@aun.edu.ng', 'Jacob Fintan Shehu', 'fce', 'SBE');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('suleiman.tahir@aun.edu.ng', 'Suleiman Tahir', 'fce', 'SBE');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('hassan.yusuf@aun.edu.ng', 'Hassan Yusuf', 'fce', 'SBE');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('vrajlal.sapovadia@aun.edu.ng', 'Vrajlal Sapovadia', 'fce', 'SBE');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('jelena.zivkovic@aun.edu.ng', 'Jelena Zivkovic', 'fce', 'SBE');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('jennifer.che@aun.edu.ng', 'Jennifer Che', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('reginald.braggs@aun.edu.ng', 'Reginald T Braggs', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('fidelis.ndehche@aun.edu.ng', 'Fidelis Ndeh-Che', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('elke.debuhr@aun.edu.ng', 'Elke De Buhr', 'fce', 'SAS');
INSERT INTO `fce`.`users` (`email`, `name`, `password`, `school`) VALUES ('lionel.rawlins@aun.edu.ng', 'Lionel Rawlins', 'fce', 'SAS');

COMMIT;


-- -----------------------------------------------------
-- Data for table `fce`.`semesters`
-- -----------------------------------------------------
START TRANSACTION;
USE `fce`;
INSERT INTO `fce`.`semesters` (`semester`, `year`) VALUES ('Spring 2015', '2015');

COMMIT;


-- -----------------------------------------------------
-- Data for table `fce`.`sections`
-- -----------------------------------------------------
START TRANSACTION;
USE `fce`;
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014480, 'ACC 201', 'Spring 2015', 'SBE', 'Fundementals of Financial Acc.', 'MW 08:00 - 09:30', 'Classroom 14', 1, 10.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014208, 'ACC 202', 'Spring 2015', 'SBE', 'Fundemental of Managerial Acct', 'TR 08:00 - 09:30', 'Classroom 01', 1, 11.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014479, 'ACC 301', 'Spring 2015', 'SBE', 'Intermediate Financial Acct. I', 'TR 09:45 - 11:15', 'Classroom 03', 1, 2.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014207, 'ACC 302', 'Spring 2015', 'SBE', 'Intermediate Financial Acct II', 'MW 08:00 - 09:30', 'Classroom 01', 1, 12.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014235, 'ACC 303', 'Spring 2015', 'SBE', 'Cost Accounting', 'MW 09:45 - 11:15', 'Classroom 01', 1, 14.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014450, 'ACC 402', 'Spring 2015', 'SBE', 'Accounting Information Systems', 'MW 16:45 - 18:15', 'AS 224', 1, 2.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014256, 'ACC 404', 'Spring 2015', 'SBE', 'Public Sector Accounting', 'MW 15:00 - 16:30', 'Classroom 01', 1, 3.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014451, 'ACC 405', 'Spring 2015', 'SBE', 'Consolidated Accounts', 'TR 15:00 - 16:30', 'AS 224', 1, 9.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014417, 'ACC 410', 'Spring 2015', 'SBE', 'Auditing', 'MW 13:15 - 14:45', 'Classroom 01', 1, 13.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014270, 'ANT 201', 'Spring 2015', 'SAS', 'Cultural Anthropology', 'MW 15:00 - 16:30', 'Classroom 11', 1, 13.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014462, 'AUN 101', 'Spring 2015', 'SAS', 'AUN First Year Experience', 'TR 11:30 - 13:00', 'Classroom 01', 1, 24.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014458, 'AUN 101', 'Spring 2015', 'SAS', 'AUN First Year Experience', 'TR 11:30 - 13:00', 'Classroom 03', 1, 26.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014416, 'BIO 101', 'Spring 2015', 'SAS', 'Exploring Life', 'TR 13:15 - 14:45', 'AS 226', 1, 10.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014205, 'BIO 101', 'Spring 2015', 'SAS', 'Exploring Life', 'MW 08:00 - 09:30', 'AS 226', 1, 13.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014377, 'BIO 103', 'Spring 2015', 'SAS', 'Essentials of Nutrition', 'TR 16:45 - 18:15', 'AS 226', 1, 26.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014206, 'BIO 104', 'Spring 2015', 'SAS', 'Health and Disease in Africa', 'TR 08:00 - 09:30', 'AS 226', 1, 14.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014234, 'BIO 120', 'Spring 2015', 'SAS', 'General Biology I', 'TR 09:45 - 11:15', 'AS 226', 1, 7.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014253, 'BIO 121', 'Spring 2015', 'SAS', 'General Biology II', 'TR 15:00 - 16:30', 'AS 226', 1, 9.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014410, 'BIO 240', 'Spring 2015', 'SAS', 'Microbiology and Immunology', 'MW 09:45 - 11:15', 'AS 225', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014298, 'BIO 320', 'Spring 2015', 'SAS', 'Human Anatomy and Physiology', 'MW 11:30 - 13:00', 'AS 226', 1, 4.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014457, 'CDV 101', 'Spring 2015', 'SAS', 'Intro to Applied Community Dev', 'TR 15:00 - 16:30', 'Classroom 03', 1, 21.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014456, 'CDV 101', 'Spring 2015', 'SAS', 'Intro to Applied Community Dev', 'MW 15:00 - 16:30', 'Classroom 03', 1, 21.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014481, 'CDV 102', 'Spring 2015', 'SBE', 'IT Financial Literacy', 'TR 15:00 - 16:30', 'Classroom 01', 1, 21.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014478, 'CDV 102', 'Spring 2015', 'SAS', 'IT', 'MW 09:45 - 11:15', 'AS 318', 1, 17.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014255, 'CHE 101', 'Spring 2015', 'SAS', 'Introduction to Chemistry', 'TR 09:45 - 11:15', 'Classroom 11', 1, 15.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014309, 'CHE 120', 'Spring 2015', 'SAS', 'General Chemistry I', 'MW 11:30 - 13:00', 'Classroom 04', 1, 15.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014411, 'CHE 121', 'Spring 2015', 'SAS', 'General Chemistry II', 'TR 11:30 - 13:00', 'Classroom 16', 1, 15.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014428, 'CHE 210', 'Spring 2015', 'SAS', 'Organic Chemistry I', 'TR 13:15 - 14:45', 'Classroom 13', 1, 17.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014230, 'CHE 211', 'Spring 2015', 'SAS', 'Organic Chemistry II', 'MW 09:45 - 11:15', 'AS 129', 1, 14.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014286, 'CHE 310', 'Spring 2015', 'SAS', 'Petroleum Science', 'MW 09:45 - 11:15', 'Classroom 18', 1, 12.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014497, 'CHE 320', 'Spring 2015', 'SAS', 'Petrochemicals and Polymers', 'MW 11:30 - 13:00', 'Classroom 03', 1, 9.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014215, 'CHE 321', 'Spring 2015', 'SAS', 'Chem. Kinetcs & Thermodynamcs', 'MW 08:00 - 09:30', 'Classroom 05', 1, 0.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014285, 'CHE 331', 'Spring 2015', 'SAS', 'Instumental Analysis', 'TR 09:45 - 11:15', 'Classroom 16', 1, 20.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014403, 'CHE 340', 'Spring 2015', 'SAS', 'Inorganic Chemistry', 'TR 11:30 - 13:00', 'Classroom 12', 1, 18.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014412, 'CHE 351', 'Spring 2015', 'SAS', 'Hydrocarbon Chemistry', 'TR 11:30 - 13:00', 'Classroom 18', 1, 0.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014392, 'CHE 410', 'Spring 2015', 'SAS', 'Oil spill Control', 'MW 15:00 - 16:30', 'Classroom 10', 1, 7.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014391, 'CHE 421', 'Spring 2015', 'SAS', 'Electrochem & corrosion sci', 'TR 18:30 - 20:00', 'Classroom 07', 1, 11.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014252, 'CHE 430', 'Spring 2015', 'SAS', 'Pet Prod Analysis & Evaluation', 'MW 09:45 - 11:15', 'Classroom 17', 1, 14.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014361, 'CHE 440', 'Spring 2015', 'SAS', 'Advanced Organic Chemistry', 'MW 16:45 - 18:15', 'Classroom 03', 1, 30, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014382, 'CHE 490', 'Spring 2015', 'SAS', 'Senior Research Projects in PS', 'MW 18:30 - 20:00', 'Classroom 01', 1, 4.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014362, 'CHG 201', 'Spring 2015', 'SAS', 'Chem. Eng. Fundamentals', 'TR 16:45 - 18:15', 'Classroom 03', 1, 0.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014440, 'CHG 210', 'Spring 2015', 'SAS', 'Stats & Strength of Materials', 'TR 13:15 - 14:45', 'Classroom 18', 1, 3.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014482, 'CHG 311', 'Spring 2015', 'SAS', 'Fluid Mechanics', 'MW 15:00 - 16:30', 'Classroom 13', 1, 6.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014290, 'CHG 320', 'Spring 2015', 'SAS', 'Petro Proc Cntr opti & Simulat', 'TR 11:30 - 13:00', 'Classroom 17', 1, 8.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014317, 'CIE 101', 'Spring 2015', 'SITC', 'Programming Logic and Design', 'MWF 12:00 - 13:00', 'AS 224', 1, 12.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014289, 'CIE 101', 'Spring 2015', 'SITC', 'Programming Logic and Design', 'MWF 08:00 - 09:00', 'AS 301', 1, 10.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014293, 'CIE 105', 'Spring 2015', 'SITC', 'Principles of Programming I', 'TR 08:00 - 09:30', 'AS 303', 1, 20.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014288, 'CIE 105', 'Spring 2015', 'SITC', 'Principles of Programming I', 'MW 08:00 - 09:30', 'AS 303', 1, 16.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014306, 'CIE 106', 'Spring 2015', 'SITC', 'Princ of Programming II', 'MW 09:45 - 11:15', 'AS 301', 1, 21.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014296, 'CIE 106', 'Spring 2015', 'SITC', 'Princ of Programming II', 'TR 08:00 - 09:30', 'AS 301', 1, 8.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014348, 'CIE 231', 'Spring 2015', 'SITC', 'Intr to Datbse,Web tch&Aplictn', 'MW 16:45 - 18:15', 'AS 303', 1, 31.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014352, 'CIE 302', 'Spring 2015', 'SITC', 'Prin. of Operating Systems', 'TR 16:45 - 18:15', 'AS 303', 1, 34.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014303, 'CIE 321', 'Spring 2015', 'SITC', 'IT Prjct Mngmnt for IS/SEN/TEL', 'MW 09:45 - 11:15', 'AS 303', 1, 25.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014308, 'CIE 333', 'Spring 2015', 'SITC', 'Data & Computer Communication', 'MW 09:45 - 11:15', 'Classroom 08', 1, 14.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014368, 'CIV 101', 'Spring 2015', 'SAS', 'African Civilization', 'MW 16:45 - 18:15', 'Classroom 11', 1, 21.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014445, 'CIV 102', 'Spring 2015', 'SAS', 'Western Civilization', 'R 18:30 - 21:30', 'Conference Room 26', 1, 32.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014409, 'CIV 111', 'Spring 2015', 'SAS', 'African Civilization: Sp Topic', 'TR 11:30 - 13:00', 'Classroom 15', 1, 23.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014408, 'CIV 111', 'Spring 2015', 'SAS', 'African Civilization: Sp Topic', 'MW 11:30 - 13:00', 'Classroom 15', 1, 21.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014305, 'CMD 121', 'Spring 2015', 'SAS', 'Design Foundations I', 'TR 11:30 - 13:00', 'Classroom 02', 1, 14.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014275, 'CMD 151', 'Spring 2015', 'SAS', 'Intro to Media in Africa', 'MW 15:00 - 16:30', 'Classroom 14', 1, 20.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014295, 'CMD 200', 'Spring 2015', 'SAS', 'Intro to Film Studies', 'TR 11:30 - 13:00', 'AS 321', 1, 8.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014388, 'CMD 208', 'Spring 2015', 'SAS', 'Public Speaking', 'MW 18:30 - 20:00', 'Classroom 04', 1, 20.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014369, 'CMD 210', 'Spring 2015', 'SAS', 'Theories of Communication', 'TR 16:45 - 18:15', 'Classroom 11', 1, 9.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014432, 'CMD 220', 'Spring 2015', 'SAS', 'Intercultural Communication', 'TR 13:15 - 14:45', 'Classroom 12', 1, 15.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014436, 'CMD 225', 'Spring 2015', 'SAS', 'Business Communications', 'MW 13:15 - 14:45', 'Classroom 15', 1, 18.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014375, 'CMD 232', 'Spring 2015', 'SAS', 'Writing for Mass Media', 'TR 16:45 - 18:15', 'Classroom 14', 1, 8.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014407, 'CMD 255', 'Spring 2015', 'SAS', 'Principles of Advertising', 'TR 11:30 - 13:00', 'Classroom 14', 1, 8.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014294, 'CMD 298', 'Spring 2015', 'SAS', 'Basic Video and Film Prod', 'MW 11:30 - 13:00', 'AS 321', 1, 6.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014389, 'CMD 300', 'Spring 2015', 'SAS', 'Research Methods', 'TR 18:30 - 20:00', 'Classroom 04', 1, 14.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014387, 'CMD 306', 'Spring 2015', 'SAS', 'Broadcast Journalism', 'TR 18:30 - 20:00', 'Classroom 03', 1, 4.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014238, 'CMD 312', 'Spring 2015', 'SAS', 'Basic Multimedia Authoring', 'TR 09:45 - 11:15', 'Classroom 13', 1, 9.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014441, 'CMD 320', 'Spring 2015', 'SAS', 'Mass Media Law', 'TR 15:00 - 16:30', 'Classroom 11', 1, 10.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014220, 'CMD 350', 'Spring 2015', 'SAS', 'Advertising Copy and Layout', 'TR 08:00 - 09:30', 'Classroom 11', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014374, 'CMD 371', 'Spring 2015', 'SAS', 'News Writing', 'MW 16:45 - 18:15', 'Classroom 12', 1, 3.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014203, 'CMD 373', 'Spring 2015', 'SAS', 'Scriptwriting', 'MW 08:00 - 09:30', 'AS 321', 1, 4.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014246, 'CMD 425', 'Spring 2015', 'SAS', 'Feature Writing', 'MW 15:00 - 16:30', 'AS 224', 1, 4.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014513, 'CMD 450', 'Spring 2015', 'SAS', 'Advertising Research', 'MW 13:45 - 15:00', 'Classroom 10', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014406, 'CMD 454', 'Spring 2015', 'SAS', 'Case Studies in Advertising', 'MW 11:30 - 13:00', 'Classroom 17', 1, 4.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014219, 'CMD 455', 'Spring 2015', 'SAS', 'Advertising Media Planning', 'MW 08:00 - 09:30', 'Classroom 11', 1, 3.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014204, 'CMD 458', 'Spring 2015', 'SAS', 'Film Editing', 'TR 08:00 - 09:30', 'AS 321', 1, 3.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014386, 'CMD 490', 'Spring 2015', 'SAS', 'Senior Design Project', 'MW 18:30 - 20:00', 'Classroom 03', 1, 8.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014383, 'CMD 493', 'Spring 2015', 'SAS', 'CMD Internship', 'S 08:00 - 11:00', '', 1, 8.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014338, 'CSC 102', 'Spring 2015', 'SITC', 'Intro to Computer Science', 'MW 15:00 - 16:30', 'AS 125', 1, 17.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014341, 'CSC 202', 'Spring 2015', 'SITC', 'Data Structures & Algorithms', 'MW 15:00 - 16:30', 'Classroom 08', 1, 15.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014323, 'CSC 213', 'Spring 2015', 'SITC', 'Discrete Structures', 'TR 11:30 - 13:00', 'AS 129', 1, 19.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014319, 'CSC 214', 'Spring 2015', 'SITC', 'Logic in Computer Science', 'MW 11:30 - 13:00', 'AS 303', 1, 20.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014354, 'CSC 232', 'Spring 2015', 'SITC', 'Computer Org & Architecture', 'TR 16:45 - 18:15', 'AS 318', 1, 8.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014350, 'CSC 301', 'Spring 2015', 'SITC', 'Systems Programming', 'MW 16:45 - 18:15', 'AS 318', 1, 8.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014322, 'CSC 364', 'Spring 2015', 'SITC', 'Design & Analysis of Algorithm', 'MW 11:30 - 13:00', 'Classroom 08', 1, 7.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014330, 'CSC 384', 'Spring 2015', 'SITC', 'Database Management', 'MW 13:15 - 14:45', 'AS 318', 1, 24.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014337, 'CSC 434', 'Spring 2015', 'SITC', 'Theory of Computation', 'MW 11:30 - 13:00', 'AS 129', 1, 6.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014346, 'CSC 438', 'Spring 2015', 'SITC', 'Interactive Comp Graphics II', 'TR 15:00 - 16:30', 'Classroom 14', 1, 0.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014512, 'CSC 465', 'Spring 2015', 'SITC', 'Artificial Intelligence', 'MW 08:00 - 09:30', 'Classroom 07', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014477, 'CSC 490', 'Spring 2015', 'SITC', 'Senior Project I', 'F 15:00 - 16:00', 'AS 301', 1, 5.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014502, 'CSC 492', 'Spring 2015', 'SITC', 'Independent Study: Programming Language', '', '', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014414, 'ECO 101', 'Spring 2015', 'SAS', 'Introduction to Economics', 'MW 13:15 - 14:45', 'AS 228', 1, 30.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014254, 'ECO 101', 'Spring 2015', 'SAS', 'Introduction to Economics', 'MW 09:45 - 11:15', 'Classroom 11', 1, 30.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014425, 'ECO 201', 'Spring 2015', 'SAS', 'Principles of Microeconomics', 'TR 13:15 - 14:45', 'Classroom 05', 1, 24.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014427, 'ECO 202', 'Spring 2015', 'SAS', 'Principles of Macroeconomics', 'TR 13:15 - 14:45', 'Classroom 07', 1, 26.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014424, 'ECO 303', 'Spring 2015', 'SAS', 'Development Economics', 'MW 13:15 - 14:45', 'Classroom 05', 1, 9.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014313, 'ECO 330', 'Spring 2015', 'SAS', 'Topics in Macroeconomic Policy', 'MW 11:30 - 13:00', 'Classroom 06', 1, 10.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014241, 'ECO 341', 'Spring 2015', 'SAS', 'Introduction to Economectrics', 'TR 09:45 - 11:15', 'Classroom 04', 1, 7.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014267, 'ECO 361', 'Spring 2015', 'SAS', 'Internatnl Political Economy', 'MW 15:00 - 16:30', 'Classroom 04', 1, 9.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014292, 'ECO 412', 'Spring 2015', 'SAS', 'Industrial Organization', 'TR 11:30 - 13:00', 'AS 224', 1, 11.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014242, 'ECO 441', 'Spring 2015', 'SAS', 'Intr. to Math. Economics', 'MW 09:45 - 11:15', 'Classroom 05', 1, 4.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014510, 'ECO 492', 'Spring 2015', 'SAS', 'Independent Study: Health Economics', '', '', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014487, 'ECO 493', 'Spring 2015', 'SAS', 'Internship', '', '', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014426, 'ENG 101', 'Spring 2015', 'SAS', 'Intro to Study of Literature', 'MW 13:15 - 14:45', 'Classroom 07', 1, 21.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014231, 'ENG 101', 'Spring 2015', 'SAS', 'Intro to Study of Literature', 'TR 09:45 - 11:15', 'AS 129', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014302, 'ENG 203', 'Spring 2015', 'SAS', 'Language and Society', 'TR 11:30 - 13:00', 'AS 228', 1, 13.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014251, 'ENG 221', 'Spring 2015', 'SAS', 'Intro to African Literature', 'TR 09:45 - 11:15', 'Classroom 17', 1, 14.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014390, 'ENG 302', 'Spring 2015', 'SAS', 'History of the English Lang', 'MW 15:00 - 16:30', 'Classroom 07', 1, 3.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014394, 'ENG 316', 'Spring 2015', 'SAS', 'Literature and Film', 'MW 11:30 - 13:00', 'Classroom 07', 1, 10.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014245, 'ENG 320', 'Spring 2015', 'SAS', 'Intro to creative Writing', 'TR 15:00 - 16:30', 'AS 129', 1, 3.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014443, 'ENG 330', 'Spring 2015', 'SAS', 'Language and Politics', 'TR 15:00 - 16:30', 'Classroom 17', 1, 5.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014446, 'ENG 418', 'Spring 2015', 'SAS', 'Studies in Eng Poetry & Prose', 'TR 11:30 - 13:00', 'Classroom 10', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014419, 'ENT 101', 'Spring 2015', 'SBE', 'Intro. to Entrepreneurship', 'MW 13:15 - 14:45', 'Classroom 02', 1, 33.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014358, 'ENT 101', 'Spring 2015', 'SBE', 'Intro. to Entrepreneurship', 'TR 16:45 - 18:15', 'Classroom 01', 1, 34.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014268, 'ENT 101', 'Spring 2015', 'SBE', 'Intro. to Entrepreneurship', 'MW 15:00 - 16:30', 'Classroom 05', 1, 34.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014420, 'ENT 201', 'Spring 2015', 'SBE', 'Entrepreneurship II', 'TR 13:15 - 14:45', 'Classroom 02', 1, 34.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014263, 'ENT 201', 'Spring 2015', 'SBE', 'Entrepreneurship II', 'TR 15:00 - 16:30', 'Classroom 02', 1, 31.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014211, 'ENT 201', 'Spring 2015', 'SBE', 'Entrepreneurship II', 'MW 08:00 - 09:30', 'Classroom 03', 1, 30.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014453, 'ENT 325', 'Spring 2015', 'SBE', 'Social Entrepreneurship', 'MW 15:00 - 16:30', 'Classroom 18', 1, 13.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014244, 'ENT 326', 'Spring 2015', 'SBE', 'Microfin & Econ Develpmnt', 'TR 16:45 - 18:15', 'Classroom 04', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014454, 'ENT 340', 'Spring 2015', 'SBE', 'Entrep. Sales & Marketing', 'MW 16:45 - 18:15', 'AS 129', 1, 16.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014422, 'ENT 345', 'Spring 2015', 'SBE', 'Entrpreneurial Innovation', 'TR 13:15 - 14:45', 'Classroom 03', 1, 10.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014488, 'ENT 492', 'Spring 2015', 'SBE', 'Entrepreneurship', '', '', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014461, 'FIN 201', 'Spring 2015', 'SBE', 'Fundementals of Financial Mgmt', 'MW 09:45 - 11:15', 'Classroom 13', 1, 10.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014249, 'FIN 310', 'Spring 2015', 'SBE', 'Analys. of Financial Statemnts', 'MW 11:30 - 13:00', 'Classroom 01', 1, 6.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014210, 'FIN 320', 'Spring 2015', 'SBE', 'Banking Finance Markets & Inst', 'TR 08:00 - 09:30', 'Classroom 02', 1, 2.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014494, 'FIN 420', 'Spring 2015', 'SBE', 'Portfolio Management', 'TR 13:15 - 14:45', 'Classroom 01', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014318, 'FIN 440', 'Spring 2015', 'SBE', 'Asset Valuation', 'TR 11:30 - 13:00', 'Classroom 06', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014307, 'FRE 101', 'Spring 2015', 'SAS', 'Introduction to French', 'MW 11:30 - 13:00', 'Classroom 14', 1, 38.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014421, 'FRE 102', 'Spring 2015', 'SAS', 'Elementary French II', 'MW 13:15 - 14:45', 'Classroom 03', 1, 6.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014435, 'GEO 101', 'Spring 2015', 'SAS', 'Introduction to Geology', 'TR 13:15 - 14:45', 'AS 131', 1, 21.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014399, 'GEO 301', 'Spring 2015', 'SAS', 'Elements of Pet. Geology', 'MW 13:15 - 14:45', 'AS 131', 1, 9.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014276, 'ICP 101', 'Spring 2015', 'SAS', 'Comparative Politics', 'MW 15:00 - 16:30', 'Classroom 15', 1, 19.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014258, 'ICP 131', 'Spring 2015', 'SAS', 'Intro International Relations', 'TR 09:45 - 11:15', 'AS 224', 1, 18.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014216, 'ICP 131', 'Spring 2015', 'SAS', 'Intro International Relations', 'TR 08:00 - 09:30', 'AS 318', 1, 9.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014404, 'ICP 161', 'Spring 2015', 'SAS', 'Intro to Political Theory', 'MW 11:30 - 13:00', 'Classroom 13', 1, 16.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014280, 'ICP 161', 'Spring 2015', 'SAS', 'Intro to Political Theory', 'MW 09:45 - 11:15', 'Classroom 14', 1, 8.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014433, 'ICP 205', 'Spring 2015', 'SAS', 'Intro to African Politics', 'MW 13:15 - 14:45', 'Classroom 04', 1, 22.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014202, 'ICP 232', 'Spring 2015', 'SAS', 'Model UN', 'W 08:00 - 09:00', 'AS 228', 1, 14.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014413, 'ICP 305', 'Spring 2015', 'SAS', 'Contemporary Nigerian Politics', 'TR 13:15 - 14:45', 'AS 125', 1, 7.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014281, 'ICP 331', 'Spring 2015', 'SAS', 'Topics in Internatnl Relations', 'TR 09:45 - 11:15', 'Classroom 14', 1, 20.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014379, 'ICP 434', 'Spring 2015', 'SAS', 'Global Environmntal politics', 'TR 16:45 - 18:15', 'AS 301', 1, 20.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014459, 'ICP 462', 'Spring 2015', 'SAS', 'Marxism and Socialism', 'MW 11:30 - 13:00', 'Classroom 18', 1, 12.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014442, 'ICP 486', 'Spring 2015', 'SAS', 'Mangmnt polces in Public Admin', 'TR 13:15 - 14:45', 'Classroom 08', 1, 12.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014508, 'ICP 492', 'Spring 2015', 'SAS', 'Independent Study ICP: Boko Haram Research Project', '', '', 1, 5.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014501, 'ICP 492', 'Spring 2015', 'SAS', 'Independent Study ICP', '', '', 1, 3.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014310, 'INF 102', 'Spring 2015', 'SITC', 'Software Applications I', 'TR 09:45 - 11:15', 'AS 303', 1, 15.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014335, 'INF 201', 'Spring 2015', 'SITC', 'Principles of Info. Systems', 'TR 13:15 - 14:45', 'AS 303', 1, 22.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014328, 'INF 201', 'Spring 2015', 'SITC', 'Principles of Info. Systems', 'MW 13:15 - 14:45', 'AS 125', 1, 35.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014320, 'INF 201', 'Spring 2015', 'SITC', 'Principles of Info. Systems', 'MW 11:30 - 13:00', 'AS 301', 1, 22.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014325, 'INF 206', 'Spring 2015', 'SITC', 'IT Systems: Hardware/Software', 'TR 11:30 - 13:00', 'AS 301', 1, 13.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014314, 'INF 260', 'Spring 2015', 'SITC', 'Sys Analysis and Design', 'TR 09:45 - 11:15', 'AS 318', 1, 9.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014343, 'INF 301', 'Spring 2015', 'SITC', 'Security Script Programming', 'TR 15:00 - 16:30', 'AS 301', 1, 0.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014511, 'INF 331', 'Spring 2015', 'SITC', 'Database Analysis and Design', 'TR 15:00 - 16:30', '', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014345, 'INF 341', 'Spring 2015', 'SITC', 'Enterprise Integration', 'TR 15:00 - 16:30', 'Classroom 08', 1, 16.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014473, 'INF 351', 'Spring 2015', 'SITC', 'Infor Security & Auditing', 'MW 18:30 - 20:00', 'AS 129', 1, 13.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014339, 'INF 361', 'Spring 2015', 'SITC', 'Proc Mod & Sol Blueprinting', 'MW 15:00 - 16:30', 'AS 301', 1, 17.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014327, 'INF 402', 'Spring 2015', 'SITC', 'Information Technology for Devel', 'TR 11:30 - 13:00', 'Classroom 08', 1, 20.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014504, 'INF 405', 'Spring 2015', 'SITC', 'IS Strategy', 'MW 16:15 - 17:15', 'Classroom 06', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014347, 'INF 421', 'Spring 2015', 'SITC', 'Client Oper Systems Security', 'MW 16:45 - 18:15', 'AS 125', 1, 10.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014355, 'INF 461', 'Spring 2015', 'SITC', 'Information Systems Planning', 'TR 15:00 - 16:30', 'AS 125', 1, 11.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014506, 'INF 488', 'Spring 2015', 'SITC', 'Data Administration', 'MW 13:15 - 14:45', 'Classroom 04', 1, 3.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014507, 'INF 489', 'Spring 2015', 'SITC', 'Web Database Driven App. Devlp', 'MW 13:15 - 14:45', 'Classroom 06', 1, 3.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014299, 'INF 490', 'Spring 2015', 'SITC', 'Intr to Busi Dynamics: Sys Thi', 'TR 08:00 - 09:30', 'Classroom 08', 1, 27.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014474, 'INF 491', 'Spring 2015', 'SITC', 'Senior Design Project/Capstone', 'F 15:00 - 16:00', 'AS 301', 1, 21.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014503, 'INF 492', 'Spring 2015', 'SITC', 'Independent Studies: Web Database Driven Application Development', '', '', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014465, 'ITC 101', 'Spring 2015', 'SITC', 'Intro to Software Applications', 'F 12:00 - 13:00', 'AS 228', 1, 19.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014464, 'ITC 101', 'Spring 2015', 'SITC', 'Intro to Software Applications', 'W 12:00 - 13:00', 'AS 228', 1, 14.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014463, 'ITC 101', 'Spring 2015', 'SITC', 'Intro to Software Applications', 'W 17:30 - 18:30', 'AS 228', 1, 21.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014493, 'MAT 100', 'Spring 2015', 'SAS', 'PreAlgebra', 'TR 13:15 - 14:45', 'Classroom 16', 1, 8.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014483, 'MAT 110', 'Spring 2015', 'SAS', 'University Algebra', 'MW 11:30 - 13:00', 'AS 125', 1, 19.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014467, 'MAT 110', 'Spring 2015', 'SAS', 'University Algebra', 'MW 15:00 - 16:30', 'Classroom 12', 1, 12.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014378, 'MAT 110', 'Spring 2015', 'SAS', 'University Algebra', 'MW 16:45 - 18:15', 'Classroom 16', 1, 15.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014232, 'MAT 110', 'Spring 2015', 'SAS', 'University Algebra', 'MW 09:45 - 11:15', 'AS 224', 1, 6.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014226, 'MAT 110', 'Spring 2015', 'SAS', 'University Algebra', 'MW 08:00 - 09:30', 'Classroom 16', 1, 22.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014221, 'MAT 110', 'Spring 2015', 'SAS', 'University Algebra', 'MW 08:00 - 09:30', 'Classroom 12', 1, 15.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014227, 'MAT 110E', 'Spring 2015', 'SAS', 'MAT Learning Enhanced Lab', 'TR 08:00 - 09:30', 'Classroom 16', 1, 22.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014222, 'MAT 110E', 'Spring 2015', 'SAS', 'MAT Learning Enhanced Lab', 'TR 08:00 - 09:30', 'Classroom 12', 1, 15.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014431, 'MAT 120', 'Spring 2015', 'SAS', 'Pre-Calculus', 'MW 13:15 - 14:45', 'Classroom 12', 1, 19.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014402, 'MAT 120', 'Spring 2015', 'SAS', 'Pre-Calculus', 'MW 11:30 - 13:00', 'Classroom 12', 1, 22.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014224, 'MAT 120', 'Spring 2015', 'SAS', 'Pre-Calculus', 'MW 08:00 - 09:30', 'Classroom 15', 1, 20.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014393, 'MAT 121', 'Spring 2015', 'SAS', 'Calculus I', 'TR 15:00 - 16:30', 'Classroom 10', 1, 27.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014274, 'MAT 121', 'Spring 2015', 'SAS', 'Calculus I', 'TR 15:00 - 16:30', 'Classroom 13', 1, 20.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014287, 'MAT 210', 'Spring 2015', 'SAS', 'Calculus II', 'TR 09:45 - 11:15', 'Classroom 18', 1, 15.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014217, 'MAT 210', 'Spring 2015', 'SAS', 'Calculus II', 'MWF 08:00 - 09:00', 'Classroom 10', 1, 17.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014396, 'MAT 211', 'Spring 2015', 'SAS', 'Calculus III', 'MWF 12:00 - 13:00', 'Classroom 10', 1, 16.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014496, 'MAT 212', 'Spring 2015', 'SITC', 'Linear Algebra', 'MW 16:45 - 18:15', 'Classroom 05', 1, 5.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014385, 'MAT 310', 'Spring 2015', 'SAS', 'Differential Equations', 'TR 18:30 - 20:00', 'Classroom 02', 1, 4.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014212, 'MGT 201', 'Spring 2015', 'SBE', 'Fundamentals of Management', 'TR 08:00 - 09:30', 'AS 125', 1, 24.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014243, 'MGT 300', 'Spring 2015', 'SBE', 'International Business', 'TR 09:45 - 11:15', 'Classroom 05', 1, 21.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014423, 'MGT 301', 'Spring 2015', 'SBE', 'Organizational Behavior', 'TR 13:15 - 14:45', 'Classroom 04', 1, 9.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014240, 'MGT 360', 'Spring 2015', 'SBE', 'Bus Ethics & Socl Responsiblty', 'MW 09:45 - 11:15', 'Classroom 04', 1, 11.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014505, 'MGT 380', 'Spring 2015', 'SITC', 'Project Management', 'MW 11:30 - 13:00', 'Classroom 16', 1, 8.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014316, 'MGT 406', 'Spring 2015', 'SBE', 'Business Policy and Strategy', 'TR 11:30 - 13:00', 'Classroom 05', 1, 12.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014357, 'MKT 201', 'Spring 2015', 'SBE', 'Fundamentals of Marketing', 'F 15:00 - 18:00', 'Classroom 01', 1, 17.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014509, 'MKT 492', 'Spring 2015', 'SBE', 'Marketing Independent Study: International Marketing', '', '', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014490, 'MKT 492', 'Spring 2015', 'SBE', 'Marketing Independent Study', '', '', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014373, 'NES 101', 'Spring 2015', 'SAS', 'Top in Env Sci: Environ Change', 'TR 16:45 - 18:15', 'Classroom 02', 1, 25.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014372, 'NES 101', 'Spring 2015', 'SAS', 'Top in Env Sci: Environ Change', 'MW 16:45 - 18:15', 'Classroom 02', 1, 34.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014273, 'NES 201', 'Spring 2015', 'SAS', 'Int Natural & Environmental Sc', 'MW 16:45 - 18:15', 'Conference Room 26', 1, 8.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014452, 'NES 320', 'Spring 2015', 'SAS', 'Special Topics: Agricultural Systems', 'TR 15:00 - 16:30', 'AS 225', 1, 21.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014376, 'NES 344', 'Spring 2015', 'SAS', 'Environmental Risk Assessement', 'MW 16:45 - 18:15', 'Classroom 15', 1, 4.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014278, 'NES 420', 'Spring 2015', 'SAS', 'Env and Occupational Health', 'MW 15:00 - 16:30', 'AS 225', 1, 8.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014381, 'NES 490', 'Spring 2015', 'SAS', 'Senior Research Project NES', 'TR 18:30 - 20:00', 'AS 226', 1, 10.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014460, 'NES 492', 'Spring 2015', 'SAS', 'Independent Study: Global Health', 'MW 13:15 - 14:45', 'AS 226', 1, 9.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014472, 'NES 493', 'Spring 2015', 'SAS', 'Internship', '', '', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014489, 'PET 201', 'Spring 2015', 'SAS', 'Reservoir Engineering', 'TR 11:30 - 13:00', 'Classroom 07', 1, 7.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014367, 'PET 430', 'Spring 2015', 'SAS', 'Oli & Production Engineering', 'TR 16:45 - 18:15', 'Classroom 05', 1, 10.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014366, 'PET 480', 'Spring 2015', 'SAS', 'Petro Team Design Project', 'MW 16:45 - 18:15', 'Classroom 07', 1, 12.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014384, 'PET 490', 'Spring 2015', 'SAS', 'Petroleum Research Project', 'MW 18:30 - 20:00', 'Classroom 02', 1, 3.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014429, 'PHI 201', 'Spring 2015', 'SAS', 'Comp Religions: Islam/Christ', 'MW 13:15 - 14:45', 'Classroom 11', 1, 20.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014405, 'PHI 300', 'Spring 2015', 'SAS', 'Ethics and Leadership', 'TR 11:30 - 13:00', 'Classroom 13', 1, 20.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014371, 'PHI 300', 'Spring 2015', 'SAS', 'Ethics and Leadership', 'TR 16:45 - 18:15', 'Classroom 12', 1, 33.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014363, 'PHI 300', 'Spring 2015', 'SAS', 'Ethics and Leadership', 'MW 16:45 - 18:15', 'Classroom 04', 1, 13.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014282, 'PHI 300', 'Spring 2015', 'SAS', 'Ethics and Leadership', 'MW 09:45 - 11:15', 'Classroom 15', 1, 7.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014213, 'PHI 300', 'Spring 2015', 'SAS', 'Ethics and Leadership', 'MW 08:00 - 09:30', 'Classroom 04', 1, 2.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014218, 'PHY 131', 'Spring 2015', 'SAS', 'College Physics I', 'TR 08:00 - 09:30', 'Classroom 10', 1, 15.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014283, 'PHY 132', 'Spring 2015', 'SAS', 'College Physics II', 'TR 09:45 - 11:15', 'AS 126', 1, 23.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014236, 'PHY 205', 'Spring 2015', 'SAS', 'Unv Phys I- Prncpls of Physc I', 'TR 09:45 - 11:15', 'Classroom 01', 1, 10.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014269, 'PHY 206', 'Spring 2015', 'SAS', 'Unv Phy II - Prncpls of Phy II', 'TR 15:00 - 16:30', 'Classroom 05', 1, 16.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014486, 'PSY 101', 'Spring 2015', 'SAS', 'Introduction to Pyschology', 'MW 16:45 - 18:15', 'Classroom 13', 1, 20.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014370, 'PSY 101', 'Spring 2015', 'SAS', 'Introduction to Pyschology', 'MW 16:45 - 18:15', 'Classroom 14', 1, 42.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014470, 'QBA 201', 'Spring 2015', 'SBE', 'Quantitative Business Analysis', 'MW 09:45 - 11:15', 'Classroom 03', 1, 18.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014209, 'QBA 202', 'Spring 2015', 'SBE', 'Operations Management', 'MW 08:00 - 09:30', 'Classroom 02', 1, 14.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014248, 'QBA 411', 'Spring 2015', 'SBE', 'Research Methodology', 'MW 15:00 - 16:30', 'AS 228', 1, 6.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014250, 'QBA 412', 'Spring 2015', 'SBE', 'Research Project', 'F 15:00 - 18:00', 'AS 228', 1, 9.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014342, 'SEN 301', 'Spring 2015', 'SITC', 'Intro to Software Engineering', 'TR 15:00 - 16:30', 'AS 303', 1, 14.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014334, 'SEN 306', 'Spring 2015', 'SITC', 'Low level Software Des of Soft', 'TR 13:15 - 14:45', 'AS 224', 1, 10.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014300, 'SEN 312', 'Spring 2015', 'SITC', 'User Interface Design', 'MW 09:45 - 11:15', 'AS 228', 1, 4.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014312, 'SEN 400', 'Spring 2015', 'SITC', 'SW Professional Ethics', 'TR 09:45 - 11:15', 'AS 301', 1, 18.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014351, 'SEN 405', 'Spring 2015', 'SITC', 'Sftwre Reqrmnt Anlysis & Spec.', 'MW 16:45 - 18:15', 'Classroom 08', 1, 2.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014291, 'SEN 406', 'Spring 2015', 'SITC', 'Technical Report Writing', 'MW 08:00 - 09:30', 'Classroom 08', 1, 9.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014324, 'SEN 415', 'Spring 2015', 'SITC', 'Software Testing & Quality Ass', 'TR 11:30 - 13:00', 'AS 303', 1, 10.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014329, 'SEN 416', 'Spring 2015', 'SITC', 'Software Design & Archtec.', 'MW 13:15 - 14:45', 'AS 129', 1, 4.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014447, 'SEN 470', 'Spring 2015', 'SITC', 'Engineering Economics', 'MW 15:00 - 16:30', 'AS 129', 1, 9.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014476, 'SEN 490', 'Spring 2015', 'SITC', 'SW Senior Design Project', 'F 15:00 - 16:00', 'AS 301', 1, 2.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014364, 'SOC 101', 'Spring 2015', 'SAS', 'Introduction to Sociology', 'MW 18:30 - 20:00', 'AS 224', 1, 20.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014304, 'SOC 101', 'Spring 2015', 'SAS', 'Introduction to Sociology', 'MW 11:30 - 13:00', 'Classroom 02', 1, 7.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014430, 'SOC 288', 'Spring 2015', 'SAS', 'Criminology I', 'TR 13:15 - 14:45', 'Classroom 11', 1, 22.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014365, 'SOC 390', 'Spring 2015', 'SAS', 'Social Sci. Research Methods', 'T 15:00 - 18:00', 'Conference Room 26', 1, 7.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014434, 'STA 101', 'Spring 2015', 'SAS', 'Introduction to Statistics', 'MW 13:15 - 14:45', 'Classroom 14', 1, 20.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014229, 'STA 101', 'Spring 2015', 'SAS', 'Introduction to Statistics', 'TR 09:45 - 11:15', 'AS 125', 1, 22.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014437, 'STA 301', 'Spring 2015', 'SAS', 'Probability and Statistics', 'TR 13:15 - 14:45', 'Classroom 15', 1, 17.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014340, 'TEL 251', 'Spring 2015', 'SITC', 'Digital Systems & Lab', 'MW 15:00 - 16:30', 'AS 318', 1, 2.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014332, 'TEL 301', 'Spring 2015', 'SITC', 'Prin of Tel Engin Theory', 'MW 13:15 - 14:45', 'Classroom 08', 1, 5.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014315, 'TEL 310', 'Spring 2015', 'SITC', 'Telecoms Syst & Archtecture', 'TR 09:45 - 11:15', 'Classroom 08', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014326, 'TEL 331', 'Spring 2015', 'SITC', 'Telecom & Datacom Laws', 'TR 11:30 - 13:00', 'AS 318', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014333, 'TEL 351', 'Spring 2015', 'SITC', 'Telecom Netwk Security & Audit', 'TR 18:30 - 20:00', 'AS 129', 1, 5.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014499, 'TEL 360', 'Spring 2015', 'SITC', 'RF/Mcrowve Sys Desg & Spec Man', 'TR 13:15 - 14:45', 'AS 318', 1, 2.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014344, 'TEL 361', 'Spring 2015', 'SITC', 'Telecom Protocls & Technlogies', 'TR 15:00 - 16:30', 'AS 318', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014349, 'TEL 429', 'Spring 2015', 'SITC', 'Intro to Switching Netwrks', 'MW 11:30 - 13:00', 'Classroom 05', 1, 5.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014353, 'TEL 472', 'Spring 2015', 'SITC', 'LAN Administration', 'TR 16:45 - 18:15', 'Classroom 16', 1, 5.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014336, 'TEL 474', 'Spring 2015', 'SITC', 'Internetworking & TCP/IP', 'TR 13:15 - 14:45', 'AS 301', 1, 5.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014475, 'TEL 490', 'Spring 2015', 'SITC', 'Snr Tel Desgn Project/Capstone', 'F 15:00 - 16:00', 'AS 301', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014498, 'TEL 499', 'Spring 2015', 'SITC', 'Advances in Comm Network', 'MW 08:00 - 09:30', 'AS 318', 1, 1.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014469, 'WRI 101', 'Spring 2015', 'SAS', 'Freshman Composition I', 'TR 11:30 - 13:00', 'Classroom 11', 1, 21.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014400, 'WRI 101', 'Spring 2015', 'SAS', 'Freshman Composition I', 'MW 11:30 - 13:00', 'Classroom 11', 1, 22.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014284, 'WRI 101', 'Spring 2015', 'SAS', 'Freshman Composition I', 'MW 09:45 - 11:15', 'Classroom 16', 1, 23.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014260, 'WRI 101', 'Spring 2015', 'SAS', 'Freshman Composition I', 'MW 09:45 - 11:15', 'Classroom 02', 1, 22.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014262, 'WRI 101E', 'Spring 2015', 'SAS', 'WRI 101 Learning Enhanced Lab', 'TR 09:45 - 11:15', 'Classroom 02', 1, 22.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014444, 'WRI 102', 'Spring 2015', 'SAS', 'Freshman Composition II', 'TR 09:45 - 11:15', 'AS 228', 1, 21.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014311, 'WRI 102', 'Spring 2015', 'SAS', 'Freshman Composition II', 'TR 11:30 - 13:00', 'Classroom 04', 1, 23.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014259, 'WRI 102', 'Spring 2015', 'SAS', 'Freshman Composition II', 'MW 15:00 - 16:30', 'Classroom 02', 1, 18.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014257, 'WRI 102', 'Spring 2015', 'SAS', 'Freshman Composition II', 'MW 09:45 - 11:15', 'Classroom 12', 1, 20.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014214, 'WRI 102', 'Spring 2015', 'SAS', 'Freshman Composition II', 'TR 08:00 - 09:30', 'Classroom 04', 1, 18.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014455, 'WRI 300', 'Spring 2015', 'SAS', 'Writing in the Disciplines', 'MW 18:30 - 20:00', 'AS 226', 1, 4.0, 0, 0);
INSERT INTO `fce`.`sections` (`crn`, `course_code`, `semester`, `school`, `course_title`, `class_time`, `location`, `locked`, `enrolled`, `mid_evaluation`, `final_evaluation`) VALUES (2014468, 'WRI 321', 'Spring 2015', 'SAS', 'Prep of Written & Oral Reports', 'TR 13:15 - 14:45', 'Classroom 14', 1, 23.0, 0, 0);

COMMIT;


-- -----------------------------------------------------
-- Data for table `fce`.`course_assignments`
-- -----------------------------------------------------
START TRANSACTION;
USE `fce`;
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014480, 'ifeatu.uzodinma@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014208, 'fodio.musa@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014208, 'ifeatu.uzodinma@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014479, 'vrajlal.sapovadia@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014207, 'samuel.akanno@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014235, 'samuel.akanno@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014450, 'vrajlal.sapovadia@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014256, 'vrajlal.sapovadia@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014451, 'vrajlal.sapovadia@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014417, 'samuel.akanno@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014270, 'alzouma.gado@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014462, 'jennifer.che@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014458, 'reginald.braggs@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014416, 'jessica.boyd@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014416, 'okeoghene.okoro@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014205, 'jessica.boyd@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014377, 'jay.siebert@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014377, 'okeoghene.okoro@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014206, 'jennifer.tyndall@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014234, 'hayatu.raji@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014253, 'hayatu.raji@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014410, 'jessica.boyd@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014298, 'jennifer.tyndall@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014457, 'grace.malgwi@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014456, 'grace.malgwi@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014481, 'jelena.zivkovic@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014478, 'fidelis.ndehche@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014255, 'ifeoma.joseph@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014309, 'victoria.adams@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014411, 'ifeoma.joseph@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014411, 'linus.okoro@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014428, 'wan.jahng@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014230, 'wan.jahng@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014286, 'bolade.agboola@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014497, 'bolade.agboola@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014215, 'linus.okoro@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014285, 'wan.jahng@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014403, 'bolade.agboola@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014412, 'wan.jahng@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014392, 'linus.okoro@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014391, 'victoria.adams@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014252, 'linus.okoro@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014361, 'wan.jahng@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014382, 'bolade.agboola@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014382, 'linus.okoro@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014382, 'wan.jahng@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014362, 'ifeoma.joseph@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014440, 'ifeoma.joseph@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014482, 'obioma.uche@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014290, 'obioma.uche@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014317, 'egunsola.olubola@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014289, 'olusegun.ogundapo@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014293, 'alexey.vedishchev@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014288, 'egunsola.olubola@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014306, 'andrei.dragunov@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014296, 'andrei.dragunov@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014348, 'evgeny.arkhipov@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014352, 'emmanuel.ukpe@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014303, 'ferdinand.che@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014308, 'charles.nche@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014368, 'alzouma.gado@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014445, 'elke.debuhr@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014409, 'loveday.gbara@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014408, 'loveday.gbara@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014305, 'joseph.rishante@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014275, 'ikechukwu.eke@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014295, 'abdul.mousa@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014388, 'abba@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014369, 'jacob.jacob@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014432, 'jacob.jacob@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014436, 'jacob.jacob@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014375, 'ikechukwu.eke@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014407, 'presly.obukoada@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014294, 'abdul.mousa@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014389, 'joseph.rishante@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014387, 'abba@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014238, 'joseph.rishante@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014441, 'abiodun.adeniyi@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014220, 'presly.obukoada@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014374, 'abiodun.adeniyi@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014203, 'abdul.mousa@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014246, 'abiodun.adeniyi@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014513, 'presly.obukoada@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014406, 'presly.obukoada@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014219, 'presly.obukoada@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014204, 'abdul.mousa@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014386, 'jacob.jacob@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014383, 'abba@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014338, 'egunsola.olubola@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014341, 'augustine.nsang@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014323, 'andrei.dragunov@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014319, 'hieu.vu@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014354, 'francis.adepoju@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014350, 'francis.adepoju@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014322, 'augustine.nsang@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014330, 'apkar.salatian@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014337, 'augustine.nsang@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014346, 'evgeny.arkhipov@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014512, 'augustine.nsang@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014477, 'ash.hussaini@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014477, 'babatunde.ogunleye@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014477, 'egunsola.olubola@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014502, 'hieu.vu@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014414, 'sicy francis@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014254, 'wasiq.khan@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014425, 'wasiq.khan@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014427, 'sicy francis@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014424, 'wasiq.khan@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014313, 'daniel.@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014241, 'daniel.@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014267, 'wasiq.khan@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014292, 'john.leonard@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014242, 'daniel.@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014510, 'john.leonard@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014487, 'john.leonard@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014426, 'agatha.ukata@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014231, 'steve.devitt@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014302, 'hannah.mugambi@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014251, 'agatha.ukata@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014390, 'tristan.purvis@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014394, 'agatha.ukata@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014245, 'steve.devitt@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014443, 'tristan.purvis@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014446, 'brian.reed@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014419, 'fardeen.dodo@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014419, 'ibro.danjuma@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014358, 'kamarudeen.bello@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014268, 'tende.sam@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014268, 'shulammite.paul@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014420, 'kamarudeen.bello@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014263, 'hassan.yusuf@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014211, 'tende.sam@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014211, 'shulammite.paul@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014453, 'jelena.zivkovic@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014453, 'martin.burt@gmail.com');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014244, 'jelena.zivkovic@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014244, 'martin.burt@gmail.com');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014454, 'fardeen.dodo@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014422, 'fardeen.dodo@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014488, 'linus.osuagwu@qun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014461, 'suleiman.tahir@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014249, 'ifeatu.uzodinma@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014210, 'suleiman.tahir@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014494, 'ifeatu.uzodinma@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014318, 'jacob.shehu@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014307, 'emilienne.akpan@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014421, 'emilienne.akpan@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014435, 'yusuf.mamman@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014399, 'yusuf.mamman@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014276, 'bill.hansen@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014258, 'lucky.imade@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014216, 'lucky.imade@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014404, 'patrick.fay@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014280, 'patrick.fay@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014433, 'loveday.gbara@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014202, 'lucky.imade@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014413, 'lucky.imade@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014281, 'patrick.fay@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014379, 'lucky.imade@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014459, 'bill.hansen@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014442, 'loveday.gbara@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014508, 'bill.hansen@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014501, 'loveday.gbara@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014310, 'chioma@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014335, 'chioma@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014328, 'aquaye@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014320, 'nwokoma@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014325, 'nwokoma@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014314, 'ferdinand.che@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014343, 'nwokoma@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014511, 'francis.adepoju@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014345, 'emmanuel.ukpe@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014473, 'francis.adepoju@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014339, 'nwokoma@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014327, 'emmanuel.ukpe@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014504, 'emmanuel.ukpe@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014347, 'aquaye@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014355, 'apkar.salatian@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014506, 'abel.ajibesin@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014507, 'emmanuel.ukpe@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014299, 'emmanuel.ukpe@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014474, 'ash.hussaini@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014474, 'babatunde.ogunleye@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014474, 'egunsola.olubola@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014503, 'emmanuel.ukpe@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014465, 'olusegun.ogundapo@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014464, 'olusegun.ogundapo@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014463, 'chioma@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014493, 'amy.drambi@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014483, 'jamiu.olumoh@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014467, 'osho.ajayi@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014378, 'adewale.james@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014232, 'osho.ajayi@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014226, 'amy.drambi@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014221, 'jamiu.olumoh@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014227, 'amy.drambi@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014222, 'jamiu.olumoh@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014431, 'adewale.james@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014402, 'adewale.james@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014224, 'adewale.james@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014393, 'quarcoo@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014274, 'fokam@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014287, 'fokam@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014217, 'quarcoo@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014396, 'quarcoo@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014496, 'augustine.nsang@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014385, 'fokam@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014212, 'abdulsalam.dauda@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014212, 'fardeen.dodo@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014243, 'hassan.yusuf@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014423, 'alfredo.ocampo@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014240, 'ibro.danjuma@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014240, 'shulammite.paul@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014505, 'francis.adepoju@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014316, 'abdulsalam.dauda@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014316, 'hassan.yusuf@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014357, 'kamarudeen.bello@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014509, 'linus.osuagwu@qun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014490, 'linus.osuagwu@qun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014373, 'jennifer.che@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014372, 'jay.siebert@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014273, 'lynne.baker@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014452, 'jay.siebert@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014376, 'friday.ogwu@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014278, 'jay.siebert@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014381, 'jessica.boyd@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014460, 'jennifer.tyndall@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014472, 'jennifer.tyndall@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014489, 'victoria.adams@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014367, 'obioma.uche@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014366, 'obioma.uche@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014384, 'victoria.adams@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014384, 'obioma.uche@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014429, 'pavel.ushakov@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014405, 'patrick.fay@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014371, 'lionel.rawlins@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014363, 'pavel.ushakov@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014282, 'pavel.ushakov@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014213, 'pavel.ushakov@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014218, 'biyasa.abraham@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014283, 'amy.drambi@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014236, 'biyasa.abraham@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014269, 'biyasa.abraham@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014486, 'regina.mousa@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014370, 'lionel.rawlins@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014470, 'jacob.shehu@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014209, 'jacob.shehu@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014248, 'jacob.shehu@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014250, 'linus.osuagwu@qun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014342, 'andrei.dragunov@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014334, 'apkar.salatian@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014300, 'aquaye@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014312, 'babatunde.ogunleye@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014351, 'apkar.salatian@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014291, 'ash.hussaini@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014324, 'hieu.vu@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014329, 'hieu.vu@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014447, 'ferdinand.che@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014476, 'ash.hussaini@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014476, 'babatunde.ogunleye@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014476, 'egunsola.olubola@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014364, 'regina.mousa@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014304, 'alzouma.gado@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014430, 'lionel.rawlins@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014365, 'elke.debuhr@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014434, 'osho.ajayi@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014229, 'jamiu.olumoh@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014437, 'osho.ajayi@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014340, 'charles.nche@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014332, 'abel.ajibesin@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014315, 'babatunde.ogunleye@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014326, 'abel.ajibesin@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014333, 'francis.adepoju@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014499, 'olusegun.ogundapo@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014344, 'charles.nche@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014349, 'abel.ajibesin@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014353, 'abel.ajibesin@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014336, 'babatunde.ogunleye@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014475, 'ash.hussaini@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014475, 'babatunde.ogunleye@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014475, 'egunsola.olubola@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014498, 'abel.ajibesin@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014469, 'mariana.silva@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014400, 'ikechukwu.eke@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014284, 'grace.malgwi@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014260, 'tristan.purvis@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014262, 'tristan.purvis@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014444, 'brian.reed@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014311, 'agatha.ukata@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014259, 'hannah.mugambi@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014257, 'hannah.mugambi@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014214, 'brian.reed@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014455, 'brian.reed@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014455, 'jennifer.tyndall@aun.edu.ng');
INSERT INTO `fce`.`course_assignments` (`crn`, `faculty_email`) VALUES (2014468, 'hannah.mugambi@aun.edu.ng');

COMMIT;


-- -----------------------------------------------------
-- Data for table `fce`.`roles`
-- -----------------------------------------------------
START TRANSACTION;
USE `fce`;
INSERT INTO `fce`.`roles` (`role`) VALUES ('admin');
INSERT INTO `fce`.`roles` (`role`) VALUES ('faculty');
INSERT INTO `fce`.`roles` (`role`) VALUES ('secretary');
INSERT INTO `fce`.`roles` (`role`) VALUES ('dean');
INSERT INTO `fce`.`roles` (`role`) VALUES ('executive');

COMMIT;


-- -----------------------------------------------------
-- Data for table `fce`.`user_roles`
-- -----------------------------------------------------
START TRANSACTION;
USE `fce`;
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('admin@aun.edu.ng', 'admin');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('admin@aun.edu.ng', 'secretary');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('mfonkam@aun.edu.ng', 'dean');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('jacob.jacob@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('abdul.mousa@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('joseph.rishante@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('abba@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('presly.obukoada@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('abiodun.adeniyi@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('daniel.@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('wasiq.khan@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('john.leonard@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('sicy francis@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('agatha.ukata@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('brian.reed@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('grace.malgwi@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('hannah.mugambi@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('mariana.silva@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('steve.devitt@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('ikechukwu.eke@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('tristan.purvis@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('alzouma.gado@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('pavel.ushakov@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('emilienne.akpan@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('biyasa.abraham@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('yusuf.mamman@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('amy.drambi@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('muhammad.dauda@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('regina.mousa@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('bill.hansen@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('kimberly.sims@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('loveday.gbara@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('lucky.imade@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('patrick.fay@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('adewale.james@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('jamiu.olumoh@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('fokam@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('quarcoo@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('osho.ajayi@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('charles.reith@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('hayatu.raji@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('jay.siebert@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('jennifer.tyndall@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('jessica.boyd@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('lynne.baker@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('okeoghene.okoro@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('friday.ogwu@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('bolade.agboola@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('linus.okoro@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('obioma.uche@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('wan.jahng@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('ifeoma.joseph@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('victoria.adams@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('abel.ajibesin@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('aquaye@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('nwokoma@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('apkar.salatian@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('francis.adepoju@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('babatunde.ogunleye@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('chioma@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('emmanuel.ukpe@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('egunsola.olubola@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('hieu.vu@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('olusegun.ogundapo@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('augustine.nsang@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('charles.nche@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('ferdinand.che@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('andrei.dragunov@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('evgeny.arkhipov@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('alexey.vedishchev@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('emmanuel.nicholas@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('ash.hussaini@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('linus.osuagwu@qun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('samuel.akanno@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('martin.burt@gmail.com', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('ibro.danjuma@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('abdulsalam.dauda@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('fardeen.dodo@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('ifeatu.uzodinma@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('kamarudeen.bello@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('fodio.musa@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('alfredo.ocampo@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('shulammite.paul@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('tende.sam@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('jacob.shehu@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('suleiman.tahir@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('hassan.yusuf@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('vrajlal.sapovadia@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('jelena.zivkovic@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('jennifer.che@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('reginald.braggs@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('fidelis.ndehche@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('elke.debuhr@aun.edu.ng', 'faculty');
INSERT INTO `fce`.`user_roles` (`user_email`, `user_role`) VALUES ('lionel.rawlins@aun.edu.ng', 'faculty');

COMMIT;

