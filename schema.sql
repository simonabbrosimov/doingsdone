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

CREATE TABLE projects (
	id INT AUTO_INCREMENT PRIMARY KEY,
	project_title VARCHAR (255),
	author_id INT,
	FOREIGN KEY (author_id) REFERENCES users(id)
);

CREATE TABLE tasks (
	id INT AUTO_INCREMENT PRIMARY KEY,
	create_date DATETIME DEFAULT CURRENT_TIMESTAMP,
	status INT,
	task_name VARCHAR (255),
	file_path VARCHAR (255),
	end_date DATE,
	author_id INT,
	project_id INT,
	FOREIGN KEY (author_id) REFERENCES users(id),
	FOREIGN KEY (project_id) REFERENCES projects(id)

);

