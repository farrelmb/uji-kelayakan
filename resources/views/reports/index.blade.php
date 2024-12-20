<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <div class="flex justify-between items-center p-4 bg-white shadow-md">
        <div class="flex items-center">
            <span class="ml-2 text-xl font-semibold">Pengaduan</span>
        </div>
    </div>

    <!-- Content -->
    <div class="p-4">
        @foreach ($reports as $report)
            <div class="bg-green-500 p-4 rounded-lg mb-4 ">
                <!-- Header laporan -->
                <div class="flex justify-between items-center cursor-pointer toggle-detail"
                    data-id="{{ $report->id }}">
                    <h2 class="text-white font-semibold">
                        Pengaduan {{ \Carbon\Carbon::parse($report->created_at)->format('d F Y') }}
                    </h2>
                    <i class="fas fa-chevron-down text-white"></i>
                </div>

                <!-- Detail laporan -->
                <div class="mt-4 hidden detail-section" id="detail-{{ $report->id }}">
                    <!-- Tab Header -->
                    <div class="flex justify-around text-white font-semibold border-b">
                        <button class="tab-btn px-4 py-2 border-b-2 border-transparent"
                            data-tab="data-{{ $report->id }}">Data</button>
                        <button class="tab-btn px-4 py-2 border-b-2 border-transparent"
                            data-tab="image-{{ $report->id }}">Gambar</button>
                        <button class="tab-btn px-4 py-2 border-b-2 border-transparent"
                            data-tab="status-{{ $report->id }}">Status</button>
                    </div>

                    <!-- Tab Content: Data -->
                    <div class="tab-content mt-2 text-white hidden" id="data-{{ $report->id }}">
                        <ul class="list-disc ml-5">
                            <li><strong>Tipe:</strong> {{ $report->type }}</li>
                            <li><strong>Lokasi:</strong> {{ $report->village }}</li> 
                            <li>{{ $report->subdistrict }}</li>
                            <li>{{ $report->regency }}</li> 
                            <li>{{ $report->province }}</li>
                            <li><strong>Deskripsi:</strong> {{ $report->description }}</li>
                        </ul>
                    </div>

                    <!-- Tab Content: Gambar -->
                    <div class="tab-content mt-2 text-white hidden my-2" id="image-{{ $report->id }}">
                        @if ($report->image)
                            <div class="flex justify-center">
                                <div class="w-64 h-64 bg-gray-300 rounded overflow-hidden shadow-lg">
                                    <img src="{{ asset('storage/' . $report->image) }}" alt="Gambar Pengaduan"
                                        class="w-full h-full object-cover object-center">
                                </div>
                            </div>
                        @else
                            <p class="text-sm text-gray-200 text-center">No Image</p>
                        @endif
                    </div>


                    <!-- Tab Content: Status -->
                    <div class="tab-content mt-2 text-white hidden" id="status-{{ $report->id }}">
                        @if ($report->response->isEmpty())
                            <p>Pengaduan belum direspon petugas, ingin menghapus pengaduan?</p>
                            <button class="bg-red-500 p-2 rounded-lg mt-2"
                                onclick="showModal({{ $report->id }}, '{{ $report->created_at }}')">
                                Delete
                            </button>
                        @endif
                        
                        <h3 class="mb-1 text-lg mt-5 font-semibold text-gray-900 dark:text-white">
                            Response History
                        </h3>
                        <ol class="relative border-s-4  ml-5 border-gray-200 dark:border-gray-700">

                            <li class="mb-10 ms-6">
                                <ol class="mt-4">
                                    @forelse ($report->responseProgress as $progress)
                                        @php
                                            // Decode JSON from histories column
                                            $histories = json_decode($progress->histories, true);
                                        @endphp
                                        <li class="mb-10 ms-6">
                                            <span
                                                class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                                                <svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                </svg>
                                            </span>
                                            <time class="block mb-2 text-sm font-normal leading-none ">
                                                {{ $progress->created_at->format('d M Y, H:i') }}
                                            </time>
                                            <p class="text-base font-normal">
                                                {{ $histories['response'] }}
                                            </p>
                                        </li>
                                    @empty
                                        <p class="text-base font-normal text-gray-500 dark:text-gray-400"></p>
                                    @endforelse
                                </ol>
                            </li>
                            {{-- @endforeach --}}
                        </ol>

                    </div>
                </div>
            </div>
        @endforeach

        <!-- Jika tidak ada laporan -->
        @if ($reports->isEmpty())
            <p class="text-center">Tidak ada laporan.</p>
        @endif
    </div>

    <!-- Floating Buttons -->
    <div class="absolute top-1/2 right-10 transform -translate-y-1/2 space-y-4 z-20 mt-8">
        <a href="{{ auth()->check() ? route('report.create') : route('login') }}"
            class="flex items-center justify-center w-16 h-16 text-white bg-teal-600 hover:bg-teal-700 rounded-full shadow-lg">
            <i class="fa fa-plus" aria-hidden="true"></i>
        </a>

        <a href="{{ route('article') }}"
            class="flex items-center justify-center w-16 h-16 text-white bg-teal-600 hover:bg-teal-700 rounded-full shadow-lg">
            <i class="fa fa-newspaper" aria-hidden="true"></i>
        </a>
        <a href="{{ route('index.reports.me') }}"
            class="flex items-center justify-center w-16 h-16 text-white bg-teal-600 hover:bg-teal-700 rounded-full shadow-lg">
            <i class="fa fa-list" aria-hidden="true"></i>
        </a>

    </div>

    <!-- Modal Hapus Report -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" id="form-delete-report" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Hapus Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus report yang dibuat pada
                        {{ \Carbon\Carbon::parse($report?->created_at ?? '')->format('d F Y') }}?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        function showModal(id, createdAt) {
            // Set action untuk form delete, mengarah ke route penghapusan report
            let action = '{{ route('reports.destroy', ':id') }}';
            action = action.replace(':id', id);

            // Ubah action form delete
            $('#form-delete-report').attr('action', action);

            // Tampilkan ID report dan tanggal pembuatan report di modal
            $('#report-id').text(id);
            $('#created_at-report').text(createdAt);

            // Tampilkan modal
            $('#exampleModal').modal('show');
        }
    </script>


    <!-- Scripts -->
    <script>
        // Toggle detail laporan
        $('.toggle-detail').on('click', function() {
            const id = $(this).data('id');
            $(`#detail-${id}`).toggleClass('hidden');
        });

        // Handle tab click
        $('.tab-btn').on('click', function() {
            const tabId = $(this).data('tab');
            const parent = $(this).closest('.detail-section');

            // Sembunyikan semua tab content dalam satu laporan
            parent.find('.tab-content').addClass('hidden');

            // Tampilkan tab content yang dipilih
            $(`#${tabId}`).removeClass('hidden');

            // Hilangkan border aktif dari semua tab
            parent.find('.tab-btn').removeClass('border-blue-700').addClass('border-transparent');

            // Tambahkan border ke tab yang aktif
            $(this).addClass('border-blue-700').removeClass('border-transparent');
        });
    </script>


    @if (Session::get('success'))
        <div id="alert"
            class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full opacity-0 transition-transform duration-300 ease-out">
            {{ Session::get('success') }}
        </div>
        <!--script styling dan timeout untuk alert -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const alert = document.getElementById('alert');
                if (alert) {
                    // Show the alert
                    setTimeout(() => {
                        alert.classList.remove('translate-x-full', 'opacity-0');
                        alert.classList.add('translate-x-0', 'opacity-100');
                    }, 100);

                    // Hide the alert after 3 seconds
                    setTimeout(() => {
                        alert.classList.add('translate-x-full', 'opacity-0');
                        alert.classList.remove('translate-x-0', 'opacity-100');
                    }, 3000);
                }
            });
        </script>
    @endif
</body>

</html>
