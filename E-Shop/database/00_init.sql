CREATE DATABASE IF NOT EXISTS comp3421_final_project;
USE comp3421_final_project;

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS user;
CREATE TABLE user (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(45) NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) NOT NULL DEFAULT 0,
    create_datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    delete_datetime TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id)
);
INSERT INTO user (username, password, is_admin) VALUES 
('admin', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 1),
('user', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 0);

DROP TABLE IF EXISTS user_access_token;

DROP TABLE IF EXISTS user_reward_log;

DROP TABLE IF EXISTS payment;
CREATE TABLE payment (
    id INT NOT NULL AUTO_INCREMENT,
    code VARCHAR(45) NOT NULL,
    description VARCHAR(255) NOT NULL,
    create_datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    delete_datetime TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id)
);
INSERT INTO payment (code, description) VALUES ('COD', 'Cash on Delivery');

DROP TABLE IF EXISTS promotion_code;
CREATE TABLE promotion_code (
    id INT NOT NULL AUTO_INCREMENT,
    code VARCHAR(45) NOT NULL,
    discount_rate DECIMAL(8,2) NOT NULL, 
    description VARCHAR(255) NOT NULL,
    is_valid TINYINT(1) NOT NULL DEFAULT 1,
    create_datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    delete_datetime TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id)
);
INSERT INTO promotion_code (code, discount_rate, description) VALUES ('TEST', 0.1, 'Test');

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
    id INT NOT NULL AUTO_INCREMENT,
    order_sn VARCHAR(45) NOT NULL,
    user_id INT NOT NULL,
    promotion_code_id INT NULL DEFAULT NULL,
    payment_id INT NOT NULL,
    create_datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    cancel_datetime TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES user (id),
    FOREIGN KEY (promotion_code_id) REFERENCES promotion_code (id),
    FOREIGN KEY (payment_id) REFERENCES payment (id)
);

DROP TABLE IF EXISTS region;
CREATE TABLE region (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(45) NOT NULL,
    create_datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    delete_datetime TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id)
);
INSERT INTO region (name) VALUES ('Hong Kong'), ('Macau');

DROP TABLE IF EXISTS user_address;
DROP TABLE IF EXISTS order_shipping;
CREATE TABLE order_shipping (
    id INT NOT NULL AUTO_INCREMENT,
    order_id INT NOT NULL,
    first_name VARCHAR(45) NOT NULL,
    last_name VARCHAR(45) NOT NULL,
    email VARCHAR(255) NULL,
    phone VARCHAR(8) NOT NULL,
    address1 VARCHAR(255) NOT NULL,
    address2 VARCHAR(255) NOT NULL,
    region_id INT NOT NULL,
    create_datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    delete_datetime TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (order_id) REFERENCES `order` (id),
    FOREIGN KEY (region_id) REFERENCES region (id)
);

DROP TABLE IF EXISTS product;
CREATE TABLE product (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    brand VARCHAR(45) NOT NULL,
    description VARCHAR(1024) NOT NULL,
    unit_price DECIMAL(8,2) NOT NULL,
    is_hidden TINYINT(1) NOT NULL DEFAULT 0,
    create_datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    delete_datetime TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id)
);
INSERT INTO product (id, name, brand, description, unit_price) VALUES 
(1, 'iPhone 14', 'Apple', 'iPhone 14', 6899),
(2, 'Galaxy S23', 'Samsung', 'Galaxy S23', 5899),
(3, 'iPad Air', 'Apple', 'iPad Air', 4799),
(4, 'Tab S7 FE', 'Samsung', 'Tab S7 FE', 4988),
(5, 'Macbook Air M2', 'Apple', 'Macbook Air M2', 9499),
(6, 'ZenBook S 13 OLED', 'ASUS', 'ZenBook S 13 OLED', 9998);

