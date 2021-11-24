CREATE TABLE `task` (
	`id` int UNSIGNED NOT NULL AUTO_INCREMENT,
	`title` TEXT NOT NULL,
	`description` TEXT NOT NULL,
	`price` int DEFAULT NULL,
	`category_id` int UNSIGNED NOT NULL,
	`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`finish_at` datetime DEFAULT NULL,
	`status` enum('new','canceled','in_work','failed','completed') NOT NULL DEFAULT 'new',
    `budget` decimal(12,2) NOT NULL,
    `latitude` decimal(10,7) DEFAULT NULL,
    `longitude` decimal(10,7) DEFAULT NULL,
    `address` varchar(512) COLLATE utf8mb4_general_ci DEFAULT NULL,
	`city_id` int UNSIGNED DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX (`category_id`),
	INDEX (`city_id`)
);

CREATE TABLE `category` (
	`id` int UNSIGNED NOT NULL AUTO_INCREMENT,
	`title` TEXT NOT NULL,
	`code` TEXT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `user` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
    `email` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
    `password_hash` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
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
    `about` varchar(512) COLLATE utf8mb4_general_ci DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX (`city_id`),
	INDEX (`email`(128))
);

CREATE TABLE `response` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`task_id` INT UNSIGNED NOT NULL,
	`worker_id` INT UNSIGNED NOT NULL,
	`comment` TEXT NOT NULL,
	`price` INT NOT NULL,
	`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX (`task_id`),
	INDEX (`worker_id`)
);

CREATE TABLE `city` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` TEXT NOT NULL,
    `latitude` DECIMAL(10,7) DEFAULT NULL,
    `longitude` DECIMAL(10,7) DEFAULT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `message` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`task_id` INT UNSIGNED NOT NULL,
	`user_id` INT UNSIGNED NOT NULL,
	`text` TEXT NOT NULL,
	`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX (`task_id`),
	INDEX (`user_id`)
);

CREATE TABLE `review` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`task_id` INT UNSIGNED NOT NULL,
	`customer_id` INT UNSIGNED NOT NULL,
	`worker_id` INT UNSIGNED NOT NULL,
	`comment` TEXT NOT NULL,
	`rating` INT(1) DEFAULT NULL,
	`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX (`task_id`),
	INDEX (`customer_id`),
	INDEX (`worker_id`)
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
	PRIMARY KEY (`id`),
	INDEX (`task_id`)
);

CREATE TABLE `portfolio` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` INT UNSIGNED NOT NULL,
	`source` TEXT NOT NULL,
	PRIMARY KEY (`id`),
	INDEX (`user_id`)
);

ALTER TABLE `task` ADD CONSTRAINT `task_fk0` FOREIGN KEY (`category_id`) REFERENCES `category`(`id`);

ALTER TABLE `task` ADD CONSTRAINT `task_fk1` FOREIGN KEY (`city_id`) REFERENCES `city`(`id`);

ALTER TABLE `user` ADD CONSTRAINT `user_fk0` FOREIGN KEY (`city_id`) REFERENCES `city`(`id`);

ALTER TABLE `response` ADD CONSTRAINT `response_fk0` FOREIGN KEY (`task_id`) REFERENCES `task`(`id`) ON DELETE NO ACTION;

ALTER TABLE `response` ADD CONSTRAINT `response_fk1` FOREIGN KEY (`worker_id`) REFERENCES `user`(`id`);

ALTER TABLE `message` ADD CONSTRAINT `message_fk0` FOREIGN KEY (`task_id`) REFERENCES `task`(`id`) ON DELETE NO ACTION;

ALTER TABLE `message` ADD CONSTRAINT `message_fk1` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);

ALTER TABLE `review` ADD CONSTRAINT `review_fk0` FOREIGN KEY (`task_id`) REFERENCES `task`(`id`);

ALTER TABLE `review` ADD CONSTRAINT `review_fk1` FOREIGN KEY (`customer_id`) REFERENCES `user`(`id`);

ALTER TABLE `review` ADD CONSTRAINT `review_fk2` FOREIGN KEY (`worker_id`) REFERENCES `user`(`id`) ON DELETE NO ACTION;

ALTER TABLE `user_category` ADD CONSTRAINT `user_category_fk0` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`) ON DELETE NO ACTION;

ALTER TABLE `user_category` ADD CONSTRAINT `user_category_fk1` FOREIGN KEY (`category_id`) REFERENCES `category`(`id`) ON DELETE NO ACTION;

ALTER TABLE `favorite` ADD CONSTRAINT `favorite_fk0` FOREIGN KEY (`customer_id`) REFERENCES `user`(`id`) ON DELETE NO ACTION;

ALTER TABLE `favorite` ADD CONSTRAINT `favorite_fk1` FOREIGN KEY (`worker_id`) REFERENCES `user`(`id`) ON DELETE NO ACTION;

ALTER TABLE `file` ADD CONSTRAINT `file_fk0` FOREIGN KEY (`task_id`) REFERENCES `task`(`id`) ON DELETE NO ACTION;

ALTER TABLE `portfolio` ADD CONSTRAINT `portfolio_fk0` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`) ON DELETE NO ACTION;
