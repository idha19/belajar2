@extends('buku.layout')

@section('title', 'Dashboard Buku')

@section('content')
    <div class="text-center mb-5">
        <h1 class="fw-bold">Dashboard Buku</h1>
        <p class="text-muted">Kelola buku dengan cepat lewat shortcut di bawah</p>
    </div>

    <div class="row g-4">
        <!-- Card Tambah -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">➕ Tambah Buku</h5>
                    <p class="card-text">Tambah buku baru ke dalam perpustakaan.</p>
                    <a href="{{ route('buku.create') }}" class="btn btn-primary">Tambah</a>
                </div>
            </div>
        </div>

        <!-- Card List/Edit -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">✏️ Edit Buku</h5>
                    <p class="card-text">Lihat semua buku dan lakukan edit sesuai kebutuhan.</p>
                    {{-- <a href="{{ route('buku.edit') }}" class="btn btn-warning">Kelola</a> --}}
                </div>
            </div>
        </div>

        <!-- Card Hapus -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title">🗑️ Hapus Buku</h5>
                    <p class="card-text">Hapus buku yang sudah tidak tersedia.</p>
                    <a href="{{ route('buku.index') }}" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5">

    <!-- List Data Buku -->
    <h3 class="mb-3">Daftar Buku</h3>
    <table class="table table-bordered table-hover shadow-sm">
        <thead class="table-light">
            <tr>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Stok</th>
                <th>image</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="testing">
            @forelse ($bukus as $buku)
                <tr>
                    <td>{{ $buku->title }}</td>
                    <td>{{ $buku->author }}</td>
                    <td>{{ $buku->publisher }}</td>
                    <td>{{ $buku->years }}</td>
                    <td>{{ $buku->stock }}</td>
                    <td>{{ $buku->image }}</td>
                    <td>
                        {{-- <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                </form> --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada buku</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        let buku;
        async function getData() {
            const data = await fetch("http://localhost:8000/api/bukus", {
                method: "GET"
            })

            const result = await data.json()
            buku = data.data

            const tbody = document.getElementById("testing");
            result.data.forEach(element => {
                tbody.innerHTML += `
        <tr>
            <td>${element.title}</td>    
        </tr>
    `;
            });
        }


        getData()
    </script>
@endsection
