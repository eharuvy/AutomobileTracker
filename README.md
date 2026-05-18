# 🚗 AutomobileTracker

A secure, database-driven web application built with PHP and MySQL to track and manage automobile inventories.

## 🌟 Key Features

- **User Authentication:** Login gateway with email formatting checks and server-side validation.
- **Data Validation:** Enforces numeric year/mileage values and required `make` input before inserting records.
- **XSS Mitigation:** Uses `htmlentities()` for output sanitization to reduce Cross-Site Scripting risks.
- **Production-Ready Architecture:** Keeps web-facing files in `public/` while isolating backend logic in `src/`.
- **Dynamic Configuration:** Reads database credentials from environment variables, avoiding hardcoded secrets.

## 📁 Repository Architecture

- `public/`: Web-facing PHP files, intended for the document root.
  - `index.php` - Landing page.
  - `login.php` - Login form and authentication.
  - `autos.php` - Main automobile management dashboard.
- `src/`: Backend helper code and database connection logic.
  - `pdo.php` - Database connection loader using environment variables.
- `sql/`: Database initialization scripts.
  - `init_db.sql` - Creates the `misc` database and `autos` table.
- `.env.example`: Example environment variables for local development.

## 🛠️ Tech Stack

- **Backend:** PHP 8.3.1
- **Database:** MySQL
- **Configuration:** Environment variables

## 🚀 Local Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/AutomobileTracker.git
   cd AutomobileTracker
   ```

2. **Initialize the database:**
   ```bash
   mysql -u root -p < sql/init_db.sql
   ```

3. **Create local environment settings:**
   ```bash
   cp .env.example .env
   ```
   Or on Windows PowerShell:
   ```powershell
   Copy-Item .env.example .env
   ```
   Then update `.env` with your local MySQL values.

4. **Configure your local web server:**
   - Set the document root to the `public/` directory.
   - If using MAMP or XAMPP on Windows, point the host folder to `.../AutomobileTracker/public`.

5. **Open the application in your browser:**
   ```text
   http://localhost/AutomobileTracker/public/
   ```

## 🔑 Local Development Credentials

The placeholder defaults in `.env.example` are for local development only:

- `DB_HOST=localhost`
- `DB_PORT=3306`
- `DB_NAME=misc`
- `DB_USER=fred`
- `DB_PASSWORD=zap`

> Do not use `fred` / `zap` in production. Those are placeholder values only.

## 🚨 Deployment Checklist

- Do not commit or upload `.env` to production.
- Use your host's environment configuration dashboard to set `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, and `DB_PASSWORD`.
- Generate a secure password for the production database user.
- Set your web server document root to the `public/` folder so `src/` and `sql/` are not exposed.

