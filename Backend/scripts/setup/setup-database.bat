@echo off
REM ============================================================================
REM BAKERY ORDERING SYSTEM - AUTOMATED DATABASE SETUP
REM For Windows XAMPP Installation
REM ============================================================================

echo.
echo ============================================================================
echo          BAKERY ORDERING SYSTEM - DATABASE SETUP WIZARD
echo ============================================================================
echo.
echo This script will help you import the database and set up the system.
echo.

REM Check if MySQL is available
where mysql >nul 2>nul
if %errorlevel% neq 0 (
    echo.
    echo ERROR: MySQL not found in PATH!
    echo.
    echo Please make sure:
    echo 1. XAMPP is installed
    echo 2. MySQL is running (start from XAMPP Control Panel)
    echo 3. MySQL bin folder is in PATH
    echo.
    echo For XAMPP, MySQL is usually at:
    echo C:\xampp\mysql\bin
    echo.
    pause
    exit /b 1
)

echo ✓ MySQL found!
echo.

REM Get MySQL password from user
set /p mysql_password="Enter MySQL password (press Enter if blank): "

if "%mysql_password%"=="" (
    set mysql_args=-u root
    echo ✓ Using blank password
) else (
    set mysql_args=-u root -p%mysql_password%
)

echo.
echo ============================================================================
echo STEP 1: Checking if database exists...
echo ============================================================================
echo.

REM Check if database already exists
mysql %mysql_args% -e "USE bakery_ordering_system;" 2>nul
if %errorlevel% equ 0 (
    echo ✓ Database already exists!
    echo.
    set /p drop_db="Do you want to drop and recreate it? (y/n): "
    if /i "%drop_db%"=="y" (
        echo Dropping existing database...
        mysql %mysql_args% -e "DROP DATABASE IF EXISTS bakery_ordering_system;" 2>nul
        echo ✓ Database dropped
    ) else (
        echo Using existing database
    )
) else (
    echo Database does not exist - will create new one
)

echo.
echo ============================================================================
echo STEP 2: Importing database schema...
echo ============================================================================
echo.

REM Get the directory of this script
set script_dir=%~dp0

REM Check if import.sql exists
if not exist "%script_dir%import.sql" (
    echo ERROR: import.sql not found in %script_dir%
    echo.
    echo Please make sure import.sql is in the same directory as this script.
    echo.
    pause
    exit /b 1
)

echo Importing from: %script_dir%import.sql
echo.
echo This may take a moment...
echo.

REM Import the database
mysql %mysql_args% < "%script_dir%import.sql" 2>"%script_dir%import_error.log"

if %errorlevel% equ 0 (
    echo.
    echo ✓ Database imported successfully!
    echo.
) else (
    echo.
    echo ERROR during database import!
    echo.
    echo Check error log: %script_dir%import_error.log
    echo.
    type "%script_dir%import_error.log"
    echo.
    pause
    exit /b 1
)

echo ============================================================================
echo STEP 3: Verifying database...
echo ============================================================================
echo.

REM Count tables
for /f %%A in ('mysql %mysql_args% bakery_ordering_system -e "SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='bakery_ordering_system';" -N -B 2^>nul') do set table_count=%%A

echo Tables created: %table_count%

if %table_count% geq 22 (
    echo ✓ All 22 tables created successfully!
) else (
    echo ⚠ Warning: Expected 22 tables but found %table_count%
)

echo.

REM Count demo data
for /f %%A in ('mysql %mysql_args% bakery_ordering_system -e "SELECT COUNT(*) FROM users;" -N -B 2^>nul') do set user_count=%%A
for /f %%A in ('mysql %mysql_args% bakery_ordering_system -e "SELECT COUNT(*) FROM products;" -N -B 2^>nul') do set product_count=%%A
for /f %%A in ('mysql %mysql_args% bakery_ordering_system -e "SELECT COUNT(*) FROM orders;" -N -B 2^>nul') do set order_count=%%A

echo Demo Data:
echo - Users: %user_count%
echo - Products: %product_count%
echo - Orders: %order_count%

echo.
echo ============================================================================
echo STEP 4: Creating .env file configuration...
echo ============================================================================
echo.

REM Check if .env exists
if exist "%script_dir%.env" (
    echo ✓ .env file already exists
) else (
    echo Creating .env file...
    REM This would require creating .env - usually copy from .env.example
    echo ✓ Please copy .env.example to .env manually
)

echo.
echo ============================================================================
echo SETUP COMPLETE!
echo ============================================================================
echo.
echo ✓ Database: bakery_ordering_system
echo ✓ Tables: %table_count% created
echo ✓ Demo Users: %user_count%
echo ✓ Demo Products: %product_count%
echo ✓ Demo Orders: %order_count%
echo.

echo Next Steps:
echo 1. Make sure Apache and MySQL are running in XAMPP Control Panel
echo 2. Open your browser and go to:
echo    http://localhost/bakery-ordering-system/Backend/public/admin/login
echo 3. Login with:
echo    Email: admin@bakery.com
echo    Password: admin123
echo.
echo.
echo For more help, see QUICK_SETUP_GUIDE.md
echo.
pause
