# 📋 DOKUMENTASI ARSITEKTUR SISTEM

## MVC Architecture

Sistem ini menggunakan pattern **Model-View-Controller (MVC)** dari Laravel:

```
                        ┌─────────────────────────┐
                        │   USER/BROWSER          │
                        └────────────┬────────────┘
                                     │ HTTP Request
                                     ▼
                        ┌─────────────────────────┐
                        │   ROUTING (routes/)     │
                        │   ↓                     │
                        │   Directs to Controller │
                        └────────────┬────────────┘
                                     │
              ┌──────────────────────┼──────────────────────┐
              │                      │                      │
              ▼                      ▼                      ▼
    ┌──────────────────┐  ┌──────────────────┐  ┌──────────────────┐
    │ CONTROLLER       │  │ MIDDLEWARE       │  │ VALIDATION       │
    │ (Business Logic) │  │ (Authorization)  │  │ (Form Rules)     │
    │                  │  │ (Authentication) │  │                  │
    └────────┬─────────┘  └──────────────────┘  └──────────────────┘
             │
             │ Interacts with
             ▼
    ┌──────────────────────────────────────────┐
    │ MODEL (Eloquent ORM)                     │
    │ ├── User                                 │
    │ ├── Vehicle                              │
    │ ├── MaintenanceSchedule                  │
    │ └── MaintenanceRecord                    │
    └────────┬─────────────────────────────────┘
             │
             │ Queries Database
             ▼
    ┌──────────────────────────────────────────┐
    │ DATABASE (MySQL)                         │
    │ ├── users                                │
    │ ├── vehicles                             │
    │ ├── maintenance_schedules                │
    │ └── maintenance_records                  │
    └──────────────────────────────────────────┘


    Data Flow:
    ─────────
    View (Blade Template)
         ↓
    Form Submit/Link Click
         ↓
    Router (routes/web.php)
         ↓
    Controller Action
         ↓
    Model Query
         ↓
    Database
         ↓
    Model Return Data
         ↓
    Controller Process
         ↓
    View Render
         ↓
    HTML Response
```

---

## 🔄 Request Lifecycle

1. **Request Masuk**: User akses `/vehicles`
2. **Routing**: `routes/web.php` tangkap route
3. **Middleware**: Check authentication & authorization
4. **Controller**: `VehicleController@index()` dijalankan
5. **Model Query**: Query ke database melalui `Vehicle::all()`
6. **View Render**: Template `vehicles/index.blade.php` ditampilkan dengan data
7. **Response**: HTML dikirim ke browser

---

## 📦 Component Breakdown

### Controllers (app/Http/Controllers/)

```php
VehicleController
├── index()          // GET /vehicles
├── create()         // GET /vehicles/create (form)
├── store()          // POST /vehicles (save)
├── show()           // GET /vehicles/{id}
├── edit()           // GET /vehicles/{id}/edit (form)
├── update()         // PUT /vehicles/{id} (save changes)
└── destroy()        // DELETE /vehicles/{id}

MaintenanceScheduleController
├── index()          // List semua jadwal
├── create()         // Form buat jadwal
├── store()          // Simpan jadwal
├── show()           // Detail jadwal
├── edit()           // Edit jadwal
├── update()         // Update jadwal
└── destroy()        // Hapus jadwal

MaintenanceRecordController
├── index()          // List riwayat
├── create()         // Form catat pemeliharaan
├── store()          // Simpan record
├── show()           // Detail record
├── edit()           // Edit record
├── update()         // Update record
└── destroy()        // Hapus record

DashboardController
└── index()          // Dashboard dengan statistik

ReportController
├── index()          // Form laporan
├── generate()       // Generate dengan filter
├── export()         // Export CSV
├── vehicleCostSummary()  // Biaya per kendaraan
└── mechanicPerformance() // Performa mekanik
```

### Models (app/Models/)

