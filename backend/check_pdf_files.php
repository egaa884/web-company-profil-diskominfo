<?php

require_once 'vendor/autoload.php';

use App\Models\LaporanPengaduanAdmin;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Check PDF Files ===\n";

// Get all laporan pengaduan admin
$reports = LaporanPengaduanAdmin::all();

foreach ($reports as $report) {
    echo "ID: {$report->id}\n";
    echo "Judul: {$report->judul}\n";
    echo "File Lampiran: {$report->file_lampiran}\n";
    echo "File URL: {$report->file_url}\n";
    
    if ($report->file_lampiran) {
        $storagePath = storage_path('app/public/' . $report->file_lampiran);
        $publicPath = public_path('storage/' . $report->file_lampiran);
        
        echo "Storage Path: $storagePath\n";
        echo "Public Path: $publicPath\n";
        echo "Storage Exists: " . (file_exists($storagePath) ? 'Yes' : 'No') . "\n";
        echo "Public Exists: " . (file_exists($publicPath) ? 'Yes' : 'No') . "\n";
    } else {
        echo "No file attached\n";
    }
    echo "---\n";
}

echo "=== Check Storage Directories ===\n";
$storagePublic = storage_path('app/public');
$publicStorage = public_path('storage');

echo "Storage Public: $storagePublic\n";
echo "Public Storage: $publicStorage\n";

if (is_dir($storagePublic)) {
    echo "Storage Public Directory Contents:\n";
    $files = scandir($storagePublic);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            echo "  - $file\n";
        }
    }
} else {
    echo "Storage Public directory not found\n";
}

if (is_dir($publicStorage)) {
    echo "Public Storage Directory Contents:\n";
    $files = scandir($publicStorage);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            echo "  - $file\n";
        }
    }
} else {
    echo "Public Storage directory not found\n";
}
