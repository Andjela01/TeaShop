# TeaShop

TeaShop is a web application for managing tea sales with different access levels for users. It follows the MVC architecture and is built using OOP PHP and Twig template engine.

## Features

### Guest Users
- Can browse available teas.
- Must register/login to make purchases.

### Registered Users
- Can purchase teas.
- Can manage their shopping cart (add/remove items).
- Can filter teas by type.
- Can register an account.

### Manager
- Can add and remove users.
- Can search for teas.
- Can view user activity logs.

### Admin
- Can add, edit, and delete users and teas.
- Can generate user reports (PDF).
- Can generate order reports (Excel).

## Technologies Used
- PHP (OOP)
- Twig Template Engine
- MySQL (Relational Database)
- MVC Architecture
- Logging System

## Setup Instructions
1. Clone the repository.
2. Configure database connection in `config.php`.
3. Import the provided SQL file to set up the database.
4. Start a local server (WAMP, XAMPP, etc.).
5. Access the application via browser.

## Usage
- Register or log in to access user features.
- Admin and Manager have additional functionalities based on their roles.

## License
This project is for educational purposes.

