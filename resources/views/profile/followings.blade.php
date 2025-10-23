<x-html>
    <x-slot:title> {{ $user->name }} mengikuti</x-slot:title>
    

    <div class="mx-auto max-w-4xl px-4 py-6 -mt-25 lg:-mt-15">
        {{-- 🧩 Header --}}
        <h1 class="text-xl sm:text-xl font-bold mb-4 capitalize">
            {{ $user->name }} Mengikuti
        </h1>

        {{-- 🔍 Search bar --}}
        <form method="GET" action="{{ route('user.following', $user->username) }}" class="mb-6">
            <div class="flex gap-2">
                <input
                    type="search"
                    id="search"
                    name="search"
                    value="{{ request('search') }}"
                    class="flex-1 p-2 sm:p-2.5 text-sm border border-gray-300 rounded-md
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           placeholder-gray-400 bg-white dark:bg-gray-800 dark:text-white dark:border-gray-700"
                    placeholder="Cari pengguna..."
                />
                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700
                           rounded-md focus:ring-4 focus:outline-none focus:ring-blue-300
                           dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                    Cari
                </button>
            </div>
        </form>

        {{-- 👥 Daftar followings --}}
        <div class="space-y-3">
            @forelse($followings as $following)
                <div
                    class="flex items-center justify-between bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 
                           rounded-xl p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    
                    {{-- Profil kiri --}}
                    <div class="flex items-center gap-3">
                        @if ($following->avatar)
                            <img src="{{ asset('storage/' . $following->avatar) }}" 
                                alt="{{ $following->username }}" 
                                class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div
                                class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr($following->username, 0, 1)) }}
                            </div>
                        @endif

                        <div>
                            <a href="{{ route('profile.user', $following->username) }}"
                                class="font-semibold text-gray-900 dark:text-white text-sm hover:underline">
                                {{ $following->name }}
                            </a>
                            <p class="text-xs text-gray-500">{{ '@' . $following->username }}</p>
                        </div>
                    </div>

                    {{-- Tombol kanan --}}
                    @auth
                        @if(auth()->id() !== $following->id)
                            <form action="{{ route('follow.toggle', $following->username) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="px-4 py-1.5 text-sm font-medium rounded-full border 
                                           {{ auth()->user()->followings->contains($following->id)
                                               ? 'bg-gray-100 text-gray-900 border-gray-300 hover:bg-gray-200'
                                               : 'bg-blue-600 text-white border-transparent hover:bg-blue-700' }}">
                                    {{ auth()->user()->followings->contains($following->id) ? 'Mengikuti' : 'Ikuti' }}
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            @empty
                <p class="text-center text-gray-500 mt-6">
                    @if(request('search'))
                        Tidak ada hasil untuk "<span class="font-semibold">{{ request('search') }}</span>".
                    @else
                        Belum ada yang mengikuti {{ $user->name }}.
                    @endif
                </p>
            @endforelse
        </div>
    </div>
</x-html>
