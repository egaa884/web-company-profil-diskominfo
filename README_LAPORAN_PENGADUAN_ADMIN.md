# Sistem Laporan Pengaduan Admin - Diskominfo Kota Madiun

## 🎯 **Overview**

Sistem Laporan Pengaduan Admin adalah sistem baru yang menggantikan sistem pengaduan user-submitted dengan sistem laporan yang dibuat oleh admin Diskominfo Kota Madiun. Sistem ini mengikuti format yang sama dengan website resmi Kominfo Madiun ([https://kominfo.madiunkota.go.id](https://kominfo.madiunkota.go.id)).

## 🚀 **Fitur Utama**

### **Backend (Laravel)**
- ✅ **CRUD Operations**: Create, Read, Update, Delete laporan pengaduan admin
- ✅ **File Upload**: Support untuk upload file PDF laporan (maksimal 10MB)
- ✅ **Publication System**: Sistem publikasi laporan (draft/published)
- ✅ **Statistics Tracking**: Tracking statistik pengaduan (total, diproses, selesai, ditolak)
- ✅ **Period Management**: Manajemen periode laporan (bulan dan tahun)
- ✅ **Admin Interface**: Interface admin untuk mengelola laporan
- ✅ **API Endpoints**: API untuk frontend integration

### **Frontend (Vue.js)**
- ✅ **Responsive Design**: Tampilan responsif untuk semua device
- ✅ **Statistics Dashboard**: Dashboard statistik laporan
- ✅ **Filter & Search**: Filter berdasarkan bulan, tahun, dan pencarian
- ✅ **Card Layout**: Tampilan card yang modern dan informatif
- ✅ **File Download**: Download file laporan PDF
- ✅ **Pagination**: Navigasi halaman untuk data yang banyak

## 📊 **Struktur Data**

### **Table: `laporan_pengaduan_admin`**
```sql
- id (Primary Key)
- judul (String) - Judul laporan
- deskripsi (Text) - Deskripsi lengkap laporan
- bulan (String) - Bulan laporan (Januari, Februari, dll)
- tahun (Integer) - Tahun laporan
- file_lampiran (String) - Path file PDF laporan
- kategori (String) - Kategori laporan
- ringkasan (Text) - Ringkasan laporan
- total_pengaduan (Integer) - Total pengaduan
- pengaduan_diproses (Integer) - Pengaduan sedang diproses
- pengaduan_selesai (Integer) - Pengaduan selesai
- pengaduan_ditolak (Integer) - Pengaduan ditolak
- catatan_admin (Text) - Catatan internal admin
- admin_id (Foreign Key) - Admin yang membuat laporan
- is_published (Boolean) - Status publikasi
- tanggal_publikasi (Timestamp) - Tanggal publikasi
- created_at, updated_at (Timestamps)
```

## 🔧 **Instalasi & Setup**

### **1. Backend Setup**
```bash
cd backend
composer install
php artisan migrate
php artisan db:seed --class=LaporanPengaduanAdminSeeder
php artisan serve
```

### **2. Frontend Setup**
```bash
cd frontend
npm install
npm run dev
```

## 📁 **Struktur File**

### **Backend**
```
backend/
├── app/
│   ├── Models/
│   │   └── LaporanPengaduanAdmin.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   └── LaporanPengaduanAdminController.php
│   │   │   └── Api/
│   │   │       └── LaporanPengaduanAdminApiController.php
│   │   └── Resources/
│   │       └── LaporanPengaduanAdminResource.php
│   └── database/
│       ├── migrations/
│       │   └── 2025_01_15_000000_create_laporan_pengaduan_admin_table.php
│       └── seeders/
│           └── LaporanPengaduanAdminSeeder.php
└── resources/views/admin/laporan_pengaduan_admin/
    ├── index.blade.php
    ├── create.blade.php
    ├── edit.blade.php
    └── show.blade.php
```

### **Frontend**
```
frontend/src/
├── views/
│   └── LaporanPengaduan.vue
├── components/laporanpengaduanadmin/
│   ├── CardList.vue
│   └── HeroSection.vue
└── service/
    └── api.js (updated with laporanPengaduanAdminService)
```

## 🌐 **API Endpoints**

### **Public API (No Authentication)**
```
GET /api/laporan-pengaduan-admin - Daftar laporan yang dipublikasi
GET /api/laporan-pengaduan-admin/{id} - Detail laporan
GET /api/laporan-pengaduan-admin/statistics - Statistik laporan
GET /api/laporan-pengaduan-admin/years - Daftar tahun tersedia
GET /api/laporan-pengaduan-admin/months - Daftar bulan tersedia
GET /api/laporan-pengaduan-admin/latest - Laporan terbaru
GET /api/laporan-pengaduan-admin/{id}/download - Download file
```

### **Admin Routes (Authentication Required)**
```
GET /admin/laporan-pengaduan-admin - Daftar semua laporan
GET /admin/laporan-pengaduan-admin/create - Form buat laporan
POST /admin/laporan-pengaduan-admin - Simpan laporan baru
GET /admin/laporan-pengaduan-admin/{id}/edit - Form edit laporan
PUT /admin/laporan-pengaduan-admin/{id} - Update laporan
DELETE /admin/laporan-pengaduan-admin/{id} - Hapus laporan
PATCH /admin/laporan-pengaduan-admin/{id}/toggle-publish - Toggle publikasi
GET /admin/laporan-pengaduan-admin/{id}/download - Download file
```

## 🎨 **UI/UX Features**

### **Admin Interface**
- Dashboard dengan statistik
- Form CRUD yang user-friendly
- File upload dengan validasi
- Toggle publikasi laporan
- Download file laporan

### **Public Interface**
- Hero section yang menarik
- Card layout yang modern
- Filter berdasarkan bulan dan tahun
- Statistik dashboard
- Download file laporan

## 🔒 **Security Features**

- File upload validation (PDF, DOC, DOCX only)
- File size limit (10MB)
- Admin authentication required for management
- Unique constraint on bulan + tahun combination
- Proper file storage and access control

## 📱 **Responsive Design**

- Mobile-first approach
- Grid layout yang adaptif
- Touch-friendly interface
- Optimized for all screen sizes

## 🚀 **Deployment**

### **Backend**
```bash
# Production setup
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

### **Frontend**
```bash
# Build for production
npm run build
```

## 📝 **Sample Data**

Sistem sudah dilengkapi dengan sample data untuk 5 bulan terakhir (Februari - Juni 2025) dengan statistik yang realistis.

## 🔄 **Migration from Old System**

Sistem lama (user-submitted complaints) telah dihapus dan diganti dengan sistem baru ini. Semua file terkait sistem lama telah dihapus:

- ❌ `LaporanPengaduan` model
- ❌ `LaporanPengaduanController` 
- ❌ `LaporanPengaduanApiController`
- ❌ Old migration files
- ❌ Old frontend components

## 📞 **Support**

Untuk bantuan teknis atau pertanyaan, silakan hubungi tim development Diskominfo Kota Madiun.

---

**Dibuat oleh:** Tim Development Diskominfo Kota Madiun  
**Versi:** 2.0.0  
**Tanggal:** Januari 2025
