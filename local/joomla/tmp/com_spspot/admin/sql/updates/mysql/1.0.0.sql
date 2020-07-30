ALTER TABLE `#__spspot_spot` ADD `country` VARCHAR(255) NULL DEFAULT '' AFTER `city`;

ALTER TABLE `#__spspot_spot` ADD `state` VARCHAR(255) NULL DEFAULT '' AFTER `spot_id`;
