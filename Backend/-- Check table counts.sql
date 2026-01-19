-- Check table counts
SELECT 'Products' as Table, COUNT(*) as Count FROM products
UNION ALL
SELECT 'Users', COUNT(*) FROM users
UNION ALL
SELECT 'Admins', COUNT(*) FROM admins
UNION ALL
SELECT 'Orders', COUNT(*) FROM orders
UNION ALL
SELECT 'Payments', COUNT(*) FROM payments;
