CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE yeticave;
CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(64) NOT NULL,
    symbol_code VARCHAR(64) NOT NULL
);
CREATE INDEX category_name_index ON categories (category_name);
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_email VARCHAR(255) UNIQUE NOT NULL,
    user_name VARCHAR(64) NOT NULL,
    user_pass VARCHAR(64) NOT NULL,
    user_contact TEXT(500) NOT NULL
);
CREATE TABLE lots (
    lot_id INT AUTO_INCREMENT PRIMARY KEY,
    lot_date_create  DATETIME DEFAULT CURRENT_TIMESTAMP,
    lot_name VARCHAR(255) NOT NULL,
    lot_description TEXT(500) NOT NULL,
    lot_image VARCHAR(255) NOT NULL, 
    lot_first_price INT NOT NULL,
    lot_date_finish  DATETIME,
    lot_price_step INT NOT NULL,
    lot_category INT NOT NULL,
    lot_user INT NOT NULL,
    FOREIGN KEY (lot_category) REFERENCES categories (category_id),
    FOREIGN KEY (lot_user) REFERENCES users(user_id)
);
CREATE INDEX lot_name_index ON lots (lot_name);
CREATE TABLE bets (
    bet_id INT AUTO_INCREMENT PRIMARY KEY,
    bet_date  DATETIME DEFAULT CURRENT_TIMESTAMP,
    bet_price INT NOT NULL,
    bet_lot_id INT NOT NULL,
    bet_user_id INT NOT NULL,
    FOREIGN KEY (bet_lot_id) REFERENCES lots(lot_id),
    FOREIGN KEY (bet_user_id) REFERENCES users(user_id)
);