<x-html>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="max-w-2xl mx-auto py-6 sm:px-6 lg:px-8 -mt-18">
        {{-- Card Edit Profil --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Edit Profil</h1>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Nama Lengkap --}}
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                  focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 
                                  dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           placeholder="Nama lengkap">
                </div>

                
                {{-- Bio --}}
                <div>
                    <label for="bio" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Bio</label>
                    <textarea id="bio" name="bio" rows="3"
                              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                                     focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 
                                     dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                              placeholder="Tuliskan sesuatu tentang kamu...">{{ old('bio', $user->bio) }}</textarea>
                </div>

                {{-- Avatar --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Foto Profil</label>
                    
                    @if ($user->avatar)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $user->avatar) }}" 
                                 alt="Foto Profil" class="w-20 h-20 rounded-full object-cover ring-2 ring-blue-500">
                        </div>
                    @endif
                    
                    <input type="file" name="avatar"
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer 
                                  bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 
                                  dark:placeholder-gray-400">
                </div>

                {{-- Tombol Simpan --}}
                <div class="flex justify-end">
                    <button type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg shadow 
                                   hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 
                                   dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                        Simpan
                    </button>
                </div>
            </form>

            
        </div>
        {{-- ... (Akhir dari kartu Edit Profil) ... --}}
</div>
<div class="max-w-2xl mx-auto py-6 sm:px-6 lg:px-8 -mt-18">
    {{-- Card Ubah Password (REVISI 4) --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Ubah Password</h1>

        {{-- Form Ubah Password --}}
        {{-- Kita asumsikan Anda memiliki route PUT /password yang menangani perubahan password pengguna yang sedang login --}}
       <form method="POST" action="{{ route('password.update') }}" class="space-y-5"> 
                @csrf
                @method('PUT')

            {{-- Password Saat Ini --}}
            <div>
                <label for="current_password" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                              focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 
                              dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="Masukkan password saat ini" required>
                @error('current_password', 'updatePassword')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Baru --}}
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Password Baru</label>
                <input type="password" id="password" name="password"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                              focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 
                              dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="Masukkan password baru" required>
                @error('password', 'updatePassword')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password Baru --}}
            <div>
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                              focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 
                              dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="Konfirmasi password baru" required>
            </div>

            {{-- Tombol Simpan --}}
            <div class="flex justify-end">
                <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg shadow 
                               hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 
                               dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800">
                    Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>
    </div>
</x-html>
