<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // Display list of comments
    public function index(Request $request)
    {
        $query = Comment::with('berita');

        // Filter by approval status
        if ($request->has('status')) {
            if ($request->status === 'approved') {
                $query->approved();
            } elseif ($request->status === 'pending' || $request->status === 'rejected') {
                $query->pending();
            }
        }

        $comments = $query->latest()->paginate(15);

        return view('admin.comments.index', compact('comments'));
    }

    // Approve a comment
    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => true]);

        return redirect()->back()->with('success', 'Komentar berhasil disetujui.');
    }

    // Reject a comment
    public function reject(Comment $comment)
    {
        $comment->update(['is_approved' => false]);

        return redirect()->back()->with('success', 'Komentar berhasil ditolak.');
    }

    // Delete a comment
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }
}
