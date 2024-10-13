# CSTA - SPAM (Capstone Project)

<img src="resources/img/github/banner-light.png" alt="Banner" style="width: 100%;">

This capstone project is titled "SPAM: Systematized Property and Assets Management for Colegio de Sta. Teresa de Avila". It aims to create a management solution that improves the efficiency and accuracy of tracking the institution’s property, equipment, and assets. The system features QR code generation for streamlined tracking and prescriptive analytics for better decision-making. The study demonstrates how systematic asset management enhances operational efficiency, reduces errors, and supports optimal resource allocation.


## Main Features

- Item Inventory Management
- Forms/Requisitions Builder
- Borrowing and Reservation
- Repair Management
- Dashboard w/ Prescriptive Analytics
- Reports Generation
- User Management
- File Settings & Maintenance
- Audit Trailing


## Tech Stack

**Frontend**
- **Languages:** HTML, CSS, JavaScript
- **CSS Framework:** [Bootstrap 5](https://getbootstrap.com/) (v5.2.2)
- **JavaScript Library:** [jQuery](https://jquery.com/) (v3.6.0)

**Backend**
- **Framework:** [Laravel 11](https://laravel.com/) (v11.21.0)
- **Language:** PHP (v8.2.12)
- **Server:** [XAMPP](https://www.apachefriends.org/index.html)(v3.3.0) (includes [Apache](https://httpd.apache.org/) and [MySQL](https://www.mysql.com/) with [MariaDB](https://mariadb.org/) (v10.4.32))

**DevOps**
- **Version Control:** [Git](https://git-scm.com/) (v2.46.0)

**Tools & Libraries**
- **Package Managers:** [npm](https://www.npmjs.com/) (v10.8.1) and [Composer](https://getcomposer.org/) (v2.7.7)
- **Code Editor:** [PHPStorm](https://www.jetbrains.com/phpstorm/) (v2024.2)

**Other Technologies**
- **QR Code Generation:** [QRCode.js](https://github.com/davidshimjs/qrcodejs) / [Laravel QR Code](https://github.com/simple-qrcode)
- **Hardware:** Thermal Printer, QR Code Scanner (optional)


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

Migrate the database

```bash
  php artisan migrate
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
