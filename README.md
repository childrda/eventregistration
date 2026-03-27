# Virginia Cybercon Website (Laravel)

Production-ready Laravel CMS site for Virginia Cybercon with:

- Public marketing pages
- Admin-managed content (CRUD)
- Registration workflow + confirmation email
- Sent email logging
- Admin user management (invite / enable / disable)

---

## 1) Server Requirements (Clean Linux Install)

Assume Ubuntu/Debian-like system.

Install required packages:

```bash
sudo apt update
sudo apt install -y apache2 mysql-server php php-cli php-common php-mysql php-mbstring php-xml php-curl php-zip php-bcmath php-intl unzip git composer
```

Optional but recommended for asset builds:

```bash
sudo apt install -y nodejs npm
```

Enable Apache rewrite and restart:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

---

## 2) Harden MySQL

Run:

```bash
sudo mysql_secure_installation
```

Recommended answers:

- Set root password: **Yes**
- Remove anonymous users: **Yes**
- Disallow remote root login: **Yes**
- Remove test database: **Yes**
- Reload privilege tables now: **Yes**

---

## 3) Create Database and DB User

Login to MySQL:

```bash
sudo mysql -u root -p
```

Create database/user:

```sql
CREATE DATABASE vacybercon CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'vacybercon_user'@'localhost' IDENTIFIED BY 'CHANGE_THIS_STRONG_PASSWORD';
GRANT ALL PRIVILEGES ON vacybercon.* TO 'vacybercon_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

---

## 4) Deploy Application Code

Place app code in your web root path, e.g.:

```bash
/var/www/vacybercon
```

Install PHP dependencies:

```bash
cd /var/www/vacybercon
composer install --no-dev --optimize-autoloader
```

If frontend assets must be rebuilt:

```bash
npm install
npm run build
```

---

## 5) Configure Environment

Create env file:

```bash
cp .env.example .env
```

Edit `.env`:

```env
APP_NAME="Virginia Cybercon"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vacybercon
DB_USERNAME=vacybercon_user
DB_PASSWORD=CHANGE_THIS_STRONG_PASSWORD
```

Generate app key:

```bash
php artisan key:generate
```

---

## 6) Run Migrations + Seed Data

```bash
php artisan migrate
php artisan db:seed
```

Default seeded admin credentials:

- Email: `admin@vacybercon.com`
- Password: `ChangeMeNow!123`

Change password immediately after first login.

---

## 7) Set Permissions

```bash
sudo chown -R www-data:www-data /var/www/vacybercon
sudo find /var/www/vacybercon -type f -exec chmod 644 {} \;
sudo find /var/www/vacybercon -type d -exec chmod 755 {} \;
sudo chmod -R 775 /var/www/vacybercon/storage /var/www/vacybercon/bootstrap/cache
```

---

## 8) Apache VirtualHost (Important)

Laravel must point to the `public` folder.

Example `/etc/apache2/sites-available/vacybercon.conf`:

```apache
<VirtualHost *:80>
    ServerName your-domain.com
    ServerAlias www.your-domain.com
    DocumentRoot /var/www/vacybercon/public

    <Directory /var/www/vacybercon/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/vacybercon_error.log
    CustomLog ${APACHE_LOG_DIR}/vacybercon_access.log combined
</VirtualHost>
```

Enable and reload:

```bash
sudo a2ensite vacybercon.conf
sudo a2dissite 000-default.conf
sudo systemctl reload apache2
```

---

## 9) Configure Email (Google Workspace SMTP)

This app expects SMTP username/password from `.env`.

Use a Google Workspace mailbox + App Password.

Set:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=your-workspace-email@yourdomain.com
MAIL_PASSWORD=your-google-app-password
MAIL_FROM_ADDRESS=your-workspace-email@yourdomain.com
MAIL_FROM_NAME="Virginia Cybercon"
```

Then clear cached config:

```bash
php artisan config:clear
php artisan cache:clear
```

Note:

- Google requires 2-Step Verification + App Password for SMTP auth.
- Do not use your normal Gmail/Workspace account password directly.

---

## 10) Production Optimizations

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

If you change env/config/routes/views later, clear/rebuild caches accordingly.

---

## 11) Admin URLs

- Login: `/login`
- Admin Dashboard: `/admin`
- Site Settings: `/admin/site-settings/edit`
- Pages (What page content): `/admin/pages`
- Admin Users (invite/enable/disable): `/admin/users`
- Registrations: `/admin/registrations`
- Email Templates: `/admin/email-templates`
- Sent Email Log: `/admin/sent-emails`

---

## 12) Troubleshooting

- **403 / Forbidden**
  - Verify Apache `DocumentRoot` is `/public`
  - Confirm `<Directory ...> AllowOverride All`
  - Ensure file permissions are set correctly

- **Emails not sending**
  - Re-check `MAIL_*` values
  - Run `php artisan config:clear`
  - Check app logs in `storage/logs/laravel.log`

- **White screen / server errors**
  - Check Apache error logs
  - Check `storage/logs/laravel.log`

---

## 13) Security Notes

- Keep `APP_DEBUG=false` in production.
- Use HTTPS (Let’s Encrypt recommended).
- Rotate default seeded admin password immediately.
- Keep server packages and Composer dependencies updated.
