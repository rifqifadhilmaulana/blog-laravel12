<x-html>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- Card Profil --}}
    <div class="max-w-md mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 text-center -mt-19">
       @if ($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}"
             alt="{{ $user->username }}"
             class="w-24 h-24 mx-auto rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">
        @else
              <div class="w-24 h-24 mx-auto rounded-full bg-blue-500 flex items-center justify-center text-white text-3xl font-bold border-2 border-gray-300 dark:border-gray-600">
                  {{ strtoupper(substr($user->username, 0, 1)) }}
             </div>
        @endif


        {{-- Nama & Username --}}
        <h2 class="mt-2 text-2xl font-semibold text-gray-800 dark:text-gray-100">
            {{ $user->name }}
        </h2>
        <p class="text-gray-500 dark:text-gray-400">{{ '@' . $user->username }}</p>

        {{-- Bio --}}
        <p class="mt-2 text-gray-600 dark:text-gray-300">
            {{ $user->bio ?? 'Belum ada bio.' }}
        </p>

        {{-- Statistik --}}
      <div class="mt-2 flex gap-10 justify-center items-center text-gray-700 dark:text-gray-200">
    <!-- Mengikuti -->
    <a href="{{ route('user.following', $user->username) }}" class="flex flex-col items-center hover:underline">
        <span class="font-bold text-lg">{{ $user->followings()->count() }}</span>
        <span class="text-sm">Mengikuti</span>
    </a>

    <!-- Artikel -->
    <a href="/posts?author={{ $user->username }}" class="flex flex-col items-center">
        <span class="font-bold text-lg">{{ $user->posts()->count() }}</span>
        <span class="text-sm">Artikel</span>
    </a>

    <!-- Diikuti -->
    <a href="{{ route('user.followers', $user->username) }}" class="flex flex-col items-center hover:underline">
        <span class="font-bold text-lg">{{ $user->followers()->count() }}</span>
        <span class="text-sm">pengikut</span>
    </a>
</div>



                {{-- Tombol Edit Profil (hanya untuk user yang sedang login) --}}
      @auth
    @if(Auth::id() === $user->id)
        {{-- Jika profil milik sendiri → tombol Edit Profil --}}
        <div class="mt-3">
            <a href="{{ route('profile.edit') }}"
               class="inline-block px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                ✏️ Edit Profil
            </a>
        </div>
    @else
        {{-- Jika profil orang lain → tombol Follow/Unfollow --}}
        @php
            $isFollowing = Auth::user()->followings->contains($user->id);
        @endphp

        <div class="mt-3">
            <form action="{{ route('follow.toggle', $user->username) }}" method="POST">
                @csrf
                <button type="submit"
                        title="{{ $isFollowing ? 'Berhenti mengikuti ' . $user->name : 'Ikuti ' . $user->name }}"
                        class="inline-block px-4 py-2 text-sm mt-2 font-semibold rounded-lg shadow focus:ring-2 focus:ring-blue-400 focus:outline-none
                        {{ $isFollowing ? ' border-2 bg-gray-100 text-gray-900 border-gray-300 hover:bg-gray-200  ' : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                    {{ $isFollowing ? 'Mengikuti' : 'Ikuti' }}
                </button>
            </form>
        </div>
    @endif
@endauth

    </div>

    {{-- Artikel User --}}
      @auth
            
                <h3 class="text-2xl mt-6  font-bold mb-8 text-gray-800 dark:text-gray-100">
                    @if(Auth::id() === $user->id)
                        Artikel Saya
                    @else
                        Artikel By {{ $user->username }}
                    @endif
                </h3>
           
        @endauth

    

        {{-- Pagination atas --}}
        <div class="mb-4 -mt-4">
            {{ $posts->links() }}
        </div>

        {{-- Daftar Artikel --}}
        <div class="grid gap-5 grid-cols-1 mt-12">
            @forelse ($posts as $post)
            <article class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-md dark:shadow-gray-900 flex flex-col h-full">

                {{-- Bagian atas --}}
                  <div class="flex justify-between items-center mb-5 text-gray-500 dark:text-gray-400">
                    <a href="/posts?category={{ $post->category->slug }}"
                       class="text-white px-2.5 py-0.5 rounded-full font-semibold text-[10px] sm:text-xs 
                              {{ $post->category->color ?? 'bg-blue-500' }}">
                        {{ $post->category->name ?? 'Uncategorized' }}
                    </a>

                    <span class="text-sm">{{ $post->created_at->diffForHumans() }}</span>
                </div>

                    

                {{-- Judul --}}
                 @if ($post->image)
                <h2 class="mb-4 -mt-3 text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-100">
                   <a href="/posts/{{ $post->slug }}" class="hover:underline">{{ $post->title }}</a>
                </h2>
            @else
                <h2 class="mb-3 -mt-4 text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-100">
                   <a href="/posts/{{ $post->slug }}" class="hover:underline">{{ $post->title }}</a>
                </h2>
            @endif
                
                {{-- Gambar --}}
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" 
                         alt="{{ $post->title }}" 
                         class="mb-4 rounded-lg w-full object-cover max-h-60">
                @endif

                {{-- Preview --}}
                 <p class=" px-4 mt-2 mb-4 text-sm font-light text-gray-600 dark:text-gray-300 flex-1">
                     {{ Str::limit(strip_tags($post->body), 150) }}
                 </p>

                {{-- Footer --}}
              <div class="px-4 pb-4 flex items-center justify-between border-t border-gray-100 dark:border-gray-700 pt-3">
                <div class="flex items-center gap-2">
                    {{-- Avatar Author --}}
                    @if ($post->author->avatar ?? false)
                        <img src="{{ asset('storage/' . $post->author->avatar) }}" 
                             alt="{{ $post->author->username }}" 
                             class="w-8 h-8 rounded-full object-cover">
                    @else
                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white">
                            {{ strtoupper(substr($post->author->username, 0, 1)) }}
                        </div>
                    @endif

                    <a href="/posts?author={{ $post->author->username }}"
                class="font-medium text-gray-900 dark:text-gray-100 hover:underline">
                    {{ $post->author->username }}
                </a>

                    </div>

                    <a href="/posts/{{ $post->slug }}" 
                       class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                        Baca
                        <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>
            </article>
            @empty
            <div class="flex flex-col items-center justify-center text-center py-16">
                <div class="bg-red-100 border border-red-300 text-red-700 px-6 py-4 rounded-2xl shadow-md max-w-md">
                    <h2 class="text-2xl font-bold mb-2">Belum ada artikel</h2>
                @if (Auth::id()===$user->id)
                    <p class="text-base text-gray-600">
                        Kamu belum menulis artikel apapun.
                    </p>
                    @else
                    <p class="text-base text-gray-600">
                        {{ $user->username }} belum menulis artikel apapun.
                    </p>
                @endif
                    
                </div>
            </div>
            @endforelse
        </div>

        {{-- Pagination bawah --}}
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>
</x-html>
