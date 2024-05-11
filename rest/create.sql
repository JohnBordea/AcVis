-- Create database
CREATE DATABASE IF NOT EXISTS acvis;

USE acvis;

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM("admin", "user") NOT NULL
);

DROP TABLE IF EXISTS session;
CREATE TABLE IF NOT EXISTS session (
    id_user INT PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    creation_date DATE NOT NULL
);

DROP TABLE IF EXISTS sag;
CREATE TABLE IF NOT EXISTS sag (
    id INT AUTO_INCREMENT PRIMARY KEY,
    year_of_competition INT,
    category_id INT,
    actor_id INT,
    show_id INT,
    result ENUM("yes", "no") NOT NULL
);

DROP TABLE IF EXISTS sag_category;
CREATE TABLE IF NOT EXISTS sag_category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255)
);
INSERT INTO sag_category(id, category_name) values (-1, "");

DROP TABLE IF EXISTS sag_actor;
CREATE TABLE IF NOT EXISTS sag_actor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    actor_name VARCHAR(255)
);
INSERT INTO sag_actor(id, actor_name) values (-1, "");

DROP TABLE IF EXISTS sag_show;
CREATE TABLE IF NOT EXISTS sag_show (
    id INT AUTO_INCREMENT PRIMARY KEY,
    show_name VARCHAR(255)
);

INSERT INTO sag_show(id, show_name) values (-1, "");