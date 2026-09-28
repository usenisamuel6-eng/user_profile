# User Profile System

A simple user profile management system built with PHP and MySQL. The project allows users to create an account, log in, view their profile information, update their details, upload a profile picture, and delete their account.

The project was built mainly as a practical PHP and MySQL project to understand how user authentication, sessions, database operations, file uploads, and basic CRUD operations work together.

## Features

- User registration
- User login and logout
- Session-based authentication
- Password hashing
- Profile information management
- Edit profile details
- Profile picture upload
- Email validation
- Duplicate email checking
- Account deletion
- MySQL database integration
- Prepared SQL statements
- Responsive interface
- Font Awesome icons
- Basic form validation and error messages

## Technologies Used

- **PHP** - Server-side programming
- **MySQL** - Database management
- **HTML5** - Page structure
- **CSS3** - Styling and responsive layout
- **Font Awesome** - Icons
- **Apache** - Local web server through XAMPP
- **phpMyAdmin** - Database management

## Project Structure


user_profile/
│
├── config/
│   └── db_connection.php
│
├── css/
│   └── style.css
│
├── includes/
│   ├── authentication.php
│   ├── header.php
│   └── footer.php
│
├── modules/
│   ├── login.php
│   ├── register.php
│   ├── profile.php
│   ├── edit_profile.php
│   ├── delete_account.php
│   └── logout.php
│
├── uploads/
│   └── profiles/
│       ├── user_1_abc123.jpg
│       ├── user_2_xyz456.png
│       └── ...
│
├── index.php
├── user_profile.sql
├── README.md
└── .gitignore
```

### Folder and File Description

| Folder/File | Purpose |
|---|---|
| `config/` | Contains database connection files. |
| `css/` | Contains the application's styling files. |
| `includes/` | Contains reusable files such as authentication, header, and footer. |
| `modules/` | Contains the main application pages and user operations. |
| `uploads/profiles/` | Stores uploaded profile images. |
| `index.php` | Landing page of the application. |
| `user_profile.sql` | Database structure and table definitions. |
| `README.md` | Project documentation. |
| `.gitignore` | Specifies files and folders that should not be tracked by Git. |

## How the Project Works

The application starts from `index.php`. From there, a user can either log in to an existing account or create a new account.

After registration, the user can log in. When the login details are correct, a PHP session stores the user's ID.

The session is then used to identify the logged-in user when accessing the profile and edit profile pages.

The general flow is:

```text
                ┌──────────────┐
                │   index.php  │
                └──────┬───────┘
                       │
              ┌────────┴────────┐
              │                 │
              ▼                 ▼
       Create Profile         Login
              │                 │
              ▼                 ▼
        register.php        login.php
              │                 │
              └────────┬────────┘
                       │
                       ▼
                 User Session
                       │
                       ▼
                  profile.php
                       │
                ┌──────┴──────┐
                │             │
                ▼             ▼
        edit_profile.php  delete_account.php
```

## Main Files

### `index.php`

This is the landing page of the application.

It introduces the profile system and provides links to either log in or create a profile. When a user is already logged in, the page provides a link to their profile.

### `config/db_connection.php`

This file handles the connection between PHP and MySQL.

The default local configuration uses:

```php
$host = "localhost";
$username = "root";
$password = "";
$database = "user_profile";
```

The connection is created using MySQLi.

### `includes/authentication.php`

This file protects pages that should only be available to logged-in users.

It starts a session when necessary and checks whether `user_id` exists in the session.

If the user is not logged in, they are redirected to the login page.

### `includes/header.php`

The header contains the common HTML structure used across the application.

It also:

- Starts the session when necessary
- Loads Font Awesome
- Loads the CSS file
- Displays the navigation
- Shows Profile and Logout links when a user is logged in

### `includes/footer.php`

The footer closes the main page structure and displays the current year.

### `modules/register.php`

This page handles new user registration.

The user provides:

- Full name
- Email address
- Phone number
- Password
- Password confirmation

The password is hashed before it is saved in the database.

The page also checks whether the email address is already registered.

### `modules/login.php`

This page handles user authentication.

The user enters their email and password. The application searches for the account and verifies the submitted password against the stored password hash.

When the password is correct, the user's ID is stored in the PHP session and the user is redirected to the profile page.

### `modules/profile.php`

This page displays the information belonging to the currently logged-in user.

It can display:

- Full name
- Email
- Phone number
- Gender
- Date of birth
- Country
- City
- State
- Address
- Profile picture

The page also provides options to edit the profile or delete the account.

### `modules/edit_profile.php`

This page allows the logged-in user to update their personal information.

The editable information includes:

- Full name
- Email
- Phone
- Gender
- Date of birth
- Address
- City
- State
- Country
- Profile picture

The page also handles profile image uploads.

## Profile Image Storage

Profile images are **not stored directly inside the MySQL database**.

The actual image is stored in:


uploads/
└── profiles/
    ├── user_1_abc123.jpg
    ├── user_2_xyz456.png
    └── ...
```

