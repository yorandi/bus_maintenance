# 🚌 Alur Sistem Pemeliharaan Armada Bus

## 📊 Overview Diagram

Sistem ini dirancang untuk mengelola pemeliharaan kendaraan bus dengan 4 aktor utama:

- **Sopir (Driver)**: Pengemudi bus
- **User (Operator)**: Operator sistem yang mengelola data
- **Admin**: Administrator sistem
- **Manager Teknik**: Manajer teknis yang mengawasi operasional

```
┌─────────────────────────────────────────────────────────────────────┐
│                  SISTEM INFORMASI PEMELIHARAAN ARMADA BUS           │
├─────────────────────────────────────────────────────────────────────┤
│                                                                     │
│  ┌──────────┐      ┌──────────┐      ┌──────────┐    ┌──────────┐ │
│  │  Sopir   │      │   User   │      │  Admin   │    │ Manager  │ │
│  │ (Driver) │      │(Operator)│      │          │    │  Teknik  │ │
│  └────┬─────┘      └────┬─────┘      └────┬─────┘    └────┬─────┘ │
│       │                 │                 │               │        │
│       └─────────────────┼─────────────────┼───────────────┘        │
│                         │                 │                        │
│                         ▼                 ▼                        │
│                    ┌──────────────────────────────┐                │
│                    │    SISTEM INFORMASI          │                │
│                    ├──────────────────────────────┤                │
│                    │  - Kelola Armada             │                │
│                    │  - Jadwal Servis             │                │
│                    │  - Riwayat Pemeliharaan      │                │
│                    │  - Monitoring Bus            │                │
│                    │  - Laporan                   │                │
│                    │  - User Management           │                │
│                    └──────────────┬───────────────┘                │
│                                  │                                 │
│                                  ▼                                 │
│                    ┌──────────────────────────────┐                │
│                    │    DATABASE (MySQL)          │                │
│                    ├──────────────────────────────┤                │
│                    │  - Users                     │                │
│                    │  - Vehicles                  │                │
│                    │  - Maintenance Schedules     │                │
│                    │  - Maintenance Records       │                │
│                    │  - Vehicle Conditions        │                │
│                    └──────────────────────────────┘                │
│                                  │                                 │
│                                  ▼                                 │
│                    ┌──────────────────────────────┐                │
│                    │   NOTIFIKASI                 │                │
│                    ├──────────────────────────────┤                │
│                    │  WhatsApp Notifications      │                │
│                    │  ke Sopir / Mekanik          │                │
│                    └──────────────────────────────┘                │
│                                                                     │
└─────────────────────────────────────────────────────────────────────┘
```

---

## 👥 Detail Aktor dan Use Cases

### 1. **Sopir (Driver)**

**Responsibilities:**

- Melaporkan kondisi kendaraan
- Input data armada dengan kode 4 digit (AT/nomor polisi)
- Melihat status monitoring bus
- Menerima notifikasi jadwal servis

**Alur Aktivitas Sopir:**

```
┌─────────────┐
│   Sopir     │
└─────┬───────┘
      │
      ├─────────────────────────────────────┐
      │                                     │
      ▼                                     ▼
  ┌─────────────┐                    ┌──────────────────┐
  │    Login    │                    │  Input Data AT/  │
  └─────┬───────┘                    │  Nomor Polisi    │
        │                            │  (4 digit)       │
        │                            └──────┬───────────┘
        │                                   │
        ├───────────────────────────────────┤
        │                                   │
        ▼                                   ▼
  ┌─────────────┐                    ┌────────────────┐
  │  Dashboard  │                    │ Monitoring Bus │
  │  Sopir      │                    │  (Status View) │
  │             │                    └────────┬───────┘
  │ - Status    │                            │
  │   Armada    │                            │
  │ - Jadwal    │◄───────────┬────────────────┤
  │   Servis    │            │                │
  └─────┬───────┘            ▼                │
        │             ┌────────────────┐      │
        │             │ Notifikasi WA  │      │
        │             │ Jadwal Servis  │      │
        │             └────────────────┘      │
        │                                     │
        └─────────────────────────────────────┤
                                              │
                                              ▼
                                         ┌──────────┐
                                         │  Logout  │
                                         └──────────┘
```

