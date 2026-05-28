# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

**Turbocharged** — A PHP/MySQL car service management platform for Turbocharged Car Care Center (NH-65, Abdullapurmet, Rangareddy, Telangana). Customers book service packages online; admins approve bookings and manage inventory.

## Running the Project

**Prerequisites:** PHP 7.4+, MySQL 5.5+, local server (XAMPP / WAMP / MAMP).

**Database setup:**
```bash
mysql -u root < turbocharged/db/cars.sql
```

**Configure DB** in `turbocharged/includes/config.php` (host, user, pass, db name `cars`).

**Serve:**
```bash
cd turbocharged
php -S localhost:8000
```

- Customer portal: `http://localhost:8000/`
- Admin: `http://localhost:8000/login.php` (default: `admin` / `admin`)

## Architecture

```
turbocharged/
├── header.php              # Full HTML head (Tailwind CDN, Google Fonts) + responsive customer navbar
├── includes/
│   ├── config.php          # MySQLi connection only — include at top of any page needing DB
│   └── footer.php          # Full <footer> element + </body></html>
├── admin/
│   └── menu.php            # Admin navbar — also performs session auth guard (redirects if not logged in)
```

**Page structure pattern (customer pages):**
```php
<?php
// 1. All PHP processing at the top (before any output)
include 'includes/config.php';
$pageTitle = 'My Page';
// ... prepared statement queries, form handling, set $error/$success ...

// 2. Output starts here
include 'header.php';   // emits <!DOCTYPE html> through <nav>
?>
<main class="flex-1 ...">
    <!-- Tailwind-styled content -->
</main>
<?php include 'includes/footer.php'; ?>   // emits <footer> through </html>
```

**Admin page structure:** Each admin page has its own `<!DOCTYPE html>` head (with Tailwind CDN), then `<?php include 'menu.php'; ?>` for the nav, content in `<main>`, and an inline footer. Auth check lives in `menu.php`.

## UI / Styling

- **CSS framework:** Tailwind CSS via CDN (`<script src="https://cdn.tailwindcss.com">`) — no build step
- **Design system:** Dark theme — `bg-slate-950` page, `bg-slate-900` cards/nav, `orange-500` accent
- **No legacy CSS:** `css/reset.css`, `css/main.css`, `css/responsive.css` and `js/main.js` are retained but no longer referenced
- All form inputs use class pattern: `bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 ... focus:ring-2 focus:ring-orange-500`

## SQL / Security

- **All DB queries use prepared statements** (`$conn->prepare()` → `bind_param()` → `execute()` → `get_result()`)
- **Never** use raw string interpolation for DB queries
- Integer IDs from GET/POST must be cast with `intval()` before use
- Session started with `session_status() === PHP_SESSION_NONE` guard before `session_start()`

## Key Flows

**Customer auth:** `email` + `reg_no` (vehicle registration number used as password) → checked against `client` table
**Admin auth:** `uname` + `pass` → checked against `admin` table; session vars `$_SESSION['uname']` and `$_SESSION['pass']`
**Booking:** `client` row inserted with `status='Pending'`; admin visits `approve.php?id=N` to flip to `'Approved'`
**Payment:** Transaction ID stored in `client.mpesa` field via `pay.php`

## Code Patterns

- Procedural PHP — no OOP, no framework, no Composer
- Error/success feedback uses PHP variables (`$error`, `$success`) set before `include 'header.php'`, rendered as styled Tailwind alert divs — no JavaScript `alert()` calls
- No automated tests — manual testing required
