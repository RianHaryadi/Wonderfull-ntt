<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Version"></a>
  <a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---

# 🌴 Wonderful Indonesia – NTT

A tourism web platform for **East Nusa Tenggara (NTT)** built using **Laravel 11**, **Tailwind CSS**, and **Vite**.  
This application allows users to explore destinations, book hotels, and join tour packages with ease.  
It includes a full admin dashboard, real-time transaction handling, and Midtrans payment integration.

---

## ✨ Features

- 🏝️ Destination listings by region  
- 🏨 Hotel booking with room type & availability control  
- 🎒 Tour package booking (grouped or per-item)  
- 🛒 Cart system with dynamic pricing and discounts  
- 💳 Payment via bank transfer or QRIS (Midtrans)  
- 🧾 Promo code integration  
- 📩 Email & WhatsApp notifications  
- 🎟️ QR Code ticketing & admin verification  
- 🔐 Admin panel powered by FilamentPHP  
- 📈 Exportable reports (PDF/Excel) for finance monitoring

---

## 🧭 Tech Stack

| Layer       | Stack                          |
|-------------|-------------------------------|
| Backend     | Laravel 11, FilamentPHP       |
| Frontend    | Blade, Tailwind CSS, Vite     |
| Database    | MySQL 8+                      |
| Payments    | Midtrans (Transfer & QRIS)    |
| Notifications | Laravel Mail, WhatsApp API |

---

## 📁 Folder Structure Overview

```plaintext
.
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Filament/
│   │   └── Resources/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   └── Providers/
├── bootstrap/
│   └── app.php
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
│   ├── web.php
│   └── api.php
├── storage/
├── tests/
│   ├── Feature/
│   └── Unit/
├── .env.example
├── artisan
├── composer.json
├── package.json
├── vite.config.js
⚙️ Project Setup
✅ Requirements
PHP ≥ 8.1

Composer 2.x

Node.js ≥ 16

MySQL 8 / PostgreSQL / SQLite

🛠 Installation Steps
bash
Copy code
# 1. Clone repository
git clone https://github.com/your-username/wonderful-ntt.git
cd wonderful-ntt

# 2. Install PHP dependencies
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Install JS dependencies & compile assets
npm install
npm run dev

# 5. Run migrations & seed data
php artisan migrate --seed

# 6. Start development server
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

FilamentPHP

Tailwind CSS

Midtrans Integration

📫 Contact
For contributions, support, or collaboration:

📧 Email: yourname@example.com

📱 WhatsApp: +62-812-xxxx-xxxx

🔐 Security
If you discover a security vulnerability, please report it via email.
For framework-level issues, refer to Laravel Security Policy.

🪪 License
This project is open-sourced under the MIT License.

✨ Feel free to fork, contribute, or customize this platform to fit your own region or tourism project!


---

### Kelebihan versi ini:
- Lebih estetis, profesional, dan informatif
- Struktur terorganisir dengan baik dan mudah di-scan
- Tabel stack teknologi
- Blok kode jelas & blok quote motivasional di akhir
- Bisa dipakai langsung di GitHub (tanpa edit tambahan)
