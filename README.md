# Laravel CRUD To-Do App

A secure Laravel-based To-Do application with user authentication, full CRUD functionality, and multiple layers of security.

---

## 🚀 Features

- User Registration & Login (Auth)
- Create, Read, Update, Delete To-Do items
- Mark items as completed or pending
- Role-Based Access Control (RBAC) for Users and Admins
- Secure authentication and authorization
- Security best practices implemented

---

## 🛡️ Security Measures

### 1. Input Validation

- **Registration and Login** use Laravel Form Request classes for validation.
- **Regex whitelisting**: Names only accept A-Z and a-z using regex in the `rules()` function.
- **Reference**: [Laravel Form Request Validation](https://laravel.com/docs/validation#form-request-validation)

---

### 2. Multi-Factor Authentication (MFA), Password Security, and Rate Limiting

- **MFA**: Implemented using [Laravel Fortify](https://laravel.com/docs/fortify), with email-based verification codes.
- **Password Hashing**: Passwords are hashed using Bcrypt or Argon2 (Laravel default).
- **Rate Limiting**: Login attempts are limited to 3 failed attempts using Laravel's RateLimiter.
- **Password Salting**: A random alphanumeric salt is generated and stored in the users table, and used in password hashing.

---

### 3. Authorization and Role-Based Access Control (RBAC)

- **Authentication Required**: All users must log in before accessing To-Do features.
- **RBAC**: Users are assigned roles (User or Admin) and redirected accordingly after login.
    - **Users**: Access To-Do CRUD operations.
    - **Admins**: Manage users, activate/deactivate accounts, view all users' To-Do lists, and manage permissions.
- **UserRoles Table**: Stores RoleID, UserID, RoleName, Description.
- **RolePermissions Table**: Stores PermissionID, RoleID, Description (CRUD).
- **Permission Enforcement**: UI elements (e.g., "New Task" button) are shown/hidden based on user permissions.

---

### 4. Web Security Headers and Defenses

- **Content Security Policy (CSP)**: Enforced using [spatie/laravel-csp](https://spatie.be/docs/laravel-csp), following Laravel's official documentation. This ensures compliance with the same-origin policy and mitigates XSS risks.
- **XSS Defense**: All user output is escaped using Blade's `{{ }}` syntax. No unescaped output is rendered. Input is validated and sanitized.
- **CSRF Protection**: All forms include `@csrf` and CSRF middleware is enabled by default. AJAX requests include CSRF tokens in headers.

---

## 🛠 Tech Stack

- **Framework**: Laravel 10+
- **Language**: PHP 8+
- **Database**: MySQL / SQLite
- **Frontend**: Blade Templates, Bootstrap (optional)
- **Auth**: Laravel UI / Fortify

---

## 📦 Installation & Setup

### 1. Clone the Repository

```bash
git clone git@github.com:dinni3/todoapp2.git
cd todoapp2
```

### 2. Install dependencies

```bash
composer install
npm install && npm run dev
```

### 3. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Update `.env` file with your DB credentials:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Start the application

```bash
php artisan serve
```

Visit http://127.0.0.1:8000

---

## Authentication Scaffolding

If not already installed:

```bash
composer require laravel/ui
php artisan ui bootstrap --auth
npm install && npm run dev
```

---

## 📄 License

This project is open-source and free to use under the MIT license.