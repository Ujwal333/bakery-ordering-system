# 🚀 BAKERY ORDERING SYSTEM - QUICK SETUP & VERIFICATION GUIDE

**Date:** January 10, 2026  
**Status:** Production Ready  
**Estimated Setup Time:** 15 minutes

---

## STEP 1: DATABASE SETUP (5 minutes)

### Option A: Using phpMyAdmin (Recommended for Windows/XAMPP)

1. **Open phpMyAdmin**
   - URL: `http://localhost/phpmyadmin`
   - Log in with your MySQL credentials

2. **Import Database**
   - Click "Import" tab at top
   - Click "Choose File" 
   - Select: `Backend/import.sql`
   - Click "Go"
   - Wait for completion message ✅

3. **Verify Import**
   - Left sidebar should show: `bakery_ordering_system`
   - Click database name
   - Should see 22 tables listed

### Option B: Using MySQL Command Line

```bash
# Navigate to project directory
cd c:\xampp\htdocs\bakery-ordering-system\Backend

# Import database
mysql -u root -p < import.sql

# When prompted, enter MySQL password (usually blank for XAMPP)
```

### Option C: Using Laravel Artisan

```bash
# From Backend directory
cd Backend

# Run migrations (if .sql method doesn't work)
php artisan migrate

# Seed demo data
php artisan db:seed
```

---

## STEP 2: ENVIRONMENT CONFIGURATION (3 minutes)

1. **Check .env file**
   ```bash
   cd Backend
   # File should already exist, verify contents:
   ```

2. **Verify Database Connection**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bakery_ordering_system
   DB_USERNAME=root
   DB_PASSWORD=        (blank for XAMPP)
   ```

3. **Test Connection**
   ```bash
   php artisan tinker
   
   # In tinker console:
   > DB::connection()->getPdo()
   > exit  (should show PDO object, not error)
   ```

---

## STEP 3: SERVER STARTUP (2 minutes)

### Method 1: Using XAMPP Control Panel
- Open XAMPP Control Panel
- Click "Start" next to Apache
- Click "Start" next to MySQL
- Verify both show "Running" ✅

### Method 2: Using Command Line
```bash
# Terminal/PowerShell:
cd c:\xampp

# Start Apache and MySQL
.\xampp_start.exe
```

### Method 3: Using Laravel's Built-in Server
```bash
cd Backend

# This runs on http://localhost:8000
php artisan serve

# Press Ctrl+C to stop
```

---

## STEP 4: VERIFY INSTALLATION

### Check 1: Database Connection
```bash
cd Backend
php artisan tinker

# In tinker:
> User::count()       # Should return: 3
> Order::count()      # Should return: 3
> Product::count()    # Should return: 10
> exit
```

### Check 2: Admin Login
```
URL:      http://localhost/bakery-ordering-system/Backend/public/admin/login
Email:    admin@bakery.com
Password: admin123

Expected: Dashboard loads with statistics
```

### Check 3: Customer Login
```
URL:      http://localhost/bakery-ordering-system/Backend/public/login
Email:    customer@bakery.com
Password: admin123

Expected: Customer dashboard loads
```

### Check 4: Route Verification
```bash
cd Backend

# List all routes (to verify no broken routes)
php artisan route:list

# Look for:
# ✅ GET /admin/login
# ✅ GET /admin/dashboard
# ✅ GET /admin/orders
# ✅ GET /admin/products
```

### Check 5: Database Tables
```bash
# In phpMyAdmin or MySQL terminal:
USE bakery_ordering_system;
SHOW TABLES;

# Should show 22 tables:
admins, activity_logs, brands, carts, cart_items, categories, 
contact_queries, custom_cakes, deliveries, delivery_locations, 
events, failed_jobs, notifications, order_items, order_tracking, 
orders, pages, password_resets, payments, personal_access_tokens, 
products, roles, settings, subscribers, testimonials, users
```

---

## TROUBLESHOOTING

### Problem: "Database connection refused"
**Solution:**
1. Check MySQL is running (XAMPP Control Panel)
2. Verify DB credentials in .env match MySQL setup
3. Ensure database name matches: `bakery_ordering_system`

```bash
# Reset database
php artisan migrate:refresh --seed
```

### Problem: "Class not found" error
**Solution:**
1. Clear autoloader cache
```bash
cd Backend
composer dump-autoload
```

### Problem: "SQLSTATE[HY000]: General error: 1030"
**Solution:**
```bash
# Verify database import completed
php artisan migrate

# Check table structure
php artisan tinker
> Schema::getTableListing()  # View all tables
```

### Problem: "Session driver error"
**Solution:**
```bash
# Ensure session storage is writable
chmod -R 755 storage/framework
```

### Problem: Admin can't login
**Solution:**
1. Verify admin user exists:
```bash
cd Backend
php artisan tinker
> Admin::all()  # Should show 2 admins
> exit
```

2. Reset admin password:
```bash
php artisan tinker
> $admin = Admin::first()
> $admin->password = Hash::make('admin123')
> $admin->save()
> exit
```

---

## QUICK FEATURE TEST

### Test Admin Dashboard
1. Login: `http://localhost/bakery-ordering-system/Backend/public/admin/login`
2. Credentials: `admin@bakery.com / admin123`
3. Expected: Dashboard shows:
   - ✅ Total Users: 3
   - ✅ Total Orders: 3
   - ✅ Total Products: 10
   - ✅ Total Revenue: 4,181.00
   - ✅ Recent Orders list

