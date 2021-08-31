CREATE DATABASE TaskForce DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
USE TaskForce;

/*Таблица категорий*/
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(64) NOT NULL,
    code VARCHAR(64) NOT NULL UNIQUE,
    icon VARCHAR(256) DEFAULT NULL
);

CREATE INDEX code_ind ON categories(code);

/*Таблица ссылок на дополнительные документы к заданию*/
CREATE TABLE documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    link VARCHAR(512) NOT NULL
);

CREATE INDEX doc_ind ON documents(task_id);

/*Таблица фотографий работ исполнителя*/
CREATE TABLE images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    img VARCHAR(256) NOT NULL
);

CREATE INDEX img_ind ON images(user_id);

/*Таблица городов*/
CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(32) NOT NULL,
    latitude DECIMAL(10, 8) NOT NULL,
    longitude DECIMAL(11, 8) NOT NULL
);

CREATE INDEX city_ind ON cities(name);

/*Таблица мест выполнения заданий*/
CREATE TABLE locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    city_id INT NOT NULL,
    latitude DECIMAL(10, 8) DEFAULT NULL,
    longitude DECIMAL(11, 8) DEFAULT NULL,
    district VARCHAR(64) DEFAULT NULL,
    street VARCHAR(64) DEFAULT NULL,
    info TEXT DEFAULT NULL
);

CREATE INDEX loc_ind ON locations(city_id);

/*Таблица заданий*/
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    custom_id INT NOT NULL, /*заказчик*/
    contr_id INT NOT NULL,  /*исполнитель*/
    name VARCHAR(256) NOT NULL,
    description TEXT DEFAULT NULL,
    cat_id  INT NOT NULL,
    loc_id INT NOT NULL,
    budget INT NOT NULL,
    add_date DATETIME NOT NULL,
    deadline DATETIME NOT NULL, /*срок выполнения задания*/
    fin_date DATETIME NOT NULL, /*фактический срок выполнения задания*/
    status VARCHAR(16) NOT NULL 
);

CREATE INDEX task_ind ON tasks(name);

/*Таблица пользователей*/
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(64) NOT NULL,
    email VARCHAR(64) NOT NULL UNIQUE,
    password VARCHAR(64) NOT NULL,
    add_date DATETIME NOT NULL
);

CREATE INDEX user_ind ON users(email);

/*Таблица профилей пользователей*/
CREATE TABLE profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    born_date DATE NOT NULL,
    avatar VARCHAR(256) DEFAULT NULL,
    last_act DATETIME DEFAULT NULL, /*дата последней активности*/
    phone VARCHAR(32) DEFAULT NULL,
    messenger VARCHAR(32) DEFAULT NULL,
    social_net VARCHAR(32) DEFAULT NULL,
    address VARCHAR(256) DEFAULT NULL,
    about_info TEXT DEFAULT NULL   /*дополнительная информация о себе*/
);

CREATE INDEX profile_ind ON profiles(user_id);

/*Таблица откликов исполнителей*/
CREATE TABLE replies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    contr_id INT NOT NULL,
    price INT NOT NULL,
    comment TEXT DEFAULT NULL,
    add_date DATETIME NOT NULL,
    rating INT NOT NULL,
    status VARCHAR(16) NOT NULL
);

CREATE INDEX reply_ind ON replies(add_date);

/*Таблица отзывов о работах исполнителей*/
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    custom_id INT NOT NULL,
    contr_id INT NOT NULL,
    add_date DATETIME NOT NULL,
    comment TEXT NOT NULL,
    rating INT NOT NULL
);

CREATE INDEX review_ind ON reviews(add_date);

/*Таблица сообщений пользователей*/
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content VARCHAR(256) NOT NULL,
    from_id INT NOT NULL, /*от кого сообщение*/
    whom_id INT NOT NULL, /*кому сообщение*/
    add_date DATETIME NOT NULL
);

CREATE INDEX msg_ind ON messages(add_date);

/*Таблица связей типа многие-ко-многим пользователи-категории*/
CREATE TABLE users_categories (
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (user_id, category_id),
    CONSTRAINT fk_users FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_categories FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE INDEX user_ind ON users_categories(user_id);
CREATE INDEX category_ind ON users_categories(category_id);
