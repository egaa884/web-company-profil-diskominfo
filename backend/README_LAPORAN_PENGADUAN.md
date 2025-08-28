# Laporan Pengaduan Pelayanan Publik - Backend System

## Overview
Backend sistem Laporan Pengaduan Pelayanan Publik untuk Dinas Komunikasi dan Informatika Kota Madiun. Sistem ini dibangun menggunakan Laravel 11 dengan PostgreSQL database.

## Features

### Core Features
- ✅ **CRUD Operations**: Create, Read, Update, Delete laporan pengaduan
- ✅ **File Upload**: Support untuk upload file lampiran (PDF, DOC, DOCX, JPG, JPEG, PNG)
- ✅ **Status Management**: Tracking status pengaduan (pending, diproses, selesai, ditolak)
- ✅ **Priority System**: Sistem prioritas (rendah, normal, tinggi, kritis)
- ✅ **Category Management**: Kategori pengaduan yang dapat dikustomisasi
- ✅ **Search & Filter**: Pencarian dan filter berdasarkan berbagai kriteria
- ✅ **Statistics Dashboard**: Statistik untuk dashboard admin
- ✅ **Pagination**: Pagination untuk data yang besar
- ✅ **API Authentication**: Laravel Sanctum untuk protected endpoints

### Data Fields
- **Judul**: Judul pengaduan
- **Deskripsi**: Detail pengaduan
- **Kategori**: Kategori pengaduan (Pelayanan Publik, Infrastruktur, dll)
- **Status**: Status pengaduan (pending, diproses, selesai, ditolak)
- **Prioritas**: Prioritas pengaduan (rendah, normal, tinggi, kritis)
- **Data Pelapor**: Nama, email, telepon, alamat, NIK
- **File Lampiran**: File pendukung (opsional)
- **Catatan Admin**: Catatan dari admin untuk follow-up
- **Timestamps**: Tanggal pengaduan, tanggal selesai, created_at, updated_at

## Database Structure

### Table: `laporan_pengaduan`
```sql
CREATE TABLE laporan_pengaduan (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL,
    kategori_pengaduan VARCHAR(100) NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    prioritas VARCHAR(50) DEFAULT 'normal',
    nama_pelapor VARCHAR(255) NOT NULL,
    email_pelapor VARCHAR(255) NOT NULL,
    telepon_pelapor VARCHAR(20) NULL,
    alamat_pelapor TEXT NULL,
    nik_pelapor VARCHAR(16) NULL,
    file_lampiran VARCHAR(255) NULL,
    catatan_admin TEXT NULL,
    tanggal_pengaduan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tanggal_selesai TIMESTAMP NULL,
    admin_id BIGINT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE SET NULL
);
```

## API Endpoints

### Public Endpoints (No Authentication Required)

#### 1. Get All Complaints
```
GET /api/laporan-pengaduan
```
**Query Parameters:**
- `status`: Filter by status
- `prioritas`: Filter by priority
- `kategori`: Filter by category
- `tanggal_mulai`: Start date (YYYY-MM-DD)
- `tanggal_akhir`: End date (YYYY-MM-DD)
- `search`: Search in title, description, or reporter name
- `sort_by`: Sort field (default: tanggal_pengaduan)
- `sort_order`: Sort order (asc/desc, default: desc)
- `per_page`: Items per page (default: 15)

#### 2. Create New Complaint
```
POST /api/laporan-pengaduan
```
**Required Fields:**
- `judul`: String (max 255 chars)
- `deskripsi`: Text
- `kategori_pengaduan`: String (max 100 chars)
- `nama_pelapor`: String (max 255 chars)
- `email_pelapor`: Valid email

**Optional Fields:**
- `prioritas`: rendah/normal/tinggi/kritis
- `telepon_pelapor`: String (max 20 chars)
- `alamat_pelapor`: Text
- `nik_pelapor`: String (max 16 chars)
- `file_lampiran`: File (max 2MB, formats: pdf, doc, docx, jpg, jpeg, png)

#### 3. Get Single Complaint
```
GET /api/laporan-pengaduan/{id}
```

#### 4. Get Categories
```
GET /api/laporan-pengaduan/categories
```

#### 5. Get Statistics
```
GET /api/laporan-pengaduan/statistics
```

### Protected Endpoints (Authentication Required)

#### 6. Update Complaint
```
PUT /api/laporan-pengaduan/{id}
```

#### 7. Update Status Only
```
PATCH /api/laporan-pengaduan/{id}/status
```

#### 8. Delete Complaint
```
DELETE /api/laporan-pengaduan/{id}
```

#### 9. Download Attachment
```
GET /api/laporan-pengaduan/{id}/download
```

## Installation & Setup

### Prerequisites
- PHP 8.2+
- Composer
- PostgreSQL
- Laravel 11

