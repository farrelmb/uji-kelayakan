<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Form Pengaduan Masyarakat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-100" style="background-image: url('{{asset('indonesia.png')}}');">
    @if ($errors->any())
        <div class="bg-red-500 text-white p-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex min-h-screen" style="display: flex; justify-content: center;">
        <!-- Form Section -->
        <div class="w-full md:w-1/2  p-8" style="background: linear-gradient(to bottom right, green, lime);">
            <h1 class="text-4xl font-bold text-white mb-8">Form Pengaduan Masyarakat</h1>
            <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Deskripsi -->
                <div class="mb-4">
                    <label class="block text-white mb-2" for="description">Deskripsi Laporan*</label>
                    <textarea class="w-full p-2 border border-gray-300 rounded" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                </div>

                <!-- Tipe -->
                <div class="mb-4">
                    <label class="block text-white mb-2" for="type">Tipe Laporan*</label>
                    <select class="w-full p-2 border border-gray-300 rounded" id="type" name="type" required>
                        <option value="" disabled selected>Pilih tipe laporan</option>
                        <option value="KEJAHATAN" {{ old('type') == 'KEJAHATAN' ? 'selected' : '' }}>Kejahatan</option>
                        <option value="PEMBANGUNAN" {{ old('type') == 'PEMBANGUNAN' ? 'selected' : '' }}>Pembangunan</option>
                        <option value="SOSIAL" {{ old('type') == 'SOSIAL' ? 'selected' : '' }}>Sosial</option>
                    </select>
                </div>

                <!-- Lokasi -->
                <div class="mb-4">
                    <label class="block text-white mb-2" for="province">Provinsi*</label>
                    <select class="w-full p-2 border border-gray-300 rounded" id="province" required>
                        <option value="">Pilih Provinsi</option>
                    </select>
                    <input type="hidden" name="province" value="{{ old('province') }}">
                </div>

                <div class="mb-4">
                    <label class="block text-white mb-2" for="regency">Kota/Kabupaten*</label>
                    <select class="w-full p-2 border border-gray-300 rounded" id="regency" required>
                        <option value="">Pilih Kota/Kabupaten</option>
                    </select>
                    <input type="hidden" name="regency" value="{{ old('regency') }}">
                </div>

                <div class="mb-4">
                    <label class="block text-white mb-2" for="subdistrict">Kecamatan*</label>
                    <select class="w-full p-2 border border-gray-300 rounded" id="subdistrict" required>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                    <input type="hidden" name="subdistrict" value="{{ old('subdistrict') }}">
                </div>

                <div class="mb-4">
                    <label class="block text-white mb-2" for="village">Kelurahan*</label>
                    <select class="w-full p-2 border border-gray-300 rounded" id="village" required>
                        <option value="">Pilih Kelurahan</option>
                    </select>
                    <input type="hidden" name="village" value="{{ old('village') }}">
                </div>

                <!-- Pernyataan -->
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="hidden" name="statement" value="0">
                        <input type="checkbox" name="statement" id="statement" value="1" {{ old('statement') ? 'checked' : '' }} required>
                        <span class="text-white">Laporan yang disampaikan sesuai dengan kebenaran.</span>
                    </label>
                </div>

                <!-- Gambar -->
                <div class="mb-4">
                    <label class="block text-white mb-2" for="image">Gambar Pendukung</label>
                    <input class="w-full p-2 border border-gray-300 rounded" id="image" name="image" type="file" accept="image/*" />
                </div>

                <!-- Submit -->
                <button class="bg-green-700 text-white px-4 py-2 rounded" type="submit">Kirim</button>
                <button class="bg-blue-700 text-white px-4 py-2 rounded"><a href="{{route('article')}}">Back</a></button>
            </form>
        </div>

        <!-- Image Section -->
        
    </div>

    <script>
        $(document).ready(function () {
            // Fetch provinces
            $.ajax({
                method: "GET",
                url: "https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json",
                dataType: "json",
                success: function (data) {
                    data.forEach(function (provinsi) {
                        $('#province').append(`<option value="${provinsi.id}" data-name="${provinsi.name}">${provinsi.name}</option>`);
                    });
                }
            });

            function resetDropdowns(selectors) {
                selectors.forEach(selector => $(selector).html('<option value="">Pilih</option>'));
            }

            // Province change
            $('#province').change(function () {
                const selectedOption = $(this).find(':selected');
                const idProv = selectedOption.val();
                const nameProv = selectedOption.data('name');
                resetDropdowns(['#regency', '#subdistrict', '#village']);
                $('[name="province"]').val(nameProv); // Set hidden input with name
                if (idProv) loadRegencies(idProv);
            });

            function loadRegencies(idProv) {
                $.ajax({
                    method: "GET",
                    url: `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${idProv}.json`,
                    dataType: "json",
                    success: function (data) {
                        data.forEach(function (kota) {
                            $('#regency').append(`<option value="${kota.id}" data-name="${kota.name}">${kota.name}</option>`);
                        });
                    }
                });
            }

            // Regency change
            $('#regency').change(function () {
                const selectedOption = $(this).find(':selected');
                const idKota = selectedOption.val();
                const nameKota = selectedOption.data('name');
                resetDropdowns(['#subdistrict', '#village']);
                $('[name="regency"]').val(nameKota); // Set hidden input with name
                if (idKota) loadDistricts(idKota);
            });

            function loadDistricts(idKota) {
                $.ajax({
                    method: "GET",
                    url: `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${idKota}.json`,
                    dataType: "json",
                    success: function (data) {
                        data.forEach(function (kecamatan) {
                            $('#subdistrict').append(`<option value="${kecamatan.id}" data-name="${kecamatan.name}">${kecamatan.name}</option>`);
                        });
                    }
                });
            }

            // Subdistrict change
            $('#subdistrict').change(function () {
                const selectedOption = $(this).find(':selected');
                const idKec = selectedOption.val();
                const nameKec = selectedOption.data('name');
                resetDropdowns(['#village']);
                $('[name="subdistrict"]').val(nameKec); // Set hidden input with name
                if (idKec) loadVillages(idKec);
            });

            function loadVillages(idKec) {
                $.ajax({
                    method: "GET",
                    url: `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${idKec}.json`,
                    dataType: "json",
                    success: function (data) {
                        data.forEach(function (kelurahan) {
                            $('#village').append(`<option value="${kelurahan.id}" data-name="${kelurahan.name}">${kelurahan.name}</option>`);
                        });
                    }
                });
            }

            // Village change
            $('#village').change(function () {
                const selectedOption = $(this).find(':selected');
                const nameKel = selectedOption.data('name');
                $('[name="village"]').val(nameKel); // Set hidden input with name
            });
        });
    </script>
</body>

</html>
