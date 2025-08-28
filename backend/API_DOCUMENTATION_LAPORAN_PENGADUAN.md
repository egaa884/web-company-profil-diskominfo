# API Documentation - Laporan Pengaduan Pelayanan Publik

## Overview
API untuk sistem Laporan Pengaduan Pelayanan Publik Dinas Komunikasi dan Informatika Kota Madiun.

## Base URL
```
http://localhost:8000/api
```

## Authentication
- Public endpoints: Tidak memerlukan authentication
- Protected endpoints: Memerlukan Bearer token (Laravel Sanctum)

## Endpoints

### 1. Get All Laporan Pengaduan (Public)
**GET** `/laporan-pengaduan`

**Query Parameters:**
- `status` (optional): Filter by status (pending, diproses, selesai, ditolak)
- `prioritas` (optional): Filter by priority (rendah, normal, tinggi, kritis)
- `kategori` (optional): Filter by category
- `tanggal_mulai` (optional): Start date (YYYY-MM-DD)
- `tanggal_akhir` (optional): End date (YYYY-MM-DD)
- `search` (optional): Search in title, description, or reporter name
- `sort_by` (optional): Sort field (default: tanggal_pengaduan)
- `sort_order` (optional): Sort order (asc/desc, default: desc)
- `per_page` (optional): Items per page (default: 15)

**Response:**
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "judul": "Jalan Rusak di Kelurahan Kartoharjo",
                "deskripsi": "Jalan utama di Kelurahan Kartoharjo mengalami kerusakan parah...",
                "kategori_pengaduan": "Infrastruktur",
                "status": "diproses",
                "status_label": "Sedang Diproses",
                "status_color": "blue",
                "prioritas": "tinggi",
                "prioritas_label": "Tinggi",
                "prioritas_color": "orange",
                "nama_pelapor": "Budi Santoso",
                "email_pelapor": "budi.santoso@email.com",
                "telepon_pelapor": "081234567890",
                "alamat_pelapor": "Jl. Kartoharjo No. 45, Kota Madiun",
                "nik_pelapor": "3573011234567890",
                "file_lampiran": null,
                "file_lampiran_name": null,
                "catatan_admin": null,
                "tanggal_pengaduan": "2025-08-15 10:30:00",
                "tanggal_pengaduan_formatted": "15 August 2025 10:30",
                "tanggal_selesai": null,
                "tanggal_selesai_formatted": null,
                "admin": null,
                "created_at": "2025-08-15 10:30:00",
                "updated_at": "2025-08-15 10:30:00"
            }
        ],
        "total": 28,
        "per_page": 15
    },
    "message": "Data laporan pengaduan berhasil diambil"
}
```

### 2. Create New Laporan Pengaduan (Public)
**POST** `/laporan-pengaduan`

**Request Body (multipart/form-data):**
```json
{
    "judul": "Jalan Rusak di Kelurahan Kartoharjo",
    "deskripsi": "Jalan utama di Kelurahan Kartoharjo mengalami kerusakan parah yang mengganggu lalu lintas.",
    "kategori_pengaduan": "Infrastruktur",
    "prioritas": "tinggi",
    "nama_pelapor": "Budi Santoso",
    "email_pelapor": "budi.santoso@email.com",
    "telepon_pelapor": "081234567890",
    "alamat_pelapor": "Jl. Kartoharjo No. 45, Kota Madiun",
    "nik_pelapor": "3573011234567890",
    "file_lampiran": "file" // optional, max 2MB, formats: pdf, doc, docx, jpg, jpeg, png
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 29,
        "judul": "Jalan Rusak di Kelurahan Kartoharjo",
        "deskripsi": "Jalan utama di Kelurahan Kartoharjo mengalami kerusakan parah yang mengganggu lalu lintas.",
        "kategori_pengaduan": "Infrastruktur",
        "status": "pending",
        "status_label": "Menunggu",
        "status_color": "yellow",
        "prioritas": "tinggi",
        "prioritas_label": "Tinggi",
        "prioritas_color": "orange",
        "nama_pelapor": "Budi Santoso",
        "email_pelapor": "budi.santoso@email.com",
        "telepon_pelapor": "081234567890",
        "alamat_pelapor": "Jl. Kartoharjo No. 45, Kota Madiun",
        "nik_pelapor": "3573011234567890",
        "file_lampiran": "http://localhost:8000/storage/lampiran_pengaduan/1734854400_document.pdf",
        "file_lampiran_name": "1734854400_document.pdf",
        "catatan_admin": null,
        "tanggal_pengaduan": "2025-08-22 08:00:00",
        "tanggal_pengaduan_formatted": "22 August 2025 08:00",
        "tanggal_selesai": null,
        "tanggal_selesai_formatted": null,
        "admin": null,
        "created_at": "2025-08-22 08:00:00",
        "updated_at": "2025-08-22 08:00:00"
    },
    "message": "Laporan pengaduan berhasil dibuat"
}
```

### 3. Get Single Laporan Pengaduan (Public)
**GET** `/laporan-pengaduan/{id}`

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "judul": "Jalan Rusak di Kelurahan Kartoharjo",
        "deskripsi": "Jalan utama di Kelurahan Kartoharjo mengalami kerusakan parah...",
        "kategori_pengaduan": "Infrastruktur",
        "status": "diproses",
        "status_label": "Sedang Diproses",
        "status_color": "blue",
        "prioritas": "tinggi",
        "prioritas_label": "Tinggi",
        "prioritas_color": "orange",
        "nama_pelapor": "Budi Santoso",
        "email_pelapor": "budi.santoso@email.com",
        "telepon_pelapor": "081234567890",
        "alamat_pelapor": "Jl. Kartoharjo No. 45, Kota Madiun",
        "nik_pelapor": "3573011234567890",
        "file_lampiran": null,
        "file_lampiran_name": null,
        "catatan_admin": null,
        "tanggal_pengaduan": "2025-08-15 10:30:00",
        "tanggal_pengaduan_formatted": "15 August 2025 10:30",
        "tanggal_selesai": null,
        "tanggal_selesai_formatted": null,
        "admin": {
            "id": 1,
            "nama": "Admin Name",
            "email": "admin@example.com"
        },
        "created_at": "2025-08-15 10:30:00",
        "updated_at": "2025-08-15 10:30:00"
    },
    "message": "Data laporan pengaduan berhasil diambil"
}
```

