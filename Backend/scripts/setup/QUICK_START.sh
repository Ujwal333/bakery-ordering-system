#!/bin/bash
# ============================================
# CINNAMON BAKERY - ADMIN PANEL QUICK START
# ============================================
# This script sets up the admin panel quickly
# Run from: C:\xampp\htdocs\bakery-ordering-system\Backend

echo "🍰 Cinnamon Bakery - Admin Panel Setup"
echo "======================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Step 1: Install Dependencies
echo -e "${BLUE}Step 1: Installing Dependencies...${NC}"
composer install
npm install
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Dependencies installed${NC}"
else
    echo -e "${RED}✗ Failed to install dependencies${NC}"
    exit 1
fi
echo ""

# Step 2: Generate App Key
echo -e "${BLUE}Step 2: Generating Application Key...${NC}"
php artisan key:generate
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Application key generated${NC}"
else
    echo -e "${RED}✗ Failed to generate key${NC}"
    exit 1
fi
echo ""

# Step 3: Create Database
echo -e "${BLUE}Step 3: Running Migrations...${NC}"
php artisan migrate
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Migrations completed${NC}"
else
    echo -e "${RED}✗ Migrations failed${NC}"
    exit 1
fi
echo ""

# Step 4: Seed Database
echo -e "${BLUE}Step 4: Seeding Database with Demo Data...${NC}"
php artisan db:seed
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Database seeded with demo data${NC}"
else
    echo -e "${RED}✗ Seeding failed${NC}"
    exit 1
fi
echo ""

# Step 5: Create Storage Link
echo -e "${BLUE}Step 5: Creating Storage Symlink...${NC}"
php artisan storage:link
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Storage symlink created${NC}"
else
    echo -e "${RED}✗ Failed to create storage symlink${NC}"
fi
echo ""

# Step 6: Build Assets
echo -e "${BLUE}Step 6: Building Frontend Assets...${NC}"
npm run build
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Assets built${NC}"
else
    echo -e "${RED}✗ Failed to build assets${NC}"
fi
echo ""

# Success Message
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}✓ SETUP COMPLETE!${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo -e "${YELLOW}🔐 Admin Credentials:${NC}"
echo "   Email: admin@bakery.com"
echo "   Username: superadmin"
echo "   Password: admin123"
echo ""
echo -e "${YELLOW}📍 Next Steps:${NC}"
echo "1. Start Laravel Development Server:"
echo "   ${BLUE}php artisan serve${NC}"
echo ""
echo "2. In another terminal, start Vite:"
echo "   ${BLUE}npm run dev${NC}"
echo ""
echo "3. Open browser and visit:"
echo "   ${BLUE}http://localhost:8000/admin/login${NC}"
echo ""
echo -e "${YELLOW}📚 Documentation:${NC}"
echo "   - ADMIN_SETUP_GUIDE.md"
echo "   - IMPLEMENTATION_STATUS.md"
echo ""
echo "🎉 Happy baking!"