---

### 2. **User (Operator)**

**Responsibilities:**

- Kelola data armada (tambah, edit, lihat)
- Kelola jadwal servis
- Catat riwayat pemeliharaan
- Kirim notifikasi ke Sopir/Mekanik
- Lihat monitoring status kendaraan

**Alur Aktivitas User:**

```
┌─────────────┐
│    User     │
│  (Operator) │
└─────┬───────┘
      │
      ▼
  ┌─────────────┐
  │    Login    │
  └─────┬───────┘
        │
        ├──────────────────────────────────────┐
        │                                      │
        ▼                                      ▼
  ┌────────────────┐               ┌──────────────────────┐
  │  Dashboard     │               │ Kelola Data Armada   │
  │  User          │               │ ─────────────────── │
  │                │               │ ├─ Lihat semua      │
  │ - Total Armada │               │ ├─ Tambah baru      │
  │ - Jadwal       │               │ ├─ Edit             │
  │ - Riwayat      │               │ └─ Detail armada    │
  └────────┬───────┘               └──────────┬──────────┘
           │                                  │
           │                                  ▼
           │                        ┌──────────────────────┐
           │                        │ Kelola Jadwal Servis │
           │                        │ ─────────────────── │
           │                        │ ├─ Lihat jadwal     │
           │                        │ ├─ Buat jadwal      │
           │                        │ ├─ Edit jadwal      │
           │                        │ └─ Tentukan mekanik │
           │                        └──────────┬──────────┘
           │                                  │
           │                                  ▼
           │                        ┌──────────────────────┐
           │                        │ Kelola Riwayat       │
           │                        │ Pemeliharaan         │
           │                        │ ─────────────────── │
           │                        │ ├─ Lihat riwayat    │
           │                        │ ├─ Catat pemeliharan│
           │                        │ └─ Edit record      │
           │                        └──────────┬──────────┘
           │                                  │
           │                                  ▼
           │                        ┌──────────────────────┐
           │                        │ Monitoring Bus       │
           │                        │ ─────────────────── │
           │                        │ ├─ Status semua bu  │
           │                        │ ├─ Kondisi operasi  │
           │                        │ └─ Alert/Warning    │
           │                        └──────────┬──────────┘
           │                                  │
           │                                  ▼
           │                        ┌──────────────────────┐
           │                        │ Notifikasi WhatsApp  │
           │                        │ ke Sopir/Mekanik     │
           │                        └──────────┬──────────┘
           │                                  │
           └──────────────────────────────────┤
                                              │
                                              ▼
                                         ┌──────────┐
                                         │  Logout  │
                                         └──────────┘
```

---

### 3. **Admin**

**Responsibilities:**

- Semua fitur User (kelola armada, jadwal, riwayat)
- Kelola pengguna (User Management)
- Akses laporan lengkap
- Konfigurasi sistem
- Ekspor laporan

**Alur Aktivitas Admin:**

