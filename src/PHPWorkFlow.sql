
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- PHPWF_arc
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `PHPWF_arc`;

CREATE TABLE `PHPWF_arc`
(
    `arc_id` INTEGER NOT NULL AUTO_INCREMENT,
    `work_flow_id` INTEGER NOT NULL,
    `transition_id` INTEGER NOT NULL,
    `place_id` INTEGER NOT NULL,
    `direction` VARCHAR(255) NOT NULL,
    `arc_type` VARCHAR(32) NOT NULL,
    `description` VARCHAR(255),
    `name` VARCHAR(255) NOT NULL,
    `yasper_name` VARCHAR(255) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `created_by` INTEGER DEFAULT 0 NOT NULL,
    `modified_at` DATETIME NOT NULL,
    `modified_by` INTEGER DEFAULT 0 NOT NULL,
    PRIMARY KEY (`arc_id`),
    UNIQUE INDEX `arc_work_flow_id_transition_id_place_id_direction_i` (`work_flow_id`, `transition_id`, `place_id`, `direction`),
    UNIQUE INDEX `arc_work_flow_id_name_i` (`work_flow_id`, `name`),
    UNIQUE INDEX `arc_work_flow_id_yasper_name_i` (`work_flow_id`, `yasper_name`),
    INDEX `arc_transition_id_i` (`transition_id`),
    INDEX `arc_place_id_i` (`place_id`),
    CONSTRAINT `arc_work_flow_id_fk`
        FOREIGN KEY (`work_flow_id`)
        REFERENCES `PHPWF_work_flow` (`work_flow_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `arc_transition_id_fk`
        FOREIGN KEY (`transition_id`)
        REFERENCES `PHPWF_transition` (`transition_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `arc_place_id_fk`
        FOREIGN KEY (`place_id`)
        REFERENCES `PHPWF_place` (`place_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- PHPWF_command
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `PHPWF_command`;

CREATE TABLE `PHPWF_command`
(
    `command_id` INTEGER NOT NULL AUTO_INCREMENT,
    `transition_id` INTEGER NOT NULL,
    `command_string` VARCHAR(255) NOT NULL,
    `command_seq` INTEGER NOT NULL,
    `created_at` DATETIME NOT NULL,
    `created_by` INTEGER DEFAULT 0 NOT NULL,
    `modified_at` DATETIME NOT NULL,
    `modified_by` INTEGER DEFAULT 0 NOT NULL,
    PRIMARY KEY (`command_id`),
    INDEX `fi_mand_transition_id_fk` (`transition_id`),
    CONSTRAINT `command_transition_id_fk`
        FOREIGN KEY (`transition_id`)
        REFERENCES `PHPWF_transition` (`transition_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- PHPWF_gate
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `PHPWF_gate`;

CREATE TABLE `PHPWF_gate`
(
    `gate_id` INTEGER NOT NULL AUTO_INCREMENT,
    `transition_id` INTEGER NOT NULL,
    `target_yasper_name` VARCHAR(255) NOT NULL,
    `value` VARCHAR(255) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `created_by` INTEGER DEFAULT 0 NOT NULL,
    `modified_at` DATETIME NOT NULL,
    `modified_by` INTEGER DEFAULT 0 NOT NULL,
    PRIMARY KEY (`gate_id`),
    UNIQUE INDEX `gate_transition_id_value_target_yasper_name_i` (`transition_id`, `value`, `target_yasper_name`),
    CONSTRAINT `gate_transition_id_fk`
        FOREIGN KEY (`transition_id`)
        REFERENCES `PHPWF_transition` (`transition_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- PHPWF_notification
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `PHPWF_notification`;

CREATE TABLE `PHPWF_notification`
(
    `notification_id` INTEGER NOT NULL AUTO_INCREMENT,
    `transition_id` INTEGER NOT NULL,
    `notification_type` VARCHAR(32) NOT NULL,
    `notification_string` VARCHAR(255) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `created_by` INTEGER DEFAULT 0 NOT NULL,
    `modified_at` DATETIME NOT NULL,
    `modified_by` INTEGER DEFAULT 0 NOT NULL,
    PRIMARY KEY (`notification_id`),
    UNIQUE INDEX `notification_transition_id_notification_type_notification_string` (`transition_id`, `notification_type`, `notification_string`),
    CONSTRAINT `notification_transition_id_fk`
        FOREIGN KEY (`transition_id`)
        REFERENCES `PHPWF_transition` (`transition_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- PHPWF_place
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `PHPWF_place`;

CREATE TABLE `PHPWF_place`
(
    `place_id` INTEGER NOT NULL AUTO_INCREMENT,
    `work_flow_id` INTEGER NOT NULL,
    `place_type` VARCHAR(32) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `position_x` INTEGER DEFAULT 0 NOT NULL,
    `position_y` INTEGER DEFAULT 0 NOT NULL,
    `dimension_x` INTEGER DEFAULT 0 NOT NULL,
    `dimension_y` INTEGER DEFAULT 0 NOT NULL,
    `yasper_name` VARCHAR(255) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `created_by` INTEGER DEFAULT 0 NOT NULL,
    `modified_at` DATETIME NOT NULL,
    `modified_by` INTEGER DEFAULT 0 NOT NULL,
    PRIMARY KEY (`place_id`),
    UNIQUE INDEX `place_work_flow_id_name_i` (`work_flow_id`, `name`),
    UNIQUE INDEX `place_work_flow_id_yasper_name_i` (`work_flow_id`, `yasper_name`),
    CONSTRAINT `place_work_flow_id_fk`
        FOREIGN KEY (`work_flow_id`)
        REFERENCES `PHPWF_work_flow` (`work_flow_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- PHPWF_route
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `PHPWF_route`;

CREATE TABLE `PHPWF_route`
(
    `route_id` INTEGER NOT NULL AUTO_INCREMENT,
    `transition_id` INTEGER NOT NULL,
    `route` VARCHAR(255) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `created_by` INTEGER DEFAULT 0 NOT NULL,
    `modified_at` DATETIME NOT NULL,
    `modified_by` INTEGER DEFAULT 0 NOT NULL,
    PRIMARY KEY (`route_id`),
    UNIQUE INDEX `route_transition_id_route_i` (`transition_id`, `route`),
    CONSTRAINT `route_transition_id_fk`
        FOREIGN KEY (`transition_id`)
        REFERENCES `PHPWF_transition` (`transition_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- PHPWF_token
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `PHPWF_token`;

CREATE TABLE `PHPWF_token`
(
    `token_id` INTEGER NOT NULL AUTO_INCREMENT,
    `use_case_id` INTEGER NOT NULL,
    `place_id` INTEGER NOT NULL,
    `creating_work_item_id` INTEGER,
    `consuming_work_item_id` INTEGER,
    `token_status` VARCHAR(255) NOT NULL,
    `enabled_date` DATETIME NOT NULL,
    `cancelled_date` DATETIME,
    `consumed_date` DATETIME,
    `created_at` DATETIME NOT NULL,
    `created_by` INTEGER DEFAULT 0 NOT NULL,
    `modified_at` DATETIME NOT NULL,
    `modified_by` INTEGER DEFAULT 0 NOT NULL,
    PRIMARY KEY (`token_id`),
    INDEX `token_place_id_fk` (`place_id`),
    INDEX `fi_en_use_case_id_fk` (`use_case_id`),
    INDEX `fi_en_creating_work_item_id_fk` (`creating_work_item_id`),
    INDEX `fi_en_consuming_work_item_id_fk` (`consuming_work_item_id`),
    CONSTRAINT `token_use_case_id_fk`
        FOREIGN KEY (`use_case_id`)
        REFERENCES `PHPWF_use_case` (`use_case_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `token_creating_work_item_id_fk`
        FOREIGN KEY (`creating_work_item_id`)
        REFERENCES `PHPWF_work_item` (`work_item_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `token_consuming_work_item_id_fk`
        FOREIGN KEY (`consuming_work_item_id`)
        REFERENCES `PHPWF_work_item` (`work_item_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `token_place_id_fk`
        FOREIGN KEY (`place_id`)
        REFERENCES `PHPWF_place` (`place_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- PHPWF_transition
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `PHPWF_transition`;

CREATE TABLE `PHPWF_transition`
(
    `transition_id` INTEGER NOT NULL AUTO_INCREMENT,
    `work_flow_id` INTEGER NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `description` VARCHAR(1023) NOT NULL,
    `transition_type` VARCHAR(255) NOT NULL,
    `transition_trigger_method` VARCHAR(255) NOT NULL,
    `position_x` INTEGER DEFAULT 0 NOT NULL,
    `position_y` INTEGER DEFAULT 0 NOT NULL,
    `dimension_x` INTEGER DEFAULT 0 NOT NULL,
    `dimension_y` INTEGER DEFAULT 0 NOT NULL,
    `yasper_name` VARCHAR(255) NOT NULL,
    `time_delay` INTEGER,
    `created_at` DATETIME NOT NULL,
    `created_by` INTEGER DEFAULT 0 NOT NULL,
    `modified_at` DATETIME NOT NULL,
    `modified_by` INTEGER DEFAULT 0 NOT NULL,
    PRIMARY KEY (`transition_id`),
    UNIQUE INDEX `transition_work_flow_id_name_i` (`work_flow_id`, `name`),
    UNIQUE INDEX `transition_work_flow_id_transition_trigger_method_i` (`work_flow_id`, `transition_trigger_method`),
    UNIQUE INDEX `transition_work_flow_id_yasper_name_i` (`work_flow_id`, `yasper_name`),
    CONSTRAINT `transition_work_flow_id_fk`
        FOREIGN KEY (`work_flow_id`)
        REFERENCES `PHPWF_work_flow` (`work_flow_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- PHPWF_trigger_fulfillment
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `PHPWF_trigger_fulfillment`;

CREATE TABLE `PHPWF_trigger_fulfillment`
(
    `trigger_fulfillment_id` INTEGER NOT NULL AUTO_INCREMENT,
    `use_case_id` INTEGER NOT NULL,
    `transition_id` INTEGER NOT NULL,
    `trigger_fulfillment_status` VARCHAR(32) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `created_by` INTEGER DEFAULT 0 NOT NULL,
    `modified_at` DATETIME NOT NULL,
    `modified_by` INTEGER DEFAULT 0 NOT NULL,
    PRIMARY KEY (`trigger_fulfillment_id`),
    INDEX `fi_gger_fulfillment_use_case_id_fk` (`use_case_id`),
    INDEX `fi_gger_fulfillment_transition_id_fk` (`transition_id`),
    CONSTRAINT `trigger_fulfillment_use_case_id_fk`
        FOREIGN KEY (`use_case_id`)
        REFERENCES `PHPWF_use_case` (`use_case_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `trigger_fulfillment_transition_id_fk`
        FOREIGN KEY (`transition_id`)
        REFERENCES `PHPWF_transition` (`transition_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- PHPWF_use_case
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `PHPWF_use_case`;

CREATE TABLE `PHPWF_use_case`
(
    `use_case_id` INTEGER NOT NULL AUTO_INCREMENT,
    `work_flow_id` INTEGER NOT NULL,
    `parent_use_case_id` INTEGER,
    `name` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255),
    `use_case_group` VARCHAR(255),
    `use_case_status` VARCHAR(255) NOT NULL,
    `start_date` DATETIME NOT NULL,
    `end_date` DATETIME NOT NULL,
    `created_at` DATETIME NOT NULL,
    `created_by` INTEGER DEFAULT 0 NOT NULL,
    `modified_at` DATETIME NOT NULL,
    `modified_by` INTEGER DEFAULT 0 NOT NULL,
    PRIMARY KEY (`use_case_id`),
    INDEX `use_case_work_flow_id_fk` (`work_flow_id`),
    INDEX `use_case_use_case_status_in` (`use_case_status`),
    INDEX `PHPWF_use_case_fi_580bf5` (`parent_use_case_id`),
    CONSTRAINT `PHPWF_use_case_fk_580bf5`
        FOREIGN KEY (`parent_use_case_id`)
        REFERENCES `PHPWF_use_case` (`use_case_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `use_case_work_flow_id_fk`
        FOREIGN KEY (`work_flow_id`)
        REFERENCES `PHPWF_work_flow` (`work_flow_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- PHPWF_use_case_context
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `PHPWF_use_case_context`;

CREATE TABLE `PHPWF_use_case_context`
(
    `use_case_context_id` INTEGER NOT NULL AUTO_INCREMENT,
    `use_case_id` INTEGER NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255),
    `value` VARCHAR(255),
    `created_at` DATETIME NOT NULL,
    `created_by` INTEGER DEFAULT 0 NOT NULL,
    `modified_at` DATETIME NOT NULL,
    `modified_by` INTEGER DEFAULT 0 NOT NULL,
    PRIMARY KEY (`use_case_context_id`),
    UNIQUE INDEX `use_case_context_use_case_id_name_i` (`use_case_id`, `name`),
    INDEX `use_case_context_use_case_id_fk` (`use_case_id`),
    CONSTRAINT `use_case_context_use_case_id_fk`
        FOREIGN KEY (`use_case_id`)
        REFERENCES `PHPWF_use_case` (`use_case_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- PHPWF_work_flow
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `PHPWF_work_flow`;

CREATE TABLE `PHPWF_work_flow`
(
    `work_flow_id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `trigger_class` TEXT NOT NULL,
    `created_at` DATETIME NOT NULL,
    `created_by` INTEGER DEFAULT 0 NOT NULL,
    `modified_at` DATETIME NOT NULL,
    `modified_by` INTEGER DEFAULT 0 NOT NULL,
    PRIMARY KEY (`work_flow_id`),
    UNIQUE INDEX `work_flow_on_name_i` (`name`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- PHPWF_work_item
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `PHPWF_work_item`;

CREATE TABLE `PHPWF_work_item`
(
    `work_item_id` INTEGER NOT NULL AUTO_INCREMENT,
    `use_case_id` INTEGER NOT NULL,
    `transition_id` INTEGER NOT NULL,
    `work_item_status` VARCHAR(255) NOT NULL,
    `enabled_date` DATETIME NOT NULL,
    `cancelled_date` DATETIME,
    `finished_date` DATETIME,
    `created_at` DATETIME NOT NULL,
    `created_by` INTEGER DEFAULT 0 NOT NULL,
    `modified_at` DATETIME NOT NULL,
    `modified_by` INTEGER DEFAULT 0 NOT NULL,
    PRIMARY KEY (`work_item_id`),
    INDEX `work_item_transition_id_fk` (`transition_id`),
    INDEX `fi_k_item_use_case_id_fk` (`use_case_id`),
    CONSTRAINT `work_item_use_case_id_fk`
        FOREIGN KEY (`use_case_id`)
        REFERENCES `PHPWF_use_case` (`use_case_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `work_item_transition_id_fk`
        FOREIGN KEY (`transition_id`)
        REFERENCES `PHPWF_transition` (`transition_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `work_item_arc_transition_id_fk`
        FOREIGN KEY (`transition_id`)
        REFERENCES `PHPWF_arc` (`transition_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
