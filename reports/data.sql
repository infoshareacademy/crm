/*Data for the table clients */

LOCK TABLES clients WRITE;

DELETE FROM clients;
INSERT INTO clients (nameClient, idTax, addressClient, cityClient, phoneClient, faxClient, wwwClient, mailClient, noteClient)
VALUES ();

UNLOCK TABLES;

/*Data for the table contacts */

LOCK TABLES contacts WRITE;

DELETE FROM contacts;
INSERT INTO contacts (idClient, surnameContact, nameContact, emailContact, cityContact)
VALUES ();

UNLOCK TABLES;

/*Data for the table events */

LOCK TABLES events WRITE;

DELETE FROM events;
INSERT INTO events (idClient, dateOfEvent, timeOfEvent, typeOfEvent, statusOfEvent)
VALUES (1, '19-10-2015', '15:00', '04', '02' ),
  (2, '19-10-2015', ),
  (),
  (),
  (),
  ();

UNLOCK TABLES;