CREATE TABLE IF NOT EXISTS `#__spcustomer_customer` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`asset_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
	`alias` CHAR(64) NOT NULL DEFAULT '',
	`communication` TINYINT(1) NOT NULL DEFAULT 0,
	`dateofbirth` DATE NOT NULL DEFAULT '0000-00-00',
	`email` VARCHAR(255) NOT NULL DEFAULT '',
	`firstname` VARCHAR(100) NOT NULL DEFAULT '',
	`lastname` VARCHAR(100) NOT NULL DEFAULT '',
	`membership` TINYINT(1) NOT NULL DEFAULT 0,
	`mobile_phone` VARCHAR(64) NOT NULL DEFAULT '',
	`sex` TINYINT(1) NOT NULL DEFAULT 0,
	`spot` VARCHAR(50) NOT NULL DEFAULT '',
	`username` VARCHAR(100) NOT NULL DEFAULT '',
	`zipcode` VARCHAR(50) NOT NULL DEFAULT '',
	`params` text NOT NULL,
	`published` TINYINT(3) NOT NULL DEFAULT 1,
	`created_by` INT(10) unsigned NOT NULL DEFAULT 0,
	`modified_by` INT(10) unsigned NOT NULL DEFAULT 0,
	`created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`modified` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`checked_out` int(11) unsigned NOT NULL DEFAULT 0,
	`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`version` INT(10) unsigned NOT NULL DEFAULT 1,
	`hits` INT(10) unsigned NOT NULL DEFAULT 0,
	`access` INT(10) unsigned NOT NULL DEFAULT 0,
	`ordering` INT(11) NOT NULL DEFAULT 0,
	PRIMARY KEY  (`id`),
	UNIQUE KEY `idx_username` (`username`),
	KEY `idx_spot` (`spot`),
	KEY `idx_sex` (`sex`),
	KEY `idx_membership` (`membership`),
	KEY `idx_communication` (`communication`),
	KEY `idx_alias` (`alias`),
	KEY `idx_access` (`access`),
	KEY `idx_checkout` (`checked_out`),
	KEY `idx_createdby` (`created_by`),
	KEY `idx_modifiedby` (`modified_by`),
	KEY `idx_state` (`published`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;



--
-- Always insure this column rules is large enough for all the access control values.
--
ALTER TABLE `#__assets` CHANGE `rules` `rules` MEDIUMTEXT NOT NULL COMMENT 'JSON encoded access control.';

--
-- Always insure this column name is large enough for long component and view names.
--
ALTER TABLE `#__assets` CHANGE `name` `name` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The unique name for the asset.';
