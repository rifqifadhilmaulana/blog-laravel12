<x-tamplat>
    <x-slot:title>{{ $title ?? 'My Favorites' }}</x-slot:title>
    <x-navbar></x-navbar>

    <div class="max-w-7xl mx-auto p-4 sm:ml-64">
        {{-- Form Search --}}
        <form method="GET" action="{{ route('my.favorites') }}" class="mb-6">
            <div class="flex items-center gap-2">
                <input
                    type="search"
                    id="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari postingan favorit..."
                    class="flex-1 w-full p-2 sm:p-3 text-sm sm:text-base text-gray-900 border border-gray-300 rounded-lg 
                           bg-gray-50 focus:ring-blue-500 focus:border-blue-500 
                           dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                           dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                <button type="submit"
                    class="px-4 py-2 text-sm sm:text-base font-medium text-white bg-blue-600 hover:bg-blue-700 
                           rounded-lg focus:ring-4 focus:outline-none focus:ring-blue-300 
                           dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                    Cari
                </button>
            </div>
        </form>

        {{-- 🔽 Pagination atas --}}
        <div class="mb-6">
            {{ $posts->links() }}
        </div>

        {{-- 🧾 Daftar Postingan --}}
        <div class="grid gap-6 items-start">
            @forelse ($posts as $post)
                <article
                    class="p-5 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 
                           shadow-sm hover:shadow-lg transition-shadow duration-200 flex flex-col h-full">

                    {{-- Bagian atas --}}
                    <div class="flex justify-between items-center mb-3 text-gray-500 dark:text-gray-400">
                         <a href="/posts?category={{ $post->category->slug }}"
                       class="text-white px-2.5 py-0.5 rounded-full font-semibold text-[10px] sm:text-xs 
                              {{ $post->category->color ?? 'bg-blue-500' }}">
                        {{ $post->category->name ?? 'Uncategorized' }}
                    </a>
                        <span class="text-xs sm:text-sm">{{ $post->created_at->diffForHumans() }}</span>
                    </div>

                    {{-- Judul --}}
                    <h2 class="mb-2 text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100 leading-snug">
                        <a href="{{ route('posts.show', $post) }}" class="hover:underline">{{ $post->title }}</a>
                    </h2>

                    {{-- Gambar --}}
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                            class="mb-3 rounded-lg w-full object-cover max-h-60">
                    @endif

                    {{-- Isi Preview --}}
                    <p class="mb-4 text-sm text-gray-600 dark:text-gray-300 flex-1">
                        {{ Str::limit(strip_tags($post->body), 150) }}
                    </p>

                    {{-- Footer --}}
                    <div class="flex justify-between items-center mt-auto pt-2 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-2">
                            {{-- Avatar --}}
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

                            {{-- Username --}}
                            <a href="{{ route('profile.user', $post->author->username) }}"
                                class="text-sm font-medium text-gray-900 dark:text-gray-100 hover:underline">
                                {{ $post->author->username }}
                            </a>
                        </div>

                        {{-- Tombol hapus favorit --}}
                        <form action="{{ route('posts.favorite', $post) }}" method="POST" class="unfavorite-form">
                            @csrf
                            <button type="submit"
                                class="px-3 py-1.5 text-xs sm:text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                Hapus koleksi
                            </button>
                        </form>
                    </div>
                </article>
            @empty
                @if (request('search'))
                    <p class="text-gray-500 text-center">Tidak ada hasil untuk "{{ request('search') }}".</p>
                @else
                    <div class="flex flex-col items-center justify-center text-center py-16">
                        <div
                            class="bg-yellow-100 border border-yellow-300 text-yellow-700 px-6 py-4 rounded-2xl shadow-md max-w-md">
                            <h2 class="text-2xl font-bold mb-2">Belum ada Favorit</h2>
                            <p class="text-base text-gray-600">
                                Simpan postingan kesukaanmu, lalu tampil di sini.
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
        document.querySelectorAll('.unfavorite-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Hapus dari favorit?',
                    text: "Postingan ini akan dihapus dari koleksi kamu.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        @if (session('success'))
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
