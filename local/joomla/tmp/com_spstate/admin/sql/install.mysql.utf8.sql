CREATE TABLE IF NOT EXISTS `#__spstate_state` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`asset_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
	`alias` CHAR(64) NOT NULL DEFAULT '',
	`country_id` VARCHAR(50) NOT NULL DEFAULT '',
	`name` VARCHAR(255) NOT NULL DEFAULT '',
	`state_code` VARCHAR(10) NOT NULL DEFAULT '',
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
	KEY `idx_country_id` (`country_id`),
	KEY `idx_name` (`name`),
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

INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (1, 0, 'andalucia', 'ES', 'Andalucía', '01', '', 1, 42, 0, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 1, 0, 1, 1);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (2, 0, 'aragon', 'ES', 'Aragon', '02', '', 1, 0, 0, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 1, 0, 0, 0);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (3, 0, 'pdo. asturas', 'ES', 'Pdo. Asturas', '03', '', 1, 0, 0, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 1, 0, 0, 0);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (4, 0, 'illes balears', 'ES', 'Illes Balears', '04', '', 1, 0, 0, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 1, 0, 0, 0);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (5, 0, 'canarias', 'ES', 'Canarias', '05', '', 1, 0, 0, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 1, 0, 0, 0);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (6, 0, 'cantabria', 'ES', 'Cantabria', '06', '', 1, 0, 0, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 1, 0, 0, 0);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (7, 0, 'castilla la mancha', 'ES', 'Castilla La Mancha', '07', '', 1, 0, 0, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 1, 0, 0, 0);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (8, 0, 'castilla y leon', 'ES', 'Castilla Y Leon', '08', '', 1, 0, 0, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 1, 0, 0, 0);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (9, 0, 'cataluña', 'ES', 'Cataluña', '09', '', 1, 0, 0, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 1, 0, 0, 0);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (10, 0, 'extremadura', 'ES', 'Extremadura', '10', '', 1, 0, 0, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 1, 0, 0, 0);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (11, 0, 'galicia', 'ES', 'Galicia', '11', '', 1, 0, 0, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 1, 0, 0, 0);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (12, 0, 'madrid', 'ES', 'Madrid', '12', '', 1, 0, 0, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 1, 0, 0, 0);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (13, 0, 'murcia', 'ES', 'Murcia', '13', '', 1, 0, 0, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 1, 0, 0, 0);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (14, 0, 'navarra', 'ES', 'Navarra', '14', '', 1, 0, 0, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 1, 0, 0, 0);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (15, 0, 'pais vasco', 'ES', 'Pais Vasco', '15', '', 1, 0, 0, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 1, 0, 0, 0);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (16, 0, 'la rioja', 'ES', 'La Rioja', '16', '', 1, 0, 0, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 1, 0, 0, 0);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (17, 0, 'valencia', 'ES', 'Valencia', '17', '', 1, 0, 0, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 1, 0, 0, 0);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (18, 0, 'ceuta', 'ES', 'Ceuta', '18', '', 1, 0, 0, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 1, 0, 0, 0);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (19, 0, 'melilla', 'ES', 'Melilla', '19', '', 1, 0, 0, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 1, 0, 0, 0);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (20, 1409, 'capital-region', 'DK', 'Region Hovedstaden (Capital Region)', '84', '', 1, 42, 42, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 3, 0, 1, 2);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (21, 1410, 'zealand-region', 'DK', 'Region Sjælland (Region Zealand)', '85', '', 1, 42, 42, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 3, 0, 1, 3);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (22, 1411, 'south-region', 'DK', 'Region Syddanmark (South Region)', '83', '', 1, 42, 42, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 3, 0, 1, 4);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (23, 1412, 'central-region', 'DK', 'Region Midtjylland (Cental Region)', '82', '', 1, 42, 42, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 3, 0, 1, 5);
INSERT INTO jos_spstate_state(id, asset_id, alias, country_id, name, state_code, params, published, created_by, modified_by, created, modified, checked_out, checked_out_time, version, hits, access, ordering) VALUES (24, 1413, 'north-region', 'DK', 'Region Nordjylland (North Region)', '81', '', 1, 42, 42, '2020-08-02 22:34:04', '2020-08-02 22:34:04', 0, '2020-08-02 22:34:04', 3, 0, 1, 6);