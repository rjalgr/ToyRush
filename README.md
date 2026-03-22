# ToyRush PH — Laravel E-Commerce

A full-featured toy e-commerce web application built with **Laravel 11**, featuring separate **Admin** and **User** panels with complete **CRUD** operations backed by **MySQL**.

---

## Preview

> A modern toy store with product listings, cart, checkout, and admin management.

---

## Features

### User Side
- Browse products by category
- Search and filter products (price, category, sort)
- Product detail page with related products
- Shopping cart (add, update quantity, remove, clear)
- Checkout with shipping info and payment method selection
- Order history and order detail view with status timeline
- User profile page with stats and recent orders
- Register and login with eye toggle password visibility

### 🔧 Admin Panel
- Dashboard with stats (users, products, orders, revenue)
- **Products** — Create, Read, Update, Delete + image upload
- **Categories** — Create, Read, Update, Delete
- **Orders** — View, update order & payment status, delete
- **Users** — Create, Read, Update, Delete + role management

---

## Database Schema

| Table | Description |
|---|---|
| `users` | Customers and admins with role-based access |
| `categories` | Product categories |
| `products` | Toys with price, stock, age range, images |
| `orders` | Customer orders with shipping info |
| `order_items` | Individual items per order |
| `cart_items` | Active cart items per user |

---

##  Roles & Access

| Role | Access |
|---|---|
| **Guest** | Browse shop, view products |
| **User** | Cart, checkout, orders, profile |
| **Admin** | Full admin panel + all user features |

---

## ⚙️ Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 11 |
| Database | MySQL |
| Frontend | Bootstrap 5.3 + Bootstrap Icons |
| Auth | Laravel built-in session auth |
| Storage | Laravel Storage (local disk) |
| PHP | 8.2+ |

---

## Installation

### 1. Clone the repository
```bash
git clone https://github.com/your-username/toyrush-ph.git
cd toyrush-ph
```

### 2. Install dependencies
```bash
composer install
```

### 3. Environment setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=toy_ecommerce
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Create the database
```sql
CREATE DATABASE toy_ecommerce CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Run migrations and seed
```bash
php artisan migrate --seed
```

### 7. Storage link
```bash
php artisan storage:link
```

### 8. Start the server
```bash
php artisan serve
```

Visit **http://127.0.0.1:8000**

---

## Demo Accounts

| Role | Email | Password |
|---|---|---|
| Admin | admin@toyshop.com | password |
| User | user@toyshop.com | password |

---

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/         # Dashboard, Products, Categories, Orders, Users
│   │   ├── Auth/          # Login, Register, Logout
│   │   └── User/          # Shop, Cart, Orders, Profile
│   └── Middleware/
│       └── AdminMiddleware.php
└── Models/
    ├── User.php
    ├── Category.php
    ├── Product.php
    ├── Order.php
    ├── OrderItem.php
    └── CartItem.php

database/
├── migrations/            # 5 migration files
└── seeders/
    └── DatabaseSeeder.php # Demo data

resources/views/
├── layouts/               # app.blade.php, admin.blade.php
├── auth/                  # login, register
├── admin/                 # dashboard, products, categories, orders, users
└── user/                  # home, shop, cart, orders, profile

routes/
└── web.php
```

---

## Sample Seed Data

- **6 Categories** — Action Figures, Board Games, Educational Toys, Stuffed Animals, Building Blocks, Remote Control
- **12 Products** — with prices, stock levels, age ranges, and sale prices
- **2 Users** — 1 Admin + 1 Customer

---

## License

This project is open-source and available under the [MIT License](LICENSE).

---
