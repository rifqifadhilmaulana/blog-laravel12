<x-html>
    <x-slot:title>{{ $title }}</x-slot:title>

    <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 p-4 -mt-32">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-4 text-xl font-bold text-gray-900">Buat Kategori Baru</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">

                    {{-- Nama Kategori --}}
                    @php
                        $inputClass = $errors->has('name')
                            ? 'bg-gray-50 border border-red-500 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5'
                            : 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5';
                    @endphp
                    <div class="sm:col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Kategori</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                               class="{{ $inputClass }}" placeholder="Masukkan nama kategori (misal: Teknologi)" required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kelas Warna Tailwind (misal: bg-blue-600) --}}
                     @php
                        $inputClass = $errors->has('color')
                            ? 'bg-gray-50 border border-red-500 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5'
                            : 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5';
                    @endphp
                    <div class="sm:col-span-2">
                        <label for="color" class="block mb-2 text-sm font-medium text-gray-900">Kelas Warna (Tailwind)</label>
                        <input type="text" name="color" id="color" value="{{ old('color', 'bg-blue-600') }}"
                               class="{{ $inputClass }}" placeholder="Contoh: bg-red-500" required>
                        <p class="mt-2 text-xs text-gray-500">Gunakan format kelas Tailwind CSS (e.g., bg-blue-600, bg-pink-500).</p>
                        @error('color')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                </div>

                <div class="flex items-center space-x-4 mt-6">
                    <button type="submit" 
                            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-html>