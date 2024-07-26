@extends('dashboard.layout.main')

@section('content')
    <div class="container-fluid px-4">
        <div class="card mt-3">
            <div class="card-body px-4">
                <h1 class="mt-2 mb-4">Slide</h1>
                @if (Session::get('info'))
                    <div class="alert alert-info">
                        {{ Session::get('info') }}
                    </div>
                @endif

                <a href="{{ url('/dashboard/slide/create') }}" class="btn btn-primary mb-2"><i class="fa-solid fa-plus"
                        title="tambah_slide"></i>
                    Tambah</a>

                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Headline</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($no = 1)
                        @foreach ($slides as $slide)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>
                                    <img src="{{ asset('images/' . $slide->gambar) }}" alt="" width="250px"
                                        alt="slide">
                                </td>
                                <td class="col-7">{{ $slide->judul }}</td>
                                <td class="col-1">
                                    <a href="{{ url('/dashboard/slide/' . $slide->id . '/edit') }}"
                                        class="btn btn-warning btn-sm" title="edit_slide"><i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form method="POST" action="{{ url('/dashboard/slide/' . $slide->id) }}"
                                        class="d-inline" onsubmit="return confirm('Anda yakin mau menghapus slide ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="hapus_slide"><i
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
