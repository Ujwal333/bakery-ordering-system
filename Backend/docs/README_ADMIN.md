# Bakery Ordering System Admin Panel - Setup Guide

This document provides instructions for setting up and managing the production-ready Admin Panel for the Cinnamon Bakery system.

## 🚀 Quick Start

1. **Database Migrations**: Ensure all tables are up to date.
   ```bash
   php artisan migrate
   ```

2. **Seed Admin Account**: If you haven't already, seed the default superadmin.
   ```bash
   php artisan db:seed --class=AdminSeeder
   ```

3. **Access Admin Panel**:
   - URL: `/admin/login`
   - Default Email: `admin@bakery.com` (or Username: `superadmin`)
   - Default Password: `admin123`

## 📦 Key Features Implemented

### 1. Dashboard (Live Statistics)
- Dynamic calculation of Today's Revenue, Pending Orders, and Top Selling Products.
- Real-time order status tracking.

### 2. Order Management
- Full status lifecycle: Pending -> Confirmed -> Baking -> Out for Delivery -> Delivered.
- Nepal-specific address fields (Landmark, Area, City).
- Printable HTML Invoices for delivery staff.

### 3. Product & Category CRUD
- Category organization with activity status.
- Product management with multi-image gallery support.
- Soft Delete support (products are moved to trash, not permanently deleted).

### 4. Custom Cake Builder
- Specialized management for custom requests.
- Track flavors, frostings, and custom messages on cake.

### 5. Role-Based Access Control (RBAC)
- **Super Admin**: Full access to all modules, including Settings and Activity Logs.
- **Admin**: Access to Orders, Products, and Customers.
- **Staff**: View-only or restricted access (extensible via `CheckAdminRole` middleware).

### 6. Security
- Isolated `admin` guard using Laravel Auth.
- Manual Rate Limiting (5 attempts/min) to prevent brute-force attacks.
- Middleware protection on all administrative routes.

## 🛠 Management CLI
- To create a new admin manually:
  ```bash
  php artisan tinker
  >>> App\Models\Admin::create(['name'=>'Name', 'email'=>'email@test.com', 'username'=>'user', 'password'=>bcrypt('pass'), 'role'=>'admin']);
  ```

## 📂 File Structure
- **Controllers**: `app/Http/Controllers/Admin/`
- **Models**: `app/Models/` (Admin, Order, Product, etc.)
- **Migrations**: `database/migrations/`
- **Views**: `resources/views/admin/` & `resources/views/layouts/admin.blade.php`

---
*Built for Cinnamon Bakery Nepal - Production Ready*