### 4. Get Categories (Public)
**GET** `/laporan-pengaduan/categories`

**Response:**
```json
{
    "success": true,
    "data": [
        "Pelayanan Publik",
        "Infrastruktur",
        "Administrasi",
        "Keamanan",
        "Kesehatan",
        "Pendidikan",
        "Transportasi",
        "Lingkungan"
    ],
    "message": "Kategori pengaduan berhasil diambil"
}
```

### 5. Get Statistics (Public)
**GET** `/laporan-pengaduan/statistics`

**Response:**
```json
{
    "success": true,
    "data": {
        "total": 28,
        "pending": 5,
        "diproses": 8,
        "selesai": 12,
        "ditolak": 3,
        "monthly_stats": [
            {
                "month": 6,
                "total": 15
            },
            {
                "month": 7,
                "total": 8
            },
            {
                "month": 8,
                "total": 5
            }
        ],
        "category_stats": [
            {
                "kategori_pengaduan": "Infrastruktur",
                "total": 8
            },
            {
                "kategori_pengaduan": "Pelayanan Publik",
                "total": 6
            },
            {
                "kategori_pengaduan": "Administrasi",
                "total": 4
            }
        ]
    },
    "message": "Statistik laporan pengaduan berhasil diambil"
}
```

## Protected Endpoints (Require Authentication)

### 6. Update Laporan Pengaduan (Protected)
**PUT** `/laporan-pengaduan/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body (multipart/form-data):**
```json
{
    "judul": "Jalan Rusak di Kelurahan Kartoharjo - Updated",
    "deskripsi": "Updated description...",
    "kategori_pengaduan": "Infrastruktur",
    "status": "selesai",
    "prioritas": "tinggi",
    "nama_pelapor": "Budi Santoso",
    "email_pelapor": "budi.santoso@email.com",
    "telepon_pelapor": "081234567890",
    "alamat_pelapor": "Jl. Kartoharjo No. 45, Kota Madiun",
    "nik_pelapor": "3573011234567890",
    "catatan_admin": "Sudah ditangani dengan perbaikan jalan",
    "admin_id": 1,
    "file_lampiran": "file" // optional
}
```

### 7. Update Status Only (Protected)
**PATCH** `/laporan-pengaduan/{id}/status`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "status": "selesai",
    "catatan_admin": "Sudah ditangani dengan perbaikan jalan"
}
```

### 8. Delete Laporan Pengaduan (Protected)
**DELETE** `/laporan-pengaduan/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "message": "Laporan pengaduan berhasil dihapus"
}
```

### 9. Download Attachment (Protected)
**GET** `/laporan-pengaduan/{id}/download`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "url": "http://localhost:8000/storage/lampiran_pengaduan/1734854400_document.pdf",
        "filename": "1734854400_document.pdf"
    },
    "message": "URL download berhasil dibuat"
}
```

## Status Values
- `pending`: Menunggu
- `diproses`: Sedang Diproses
- `selesai`: Selesai
- `ditolak`: Ditolak

## Priority Values
- `rendah`: Rendah
- `normal`: Normal
- `tinggi`: Tinggi
- `kritis`: Kritis

## Error Responses

### Validation Error (422)
```json
{
    "success": false,
    "message": "Validasi gagal",
    "errors": {
        "judul": ["Judul pengaduan harus diisi"],
        "email_pelapor": ["Format email tidak valid"]
    }
}
```

### Not Found Error (404)
```json
{
    "success": false,
    "message": "Laporan pengaduan tidak ditemukan"
}
```

### Unauthorized Error (401)
```json
{
    "message": "Unauthenticated."
}
```

## Testing with cURL

### Create New Complaint
```bash
curl -X POST http://localhost:8000/api/laporan-pengaduan \
  -H "Content-Type: multipart/form-data" \
  -F "judul=Test Pengaduan" \
  -F "deskripsi=Ini adalah test pengaduan" \
  -F "kategori_pengaduan=Pelayanan Publik" \
  -F "nama_pelapor=Test User" \
  -F "email_pelapor=test@example.com" \
  -F "telepon_pelapor=081234567890"
```

### Get All Complaints
```bash
curl -X GET "http://localhost:8000/api/laporan-pengaduan?status=pending&per_page=10"
```

### Get Statistics
```bash
curl -X GET http://localhost:8000/api/laporan-pengaduan/statistics
```

## Notes
- File uploads are stored in `storage/app/public/lampiran_pengaduan/`
- Maximum file size: 2MB
- Supported file formats: PDF, DOC, DOCX, JPG, JPEG, PNG
- All timestamps are in UTC
- Pagination is included in list responses
- Search functionality works across title, description, and reporter name 