# ⚡ TURBOCHARGED

A web platform for car service management at **Turbocharged Car Care Center**, Abdullapurmet, Rangareddy, Telangana.

Customers can browse service packages, book a service, submit payment, and track approval status. Admins manage bookings, messages, and vehicle listings via a separate panel.

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | PHP (procedural, MySQLi with prepared statements) |
| Frontend | Tailwind CSS (CDN), vanilla JS |
| Database | MySQL 5.5+ |

No build step. No external PHP dependencies.

---

## Setup

**Prerequisites:** PHP 7.4+, MySQL 5.5+, a local web server (XAMPP / WAMP / MAMP or PHP built-in server).

**1. Import the database:**
```bash
mysql -u root < turbocharged/db/cars.sql
```

**2. Configure the database connection** in `turbocharged/includes/config.php`:
```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "cars";
```

**3. Serve the app:**
```bash
cd turbocharged
php -S localhost:8000
```

| URL | Purpose |
|-----|---------|
| `http://localhost:8000/` | Customer portal |
| `http://localhost:8000/login.php` | Admin panel login |

**Default admin credentials** (from `db/cars.sql`): `admin` / `admin`

---

## Customer Flow

1. Browse service packages → `index.php`
2. Click **Book Now** → fill in details or log in → `book_car.php`
3. Submit payment transaction ID → `pay.php`
4. Wait for admin approval → `wait.php`
5. Log in to track status → `account.php` → `status.php`
6. Contact team if needed → `message_admin.php`

## Admin Flow

1. Login at `login.php` → redirects to `admin/index.php`
2. **Messages** (`admin/index.php`) — view & delete customer messages
3. **Service Requests** (`admin/client_requests.php`) — review & approve bookings
4. **Vehicles** (`admin/add_vehicles.php`) — add or delete service packages

---

## Project Structure

```
turbocharged/
├── index.php               # Homepage — vehicle card grid
├── account.php             # Customer login
├── signup.php              # Customer registration
├── book_car.php            # Service booking form
├── pay.php                 # Payment submission
├── status.php              # Booking status tracker
├── spares.php              # Spare parts listing
├── contact_us.php          # Contact info
├── message_admin.php       # Send message to admin
├── wait.php / success.php  # Confirmation pages
├── header.php              # Shared HTML head + customer navbar
├── includes/
│   ├── config.php          # MySQLi connection
│   └── footer.php          # Shared footer + closing HTML
├── admin/
│   ├── menu.php            # Admin navbar (+ auth guard)
│   ├── index.php           # Messages dashboard
│   ├── client_requests.php # Booking approval
│   ├── add_vehicles.php    # Vehicle management
│   ├── approve.php         # Approve a booking (action endpoint)
│   ├── delete_car.php      # Delete vehicle
│   ├── delete_msg.php      # Delete message
│   └── logout.php          # Destroy session
├── db/
│   └── cars.sql            # Database schema + seed data
├── cars/                   # Car images
└── spares/                 # Spare parts images
```

---

## Database Schema

| Table | Key Columns |
|-------|-------------|
| `admin` | `admin_id`, `uname`, `pass` |
| `cars` | `car_id`, `car_name`, `car_type`, `image`, `hire_cost`, `capacity`, `status` |
| `client` | `client_id`, `fname`, `email`, `reg_no`, `phone`, `location`, `gender`, `car_id`, `status`, `mpesa` |
| `message` | `msg_id`, `client_id`, `message`, `status`, `time` |
| `spares` | `spare_id`, `car_name`, `spare_type`, `image`, `spare_cost`, `status` |
