# 🚌 SISTEM INFORMASI PEMELIHARAAN ARMADA BUS DAMRI

## Panduan Setup dan Instalasi Lengkap

Aplikasi ini adalah sistem manajemen pemeliharaan armada kendaraan bus berbasis Laravel 11 dengan teknologi:

- **Framework**: Laravel 11
- **Database**: MySQL
- **Frontend**: Blade Templates + Bootstrap 5
- **Authentication**: Laravel Sanctum dengan Role-Based Access Control

---

## 📋 PERSYARATAN SISTEM

Pastikan komputer Anda memiliki:

- PHP >= 8.2
- Composer (Package Manager PHP)
- MySQL >= 5.7
- Git (untuk version control)
- Text Editor/IDE (VS Code, PHPStorm, dll)

Cek versi:

```bash
php --version
composer --version
mysql --version
```

---

## 🚀 PROSES INSTALASI STEP-BY-STEP

### **STEP 1: Clone/Download Project**

Jika sudah download, buka folder project di terminal:

```bash
cd C:/Users/nanda/bus-maintenance-system
```

### **STEP 2: Install Dependencies**

Install semua package PHP yang dibutuhkan:

```bash
composer install
```

**Estimasi waktu**: 2-5 menit (tergantung kecepatan internet)

### **STEP 3: Generate Application Key**

Generate key untuk enkripsi aplikasi:

```bash
php artisan key:generate
```

**Output yang diharapkan**:

```
✓ Application key set successfully.
```

### **STEP 4: Setup Database**

#### A. Buat Database di MySQL

Buka MySQL Command Line atau MySQL Workbench, kemudian jalankan:

```sql
CREATE DATABASE bus_maintenance CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Atau bisa juga gunakan PHPMyAdmin:

1. Buka `http://localhost/phpmyadmin`
2. Klik "New" di sebelah kiri
3. Masukkan nama: `bus_maintenance`
4. Klik "Create"

#### B. Update File .env

Edit file `.env` di root project:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bus_maintenance
DB_USERNAME=root
DB_PASSWORD=          # Kosongkan jika tidak ada password
```

Jika menggunakan password MySQL, isi password-nya.

### **STEP 5: Run Database Migrations**

Jalankan migration untuk membuat tabel:

```bash
php artisan migrate
```

**Output yang diharapkan**:

```
✓ Migrating: 2024_01_01_000001_create_users_table
✓ Migrated: 2024_01_01_000001_create_users_table
✓ Migrating: 2024_01_01_000002_create_vehicles_table
✓ Migrated: 2024_01_01_000002_create_vehicles_table
...
```

### **STEP 6: Seed Database (Optional - Isi Data Awal)**

Jalankan seeder untuk mengisi data dummy (user, kendaraan, dll):

```bash
php artisan db:seed
```

Data yang akan dibuat:

- **Admin User**: email: `admin@example.com`, password: `password`
- **Manager User**: email: `manager@example.com`, password: `password`
- **Mechanic Users**: 3 mekanik contoh
- **Sample Vehicles**: 5 kendaraan contoh
- **Sample Maintenance Data**: Jadwal dan riwayat contoh

### **STEP 7: Jalankan Aplikasi**

Start development server:

```bash
php artisan serve
```

**Output**:

```
   Local:   http://127.0.0.1:8000
```

Buka browser dan akses: `http://localhost:8000`

---

## 🔐 Login Info (Jika Menggunakan Seeder)

Setelah menjalankan `php artisan db:seed`, gunakan credentials ini:

### Admin User

- **Email**: `admin@example.com`
- **Password**: `password`
- **Role**: Admin (akses penuh)

### Manager User

- **Email**: `manager@example.com`
- **Password**: `password`
- **Role**: Manager (manajemen operasional)

### Mechanic User

- **Email**: `mechanic1@example.com`
- **Password**: `password`
- **Role**: Mechanic (pencatatan pemeliharaan)

---

## 📁 STRUKTUR PROJECT

