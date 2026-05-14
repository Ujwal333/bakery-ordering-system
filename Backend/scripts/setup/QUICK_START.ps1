# ============================================
# CINNAMON BAKERY - ADMIN PANEL QUICK START
# ============================================
# Windows PowerShell Version
# Run from: C:\xampp\htdocs\bakery-ordering-system\Backend

Write-Host "🍰 Cinnamon Bakery - Admin Panel Setup" -ForegroundColor Cyan
Write-Host "=======================================" -ForegroundColor Cyan
Write-Host ""

# Function to check command success
function Check-Success {
    param($message)
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✓ $message" -ForegroundColor Green
        return $true
    } else {
        Write-Host "✗ $message" -ForegroundColor Red
        return $false
    }
}

# Step 1: Install Dependencies
Write-Host "Step 1: Installing Dependencies..." -ForegroundColor Blue
composer install
if (-not (Check-Success "Dependencies installed")) {
    exit 1
}
Write-Host ""

Write-Host "Installing npm packages..." -ForegroundColor Blue
npm install
if (-not (Check-Success "npm packages installed")) {
    exit 1
}
Write-Host ""

# Step 2: Generate App Key
Write-Host "Step 2: Generating Application Key..." -ForegroundColor Blue
php artisan key:generate
Check-Success "Application key generated" | Out-Null
Write-Host ""

# Step 3: Run Migrations
Write-Host "Step 3: Running Migrations..." -ForegroundColor Blue
php artisan migrate --force
if (-not (Check-Success "Migrations completed")) {
    exit 1
}
Write-Host ""

# Step 4: Seed Database
Write-Host "Step 4: Seeding Database with Demo Data..." -ForegroundColor Blue
php artisan db:seed --force
if (-not (Check-Success "Database seeded")) {
    exit 1
}
Write-Host ""

# Step 5: Create Storage Link
Write-Host "Step 5: Creating Storage Symlink..." -ForegroundColor Blue
php artisan storage:link
Check-Success "Storage symlink created" | Out-Null
Write-Host ""

# Step 6: Build Assets
Write-Host "Step 6: Building Frontend Assets..." -ForegroundColor Blue
npm run build
if (-not (Check-Success "Assets built")) {
    Write-Host "Warning: Asset build failed, but setup can continue" -ForegroundColor Yellow
}
Write-Host ""

# Success Message
Write-Host "========================================" -ForegroundColor Green
Write-Host "✓ SETUP COMPLETE!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""

Write-Host "🔐 Admin Credentials:" -ForegroundColor Yellow
Write-Host "   Email: admin@bakery.com"
Write-Host "   Username: superadmin"
Write-Host "   Password: admin123"
Write-Host ""

Write-Host "📍 Next Steps:" -ForegroundColor Yellow
Write-Host "1. Start Laravel Development Server:"
Write-Host "   php artisan serve" -ForegroundColor Blue
Write-Host ""
Write-Host "2. In another terminal, start Vite:"
Write-Host "   npm run dev" -ForegroundColor Blue
Write-Host ""
Write-Host "3. Open browser and visit:"
Write-Host "   http://localhost:8000/admin/login" -ForegroundColor Blue
Write-Host ""

Write-Host "📚 Documentation:" -ForegroundColor Yellow
Write-Host "   - ADMIN_SETUP_GUIDE.md"
Write-Host "   - IMPLEMENTATION_STATUS.md"
Write-Host ""

Write-Host "🎉 Happy baking!" -ForegroundColor Green
