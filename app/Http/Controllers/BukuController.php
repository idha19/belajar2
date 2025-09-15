<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;
use App\Trait\HasResponse; //ini memanggil trait
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BukuController extends Controller
{

    public function index()
    {
        $data = Buku::all(); //valiabel untuk ambil semua data
        return $this->response(200, 'List semua buku', $data);
    }

    
    public function store(StoreBukuRequest $request)
    {
        // // Validasi request
        // $validator = Validator::make($request->all(), [
        //     'title' => 'required|string|max:255|unique:bukus,title',
        //     'author' => 'required|string|max:255',
        //     'publisher' => 'required|string|max:255',
        //     'years' => 'required|digits:4|integer',
        //     'isbn' => 'required|string|max:20|unique:bukus,isbn',
        //     'category' => 'required|string|max:100',
        //     'description' => 'nullable|string',
        //     'stock' => 'required|integer|min:0',
        //     'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Validasi gagal',
        //         'errors' => $validator->errors()
        //     ], 422);
        // }

        $data = $request->validated();

        // Upload Image jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('buku-images', 'public');
            $data['image'] = $path;
        }

        $buku = Buku::create($data);
        
        return $this->response(200, "Buku berhasil ditambahkannn", $buku);
    }


    public function show($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
        return $this->response(404, "Buku tidak ditemukan");
        }

        return $this->response(200, "Detail buku", $buku); //cara pemprograman modular
    }


    public function update(Request $request, $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return $this->response(404, "Buku tidak ditemukan");
        }

        // Validasi update
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255|unique:bukus,title,' .$buku->id,
            'author' => 'sometimes|required|string|max:255',
            'publisher' => 'sometimes|required|string|max:255',
            'years' => 'sometimes|required|digits:4|integer',
            'isbn' => 'sometimes|required|string|max:20|unique:bukus,isbn,' .$buku->id,
            'category' => 'sometimes|required|string|max:100',
            'description' => 'nullable|string',
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
        return $this->response(200, "Buku berhasil diperbarui", $buku);
    }

    
    public function destroy($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return $this->response(404, "Buku tidak ditemukan");
        }

        $buku->delete();
        return $this->response(200, "Buku berhasil dihapus", $buku);
    }
}
