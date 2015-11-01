/* Table structure for table events */

DROP TABLE if EXISTS events;

CREATE TABLE events (
  idOfEvent INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  idClient INT NOT NULL,
  idContact INT NULL,
  dateOfEvent DATE NOT NULL,
  timeOfEvent TIME NOT NULL,
  typeOfEvent ENUM ('missing type', '01', '02', '03', '04') NOT NULL,
  statusOfEvent ENUM ('missing status', '01', '02', '03', '04') NOT NULL,
  outcomeOfEvent ENUM ('missing outcome', '01', '02', '03') NULL,
  descriptionOfEvent VARCHAR(250) NULL,
  creationOfEvent TIMESTAMP NOT NULL DEFAULT current_timestamp,
  topicOfEvent VARCHAR(50) NOT NULL,
  CONSTRAINT fk_clients_events FOREIGN KEY (idClient) REFERENCES clients(idClient),
  CONSTRAINT fk_contacts_events FOREIGN KEY (idContact) REFERENCES contacts(idContact)
)DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;

/* Table structure for table clients */

DROP TABLE if EXISTS clients;

CREATE TABLE clients (
  idClient INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  nameClient VARCHAR(80) NOT NULL ,
  idTax VARCHAR(10) NULL,
  addressClient TINYTEXT NULL ,
  cityClient VARCHAR(25) NOT NULL ,
  phoneClient INT NOT NULL ,
  faxClient INT NULL ,
  wwwClient VARCHAR(40) NULL ,
  mailClient VARCHAR(40) NOT NULL ,
  noteClient TEXT NULL ,
  creationDateClient TIMESTAMP NOT NULL DEFAULT current_timestamp
)DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;

/* Table structure for table contacts */

DROP TABLE if EXISTS contacts;

CREATE TABLE contacts (
  idContact INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  idClient INT NOT NULL,
  surnameContact VARCHAR(30) NOT NULL,
  nameContact VARCHAR(30) NULL,
  positionContact VARCHAR(30) NULL,
  phoneContact VARCHAR(15) NULL,
  emailContact VARCHAR(50) NOT NULL,
  cityContact VARCHAR(30) NOT NULL,
  linkedinContact VARCHAR(200) NULL,
  noteContact TINYTEXT NULL,
  creationDateContact TIMESTAMP NOT NULL DEFAULT current_timestamp,
  CONSTRAINT fk_clients_contacts FOREIGN KEY (idClient) REFERENCES clients(idClient)
)DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;

/* Table structure for table users */

DROP TABLE if EXISTS users;

CREATE TABLE users (
  idUser INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  loginUser VARCHAR(80) NOT NULL UNIQUE,
  passwordUser VARCHAR (125) NOT NULL ,
  roleUser ENUM('0','1','2') NOT NULL DEFAULT '0',
  creationDateUser TIMESTAMP NOT NULL DEFAULT current_timestamp
)DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;
