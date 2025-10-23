<x-html>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 -mt-18">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $title }}</h1>
        
        {{-- Header & Search --}}
        <div class="flex mb-7 sm:flex-row items-center justify-between  sm:space-y-0">
            <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-center">
                Tambah Kategori Baru
            </a>
            <form method="GET" action="{{ route('admin.categories.index') }}" class="space-x-3">
                <input type="search" name="search" placeholder="Cari kategori.." value="{{ request('search') }}" class="border border-gray-300 rounded-lg p-2 text-sm">
                <button type="submit" class="px-3 py-2 bg-gray-200 rounded-lg text-sm hover:bg-gray-300">Cari</button>
            </form>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">{{ session('success') }}</div>
        @endif
        
        @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">{{ session('error') }}</div>
        @endif

        <div class="bg-white shadow overflow-hidden sm:rounded-lg overflow-x-auto ">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Warna</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($categories as $category)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->slug }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                             <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold text-white {{ $category->color }}">{{ $category->color }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-3">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini? Semua post yang terkait harus dipindahkan terlebih dahulu.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada kategori ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</x-html>