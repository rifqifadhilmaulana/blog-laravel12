<x-tamplat>
  <x-slot:title>{{ $title ?? 'Register' }}</x-slot:title>

  <body class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <!-- Main Container -->
    <div class="w-full max-w-5xl">
      <div class="bg-white rounded-2xl shadow-2xl overflow-hidden ring-2 ring-white/30 ring-offset-8 ring-offset-transparent">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-center py-6 px-4">
          <h2 class="text-2xl sm:text-3xl font-bold uppercase tracking-wide">Register</h2>
          <p class="text-purple-100 text-sm mt-1">Buat akun baru Anda</p>
        </div>

        <!-- Form Container -->
        <div class="p-6 sm:p-8 lg:p-10">
          
          {{-- Success Message --}}
          @if(session('success'))
            <div class="mb-4 p-3 text-sm text-green-700 bg-green-50 rounded-lg border border-green-200">
              {{ session('success') }}
            </div>
          @endif

          {{-- Error Messages --}}
          @if ($errors->any())
            <div class="mb-4 p-3 text-sm text-red-700 bg-red-50 rounded-lg border border-red-200">
              <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('register-proses') }}" method="POST">
            @csrf

            <!-- Grid Layout for Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              
              {{-- Name Field --}}
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                <input 
                  type="text" 
                  id="name" 
                  name="name" 
                  value="{{ old('name') }}" 
                  required
                  placeholder="Masukkan nama lengkap"
                  class="w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all h-11"
                />
                @error('name')
                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
              </div>

              {{-- Email Field --}}
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input 
                  type="email" 
                  id="email" 
                  name="email" 
                  value="{{ old('email') }}" 
                  required
                  placeholder="email@example.com"
                  class="w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all h-11"
                />
                @error('email')
                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
              </div>

              {{-- Username Field --}}
              <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1.5">Username</label>
                <input 
                  type="text" 
                  id="username" 
                  name="username" 
                  value="{{ old('username') }}" 
                  required
                  placeholder="username"
                  class="w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all h-11"
                />
                @error('username')
                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
              </div>

              {{-- Password Field --}}
              <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                <div class="relative">
                  <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    placeholder="Min. 8 karakter"
                    class="w-full px-4 pr-10 py-2.5 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all h-11"
                  />
                  <button 
                    type="button"
                    onclick="togglePassword('password', 'eye-pw', 'eye-off-pw')"
                    class="absolute right-3 top-3 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none"
                  >
                    <svg id="eye-pw" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg id="eye-off-pw" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                  </button>
                </div>
                @error('password')
                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
              </div>

              {{-- Confirm Password Field --}}
              <div class="md:col-span-2">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                <div class="relative">
                  <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    required
                    placeholder="Konfirmasi password"
                    class="w-full px-4 pr-10 py-2.5 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all h-11"
                  />
                  <button 
                    type="button"
                    onclick="togglePassword('password_confirmation', 'eye-confirm', 'eye-off-confirm')"
                    class="absolute right-3 top-3 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none"
                  >
                    <svg id="eye-confirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg id="eye-off-confirm" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                  </button>
                </div>
              </div>
            </div>

            {{-- Register Button --}}
            <button 
              type="submit"
              class="w-full py-3 px-4 text-base font-semibold text-white rounded-lg transition-all shadow-lg hover:shadow-xl uppercase tracking-wide mt-6"
              style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"
            >
              Daftar Sekarang
            </button>
          </form>

          {{-- Login Link --}}
          <div class="text-center mt-6 pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-600">
              Sudah punya akun? 
              <a href="{{ url('/login') }}" class="text-purple-600 font-semibold hover:text-purple-700 hover:underline">
                Login di sini
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>

    <script>
      function togglePassword(inputId, eyeId, eyeOffId) {
        const input = document.getElementById(inputId);
        const eye = document.getElementById(eyeId);
        const eyeOff = document.getElementById(eyeOffId);
        
        if (input.type === 'password') {
          input.type = 'text';
          eye.classList.add('hidden');
          eyeOff.classList.remove('hidden');
        } else {
          input.type = 'password';
          eye.classList.remove('hidden');
          eyeOff.classList.add('hidden');
        }
      }
    </script>
  </body>
</x-tamplat>