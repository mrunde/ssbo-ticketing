CREATE DATABASE `ssbo_ticketing` CHARACTER SET utf8 COLLATE utf8_general_ci;
USE ssbo_ticketing;

CREATE USER 'admin'@'localhost' IDENTIFIED BY 'password';
GRANT SELECT, INSERT, UPDATE ON `ssbo_ticketing`.* TO 'admin'@'localhost';

CREATE TABLE IF NOT EXISTS tickets (
	code		VARCHAR(50) NOT NULL,
	firstname	VARCHAR(50) NOT NULL,
	lastname	VARCHAR(50) NOT NULL,
	street		VARCHAR(50) NOT NULL,
	housenumber	VARCHAR(5) NOT NULL,
	postalcode	INT(5) UNSIGNED NOT NULL,
	town		VARCHAR(50) NOT NULL,
	email		VARCHAR(50) NOT NULL,
	date		TIMESTAMP NOT NULL,
	payed		BOOLEAN NOT NULL DEFAULT false,
	used		BOOLEAN NOT NULL DEFAULT false,
	PRIMARY KEY (code)
);
