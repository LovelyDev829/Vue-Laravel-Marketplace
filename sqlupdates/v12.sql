INSERT INTO `permissions` (`id`, `name`, `parent`, `guard_name`, `created_at`, `updated_at`)
  VALUES
  (NULL, 'show_refund_requests', 'refund', 'web', NULL, NULL),
  (NULL, 'show_refund_settings', 'refund', 'web', NULL, NULL);

ALTER TABLE `languages` ADD `status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `rtl`;
ALTER TABLE `shops` ADD `min_order` DOUBLE(20,2) NOT NULL DEFAULT '0.00' AFTER `logo`;


ALTER TABLE `wallets`
  ADD `type` VARCHAR(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Added' COMMENT 'Added/Deducted' AFTER `payment_details`,
  ADD `details` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL AFTER `type`;

ALTER TABLE `commission_histories`
  ADD `type` VARCHAR(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Added' COMMENT 'Added/Deducted' AFTER `seller_earning`,
  ADD `details` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL AFTER `type`;

ALTER TABLE `commission_histories` CHANGE `order_id` `order_id` INT(11) NULL;

ALTER TABLE `commission_histories` 
  CHANGE `admin_commission` `admin_commission` DOUBLE(20,2) NOT NULL DEFAULT 0.00,
  CHANGE `seller_earning` `seller_earning` DOUBLE(20,2) NOT NULL DEFAULT 0.00;


ALTER TABLE `orders` 
  ADD `admin_commission` double(20,2) NOT NULL DEFAULT 0.00 AFTER `grand_total`,
  ADD `seller_earning` double(20,2) NOT NULL DEFAULT 0.00 AFTER `admin_commission`,
  ADD `commission_percentage` double(20,2) DEFAULT 0.00 AFTER `seller_earning`,
  ADD `refund_status` VARCHAR(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'null, fully_refunded, partially_refunded' AFTER `commission_calculated`,
  ADD `refund_amount` double(20,2) DEFAULT 0.00 AFTER `refund_status`;
  
ALTER TABLE `orders` ADD `courier_name` VARCHAR(255) NULL DEFAULT NULL AFTER `refund_amount`;
ALTER TABLE `orders` ADD `tracking_number` VARCHAR(255) NULL DEFAULT NULL AFTER `courier_name`;
ALTER TABLE `orders` ADD `tracking_url` TEXT NULL DEFAULT NULL AFTER `tracking_number`;




INSERT INTO `settings` (`id`, `type`, `value`, `created_at`, `updated_at`, `deleted_at`) 
VALUES 
(NULL, 'refund_request_time_period', '30', current_timestamp(), current_timestamp(), NULL),
(NULL, 'refund_request_order_status', '[\"delivered\"]', current_timestamp(), current_timestamp(), NULL),
(NULL, 'refund_reason_types', '[\"Ordered the wrong product\",\"The merchant shipped the wrong product\",\"The product is damaged or defective\",\"The product arrived too late\",\"The product do not match the description\"]', current_timestamp(), current_timestamp(), NULL);


--
-- Table structure for table `order_updates`
--

CREATE TABLE `order_updates` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `order_updates`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `order_updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;


--
-- Table structure for table `refund_requests`
--

CREATE TABLE `refund_requests` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `admin_approval` int(1) NOT NULL DEFAULT 0 COMMENT '0= Pending,\r\n1= Accepted,\r\n2= Rejected',
  `seller_approval` int(1) NOT NULL DEFAULT 0 COMMENT '0= Pending,\r\n1= Accepted,\r\n2= Rejected',
  `amount` double(20,2) NOT NULL DEFAULT 0.00 ,
  `reasons` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `refund_note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `attachments` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `refund_requests`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `refund_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Table structure for table `refund_request_items`
--

CREATE TABLE `refund_request_items` (
  `id` int(11) NOT NULL,
  `refund_request_id` int(11) NOT NULL,
  `order_detail_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `refund_request_items`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `refund_request_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

UPDATE `settings` SET `value` = '1.2' WHERE `type` = 'current_version';

COMMIT;

