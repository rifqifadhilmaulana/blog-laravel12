<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
@auth
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-4 mb-3 -ml-64 ">
            <a href="{{ route('posts.create') }}" 
               class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
                Buat Artikel Baru
            </a>
        </div>
    @endauth
    {{-- Pagination atas --}}
    <div class="mb-6 mt-6">
        {{ $posts->links() }}
    </div>
    
    {{--  Daftar artikel --}}
   <div class="grid gap-6 items-start  grid-cols-1 mt-4">
    @forelse ($posts as $post)
        <article
            class="flex flex-col p-2 xl:mx-12 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 
                   dark:border-gray-700 shadow-sm hover:shadow-md transition duration-200">

                {{-- Kategori & waktu --}}
                <div class="flex justify-between items-center px-4 pt-4 text-gray-500 dark:text-gray-400 text-xs sm:text-sm">
                    <a href="/posts?category={{ $post->category->slug }}"
                       class="text-white px-2.5 py-0.5 rounded-full font-semibold text-[10px] sm:text-xs 
                              {{ $post->category->color ?? 'bg-blue-500' }}">
                        {{ $post->category->name ?? 'Uncategorized' }}
                    </a>
                    <span>{{ $post->created_at->diffForHumans() }}</span>
                </div>

                {{--  Gambar --}}
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}"
                         alt="{{ $post->title }}"
                         class=" mb-4 rounded-lg mt-4  w-full object-cover max-h-60">
                @endif

                {{-- Judul --}}
                <div class="px-4 mt-3">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100 hover:underline leading-snug">
                        <a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
                    </h2>
                </div>

                {{-- Isi ringkas --}}
                <p class="px-4 mt-2 mb-4 text-sm font-light text-gray-600 dark:text-gray-300 flex-1">
                    {{ Str::limit(strip_tags($post->body), 120) }}
                </p>

                {{-- Footer author dan tombol --}}
                <div class="px-4 pb-4 flex items-center justify-between border-t border-gray-100 dark:border-gray-700 pt-3">
                    <div class="flex items-center gap-2">
                        @if ($post->author->avatar ?? false)
                            <img src="{{ asset('storage/' . $post->author->avatar) }}"
                                 alt="{{ $post->author->username }}"
                                 class="w-8 h-8 rounded-full object-cover">
                        @else
                            <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white">
                                {{ strtoupper(substr($post->author->username, 0, 1)) }}
                            </div>
                        @endif

                        <a href="{{ route('profile.user', $post->author->username) }}"
                           class="font-medium text-gray-900 dark:text-gray-100 hover:underline text-sm">
                            {{ $post->author->name}}
                        </a>
                    </div>

                    <a href="/posts/{{ $post->slug }}"
                       class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                        Baca
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                  clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </article>
        @empty
            {{-- 🚫 Jika tidak ada post --}}
            <div class="flex flex-col items-center justify-center text-center py-16 col-span-full">
                <div class="bg-red-100 border border-red-300 text-red-700 px-6 py-4 rounded-2xl shadow-md max-w-md">
                    <h2 class="text-2xl font-bold mb-2">Not Found</h2>
                    <p class="text-base text-gray-600">
                        Maaf, data yang kamu cari tidak ditemukan.
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- 🔽 Pagination bawah --}}
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</x-layout>
