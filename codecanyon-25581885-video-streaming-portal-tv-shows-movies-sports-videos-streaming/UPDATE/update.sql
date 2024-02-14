ALTER TABLE `settings` ADD `gdpr_cookie_on_off` INT(1) NOT NULL DEFAULT '1' AFTER `smtp_encryption`;

ALTER TABLE `settings` ADD `recaptcha_site_key` VARCHAR(255) NULL DEFAULT NULL AFTER `menu_livetv`, ADD `recaptcha_secret_key` VARCHAR(255) NULL DEFAULT NULL AFTER `recaptcha_site_key`;

ALTER TABLE `settings` ADD `recaptcha_on_login` INT(1) NOT NULL DEFAULT '0' AFTER `recaptcha_secret_key`, ADD `recaptcha_on_signup` INT(1) NOT NULL DEFAULT '0' AFTER `recaptcha_on_login`, ADD `recaptcha_on_forgot_pass` INT(1) NOT NULL DEFAULT '0' AFTER `recaptcha_on_signup`;

ALTER TABLE `settings` ADD `recaptcha_on_contact_us` INT(1) NOT NULL DEFAULT '0' AFTER `recaptcha_on_forgot_pass`;

ALTER TABLE `coupons` CHANGE `coupon_plan_id` `coupon_percentage` INT(11) NOT NULL;

ALTER TABLE `transaction` ADD `coupon_code` VARCHAR(255) NULL DEFAULT NULL AFTER `payment_id`;
ALTER TABLE `transaction` ADD `coupon_percentage` INT(255) NULL DEFAULT NULL AFTER `coupon_code`;

ALTER TABLE `actor_director` ADD `ad_bio` TEXT NULL DEFAULT NULL AFTER `ad_name`, ADD `ad_birthdate` INT(11) NULL DEFAULT NULL AFTER `ad_bio`, ADD `ad_place_of_birth` VARCHAR(255) NULL DEFAULT NULL AFTER `ad_birthdate`;

ALTER TABLE `actor_director` ADD `ad_tmdb_id` VARCHAR(255) NULL DEFAULT NULL AFTER `ad_place_of_birth`;

ALTER TABLE `settings` ADD `tmdb_api_key` VARCHAR(500) NULL DEFAULT NULL AFTER `recaptcha_on_contact_us`;

ALTER TABLE `subscription_plan` ADD `plan_device_limit` INT(3) NOT NULL DEFAULT '1' AFTER `plan_price`, ADD `ads_on_off` INT(1) NOT NULL DEFAULT '0' AFTER `plan_device_limit`;

ALTER TABLE `payment_gateway` ADD `gateway_short_info` VARCHAR(500) NULL DEFAULT NULL AFTER `gateway_name`;

ALTER TABLE `settings` ADD `maintenance_title` VARCHAR(500) NULL DEFAULT NULL AFTER `tmdb_api_key`, ADD `maintenance_description` TEXT NULL DEFAULT NULL AFTER `maintenance_title`, ADD `maintenance_mode` VARCHAR(255) NOT NULL DEFAULT 'up' AFTER `maintenance_description`; 

ALTER TABLE `settings` ADD `maintenance_secret` VARCHAR(500) NOT NULL DEFAULT 'viaviweb' AFTER `maintenance_mode`;


UPDATE `settings_player` SET `player_style` = 'classic_skin_dark' WHERE `settings_player`.`id` = 1;

UPDATE `settings_player` SET `autoplay` = 'no' WHERE `settings_player`.`id` = 1;

UPDATE `settings_player` SET `player_watermark` = 'no' WHERE `settings_player`.`id` = 1;

UPDATE `settings_player` SET `player_logo_position` = 'topRight' WHERE `settings_player`.`id` = 1;

UPDATE `settings_player` SET `rewind_forward` = 'yes' WHERE `settings_player`.`id` = 1;

ALTER TABLE `settings_player`
  DROP `ad_offset`,
  DROP `ad_skip`,
  DROP `ad_web_url`,
  DROP `ad_video_type`,
  DROP `ad_video_url`;

ALTER TABLE `settings_player` ADD `vast_type` VARCHAR(255) NOT NULL DEFAULT 'Local' AFTER `player_ad_on_off`, ADD `vast_url` VARCHAR(500) NULL DEFAULT NULL AFTER `vast_type`;  

ALTER TABLE `settings_player` ADD `player_default_ads` VARCHAR(255) NOT NULL DEFAULT 'Custom' AFTER `player_ad_on_off`;