```php
User
├── Properties: name, email, password, role, is_active
├── Methods:
│   ├── isAdmin()
│   ├── isManager()
│   ├── isMechanic()
│   └── maintenanceRecords() // Relationship
└── Scopes: byRole($role)

Vehicle
├── Properties: registration_number, nomor_rangka, merk, model, ...
├── Relationships:
│   ├── schedules() // One-to-Many dengan MaintenanceSchedule
│   └── records() // One-to-Many dengan MaintenanceRecord
├── Methods: updateStatus($status)
└── Scopes: byStatus($status)

MaintenanceSchedule
├── Properties: vehicle_id, service_type, scheduled_date, status, ...
├── Relationships:
│   └── vehicle() // Many-to-One dengan Vehicle
├── Scopes:
│   ├── pending()
│   └── overdue()

MaintenanceRecord
├── Properties: vehicle_id, mechanic_id, maintenance_date, cost, ...
├── Relationships:
│   ├── vehicle() // Many-to-One
│   ├── mechanic() // Many-to-One dengan User
│   └── schedule() // Many-to-One dengan MaintenanceSchedule
└── Scopes:
    ├── dateRange($start, $end)
    └── byServiceType($type)
```

### Routes (routes/web.php)

```php
Group: middleware(['auth'])
├── GET    /              → DashboardController@index
├── GET    /dashboard     → DashboardController@index
│
├── GET    /vehicles      → VehicleController@index
├── POST   /vehicles      → VehicleController@store
├── GET    /vehicles/create
├── GET    /vehicles/{id}
├── GET    /vehicles/{id}/edit
├── PUT    /vehicles/{id}
├── DELETE /vehicles/{id}
│
├── GET    /maintenance-schedules
├── POST   /maintenance-schedules
├── [... schedule routes ...]
│
├── GET    /maintenance-records
├── POST   /maintenance-records
├── [... record routes ...]
│
└── GET    /reports
    ├── /reports/generate
    ├── /reports/export
    ├── /reports/vehicle-cost
    └── /reports/mechanic-performance
```

### Views (resources/views/)

```
layouts/
└── app.blade.php       // Master layout (navbar, sidebar, footer)

dashboard/
└── index.blade.php     // Dashboard dengan statistik

vehicles/
├── index.blade.php     // List vehicles
├── create.blade.php    // Form tambah
├── edit.blade.php      // Form edit
└── show.blade.php      // Detail vehicle

maintenance/
├── schedules/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
└── records/
    ├── index.blade.php
    ├── create.blade.php
    ├── edit.blade.php
    └── show.blade.php

reports/
├── index.blade.php          // Form filter
├── generate.blade.php       // Hasil laporan
├── vehicle-cost-summary.blade.php
└── mechanic-performance.blade.php
```

---

## 🔐 Authorization Flow

```
┌─────────────────────────────────────┐
│ User Login → Set Session            │
│ auth()->user() available            │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│ Route dengan Middleware:            │
│ middleware('auth')                  │
│ middleware('role:admin,manager')    │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│ CheckRole Middleware (app/Http/     │
│ Middleware/CheckRole.php)           │
│                                     │
│ Cek: in_array(user->role, $roles)   │
└──────────────┬──────────────────────┘
               │
        ┌──────┴──────┐
        │             │
     ✓ (Yes)      ✗ (No)
        │             │
        ▼             ▼
   Proceed     Return 403 Error
   to Route    (Forbidden Access)
```

---

## 💾 Database Relationships

```
╔══════════╗
║  USERS   ║
╠══════════╣
║ id (PK)  ║
║ name     ║
║ email    ║
║ role*    ║◄──────┐
╚══════════╝       │ 1 to Many
     │             │
     │         ┌───────────────────┐
     │         │ MAINTENANCE_      │
     │         │ RECORDS           │
     │         ├───────────────────┤
     │         │ mechanic_id (FK)  │
     │         └───────────────────┘
     │
     │
┌────┴──────────────────┐
│                       │
▼                       ▼
HAS MANY        (if admin/manager/mechanic)
MAINTENANCE
_RECORDS


╔═════════════╗
║  VEHICLES   ║
╠═════════════╣
║ id (PK)     ║
║ reg number* ║
║ status*     ║
╚═════════════╝
     │ 1 to Many
     │
     ├─────────────────────────────────────┐
     │                                     │
     ▼                                     ▼
┌─────────────────────┐        ┌──────────────────────┐
│ MAINTENANCE_        │        │ MAINTENANCE_         │
│ SCHEDULES           │        │ RECORDS              │
├─────────────────────┤        ├──────────────────────┤
│ id (PK)             │1 ◄──► │ schedule_id (FK)     │
│ vehicle_id (FK) ◄───┼─┐     │ vehicle_id (FK) ◄────┼──┐
│ service_type    │   │      │ mechanic_id (FK)     │  │
│ scheduled_date  │   │      │ cost                 │  │
│ status**        │   │      │ maintenance_date     │  │
└─────────────────────┘   │      └──────────────────────┘  │
                            │                               │
                            └───────────────────────────────┘
* = Indexed Columns
** = Used for filtering
```

