<?php


// Create new table
CREATE TABLE `test.db`.`table1` ( `Id` INT(11) NOT NULL AUTO_INCREMENT , `name` VARCHAR(100) NOT NULL , PRIMARY KEY (`Id`)) ENGINE = InnoDB;


// add field in existing table
ALTER TABLE `table1` ADD `address` TEXT NOT NULL AFTER `name`, ADD `age` INT(11) NOT NULL AFTER `address`;


// Modify existing field
ALTER TABLE `table1` CHANGE `name` `firstName` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

// Delete a field
ALTER TABLE `table1` DROP `gender`;

// Delete table
DROP TABLE ` table1 `;



?>
