<?php

namespace App\Http\Controllers;

use App\Models\Information;
use App\Models\Topic;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function create()
    {
        // Ambil semua topik yang belum memiliki informasi
        $topics = Topic::doesntHave('information')->get();

        return view('admin.chat-menu.information.create', compact('topics'));
    }

    public function store(Request $request)
    {
        // Validasi input dasar
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'topic_id' => 'required|exists:topics,id',
        ]);

        // Cek apakah informasi untuk topik yang dipilih sudah ada
        $existingInformation = Information::where('topic_id', $request->topic_id)->first();

        if ($existingInformation) {
            return redirect()->back()->withErrors(['topic_id' => 'Informasi untuk topik ini sudah ada. Pilih topik lain.']);
        }

        // Jika tidak ada, simpan informasi baru
        Information::create($request->all());

        return redirect()->route('chat-menu')->with('success', 'Informasi berhasil ditambahkan');
    }


    public function edit($id)
    {
        $information = Information::findOrFail($id);
        $topics = Topic::all();
        return view('admin.chat-menu.information.edit', compact('information', 'topics'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input dasar
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'topic_id' => 'required|exists:topics,id',
        ]);

        // Cari informasi yang sedang diupdate
        $information = Information::findOrFail($id);

        // Cek apakah ada informasi lain dengan topic_id yang sama, kecuali yang sedang diupdate
        $existingInformation = Information::where('topic_id', $request->topic_id)
            ->where('id', '!=', $id)
            ->first();

        if ($existingInformation) {
            return redirect()->back()->withErrors(['topic_id' => 'Informasi untuk topik ini sudah ada. Pilih topik lain.']);
        }

        // Update informasi jika tidak ada duplikasi
        $information->update($request->all());

        return redirect()->route('chat-menu')->with('success', 'Informasi berhasil diupdate');
    }


    public function destroy($id)
    {
        $information = Information::findOrFail($id);
        $information->delete();

        return response()->json(['success' => true]);
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/information', $fileName, 'public');

            $url = asset('storage/' . $filePath);

            return response()->json([
                'uploaded' => true,
                'url' => $url,
            ]);
        }

        return response()->json(['uploaded' => false, 'error' => ['message' => 'Gagal mengupload gambar.']]);
    }

    public function getTopicsWithInformation()
    {
        $topics = Topic::with('information')->get();

        return response()->json($topics);
    }
}
