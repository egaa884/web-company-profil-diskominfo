<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentApiController extends Controller
{
    // Get comments for a specific berita
    public function index(Request $request, $beritaId)
    {
        $berita = Berita::findOrFail($beritaId);

        $comments = $berita->approvedComments()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($comments);
    }

    // Store a new comment
    public function store(Request $request, $beritaId)
    {
        $berita = Berita::findOrFail($beritaId);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'comment' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $comment = Comment::create([
            'berita_id' => $beritaId,
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment,
            'is_approved' => false, // Comments need approval by default
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil dikirim dan menunggu moderasi.',
            'comment' => $comment
        ], 201);
    }

    // Get all comments for admin (both approved and pending)
    public function adminIndex(Request $request)
    {
        $query = Comment::with('berita')->orderBy('created_at', 'desc');

        // Filter by approval status
        if ($request->has('status')) {
            if ($request->status === 'approved') {
                $query->approved();
            } elseif ($request->status === 'pending') {
                $query->pending();
            }
        }

        $comments = $query->paginate(15);

        return response()->json($comments);
    }

    // Approve or reject a comment
    public function updateStatus(Request $request, Comment $comment)
    {
        $validator = Validator::make($request->all(), [
            'is_approved' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $comment->update(['is_approved' => $request->is_approved]);

        $message = $request->is_approved ? 'Komentar berhasil disetujui.' : 'Komentar berhasil ditolak.';

        return response()->json([
            'success' => true,
            'message' => $message,
            'comment' => $comment
        ]);
    }

    // Delete a comment
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil dihapus.'
        ]);
    }
}
