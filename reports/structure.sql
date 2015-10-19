/* Table structure for table events */

DROP TABLE if EXISTS events;

CREATE TABLE events (
  idOfEvent INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  topicOfEvent VARCHAR(50) NOT NULL,
  idClient INT NOT NULL,
  idContact INTEGER NULL,
  dateOfEvent DATE NOT NULL,
  timeOfEvent TIME NOT NULL,
  statusOfEvent ENUM ('missing status', '01', '02', '03', '04') NOT NULL,
  typeOfEvent ENUM ('missing type', '01', '02', '03', '04') NOT NULL,
  descriptionOfEvent VARCHAR(250) NULL,
  outcomeOfEvent ENUM ('missing outcome', '01', '02', '03'),
  creationOfEvent TIMESTAMP NOT NULL DEFAULT current_timestamp,
  CONSTRAINT fk_clients_events FOREIGN KEY (idClient) REFERENCES clients(idClient),
  CONSTRAINT fk_contacts_events FOREIGN KEY (idContact) REFERENCES contacts(idContact)
) DEFAULT CHARSET=utf8;

/* Table structure for table events */

DROP TABLE if EXISTS clients;

CREATE TABLE clients (
  idClient INT NOT NULL  AUTO_INCREMENT PRIMARY KEY ,
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
);

/* Table structure for table events */

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
linkedInContact VARCHAR(200) NULL,
noteContact TINYTEXT NULL,
creationDateContact TIMESTAMP NOT NULL DEFAULT current_timestamp
)