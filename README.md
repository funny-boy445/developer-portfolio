# Developer Portfolio

A professional developer portfolio built with PHP featuring a modern red/black design with full animations.

![image alt](https://github.com/hatim-ayyad/developer-portfolio/blob/d484b116d5fc6390a28bf1aad972ef8ba076ca84/assets/ui.png)

## Languages Used

PHP
MySQL
HTML
CSS
JavaScript

## Requirements
To run this application, you need the following:

PHP: Version 7.4 or higher.
MySQL: For the database.
Web server: Such as XAMPP, WAMP, or MAMP.
Composer: To manage dependencies (optional if already configured).

## Installation
### 1. Clone the Repository
Clone this project to your local machine using the following commands:

SSH:
```bash
git clone git@github.com:hatim-ayyad/developer-portfolio.git
```
HTTPS:
```bash
git clone https://github.com/hatim-ayyad/developer-portfolio.git
```
```bash
cd developer-portfolio
```
### 2. Install Dependencies
Use Composer to install required libraries:
```bash
composer install
```
### 3. Set Up the Database
Run the automatic setup script:
```bash
php setup-host.php
```
This script will:
Create a database named portfolio_db.
Create a table named portfolio_db with the necessary structure.
Create a contacts table for storing messages.

### 4. Configure the Database
Open the db.php file in the root directory.
Update the database credentials if necessary:
```bash
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'portfolio_db');
```

### 5. Configuration
Edit ```config.php``` to insert your personal details:

```bash
define('SITE_NAME', 'Your Name');
define('SITE_EMAIL', 'youremail@example.com');
define('SITE_PHONE', 'YOUR_NUMBER');
```

### 6. Customization
Modify ```main.php``` to update:

Skills and percentages

Project descriptions

Personal information

Social media links

## Contact Form
All contact form submissions are stored in the MySQL database. Messages include name, email, subject, message content, and timestamp.

## Browser Support
Works on all modern browsers including Chrome, Firefox, Safari, and Edge.

## License
This project is licensed under the MIT License. See the LICENSE file for details.
