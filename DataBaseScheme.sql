CREATE TABLE `client` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `full_name` varchar(255),
  `password` varchar(255),
  `created_at` timestamp,
  `about` varchar(255),
  `age` date
);

CREATE TABLE `worker` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `full_name` varchar(255),
  `password` varchar(255),
  `created_at` timestamp,
  `about` varchar(255),
  `age` date
);

CREATE TABLE `task` (
  `taskId` int,
  `clientId` int,
  `workerId` int,
  `name` char,
  `cathegory` char,
  `created_at` timestamp,
  `description` varchar(255),
  `price` int,
  `term` data
);

CREATE TABLE `adressC` (
  `clientId` int PRIMARY KEY,
  `country` char,
  `city` char,
  `street` varchar(255),
  `home` varchar(255),
  `coordinatesLatitude` int,
  `coordinatesLongitude` int
);

CREATE TABLE `contactsC` (
  `clientId` int,
  `facebook` char,
  `email` char,
  `number` int
);

CREATE TABLE `adressW` (
  `workerId` int PRIMARY KEY,
  `country` char,
  `city` char,
  `street` varchar(255),
  `home` varchar(255),
  `coordinatesLatitude` int,
  `coordinatesLongitude` int
);

CREATE TABLE `contactsW` (
  `workerId` int,
  `facebook` char,
  `email` char,
  `number` int
);

CREATE TABLE `evaluations` (
  `workerId` int,
  `rate` decimal,
  `completeTask` int,
  `failedTask` int
);

CREATE TABLE `adressT` (
  `taskId` int PRIMARY KEY,
  `country` char,
  `city` char,
  `street` varchar(255),
  `home` varchar(255),
  `coordinatesLatitude` int,
  `coordinatesLongitude` int
);

CREATE TABLE `comment` (
  `taskId` int,
  `comment` varchar(255),
  `time` timestamp,
  `price` int,
  `workerId` int
);

CREATE TABLE `include` (
  `taskId` int,
  `attachment` varchar(255)
);

CREATE TABLE `cityTable` (
  `city` int
);

ALTER TABLE `task` ADD FOREIGN KEY (`clientId`) REFERENCES `client` (`id`);

ALTER TABLE `adressC` ADD FOREIGN KEY (`clientId`) REFERENCES `client` (`id`);

ALTER TABLE `adressC` ADD FOREIGN KEY (`city`) REFERENCES `cityTable` (`city`);

ALTER TABLE `client` ADD FOREIGN KEY (`id`) REFERENCES `contactsC` (`clientId`);

ALTER TABLE `adressW` ADD FOREIGN KEY (`workerId`) REFERENCES `worker` (`id`);

ALTER TABLE `adressW` ADD FOREIGN KEY (`city`) REFERENCES `cityTable` (`city`);

ALTER TABLE `worker` ADD FOREIGN KEY (`id`) REFERENCES `contactsW` (`workerId`);

ALTER TABLE `worker` ADD FOREIGN KEY (`id`) REFERENCES `evaluations` (`workerId`);

ALTER TABLE `adressT` ADD FOREIGN KEY (`taskId`) REFERENCES `task` (`taskId`);

ALTER TABLE `adressT` ADD FOREIGN KEY (`city`) REFERENCES `cityTable` (`city`);

ALTER TABLE `comment` ADD FOREIGN KEY (`workerId`) REFERENCES `worker` (`id`);

ALTER TABLE `comment` ADD FOREIGN KEY (`taskId`) REFERENCES `task` (`taskId`);

ALTER TABLE `include` ADD FOREIGN KEY (`taskId`) REFERENCES `task` (`taskId`);
