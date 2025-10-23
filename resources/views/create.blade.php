<x-html>
    <x-slot:title>{{ $title }}</x-slot:title>

    <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 p-4 -mt-32">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-4 text-xl font-bold text-gray-900">Upload Artikel Baru</h2>

            <!-- Tampilkan error global -->
            @if ($errors->any())
                <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form id="post-form" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">

                    <!-- Judul Artikel -->
                    @php
                        $titleClass = $errors->has('title')
                            ? 'bg-gray-50 border border-red-500 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5'
                            : 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5';
                    @endphp
                    <div class="sm:col-span-2">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Judul Artikel</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                               class="{{ $titleClass }}" placeholder="Masukkan judul artikel" required>
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Gambar -->
                    @php
                        $imageClass = $errors->has('image')
                            ? 'flex flex-col items-center justify-center w-full min-h-64 border-2 border-red-500 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 overflow-hidden'
                            : 'flex flex-col items-center justify-center w-full min-h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 overflow-hidden';
                    @endphp
                    <div class="sm:col-span-2">
                        <label for="image" class="block mb-2 text-sm font-medium text-gray-900">Upload Gambar</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="image" class="{{ $imageClass }}">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6" id="upload-placeholder">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 
                                                 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 
                                                 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                    <p class="text-xs text-gray-500">PNG, JPG (MAX. 2MB)</p>
                                </div>
                                <!-- Preview -->
                                <div id="preview-container" class="hidden w-full p-4">
                                    <img id="preview-image" class="max-w-full max-h-96 mx-auto rounded-lg shadow-lg object-contain" alt="Preview">
                                    <div class="mt-3 text-center">
                                        <p class="text-sm text-gray-600" id="image-info"></p>
                                        <button type="button" id="remove-image" class="mt-2 px-3 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600">
                                            Hapus Gambar
                                        </button>
                                    </div>
                                </div>
                                <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                            </label>
                        </div>
                        @error('image')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    @php
                        $categoryClass = $errors->has('category_id')
                            ? 'bg-gray-50 border border-red-500 text-gray-900 text-sm rounded-lg block w-full p-2.5'
                            : 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5';
                    @endphp
                    <div class="w-full">
                        <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                        <select id="category_id" name="category_id" class="{{ $categoryClass }}" required>
                            <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Isi Artikel -->
                    @php
                        $bodyClass = $errors->has('body')
                            ? 'block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-red-500 focus:ring-red-500 focus:border-red-500'
                            : 'block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500';
                    @endphp
                    <div class="sm:col-span-2">
                        <label for="body" class="block mb-2 text-sm font-medium text-gray-900">Isi Artikel</label>
                        <textarea id="body" name="body" rows="12" class="{{ $bodyClass }}" 
                                  placeholder="Tulis isi artikel di sini... minimal 180 karakter" required>{{ old('body') }}</textarea>
                        @error('body')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex items-center space-x-4 mt-6">
                    <button type="submit" 
                            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        Publish Artikel
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const imageInput = document.getElementById('image');
        const previewImage = document.getElementById('preview-image');
        const uploadPlaceholder = document.getElementById('upload-placeholder');
        const previewContainer = document.getElementById('preview-container');
        const imageInfo = document.getElementById('image-info');
        const removeImageBtn = document.getElementById('remove-image');
        const form = document.getElementById('post-form');

        // preview & validasi ukuran gambar
        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'File terlalu besar! Maksimal 2MB.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    imageInput.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imageInfo.textContent = `${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
                    uploadPlaceholder.classList.add('hidden');
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        // hapus gambar pakai swal
        removeImageBtn.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin hapus gambar?',
                text: "Gambar akan dibuang dari form.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    imageInput.value = '';
                    previewContainer.classList.add('hidden');
                    uploadPlaceholder.classList.remove('hidden');
                    Swal.fire('Terhapus!', 'Gambar berhasil dihapus.', 'success');
                }
            });
        });

        // konfirmasi sebelum submit artikel
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Publish Artikel?',
                text: "Pastikan semua data sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, publish',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
</x-html>
