<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Film::all();
        // return response()->json($data);
        return response()->json([
            'success' => true, 
            'message' => 'List semua film', 
            'data' => $data], 200);
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
        //Validati request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:films,title',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasai gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Simpan data
        $film = Film::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Film berhasil ditambahkan',
            'data' => $film
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //detail film berdasarkan id
        $film = Film::find($id);

        if (!$film) {
            return response()->json([
                'success' => false,
                'message' => 'Film tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail film',
            'data' => $film
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Film $film)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $film = Film::find($id);

        if (!$film) {
            return response()->json([
                'success' => false,
                'message' => 'Film tidak ditemukan'
            ], 404);
        }

        // Validasi update
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255|unique:films,title,' .$film->id,
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $film->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Film berhasil diperbarui',
            'data' => $film
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $film = Film::find($id);

        if (!$film) {
            return response()->json([
                'success' => false,
                'message' => 'Film tidak ditemukan'
            ], 404);
        }

        $film->delete();

        return response()->json([
            'success' => true,
            'message' => 'Film berhasil dihapus'
        ], 200);
    }
}
