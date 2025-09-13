<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Berita;
use App\Models\Comment;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Infografis;
use App\Models\LaporanPengaduanAdmin;
use App\Models\Profil;
use App\Models\Publikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        try {
            $statistics = [
                // Content Statistics
                'content' => [
                    'total_berita' => Berita::count(),
                    'berita_published' => Berita::where('status', 'published')->count(),
                    'berita_draft' => Berita::where('status', 'draft')->count(),
                    'total_profil' => Profil::count(),
                    'profil_active' => Profil::where('status', 'active')->count(),
                    'total_publikasi' => Publikasi::count(),
                    'total_infografis' => Infografis::count(),
                    'total_faq' => Faq::count(),
                    'total_faq_categories' => FaqCategory::count(),
                ],

                // Interaction Statistics
                'interaction' => [
                    'total_comments' => Comment::count(),
                    'comments_approved' => Comment::where('is_approved', true)->count(),
                    'comments_pending' => Comment::where('is_approved', false)->count(),
                    'total_laporan_pengaduan' => LaporanPengaduanAdmin::count(),
                    'laporan_pending' => LaporanPengaduanAdmin::where('status', 'pending')->count(),
                    'laporan_completed' => LaporanPengaduanAdmin::where('status', 'completed')->count(),
                ],

                // User Statistics
                'users' => [
                    'total_users' => User::count(),
                    'total_admins' => Admin::count(),
                    'admins_active' => Admin::where('status', 'active')->count(),
                    'admin_roles' => Admin::select('role', DB::raw('count(*) as count'))
                        ->groupBy('role')
                        ->get()
                        ->pluck('count', 'role')
                        ->toArray(),
                ],

                // Recent Activity
                'recent' => [
                    'latest_berita' => Berita::with('admin:id,name')
                        ->select('id', 'judul', 'status', 'created_at', 'admin_id')
                        ->latest()
                        ->take(5)
                        ->get()
                        ->map(function ($berita) {
                            return [
                                'id' => $berita->id,
                                'judul' => $berita->judul,
                                'status' => $berita->status,
                                'created_at' => $berita->created_at->format('d M Y H:i'),
                                'admin_name' => $berita->admin->name ?? 'Unknown',
                            ];
                        }),

                    'latest_comments' => Comment::with('berita:id,judul')
                        ->select('id', 'name', 'comment', 'is_approved', 'created_at', 'berita_id')
                        ->latest()
                        ->take(5)
                        ->get()
                        ->map(function ($comment) {
                            return [
                                'id' => $comment->id,
                                'name' => $comment->name,
                                'comment' => Str::limit($comment->comment, 50),
                                'is_approved' => $comment->is_approved,
                                'created_at' => $comment->created_at->format('d M Y H:i'),
                                'berita_title' => $comment->berita->judul ?? 'Unknown',
                            ];
                        }),

                    'latest_laporan' => LaporanPengaduanAdmin::with('admin:id,name')
                        ->select('id', 'judul', 'status', 'created_at', 'admin_id')
                        ->latest()
                        ->take(5)
                        ->get()
                        ->map(function ($laporan) {
                            return [
                                'id' => $laporan->id,
                                'judul' => $laporan->judul,
                                'status' => $laporan->status,
                                'created_at' => $laporan->created_at->format('d M Y H:i'),
                                'admin_name' => $laporan->admin->name ?? 'Unknown',
                            ];
                        }),
                ],

                // Monthly Statistics (Last 12 months)
                'monthly' => [
                    'berita_per_month' => $this->getMonthlyData('beritas', 12),
                    'comments_per_month' => $this->getMonthlyData('comments', 12),
                    'laporan_per_month' => $this->getMonthlyData('laporan_pengaduan_admins', 12),
                ],

                // Category Distribution
                'categories' => [
                    'berita_by_category' => Berita::select('category', DB::raw('count(*) as count'))
                        ->whereNotNull('category')
                        ->groupBy('category')
                        ->get()
                        ->pluck('count', 'category')
                        ->toArray(),

                    'faq_by_category' => FaqCategory::withCount('faqs')
                        ->get()
                        ->pluck('faqs_count', 'name')
                        ->toArray(),
                ],

                // Performance Metrics
                'performance' => [
                    'total_views' => Berita::sum('views'),
                    'average_views_per_berita' => Berita::avg('views'),
                    'most_viewed_berita' => Berita::select('id', 'judul', 'views')
                        ->orderBy('views', 'desc')
                        ->first(),
                    'berita_with_most_comments' => Berita::withCount('comments')
                        ->orderBy('comments_count', 'desc')
                        ->first(),
                ],
            ];

            return response()->json([
                'success' => true,
                'data' => $statistics,
                'timestamp' => now()->toISOString(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch statistics',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function getMonthlyData($table, $months = 12)
    {
        $data = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = DB::table($table)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $data[] = [
                'month' => $date->format('M Y'),
                'count' => $count,
            ];
        }
        return $data;
    }
}