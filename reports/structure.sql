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
creationOfEvent TIMESTAMP NOT NULL,
CONSTRAINT fk_clients_events FOREIGN KEY (idClient) REFERENCES clients(idClient),
CONSTRAINT fk_contacts_events FOREIGN KEY (idContact) REFERENCES contacts(idContact)
) DEFAULT CHARSET=utf8;