<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        return Faq::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);
        $faq = Faq::create($data);
        return response()->json($faq, 201);
    }

    public function show(Faq $faq)
    {
        return $faq;
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);
        $faq->update($data);
        return response()->json($faq);
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return response()->json(null, 204);
    }
} 