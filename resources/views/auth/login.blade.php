<x-tamplat>
    <x-slot:title>{{ $title ?? 'Login' }}</x-slot:title>

    <body class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <!-- Main Container -->
        <div class="w-full max-w-4xl">
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden ring-2 ring-white/30 ring-offset-8 ring-offset-transparent">
                <div class="grid md:grid-cols-2">
                    
                    {{-- Left Side - Welcome Section --}}
                    <div class="flex flex-col justify-center p-12 relative overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        {{-- Decorative circles --}}
                        <div class="absolute top-0 right-0 w-40 h-40 bg-white opacity-5 rounded-full -mr-20 -mt-20"></div>
                        <div class="absolute bottom-0 left-0 w-32 h-32 bg-white opacity-5 rounded-full -ml-16 -mb-16"></div>
                        
                        {{-- Content --}}
                        <div class="relative z-10">
                            <h1 class="text-3xl font-bold text-white mb-4">
                                Welcome to website Throrix
                            </h1>
                            <p class="text-white text-opacity-90 text-sm leading-relaxed">
                               Masuk dan mulai jelajahi dunia Throrix, tempat di mana kamu Bisa membahas suatu teori yang menarik.
                        </div>

                        {{-- Decorative Shapes --}}
                        <div class="mt-12 relative z-10">
                            <svg viewBox="0 0 200 120" class="w-full h-auto">
                                {{-- Orange diagonal lines --}}
                                <line x1="20" y1="100" x2="80" y2="40" stroke="#ff6b6b" stroke-width="8" stroke-linecap="round" opacity="0.8"/>
                                <line x1="40" y1="110" x2="100" y2="50" stroke="#ff8e53" stroke-width="8" stroke-linecap="round" opacity="0.8"/>
                                <line x1="60" y1="115" x2="120" y2="55" stroke="#ffa940" stroke-width="10" stroke-linecap="round" opacity="0.9"/>
                                
                                {{-- Orange circles --}}
                                <circle cx="140" cy="40" r="15" fill="#ffa940" opacity="0.8"/>
                                <circle cx="160" cy="70" r="20" fill="#ff8e53" opacity="0.9"/>
                                <circle cx="175" cy="95" r="12" fill="#ff6b6b" opacity="0.8"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Right Side - Login Form --}}
                    <div class="p-8 md:p-12 flex flex-col justify-center bg-white">
                        <div class="text-center mb-8">
                            <h2 class="text-xl font-bold text-gray-800 uppercase tracking-wide">User Login</h2>
                        </div>

                        {{-- Pesan sukses --}}
                        @if(session('success'))
                            <div class="mb-6 p-4 text-sm text-green-700 bg-green-50 rounded-lg border border-green-200">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Pesan error --}}
                        @if($errors->has('login'))
                            <div class="mb-6 p-4 text-sm text-red-700 bg-red-50 rounded-lg border border-red-200">
                                {{ $errors->first('login') }}
                            </div>
                        @endif

                        <form action="{{ route('login-proses') }}" method="POST" class="space-y-5">
                            @csrf

                            {{-- Username/Email --}}
                            <div>
                              <label class="text-sm text-gray-400 ">username/email</label>
                                <div class="relative">
                                    
                                    <input 
                                        type="text" 
                                        id="login" 
                                        name="login" 
                                        value="{{ old('login') }}" 
                                        required 
                                        placeholder="Username atau Email"
                                        class="w-full pl-12 pr-4 py-3.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                    />
                                </div>
                            </div>

                            {{-- Password --}}
                            <div>
                              <label class="text-sm text-gray-400 ">password</label>
                                <div class="relative flex items-center ">
                                   
                                    <input 
                                        type="password" 
                                        id="password" 
                                        name="password" 
                                        required 
                                        placeholder="Password"
                                        class="w-full pl-12 pr-12 py-3.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                    />
                                    <button 
                                        type="button"
                                        onclick="togglePassword()"
                                        class="absolute  right-4 top-3 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none"
                                        aria-label="Toggle password visibility"
                                    >
                                        <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <svg id="eye-off-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Remember & Forgot Password --}}
                            <div class="flex items-center justify-between text-sm">
                                <label class="flex items-center text-gray-600">
                                    <input 
                                        type="checkbox" 
                                        name="remember" 
                                        class="w-4 h-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500 mr-2"
                                    />
                                    Remember me
                                </label>
                                <a href="{{ route('password.request') }}" class="text-gray-400 hover:text-purple-600 transition-colors">
                                    Forgot password?
                                </a>
                            </div>

                            {{-- Login Button --}}
                            <button 
                                type="submit"
                                class="w-full py-3 px-4 font-semibold text-white rounded-full transition-all shadow-lg hover:shadow-xl uppercase tracking-wide"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"
                            >
                                Login
                            </button>
                        </form>

                        {{-- Register Link --}}
                        <p class="text-sm text-gray-600 text-center mt-6">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-purple-600 font-semibold hover:text-purple-700">
                                Create Account
                            </a>
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <script>
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const eyeIcon = document.getElementById('eye-icon');
                const eyeOffIcon = document.getElementById('eye-off-icon');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.add('hidden');
                    eyeOffIcon.classList.remove('hidden');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('hidden');
                    eyeOffIcon.classList.add('hidden');
                }
            }
        </script>
    </body>
</x-tamplat>