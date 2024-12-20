<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        Pengaduan
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100">
    <nav class="p-4" style="background-color: green;">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                </div>
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <a href="#" class="text-white font-bold text-xl">Pengaduan</a>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    @method('POST')
                    <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <main class="container mx-auto mt-8 px-4 m-5">
        <div class="bg-white shadow rounded-lg p-4 m-5">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">
                    Pengaduan
                </h2>
                <div class="flex justify-between items-center p-4">
                    <div></div>
                    <a href="{{ route('excel') }}">
                        <button class="bg-green-700 text-white px-4 py-2 rounded-md flex items-center">
                            Export (.xlsx)
                            <i class="fas fa-caret-down ml-2"></i>
                        </button>
                    </a>
                </div>
            </div>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left">Gambar & Pengirim</th>
                        <th class="py-2 px-4 border-b text-left">Lokasi & Tanggal</th>
                        <th class="py-2 px-4 border-b text-left">Deskripsi</th>
                        <th class="py-2 px-4 border-b text-left">Jumlah Vote
                            <!-- DESCENDING -->
                            <a href="{{ route('report.staff', ['sort' => 'voting', 'order' => 'desc']) }}">
                                <i class="fas fa-caret-up ml-1 cursor-pointer  {{ $order == 'desc' && $sortBy == 'voting' ? 'text-green-600' : '' }}"></i>
                            </a>
                            <!-- ASCENDING -->
                            <a href="{{ route('report.staff', ['sort' => 'voting', 'order' => 'asc']) }}">
                                <i class="fas fa-caret-down ml-1 cursor-pointer  {{ $order == 'asc' && $sortBy == 'voting' ? 'text-green-600' : '' }}"></i>
                            </a>
                        </th>
                        <th class="py-2 px-4 border-b text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td class="py-2 px-4 border-b flex items-center space-x-2">
                                <img src="{{ $report->image ? asset('storage/' . $report->image) : 'https://via.placeholder.com/150' }}"
                                    alt="Profile picture of the sender" class="w-10 h-10 rounded-full cursor-pointer" height="40"
                                    width="40"  onclick="showModal('{{ $report->id }}', '{{ asset('storage/' . $report->image) }}')">
                                <span>{{ $report->user->email ?? 'Tidak diketahui' }}</span>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <span>{{ $report->village }}, {{ $report->subdistrict }}, {{ $report->regency }},
                                    {{ $report->province }}</span>
                                <br>
                                <span>{{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('d F Y') }}</span>
                            </td>
                            <td class="py-2 px-4 border-b">
                                {{ \Illuminate\Support\Str::limit($report->description, 35, '...') }}
                            </td>
                            <td class="py-2 px-4 border-b">
                                {{ count(json_decode($report->voting ?? '[]', true)) }}
                            </td>
                            <td class="py-2 px-4 border-b text-left">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $report->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $report->id }}">
                                        <li>
                                            <button class="dropdown-item" onclick="showDropDown('{{ $report->id }}')">Tindak Lanjut</button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-2 px-4 border-b text-center text-gray-500">Tidak ada data
                                laporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </main>


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center flex justify-center">
                        <!-- Hanya satu elemen gambar -->
                        <img id="report-image" alt="Gambar Pengaduan"
                        class="w-72 h-64 object-cover object-center rounded-xl">
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="responseModalLabel">Tindakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="response-form" action="{{ route('reports.response', ':id') }}" method="POST">
                        @csrf
                        <input type="hidden" name="report_id" id="report-id">
                        <div class="mb-3">
                            <label for="response-status" class="form-label">Tanggapan</label>
                            <select class="form-select" name="response_status" id="response-status" required>
                                <option value="" selected hidden>Pilih Tanggapan</option>
                                <option value="ON_PROCESS">Proses Penyelesaian/Perbaikan</option>
                                <option value="REJECT">Tolak</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
     function showModal(id, image) {
    // Perbarui atribut src pada gambar
    document.getElementById('report-image').setAttribute('src', image);

    // Tampilkan modal
    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
    modal.show();
    }

    function showDropDown(reportId) {
    // Isi ID laporan di modal
    document.getElementById('report-id').value = reportId;

    // Ubah action form agar sesuai dengan ID yang diterima
    document.getElementById('response-form').action = "{{ route('reports.response', ':id') }}".replace(':id', reportId);

    // Tampilkan modal
    let modal = new bootstrap.Modal(document.getElementById('responseModal'));
    modal.show();
}


    </script>

</body>

</html>
