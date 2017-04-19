#
# Created by: Baldwin Yu
# Created for: Fresh Focus Media
#
# This is the sql file to create the database and tables for a Point of Sale
# web application requested by Fresh Focus Media as a code revision test.
# The tables are populated with initial values for testing purposes.
#

/* Create/drop databases and tables */
CREATE DATABASE IF NOT EXISTS pos;
USE pos;

DROP TABLE IF EXISTS employee;
DROP TABLE IF EXISTS customer;
DROP TABLE IF EXISTS product_pricing;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS part;
DROP TABLE IF EXISTS inventory;
DROP TABLE IF EXISTS payment_type;
DROP TABLE IF EXISTS `order`;

/* Initial creation of tables */

-- Employees table
CREATE TABLE employee (
	id INT(10) NOT NULL AUTO_INCREMENT,
	firstname VARCHAR(50) NOT NULL,
	lastname VARCHAR(50) NOT NULL,
	PRIMARY KEY (id)
);

-- Customers table
CREATE TABLE customer (
	id INT(10) NOT NULL AUTO_INCREMENT,
	firstname VARCHAR(50) NOT NULL,
	lastname VARCHAR(50) NOT NULL,
	PRIMARY KEY (id)
);

-- Product pricing table
CREATE TABLE product_pricing (
	id INT(10) NOT NULL AUTO_INCREMENT,
	description VARCHAR(50) NOT NULL,
	PRIMARY KEY (id)
);

-- Category table
CREATE TABLE category (
	id INT(10) NOT NULL AUTO_INCREMENT,
	description VARCHAR(50) NOT NULL,
	PRIMARY KEY (id)
);

-- Parts table
CREATE TABLE part (
	id INT(10) NOT NULL AUTO_INCREMENT,
	category_id INT(10) NOT NULL,
	description VARCHAR(50) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (category_id) REFERENCES category(id)
);

-- Inventory table
CREATE TABLE inventory (
	id INT(10) NOT NULL AUTO_INCREMENT,
	category_id INT(10) NOT NULL,
	part_id INT(10) NOT NULL,
	product VARCHAR(50) NOT NULL,
	product_pricing_id INT(10) NOT NULL,
	price DECIMAL(10,2) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (category_id) REFERENCES category(id),
	FOREIGN KEY (part_id) REFERENCES part(id),
	FOREIGN KEY (product_pricing_id) REFERENCES product_pricing(id)
);

-- Payment description table
CREATE TABLE payment_type (
	id INT(10) NOT NULL AUTO_INCREMENT,
	description VARCHAR(50) NOT NULL,
	PRIMARY KEY (id)
);

-- `order`s table
CREATE TABLE `order` (
	id INT(10) NOT NULL AUTO_INCREMENT,
	order_date DATE NOT NULL,
	customer_id INT(10) NOT NULL,
	subtotal DECIMAL(10,2) NOT NULL,
	discount_type INT(1),
	discount_value DECIMAL(10,2),
	tax DECIMAL(10,2),
	total DECIMAL(10,2) NOT NULL,
	payment_type_id INT(10) NOT NULL,
	comments VARCHAR(200),
	employee_id INT(10) NOT NULL,
	ship_date DATE NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (customer_id) REFERENCES customer(id),
	FOREIGN KEY (payment_type_id) REFERENCES payment_type(id),
	FOREIGN KEY (employee_id) REFERENCES employee(id)
);

/* Populate tables */

-- Employees table
INSERT INTO employee (firstname, lastname)
VALUES ('Baldwin', 'Yu');

-- Customers table
INSERT INTO customer (firstname, lastname)
VALUES ('Kenneth', 'Bond'),
	('Lana', 'Bond'),
	('Dayana', 'Patel');

-- Product pricing table
INSERT INTO product_pricing (description)
VALUES ('Client Price'),
	('Admin Price'),
	('Sell Price');

-- Category table
INSERT INTO category (description)
VALUES ('Category 1'),
	('Category 2');

-- Part table
INSERT INTO part (description, category_id)
VALUES ('Part 1-1', 1),
	('Part 1-2', 1),
	('Part 1-3', 1),
	('Part 2-1', 2),
	('Part 2-2', 2);

-- Inventory table
INSERT INTO inventory (category_id, part_id, product, product_pricing_id, price)
VALUES (1, 1, 'Product 1-1-1', 1, 20.00),
	(1, 1, 'Product 1-1-1', 2, 15.50),
	(1, 1, 'Product 1-1-1', 3, 300.45),
	(1, 2, 'Product 1-2-1', 1, 283.34),
	(1, 2, 'Product 1-2-1', 2, 1282.60),
	(1, 2, 'Product 1-2-1', 3, 5883.20),
	(1, 3, 'Product 1-3-1', 1, 2000.00),
	(1, 3, 'Product 1-3-1', 2, 3014.00),
	(1, 3, 'Product 1-3-1', 3, 34883.00),
	(2, 4, 'Product 2-4-1', 1, 238.00),
	(2, 4, 'Product 2-4-1', 2, 1.99),
	(2, 4, 'Product 2-4-1', 3, 2.04),
	(2, 5, 'Product 2-5-1', 1, 30.30),
	(2, 5, 'Product 2-5-1', 2, 37.40),
	(2, 5, 'Product 2-5-1', 3, 10.00);

-- Payment description table
INSERT INTO payment_type (description)
VALUES ('MasterCard'),
	('Visa'),
	('American Express');

/* Create user for testing */
CREATE USER IF NOT EXISTS 'pos_test'@'localhost'
	IDENTIFIED BY 'pos_test';
GRANT ALL PRIVILEGES ON pos.* TO 'pos_test'@'localhost'
	WITH GRANT OPTION;
FLUSH PRIVILEGES;