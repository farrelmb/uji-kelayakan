<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    @vite('resources/css/app.css')
    <title>Pengaduan Masyarakat</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            background-size: cover;
            position: relative;
            height: 100vh;
            overflow: hidden;
            background-color: green
        }

        .content {
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body class=" opacity-90">
    <!-- Background Orange Diagonal -->
    <div class="diagonal-bg"></div>
    <div class="absolute top-1/2 right-10 transform -translate-y-1/2 space-y-4 z-20">
        <a href="{{ auth()->check() ? route('report.create') : route('login') }}"
            class="flex items-center justify-center w-16 h-16 text-white bg-teal-600 hover:bg-teal-700 rounded-full shadow-lg">
            <i class="fa fa-plus" aria-hidden="true"></i>
        </a>

        <a href="{{ route('article') }}"
            class="flex items-center justify-center w-16 h-16 text-white bg-teal-600 hover:bg-teal-700 rounded-full shadow-lg">
            <i class="fa fa-newspaper" aria-hidden="true"></i>
        </a>
        <a href="{{ route('login') }}"
            class="flex items-center justify-center w-16 h-16 text-white bg-teal-600 hover:bg-teal-700 rounded-full shadow-lg">
            <i class="fa fa-list" aria-hidden="true"></i>
        </a>

    </div>

    <!-- Content -->
    <div class="content flex items-center justify-start h-full text-white p-10">
        <div class="text-left max-w-2xl">
            <h1 class="text-5xl font-extrabold mb-6">Pengaduan Masyarakat</h1>
            <div class="">
                <p class="text-lg mb-6 text-justify">
                    Website Pengaduan Masyarakat adalah platform untuk menyampaikan laporan publik secara mudah dan transparan
                </p>
            </div>
             <a href="{{ auth()->check() ? route('article') : route('login') }}"
                class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition">
                BERGABUNG SEKARANG!
            </a>
        </div>
    </div>
    
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
