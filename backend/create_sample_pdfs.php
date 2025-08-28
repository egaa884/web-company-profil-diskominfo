<?php

require_once 'vendor/autoload.php';

use App\Models\LaporanPengaduanAdmin;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Create Sample PDF Files ===\n";

// Create sample PDF content
$samplePdfContent = '%PDF-1.4
1 0 obj
<<
/Type /Catalog
/Pages 2 0 R
>>
endobj

2 0 obj
<<
/Type /Pages
/Kids [3 0 R]
/Count 1
>>
endobj

3 0 obj
<<
/Type /Page
/Parent 2 0 R
/MediaBox [0 0 612 792]
/Contents 4 0 R
>>
endobj

4 0 obj
<<
/Length 44
>>
stream
BT
/F1 12 Tf
72 720 Td
(Laporan Pengaduan Sample) Tj
ET
endstream
endobj

xref
0 5
0000000000 65535 f 
0000000009 00000 n 
0000000058 00000 n 
0000000115 00000 n 
0000000204 00000 n 
trailer
<<
/Size 5
/Root 1 0 R
>>
startxref
297
%%EOF';

// Get all reports
$reports = LaporanPengaduanAdmin::all();

foreach ($reports as $report) {
    // Create PDF filename
    $filename = 'laporan_pengaduan_' . strtolower($report->bulan) . '_' . $report->tahun . '.pdf';
    $filepath = 'laporan_pengaduan/' . $filename;
    
    // Create directory if not exists
    $directory = storage_path('app/public/laporan_pengaduan');
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
        echo "Created directory: $directory\n";
    }
    
    // Create PDF file
    $fullPath = storage_path('app/public/' . $filepath);
    file_put_contents($fullPath, $samplePdfContent);
    
    // Update database
    $report->file_lampiran = $filepath;
    $report->save();
    
    echo "Created PDF for ID {$report->id}: $filename\n";
    echo "Path: $fullPath\n";
    echo "URL: " . asset('storage/' . $filepath) . "\n";
    echo "---\n";
}

echo "=== Verification ===\n";
$updatedReports = LaporanPengaduanAdmin::all();
foreach ($updatedReports as $report) {
    echo "ID: {$report->id} - File: {$report->file_lampiran}\n";
    if ($report->file_lampiran) {
        $fullPath = storage_path('app/public/' . $report->file_lampiran);
        echo "  Exists: " . (file_exists($fullPath) ? 'Yes' : 'No') . "\n";
        echo "  URL: " . asset('storage/' . $report->file_lampiran) . "\n";
    }
}
