SET FOREIGN_KEY_CHECKS=0;

-- create status table with id and name
DROP TABLE IF EXISTS status;
CREATE TABLE status (
    id INT NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
);

-- add status_id column to order table after payment_id and add foreign key
ALTER TABLE `order` ADD status_id INT NOT NULL AFTER payment_id;
ALTER TABLE `order` ADD FOREIGN KEY (status_id) REFERENCES status (id);

-- insert status data
INSERT INTO status (name) VALUES ('Paid'), ('Shipped'), ('Delivered'), ('Voided');

SET FOREIGN_KEY_CHECKS=1;