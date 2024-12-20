<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Progress Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-globe text-2xl text-green-700"></i>
                <span class="ml-3 text-2xl font-semibold text-gray-800">Pengaduan</span>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="container mx-auto mt-8">
        {{-- @foreach (Session::all() as $key => $message)
                <div class="alert text-5xl alert-{{ $key }}">
                    {{ $message }}
                </div>
            @endforeach --}}

        <div class="bg-white p-6 rounded-lg shadow-lg m-5">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <div>
                    {{-- @dd($response) --}}
                    <h1 class="text-2xl font-bold text-gray-800">{{ $response->report->user->email }}</h1>
                    <p class="text-gray-600 mt-1">
                        {{ $response->created_at->translatedFormat('d F Y') }}
                        <span class="font-bold">Status tanggapan:</span>
                        <span class="bg-green-500 text-white px-2 py-1 rounded">{{ $response->response_status }}</span>
                    </p>
                </div>
                <button class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 transition"><a
                        href="{{ route('report.staff') }}">Kembali</a></button>
            </div>

            <!-- Report Section -->
            <div class="flex gap-4">
                <div class="bg-gray-50 p-6 rounded-lg shadow border flex-1">
                    <h2 class="font-bold text-lg mb-4 text-gray-800">
                        {{ $response->report->village }}, {{ $response->report->subdistrict }},
                        {{ $response->report->regency }}, {{ $response->report->province }}
                    </h2>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        {{ $response->report->description }}
                    </p>
                    <img src="{{ asset('storage/' . $response->report->image) }}" alt="Report Image"
                        class="rounded-lg shadow-lg w-full max-w-sm">
                </div>

                <!-- Empty Progress Section -->
                <div class="flex items-center justify-center flex-col bg-gray-50 p-6 rounded-lg shadow border w-1/3">
                    <div class="timeline">
                        @forelse($responseProgress as $progress)
                        <ol class="relative border-s-4 border-gray-200 dark:border-gray-700">
                                @php
                                    // Decode JSON from histories column
                                    $histories = json_decode($progress->histories, true);
                                @endphp
                                <li class="mb-10 ms-6">
                                    <span
                                        class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                                        <svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </span>
                                    <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                                        Response History
                                    </h3>
                                    <time
                                        class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">
                                        {{ $progress->created_at->format('d M Y, H:i') }}
                                    </time>
                                    <p class="text-base font-normal ">
                                        <form action="{{ route('destroy.response', $progress->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">
                                            {{ $histories['response'] ?? 'No response available' }}
                                        </button>
                                        </form>
                                    </p>
                                </li>
                            </ol>
                            @empty
                                <p class="text-base font-normal text-gray-500 dark:text-gray-400">No progress data
                                    available.</p>
                            @endforelse

                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-4 mt-6">
                @if ($response->response_status != 'DONE')
                <form action="{{route('update.response', $responseId)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <button class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 transition" type="submit">Nyatakan
                        Selesai</button>
                </form>
                <button onclick="showProgressModal()"
                    class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 transition">
                    Tambah Progres
                </button>
                @endif
            </div>
        </div>
    </main>

    <!-- Modal Tambah Progres -->
    <div class="modal fade" id="progressModal" tabindex="-1" aria-labelledby="progressModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('progress.store', $response->id) }}" id="form-add-progress" method="POST">
                @method('POST')
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="progressModalLabel">Progress Tindak Lanjut</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="response" class="form-label">Tanggapan</label>
                            <textarea class="form-control" name="response" id="response" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-primary" />
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        function showProgressModal() {
            // Set action form ke endpoint sesuai kebutuhan (contoh menggunakan placeholder)
            const action = '{{ route('progress.store', ':id') }}'.replace(':id',
                '{{ $response->report->id }}'); // Ganti 1 dengan ID dinamis jika diperlukan

            // Ubah action form
            $('#form-add-progress').attr('action', action);

            // Tampilkan modal
            $('#progressModal').modal('show');
        }
    </script>
</body>

</html>