---

## 🎯 Fitur-to-Controller Mapping

| Fitur                 | Controller                    | Methods                             |
| --------------------- | ----------------------------- | ----------------------------------- |
| Dashboard             | DashboardController           | index()                             |
| Lihat Kendaraan       | VehicleController             | index(), show()                     |
| Tambah/Edit Kendaraan | VehicleController             | create(), store(), edit(), update() |
| Hapus Kendaraan       | VehicleController             | destroy()                           |
| Jadwal Servis         | MaintenanceScheduleController | CRUD methods                        |
| Riwayat Pemeliharaan  | MaintenanceRecordController   | CRUD methods                        |
| Laporan               | ReportController              | index(), generate(), export(), ...  |

---

## 🔄 Validation & Business Rules

### Vehicle Creation

- Nomor polisi: wajib, unique
- Nomor rangka: wajib, unique
- Merk: wajib
- Model: wajib
- Tahun: 1900 - tahun sekarang
- Kapasitas: minimal 1 penumpang

### Maintenance Schedule

- Kendaraan: wajib (exists di vehicles)
- Tipe servis: Rutin/Berkala/Perbaikan
- Tanggal: >= hari ini (untuk pending)
- Status: pending/in_progress/completed/cancelled

### Maintenance Record

- Kendaraan: wajib
- Mekanik: wajib (user dengan role mechanic)
- Tanggal: wajib
- Tipe servis: wajib
- Deskripsi: wajib, min 10 karakter
- Biaya: wajib, >= 0

---

## 🚀 Performance Considerations

1. **Pagination**: 10 records per page
2. **Query Optimization**: Eager loading dengan `with()`
3. **Caching**: Cache dashboard statistics (bisa ditambah)
4. **Indexes**: Ada di foreign keys & unique columns
5. **Database**: MySQL untuk concurrent connections

---

## 📈 Scalability Path

1. **Current (MVP)**: Single Laravel app, MySQL database
2. **Phase 2**: Add API layer (REST API)
3. **Phase 3**: Cache layer (Redis)
4. **Phase 4**: Queue system untuk async jobs
5. **Phase 5**: Microservices architecture

---

## 🔧 Development Workflow

```
1. Understand Requirement
   ↓
2. Design Database Schema
   ↓
3. Create Migration
   ↓
4. Create Model with Relationships
   ↓
5. Create Controller with CRUD methods
   ↓
6. Define Routes
   ↓
7. Create Blade Templates (Views)
   ↓
8. Add Validation
   ↓
9. Test Functionality
   ↓
10. Deploy
```

---

## 📝 Code Examples

### Creating a Record

```php
// In Controller
$vehicle = Vehicle::find($id);
$schedule = MaintenanceSchedule::create([
    'vehicle_id' => $vehicle->id,
    'service_type' => 'Rutin',
    'scheduled_date' => '2024-06-15',
    'status' => 'pending',
]);

// Or using relationship
$vehicle->schedules()->create([...]);
```

### Querying Data

```php
// Get all with relationships
$records = MaintenanceRecord::with(['vehicle', 'mechanic'])->get();

// Filter by status
$pending = MaintenanceSchedule::where('status', 'pending')->get();

// Using scopes
$overdue = MaintenanceSchedule::overdue()->get();

// Date range
$thisMonth = MaintenanceRecord::dateRange(
    now()->startOfMonth(),
    now()->endOfMonth()
)->get();
```

### Authorization Check

```blade
@if(auth()->user()->isAdmin())
    <!-- Admin only content -->
@elseif(auth()->user()->isManager())
    <!-- Manager content -->
@else
    <!-- Mechanic content -->
@endif
```

---

File ini menjelaskan arsitektur sistem secara lengkap untuk keperluan dokumentasi dan maintenance.
