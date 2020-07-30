ALTER TABLE `#__spspot_spot` ADD `location` VARCHAR(255) NOT NULL DEFAULT '' AFTER `latitude`;

ALTER TABLE `#__spspot_spot` ADD `zipcode` VARCHAR(50) NOT NULL DEFAULT '' AFTER `state`;
