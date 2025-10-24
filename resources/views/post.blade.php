<x-html>
<x-slot:title>{{ $post->title }}</x-slot:title>
<main class="pt-6 pb-12 sm:pt-10 sm:pb-16 lg:pt-16 lg:pb-24 bg-white dark:bg-gray-900 antialiased -mt-14">
  <div class="px-4 sm:px-6 lg:px-8 mx-auto max-w-screen-xl">
    <article class="mx-auto w-full max-w-3xl lg:max-w-4xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
      
      <!-- Tombol kembali -->
      <a href="{{ route('posts.index') }}"
         class="block mb-6 font-medium text-sm text-blue-600 dark:text-blue-500 hover:underline">
         &laquo; Kembali ke Halaman
      </a>

      <!-- Header -->
     <header class="mb-6 not-format">
  <div class="flex items-start md:justify-between lg:justify-between xl:justify-between max-lg:flex-row xl:flex-row  ">
    <!-- Info penulis -->
   <address class="flex items-center not-italic gap-3 sm:gap-4 flex-wrap">
  <!-- Foto Profil -->
  @if($post->author->avatar)
    <img class="w-12 h-12 sm:w-14 sm:h-14 rounded-full object-cover shadow"
         src="{{ asset('storage/' . $post->author->avatar) }}"
         alt="{{ $post->author->username }}">
  @else
    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-lg shadow">
      {{ strtoupper(substr($post->author->username, 0, 1)) }}
    </div>
  @endif

  <!-- Info Penulis -->
  <div class="flex flex-col justify-center">
    <a href="{{ route('posts.index', ['author' => $post->author->username]) }}"
       rel="author"
       class="text-base sm:text-lg lg:text-xl font-bold text-gray-900 dark:text-white hover:underline">
       {{ $post->author->name }}
    </a>

    <!-- Waktu + Kategori -->
    <div class="flex items-center flex-wrap gap-2 mt-1 sm:mt-2">
      <p class="text-sm text-gray-500 dark:text-gray-400">
        {{ $post->created_at->diffForHumans() }}
      </p>
      <a href="/posts?category={{ $post->category->slug }}"
                       class="text-white px-2.5 py-0.5 rounded-full font-semibold text-[10px] sm:text-xs 
                              {{ $post->category->color ?? 'bg-blue-500' }}">
                        {{ $post->category->name ?? 'Uncategorized' }}
                    </a>
    </div>
  </div>
</address>


    <!-- Tombol Simpan di kanan atas -->
    <div class="text-right  lg:mt-0  xl:mt-0 md:mt-0">
      @auth
        <form action="{{ route('posts.favorite', $post->id) }}" method="POST" class="inline">
          @csrf
          <button type="submit"
              class="px-3 py-1.5 rounded text-sm font-medium transition-colors
              {{ auth()->user()->hasFavorited($post) ? 'bg-gray-500 text-white hover:bg-gray-600' : 'bg-blue-600 text-white hover:bg-blue-700' }}">
              {{ auth()->user()->hasFavorited($post) ? 'Batalkan' : 'Simpan' }}
          </button>
        </form>
        <div class="text-xs xl:text-sm lg:text-sm md:text-sm text-gray-500  ">
          {{ $post->favorites()->count() }} menyimpan
        </div>
      @else
        <p class="text-sm text-gray-500">
          <a href="{{ route('login') }}" class="underline">Login</a> untuk menyimpan artikel
        </p>
      @endauth
    </div>
  </div>

  <!-- Judul -->
  <h1 class="mb-4 mt-3 text-2xl sm:text-3xl lg:text-4xl font-extrabold leading-snug text-gray-900 dark:text-white">
    {{ $post->title }}
  </h1>

  <!-- Share Button -->
  <div class="mb-6 flex flex-wrap items-center gap-2">
    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Bagikan:</span>

    @php
        $url = url()->current();
        $text = urlencode($post->title . " - Baca artikel ini: " . $url);
        $title_encoded = urlencode($post->title);
    @endphp

    <!-- Twitter -->
    <a href="https://twitter.com/intent/tweet?text={{ $text }}" 
       target="_blank" rel="noopener noreferrer"
       class="text-gray-500 hover:text-sky-500 transition-colors"
       title="Bagikan di Twitter">
       <svg class="w-[30px] h-[30px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"> 
         <path fill-rule="evenodd" d="M22 5.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.343 8.343 0 0 1-2.605.981A4.13 4.13 0 0 0 15.85 4a4.068 4.068 0 0 0-4.1 4.038c0 .31.035.618.105.919A11.705 11.705 0 0 1 3.4 4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 6.1 13.635a4.192 4.192 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 2 18.184 11.732 11.732 0 0 0 8.291 20 11.502 11.502 0 0 0 19.964 8.5c0-.177 0-.349-.012-.523A8.143 8.143 0 0 0 22 5.892Z" clip-rule="evenodd"/> 
       </svg>
    </a>

    <!-- Facebook -->
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}" 
       target="_blank" rel="noopener noreferrer"
       class="text-gray-500 hover:text-blue-600 transition-colors"
       title="Bagikan di Facebook">
       <svg class="w-[30px] h-[30px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"> 
         <path fill-rule="evenodd" d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z" clip-rule="evenodd"/> 
       </svg>
    </a>

    <!-- WhatsApp -->
    <a href="https://api.whatsapp.com/send?text={{ $text }}" 
       target="_blank" rel="noopener noreferrer"
       class="text-gray-500 hover:text-green-600 transition-colors"
       title="Bagikan via WhatsApp">
      <svg class="w-[30px] h-[30px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"> 
        <path fill-rule="evenodd" d="M12 4a8 8 0 0 0-6.895 12.06l.569.718-.697 2.359 2.32-.648.379.243A8 8 0 1 0 12 4ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10a9.96 9.96 0 0 1-5.016-1.347l-4.948 1.382 1.426-4.829-.006-.007-.033-.055A9.958 9.958 0 0 1 2 12Z" clip-rule="evenodd"/> 
        <path d="M16.735 13.492c-.038-.018-1.497-.736-1.756-.83a1.008 1.008 0 0 0-.34-.075c-.196 0-.362.098-.49.291-.146.217-.587.732-.723.886-.018.02-.042.045-.057.045-.013 0-.239-.093-.307-.123-1.564-.68-2.751-2.313-2.914-2.589-.023-.04-.024-.057-.024-.057.005-.021.058-.074.085-.101.08-.079.166-.182.249-.283l.117-.14c.121-.14.175-.25.237-.375l.033-.066a.68.68 0 0 0-.02-.64c-.034-.069-.65-1.555-.715-1.711-.158-.377-.366-.552-.655-.552-.027 0 0 0-.112.005-.137.005-.883.104-1.213.311-.35.22-.94.924-.94 2.16 0 1.112.705 2.162 1.008 2.561l.041.06c1.161 1.695 2.608 2.951 4.074 3.537 1.412.564 2.081.63 2.461.63.16 0 .288-.013.4-.024l.072-.007c.488-.043 1.56-.599 1.804-1.276.192-.534.243-1.117.115-1.329-.088-.144-.239-.216-.43-.308Z"/> 
      </svg>
    </a>

    <!-- Copy Link -->
    <button type="button"
       onclick="navigator.clipboard.writeText('{{ $url }}').then(() => { alert('Link berhasil disalin!'); })"
       class="text-gray-500 hover:text-purple-600 transition-colors"
       title="Salin Link">
       <svg class="w-[30px] h-[30px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"> 
         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13.213 9.787a3.391 3.391 0 0 0-4.795 0l-3.425 3.426a3.39 3.39 0 0 0 4.795 4.794l.321-.304m-.321-4.49a3.39 3.39 0 0 0 4.795 0l3.424-3.426a3.39 3.39 0 0 0-4.794-4.795l-1.028.961"/> 
       </svg>
    </button>
  </div>
