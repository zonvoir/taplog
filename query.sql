14-10-2020

ALTER TABLE `user_details` ADD `profile_img` VARCHAR(255) NULL DEFAULT NULL AFTER `designation`;

ALTER TABLE `user_details` ADD `first_name` VARCHAR(255) NULL DEFAULT NULL AFTER `user_id`, ADD `last_name` VARCHAR(255) NULL DEFAULT NULL AFTER `first_name`;

ALTER TABLE `children` ADD `gender` ENUM('Male','Female','Other') NOT NULL DEFAULT 'Male' AFTER `child_age`;

DROP TABLE `beat_plans`;

DROP TABLE `collections`;

ALTER TABLE `user_details` ADD `pan_no` VARCHAR(255) NULL DEFAULT NULL AFTER `adhar_doc`, ADD `pan_doc` VARCHAR(255) NULL DEFAULT NULL AFTER `pan_no`;

ALTER TABLE `user_details` ADD `beneficiary_name` VARCHAR(255) NULL DEFAULT NULL AFTER `bank_ifsc`;