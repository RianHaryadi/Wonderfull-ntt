![Laravel Logo](https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg)

[![Build Status](https://github.com/laravel/framework/workflows/tests/badge.svg)](https://github.com/laravel/framework/actions)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/framework)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/framework)](https://packagist.org/packages/laravel/framework)
[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/framework)

---

# 🌴 Wonderful Indonesia – NTT

A tourism web platform for **East Nusa Tenggara (NTT)** built with **Laravel 10**, **Tailwind CSS**, and **Vite**.  
This application promotes cultural destinations, offers hotel booking, and allows users to book tour packages via a simple UI with an admin backend.

---

## ✨ Features

- 🏝️ Explore curated destinations in NTT  
- 🏨 Book hotels by room type with real-time availability  
- 🎒 Select & reserve tour packages (built-in or custom)  
- 📦 Dynamic cart & transaction system  
- 💳 Payment via Transfer or QRIS (Midtrans integration)  
- 🧾 Discount system using promo codes  
- 📩 Email and WhatsApp notifications for payment status  
- 📄 QR Code ticketing & admin validation  
- 🔐 Admin dashboard using FilamentPHP  
- 📊 Printable and exportable reports for admin

---

## 🧭 Tech Stack

- Backend: **Laravel 10**, **FilamentPHP**
- Frontend: **Tailwind CSS**, **Blade**, **Vite**
- Database: **MySQL 8+**
- Payment: **Midtrans (Transfer & QRIS)**
- Notification: **Email & WhatsApp API**

---

## 📁 Folder Structure Overview

├── app/
│ ├── Models/
│ ├── Http/Controllers/
│ └── Filament/Resources/
├── database/
│ └── migrations/
├── public/
├── resources/
│ └── views/
├── routes/
│ └── web.php
├── .env.example
├── vite.config.js

yaml
Copy code

---

## ⚙️ Setup Instructions

### ✅ Requirements

- PHP 8.1+
- Composer 2+
- Node.js 16+
- MySQL or compatible DB

### 🛠 Installation

```bash
# Clone the repo
git clone https://github.com/your-username/wonderful-ntt.git
cd wonderful-ntt

# Install backend dependencies
composer install

# Copy and setup environment
cp .env.example .env
php artisan key:generate

# Install frontend dependencies
npm install
npm run dev

# Run migration & seeder
php artisan migrate --seed

# Start server
php artisan serve
🧪 Testing
bash
Copy code
php artisan test
📦 Production Build
bash
Copy code
npm run build
📘 Learn More
Laravel Documentation

FilamentPHP Docs

Tailwind CSS Docs

Midtrans API Docs

📫 Contact
For collaboration or technical inquiries:

Email: yourname@example.com

WhatsApp: +62-812-xxxx-xxxx

🔐 Security
If you discover a security vulnerability, please report it to: security@laravel.com

🪪 License
This project is open-sourced under the MIT License.

yaml
Copy code

---

📌 **Cara pakai**:
1. Buka proyek kamu di GitHub
2. Tambahkan file baru `README.md`
3. Paste semua isi di atas
4. Komit dan push
