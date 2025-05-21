# 📦 Sell2Recycle (Laravel 12)

A mobile phone recycling comparison platform built with Laravel 12, Blade, Tailwind, Spatie roles & activity log, and a structured admin/vendor architecture.

---

## 🚀 Features
- Role-based dashboards for Admin, Vendor, and User
- Vendor offer ingestion via CSV feed
- User authentication via Laravel Breeze
- Spatie permission for RBAC
- Spatie activity log for auditing
- Tailwind UI styling
- CI-ready Laravel project structure

---

## ✅ Project Setup

### Clone the Repo
```bash
git clone https://github.com/OniJoshin/sell2recycle.git
cd sell2recycle
```

### Install Dependencies
```bash
composer install
npm install
npm run dev
```

### Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```
Update `.env` with your DB settings.

### Run Migrations and Seeders
```bash
php artisan migrate --seed
```

This creates:
- Admin user (admin@example.com / password)
- Roles: admin, vendor, user
- Sample vendors and offers (via factories)

---

## 🔐 Auth and Dashboards

- Admin: `/admin/dashboard` (role: admin)
- Vendor: `/vendor/dashboard` (role: vendor)
- User: `/user/dashboard` (role: user)
- Role-based middleware setup using Spatie

---

## 🧪 Developer Tools

### Telescope (local dev)
```bash
php artisan telescope:install
php artisan migrate
```

### Activity Logs
Logged automatically for key model events.

---

## 🔄 Deployment Notes
- `.env` is excluded — set this up manually per environment
- DB and activity logs are not versioned
- Use `mysqldump` to export/import if needed

---

## 🧩 Optional Extras
- Add Meilisearch for internal device search
- Add GitHub Actions for CI (`php artisan test`)
- Set up Forge or Envoyer for deployment

---

## 📫 Contact
For feature suggestions or help setting up, contact the maintainer.