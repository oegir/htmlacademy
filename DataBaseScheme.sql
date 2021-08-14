CREATE TABLE `user` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `fullName` varchar(255),
  `password` varchar(255),
  `createdAt` timestamp,
  `about` varchar(255),
  `age` date,
  `city` char,
  `street` varchar(255),
  `home` varchar(255),
  `coordinatesLatitude` int,
  `coordinatesLongitude` int,
  `facebook` char,
  `email` char,
  `number` int,
  `cathegory` varchar(255)
);

CREATE TABLE `task` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `clientId` int,
  `workerId` int,
  `title` char,
  `cathegory` char,
  `createdAt` timestamp,
  `description` varchar(255),
  `price` int,
  `term` date
);

CREATE TABLE `evaluations` (
  `id` int PRIMARY KEY,
  `rate` decimal,
  `isTaskComplete` int,
  `failedTask` int,
  `comment` varchar(255)
);

CREATE TABLE `comment` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `comment` varchar(255),
  `time` timestamp,
  `price` int,
  `userId` int
);

CREATE TABLE `include` (
  `id` int PRIMARY KEY,
  `attachment` MEDIUMBLOB
);

CREATE TABLE `cityTable` (
  `city` varchar(255) PRIMARY KEY,
  `coordinatesLatitude` int,
  `coordinatesLongitude` int
);

CREATE TABLE `cathegory` (
  `id` int PRIMARY KEY,
  `cathegories` varchar(255)
);

ALTER TABLE `task` ADD FOREIGN KEY (`clientId`) REFERENCES `user` (`id`);

ALTER TABLE `user` ADD FOREIGN KEY (`id`) REFERENCES `evaluations` (`id`);

ALTER TABLE `comment` ADD FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

ALTER TABLE `comment` ADD FOREIGN KEY (`id`) REFERENCES `task` (`id`);

ALTER TABLE `include` ADD FOREIGN KEY (`id`) REFERENCES `task` (`id`);

ALTER TABLE `cathegory` ADD FOREIGN KEY (`id`) REFERENCES `task` (`cathegory`);

ALTER TABLE `cathegory` ADD FOREIGN KEY (`id`) REFERENCES `user` (`cathegory`);
