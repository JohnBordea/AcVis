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