</header>


      <!-- Gambar -->
      @if($post->image)
        <img src="{{ asset('storage/' . $post->image) }}"
             alt="{{ $post->title }}"
             class="mx-auto w-full max-h-[500px] rounded-lg mb-6 shadow object-cover sm:object-contain">
      @endif

      <!-- Isi Artikel -->
      <div class="prose prose-sm sm:prose-base lg:prose-lg dark:prose-invert max-w-none dark:text-white">
       {!! $post->body !!}
      </div>

      <p class="mt-6 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
        {{ $post->created_at->format('d F Y') }}
      </p>
    </article>

    <hr class="my-6 mt-8 border-gray-300 dark:border-gray-700">

{{--  Bagian Komentar --}}
<section  class="mt-10">
  <h2 class="text-lg sm:text-xl font-semibold mb-4 text-gray-900 dark:text-white">
    Komentar ({{ $post->comments->count() }})
  </h2>

  {{-- Form tambah komentar utama --}}
  @auth
    <form action="{{ route('comments.store') }}" method="POST" class="mb-6">
      @csrf
      <input type="hidden" name="post_id" value="{{ $post->id }}">
      <textarea name="body" rows="3" placeholder="Tulis komentar..."
        class="w-full border rounded-lg p-3 dark:bg-gray-800 dark:text-white"></textarea>
      <button type="submit"
        class="mt-2 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
        Kirim
      </button>
    </form>
  @else
    <p class="text-sm text-gray-500 dark:text-gray-400">
      <a href="{{ route('login') }}" class="underline">Login</a> untuk menulis komentar.
    </p>
    {{-- komentar --}}
    
  @endauth
        

          @auth
          @foreach ($post->comments as $comment)
              @include('components.comment', ['comment' => $comment])
          @endforeach
      @else
          <p class="text-gray-500">Silakan login untuk melihat komentar.</p>
      @endauth
              </div>
          
      </div>
  </div>
</div>






{{-- Form komentar --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.body.addEventListener("click", (e) => {
        const btn = e.target.closest(".reply-btn");
        if (!btn) return;

        const id = btn.dataset.commentId;
        const username = btn.dataset.username;
        const form = document.getElementById(`reply-form-${id}`);
        if (!form) return;

        // Tutup semua form lain
        document.querySelectorAll(".reply-form").forEach(f => {
            if (f !== form) f.classList.add("hidden");
        });

        // Toggle form aktif
        form.classList.toggle("hidden");

        const textarea = form.querySelector("textarea");
        textarea.value = ``;
        textarea.focus();
    });
});
</script>


</x-html>