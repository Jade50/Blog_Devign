--# ------------------------------------------------------------------
--# CREATION BASE DE DONNEES
--# ------------------------------------------------------------------
CREATE DATABASE IF NOT EXISTS `devign` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `devign`;

--# ------------------------------------------------------------------
--# CREATION TABLES
--# ------------------------------------------------------------------

--# Table POST_CATEGORIE----------------------------------------------
CREATE TABLE IF NOT EXISTS `post_category` (
    `pst_category_id` INT(11) NOT NULL AUTO_INCREMENT,
    `pst_category_name` VARCHAR(75) NOT NULL,

    PRIMARY KEY (`pst_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--# Table ROLE--------------------------------------------------------
CREATE TABLE IF NOT EXISTS `role` (
    `rol_id` INT(11) NOT NULL AUTO_INCREMENT,
    `rol_name` VARCHAR(75) NOT NULL,

    PRIMARY KEY (`rol_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--# Table USER--------------------------------------------------------
CREATE TABLE IF NOT EXISTS `user` (
    `usr_id` INT(11) NOT NULL AUTO_INCREMENT,
    `usr_inscription` DATETIME NOT NULL,
    `usr_name` VARCHAR(75) NOT NULL,
    `usr_first_name` VARCHAR(75) NOT NULL,
    `usr_login` VARCHAR(75) NOT NULL,
    `usr_birth` DATE NOT NULL,
    `usr_email` VARCHAR(75) NOT NULL,
    `usr_password` VARCHAR(255) NOT NULL,
    `usr_avatar` VARCHAR(255) NOT NULL,

    `usr_rol_fk` INT(11) NOT NULL,

    PRIMARY KEY (`usr_id`),
    KEY (`usr_rol_fk`),

    CONSTRAINT `constraint_usr_rol` FOREIGN KEY(`usr_rol_fk`) REFERENCES `role` (`rol_id`)ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--# Table POST--------------------------------------------------------
CREATE TABLE IF NOT EXISTS `post` (
    `pst_id` INT(11) NOT NULL AUTO_INCREMENT,
    `pst_title` VARCHAR(255) NOT NULL,
    `pst_text` TEXT NOT NULL,
    `pst_date` DATETIME NOT NULL,

    `pst_usr_fk` INT(11) NOT NULL,
    `pst_category_fk` INT(11) NOT NULL,

    PRIMARY KEY (`pst_id`),
    KEY (`pst_usr_fk`),
    KEY (`pst_category_fk`),

    CONSTRAINT `constraint_pst_usr` FOREIGN KEY(`pst_usr_fk`) REFERENCES `user` (`usr_id`)ON UPDATE CASCADE ON DELETE RESTRICT,

    CONSTRAINT `constraint_pst_cat` FOREIGN KEY(`pst_category_fk`) REFERENCES `post_category` (`pst_category_id`)ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--# Table COMMENT--------------------------------------------------------
CREATE TABLE IF NOT EXISTS `comment` (
    `com_id` INT(11) NOT NULL AUTO_INCREMENT,
    `com_content` TEXT NOT NULL,
    `com_seen` BOOLEAN NOT NULL,
    `com_date` DATETIME NOT NULL,

    `com_pst_fk` INT(11) NOT NULL,
    `com_usr_fk` INT(11) NOT NULL,

    PRIMARY KEY (`com_id`),
    KEY (`com_pst_fk`),
    KEY (`com_usr_fk`),

    CONSTRAINT `constraint_com_pst` FOREIGN KEY(`com_pst_fk`) REFERENCES `post` (`pst_id`)ON UPDATE CASCADE ON DELETE RESTRICT,

    CONSTRAINT `constraint_com_usr` FOREIGN KEY(`com_usr_fk`) REFERENCES `user` (`user_id`)ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--# Table IMG_POST--------------------------------------------------------
CREATE TABLE IF NOT EXISTS `img_post` (
    `img_pst_id` INT(11) NOT NULL AUTO_INCREMENT,

    `img_pst_fk` INT(11) NOT NULL,

    PRIMARY KEY (`img_pst_id`),
    KEY (`img_pst_fk`),

    CONSTRAINT `constraint_img_pst` FOREIGN KEY(`img_pst_fk`) REFERENCES `post` (`pst_id`)ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--# Table FORUM_CATEGORY--------------------------------------------------------
CREATE TABLE IF NOT EXISTS `forum_category` (
    `for_category_id` INT(11) NOT NULL AUTO_INCREMENT,
    `for_category_name` VARCHAR(75) NOT NULL,

    PRIMARY KEY (`for_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--# Table FORUM_SUBCATEGORY-------------------------------------------------------
CREATE TABLE IF NOT EXISTS `forum_subcategory` (
    `for_subcategory_id` INT(11) NOT NULL AUTO_INCREMENT,
    `for_subcategory_name` VARCHAR(75) NOT NULL,

    `for_cat_fk` INT(11) NOT NULL,
    PRIMARY KEY (`for_subcategory_id`),
    KEY (`for_cat_fk`),

    CONSTRAINT `constraint_for_cat_subcat` FOREIGN KEY(`for_cat_fk`) REFERENCES `forum_category` (`for_category_id`)ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--# Table FORUM_TOPIC--------------------------------------------------------
CREATE TABLE IF NOT EXISTS `forum_topic` (
    `for_topic_id` INT(11) NOT NULL AUTO_INCREMENT,
    `for_topic_name` VARCHAR(75) NOT NULL,
    `for_topic_content` TEXT NOT NULL,
    `for_topic_date` DATETIME NOT NULL,

    `for_topic_usr_fk` INT(11) NOT NULL,
    `for_topic_subcat_fk` INT(11) NOT NULL,

    PRIMARY KEY (`for_topic_id`),
    KEY (`for_topic_usr_fk`),
    KEY (`for_topic_subcat_fk`),
  
    CONSTRAINT `constraint_for_usr` FOREIGN KEY(`for_topic_usr_fk`) REFERENCES `user` (`usr_id`)ON UPDATE CASCADE ON DELETE RESTRICT,

    CONSTRAINT `constraint_for_subcat` FOREIGN KEY(`for_topic_subcat_fk`) REFERENCES `forum_subcategory` (`for_subcategory_id`)ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--# Table FORUM_MSG-------------------------------------------------------
CREATE TABLE IF NOT EXISTS `forum_msg` (
    `for_msg_id` INT(11) NOT NULL AUTO_INCREMENT,
    `for_msg_date` DATETIME NOT NULL,
    `for_msg_content` TEXT NOT NULL,

    `for_msg_usr_fk` INT(11) NOT NULL,
    `for_msg_topic_fk` INT(11) NOT NULL,

    PRIMARY KEY (`for_msg_id`),
    KEY (`for_msg_usr_fk`),
    KEY (`for_msg_topic_fk`),

    CONSTRAINT `constraint_for_msg_usr` FOREIGN KEY(`for_msg_usr_fk`) REFERENCES `user` (`usr_id`)ON UPDATE CASCADE ON DELETE RESTRICT,

    CONSTRAINT `constraint_for_msg_topic` FOREIGN KEY(`for_msg_topic_fk`) REFERENCES `forum_topic` (`for_topic_id`)ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--# Table NOTIF-------------------------------------------------------
CREATE TABLE IF NOT EXISTS `notif` (
    `not_id` INT(11) NOT NULL AUTO_INCREMENT,
    `not_msg` TEXT NOT NULL,

    `not_usr_fk` INT(11) NOT NULL,

    PRIMARY KEY (`not_id`),
    KEY (`not_usr_fk`),

    CONSTRAINT `constraint_not_usr` FOREIGN KEY(`not_usr_fk`) REFERENCES `user` (`for_topic_id`)ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;