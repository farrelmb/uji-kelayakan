@extends('layouts.template')
@section('content')
    <style>
        /* Handle scroll bar */
        .scrollable::-webkit-scrollbar-thumb {
            background: #38b2ac;
            /* Warna handle */
            border-radius: 10px;
            /* Membuat sudut melengkung */
        }

        /* Tambahan untuk browser lain */
        .scrollable {
            scrollbar-width: thin;
            /* Untuk Firefox */
            scrollbar-color: #38b2ac #f0f0f0;
            /* Handle dan track */
        }
    </style>
    <div class="container p-6" style="width: 400">
        <a href="{{ route('create') }}" class="btn btn-primary">Tambah Staff</a>
        <div class="container mt-4">
            <h1>Data Staff</h1>
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                <form action="{{ route('destroy.user', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
