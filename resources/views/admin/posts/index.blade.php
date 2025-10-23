<x-html>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 -mt-18">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $title }}</h1>

         
        <a href="{{ route('admin.dashboard') }}"
            class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Dashboard Admin
        </a>

        <form method="GET" action="{{ route('admin.posts.index') }}" class="mb-6">
            <div class="flex items-center gap-2">
                <input 
                    type="search" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari nama, username, atau email..."
                    class="flex-1 px-4 py-2.5 text-sm sm:text-base text-gray-900 border border-gray-300 rounded-lg
                           bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                           dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                
                <button 
                    type="submit" 
                    class="px-5 py-2.5 text-sm sm:text-base font-medium text-white bg-blue-600 hover:bg-blue-700
                           rounded-lg focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors
                           dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                    Cari
                </button>
            </div>
        </form>

        <div class="mb-4">
            {{ $posts->links() }}
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($posts as $post)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <a href="{{ route('posts.show', $post) }}" class="hover:underline">{{ $post->title }}</a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $post->author->username }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm ">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold text-white {{ $post->category->color }}">{{ $post->category->name }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Yakin hapus postingan ini secara permanen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada postingan ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</x-html>