```
┌──────────┐
│  Admin   │
└─────┬────┘
      │
      ▼
  ┌─────────────┐
  │    Login    │
  └─────┬───────┘
        │
        ├──────────────────────────────────────────────┐
        │                                              │
        ▼                                              ▼
  ┌────────────────┐                        ┌──────────────────────┐
  │  Dashboard     │                        │ Kelola Pengguna      │
  │  Admin         │                        │ ─────────────────── │
  │                │                        │ ├─ Lihat users      │
  │ - Statistik    │                        │ ├─ Tambah user      │
  │   lengkap      │                        │ ├─ Edit user        │
  │ - Total data   │                        │ ├─ Hapus user       │
  │ - Laporan cepat│                        │ └─ Tentukan role    │
  └────────┬───────┘                        └──────────┬──────────┘
           │                                           │
           │◄──────────────────────────────────────────┤
           │                                           │
           ├──────────────────────────────────────────┐│
           │                                          ││
           ▼                                          ▼▼
  ┌────────────────┐                        ┌──────────────────────┐
  │ Kelola Armada  │                        │ Akses Laporan        │
  │ (Admin View)   │                        │ ─────────────────── │
  │ ─────────────  │                        │ ├─ Laporan Armada   │
  │ ├─ Lihat semua │                        │ ├─ Laporan Jadwal   │
  │ ├─ Tambah      │                        │ ├─ Laporan Riwayat  │
  │ ├─ Edit        │                        │ ├─ Status Maint     │
  │ └─ Hapus       │                        │ └─ Ekspor PDF/Excel │
  └────────┬───────┘                        └──────────┬──────────┘
           │                                          │
           ├──────────────────────────────────────────┤
           │                                          │
           ▼                                          ▼
  ┌────────────────┐                        ┌──────────────────────┐
  │ Kelola Jadwal  │                        │ Monitoring Bus       │
  │ ─────────────  │                        │ ─────────────────── │
  │ ├─ CRUD Jadwal │                        │ ├─ Semua Status    │
  │ └─ Assign      │                        │ └─ Real-time View  │
  └────────┬───────┘                        └──────────┬──────────┘
           │                                          │
           ├──────────────────────────────────────────┤
           │                                          │
           ▼                                          ▼
  ┌────────────────┐                        ┌──────────────────────┐
  │ Kelola Riwayat │                        │ Notifikasi System    │
  │ Pemeliharaan   │                        │ ─────────────────── │
  │ ─────────────  │                        │ └─ Kirim reminder   │
  │ ├─ CRUD Record │                        └──────────┬──────────┘
  │ └─ Tracking    │                                   │
  └────────┬───────┘                                   │
           │                                          │
           └──────────────────────────────────────────┤
                                                      │
                                                      ▼
                                                 ┌──────────┐
                                                 │  Logout  │
                                                 └──────────┘
```

---

### 4. **Manager Teknik (Technical Manager)**

**Responsibilities:**

- Lihat semua data armada
- Kelola jadwal servis
- Kelola riwayat pemeliharaan
- Monitoring status kendaraan
- Akses laporan

**Alur Aktivitas Manager Teknik:**

```
┌────────────────┐
│ Manager Teknik │
└────────┬───────┘
         │
         ▼
     ┌─────────────┐
     │    Login    │
     └────────┬────┘
              │
              ├──────────────────────────────────────┐
              │                                      │
              ▼                                      ▼
    ┌──────────────────┐                 ┌────────────────────┐
    │  Dashboard       │                 │ Monitoring Bus     │
    │  Manager Teknik  │                 │ ─────────────────  │
    │                  │                 │ ├─ Status operasi  │
    │ - Jadwal pending │                 │ ├─ Alert/warning   │
    │ - Due servis     │                 │ └─ Kondisi armada  │
    │ - Riwayat last   │                 └────────┬───────────┘
    │   maintenance    │                         │
    └────────┬─────────┘                         │
             │                                   │
             ├───────────────────────────────────┤
             │                                   │
             ▼                                   ▼
    ┌──────────────────┐                 ┌────────────────────┐
    │ Kelola Jadwal    │                 │ Kelola Riwayat     │
    │ Servis           │                 │ Pemeliharaan       │
    │ ─────────────── │                 │ ─────────────────  │
    │ ├─ Lihat jadwal │                 │ ├─ Catat pemeliharan
    │ ├─ Buat jadwal  │                 │ ├─ Edit record      │
    │ ├─ Edit jadwal  │                 │ ├─ Tracking status │
    │ └─ Assign       │                 │ └─ History view    │
    └────────┬─────────┘                 └────────┬───────────┘
             │                                   │
             │                                   │
             ├───────────────────────────────────┤
             │                                   │
             ▼                                   ▼
    ┌──────────────────┐                 ┌────────────────────┐
    │ Lihat Data       │                 │ Akses Laporan      │
    │ Armada           │                 │ ─────────────────  │
    │ ─────────────── │                 │ ├─ Laporan Jadwal  │
    │ └─ View Detail   │                 │ ├─ Laporan Riwayat │
    └────────┬─────────┘                 │ └─ Export reports  │
             │                           └────────┬───────────┘
             │                                   │
             └───────────────────────────────────┤
                                                 │
                                                 ▼
                                            ┌──────────┐
                                            │  Logout  │
                                            └──────────┘
```