The database stores only the filename.

For example:


Database:
profile_image = user_1_abc123.jpg
```

The actual image is:


uploads/profiles/user_1_abc123.jpg
```

This allows the application to locate the image without putting the complete image file inside the database.

### Important

The `uploads/profiles/` folder should exist before testing the profile image upload feature.

If the folder is empty, a `.gitkeep` file can be placed inside it so Git keeps the folder:

```text
uploads/
└── profiles/
    └── .gitkeep
```

## `modules/logout.php`

This file logs the user out by clearing and destroying the current session.

The user is then redirected to the application's home page.

## `modules/delete_account.php`

This module handles account deletion.

It is intended to remove the user's account from the database and remove the associated profile picture from local storage.

## `css/style.css`

This file contains the styling for the application.

It includes styles for:

- Navigation
- Profile cards
- Forms
- Buttons
- Alerts
- Authentication pages
- Profile images
- Responsive layouts
- Mobile screens

The design is kept simple without depending on a large CSS framework.

## Database

The project uses a MySQL database called:
user_profile
```

The main table is:
users
```

The table contains fields such as:

| Field | Type | Description |
|---|---|---|
| `id` | INT | Unique user ID |
| `full_name` | VARCHAR(100) | User's full name |
| `email` | VARCHAR(100) | User's email address |
| `phone` | VARCHAR(20) | User's phone number |
| `gender` | VARCHAR(20) | User's gender |
| `date_of_birth` | DATE | User's date of birth |
| `address` | VARCHAR(255) | User's address |
| `city` | VARCHAR(100) | User's city |
| `state` | VARCHAR(100) | User's state |
| `country` | VARCHAR(100) | User's country |
| `password` | VARCHAR(255) | Hashed password |
| `profile_image` | VARCHAR(255) | Profile image filename |
| `created_at` | TIMESTAMP | Account creation time |
| `updated_at` | TIMESTAMP | Last update time |

The database structure is provided in `user_profile.sql`.

## Security Measures

### Password Hashing

Passwords are hashed before they are stored.

```php
password_hash($password, PASSWORD_DEFAULT);
```

During login, the password is checked using:

```php
password_verify($password, $user["password"]);
```

### Prepared Statements

Prepared statements are used for database queries that involve user input.

Example:

```php
$stmt = $conn->prepare(
    "SELECT id FROM users WHERE email = ?"
);

$stmt->bind_param("s", $email);
```

### Session Authentication

The user's ID is stored in a session after successful login.

Protected pages check:

```php
$_SESSION["user_id"]
```

before allowing the user to continue.

### Output Escaping

User information displayed on pages is passed through:

```php
htmlspecialchars()
```

This helps prevent user-supplied HTML from being interpreted as page content.

## How to Run the Project Locally Using XAMPP

### 1. Install XAMPP

Install XAMPP on your computer if it is not already installed.

XAMPP provides Apache, PHP, MySQL and phpMyAdmin for local development.

### 2. Start Apache and MySQL

Open the XAMPP Control Panel and start:

