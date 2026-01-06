# Cinnamon Bakery - Laravel E-Commerce Platform

![Laravel](https://img.shields.io/badge/Laravel-9.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.0+-blue.svg)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

A comprehensive e-commerce platform built with Laravel for Cinnamon Bakery, featuring a complete bakery management system with user authentication, product catalog, shopping cart, order management, and custom cake builder.

## 🌟 Features

### 🛒 Customer Features
- **User Registration & Authentication** - Secure login/signup with Laravel Sanctum
- **Product Catalog** - Browse cakes, cupcakes, cookies, and specials
- **Advanced Search & Filtering** - Filter by category, price, rating
- **Shopping Cart** - Add, update, remove items with persistent storage
- **Custom Cake Builder** - Design personalized cakes with flavors, sizes, decorations
- **Order Management** - Place orders, track status, order history
- **Order Tracking** - Real-time order status updates
- **User Profile** - Manage personal information and preferences

### 👨‍💼 Admin Features
- **Dashboard** - Overview of orders, sales, and analytics
- **Product Management** - CRUD operations for products and categories
- **Order Management** - View, update, and process orders
- **User Management** - Manage customer accounts and roles
- **Inventory Control** - Track stock levels and availability
- **Reports** - Sales reports and analytics

### 🛠️ Technical Features
- **RESTful API** - Complete API for frontend integration
- **Role-based Access Control** - Admin and customer permissions
- **Image Upload & Management** - Product and profile image handling
- **Email Notifications** - Order confirmations and updates
- **Payment Integration Ready** - Prepared for payment gateway integration
- **Responsive Design** - Mobile-friendly interface
- **SEO Optimized** - Search engine friendly URLs and meta tags

## 🚀 Tech Stack

- **Backend:** Laravel 9.x
- **Database:** MySQL 8.0+
- **Authentication:** Laravel Sanctum
- **Frontend:** HTML5, CSS3, JavaScript (ES6+)
- **Styling:** Custom CSS with responsive design
- **Icons:** Font Awesome
- **Deployment:** Compatible with shared hosting and cloud platforms

## 📋 Prerequisites

- PHP 8.0 or higher
- Composer
- MySQL 8.0 or higher
- Node.js (for frontend assets, optional)
- Git

## 🛠️ Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/cinnamon-bakery.git
   cd cinnamon-bakery
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   - Create a MySQL database
   - Update `.env` file with database credentials:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=cinnamon_bakery
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```

5. **Run Migrations**
   ```bash
   php artisan migrate
   ```

6. **Seed Database (Optional)**
   ```bash
   php artisan db:seed
   ```

7. **Start Development Server**
   ```bash
   php artisan serve
   ```

8. **Access the Application**
   - Frontend: `http://localhost:8000`
   - API: `http://localhost:8000/api`

## 📖 Usage

### For Customers
1. **Register/Login** at `http://localhost:8000/login`
2. **Browse Products** at `http://localhost:8000/browse-menu`
3. **Add to Cart** and proceed to checkout
4. **Design Custom Cakes** at `http://localhost:8000/custom-cake`
5. **Track Orders** at `http://localhost:8000/order-tracking`

### For Admins
1. Login with admin credentials
2. Access admin features through protected routes
3. Manage products, orders, and users

### API Usage
The application provides a complete REST API. Here are some key endpoints:

#### Authentication
```http
POST /api/register
POST /api/login
POST /api/logout
GET  /api/user
```

#### Products
```http
GET  /api/products
GET  /api/products/{id}
GET  /api/products/popular
GET  /api/products/featured
GET  /api/categories
```

#### Cart & Orders
```http
GET    /api/cart
POST   /api/cart/add
POST   /api/orders
GET    /api/orders/my
GET    /api/orders/{id}
```

#### Custom Cakes
```http
POST /api/custom-cakes
GET  /api/custom-cakes
```

## 🗂️ Project Structure

```
cinnamon-bakery/
├── app/
│   ├── Http/Controllers/     # API Controllers
│   ├── Models/              # Eloquent Models
│   ├── Providers/           # Service Providers
│   └── Middleware/          # Custom Middleware
├── database/
│   ├── migrations/          # Database Migrations
│   └── seeders/            # Database Seeders
├── public/
│   ├── css/                # Stylesheets
│   ├── js/                 # JavaScript files
│   └── images/             # Static images
├── resources/
│   └── views/              # Blade templates
├── routes/
│   ├── api.php             # API Routes
│   └── web.php             # Web Routes
├── config/                 # Configuration files
├── storage/                # File storage
├── tests/                  # Test files
├── artisan                 # Laravel CLI
├── composer.json           # PHP dependencies
└── README.md
```

## 🔧 Configuration

### Environment Variables
Key environment variables in `.env`:

```env
APP_NAME=Cinnamon Bakery
APP_ENV=local
APP_KEY=base64:your_app_key
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cinnamon_bakery
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mail_username
MAIL_PASSWORD=your_mail_password
```

### Sample Data
The seeder creates:
- Admin user: `admin@cinnamonbakery.com` / `admin123`
- Sample users: `priya@example.com` / `password123`
- Product categories and sample products
- Sample orders with tracking

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

## 🚀 Deployment

### Production Checklist
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure production database
- [ ] Set up proper file permissions
- [ ] Configure web server (Apache/Nginx)
- [ ] Set up SSL certificate
- [ ] Configure email service
- [ ] Set up backup system

### Server Requirements
- PHP 8.0+
- MySQL 8.0+
- Composer
- Node.js (optional)
- SSL certificate
- Cron jobs for scheduled tasks

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines
- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation
- Use meaningful commit messages

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Laravel Framework
- Laravel Sanctum
- Font Awesome
- Unsplash (for sample images)

## 📞 Support

For support, email support@cinnamonbakery.com or create an issue in this repository.

---

**Made with ❤️ for Cinnamon Bakery**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines
- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation
- Use meaningful commit messages

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Laravel Framework
- Laravel Sanctum
- Font Awesome
- Unsplash (for sample images)

## 📞 Support

For support, email support@cinnamonbakery.com or create an issue in this repository.

---

**Made with ❤️ for Cinnamon Bakery**
