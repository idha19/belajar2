<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Buku::all(); //valiabel untuk ambil semua data

        return response()->json([
            'success' => true,
            'message' => 'List semua buku',
            'data' => $data
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:bukus,title',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'years' => 'required|digits:4|integer',
            'isbn' => 'required|string|max:20|unique:bukus,isbn',
            'category' => 'required|string|max:100',
            'descriotion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $data['id'] = Str::uuid();

        // Upload Image jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('buku-images', 'public');
            $data['image'] = $path;
        }

        $buku = Buku::create($data);
        
        return response()->json([
            'success' => true,
            'message' => 'buku berhasil ditambahkan',
            'data' => $buku
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail buku',
            'data' => $buku
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan'
            ], 404);
        }

        // Validasi update
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|mas:255|unique:bukus,title' .$buku->id,
            'author' => 'sometimes|required|string|mas:255',
            'publisher' => 'sometimes|required|string|max:255',
            'years' => 'sometimes|required|digits:4|integer',
            'isbn' => 'sometimes|required|string|max:20|unique:bukus,isbn' .$buku->id,
            'category' => 'sometimes|required|string|max:100',
            'descriotion' => 'nullable|string',
            'stock' => 'sometimes|required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        // Upload image bari jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('buku-images', 'public');
            $data['image'] = $path;
        }

        $buku->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil diperbarui',
            'data' =>$buku
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan'
            ], 404);
        }

        $buku->delete();

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dihapus'
        ], 200);
    }
}
