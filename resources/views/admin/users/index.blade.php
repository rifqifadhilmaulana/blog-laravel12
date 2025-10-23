<x-html>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8 -mt-18">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $title }}</h1>
        
        <a href="{{ route('admin.dashboard') }}"
            class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Dashboard Admin
        </a>

        {{-- Notifikasi --}}
        @if(session('success'))
        <div class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 p-4 rounded-lg mb-6 border border-green-200 dark:border-green-800">
            {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 p-4 rounded-lg mb-6 border border-red-200 dark:border-red-800">
            {{ session('error') }}
        </div>
        @endif
        
        {{-- Search Bar --}}
        <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6">
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

        {{-- Pagination Top --}}
        <div class="mb-4">
            {{ $users->links() }}
        </div>

        {{-- Tabel Users --}}
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                User Info
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Role
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Artikel
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    @if ($user->avatar)
                                        <img class="w-10 h-10 rounded-full object-cover flex-shrink-0" 
                                             src="{{ asset('storage/' . $user->avatar) }}" 
                                             alt="{{ $user->username }}">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold flex-shrink-0">
                                            {{ strtoupper(substr($user->username, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            <a href="{{ route('profile.user', $user->username) }}" 
                                               class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                                {{ $user->name }}
                                            </a>
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                            {{ '@'.$user->username }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($user->isAdmin())
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                        Admin
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                        User
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300 font-medium">
                                {{ $user->posts()->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('ANDA YAKIN INGIN MENGHAPUS USER {{ $user->username }}? Tindakan ini permanen dan akan menghapus semua postingannya.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors font-medium">
                                            Hapus Permanen
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500 text-xs italic">
                                        Anda Admin yang sedang login
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="text-gray-500 dark:text-gray-400">
                                    @if(request('search'))
                                        Tidak ada hasil untuk "<span class="font-semibold">{{ request('search') }}</span>".
                                    @else
                                        Tidak ada pengguna ditemukan.
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination Bottom --}}
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</x-html>