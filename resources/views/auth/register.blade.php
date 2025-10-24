{{-- resources/views/auth/register.blade.php (Rombak Total) --}}
<x-tamplat>
  <x-slot:title>{{ $title ?? 'Registrasi' }}</x-slot:title>

  {{-- Mengganti full gradient dengan latar belakang yang lebih minimalis --}}
  <body class="min-h-screen flex items-center justify-center p-4 bg-gray-50 dark:bg-gray-900">
    <div class="w-full max-w-4xl mx-auto">
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
        
        <div class="grid grid-cols-1 md:grid-cols-2">
            
            {{-- Kolom Kiri: Ilustrasi / Branding --}}
            <div class="flex flex-col justify-center p-10 text-white" 
                 style="background: linear-gradient(135deg, #2b6cb0 0%, #4c51bf 100%);"> {{-- Warna biru/indigo kustom --}}
                <h1 class="text-3xl font-bold mb-3">Gabung Komunitas Kami!</h1>
                <p class="text-white text-opacity-90">
                    Daftar sekarang dan mulai posting artikel menarik Anda, berinteraksi, dan jelajahi berbagai teori.
                </p>
                <div class="mt-8">
                    {{-- Ganti dengan logo atau ilustrasi sederhana --}}
                    <svg class="w-full h-auto text-white opacity-80" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h2v-6h-2v6zm0-8h2V7h-2v2z"/>
                    </svg>
                </div>
            </div>

            {{-- Kolom Kanan: Form Registrasi --}}
            <div class="p-6 sm:p-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Buat Akun Baru</h2>
                </div>

                {{-- Status & Error Messages (biarkan tetap sama) --}}
                @if(session('success'))
                    <div class="mb-4 p-3 text-sm text-green-700 bg-green-50 rounded-lg border border-green-200">
                      {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 p-3 text-sm text-red-700 bg-red-50 rounded-lg border border-red-200">
                      <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                @endif
                
                <form action="{{ route('register-proses') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               placeholder="Nama Lengkap"
                               class="w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        />
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email Field --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               placeholder="email@contoh.com"
                               class="w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        />
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Username Field --}}
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" required
                               placeholder="usernameunik"
                               class="w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        />
                        @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Password Field --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                        <input type="password" id="password" name="password" required
                               placeholder="Minimal 8 karakter"
                               class="w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        />
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Confirm Password Field --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               placeholder="Ketik ulang password"
                               class="w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        />
                    </div>

                    {{-- Register Button --}}
                    <button type="submit"
                            class="w-full py-3 px-4 text-base font-semibold text-white rounded-lg transition-all shadow-lg hover:shadow-xl uppercase tracking-wide mt-6 bg-blue-600 hover:bg-blue-700">
                      Daftar Sekarang
                    </button>
                </form>

                {{-- Login Link --}}
                <div class="text-center mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                      Sudah punya akun? 
                      <a href="{{ url('/login') }}" class="text-blue-600 font-semibold hover:text-blue-700 hover:underline">
                        Login di sini
                      </a>
                    </p>
                </div>
            </div>
        </div>
      </div>
    </div>
  </body>
</x-tamplat>