<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Check database connection
    $pdo = DB::connection()->getPdo();
    echo "Database connection successful!\n";

    // Check berita count
    $publishedCount = DB::table('beritas')->where('status', 'published')->count();
    $totalCount = DB::table('beritas')->count();

    echo "Published berita: $publishedCount\n";
    echo "Total berita: $totalCount\n";

    // Get latest 3 berita
    $latestBerita = DB::table('beritas')
        ->where('status', 'published')
        ->orderBy('created_at', 'desc')
        ->limit(3)
        ->get(['id', 'judul', 'slug', 'created_at']);

    echo "\nLatest 3 berita:\n";
    foreach ($latestBerita as $berita) {
        echo "- {$berita->judul} (ID: {$berita->id})\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}