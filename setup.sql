DROP DATABASE IF EXISTS ListServ;
CREATE DATABASE ListServ;

USE ListServ;

CREATE TABLE List_name(
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(20)
);

CREATE TABLE SMSList_name(
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(20)
);

CREATE TABLE MyUser(
    Email VARCHAR(20),
    PRIMARY KEY(Email)
);

CREATE TABLE SMSMyUser(
    PhoneNumber VARCHAR(10),
    PRIMARY KEY(PhoneNumber)
);


CREATE TABLE List_User(
    Email_id VARCHAR(20),
    List_id INT,
    PRIMARY KEY(Email_id, List_id),
    FOREIGN KEY (Email_id) REFERENCES MyUser(Email),
    FOREIGN KEY (List_id) REFERENCES List_name(ID)
);

CREATE TABLE SMSList_User(
    PhoneNumber_id VARCHAR(10),
    List_id INT,
    PRIMARY KEY(PhoneNumber_id, List_id),
    FOREIGN KEY (PhoneNumber_id) REFERENCES SMSMyUser(PhoneNumber),
    FOREIGN KEY (List_id) REFERENCES SMSList_name(ID)
);