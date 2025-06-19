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



### 1. Input Validation & Output Escaping

- **Form Request Validation:**  
  All user input (registration, login, to-do CRUD, admin actions) is validated using Laravel Form Request classes in `app/Http/Requests/`. For example, `LoginRequest` and other custom requests define strict validation rules, including regex for names and emails. This ensures only expected, safe data is processed and blocks malicious input at the controller level.
- **Regex Whitelisting:**  
  Names and other sensitive fields are validated with regex in the request classes to allow only safe characters (e.g., A-Z, a-z). This is enforced in the `rules()` method of each Form Request.
- **Output Escaping:**  
  All dynamic output in Blade templates uses `{{ }}` for automatic HTML escaping, preventing XSS. No unescaped output is rendered. Blade templates are in `resources/views/`.

---

### 2. Multi-Factor Authentication (MFA) & Authentication Security

- **Email-based MFA:**  
  After password login, users must enter a 6-digit code sent to their email. This is implemented in `app/Actions/Fortify/SendEmailMfaCode.php`, which generates a code, stores it in the user record (`mfa_code`, `mfa_expires_at`), and sends it using the `EmailMfaCode` notification (`app/Notifications/EmailMfaCode.php`). The user is redirected to `/mfa` and must enter the code, which is verified in `MfaController` before login is completed. Mailtrap is used for safe email testing in development and to generate the code.
- **Session Isolation:**  
  The user is logged out after password check and before MFA (see `SendEmailMfaCode`), so no session is established until MFA is complete. The user ID is stored in the session as `mfa_user_id` for the challenge step only.
- **Password Hashing & Salting:**  
  Passwords are hashed using Bcrypt/Argon2 (Laravel default). A unique salt is generated and stored per user in the `users` table, and is prepended to the password before hashing and checking (see `FortifyServiceProvider`).
- **Rate Limiting:**  
  Login attempts are limited (3 per minute) using Laravel's RateLimiter, configured in `FortifyServiceProvider` with `RateLimiter::for('login', ...)`.

---

### 3. Role-Based Access Control (RBAC) & Permissions

- **RBAC Implementation:**  
  Users are assigned roles (User/Admin) via the `user_roles` table, and permissions are managed in `role_permissions`. Eloquent relationships are defined in `User`, `UserRole`, and `RolePermission` models (`app/Models/`).
- **Permission Enforcement:**  
  Controllers (e.g., `AdminController`, `TodoController`) and Blade templates check permissions and roles before allowing access to admin/user actions. Unauthorized actions are blocked at both the UI (Blade) and controller (middleware/checks) level. For example, only admins see user management buttons in `admin/dashboard.blade.php`.
- **Admin Controls:**  
  Admins can activate/deactivate/delete users, assign tasks, and manage permissions from a protected dashboard. These actions are only available to users with the `admin` role and the correct permissions, enforced in both routes and controllers.

---

### 4. Web Security Headers & Defenses

- **Content Security Policy (CSP):**  
  Enforced using [spatie/laravel-csp](https://spatie.be/docs/laravel-csp), configured in `config/csp.php` and enabled in middleware. This restricts scripts/styles to trusted sources and mitigates XSS.
- **XSS Defense:**  
  All user output is escaped using Blade, and all input is validated and sanitized in Form Requests and controllers.
- **CSRF Protection:**  
  All forms use `@csrf` and CSRF middleware is always enabled. AJAX requests include CSRF tokens. This is handled automatically by Laravel and visible in all Blade forms.

---

### 5. Additional Security Best Practices

- **Session Security:**  
  Sessions are stored securely using the database driver (see `.env` and `config/session.php`), and session data is cleared on logout and after MFA. Session fixation is prevented by regenerating session IDs after login.
- **Error Handling:**  
  Sensitive errors are never shown to users; debug is off in production (`APP_DEBUG=false`).
- **Database Security:**  
  All database access uses Eloquent ORM or parameterized queries, preventing SQL injection.
- **User Enumeration Defense:**  
  Login errors are generic and do not reveal if a user/email exists, preventing attackers from enumerating valid accounts.

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