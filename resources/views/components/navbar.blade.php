<x-tamplat>
    <x-slot:title>Throrix</x-slot:title>
<body class="bg-gray-50">

<!-- Tombol Sidebar (Mobile) -->
<button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
    aria-controls="logo-sidebar" type="button"
    class="inline-flex items-center p-2.5 mt-2 ms-3 text-sm text-gray-600 rounded-lg sm:hidden 
           hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 
           dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 transition-all duration-200">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" clip-rule="evenodd"
            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 
               0 010 1.5H2.75A.75.75 0 012 4.75zm0 
               10.5a.75.75 0 01.75-.75h7.5a.75.75 
               0 010 1.5h-7.5a.75.75-.75zM2 10a.75.75 
               0 01.75-.75h14.5a.75.75 
               0 010 1.5H2.75A.75.75 0 012 10z" />
    </svg>
</button>

<!-- Sidebar -->
<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full 
           sm:translate-x-0 bg-white dark:bg-gray-900 border-r border-gray-100 dark:border-gray-800"
    aria-label="Sidebar">

    <div class="h-full px-4 py-6 overflow-y-auto flex flex-col">
        <a href="/" class="flex items-center px-2 mb-8">
            <div class="shrink-0 ">
                <div class="bg-gradient-to-br from-indigo-500 via-purple-500 to-blue-500 px-5 py-2.5 rounded-lg">
                    <span class="font-extrabold text-white text-xl tracking-tight">Theoria.</span>
                </div>
            </div>
        </a>

        <nav class="flex-1">
            <ul class="space-y-2 font-medium">

                 @if(auth()->check() && auth()->user()->isAdmin())
                 <li>
                    <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->is('admin*')"
                        class="flex items-center px-3 py-2.5 text-red-600 rounded-lg hover:bg-red-50 
                               dark:text-red-400 dark:hover:bg-red-900/20 transition-colors duration-150 group">
                        <div class="flex items-center justify-center w-8 h-8 bg-red-100 rounded-lg group-hover:bg-red-200 dark:bg-gray-800 dark:group-hover:bg-red-900/30">
                            <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="ms-3 text-sm font-bold">ADMIN PANEL</span>
                    </x-nav-link>
                </li>
                @endif

                <li>
                    <x-nav-link href="/posts" :active="request()->is('posts')"
                        class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gray-50 
                               dark:text-gray-300 dark:hover:bg-gray-800 transition-colors duration-150 group">
                        <div class="flex items-center justify-center w-8 h-8 bg-indigo-50 rounded-lg group-hover:bg-indigo-100 dark:bg-gray-800 dark:group-hover:bg-gray-700">
                              <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h10M5 11h10M5 15h5M10 3H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2Z"/>
                            </svg>
                        </div>
                        <span class="ms-3 text-sm">Post</span>
                    </x-nav-link>
                </li>

                @auth
                <li>
                    <x-nav-link href="/mypost" :active="request()->is('mypost')"
                        class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gray-50 
                               dark:text-gray-300 dark:hover:bg-gray-800 transition-colors duration-150 group">
                        <div class="flex items-center justify-center w-8 h-8 bg-purple-50 rounded-lg group-hover:bg-purple-100 dark:bg-gray-800 dark:group-hover:bg-gray-700">
                            <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="ms-3 text-sm">MyPost</span>
                    </x-nav-link>
                </li>

                {{-- myfavorite --}}
                <li>
                    <x-nav-link href="/myfavorite" :active="request()->is('myfavorite')"
                        class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gray-50 
                               dark:text-gray-300 dark:hover:bg-gray-800 transition-colors duration-150 group">
                        <div class="flex items-center justify-center w-8 h-8 bg-cyan-50 rounded-lg group-hover:bg-cyan-100 dark:bg-gray-800 dark:group-hover:bg-gray-700">
                            <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 8a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8Z"/>
                                <path d="M14.316 7.08a1 1 0 0 0-2 0V5a2 2 0 1 0-4 0v2.08a1 1 0 1 0-2 0V5a4 4 0 1 1 8 0v2.08Z"/>
                            </svg>
                        </div>
                        <span class="ms-3 text-sm">koleksi</span>
                    </x-nav-link>
                </li>
                
               
                <li>
                    <x-nav-link href="/create" :active="request()->is('create')"
                        class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gray-50 
                               dark:text-gray-300 dark:hover:bg-gray-800 transition-colors duration-150 group">
                        <div class="flex items-center justify-center w-8 h-8 bg-emerald-50 rounded-lg group-hover:bg-emerald-100 dark:bg-gray-800 dark:group-hover:bg-gray-700">
                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/>
                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="ms-3 text-sm">Create Post</span>
                    </x-nav-link>
                </li>

                <li>
                    <x-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')"
                        class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gray-50 
                               dark:text-gray-300 dark:hover:bg-gray-800 transition-colors duration-150 group">
                        <div class="flex items-center justify-center w-8 h-8 bg-blue-50 rounded-lg group-hover:bg-blue-100 dark:bg-gray-800 dark:group-hover:bg-gray-700">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="ms-3 text-sm">Profil</span>
                    </x-nav-link>
                </li>
                @endauth
            </ul>
        </nav>

        <div class="pt-4 mt-auto border-t border-gray-100 dark:border-gray-800">
            <ul class="space-y-2">
                @auth
                <li>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <x-nav-link href="#" 
                            onclick="event.preventDefault(); confirmLogout();"
                            class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-red-50 
                                   dark:text-gray-300 dark:hover:bg-red-900/20 transition-colors duration-150 group">
                            <div class="flex items-center justify-center w-8 h-8 bg-red-50 rounded-lg group-hover:bg-red-100 dark:bg-gray-800 dark:group-hover:bg-red-900/30">
                                <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="ms-3 text-sm">Logout</span>
                        </x-nav-link>
                    </form>
                </li>
                @endauth
                
                @guest
                <li>
                    <x-nav-link href="/login" :active="request()->is('auth.login')"
                        class="flex items-center px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gray-50 
                               dark:text-gray-300 dark:hover:bg-gray-800 transition-colors duration-150 group">
                        <div class="flex items-center justify-center w-8 h-8 bg-green-50 rounded-lg group-hover:bg-green-100 dark:bg-gray-800 dark:group-hover:bg-gray-700">
                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="ms-3 text-sm">Login</span>
                    </x-nav-link>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</aside>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmLogout() {
    Swal.fire({
        title: 'Yakin mau logout?',
        text: "Kamu akan keluar dari aplikasi",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6366f1',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'rounded-xl',
            confirmButton: 'rounded-lg px-5 py-2.5',
            cancelButton: 'rounded-lg px-5 py-2.5'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    })
}
</script>


</x-tamplat>