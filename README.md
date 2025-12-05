# 🛒 Laravel Inventory Management System 📊

A **modern Laravel 12** application to manage **products, customers, sales**, and generate **reports**. Perfect for small businesses or internal tools. Features full **CRUD**, search functionality, authentication, and secure API endpoints.

---

## 🛠️ Technical Stack & Technologies Used

* **Laravel** simplifies backend logic, routing, and security.
* **Blade + Bootstrap** ensures a **fast, clean, and responsive UI**.
* **AJAX + jQuery** provides **dynamic page updates** without full page reloads, enhancing user experience.
* **MySQL** offers a **reliable relational database** for storing business-critical data.

---

## 📑 Table of Contents

- [✨ Features](#-features)
- [📸 Screenshots](#-screenshots)
- [⚙️ Installation](#-installation)
- [🛠️ Configuration](#-configuration)
- [🚀 Usage](#-usage)
- [🔗 Routes & API](#-routes--api)
- [🔐 Authentication & Authorization](#-authentication--authorization)
- [🧰 Artisan Commands](#-artisan-commands)
- [📜 License](#-license)

---

## ✨ Features

- 🔑 **User authentication & registration** with email verification 📧  
- 👤 **User profile management**: edit, update, delete  
- 🛍️ **Product Management**: add, edit, delete, list, and view individual products  
- 👥 **Customer Management**: add, edit, delete, list, and view individual customers  
- 💵 **Sales Management**: create, list, and track sales  
- 📊 **Dashboard & Reports**: overview of sales, top products, and customers  
- 🔍 **Search functionality**: search products and customers by keyword  
- 🗂️ **JSON API Endpoints**: fetch individual product/customer data  
- 🔒 **CSRF protection & secure session management**  
- 🌟 **Artisan inspire command**: motivational quotes in console  
- ✅ Fully responsive design (works on desktop & mobile)  

---

## 📸 Screenshots

| 📊 Dashboard | 🛍️ Products Page | 👥 Customers Page | 💵 Sales Page |
|-------------|-----------------|-----------------|---------------|
| ![Dashboard](screenshots/1.png) | ![Products Page](screenshots/2.png) | ![Customers Page](screenshots/3.png) | ![Sales Page](screenshots/4.png) |

---

## ⚙️ Installation

1. **Clone the repository**:

```bash
git clone https://github.com/your-username/laravel-sales-reports.git
cd laravel-sales-reports
````

2. **Install PHP & Node dependencies**:

```bash
composer install
npm install
npm run dev
```

3. **Configure environment**:

```bash
cp .env.example .env
php artisan key:generate
```

4. **Set up the database**:

```bash
php artisan migrate
php artisan db:seed
```

5. **Run the development server**:

```bash
php artisan serve
```

Visit 🌐 `http://localhost:8000`

---

## 🛠️ Configuration

Update `.env` with your database credentials and optional mail configuration:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 🚀 Usage

1. Access `/` → redirected to **Reports Page** 📈
2. Register or log in to access the application 🔑
3. Use the dashboard to view:

   * 💵 Total sales
   * 🛍️ Top products
   * 👥 Top customers
4. **Products**: create, edit, delete, search, and view individual JSON endpoint
5. **Customers**: create, edit, delete, search, and view individual JSON endpoint
6. **Sales**: record new sales and view sales history
7. Edit user profile at `/profile` 👤
8. Logout securely via `/logout` 🔒

---

## 🔗 Routes & API

### Web Routes (Authenticated)

| 🌐 URL              | ⚡ Method               | 🧩 Controller               | 📝 Description                        |
| ------------------- | ---------------------- | --------------------------- | ------------------------------------- |
| `/dashboard`        | GET                    | `ReportController@index`    | Main dashboard overview 📊            |
| `/reports`          | GET                    | `ReportController@index`    | Reports listing 📈                    |
| `/products`         | GET, POST, PUT, DELETE | `ProductController`         | CRUD operations for products 🛍️      |
| `/products/{id}`    | GET                    | `ProductController@show`    | Returns JSON details of a product 📦  |
| `/customers`        | GET, POST, PUT, DELETE | `CustomerController`        | CRUD operations for customers 👥      |
| `/customers/{id}`   | GET                    | `CustomerController@show`   | Returns JSON details of a customer 📦 |
| `/sales`            | GET, POST              | `SaleController`            | List and create sales 💵              |
| `/search/products`  | GET                    | `ProductController@search`  | Search products 🔍                    |
| `/search/customers` | GET                    | `CustomerController@search` | Search customers 🔎                   |
| `/profile`          | GET, PATCH, DELETE     | `ProfileController`         | View, update, or delete profile 👤    |

---

### API Responses (JSON)

#### Product Example

```json
{
  "id": 1,
  "name": "Product A",
  "price": 50.00,
  "stock": 100,
  "created_at": "2025-12-05T12:34:56",
  "updated_at": "2025-12-05T12:34:56"
}
```

#### Customer Example

```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "+123456789",
  "created_at": "2025-12-05T12:34:56",
  "updated_at": "2025-12-05T12:34:56"
}
```

---

## 🔐 Authentication & Authorization

* **Guest routes** 📝:

  * `register` 🆕
  * `login` 🔑
  * `forgot-password` 📧
  * `reset-password` 🔄

* **Authenticated routes** 🔒:

  * `dashboard` 📊
  * `profile` 👤
  * `products` 🛍️
  * `customers` 👥
  * `sales` 💵
  * `verify-email` ✅
  * `confirm-password` 🔐
  * `update-password` 🔄
  * `logout` 🔓

---

## 🧰 Artisan Commands

* `php artisan inspire` 🌟 – Displays an inspiring quote in the console 💡
* `php artisan migrate` 🗂️ – Runs database migrations
* `php artisan db:seed` 🌱 – Seeds the database with sample data

---

## 📜 License

Open project is licensed under the **MIT License** 📝. See the [LICENSE](LICENSE) file for details.

---
