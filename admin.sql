CREATE TABLE registration (
  id INT(6) UNSIGNED ZEROFILL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(50) NOT NULL,
  organization VARCHAR(50) NOT NULL
);
CREATE TABLE votes (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT(6) UNSIGNED,
  position VARCHAR(255) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES registration(id)
);
CREATE TABLE elektrons_candidates (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  position VARCHAR(255) NOT NULL,
  year_level VARCHAR(255) NOT NULL,
  score INT(6) UNSIGNED
);

CREATE TABLE elektrons_settings (
  description TEXT,
  duration_from DATE NOT NULL,
  duration_to DATE,
  candidate_id INT(11) UNSIGNED
);

CREATE TABLE skimmers_candidates (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  position VARCHAR(255) NOT NULL,
  year_level VARCHAR(255) NOT NULL,
  score INT(6) UNSIGNED 
);

CREATE TABLE skimmers_settings (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  duration_from DATE NOT NULL,
  duration_to DATE,
  candidate_id INT(11) UNSIGNED
);

CREATE TABLE clovers_candidates (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  position VARCHAR(255) NOT NULL,
  year_level VARCHAR(255) NOT NULL,
  score INT(6) UNSIGNED
);

CREATE TABLE clovers_settings (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  duration_from DATE NOT NULL,
  duration_to DATE,
  candidate_id INT(11) UNSIGNED
);

CREATE TABLE redbolts_candidates (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  position VARCHAR(255) NOT NULL,
  year_level VARCHAR(255) NOT NULL,
  score INT(6) UNSIGNED
);

CREATE TABLE redbolts_settings (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  duration_from DATE NOT NULL,
  duration_to DATE,
  candidate_id INT(11) UNSIGNED
);

CREATE TABLE admin (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(50) NOT NULL
);
CREATE TABLE contacts(
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  message VARCHAR(255) NOT NULL,
  email VARCHAR(50) NOT NULL);


ALTER TABLE registration
ADD CONSTRAINT unique_email UNIQUE (email);

