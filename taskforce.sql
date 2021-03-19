CREATE TABLE `task` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` TEXT NOT NULL,
  `description` TEXT NOT NULL,
  `price` int DEFAULT NULL,
  `category_id` int UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `finish_at` datetime DEFAULT NULL,
  `status` enum('new','canceled','in_work','performed','failed','completed') NOT NULL DEFAULT 'new',
  `latitude` decimal(8,6) DEFAULT NULL,
  `longitude` DECIMAL(9,6) DEFAULT NULL,
  `city_id` int UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `category` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` TEXT NOT NULL,
  `code` TEXT NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `user` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` TEXT NOT NULL,
	`email` TEXT NOT NULL,
	`password_hash` text NOT NULL,
	`register_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`city_id` INT UNSIGNED NOT NULL,
	`avatar` TEXT DEFAULT NULL,
	`role` enum('customer','worker') NOT NULL DEFAULT 'customer',
	`birthday` DATETIME NOT NULL,
	`phone` TEXT DEFAULT NULL,
	`skype` TEXT DEFAULT NULL,
	`telegram` TEXT DEFAULT NULL,
	`is_show_profile` tinyint NOT NULL DEFAULT '0',
    `is_show_contacts` tinyint NOT NULL DEFAULT '0',
    `is_notify_about_message` tinyint NOT NULL DEFAULT '0',
    `is_notify_about_action` tinyint NOT NULL DEFAULT '0',
    `is_notify_about_review` tinyint NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
);

CREATE TABLE `response` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`task_id` INT UNSIGNED NOT NULL,
	`worker_id` INT UNSIGNED NOT NULL,
	`comment` TEXT NOT NULL,
	`price` INT NOT NULL,
	`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
);

CREATE TABLE `city` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` TEXT NOT NULL,
	`latitude` DECIMAL(8,6) DEFAULT NULL,
	`longitude` DECIMAL(9,6) DEFAULT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `message` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`task_id` INT UNSIGNED NOT NULL,
	`user_id` INT UNSIGNED NOT NULL,
	`text` TEXT NOT NULL,
	`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
);

CREATE TABLE `review` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`task_id` INT UNSIGNED NOT NULL,
	`customer_id` INT UNSIGNED NOT NULL,
	`worker_id` INT UNSIGNED NOT NULL,
	`comment` TEXT NOT NULL,
	`rating` INT(1) DEFAULT NULL,
	`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
);

CREATE TABLE `user_category` (
	`user_id` INT UNSIGNED NOT NULL,
	`category_id` INT UNSIGNED NOT NULL,
	PRIMARY KEY (`user_id`,`category_id`)
);

CREATE TABLE `favorite` (
	`customer_id` INT UNSIGNED NOT NULL,
	`worker_id` INT UNSIGNED NOT NULL,
	PRIMARY KEY (`customer_id`,`worker_id`)
);

CREATE TABLE `file` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`task_id` INT UNSIGNED NOT NULL,
	`name` TEXT NOT NULL,
	`source` TEXT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `portfolio` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` INT UNSIGNED NOT NULL,
	`source` TEXT NOT NULL,
	PRIMARY KEY (`id`)
);
