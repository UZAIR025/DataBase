CREATE DATABASE uber;

use uber;

CREATE TABLE customer (
	cid INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	contactnumber int(15) NOT NULL,
	email VARCHAR(50) NOT NULL,
	age INT(3),
	location VARCHAR(50),
	date TIMESTAMP
);
CREATE TABLE driver (
	did INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	contactnumber int(15) NOT NULL,
	email VARCHAR(30) NOT NULL,
	age INT(3),
	location VARCHAR(50),
	licencenumber VARCHAR(10),
	date TIMESTAMP
);

CREATE TABLE trip (
	tid INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	startlocation VARCHAR(30) NOT NULL,
	endlocation VARCHAR(30) NOT NULL,
	distance INT(4),
	currentlocation VARCHAR(30) NOT NULL,
	date TIMESTAMP
);

CREATE TABLE vehicle (
	vid INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	vehiclename VARCHAR(30) NOT NULL,
	ftype VARCHAR(30) NOT NULL,
	ac VARCHAR(30) NOT NULL,
	humancapacity INT(2) NOT NULL,
	vehiclenumber VARCHAR(10)
);

ALTER TABLE trip
    ADD uberid INT (4);

ALTER TABLE trip
    ADD customerfeedback VARCHAR (30);

ALTER TABLE trip
	ADD COLUMN AddedDate TIMESTAMP;

CREATE TABLE albums (
 albumid INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
title VARCHAR(30), description VARCHAR(50),
 CreatedDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tripalbums (
 tripalbumid INT(11) AUTO_INCREMENT PRIMARY KEY,
 albumid INT(11) UNSIGNED,
 FOREIGN KEY (albumid) REFERENCES albums(albumid),
 tripid INT(11) UNSIGNED,
 FOREIGN KEY (tripid) REFERENCES trip(tripid)
);
ALTER TABLE tripalbums
    ADD selected_attribute VARCHAR (30);
CREATE INDEX idx_selected_attribute ON tripalbums(selected_attribute);

