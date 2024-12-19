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
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Left column with posts -->
            <div class="lg:col-span-2 overflow-y-auto max-h-[500px] scrollable">
                <div class="bg-white p-4 rounded shadow mb-4">
                    <div class="flex items-center">
                        <!-- Gambar -->
                        <img class="w-1/3 rounded"
                            src="{{ $report->image ? asset('storage/' . $report->image) : 'https://via.placeholder.com/150' }}"
                            width="150" height="100" />
                        <div class="ml-4 flex-grow">
                            <!-- Judul -->
                                <p class="semi-bold">
                                    {{ $report->created_at->format('j F Y') }}
                                </p>
                                <p>
                                    {{ ($report->description) }}
                                </p>
                                <div class="bg-orange-300 my-5 py-2 w-36 rounded-xl text-center">
                                    {{ $report->type}}
                                </div>

                            <!-- Statistik -->
                            <div class="flex items-center text-gray-600 text-sm mt-2">
                            </div>
                            <!-- Email Pengguna -->
                            <div class="text-gray-600 text-sm mt-2">{{ $report->user->email ?? 'Anonim' }}</div>
                            <!-- Waktu -->
                            <div class="text-gray-600 text-sm mt-2">{{ $report->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-md w-full max-w-4xl">
                    <h3 class="font-bold text-lg">Komentar</h3>
                    @foreach ($comment as $comment)
                    <div class="my-5 border p-4 rounded-lg shadow-md">
                    <p class=" text-blue-400">{{$comment->user->email}}</p>
                    <p>{{$comment->created_at->diffForHumans()}} - {{ \Carbon\Carbon::parse($report->created_at)->format('d F Y') }}</p>
                    <p class="my-2">{{$comment->comment}}</p>
                    </div>
                    @endforeach
                    <form action="{{ route('comments.store', $report->id) }}"" method="POST">
                        @csrf
                    <div class="flex items-start space-x-4">
                        <i class="fas fa-user text-xl mt-2"></i>
                        <textarea name="comment" id="comment" class="flex-1 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4"></textarea>
                    </div>
                    <div class="flex justify-end mt-2">
                        <button class="bg-teal-700 text-white px-4 py-2 rounded-lg">Buat Komentar</button>
                    </div>
                </form>
                <a href="{{route('article')}}" class="btn btn-danger">Back</a>
            </div>
            </div>
        </div>

        @if (Session::get('success'))
        <div id="alert"
        class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full opacity-0 transition-transform duration-300 ease-out">
            {{ Session::get('success') }}
        </div>
        <!--script styling dan timeout untuk alert -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
