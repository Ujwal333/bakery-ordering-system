# 🥐 Bakery Ordering System

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

Welcome to the **Bakery Ordering System**, a comprehensive, full-stack application built with Laravel designed to streamline operations for modern bakeries. This system handles everything from managing customer orders (both dine-in and delivery) to processing secure payments via local gateways. 

This repository highlights strong back-end logic, database design, payment integrations, and system administration skills.

## ✨ Core Features
- **Intelligent Order Management**: Track order statuses seamlessly, branching logic for Dine-in ("Ready for Handover", "Served") vs. Delivery.
- **Payment Gateway Integration**: Secure and verified transaction flows utilizing **eSewa** and **Khalti** APIs.
- **Admin Dashboard**: Comprehensive sales tracking with visual graphs, reflecting real-time sales data accurately linked to completed payment gateways.
- **Table Management**: Automated system to lock tables when a dine-in order starts and free them upon "Served" or "Cancelled" statuses.
- **Cart & Checkout Logic**: Robust, state-managed shopping cart logic handling discounts and pricing variations.

## 🗂️ Clean Repository Structure
To maintain a high professional standard, this project distinguishes application source code from deployment, maintenance, and setup utilities.

```text
📂 bakery-ordering-system/
├── 📂 Backend/                 # Primary Laravel Application Source Code
│   ├── 📂 docs/                # Project Reports, Delivery Checklists, Deployment Summaries
│   ├── 📂 scripts/             # Maintenance, Setup, and Database Migration utilities
│   │   ├── database_sql/       # Raw SQL dumps for fast seeding/restoring
│   │   ├── database_backups/   # JSON & SQLite backup states
│   │   ├── maintenance/        # Diagnostics, table checkers, & audit scripts
│   │   └── setup/              # Configuration (ps1, bat, sh) setups
│   └── 📂 app, config ...      # Standard Laravel MVC Directories
├── 📂 assets/                  # External marketing screens / UI Mockups
├── 📂 database_dumps/          # Global Database schema reference
└── 📂 scripts/                 # Utility layout formatters
```

## 🚀 Quick Start / Local Setup

If you are evaluating this project, you can get the Laravel backend up and running easily:

1. **Clone the repository**
   ```bash
   git clone https://github.com/Ujwal333/bakery-ordering-system.git
   cd bakery-ordering-system/Backend
   ```
2. **Install Dependencies**
   ```bash
   composer install
   npm install && npm run dev
   ```
3. **Environment Setup**
   Copy `.env.example` to `.env` and configure your database settings.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. **Database Migration**
   Execute migrations (or use the provided SQL dumps in `Backend/scripts/database_sql/`).
   ```bash
   php artisan migrate --seed
   ```
5. **Run the Application**
   ```bash
   php artisan serve
   ```

## 🛠️ Testing & Maintenance
Inside `Backend/scripts/maintenance`, there are multiple custom-built diagnostics scripts (`check_payments.php`, `test_cart_logic.php`, `audit_system.php`). 
Rather than manually debugging the database on the fly, these scripts embody a mature CI/CD mindset, enabling immediate validation of schema integrity, cart states, and payment verifications.

---
*Created and maintained by Ujwal. Showcasing robust systems architecture, API integration, and clean code principles.*
