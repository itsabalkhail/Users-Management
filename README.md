# User Management System

A simple, secure PHP-based user management system with MySQL database integration. This project provides a clean interface for managing users with features like adding new users, viewing user lists, and toggling user status.

![](https://github.com/itsabalkhail/Users-Management/blob/main/Screenshot%202025-07-16%20174228.png?raw=true)

## Features

- **Add New Users**: Simple form to add users with name and age validation
- **View Users**: Display all users in a clean, responsive table
- **Toggle Status**: AJAX-powered status toggle (Active/Inactive) without page refresh
- **Input Validation**: Server-side validation for all user inputs
- **SQL Injection Protection**: Uses prepared statements for secure database operations
- **Responsive Design**: Mobile-friendly interface with modern styling
- **Connection Testing**: Built-in database connection diagnostic tool
- **Bilingual Support**: Arabic and English text support

## Tech Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, JavaScript
- **Server**: Apache/Nginx (XAMPP, WAMP, or similar)

## Project Structure

```
user-management-system/
├── config.php          # Database configuration and connection
├── index.php           # Main page with user form and list
├── insert.php          # Handle user insertion
├── toggle.php          # Handle status toggle via AJAX
├── test_connection.php # Database connection testing tool
├── users.sql           # Database schema and sample data
└── README.md           # This file
```

## Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7+ or MariaDB 10.4+
- Apache/Nginx web server
- XAMPP, WAMP, or similar local development environment

### Setup Steps

1. **Clone or download** the project files to your web server directory
   ```bash
   # If using XAMPP
   /xampp/htdocs/user-management-system/
   
   # If using WAMP
   /wamp/www/user-management-system/
   ```

2. **Start your web server** and MySQL service
   - Start Apache
   - Start MySQL

3. **Create the database**
   - Open phpMyAdmin or MySQL command line
   - Create a new database named `mydb`
   - Import the `users.sql` file to create the table structure

4. **Configure database connection**
   - Open `config.php`
   - Update database credentials if needed:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'mydb');
   ```

5. **Test the installation**
   - Navigate to `http://localhost/user-management-system/test_connection.php`
   - Verify database connection and table structure

6. **Access the application**
   - Open `http://localhost/user-management-system/index.php`

## Database Schema

The system uses a simple `users` table with the following structure:

```sql
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);
```

### Field Descriptions

- `id`: Auto-increment primary key
- `name`: User's name (max 50 characters)
- `age`: User's age (1-120 range)
- `status`: User status (0 = Inactive, 1 = Active)
- `created_at`: Record creation timestamp

![](https://github.com/itsabalkhail/Users-Management/blob/main/Screenshot%202025-07-15%20180349.png?raw=true)

## Usage

### Adding a New User

1. Fill in the user's name and age in the form
2. Click "إضافة مستخدم" (Add User)
3. The system validates input and adds the user to the database

### Viewing Users

- All users are displayed in a table below the form
- Shows ID, Name, Age, Status, and Action buttons
- Users are ordered by ID (newest first)

### Toggling User Status

- Click the "Toggle Status" button next to any user
- Status changes between Active/Inactive without page refresh
- Changes are reflected immediately in the interface

### Testing Database Connection

- Visit `test_connection.php` to diagnose database issues
- Shows connection status, table structure, and sample data

## Security Features

- **Prepared Statements**: All database queries use prepared statements to prevent SQL injection
- **Input Sanitization**: All user inputs are sanitized using `htmlspecialchars()`, `trim()`, and `stripslashes()`
- **Data Validation**: Server-side validation for all form inputs
- **Error Handling**: Comprehensive error handling with user-friendly messages

## Validation Rules

### Name Validation
- Required field
- Minimum 2 characters
- Maximum 100 characters
- HTML entities escaped

### Age Validation
- Required field
- Must be between 1 and 120
- Integer type validation

## Customization

### Styling
- Modify the CSS in `index.php` to change the appearance
- Responsive design adapts to different screen sizes
- Color scheme can be easily customized

### Database Configuration
- Update `config.php` for different database settings
- Change database name, host, credentials as needed

### Language Support
- Currently supports Arabic and English
- Text can be easily modified in the HTML sections

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check if MySQL service is running
   - Verify database credentials in `config.php`
   - Ensure database `mydb` exists

2. **Table Not Found**
   - Import the `users.sql` file
   - Check table name and structure

3. **Permission Errors**
   - Ensure proper file permissions
   - Check web server user permissions

4. **AJAX Not Working**
   - Check browser console for JavaScript errors
   - Verify `toggle.php` is accessible

### Debug Tools

- Use `test_connection.php` to diagnose database issues
- Check browser developer tools for JavaScript errors
- Enable PHP error reporting for development

## Browser Compatibility

- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+
- Internet Explorer 11+ (limited support)

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is open source and available under the MIT License.

## Support

For issues or questions:
- Check the troubleshooting section
- Review the code comments
- Test with `test_connection.php`

---

**Note**: This is a basic user management system intended for learning purposes. For production use, consider adding additional security measures, user authentication, and more robust error handling.
