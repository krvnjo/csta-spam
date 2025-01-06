# CSTA - SPAM (Capstone Project)

<img src="resources/img/github/banner-light.png" alt="Banner" style="width: 100%;">

This capstone project is titled "SPAM: Systematized Property and Assets Management for Colegio de Sta. Teresa de Avila".
It aims to create a management solution that improves the efficiency and accuracy of tracking the institution’s
property, equipment, and assets. The system features QR code generation for streamlined tracking for better
decision-making. The study demonstrates how systematic asset management enhances operational
efficiency, reduces errors, and supports optimal resource allocation.

## Main Features

- Dashboardd
- Item Inventory Management
- Borrowing and Reservation
- Repair and Maintenance
- Reports Generation
- User and Role Management
- File Maintenance
- Audit Trailing

## Tech Stack

**Frontend**

- **Languages:** HTML, CSS, JavaScript
- **CSS Framework:** Bootstrap 5 (v5.2)
- **JavaScript Library:** jQuery (v3.6)

**Backend**

- **Framework:** Laravel 11 (v11)
- **Language:** PHP (v8.2)
- **Server:** XAMPP (v3.3) (includes Apache and MariaDB (v10.4))
- **Version Control:** Git (v2.46)

**Tools & Libraries**

- **Package Managers:** npm (v10.9) and Composer (v2.8)
- **Code Editor:** PHPStorm (v2024.2)

**Other Technologies**

- **QR Code Generation:** QRCode.js / Laravel QR Code
- **Hardware:** Thermal Printer and QR Code Scanner

## Clone the Repository/Run Locally

Clone the project

```bash
  git clone https://github.com/krvnjo/csta-spam.git
```

Install dependencies

```bash
  npm install
  composer install
```

Copy the contents of .env.example

```bash
  cp .env.example .env
```

Generate a key

```bash
  php artisan key:generate
```

Migrate and seed database

```bash
  php artisan migrate
  php artisan db:seed
```

Run Vite

```bash
  npm run dev
```

Serve the project

```bash
  php artisan serve
```

## Authors/Developers

- Joshua Trazen Achondo - [@JayTee69](https://www.github.com/JayTee69) (GitHub)
- Rob Meynard Bunag - [@Roro2202](https://www.github.com/Roro2202) (GitHub)
- Khervin John Quimora - [@krvnjo](https://www.github.com/krvnjo) (GitHub)
