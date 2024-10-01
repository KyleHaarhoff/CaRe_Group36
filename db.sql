
SET @@AUTOCOMMIT = 1;

DROP DATABASE IF EXISTS CareGroup36;
CREATE DATABASE CareGroup36;

USE CareGroup36;

--Kyle
CREATE TABLE UserType(
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    type varchar(30)
);

CREATE TABLE Users(
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    first_name varchar(100),
    last_name varchar(100),
    email VARCHAR(255) NOT NULL UNIQUE,
    phone_number VARCHAR(15) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    added timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    profile_image BLOB NULL,
    user_type int,
    FOREIGN KEY (user_type) REFERENCES UserType(id)
	
) AUTO_INCREMENT = 1;

--admin user in case
CREATE user IF NOT EXISTS dbadmin@localhost;
GRANT all privileges ON CareGroup36.* TO dbadmin@localhost;



INSERT INTO UserType(type) VALUES('Patient');
INSERT INTO UserType(type) VALUES('Therapist');
INSERT INTO UserType(type) VALUES('Professional');
INSERT INTO UserType(type) VALUES('Auditor');

INSERT INTO Users(first_name, last_name, email, phone_number, password, user_type) VALUES('Jack', 'Ross', 'jackTheRosser@gmail.com', '+6212341235', SHA1('password'), 1);

INSERT INTO Users(first_name, last_name, email, phone_number, password, user_type) VALUES('David', 'Jones', 'dv@gmail.com', '+6212541234', SHA1('password'), 1);

INSERT INTO Users(first_name, last_name, email, phone_number, password, user_type) VALUES('Bobby', 'Max', 'bm@gmail.com', '+6262341234', SHA1('password'), 1);

INSERT INTO Users(first_name, last_name, email, phone_number, password, user_type) VALUES('Jessica', 'Caprio', 'jessC@gmail.com', '+6212661234', SHA1('password'), 2);

--Dev

--Tharushi
CREATE TABLE groups(
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    group_name varchar(50),
    is_active BOOLEAN

);

CREATE TABLE group_members (
    group_id INT NOT NULL,
    user_id INT NOT NULL,
    is_member BOOLEAN NOT NULL DEFAULT TRUE,
    created_by varchar(100),
    created_date DATE,
    PRIMARY KEY (group_id, user_id),
    FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE
);

INSERT INTO groups (group_name)
VALUES ('Group 1'), ('Group 2'), ('Group 3');


--Siddique

--Arun

--Patients Table---
CREATE TABLE patients (
    p_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    journal_status ENUM('Unread', 'Up to date') NOT NULL,
    requires_followup ENUM('Yes', 'No') NOT NULL,
    created_on DATE NOT NULL
);

--Therapist Table---
CREATE TABLE therapists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    specialty VARCHAR(100),
    contact_info VARCHAR(255)
);

CREATE TABLE patient_therapist (
    patient_id INT,
    therapist_id INT,
    assigned_on DATE NOT NULL,
    PRIMARY KEY (patient_id, therapist_id),
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (therapist_id) REFERENCES therapists(id) ON DELETE CASCADE
);

INSERT INTO patients (name, journal_status, requires_followup, created_on) VALUES
('Jack Ross', 'Unread', 'No', '2024-08-02'),
('David Jones', 'Up to date', 'Yes', '2024-08-02'),
('Mike Leo', 'Unread', 'Yes', '2024-08-02'),
('Josh Chen', 'Up to date', 'No', '2024-08-02');

INSERT INTO therapists (name, specialty, contact_info) VALUES
('Dr. Emily Smith', 'Specialty One', 'emily@example.com'),
('Dr. John Doe', 'Specialty Two', 'john@example.com');

INSERT INTO patient_therapist (patient_id, therapist_id, assigned_on) VALUES
(2, 1, '2024-08-02'),
(3, 2, '2024-08-03'),
(4, 2, '2024-08-04');