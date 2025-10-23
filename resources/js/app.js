import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.data('saveHandler', (postId, initialCount, initialSaved) => ({
    count: initialCount,
    saved: initialSaved,

    async toggleSave() {
        try {
            let response = await fetch(`/posts/${postId}/favorite/toggle`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            });

            let data = await response.json();

            if (data.success) {
                this.count = data.count;
                this.saved = data.favorited; // true = sudah simpan, false = belum
            }
        } catch (e) {
            console.error("Gagal toggle simpan:", e);
        }
    }
}))


Alpine.start()
