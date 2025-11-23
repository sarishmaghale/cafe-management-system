# ☕ Cafe Management System

A modern Laravel-based Cafe Management System designed to help cafe owners manage menus, orders, customers, and AI-generated social media content.  
The project runs inside **Docker for Laravel**, while the database is hosted **externally (Aiven MySQL)** or can be replaced with any other MySQL server.

---

## 🛠️ Setup Tutorial

This project has:

-   A **Dockerfile** and **docker-compose.yml** to run the Laravel application
-   An **external MySQL database** (hosted in Aiven)

Follow these steps to get started:

---

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/sarishmaghale/cafe-management-system.git
cd cafe-management-system

```

### 2️⃣ Configure Environment

```bash
cp .env.example .env

```

open .env and update your external database credentials

### 3️⃣ Start Docker Container

```bash
docker-compose up -d --build
```

Run migrations and seeders inside the container to set up your database

```bash
docker exec -it laravel_app php artisan migrate --seed

```

```

```