DROP TABLE IF EXISTS product_color;
CREATE TABLE product_color (
    id INT NOT NULL AUTO_INCREMENT,
    product_id INT NOT NULL,
    color VARCHAR(45) NOT NULL,
    is_hidden TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    FOREIGN KEY (product_id) REFERENCES product (id)
);
INSERT INTO product_color (product_id, color) VALUES 
(1, 'Blue'),
(1, 'Red'),
(1, 'White'),
(1, 'Yellow'),
(2, 'White'),
(2, 'Green'),
(2, 'Black'),
(2, 'Purple'),
(3, 'Purple'),
(3, 'Black'),
(3, 'Blue'),
(3, 'Silver'),
(4, 'Black'),
(4, 'Green'),
(4, 'Pink'),
(4, 'Silver'),
(5, 'Blue'),
(5, 'Silver'),
(5, 'Space Gray'),
(5, 'Starlight'),
(6, 'Blue'),
(6, 'Ceramics'),
(6, 'Pink'),
(6, 'White');

DROP TABLE IF EXISTS user_cart;
CREATE TABLE user_cart (
    user_id INT NOT NULL,
    product_color_id INT NOT NULL,
    quantity INT NOT NULL,
    PRIMARY KEY (user_id, product_color_id),
    FOREIGN KEY (user_id) REFERENCES user (id),
    FOREIGN KEY (product_color_id) REFERENCES product_color (id)
);

DROP TABLE IF EXISTS user_wishlist;

DROP TABLE IF EXISTS order_product;
CREATE TABLE order_product (
    order_id INT NOT NULL,
    product_color_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(8,2) NOT NULL,
    PRIMARY KEY (order_id, product_color_id),
    FOREIGN KEY (order_id) REFERENCES `order` (id),
    FOREIGN KEY (product_color_id) REFERENCES product_color (id)
);

DROP TABLE IF EXISTS product_inventory_log;

DROP TABLE IF EXISTS category;
CREATE TABLE category (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    create_datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    delete_datetime TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id)
);
INSERT INTO category (id, name) VALUES (1, 'Phone'), (2, 'Tablet');

DROP TABLE IF EXISTS product_category;
CREATE TABLE product_category (
    product_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (product_id, category_id),
    FOREIGN KEY (product_id) REFERENCES product (id),
    FOREIGN KEY (category_id) REFERENCES category (id)
);
INSERT INTO product_category (product_id, category_id) VALUES 
(1, 1),
(2, 1),
(3, 2),
(4, 2),
(5, 2),
(6, 2);

DROP TABLE IF EXISTS product_image;
CREATE TABLE product_image (
    id INT NOT NULL AUTO_INCREMENT,
    product_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_hidden TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    FOREIGN KEY (product_id) REFERENCES product (id)
);
INSERT INTO product_image (product_id, image_path) VALUES
(1, '/image/product/phone/Apple/ip14.png'),
(1, '/image/product/phone/Apple/ip14-red.png'),
(1, '/image/product/phone/Apple/ip14-white.png'),
(1, '/image/product/phone/Apple/ip14-yellow.png'),
(2, '/image/product/phone/Samsung/galaxy-s23.png'),
(2, '/image/product/phone/Samsung/galaxy-s23-green.png'),
(2, '/image/product/phone/Samsung/galaxy-s23-black.png'),
(2, '/image/product/phone/Samsung/galaxy-s23-purple.png'),
(3, '/image/product/tablet/Apple/ipad-air.png'),
(3, '/image/product/tablet/Apple/ipad-air-black.png'),
(3, '/image/product/tablet/Apple/ipad-air-blue.png'),
(3, '/image/product/tablet/Apple/ipad-air-sliver.png'),
(4, '/image/product/tablet/samsung/galaxy-tab-s7-fe-black.png'),
(4, '/image/product/tablet/samsung/galaxy-tab-s7-fe-green.png'),
(4, '/image/product/tablet/samsung/galaxy-tab-s7-fe-pink.png'),
(4, '/image/product/tablet/samsung/galaxy-tab-s7-fe-silver.png'),
(5, '/image/product/laptop/Apple/MacBook-Air-M2.png'),
(5, '/image/product/laptop/Apple/MacBook-Air-M2-sliver.png'),
(5, '/image/product/laptop/Apple/MacBook-Air-M2-spacegray.png'),
(5, '/image/product/laptop/Apple/MacBook-Air-M2-starlight.png'),
(6, '/image/product/laptop/Asus/zenbook-s-blue.png'),
(6, '/image/product/laptop/Asus/zenbook-s-ceramics.png'),
(6, '/image/product/laptop/Asus/zenbook-s-pink.png'),
(6, '/image/product/laptop/Asus/zenbook-s-white.png');

SET FOREIGN_KEY_CHECKS=1;