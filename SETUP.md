# Vote2Voice - Setup Guide

This guide will help you set up and run the Vote2Voice Laravel application on a new PC.

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.2 or higher** (with required extensions)
- **Composer** (PHP dependency manager)
- **Node.js and npm** (for frontend assets)
- **MySQL/PostgreSQL/SQLite** (or your preferred database)
- **Git** (optional, for cloning the repository)

## Installation Steps

### 1. Clone or Copy the Project

If using Git:
```bash
git clone <repository-url>
cd vote2voice
```

Or simply copy the project folder to your desired location.

### 2. Enable Required PHP Extensions

Open your `php.ini` file and ensure the following extensions are enabled (uncommented):

```ini
extension=zip
extension=mbstring
extension=pdo_mysql  # or pdo_pgsql, pdo_sqlite based on your database
extension=openssl
extension=fileinfo
extension=curl
```

**To find your php.ini location:**
```bash
php --ini
```

### 3. Fix Permissions (Windows Users)

If the project is in a OneDrive/cloud-synced folder, you may encounter permission issues. Run these commands in PowerShell as Administrator:

```powershell
# Navigate to project directory
cd path\to\vote2voice

# Remove read-only attributes
attrib -R "storage" /S /D
attrib -R "bootstrap" /S /D
```

### 4. Install PHP Dependencies

Install Composer dependencies using PHP directly (if `composer` command doesn't work):

```bash
php composer.phar install
```

Or if Composer is properly installed:
```bash
composer install
```

**If Composer hangs or doesn't respond:** Use the full PHP path:
```bash
php C:\path\to\composer install
```

### 5. Configure Environment

Copy the example environment file:
```bash
cp .env.example .env
```

Or on Windows:
```powershell
Copy-Item .env.example .env
```c

Edit `.env` and configure your database and application settings:
```env
APP_NAME=Vote2Voice
APP_ENV=local
APP_KEY=  # Will be generated in next step
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vote2voice
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Generate Application Key

```bash
php artisan key:generate
```

### 7. Create Database

Create a new database matching your `.env` configuration:

**MySQL:**
```sql
CREATE DATABASE vote2voice;
```

**SQLite:** (easier for development)
Update `.env`:
```env
DB_CONNECTION=sqlite
# Comment out other DB_ variables
```

Create the database file:
```bash
touch database/database.sqlite
```

Or on Windows:
```powershell
New-Item database/database.sqlite
```

### 8. Run Migrations

```bash
php artisan migrate
```

### 9. Install Frontend Dependencies

```bash
npm install
```

### 10. Build Frontend Assets

For development:
```bash
npm run dev
```

For production:
```bash
npm run build
```

### 11. Start the Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Common Issues and Solutions

### Issue: "Failed to open stream: No such file or directory vendor/autoload.php"

**Solution:** Run `php composer.phar install` or enable the zip extension in php.ini

### Issue: "The bootstrap/cache directory must be present and writable"

**Solution:** 
1. Remove read-only attributes:
   ```powershell
   attrib -R "bootstrap\cache" /S /D
   ```
2. Ensure the directory exists:
   ```bash
   mkdir bootstrap/cache
   ```

### Issue: Composer hangs without output

**Solution:** Run Composer with PHP directly:
```bash
php C:\path\to\composer.phar install
```

### Issue: Permission denied errors on Windows

**Solution:** Move project outside of OneDrive/cloud-synced folders, or run:
```powershell
icacls "bootstrap\cache" /grant "Everyone:(OI)(CI)(F)" /T
icacls "storage" /grant "Everyone:(OI)(CI)(F)" /T
```

### Issue: npm/Node.js not found

**Solution:** Install Node.js from https://nodejs.org/ and restart your terminal

## Development Workflow

### Running the Application

1. Start the PHP development server:
   ```bash
   php artisan serve
   ```

2. In a separate terminal, run Vite for hot-reloading:
   ```bash
   npm run dev
   ```

### Running Tests

```bash
php artisan test
```

### Database Seeding (Optional)

```bash
php artisan db:seed
```

### Clearing Cache

If you encounter caching issues:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Production Deployment

For production deployment:

1. Set environment to production in `.env`:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

2. Optimize the application:
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   npm run build
   ```

3. Set proper permissions (Linux/Mac):
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

## Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Composer Documentation](https://getcomposer.org/doc/)
- [npm Documentation](https://docs.npmjs.com/)

## Support

For issues or questions, please refer to the project documentation or contact the development team.