### Installation Steps

1. **Clone the repository**
```bash
git clone <repository-url>
cd backend
```

2. **Install dependencies**
```bash
composer install
```

3. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database configuration**
Edit `.env` file:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Run migrations**
```bash
php artisan migrate
```

6. **Seed sample data**
```bash
php artisan db:seed --class=LaporanPengaduanSeeder
```

7. **Create storage link**
```bash
php artisan storage:link
```

8. **Start the server**
```bash
php artisan serve
```

## File Structure

```
backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       └── LaporanPengaduanController.php
│   │   ├── Requests/
│   │   │   └── LaporanPengaduanRequest.php
│   │   └── Resources/
│   │       └── LaporanPengaduanResource.php
│   └── Models/
│       └── LaporanPengaduan.php
├── database/
│   ├── migrations/
│   │   └── 2025_08_22_000000_create_laporan_pengaduan_table.php
│   ├── seeders/
│   │   └── LaporanPengaduanSeeder.php
│   └── factories/
│       └── LaporanPengaduanFactory.php
├── routes/
│   └── api.php
└── storage/
    └── app/
        └── public/
            └── lampiran_pengaduan/
```

## Usage Examples

### Creating a New Complaint
```javascript
const response = await fetch('/api/laporan-pengaduan', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        judul: 'Jalan Rusak di Kelurahan Kartoharjo',
        deskripsi: 'Jalan utama mengalami kerusakan parah...',
        kategori_pengaduan: 'Infrastruktur',
        nama_pelapor: 'Budi Santoso',
        email_pelapor: 'budi@example.com',
        telepon_pelapor: '081234567890'
    })
});

const data = await response.json();
console.log(data);
```

### Getting Statistics
```javascript
const response = await fetch('/api/laporan-pengaduan/statistics');
const data = await response.json();
console.log(data.data);
// Output:
// {
//   total: 28,
//   pending: 7,
//   diproses: 8,
//   selesai: 6,
//   ditolak: 7,
//   monthly_stats: [...],
//   category_stats: [...]
// }
```

### Filtering Complaints
```javascript
const response = await fetch('/api/laporan-pengaduan?status=pending&prioritas=tinggi&per_page=10');
const data = await response.json();
console.log(data.data);
```

## Configuration

### File Upload Settings
- **Max file size**: 2MB
- **Allowed formats**: PDF, DOC, DOCX, JPG, JPEG, PNG
- **Storage location**: `storage/app/public/lampiran_pengaduan/`

### Pagination
- **Default per page**: 15 items
- **Max per page**: 100 items

### Status Values
- `pending`: Menunggu
- `diproses`: Sedang Diproses
- `selesai`: Selesai
- `ditolak`: Ditolak

### Priority Values
- `rendah`: Rendah
- `normal`: Normal
- `tinggi`: Tinggi
- `kritis`: Kritis

## Testing

### Manual Testing
Use the provided API documentation or test with tools like:
- Postman
- Insomnia
- cURL
- Browser Developer Tools

### Automated Testing
```bash
php artisan test
```

## Security Features

- **Input Validation**: Comprehensive validation for all inputs
- **File Upload Security**: File type and size validation
- **SQL Injection Protection**: Laravel Eloquent ORM
- **XSS Protection**: Laravel built-in protection
- **CSRF Protection**: Laravel CSRF tokens
- **Authentication**: Laravel Sanctum for protected endpoints

## Performance Optimizations

- **Database Indexing**: Indexes on frequently queried columns
- **Eager Loading**: Relationships loaded efficiently
- **Pagination**: Prevents loading large datasets
- **File Storage**: Efficient file storage with Laravel Storage

## Monitoring & Logging

- **Laravel Logs**: Check `storage/logs/laravel.log`
- **Database Logs**: PostgreSQL logs
- **Error Tracking**: Laravel's built-in error handling

## Deployment

### Production Checklist
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Configure database for production
- [ ] Set up proper file permissions
- [ ] Configure web server (Apache/Nginx)
- [ ] Set up SSL certificate
- [ ] Configure backup strategy
- [ ] Set up monitoring

### Environment Variables
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
DB_CONNECTION=pgsql
DB_HOST=your-db-host
DB_DATABASE=your-db-name
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password
```

## Support & Maintenance

### Common Issues
1. **File upload fails**: Check storage permissions and disk space
2. **Database connection**: Verify database credentials and connection
3. **API returns 500**: Check Laravel logs for detailed error messages

### Maintenance Tasks
- Regular database backups
- Log file rotation
- File storage cleanup
- Performance monitoring
- Security updates

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Contact

For support or questions, contact:
- Email: admin@kominfo.madiunkota.go.id
- Website: https://kominfo.madiunkota.go.id 