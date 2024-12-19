<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Login Page
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>

  <style>
    body{
      background-size: cover;
      position: relative;
      height: 100vh;
      overflow: hidden;
      background-color: green
    }
  </style>
 </head>
 <body class="flex items-center justify-center min-h-screen opacity-95">
   <div class="w-1/2 p-10 rounded-lg" style="background: linear-gradient(to bottom right, #5DB996, #f97316);">
    <h1 class="mb-8 text-4xl font-bold text-white ">
     Login / daftar
    </h1>

    @if ($errors->any())
    <div class="mb-4 p-3 text-red-700 bg-red-100 rounded shadow">
        <strong class="block font-semibold">Oops! Something went wrong.</strong>
        <ul class="mt-2 ml-4 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (Session::get('error'))
    <div id="alert"
    class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full opacity-0 transition-transform duration-300 ease-out">
        {{ Session::get('error') }}
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


    <form action="{{ route('loginOrRegister') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="email" class="block mb-2 text-white">
                Masukkan Email*
            </label>
            <input
                id="email"
                class="w-full px-4 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-300"
                type="email"
                name="email"
                placeholder="Email Anda"
            />
        </div>
        <div class="mb-4">
            <label for="password" class="block mb-2 text-white">
                Masukkan Kata Sandi*
            </label>
            <input
                id="password"
                class="w-full px-4 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-300"
                type="password"
                name="password"
                placeholder="Kata Sandi"
            />
        </div>
        <div class="flex items-center justify-between rounded">
            <button
                class="px-4 py-2 text-white bg-teal-600 hover:bg-teal-700 rounded"
                type="submit">
                Login
            </button>
            <button
                class="px-4 py-2 text-white"
                type="submit">
                Buat akun
            </button>
        </div>
    </form>

    <p class=" text-red-100 mb-2">Mohon untuk login / daftar terlebih dahulu ! </p>


   </div>
  </div>
 </body>
</html>
