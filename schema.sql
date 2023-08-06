CREATE DATABASE doingsdone
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

CREATE TABLE users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	registration_date DATETIME DEFAULT CURRENT_TIMESTAMP,
	user_email VARCHAR(128) NOT NULL UNIQUE,
	user_name VARCHAR(128),
	password CHAR(12)	

);	

CREATE TABLE categories (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR (255),
	author_id INT,
	FOREIGN KEY (author_id) REFERENCES users(id)
);

CREATE TABLE goals (
	id INT AUTO_INCREMENT PRIMARY KEY,
	create_date DATETIME DEFAULT CURRENT_TIMESTAMP,
	status INT,
	title VARCHAR (255),
	file_path VARCHAR (255),
	end_date DATE,
	author_id INT,
	category_id INT,
	FOREIGN KEY (author_id) REFERENCES users(id),
	FOREIGN KEY (category_id) REFERENCES categories(id)

);

ALTER TABLE goals ADD FULLTEXT(title);