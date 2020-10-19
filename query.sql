14-10-2020

ALTER TABLE `user_details` ADD `profile_img` VARCHAR(255) NULL DEFAULT NULL AFTER `designation`;

ALTER TABLE `user_details` ADD `first_name` VARCHAR(255) NULL DEFAULT NULL AFTER `user_id`, ADD `last_name` VARCHAR(255) NULL DEFAULT NULL AFTER `first_name`;

ALTER TABLE `children` ADD `gender` ENUM('Male','Female','Other') NOT NULL DEFAULT 'Male' AFTER `child_age`;

DROP TABLE `beat_plans`;

DROP TABLE `collections`;

ALTER TABLE `user_details` ADD `pan_no` VARCHAR(255) NULL DEFAULT NULL AFTER `adhar_doc`, ADD `pan_doc` VARCHAR(255) NULL DEFAULT NULL AFTER `pan_no`;

ALTER TABLE `user_details` ADD `beneficiary_name` VARCHAR(255) NULL DEFAULT NULL AFTER `bank_ifsc`;

ALTER TABLE `user_details` CHANGE `bank_name` `bank_name` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

ALTER TABLE `user_details` CHANGE `mother_name` `mother_name` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `emergency_contact_person_name` `emergency_contact_person_name` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `emergency_contact` `emergency_contact` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `bank_account_no` `bank_account_no` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `bank_ifsc` `bank_ifsc` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

ALTER TABLE `vendor_kyc` DROP `mobile_no`, DROP `email_id`;

ALTER TABLE `vendor_kyc` DROP `pincode`;

ALTER TABLE `vendor_kyc` ADD `adhar_doc` VARCHAR(255) NULL DEFAULT NULL AFTER `pan_no`, ADD `pan_doc` VARCHAR(255) NULL DEFAULT NULL AFTER `adhar_doc`