```
bus-maintenance-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # Business Logic
│   │   │   ├── DashboardController.php
│   │   │   ├── VehicleController.php
│   │   │   ├── MaintenanceScheduleController.php
│   │   │   ├── MaintenanceRecordController.php
│   │   │   └── ReportController.php
│   │   └── Middleware/         # Access Control
│   │       └── CheckRole.php
│   └── Models/                 # Database Models
│       ├── User.php
│       ├── Vehicle.php
│       ├── MaintenanceSchedule.php
│       └── MaintenanceRecord.php
├── database/
│   ├── migrations/             # Database Structure
│   │   ├── create_users_table.php
│   │   ├── create_vehicles_table.php
│   │   ├── create_maintenance_schedules_table.php
│   │   └── create_maintenance_records_table.php
│   └── seeders/               # Sample Data
│       └── DatabaseSeeder.php
├── resources/
│   └── views/                 # Frontend Templates
│       ├── layouts/           # Master Layout
│       │   └── app.blade.php
│       ├── dashboard/         # Dashboard Pages
│       ├── vehicles/          # Vehicle Pages
│       ├── maintenance/       # Maintenance Pages
│       │   ├── schedules/
│       │   └── records/
│       └── reports/           # Report Pages
├── routes/
│   └── web.php               # URL Routes
├── .env                       # Configuration File
└── composer.json             # PHP Dependencies
```

---

## 🗄️ STRUKTUR DATABASE (ERD)

```
┌─────────────────────────────────────────────────────────────────┐
│                           USERS                                   │
├─────────────────────────────────────────────────────────────────┤
│ id (PK) | name | email | password | role | is_active | timestamps│
│         │      │       │          │(enum)│           │            │
└─────────────────────────────────────────────────────────────────┘
                              ↓ 1 to Many
┌────────────────────────────────┬────────────────────────────────┐
│      MAINTENANCE_RECORDS       │         VEHICLES               │
├────────────────────────────────┼────────────────────────────────┤
│ id (PK)                        │ id (PK)                        │
│ vehicle_id (FK)                │ registration_number (unique)   │
│ schedule_id (FK)  ────────────→│ nomor_rangka (unique)          │
│ mechanic_id (FK)               │ merk | model                   │
│ maintenance_date               │ tahun_pembuatan                │
│ service_type                   │ kapasitas_penumpang            │
│ description                    │ status (enum)                  │
│ cost                           │ date_operation_started         │
│ parts_used                     │ notes                          │
│ odometer_reading               │ timestamps                     │
│ notes | timestamps             │                                │
└────────────────────────────────┴────────────────────────────────┘
                                        ↑ 1 to Many
                          ┌─────────────────────────────┐
                          │ MAINTENANCE_SCHEDULES       │
                          ├─────────────────────────────┤
                          │ id (PK)                     │
                          │ vehicle_id (FK)             │
                          │ service_type                │
                          │ scheduled_date              │
                          │ status (enum)               │
                          │ description                 │
                          │ assigned_mechanic           │
                          │ timestamps                  │
                          └─────────────────────────────┘
```

---

## 🔧 FITUR UTAMA SISTEM

### 1. **Dashboard**

- Statistik kendaraan (total, baik, servis, rusak)
- Biaya pemeliharaan bulanan
- Jadwal servis terlambat (overdue alerts)
- Riwayat pemeliharaan terbaru

### 2. **Manajemen Kendaraan**

- CRUD data kendaraan (bus)
- Tracking status kendaraan (baik/servis/rusak)
- Riwayat pemeliharaan per kendaraan
- Detail spesifikasi kendaraan

### 3. **Jadwal Servis**

- Buat jadwal servis berkala/rutin/perbaikan
- Assign mekanik ke jadwal
- Update status jadwal (pending/proses/selesai/dibatalkan)
- Notifikasi jadwal overdue

### 4. **Riwayat Pemeliharaan**

- Catat setiap servis yang dilakukan
- Tracking biaya per pemeliharaan
- Record parts yang digunakan
- Odometer reading
- Link ke jadwal servis

### 5. **Laporan & Analisis**

- Filter pemeliharaan by tanggal/kendaraan/tipe
- Export ke CSV
- Ringkasan biaya per kendaraan
- Performa mekanik (jumlah servis, biaya rata-rata)
- Statistik monthly

### 6. **Role-Based Access Control**

- **Admin**: Akses penuh semua fitur + settings
- **Manager**: Create/edit/delete kendaraan, jadwal, dan laporan
- **Mechanic**: View vehicles, record maintenance, view schedules

---

## 📝 CONTOH PENGGUNAAN (WORKFLOW)

### Workflow 1: Membuat Jadwal Servis Rutin

