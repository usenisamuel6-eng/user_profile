# User Profile System

A simple user profile management system built with PHP and MySQL. The project allows users to create an account, log in, view their profile information, update their details, upload a profile picture, and delete their account.

## Features

User registration, login and logout, session-based authentication, password hashing, profile information management, edit profile details, profile picture upload, email validation, duplicate email checking, account deletion, MySQL database integration, prepared SQL statements, responsive interface, basic form validation and error messages.

## Technologies Used

**PHP** (server-side programming), **MySQL** (database management), **HTML5** (page structure), **CSS3** (styling and responsive layout), **Font Awesome** (icons), **Apache** (local web server through XAMPP), **phpMyAdmin** (database management).

## Project Structure

- `config/` - Contains database connection files.
- `css/` - Contains the application's styling files.
- `includes/` - Contains reusable files such as authentication, header, and footer.
- `modules/` - Contains the main application pages and user operations.
- `uploads/profiles/` - Stores uploaded profile images.
- `index.php` - Landing page of the application.
- `user_profile.sql` - Database structure and table definitions.

## Profile Image Storage

Profile images are **not stored directly inside the MySQL database**. The database stores only the filename, and the actual image is stored in `uploads/profiles/`.

**Important:** The `uploads/profiles/` folder should exist before testing the profile image upload feature.

## How to Run the Project Locally Using XAMPP

### 1. Install XAMPP
Install XAMPP on your computer if it is not already installed.
XAMPP provides Apache, PHP, MySQL and phpMyAdmin for local development.

### 2. Start Apache and MySQL
Open the XAMPP Control Panel and start Apache and MySQL.

### 3. Download the Project
Clone the repository: `git clone https://github.com/usenisamuel6-eng/user_profile.git`
You can also download the project as a ZIP file from GitHub and extract it.

### 4. Move the Project to `htdocs`
Copy the project folder into the XAMPP `htdocs` folder. On Windows, the normal location is `C:\xampp\htdocs\`
The project should therefore be located at `C:\xampp\htdocs\user_profile\`

### 5. Create the Database
Open phpMyAdmin at `http://localhost/phpmyadmin`
Create a database named `user_profile`, then import `user_profile.sql`
The SQL file will create the required table and database structure.

### 6. Check the Database Connection
Open `config/db_connection.php` and make sure the database settings match your XAMPP MySQL configuration.
The common XAMPP settings are:
- `$host = "localhost";`
- `$username = "root";`
- `$password = "";`
- `$database = "user_profile";`

### 7. Open the Application
Open your browser and visit `http://localhost/user_profile/`

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

- **Apache is not starting** - Another application may already be using the Apache ports. Check the XAMPP Control Panel and make sure Apache is running.
- **MySQL is not starting** - Another MySQL or MariaDB service may already be using the MySQL port.
- **Database connection error** - Check `config/db_connection.php` and make sure the host, username, password and database name are correct.
- **Page not found** - Make sure the project is inside `C:\xampp\htdocs\` and open `http://localhost/user_profile/`
- **Profile image is not displaying** - Check that `uploads/profiles/` exists and that the filename stored in the database matches the image filename in that folder.

## Future Improvements

1. **Better Image Validation** - The upload system can be improved by checking the actual contents of an uploaded file using PHP functions such as `finfo_file()` or `getimagesize()`. This is safer than relying mainly on the MIME type provided by the browser.
2. **Cloudinary Integration** - The current project stores profile pictures locally. Cloudinary could be added later so that profile images are stored in cloud storage instead of the local `uploads` folder. The database could then store the Cloudinary image URL or public ID.
3. **Forgot Password** - A password recovery feature can be added so users can reset their password through email.
4. **Email Verification** - Users could receive a verification email after registration.
5. **Change Password** - A separate page can be added for changing the account password.
6. **CSRF Protection** - CSRF tokens can be added to forms that change or delete user information.
7. **Stronger Account Deletion** - The application could require the user's password before permanently deleting the account.
8. **Admin Dashboard** - An admin section could be added to manage registered users. An administrator could view users, search users, view profiles, edit users, delete accounts, and monitor account activity.
9. **Role-Based Access** - Different account roles such as `User` and `Admin` could be introduced.
10. **Better Project Architecture** - As the project becomes larger, the code could be reorganised using an MVC structure. This would separate Models, Views, and Controllers.
11. **Database Migrations** - Database migrations could be introduced to make future database changes easier to manage.
12. **REST API** - A REST API could be added so the profile system can later be connected to a mobile application or JavaScript frontend.

## Author
**Samuel Useni**
GitHub: https://github.com/usenisamuel6-eng
Repository: https://github.com/usenisamuel6-eng/user_profile
