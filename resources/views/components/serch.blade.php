<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-2 ">
 
    <form action="/posts" method="GET" class="w-full">
      @if(request('category'))
        <input type="hidden" name="category" value="{{ request('category') }}">
      @endif
      @if(request('author'))
        <input type="hidden" name="author" value="{{ request('author') }}">
      @endif

      {{-- FIX: Menggunakan flex untuk mengatur elemen selalu horizontal --}}
      <div class="flex items-center gap-2"> 
          
          {{-- Input mengambil sisa lebar (flex-1) --}}
          <input type="search" id="search" name="search" value="{{ request('search') }}"
                 class="flex-1 block w-full p-2 sm:p-3 text-sm sm:text-base text-gray-900 border border-gray-300 rounded-lg 
                        bg-white focus:ring-blue-500 focus:border-blue-500 
                        dark:border-gray-600 dark:placeholder-gray-400 
                        dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                 placeholder="Cari judul/username" />
          
          {{-- Button: Hapus w-full agar ukurannya mengikuti konten (Cari) --}}
          <button type="submit" 
                  class="px-4 py-2 text-sm sm:text-base font-medium text-white bg-blue-600 hover:bg-blue-700 
                         rounded-lg focus:ring-4 focus:outline-none focus:ring-blue-300 
                         dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
              Cari
          </button>
      </div>
    </form>
 
</div>