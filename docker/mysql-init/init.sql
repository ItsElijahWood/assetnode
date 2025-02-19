-- Ensure the user exists first
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';

-- Grant full access to all databases
GRANT ALL PRIVILEGES ON *.* TO 'user'@'%' WITH GRANT OPTION;

CREATE DATABASE IF NOT EXISTS `assetnode`;
CREATE DATABASE IF NOT EXISTS `assets`;
USE assetnode;

-- Create your tables here
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `is_premium` TINYINT(1) NOT NULL DEFAULT 0
);

-- Apply changes
FLUSH PRIVILEGES;
