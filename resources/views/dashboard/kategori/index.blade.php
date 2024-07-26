@extends('dashboard.layout.main')

@section('content')
    <div class="container-fluid px-4">
        <div class="card mt-3">
            <div class="card-body px-4">
                <div class="d-flex justify-content-between col-lg">
                    <h1 class="mt-2 mb-4">Kategori</h1>
                </div>

                @if (Session::get('info'))
                    <div class="alert alert-info">
                        {{ Session::get('info') }}
                    </div>
                @endif

                <a href="{{ url('/dashboard/kategori/create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus"></i>
                    Tambah</a>

                <table class="table table-hover table-sm" id="myTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($no = 1)
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $category->nama }}</td>
                                <td>{{ $category->deskripsi }}</td>
                                <td>
                                    <a href="{{ url('/dashboard/kategori/' . $category->id . '/edit') }}"
                                        class="btn btn-warning btn-sm" title="edit_kategori"><i class="fa fa-pen"></i></a>
                                    <form method="POST" action="{{ url('/dashboard/kategori/' . $category->id) }}"
                                        class="d-inline"
                                        onsubmit="return confirm('Anda yakin mau menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="hapus_kategori"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
