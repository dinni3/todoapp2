<<<<<<< HEAD
# todoapp2
A simple todo app using php, blade, laravel. This app is created to help me learn more about security.
=======
<<<<<<< HEAD
# todoapp2
A simple todo app using php, blade, laravel. This app is created to help me learn more about security.

# ✅ Laravel CRUD Todo App

A simple Laravel-based To-Do application with user authentication and full CRUD (Create, Read, Update, Delete) functionality.

---

## 🚀 Features

- ✅ User Registration & Login (Auth)
- 📝 Create new To-Do items
- ✏️ Edit existing To-Do items
- ✅ Mark items as completed or pending
- ❌ Delete To-Do items
- 🔒 Authenticated routes for to-do access

---

## 🛠 Tech Stack

- **Framework**: Laravel 10+
- **Language**: PHP 8+
- **Database**: MySQL / SQLite
- **Frontend**: Blade Templates, Bootstrap (optional)
- **Auth**: Laravel UI (basic scaffolding)

---

## Updates

## Features
- Added migrations for new tables (e.g., `todos`, `sessions`, `password_reset_tokens`)
- Updated existing tables with new columns like `nickname`, `avatar`, etc.


## 📦 Installation & Setup

### 1. Clone the Repository

```bash
git clone git@github.com:dinni3/todoapp2.git
cd todoapp2

### 2. Install dependencies

```bash
composer intall
npm install && npm run dev

### 3. Configure Environment

```bash
cp .env.example .env
php artisan key generate

### 4. Update env file with your DB credentials:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

### 5. Run Migrations

```bash
php artisan migrate

### 6. Start the application

```bash
php artisan serve

Visit http://127.0.0.1:8000

## Authentication Scaffolding

If not already installed

```bash
composer require laravel/ui
php artisan ui bootstrap --auth
npm install && npm run dev


##License

This project is open-source and free to use under the MIT license.

