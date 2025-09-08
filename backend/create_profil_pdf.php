<?php

// Create sample PDF content for profil
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
(Profil Dinas Kominfo Madiun) Tj
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

// Create directory if not exists
$directory = __DIR__ . '/storage/app/public/profil';
if (!is_dir($directory)) {
    mkdir($directory, 0755, true);
    echo "Created directory: $directory\n";
}

// Create PDF file
$filename = 'profil_dinas_kominfo.pdf';
$filepath = $directory . '/' . $filename;
file_put_contents($filepath, $samplePdfContent);

echo "Created PDF file: $filepath\n";
echo "File exists: " . (file_exists($filepath) ? 'Yes' : 'No') . "\n";
echo "File size: " . filesize($filepath) . " bytes\n";