1. Login sebagai **Manager** atau **Admin**
2. Klik menu **Jadwal Servis** → **Buat Jadwal**
3. Pilih kendaraan: **B 1234 CD** (Isuzu)
4. Tipe Servis: **Rutin** (Ganti oli setiap 1000 km)
5. Tanggal: **2024-06-15**
6. Assign Mechanic: **Budi Santoso**
7. Klik **Simpan Jadwal**

### Workflow 2: Mencatat Pemeliharaan yang Dilakukan

1. Login sebagai **Mechanic** atau **Manager**
2. Klik menu **Riwayat Pemeliharaan** → **Catat Pemeliharaan**
3. Pilih Kendaraan: **B 1234 CD**
4. Pilih Jadwal Terkait (opsional)
5. Mekanik: **Budi Santoso**
6. Tanggal: **2024-06-15**
7. Tipe Servis: **Ganti Oli**
8. Deskripsi: **Ganti oli mesin + filter**
9. Biaya: **150000**
10. Parts: **Oli Castrol 10W-40 (1 liter), Filter Oli**
11. Odometer: **25400** km
12. Klik **Simpan Pencatatan**

### Workflow 3: Generate Laporan Bulanan

1. Login sebagai Admin/Manager
2. Klik menu **Laporan** → **Generate Laporan**
3. Filter:
    - Tanggal Mulai: **2024-06-01**
    - Tanggal Akhir: **2024-06-30**
    - Kendaraan: **Semua** (atau pilih spesifik)
4. Klik **Generate Laporan**
5. Lihat ringkasan:
    - Total pemeliharaan
    - Total biaya
    - Rata-rata biaya
6. Klik **Export CSV** untuk download

---

## 🔍 MENGATASI MASALAH UMUM

### Error: "SQLSTATE[HY000] [2002] No such file or directory"

**Masalah**: Database tidak terhubung
**Solusi**:

1. Pastikan MySQL server berjalan
2. Check konfigurasi .env (DB_HOST, DB_USERNAME, DB_PASSWORD)
3. Pastikan database `bus_maintenance` sudah dibuat

### Error: "Class 'App\Models\Vehicle' not found"

**Masalah**: Model belum terload
**Solusi**:

```bash
composer dump-autoload
```

### Error: "The storage path is not writable"

**Masalah**: Permission folder storage
**Solusi** (Windows):

```bash
# Ensure folder writable
cacls storage /T /E /G everyone:F
```

### Application tidak bisa diakses di browser

**Masalah**: Development server tidak jalan
**Solusi**:

```bash
# Pastikan terminal menunjukkan:
php artisan serve
# Akses: http://localhost:8000
```

---

## 🎯 FITUR YANG BISA DIKEMBANGKAN LEBIH LANJUT

1. **Notifikasi Email**: Alert jadwal servis via email
2. **SMS Reminder**: Notifikasi jadwal via SMS
3. **Mobile App**: Aplikasi mobile untuk mekanik
4. **QR Code**: Scanning kendaraan dengan QR code
5. **Analytics Dashboard**: Chart dan grafik lebih detail
6. **Predictive Maintenance**: AI untuk prediksi kerusakan
7. **Parts Inventory**: Tracking stok suku cadang
8. **Cost Analysis**: Analisis ROI per kendaraan
9. **API Integration**: Rest API untuk integrasi sistem lain
10. **Multi-Language**: Support Bahasa Inggris/lainnya

---

## 📚 DOKUMENTASI LEBIH LANJUT

- [Laravel Documentation](https://laravel.com/docs/11.x)
- [Eloquent ORM](https://laravel.com/docs/11.x/eloquent)
- [Blade Templating](https://laravel.com/docs/11.x/blade)
- [Bootstrap 5 Docs](https://getbootstrap.com/docs/5.0/)

---

## 🤝 SUPPORT DAN TROUBLESHOOTING

Jika ada masalah atau bug, cek:

1. Terminal output untuk error messages
2. File `storage/logs/laravel.log` untuk detailed errors
3. Browser developer console (F12) untuk frontend errors

---

## 📄 LICENSE

Sistem ini dibuat untuk keperluan akademik/skripsi.

---

**Terima kasih telah menggunakan Sistem Informasi Pemeliharaan Armada Bus DAMRI! 🚌**

Created: Juni 2024
Last Updated: Juni 2024
