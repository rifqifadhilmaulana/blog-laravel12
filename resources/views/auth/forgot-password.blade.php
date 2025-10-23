<x-tamplat>
  <x-slot:title>Lupa Password</x-slot:title>

  <body class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <!-- Main Container -->
    <div class="w-full max-w-md">
      <div class="bg-white rounded-2xl shadow-2xl overflow-hidden ring-2 ring-white/30 ring-offset-8 ring-offset-transparent">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-center py-6 px-4">
          <h2 class="text-2xl sm:text-3xl font-bold uppercase tracking-wide">Lupa Password</h2>
          <p class="text-purple-100 text-sm mt-1">Reset password akun Anda</p>
        </div>

        <!-- Form Container -->
        <div class="p-6 sm:p-8 lg:p-10">
          
          {{-- Status Message --}}
          @if (session('status'))
            <div class="mb-4 p-3 text-sm text-green-700 bg-green-50 rounded-lg border border-green-200">
              {{ session('status') }}
            </div>
          @endif

          {{-- Instruction Text --}}
          <p class="text-sm text-gray-600 mb-6">
            Masukkan alamat email Anda dan kami akan mengirimkan link untuk mereset password.
          </p>

          <form method="POST" action="{{ route('password.email') }}">
            @csrf

            {{-- Email Field --}}
            <div class="mb-6">
              <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Email</label>
              <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus
                placeholder="email@example.com"
                class="w-full px-4 py-2.5 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all h-11"
              />
              @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Submit Button --}}
            <button 
              type="submit"
              class="w-full py-3 px-4 text-base font-semibold text-white rounded-lg transition-all shadow-lg hover:shadow-xl uppercase tracking-wide"
              style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"
            >
              Kirim Link Reset Password
            </button>
          </form>

          {{-- Back to Login Link --}}
          <div class="text-center mt-6 pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-600">
              Ingat password Anda? 
              <a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:text-purple-700 hover:underline">
                Login di sini
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </body>
</x-tamplat>