---

## 🔄 Alur Data Utama

### Use Case 1: Input Data Armada oleh Sopir

```
Sopir Login
    ↓
Dashboard Sopir
    ↓
Pilih "Input Data Armada"
    ↓
Form Input:
  - Nomor Polisi / AT (4 digit)
  - Plat Nomor
  - Merk/Model
  - Tahun
  - Kapasitas
    ↓
Submit Form
    ↓
Validasi Data
    ├─ Cek unique nomor polisi
    ├─ Cek format AT (4 digit)
    └─ Cek kapasitas > 0
    ↓ (Success)
Simpan ke Database
    ↓
Notifikasi: "Data armada berhasil ditambahkan"
    ↓
Return ke Dashboard
```

---

### Use Case 2: Kelola Jadwal Servis oleh User/Manager

```
User/Manager Login
    ↓
Dashboard
    ↓
Pilih "Jadwal Servis"
    ↓
┌─────────────────────────────────┐
│ Opsi:                           │
│ 1. Lihat semua jadwal           │
│ 2. Buat jadwal baru             │
│ 3. Edit jadwal existing         │
│ 4. Hapus jadwal (Admin only)    │
└─────────────────────────────────┘
    ↓
(Jika Buat Jadwal)
Form Input:
  - Pilih Kendaraan
  - Tipe Servis (Rutin/Berkala/Perbaikan)
  - Tanggal Jadwal
  - Deskripsi
  - Mekanik yang ditugaskan
    ↓
Submit Form
    ↓
Validasi Data
    ├─ Cek kendaraan exists
    ├─ Cek tanggal valid
    └─ Cek mekanik tersedia
    ↓ (Success)
Simpan ke Database
    ↓
Kirim Notifikasi WhatsApp:
  - Ke Mekanik (jadwal baru)
  - Ke Sopir (jadwal reminder)
    ↓
Notifikasi Success
    ↓
Return ke Dashboard
```

---

### Use Case 3: Catat Riwayat Pemeliharaan

```
User/Manager Login
    ↓
Dashboard
    ↓
Pilih "Riwayat Pemeliharaan"
    ↓
Pilih "Catat Pemeliharaan Baru"
    ↓
Form Input:
  - Pilih Kendaraan
  - Tanggal Pemeliharaan
  - Tipe Servis (dropdown)
  - Deskripsi Pekerjaan
  - Biaya
  - Mekanik (auto-filled if from schedule)
  - Parts Used (optional)
    ↓
Submit Form
    ↓
Validasi Data
    ├─ Cek kendaraan exists
    ├─ Cek deskripsi >= 10 karakter
    ├─ Cek biaya >= 0
    └─ Cek mekanik exists
    ↓ (Success)
Simpan Record
    ↓
Update Schedule Status (jika dari jadwal)
  Schedule.status = 'completed'
    ↓
Kirim Notifikasi WhatsApp:
  - Ke Sopir (maintenance selesai)
    ↓
Success Message
    ↓
Return ke Dashboard
```

---

### Use Case 4: Generate & Export Laporan

```
Admin/Manager Login
    ↓
Dashboard
    ↓
Pilih "Laporan"
    ↓
┌────────────────────────────┐
│ Tipe Laporan:              │
│ 1. Data Armada             │
│ 2. Jadwal Servis           │
│ 3. Riwayat Pemeliharaan    │
│ 4. Status Maintenance      │
│ 5. Kondisi Armada          │
└────────────────────────────┘
    ↓
Pilih Tipe & Filter:
  - Periode Tanggal
  - Kategori Kendaraan (optional)
  - Status Filter (optional)
    ↓
Generate Report
    ↓
Query Database (dengan filter)
    ↓
Display Results
    ├─ Tabel data
    ├─ Statistik
    └─ Chart/Graph
    ↓
Opsi Export
    ├─ PDF
    ├─ Excel
    └─ CSV
    ↓
Download File
    ↓
Sukses
```

---

