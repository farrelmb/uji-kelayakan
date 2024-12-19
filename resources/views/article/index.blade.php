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

    <div class="container mx-auto p-4">
        <div class="flex items-center mb-4">
            <form action="{{route(Route::currentRouteName())}}" method="GET">
                <select name="search" id="dropdown" class="p-2 rounded border border-gray-300 flex-grow" onchange="this.form.submit()">
                    <option value="">Pilih Provinsi</option>
                </select>
            </form>
            <a href="{{route('article')}}" class="btn btn-success">Clear</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Left column with posts -->
            <div class="lg:col-span-2 overflow-y-auto max-h-[500px] scrollable">
                @if ($reports->isEmpty())
                    <p class="text-gray-600 text-center">Tidak ada laporan untuk ditampilkan.</p>
                @else
                    @foreach ($reports as $report)

                        <div class="bg-white p-4 rounded shadow mb-4">
                            <div class="flex items-center">
                                <img alt="{{ $report->description }}" class="w-1/3 rounded"
                                    src="{{ $report->image ? asset('storage/' . $report->image) : 'https://via.placeholder.com/150' }}"
                                    width="150" height="100" />
                                <div class="ml-4 flex-grow">
                                    <h2 class="font-bold text-lg">
                                        <a href="{{ route('articleId', ['id' => $report->id]) }}" class="underline">
                                            {{ Str::limit($report->description, 50) }}
                                        </a>
                                        <p>{{$report->province}}</p>
                                    </h2>
                                    <div class="flex items-center text-gray-600 text-sm mt-2">
                                        <i class="fas fa-eye mr-1"></i> {{ $report->viewers ?? 0 }}
                                            <i class="fas fa-heart mr-1 ml-2"></i>
                                            <span
                                                id="voting-{{ $report->id }}">{{ count(json_decode($report->voting, true) ?? []) }}</span>
                                        </button>
                                    </div>
                                    <div class="text-gray-600 text-sm mt-2">{{ $report->user->email ?? 'Anonim' }}</div>
                                    <div class="text-gray-600 text-sm mt-2">{{ $report->created_at->diffForHumans() }}</div>
                                </div>
                                {{-- vote --}}
                                <button class="like-btn ml-4 flex items-center" data-id="{{ $report->id }}"
                                    data-action="like">
                                <div class="items-center">
                                    <i class="fas fa-heart text-gray-600"></i>
                                    <div>
                                    <span class="ml-1 text-gray-600">vote</span>
                                </div>
                                </div>
                            </button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Right sidebar with information -->
            <div class="bg-white p-4 rounded shadow mb-3">
                <h2 class="font-bold text-lg mb-2">Informasi Pembuatan Pengaduan</h2>
                <ol class="list-decimal list-inside text-gray-700 text-sm">
                    <li>Pengaduan bisa dibuat hanya jika Anda telah membuat akun sebelumnya,</li>
                    <li>Keseluruhan data pada pengaduan bernilai <strong>BENAR dan DAPAT DIPERTANGGUNG JAWABKAN</strong>,
                    </li>
                    <li>Seluruh bagian data perlu diisi</li>
                    <li>Pengaduan Anda akan ditanggapi dalam 2x24 Jam,</li>
                    <li>Periksa tanggapan Kami, pada <strong>Dashboard</strong> setelah Anda <strong>Login</strong>,</li>
                    <li>Pembuatan pengaduan dapat dilakukan pada halaman berikut : <a class="text-blue-500"
                            href="{{route('report.create')}}">Ikuti Tautan</a></li>
                </ol>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const dropdown = document.getElementById('dropdown');
                const apiUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json';
        
                // Fetch data from API
                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        // Clear default option
                        dropdown.innerHTML = '<option value="">Pilih Provinsi</option>';
        
                        // Populate dropdown with data
                        data.forEach(province => {
                            const option = document.createElement('option');
                            option.value = province.name; // Assign ID as value
                            option.textContent = province.name; // Display name in dropdown
                            dropdown.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                        dropdown.innerHTML = '<option value="">Gagal memuat data</option>';
                    });
            });
        </script>
        <script>
            //logika tombol like/voting
            $(document).ready(function () {
    $('.like-btn').on('click', function () {
        var reportId = $(this).data('id');
        var action = $(this).data('action');
        var $button = $(this); // Referensi tombol yang diklik

        $.ajax({
            url: `/reports/${reportId}/vote`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                action: action,
            },
        })
        .then(function (response) {
            // Update jumlah voting
            $('#voting-' + reportId).text(response.voting);

            // Toggle action (like <-> unlike) dan warna ikon hati
            if (action === 'like') {
                $button.find('i').removeClass('text-gray-600').addClass('text-red-600'); // Ubah warna ke merah
                $button.data('action', 'unlike'); // Ubah action menjadi unlike
            } else if (action === 'unlike') {
                $button.find('i').removeClass('text-red-600').addClass('text-gray-600'); // Ubah warna ke default (abu-abu)
                $button.data('action', 'like'); // Ubah action menjadi like
            }
        })
        .catch(function (xhr) {
            alert(xhr.responseJSON?.error || 'An error occurred. Please try again.');
        });
    });
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

    </div>
@endsection
