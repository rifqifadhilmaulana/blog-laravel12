<x-tamplat>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-navbar></x-navbar>

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 sm:ml-64">

        {{--  Search bar --}}
        <form method="GET" action="{{ route('myposts') }}" class="mb-6">
            <div class="flex justify-center items-center gap-2">
                <input
                    type="search"
                    id="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari postingaanmu..."
                    class="flex-1 w-full p-2.5 text-sm border border-gray-300 rounded-lg 
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           placeholder-gray-400 bg-white dark:bg-gray-800 dark:text-white 
                           dark:border-gray-700 transition" />

                <button
                    type="submit"
                    class="flex items-center justify-center gap-1 px-4 py-2 text-sm font-medium text-white 
                           bg-blue-600 hover:bg-blue-700 rounded-lg focus:ring-4 focus:outline-none 
                           focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                    {{-- 🔍 Icon Search --}}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
                    </svg>
                    <span>Cari</span>
                </button>
            </div>
        </form>

        {{-- Pagination atas --}}
        <div class="mb-6">
            {{ $posts->links() }}
        </div>

        {{-- 🧾 Daftar Postingan --}}
       <div class="grid gap-6 items-start ">
            @forelse ($posts as $post)
                <article
                    class="flex flex-col p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 
                        dark:border-gray-700 shadow-sm hover:shadow-md transition duration-200">

                    {{-- Bagian atas --}}
                    <div class="flex justify-between items-center mb-4 text-gray-500 dark:text-gray-400">
                        <a href="/posts?category={{ $post->category->slug }}"
                       class="text-white px-2.5 py-0.5 rounded-full font-semibold text-[10px] sm:text-xs 
                              {{ $post->category->color ?? 'bg-blue-500' }}">
                        {{ $post->category->name ?? 'Uncategorized' }}
                    </a>
                        <span class="text-xs sm:text-sm">{{ $post->created_at->diffForHumans() }}</span>
                    </div>

                    {{-- Judul --}}
                    <h2 class="mb-2 text-lg sm:text-xl font-bold tracking-tight text-gray-900 dark:text-gray-100">
                        <a href="/posts/{{ $post->slug }}" class="hover:underline">{{ $post->title }}</a>
                    </h2>

                    {{-- Gambar --}}
                   
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}"
                        alt="{{ $post->title }}"
                        class="rounded-lg w-full object-cover max-h-60 mb-3">
                @else
                    {{-- kalau gak ada gambar, beri jarak kecil agar teks tetap rapi --}}
                    <div class="mb-1"></div>
                @endif

                    {{-- Isi Preview --}}
                    <p class="mb-4 text-sm text-gray-600 dark:text-gray-300 flex-1">
                        {{ Str::limit(strip_tags($post->body), 150) }}
                    </p>

                    {{-- Footer --}}
                    <div class="flex justify-between items-center mt-auto pt-2 border-t border-gray-100 dark:border-gray-700">
                        {{-- Avatar dan Username --}}
                        <div class="flex items-center gap-2">
                            @if ($post->author->avatar ?? false)
                                <img src="{{ asset('storage/' . $post->author->avatar) }}"
                                    alt="{{ $post->author->username }}"
                                    class="w-8 h-8 rounded-full object-cover">
                            @else
                                <div
                                    class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($post->author->username, 0, 1)) }}
                                </div>
                            @endif

                            <a href="/posts?author={{ $post->author->username }}"
                                class="text-sm font-medium text-gray-900 dark:text-gray-100 hover:underline">
                                {{ $post->author->username }}
                            </a>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex space-x-2">
                            {{-- Tombol Edit --}}
                            @if ($post->created_at->gt(now()->subMinutes(17)))
                                <a href="{{ route('posts.edit', $post) }}"
                                    class="px-3 py-1.5 text-xs sm:text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                                    Edit
                                </a>
                            @endif

                            {{-- Tombol Delete --}}
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1.5 text-xs sm:text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                @if (request('search'))
                    <p class="text-gray-500 text-center">Tidak ada hasil untuk "{{ request('search') }}".</p>
                @else
                    <div class="flex flex-col items-center justify-center text-center py-16">
                        <div
                            class="bg-red-100 border border-red-300 text-red-700 px-6 py-4 rounded-2xl shadow-md max-w-md">
                            <h2 class="text-2xl font-bold mb-2">Not Found</h2>
                            <p class="text-base text-gray-600">
                                Maaf, kamu belum punya postingan.
                            </p>
                        </div>
                    </div>
                @endif
            @endforelse
        </div>

        {{-- Pagination bawah --}}
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Konfirmasi sebelum delete
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Yakin hapus postingan ini?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        // Notifikasi sukses
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
        @endif
    </script>
</x-tamplat>
