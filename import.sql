USE mario_subscribers;
DROP TABLE IF EXISTS `api_keys`;
CREATE TABLE `api_keys` (
    `id` int NOT NULL AUTO_INCREMENT,
    `key` varchar(1000) NOT NULL,
    PRIMARY KEY (`id`)
);