CREATE TABLE `user` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `fullName` varchar(255),
  `password` varchar(255),
  `createdAt` timestamp,
  `about` varchar(255),
  `age` date,
  `cityId` int,
  `street` varchar(255),
  `home` varchar(255),
  `facebook` char,
  `email` char,
  `number` int,
  `cathegoryId` varchar(255)
);

CREATE TABLE `task` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `clientId` int,
  `workerId` int,
  `title` char,
  `cathegoryId` int,
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
  `id` int,
  `city` varchar(255),
  `coordinatesLatitude` decimal(10,8) DEFAULT NULL,
  `coordinatesLongitude` decimal(11,8) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `cathegory` (
  `id` int PRIMARY KEY,
  `cathegories` varchar(255)
);

CREATE TABLE `userCathegory` (
  `userId` INT NOT NULL,
  `cathegoryId` INT NOT NULL,
  CONSTRAINT `userCathegory_PK` PRIMARY KEY (`userId`,`cathegoryId`)

);

ALTER TABLE `task` ADD FOREIGN KEY (`clientId`) REFERENCES `user` (`id`);

ALTER TABLE `user` ADD FOREIGN KEY (`id`) REFERENCES `evaluations` (`id`);

ALTER TABLE `comment` ADD FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

ALTER TABLE `comment` ADD FOREIGN KEY (`id`) REFERENCES `task` (`id`);

ALTER TABLE `include` ADD FOREIGN KEY (`id`) REFERENCES `task` (`id`);

ALTER TABLE `task` ADD CONSTRAINT task_FK FOREIGN KEY (`cathegoryId`) REFERENCES `cathegory`(`id`);


ALTER TABLE `userCathegory` ADD CONSTRAINT `userCathegory_FK` FOREIGN KEY (`cathegoryId`) REFERENCES `cathegory`(`id`);
ALTER TABLE `userCathegory` ADD CONSTRAINT `userCathegory_FK_1` FOREIGN KEY (`userId`) REFERENCES `user`(`id`);


ALTER TABLE `user` ADD CONSTRAINT `user_FK` FOREIGN KEY (`cityId`) REFERENCES `cityTable`(`id`);


