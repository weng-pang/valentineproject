
CREATE TABLE places (
                place_id INT NOT NULL,
                place_name VARCHAR(20) NOT NULL,
                PRIMARY KEY (place_id)
);


CREATE TABLE users (
                user_id INT AUTO_INCREMENT NOT NULL,
                pin INT NOT NULL,
                user_name VARCHAR(20) NOT NULL,
                PRIMARY KEY (user_id)
);


CREATE TABLE invoices (
                invoice_no INT NOT NULL,
                user_id INT NOT NULL,
                allocated_place INT NOT NULL,
                start_time INT NOT NULL,
                end_time INT NOT NULL,
                print_out SMALLINT NOT NULL,
                gift SMALLINT NOT NULL,
                PRIMARY KEY (invoice_no)
);


CREATE TABLE p4 (
                p4_no INT AUTO_INCREMENT NOT NULL,
                invoice_no INT NOT NULL,
                p4_time INT NOT NULL,
                p4_location VARCHAR(20) NOT NULL,
                user_id INT NOT NULL,
                PRIMARY KEY (p4_no)
);


CREATE TABLE p3 (
                p3_no INT AUTO_INCREMENT NOT NULL,
                invoice_no INT NOT NULL,
                p3_time INT NOT NULL,
                p3_location VARCHAR(20) NOT NULL,
                user_id INT NOT NULL,
                PRIMARY KEY (p3_no)
);


CREATE TABLE p2 (
                p2_no INT AUTO_INCREMENT NOT NULL,
                invoice_no INT NOT NULL,
                p2_time INT NOT NULL,
                p2_location VARCHAR(20) NOT NULL,
                user_id INT NOT NULL,
                PRIMARY KEY (p2_no)
);


CREATE TABLE p1 (
                p1_no INT AUTO_INCREMENT NOT NULL,
                p1_time INT NOT NULL,
                p1_location VARCHAR(20) NOT NULL,
                user_id INT NOT NULL,
                PRIMARY KEY (p1_no)
);


ALTER TABLE invoices ADD CONSTRAINT places_invoices_fk
FOREIGN KEY (allocated_place)
REFERENCES places (place_id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE p1 ADD CONSTRAINT users_p1_fk
FOREIGN KEY (user_id)
REFERENCES users (user_id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE p2 ADD CONSTRAINT users_p2_fk
FOREIGN KEY (user_id)
REFERENCES users (user_id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE p3 ADD CONSTRAINT users_p3_fk
FOREIGN KEY (user_id)
REFERENCES users (user_id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE p4 ADD CONSTRAINT users_p4_fk
FOREIGN KEY (user_id)
REFERENCES users (user_id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE invoices ADD CONSTRAINT users_invoices_fk
FOREIGN KEY (user_id)
REFERENCES users (user_id)
ON DELETE CASCADE
ON UPDATE CASCADE;