```text
Apache
MySQL
```

### 3. Download the Project

Clone the repository:

```bash
git clone https://github.com/usenisamuel6-eng/user_profile.git
```

You can also download the project as a ZIP file from GitHub and extract it.

### 4. Move the Project to `htdocs`

Copy the project folder into the XAMPP `htdocs` folder.

On Windows, the normal location is:

```text
C:\xampp\htdocs\
```

The project should therefore be located at:

```text
C:\xampp\htdocs\user_profile\
```

### 5. Create the Database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Create a database named:

```text
user_profile
```

Then import:

```text
user_profile.sql
```

The SQL file will create the required table and database structure.

### 6. Check the Database Connection

Open:

```text
config/db_connection.php
```

Make sure the database settings match your XAMPP MySQL configuration.

The common XAMPP settings are:

```php
$host = "localhost";
$username = "root";
$password = "";
$database = "user_profile";
```

### 7. Open the Application

Open your browser and visit:

```text
http://localhost/user_profile/
```

### 8. Test the Application

You can test the main features by:

1. Creating a new Profile.
2. Logging in.
3. Viewing the profile.
4. Editing the profile information.
5. Uploading a profile picture.
6. Checking that the picture appears on the profile.
7. Logging out.
8. Logging in again.
9. Testing account deletion if required.

## Common XAMPP Problems

### Apache is not starting

Another application may already be using the Apache ports.

Check the XAMPP Control Panel and make sure Apache is running.

### MySQL is not starting

Another MySQL or MariaDB service may already be using the MySQL port.

### Database connection error

Check:

```text
config/db_connection.php
```

and make sure the host, username, password and database name are correct.

### Page not found

Make sure the project is inside:

```text
C:\xampp\htdocs\
```

and open:

```text
http://localhost/user_profile/
```

### Profile image is not displaying

Check that:

```text
uploads/profiles/
```

exists and that the filename stored in the database matches the image filename in that folder.

## Future Improvements

The project currently covers the main requirements of a basic user profile system, but it can be improved further.

### 1. Better Image Validation

The upload system can be improved by checking the actual contents of an uploaded file using PHP functions such as `finfo_file()` or `getimagesize()`.

This is safer than relying mainly on the MIME type provided by the browser.

### 2. Cloudinary Integration

The current project stores profile pictures locally.

Cloudinary could be added later so that profile images are stored in cloud storage instead of the local `uploads` folder.

The database could then store the Cloudinary image URL or public ID.

### 3. Forgot Password

A password recovery feature can be added so users can reset their password through email.

### 4. Email Verification

Users could receive a verification email after registration.

### 5. Change Password

A separate page can be added for changing the account password.

### 6. CSRF Protection

CSRF tokens can be added to forms that change or delete user information.

### 7. Stronger Account Deletion

The application could require the user's password before permanently deleting the account.

### 8. Admin Dashboard

An admin section could be added to manage registered users.

An administrator could:

- View users
- Search users
- View profiles
- Edit users
- Delete accounts
- Monitor account activity

### 9. Role-Based Access

Different account roles such as `User` and `Admin` could be introduced.

### 10. Better Project Architecture

As the project becomes larger, the code could be reorganised using an MVC structure.

This would separate:

```text
Models
Views
Controllers
```

### 11. Database Migrations

Database migrations could be introduced to make future database changes easier to manage.

### 12. REST API

A REST API could be added so the profile system can later be connected to a mobile application or JavaScript frontend.

## Project Purpose

This project is mainly a practical PHP and MySQL project for learning how different parts of a web application work together.

It provides practice with:

- PHP
- MySQL
- CRUD operations
- Prepared statements
- Password hashing
- Sessions
- Authentication
- Form validation
- File uploads
- Responsive frontend development

It can also be used as a starting point for a larger user management application.

## Author

**Samuel Useni**

GitHub:

https://github.com/usenisamuel6-eng

Repository:

https://github.com/usenisamuel6-eng/user_profile

## Licence

This project is available for learning and personal development purposes.
