# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

**Turbocharged** — A web platform for car service management at Turbocharged Car Care Center (Abdullapurmet, Rangareddy, Telangana). Customers can register service requests, browse packages, book spare parts, and message management. Admins approve requests and manage inventory.

## Running the Project

**Prerequisites:** PHP 5.4+, MySQL 5.5+, a local web server (XAMPP, WAMP, MAMP, or PHP's built-in server).

**Database setup:**
```bash
mysql -u root < turbocharged/db/cars.sql
```

**Configure DB connection** in `turbocharged/includes/config.php`:
```php
$host = "localhost";
$user = "root";
$pass = "";
$db = "cars";
```

**Serve the app:**
```bash
cd turbocharged
php -S localhost:8000
```

- Customer portal: `http://localhost:8000/index.php`
- Admin panel: `http://localhost:8000/login.php` (default credentials in `db/cars.sql`: `admin` / `admin`)

## Architecture

```
turbocharged/
├── index.php, signup.php, account.php   # Customer-facing pages
├── book_car.php, book_spare.php         # Booking flows
├── pay.php, wait.php, success.php       # Payment flow (M-Pesa transaction ID)
├── status.php, message_admin.php        # Post-booking interactions
├── includes/
│   ├── config.php                       # MySQL connection (single config file)
│   ├── header.php, footer.php           # Shared layout templates
├── admin/                               # Admin panel (separate auth)
│   ├── index.php                        # Dashboard (messages view)
│   ├── client_requests.php, approve.php # Booking approval workflow
│   └── add_vehicles.php                 # Inventory management
├── db/cars.sql                          # Full schema + seed data
├── cars/, spares/, img/                 # Static image assets
└── css/, js/                            # Styling and jQuery
```

**Database tables:** `admin`, `cars`, `client`, `hire`, `message`, `spares`

**User flows:**
- *Customer:* signup → select car → book → M-Pesa payment ID → wait for admin approval → track status
- *Admin:* login → view messages/requests → approve bookings → manage vehicle listings

## Code Patterns

- **No framework** — procedural PHP with direct SQL queries embedded in page files
- **No build step** — deploy by copying the `turbocharged/` directory to a web server root
- **No automated tests** — all testing is manual
- SQL queries use string interpolation directly (no prepared statements or ORM)
- Pages include `includes/config.php` at the top for DB connection, then handle both GET display and POST form submission inline
