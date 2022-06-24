
INSERT INTO `permissions` (`id`, `name`, `parent`, `guard_name`, `created_at`, `updated_at`) VALUES (NULL, 'show_seller_products', 'multivendor', 'web', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `parent`, `guard_name`, `created_at`, `updated_at`) VALUES (NULL, 'show_seller_orders', 'multivendor', 'web', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `parent`, `guard_name`, `created_at`, `updated_at`) VALUES (NULL, 'show_sellers', 'multivendor', 'web', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `parent`, `guard_name`, `created_at`, `updated_at`) VALUES (NULL, 'show_payouts', 'multivendor', 'web', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `parent`, `guard_name`, `created_at`, `updated_at`) VALUES (NULL, 'show_payout_requests', 'multivendor', 'web', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `parent`, `guard_name`, `created_at`, `updated_at`) VALUES (NULL, 'show_commission_log', 'multivendor', 'web', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `parent`, `guard_name`, `created_at`, `updated_at`) VALUES (NULL, 'show_seller_packages', 'multivendor', 'web', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `parent`, `guard_name`, `created_at`, `updated_at`) VALUES (NULL, 'show_seller_package_payments', 'multivendor', 'web', NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `parent`, `guard_name`, `created_at`, `updated_at`) VALUES (NULL, 'show_shop_setting', 'multivendor', 'web', NULL, NULL);

ALTER TABLE `users` ADD `shop_id` INT NULL AFTER `role_id`;
ALTER TABLE `products` ADD `shop_id` INT NULL AFTER `id`;
ALTER TABLE `reviews` ADD `shop_id` INT NULL AFTER `id`;
ALTER TABLE `orders` ADD `shop_id` INT NULL AFTER `user_id`;
ALTER TABLE `orders` ADD `combined_order_id` INT NULL AFTER `shop_id`;
ALTER TABLE `orders` ADD `commission_calculated` TINYINT NOT NULL DEFAULT '0' AFTER `coupon_discount`;
ALTER TABLE `coupons` ADD `shop_id` INT NULL AFTER `id`;
ALTER TABLE `zones` CHANGE `cities` `cities` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;


CREATE TABLE `combined_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `shipping_address` longtext DEFAULT NULL,
  `billing_address` longtext DEFAULT NULL,
  `grand_total` double(20,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `commission_histories`
--

CREATE TABLE `commission_histories` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `admin_commission` double(25,2) NOT NULL,
  `seller_earning` double(25,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `seller_packages`
--

CREATE TABLE `seller_packages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` double(11,2) NOT NULL DEFAULT 0.00,
  `commission` double(15,2) NOT NULL,
  `product_upload_limit` int(11) NOT NULL DEFAULT 0,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `duration` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `seller_package_payments`
--

CREATE TABLE `seller_package_payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seller_package_id` int(11) NOT NULL,
  `amount` double(20,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_details` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `seller_package_translations`
--

CREATE TABLE `seller_package_translations` (
  `id` bigint(20) NOT NULL,
  `seller_package_id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `seller_payouts`
--

CREATE TABLE `seller_payouts` (
  `id` bigint(20) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'requested',
  `requested_amount` double(20,2) NOT NULL DEFAULT 0.00,
  `paid_amount` double(20,2) NOT NULL DEFAULT 0.00,
  `seller_note` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_details` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `txn_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `approval` tinyint(1) NOT NULL DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` int(11) DEFAULT NULL,
  `rating` double(8,2) NOT NULL DEFAULT 0.00,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `banners` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `featured_products` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `products_banners` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `banners_1` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `banners_2` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `banners_3` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `banners_4` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `seller_package_id` int(11) DEFAULT NULL,
  `product_upload_limit` int(11) NOT NULL DEFAULT 0,
  `commission` double(15,2) DEFAULT 0.00,
  `package_invalid_at` date DEFAULT NULL,
  `current_balance` double(20,2) NOT NULL DEFAULT 0.00,
  `cash_payout_status` int(1) NOT NULL DEFAULT 0,
  `bank_payout_status` int(1) NOT NULL DEFAULT 0,
  `bank_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_acc_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_acc_no` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_routing_no` int(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `shop_brands`
--

CREATE TABLE `shop_brands` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table structure for table `shop_categories`
--

CREATE TABLE `shop_categories` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `shop_followers`
--

CREATE TABLE `shop_followers` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `combined_orders`
--
ALTER TABLE `combined_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commission_histories`
--
ALTER TABLE `commission_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_packages`
--
ALTER TABLE `seller_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_package_payments`
--
ALTER TABLE `seller_package_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_package_translations`
--
ALTER TABLE `seller_package_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_payouts`
--
ALTER TABLE `seller_payouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_brands`
--
ALTER TABLE `shop_brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_categories`
--
ALTER TABLE `shop_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_followers`
--
ALTER TABLE `shop_followers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `combined_orders`
--
ALTER TABLE `combined_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `commission_histories`
--
ALTER TABLE `commission_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `seller_packages`
--
ALTER TABLE `seller_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `seller_package_payments`
--
ALTER TABLE `seller_package_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `seller_package_translations`
--
ALTER TABLE `seller_package_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `seller_payouts`
--
ALTER TABLE `seller_payouts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shop_brands`
--
ALTER TABLE `shop_brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


--
-- AUTO_INCREMENT for table `shop_categories`
--
ALTER TABLE `shop_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `shop_followers`
--
ALTER TABLE `shop_followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

UPDATE `settings` SET `value` = '1.1' WHERE `type` = 'current_version';

COMMIT;

