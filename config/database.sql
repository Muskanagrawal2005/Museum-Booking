-- CREATE DATABASE user_db;
USE user_db;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    token VARCHAR(100)
);

-- Create shows table
CREATE TABLE shows (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    available_slots JSON NOT NULL
);

-- Create bookings table
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    show_id INT NOT NULL,
    num_tickets INT NOT NULL,
    visitor_name VARCHAR(100) NOT NULL,
    show_time VARCHAR(50) NOT NULL,
    mobile_number VARCHAR(15) NOT NULL,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (show_id) REFERENCES shows(id)
);

-- Insert sample show data
INSERT INTO shows (name, description, price, available_slots) VALUES
('Ancient Egypt Exhibition', 'Explore the mysteries of ancient Egypt through artifacts and mummies', 25.00, 
'["09:00 AM", "11:00 AM", "02:00 PM", "04:00 PM"]'),
('Modern Art Gallery', 'Contemporary art from leading artists around the world', 20.00, 
'["10:00 AM", "01:00 PM", "03:00 PM", "05:00 PM"]'),
('Dinosaur World', 'Life-size dinosaur models and fossil exhibitions', 30.00, 
'["09:30 AM", "12:30 PM", "02:30 PM", "04:30 PM"]');