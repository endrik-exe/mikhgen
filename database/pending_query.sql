
ALTER TABLE `mikhgen`.`user` 
ADD COLUMN `isActive` TINYINT NOT NULL DEFAULT 0 AFTER `roleId`;

UPDATE mikhgen.user SET isActive = 1;