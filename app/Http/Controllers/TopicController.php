<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::all();
        return view('topics.index', compact('topics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Hanya kirim 'name' tanpa '_token'
        $topic = Topic::create($request->only('name'));

        return response()->json($topic);
    }

    public function update(Request $request, Topic $topic)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Hanya kirim 'name' tanpa '_token'
        $topic->update($request->only('name'));

        return response()->json($topic);
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();

        return response()->json(['success' => true, 'id' => $topic->id]);
    }
}
