# 🚌 QUICK START GUIDE

## Instalasi Cepat (5 Menit)

### Step 1: Install Dependencies

```bash
cd bus-maintenance-system
composer install
```

### Step 2: Setup Environment

```bash
php artisan key:generate
```

### Step 3: konfigurasi Database

Edit file `.env`:

```env
DB_DATABASE=bus_maintenance
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Create Database

```sql
CREATE DATABASE bus_maintenance;
```

### Step 5: Run Migrations

```bash
php artisan migrate
php artisan db:seed
```

### Step 6: Start Server

```bash
php artisan serve
```

Buka: **http://localhost:8000**

---

## 🔐 Login Credentials

```
Admin:    admin@example.com / password
Manager:  manager@example.com / password
Mechanic: mechanic1@example.com / password
```

---

## 🎯 Main Features

✅ Dashboard dengan statistik kendaraan  
✅ Manajemen data armada bus (CRUD)  
✅ Penjadwalan servis otomatis  
✅ Pencatatan riwayat pemeliharaan  
✅ Laporan & analisis biaya  
✅ Role-based access control (Admin/Manager/Mechanic)  
✅ Responsive UI dengan Bootstrap 5  
✅ Form validation lengkap

---

## 📝 Quick Commands

```bash
# Check status
php artisan serve

# Reset database
php artisan migrate:refresh --seed

# Clear cache
php artisan cache:clear

# View all routes
php artisan route:list

# Create migration
php artisan make:migration create_table_name

# Create model
php artisan make:model ModelName

# Create controller
php artisan make:controller ControllerName
```

---

## 📁 Key Folders

- `app/Http/Controllers/` - Business logic
- `app/Models/` - Database models
- `database/migrations/` - Database schema
- `resources/views/` - Frontend templates
- `routes/web.php` - URL routes

---

## 🆘 Common Issues

**Database Connection Error**
→ Check MySQL is running and `.env` credentials

**Model Not Found**

```bash
composer dump-autoload
```

**Port 8000 Already in Use**

```bash
php artisan serve --port=8001
```

---

Dokumentasi lengkap: [SETUP_GUIDE.md](./SETUP_GUIDE.md)