### Use Case 5: User Management oleh Admin

```
Admin Login
    ↓
Dashboard
    ↓
Pilih "Kelola Pengguna"
    ↓
┌────────────────────────┐
│ User List:             │
│ - Nama                 │
│ - Email                │
│ - Role                 │
│ - Status Active        │
│ - Action (Edit/Delete) │
└────────────────────────┘
    ↓
┌─────────────────────────────┐
│ Opsi:                       │
│ 1. Lihat semua user         │
│ 2. Tambah user baru         │
│ 3. Edit user                │
│ 4. Hapus user               │
│ 5. Reset password           │
└─────────────────────────────┘
    ↓
(Jika Tambah User)
Form Input:
  - Nama
  - Email
  - Password
  - Role (Sopir/User/Manager/Admin)
  - WhatsApp Number
  - Status Active
    ↓
Submit Form
    ↓
Validasi Data
    ├─ Cek email unique
    ├─ Cek password strength
    ├─ Cek nomor WA format
    └─ Cek role valid
    ↓ (Success)
Hash Password & Simpan
    ↓
Kirim Email Welcome (optional)
    ↓
Success Message
    ↓
Return ke User List
```

---

## 📱 Notifikasi WhatsApp

**Trigger Points:**

1. **Jadwal Servis Baru**
    - Penerima: Mekanik yang ditugaskan, Sopir (reminder)
    - Pesan: "Jadwal servis untuk kendaraan {nomor_polisi} pada {tanggal}"

2. **Maintenance Selesai**
    - Penerima: Sopir
    - Pesan: "Pemeliharaan kendaraan {nomor_polisi} telah selesai"

3. **Servis Overdue**
    - Penerima: Manager Teknik
    - Pesan: "Kendaraan {nomor_polisi} servis {hari} hari terlambat"

4. **Status Alert**
    - Penerima: Admin, Manager
    - Pesan: "Kendaraan {nomor_polisi} status: {status}"

---

## 🔐 Access Control

| Feature         | Sopir | User | Admin | Manager |
| --------------- | ----- | ---- | ----- | ------- |
| Login           | ✓     | ✓    | ✓     | ✓       |
| Dashboard       | ✓     | ✓    | ✓     | ✓       |
| Input Armada    | ✓     | ✓    | ✓     | ✓       |
| View Armada     | ✓\*   | ✓    | ✓     | ✓       |
| Edit Armada     | ✗     | ✓    | ✓     | ✗       |
| Delete Armada   | ✗     | ✗    | ✓     | ✗       |
| View Schedule   | ✓\*   | ✓    | ✓     | ✓       |
| Create Schedule | ✗     | ✗    | ✓     | ✓       |
| Edit Schedule   | ✗     | ✓    | ✓     | ✓       |
| Delete Schedule | ✗     | ✗    | ✓     | ✗       |
| View History    | ✓     | ✓    | ✓     | ✓       |
| Record History  | ✗     | ✓    | ✓     | ✓       |
| Edit History    | ✗     | ✓    | ✓     | ✓       |
| Delete History  | ✗     | ✗    | ✓     | ✗       |
| Monitoring      | ✓     | ✗    | ✓     | ✓       |
| Reports         | ✗     | ✗    | ✓     | ✓       |
| User Management | ✗     | ✗    | ✓     | ✗       |
| Export          | ✗     | ✗    | ✓     | ✓       |

\*Sopir hanya melihat kendaraan yang ditugaskan kepadanya

---

## 🛠️ Implementation Notes

1. **Role-based Middleware**: Gunakan middleware untuk mengecek role sebelum akses fitur
2. **Database Indexes**: Index pada `users.role`, `maintenance_schedules.status`, `vehicles.status`
3. **Query Optimization**: Gunakan eager loading (with()) untuk menghindari N+1 queries
4. **Validation**: Implement form validation di controller & frontend
5. **Notifications**: Gunakan job queue untuk kirim notifikasi async
6. **Audit Trail**: Log setiap perubahan data penting (optional)

---

Dokumentasi ini menjelaskan alur lengkap sistem dengan semua aktor dan use cases yang terlibat.
