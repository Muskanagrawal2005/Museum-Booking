# Heritage Museum Website

A full-stack web application for the Heritage Museum, featuring user authentication, ticket booking, payment processing, and contact management.

## Features

- User Authentication (Login/Register)
- Ticket Booking System
- Payment Integration (Razorpay)
- Contact Form with Email Notifications
- Admin Dashboard
- Responsive Design with Tailwind CSS

## Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Composer
- XAMPP/LAMP/WAMP stack

## Installation

1. Clone the repository:
```bash
git clone [repository-url]
cd FULLSTACK
```

2. Install PHP dependencies:
```bash
composer install
```

3. Configure the database:
   - Create a new MySQL database named `user_db`
   - Import the database schema (see Database Setup below)

4. Configure environment:
   - Update database credentials in `includes/db-connect.php`
   - Configure email settings in `process-contact.php`

## Database Setup

1. Create the database:
```sql
CREATE DATABASE user_db;
USE user_db;
```

2. Create users table:
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_verified BOOLEAN DEFAULT FALSE
);
```

3. Create contact_messages table:
```sql
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

4. Create bookings table:
```sql
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    ticket_type VARCHAR(50) NOT NULL,
    quantity INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    payment_status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

## Project Structure

```
FULLSTACK/
├── admin-dashboard.php    # Admin interface
├── about.php             # About page
├── contact.php           # Contact page
├── exhibitions.php       # Exhibitions page
├── home.php              # Home page
├── index.php             # Main entry point
├── login.php             # Login system
├── register.php          # Registration system
├── tickets.php           # Ticket booking
├── payment.php           # Payment processing
├── process-contact.php   # Contact form handler
├── process-payment.php   # Payment handler
├── verify-payment.php    # Payment verification
├── includes/             # PHP includes
│   ├── header.php
│   ├── footer.php
│   └── db-connect.php
├── css/                  # Stylesheets
├── js/                   # JavaScript files
├── images/               # Image assets
├── vendor/               # Composer dependencies
│   └── phpmailer/        # Email functionality
└── config/               # Configuration files
```

## Email Configuration

1. Update SMTP settings in `process-contact.php`:
```php
$mail->Host = "smtp.gmail.com";
$mail->Username = "your-email@gmail.com";
$mail->Password = "your-app-password";
```

2. Enable "Less secure app access" or use App Password in Gmail settings

## Security Notes

- Never commit sensitive information (passwords, API keys)
- Keep database credentials secure
- Use HTTPS in production
- Implement proper input validation
- Use prepared statements for database queries

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.
