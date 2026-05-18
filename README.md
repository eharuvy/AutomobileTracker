# AutomobileTracker
Web app to track automobiles and store data in a MySQL database.

Repository layout:

	- `index.php`, `login.php`, `autos.php`
	- `pdo.php`
	- `init_db.sql`

Quick start (MAMP / local):

1. Import the database: `mysql -u root -p < sql/init_db.sql` (or use phpMyAdmin)
2. Configure MySQL credentials in `src/pdo.php` (replace `fred` / `zap`).
3. Point your web server document root to the `public/` directory.
# 🚗 AutomobileTracker

A secure, database-driven web application built with PHP and MySQL to track and manage automobile inventories.

## 🌟 Key Features

- **User Authentication:** Secure login gateway requiring properly formatted credentials and basic input validation.
- **Data Validation:** Robust server-side verification ensuring data integrity (e.g., numeric constraints on mileage/year, mandatory fields).
- **XSS Mitigation:** Defensive use of `htmlentities()` to prevent Cross-Site Scripting vulnerabilities.
- **Production-Ready Architecture:** Clear separation between web-accessible files (`public/`) and backend code (`src/`).
- **Dynamic Configuration:** Uses environment variables (and optional `.env` support) for database credentials to avoid hardcoded secrets.

## 📁 Repository Architecture

- `public/`: Web-facing PHP documents (Document Root).
  - `index.php` - Application landing page.
  - `login.php` - Authentication handler and interface.
  - `autos.php` - Main application dashboard.
- `src/`: Core application logic and internal helper scripts (non-public).
  - `pdo.php` - Dynamic database connection abstraction layer (uses environment variables).
- `sql/`: Database schema initialization and migration control.
  - `init_db.sql` - Table definitions and structures.

## 🛠️ Tech Stack

- **Backend:** PHP 8.x
- **Database:** MySQL
- **Environment Management:** native environment variables

## 🚀 Local Installation & Setup

1. **Clone the repository:**
	```bash
	git clone https://github.com/yourusername/AutomobileTracker.git
	cd AutomobileTracker
	```

2. **Initialize the Database:**
	Import the schema into your local MySQL instance (MAMP/XAMPP):
	```bash
	mysql -u root -p < sql/init_db.sql
	```

3. **Configure Environment Variables:**
	Copy the example file and populate it:
	```bash
	cp .env.example .env
	```
	Or set the variables in your OS or hosting platform.

4. **Web Server Configuration:**
	Point your web server document root to the `public/` directory.

