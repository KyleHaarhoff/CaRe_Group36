
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
CREATE TABLE Goals (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,   
    user_id INT NOT NULL,                         
    goal_text TEXT NOT NULL,                      
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  
    is_completed BOOLEAN DEFAULT FALSE,           
    FOREIGN KEY (user_id) REFERENCES Users(id)    
);
-- User 1's goals
INSERT INTO Goals (user_id, goal_text, is_completed) 
VALUES 
(1, 'Run 5km every day', FALSE),
(1, 'Read a new book every month', TRUE),
(1, 'Start a new online course', FALSE);

-- User 2's goals
INSERT INTO Goals (user_id, goal_text, is_completed) 
VALUES 
(2, 'Lose 10kg in 6 months', FALSE),
(2, 'Eat healthier meals', TRUE),
(2, 'Save $5000 by the end of the year', FALSE);


--table for the session and case for the auditor to see
CREATE TABLE Sessions (
    session_id INT AUTO_INCREMENT PRIMARY KEY,
    p_id INT , 
     id INT ,
   
    session_length INT, 
    session_date DATE,
    FOREIGN KEY (id) REFERENCES therapists(id) ON DELETE CASCADE,
    FOREIGN KEY (p_id) REFERENCES patients(p_id) ON DELETE CASCADE
);



CREATE TABLE Cases (
    case_id INT AUTO_INCREMENT PRIMARY KEY,
    id INT,
    case_type VARCHAR(100),
    FOREIGN KEY (id) REFERENCES therapists(id)
);

INSERT INTO Sessions (p_id, id, session_length, session_date)
VALUES 
(1, 1, 60, '2024-09-15'),
(2, 1, 45, '2024-09-18');

INSERT INTO Cases (id, case_type)
VALUES 
(1, 'Therapeutic Consultation'),
(2, 'Depression Therapy'),


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

CREATE TABLE patient_therapist (
    patient_id INT,
    therapist_id INT,
    assigned_on DATE NOT NULL,
    PRIMARY KEY (patient_id, therapist_id),
    journal_status ENUM('Unread', 'Up to date') NOT NULL,
    requires_followup ENUM('Yes', 'No') NOT NULL,
    created_on DATE NOT NULL,
    FOREIGN KEY (patient_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (therapist_id) REFERENCES Users(id) ON DELETE CASCADE
);

INSERT INTO patient_therapist (patient_id, therapist_id, assigned_on, journal_status, requires_followup, created_on)
VALUES
(1, 2, '2024-08-01', 'Unread', 'No', '2024-08-02'),
(3, 2, '2024-09-15', 'Up to date', 'Yes', '2024-09-16'),
(1, 2, '2024-09-10', 'Unread', 'No', '2024-09-12'),
(2, 2, '2024-09-10', 'Unread', 'No', '2024-09-12'),
(4, 2, '2024-09-10', 'Unread', 'No', '2024-09-12');

