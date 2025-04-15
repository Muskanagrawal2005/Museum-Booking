<?php
require_once 'db.php';

// Create shows table if not exists
$sql = "CREATE TABLE IF NOT EXISTS shows (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL
)";

if ($conn->query($sql) === FALSE) {
    die("Error creating shows table: " . $conn->error);
}

// Check if shows table is empty
$result = $conn->query("SELECT COUNT(*) as count FROM shows");
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    // Insert sample shows
    $shows = [
        [
            'name' => 'Ancient Egypt Exhibition',
            'description' => 'Explore the mysteries of ancient Egypt through artifacts and mummies',
            'price' => 25.00
        ],
        [
            'name' => 'Modern Art Gallery',
            'description' => 'Contemporary art from leading artists around the world',
            'price' => 20.00
        ],
        [
            'name' => 'Dinosaur World',
            'description' => 'Life-size dinosaur models and fossil exhibitions',
            'price' => 30.00
        ]
    ];

    $stmt = $conn->prepare("INSERT INTO shows (name, description, price) VALUES (?, ?, ?)");
    
    foreach ($shows as $show) {
        $stmt->bind_param("ssd", $show['name'], $show['description'], $show['price']);
        if ($stmt->execute() === FALSE) {
            die("Error inserting show: " . $stmt->error);
        }
    }
}

// Drop existing bookings table to recreate with correct structure
$conn->query("DROP TABLE IF EXISTS bookings");

// Create bookings table with all required fields
$sql = "CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    show_id INT NOT NULL,
    show_name VARCHAR(255) NOT NULL,
    num_tickets INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    visitor_name VARCHAR(255) NOT NULL,
    show_time VARCHAR(50) NOT NULL,
    mobile_number VARCHAR(15) NOT NULL,
    payment_id VARCHAR(255) NOT NULL,
    ticket_number VARCHAR(50) NOT NULL,
    booking_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Bookings table created successfully\n";
} else {
    echo "Error creating bookings table: " . $conn->error . "\n";
}

$conn->close();

echo "Database setup completed successfully!";
?>