ALTER TABLE `settings_player` ADD `custom_ad1_source` VARCHAR(255) NULL DEFAULT NULL AFTER `vast_url`, ADD `custom_ad1_timestart` VARCHAR(255) NULL DEFAULT NULL AFTER `custom_ad1_source`, ADD `custom_ad1_link` VARCHAR(255) NULL DEFAULT NULL AFTER `custom_ad1_timestart`;

ALTER TABLE `settings_player` ADD `custom_ad2_source` VARCHAR(255) NULL DEFAULT NULL AFTER `custom_ad1_link`, ADD `custom_ad2_timestart` VARCHAR(255) NULL DEFAULT NULL AFTER `custom_ad2_source`, ADD `custom_ad2_link` VARCHAR(255) NULL DEFAULT NULL AFTER `custom_ad2_timestart`;

ALTER TABLE `settings_player` ADD `custom_ad3_source` VARCHAR(255) NULL DEFAULT NULL AFTER `custom_ad2_link`, ADD `custom_ad3_timestart` VARCHAR(255) NULL DEFAULT NULL AFTER `custom_ad3_source`, ADD `custom_ad3_link` VARCHAR(255) NULL DEFAULT NULL AFTER `custom_ad3_timestart`;

ALTER TABLE `settings_player` ADD `player_vector_icons` VARCHAR(255) NOT NULL DEFAULT 'no' AFTER `player_style`;


INSERT INTO `payment_gateway` (`id`, `gateway_name`, `gateway_short_info`, `gateway_info`, `status`) VALUES (NULL, 'Coingate', NULL, NULL, '0');

INSERT INTO `payment_gateway` (`id`, `gateway_name`, `gateway_short_info`, `gateway_info`, `status`) VALUES (NULL, 'Bank Transfer', 'Bank Transfer', NULL, '0');


UPDATE `channels_list` SET `channel_url_type` = 'HLS' WHERE `channels_list`.`channel_url_type` = 'hls';

UPDATE `channels_list` SET `channel_url_type` = 'Embed' WHERE `channels_list`.`channel_url_type` = 'embed';

ALTER TABLE `users` ADD `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `updated_at`;


CREATE TABLE `users_device_history` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_device_name` varchar(255) NOT NULL,
  `user_session_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
CREATE TABLE `web_banner_ads` (
  `id` int(11) NOT NULL,
  `home_top` text DEFAULT NULL,
  `home_bottom` text DEFAULT NULL,
  `list_top` text DEFAULT NULL,
  `list_bottom` text DEFAULT NULL,
  `details_top` text DEFAULT NULL,
  `details_bottom` text DEFAULT NULL,
  `other_page_top` text DEFAULT NULL,
  `other_page_bottom` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `web_banner_ads` (`id`, `home_top`, `home_bottom`, `list_top`, `list_bottom`, `details_top`, `details_bottom`, `other_page_top`, `other_page_bottom`) VALUES
(1, '<img src=\\\"https://placehold.co/728x90/F45D4F/FFF?text=Banner Ad\\\" alt=\\\"banner_ads\\\" title=\\\"Banner Ads\\\">', '<img src=\\\"https://placehold.co/728x90/F45D4F/FFF?text=Banner Ad\\\" alt=\\\"banner_ads\\\" title=\\\"Banner Ads\\\">', '<img src=\\\"https://placehold.co/728x90/F45D4F/FFF?text=Banner Ad\\\" alt=\\\"banner_ads\\\" title=\\\"Banner Ads\\\">', '<img src=\\\"https://placehold.co/728x90/F45D4F/FFF?text=Banner Ad\\\" alt=\\\"banner_ads\\\" title=\\\"Banner Ads\\\">', '', '<img src=\\\"https://placehold.co/728x90/F45D4F/FFF?text=Banner Ad\\\" alt=\\\"banner_ads\\\" title=\\\"Banner Ads\\\">', '<img src=\\\"https://placehold.co/728x90/F45D4F/FFF?text=Banner Ad\\\" alt=\\\"banner_ads\\\" title=\\\"Banner Ads\\\">', '<img src=\\\"https://placehold.co/728x90/F45D4F/FFF?text=Banner Ad\\\" alt=\\\"banner_ads\\\" title=\\\"Banner Ads\\\">');

 
ALTER TABLE `users_device_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`user_id`);
 
ALTER TABLE `web_banner_ads`
  ADD PRIMARY KEY (`id`);
 
ALTER TABLE `users_device_history`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
 
ALTER TABLE `web_banner_ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;