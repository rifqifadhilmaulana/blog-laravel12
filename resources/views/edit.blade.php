<x-html>
    <x-slot:title>{{ $title }}</x-slot:title>

    <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 p-4 -mt-32">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-4 text-xl font-bold text-gray-900">Edit Artikel</h2>

            <!-- Form -->
            <form id="post-form" action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Hidden input untuk hapus gambar -->
                <input type="hidden" name="remove_image" id="remove_image_field" value="0">

                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">

                    <!-- Judul Artikel -->
                    <div class="sm:col-span-2">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Judul Artikel</label>
                        <input type="text" name="title" id="title" 
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" 
                               value="{{ old('title', $post->title) }}" required>
                    </div>

                    <!-- Upload Gambar -->
                    <div class="sm:col-span-2">
                        <label for="image" class="block mb-2 text-sm font-medium text-gray-900">Upload Gambar</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="image" class="flex flex-col items-center justify-center w-full min-h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 overflow-hidden">
                                
                                @if ($post->image)
                                    <!-- Preview gambar lama -->
                                    <div id="preview-container" class="w-full p-4">
                                        <img id="preview-image" src="{{ asset('storage/' . $post->image) }}" class="max-w-full max-h-96 mx-auto rounded-lg shadow-lg object-contain" alt="Preview">
                                        <div class="mt-3 text-center">
                                            <p class="text-sm text-gray-600" id="image-info">{{ basename($post->image) }}</p>
                                            <button type="button" id="remove-image" class="mt-2 px-3 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600">
                                                Hapus Gambar?
                                            </button>
                                        </div>
                                    </div>
                                    <div id="upload-placeholder" class="hidden"></div>
                                @else
                                    <!-- Placeholder upload -->
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6" id="upload-placeholder">
                                        <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                        <p class="text-xs text-gray-500">PNG, JPG (MAX. 2MB)</p>
                                    </div>
                                    <div id="preview-container" class="hidden w-full p-4">
                                        <img id="preview-image" class="max-w-full max-h-96 mx-auto rounded-lg shadow-lg object-contain" alt="Preview">
                                        <div class="mt-3 text-center">
                                            <p class="text-sm text-gray-600" id="image-info"></p>
                                            <button type="button" id="remove-image" class="mt-2 px-3 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600">
                                                Hapus Gambar
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                            </label>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="w-full">
                        <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                        <select id="category_id" name="category_id" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                            <option value="">Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Isi Artikel -->
                    <div class="sm:col-span-2">
                        <label for="body" class="block mb-2 text-sm font-medium text-gray-900">Isi Artikel</label>
                        <textarea id="body" name="body" rows="12" 
                                  class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500" 
                                  required>{{ old('body', $post->body) }}</textarea>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex items-center space-x-4 mt-6">
                    <button type="submit" 
                            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h3V6a1 1 0 112 0v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Update Artikel
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
        const removeImageField = document.getElementById('remove_image_field');

        // preview & validasi ukuran gambar
        if (imageInput) {
            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    if (file.size > 2 * 1024 * 1024) {
                        alert('File terlalu besar! Maksimal 2MB.');
                        imageInput.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        imageInfo.textContent = `${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
                        uploadPlaceholder.classList.add('hidden');
                        previewContainer.classList.remove('hidden');
                        removeImageField.value = "0"; // reset kalau upload baru
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // hapus gambar
        if (removeImageBtn) {
            removeImageBtn.addEventListener('click', function(e) {
                e.preventDefault();
                imageInput.value = '';
                previewContainer.classList.add('hidden');
                uploadPlaceholder.classList.remove('hidden');
                removeImageField.value = "1"; // tandai hapus
            });
        }
    
       
        document.addEventListener("DOMContentLoaded", function() {
            ClassicEditor
                .create( document.querySelector( '#body' ), { // Inisialisasi pada textarea dengan ID 'body'
                    // Konfigurasi Toolbar
                    toolbar: {
                        items: [
                            'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo'
                        ]
                    },
                    // Nonaktifkan fitur auto-saving (opsional)
                    licenseKey: '', 
                } )
                .then( editor => {
                    console.log( 'CKEditor siap digunakan', editor );
                } )
                .catch( error => {
                    console.error( 'Ada kesalahan saat inisialisasi CKEditor:', error );
                } );
        });
        
        // ... (sisanya adalah script lama Anda untuk image preview/SweetAlert, biarkan saja)
    </script>
</x-html>