### Test Product Management
1. Navigate: `/admin/products`
2. Should see 10 demo products listed
3. Click one product - should show full details
4. Try creating new product - form should display
5. Try editing product - should be editable
6. Try deleting product - should be removed

### Test Order Management
1. Navigate: `/admin/orders`
2. Should see 3 demo orders
3. Click order CB-00001 - view details
4. Update status to "confirmed" - should save
5. View order tracking - should show history

### Test Category Management
1. Navigate: `/admin/categories`
2. Should see 5 demo categories
3. Verify you can add/edit/delete categories

---

## VERIFICATION CHECKLIST

- [ ] MySQL running
- [ ] Apache running
- [ ] Database imported (22 tables visible)
- [ ] Admin login works at `/admin/login`
- [ ] Admin dashboard displays statistics
- [ ] Customer can login at `/login`
- [ ] Products visible on dashboard
- [ ] Orders visible on dashboard
- [ ] Can navigate to `/admin/products`
- [ ] Can navigate to `/admin/orders`
- [ ] Can navigate to `/admin/categories`
- [ ] No errors in `storage/logs/laravel.log`

---

## DATABASE VERIFICATION QUERY

Run in phpMyAdmin SQL tab or MySQL terminal:

```sql
-- Check total records in each table
SELECT 'users' as table_name, COUNT(*) as count FROM users
UNION ALL
SELECT 'admins', COUNT(*) FROM admins
UNION ALL
SELECT 'products', COUNT(*) FROM products
UNION ALL
SELECT 'orders', COUNT(*) FROM orders
UNION ALL
SELECT 'categories', COUNT(*) FROM categories
UNION ALL
SELECT 'payments', COUNT(*) FROM payments
ORDER BY table_name;

-- Expected output:
-- admins: 2
-- categories: 5
-- orders: 3
-- payments: 3
-- products: 10
-- users: 3
```

---

## NEXT: DEVELOPMENT & TESTING

After verification, continue with:

1. **Create Custom Cake Test Flow**
   - Navigate to custom cake request form
   - Submit request
   - Verify appears in admin panel
   - Admin approves/rejects

2. **Create Order Flow**
   - Add products to cart
   - Proceed to checkout
   - Enter delivery details
   - Select payment method
   - Complete order
   - Check order in admin panel

3. **Test Notifications**
   - Check order status notifications
   - Verify email sending (configure mail in .env)

4. **Load Testing**
   - Test with multiple concurrent users
   - Monitor performance

---

## IMPORTANT FILES LOCATION

| File | Location | Purpose |
|------|----------|---------|
| Database SQL | `Backend/import.sql` | Complete database schema |
| Environment | `Backend/.env` | Database & mail config |
| Routes | `Backend/routes/web.php` | All application routes |
| Models | `Backend/app/Models/` | 22 database models |
| Controllers | `Backend/app/Http/Controllers/` | Application logic |
| Views | `Backend/resources/views/` | UI templates |
| Migrations | `Backend/database/migrations/` | Schema history |
| Logs | `Backend/storage/logs/laravel.log` | Error logs |

---

## DEFAULT CREDENTIALS SUMMARY

```
╔════════════════════════════════════════════╗
║     BAKERY ORDERING SYSTEM CREDENTIALS     ║
╠════════════════════════════════════════════╣
║ ADMIN ACCESS                               ║
║ Email:    admin@bakery.com                 ║
║ Password: admin123                         ║
║ URL:      /admin/login                     ║
╠════════════════════════════════════════════╣
║ CUSTOMER ACCESS                            ║
║ Email:    customer@bakery.com              ║
║ Password: admin123                         ║
║ URL:      /login                           ║
╠════════════════════════════════════════════╣
║ DATABASE                                   ║
║ Name:     bakery_ordering_system           ║
║ Host:     localhost (127.0.0.1)            ║
║ Port:     3306                             ║
║ User:     root                             ║
║ Password: (blank for XAMPP)                ║
╚════════════════════════════════════════════╝
```

---

## ⏱️ TIMELINE

- **0-5 min:** Database import
- **5-8 min:** Environment config check
- **8-10 min:** Server startup
- **10-15 min:** Verification tests
- **15+ min:** Feature testing

**Total Setup Time: ~15 minutes** ⏰

---

## 🎯 SUCCESS INDICATORS

✅ All indicators below should be GREEN for successful setup:

- Database imported without errors
- Admin can login
- Dashboard shows correct statistics
- Product list displays all 10 demo products
- Order list displays all 3 demo orders
- Category list shows all 5 categories
- No red errors in logs
- All routes accessible
- Admin can navigate all sections

---

**Version:** 1.0  
**Last Updated:** January 10, 2026  
**Status:** Ready to Deploy
