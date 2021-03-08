CREATE TABLE IF NOT EXISTS `#__spcampaign_campaign` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`asset_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
	`alias` CHAR(64) NOT NULL DEFAULT '',
	`deferred` TINYINT(1) NOT NULL DEFAULT 0,
	`deferreddate` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`message_email` LONGTEXT NOT NULL,
	`message_sms` VARCHAR(800) NOT NULL DEFAULT '',
	`name` VARCHAR(255) NOT NULL DEFAULT '',
	`percent` FLOAT(7) NOT NULL DEFAULT 0,
	`smsemail` TINYINT(1) NOT NULL DEFAULT 0,
    `type` VARCHAR(255) NOT NULL DEFAULT '',
	`validdate` DATE NOT NULL DEFAULT '0000-00-00',
	`valuein` VARCHAR(100) NOT NULL DEFAULT 0,
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
	`metakey` TEXT NOT NULL,
	`metadesc` TEXT NOT NULL,
	`metadata` TEXT NOT NULL,
	PRIMARY KEY  (`id`),
	KEY `idx_name` (`name`),
	KEY `idx_smsemail` (`smsemail`),
	KEY `idx_alias` (`alias`),
	KEY `idx_deferred` (`deferred`),
	KEY `idx_access` (`access`),
	KEY `idx_checkout` (`checked_out`),
	KEY `idx_createdby` (`created_by`),
	KEY `idx_modifiedby` (`modified_by`),
	KEY `idx_state` (`published`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 DEFAULT COLLATE=utf8_general_ci;



--
-- Always insure this column rules is large enough for all the access control values.
--
ALTER TABLE `#__assets` CHANGE `rules` `rules` MEDIUMTEXT NOT NULL COMMENT 'JSON encoded access control.';

--
-- Always insure this column name is large enough for long component and view names.
--
ALTER TABLE `#__assets` CHANGE `name` `name` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The unique name for the asset.';
