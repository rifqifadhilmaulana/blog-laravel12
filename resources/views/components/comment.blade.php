<div class="mb-4" id="comment-{{ $comment->id }}">
    <div class="flex gap-3 items-start">
        {{-- Avatar --}}
        @if($comment->user->avatar)
            <img src="{{ asset('storage/' . $comment->user->avatar) }}" class="w-8 h-8 rounded-full object-cover">
        @else
            <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                {{ strtoupper(substr($comment->user->username, 0, 1)) }}
            </div>
        @endif

        <div class="flex-1">
            {{-- Nama dan username --}}
            <div class="flex items-center gap-2">
               
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                     <a href="{{ route('profile.show', $comment->user->username) }}" class="text-xs text-gray-500">
                       <span>@</span>{{ $comment->user->name }}
                </a>
                
            </div>

            {{-- Isi komentar --}}
            <p class="text-gray-800 dark:text-gray-300">
                @if($comment->parent && $comment->parent->user)
                    <a href="#comment-{{ $comment->parent->id }}" class="text-blue-500">
                       <span>@</span> {{ $comment->parent->user->name }}
                    </a>
                @endif
                {{ $comment->body }}
            </p>

            {{-- Tombol aksi --}}
            <div class="flex items-center gap-3 text-sm mt-1">
                {{-- Balas --}}
                <button class="text-blue-500 hover:underline reply-btn"
                        data-comment-id="{{ $comment->id }}"
                        data-username="{{ $comment->user->username }}">
                    Balas
                </button>

                {{-- Hapus komentar + balasan --}}
                @if(auth()->check() && $comment->user_id === auth()->id())
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                          onsubmit="return confirm('Hapus komentar ini beserta balasannya?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                    </form>
                @endif

                <span class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
            </div>

            {{-- Form balasan --}}
            <form action="{{ route('comments.store', $comment->post) }}" method="POST"
                  class="hidden reply-form mt-2 border-l-2 border-blue-200 pl-3"
                  id="reply-form-{{ $comment->id }}">
                @csrf
                <input type="hidden" name="post_id" value="{{ $comment->post->id }}">
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <textarea name="body" rows="2" class="w-full border rounded-lg p-2 text-sm"
                          placeholder="Balas komentar {{ $comment->user->username }}..."></textarea>
                <button type="submit" class="mt-1 px-3 py-1 bg-blue-600 text-white rounded text-sm">
                    Kirim
                </button>
            </form>

           {{-- Balasan 1 tingkat --}}
@if($comment->replies->count())
    <div x-data="{ open: false }" class="mt-3">
        <button @click="open = !open" class="text-gray-500 text-sm hover:underline">
            <span x-text="open ? 'Sembunyikan balasan' : 'Lihat {{ $comment->replies->count() }} balasan'"></span>
        </button>

        <div x-show="open" class="mt-3 space-y-3 border-l-2 border-gray-200 pl-5">
            @foreach($comment->replies as $reply)
                <div class="bg-gray-50 p-2 rounded flex gap-3 items-start">
                    @if ($reply->user->avatar)
                        <img src="{{ asset('storage/' . $reply->user->avatar) }}" class="w-6 h-6 rounded-full object-cover">
                    @else
                        <div class="w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr($reply->user->username, 0, 1)) }}
                        </div>
                    @endif
                    
                    <div class="flex-1">
                        <p class="text-gray-800 dark:text-gray-300">
                            <a href="#comment-{{ $reply->parent->id }}" class="text-blue-500">
                              <span>@</span>{{ $reply->parent->user->name }}
                            </a>
                            {{ $reply->body }}
                        </p>
                        <div class="flex items-center gap-2 text-xs text-gray-500 mt-1">
                          
                            {{-- Tombol hapus reply --}}
                            @if(auth()->check() && $reply->user_id === auth()->id())
                                <form action="{{ route('comments.destroy', $reply->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus balasan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                </form>
                            @endif  
                            <span>{{ $reply->created_at->diffForHumans() }}</span>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

        </div>
    </div>
</div>
