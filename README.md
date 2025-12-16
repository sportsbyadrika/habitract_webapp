# SaaS Association Management (PHP MVC)

A lightweight MVC starter for managing associations, members, and role-based dashboards with secure authentication.

## Requirements
- PHP 8.2+
- MySQL 8+
- Composer (optional for future packages)

## Setup
1. Copy `.env` variables or update `config/config.php` with your database credentials.
2. Create the database and run the schema script:
   ```sql
   SOURCE database/schema.sql;
   ```
3. Serve the application (example using PHP's built-in server):
   ```bash
   php -S localhost:8000 -t public
   ```
4. Visit `http://localhost:8000` to log in. Use the Super Admin portal at `/super-admin/register` to create users with Argon2id-hashed passwords.

## Security
- Sessions configured with `httponly`, `secure`, and `samesite=strict` cookies.
- CSRF tokens on all forms.
- Output escaping via `Security::sanitize`.
- Passwords hashed with `password_hash(..., PASSWORD_ARGON2ID)`.
- Prepared PDO statements for all database interactions.

## Structure
- `public/` – Front controller and route definitions.
- `app/Core` – Router, database connector, autoloader, and security utilities.
- `app/Controllers` – MVC controllers for auth and dashboards.
- `app/Models` – Database models using prepared statements.
- `app/Views` – PHP templates styled with Tailwind CSS.
- `database/schema.sql` – MySQL schema for users, associations, and members.
- `tailwind.config.js` – Tailwind purge configuration for the views.
