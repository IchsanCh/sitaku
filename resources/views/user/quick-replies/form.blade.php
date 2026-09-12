@extends('user.layout2')

@section('title', $quickReply->exists ? 'Edit Balasan Cepat' : 'Tambah Balasan Cepat')
@section('meta_description', 'Atur balasan cepat (quick reply) buat admin support di live chat WhatsApp.')
@section('og_description', 'Kelola template balasan cepat SITAKU sesuai kebutuhan instansi Anda.')

@section('content')
<style>
    #whatsapp-preview code {
        background: rgba(0, 0, 0, 0.08);
        padding: 0 4px;
        border-radius: 4px;
        font-family: ui-monospace, monospace;
    }
</style>
<div class="min-h-screen bg-base-100 py-8">
    <div class="max-w-5xl mx-auto px-6">

        <a href="{{ route('quick-reply.index') }}" class="btn btn-ghost btn-sm mb-4">← Kembali</a>

        <div class="grid lg:grid-cols-2 gap-6 items-start">
            <!-- Form -->
            <div class="card bg-base-100 shadow-2xl border border-base-300">
                <div class="card-body p-8">
                    <h1 class="text-2xl font-bold mb-1">
                        {{ $quickReply->exists ? 'Edit Balasan Cepat' : 'Tambah Balasan Cepat' }}
                    </h1>
                    <p class="text-base-content/60 mb-6">
                        Admin support manggil ini di kotak chat live support dengan ngetik "/" diikuti trigger-nya.
                    </p>

                    @if ($errors->any())
                        <div class="alert alert-error mb-6">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST"
                        action="{{ $quickReply->exists ? route('quick-reply.update', $quickReply) : route('quick-reply.store') }}"
                        class="space-y-5" id="quickReplyForm">
                        @csrf
                        @if ($quickReply->exists)
                            @method('PUT')
                        @endif

                        <div>
                            <label class="label"><span class="label-text font-medium">Trigger</span></label>
                            <label class="input input-bordered flex items-center gap-1 w-full">
                                <span class="text-base-content/40">/</span>
                                <input type="text" name="trigger" value="{{ old('trigger', $quickReply->trigger) }}"
                                    class="grow" placeholder="alur-pelayanan" required maxlength="50"
                                    pattern="[a-z0-9_-]+" title="Huruf kecil, angka, - dan _ saja">
                            </label>
                            <p class="text-xs text-base-content/50 mt-1">Huruf kecil, angka, "-", "_" doang (tanpa spasi). Harus unik di instansi ini.</p>
                        </div>

                        <div>
                            <div class="flex justify-between items-baseline">
                                <label class="label"><span class="label-text font-medium">Isi Balasan</span></label>
                                <span class="text-xs text-base-content/50"><span id="charCount">0</span>/2000</span>
                            </div>

                            <!-- Legenda syntax -- gak ada toggle/tombol, user ngetik syntax-nya
                                 langsung apa adanya (persis kayak WA aslinya), biar gak ada lagi
                                 lapisan "penerjemah" yang bisa salah nerjemahin. -->
                            <div class="flex flex-wrap gap-x-4 gap-y-1 mb-1 text-xs text-base-content/60 bg-base-200/50 border border-base-300 rounded-lg p-2">
                                <span><code class="bg-base-300 px-1 rounded">*teks*</code> → <strong>tebal</strong></span>
                                <span><code class="bg-base-300 px-1 rounded">_teks_</code> → <em>miring</em></span>
                                <span><code class="bg-base-300 px-1 rounded">~teks~</code> → <s>coret</s></span>
                                <span><code class="bg-base-300 px-1 rounded">```teks```</code> → <code class="bg-base-300 px-1 rounded">monospace</code></span>
                            </div>

                            <textarea name="content" id="content_input" required maxlength="2000"
                                class="textarea textarea-bordered w-full min-h-32 font-mono text-sm"
                                placeholder="Tulis teks lengkap yang bakal ngisi kotak chat begitu trigger ini dipilih...">{{ old('content', $quickReply->content) }}</textarea>

                            <p class="text-xs text-base-content/50 mt-1">
                                Ketik syntax-nya langsung (contoh: <code>*penting*</code>). Enter = baris baru persis kayak yang diketik, gak ada yang dirapiin/diubah otomatis.
                            </p>
                        </div>

                        <div class="flex justify-end gap-2 pt-2">
                            <a href="{{ route('quick-reply.index') }}" class="btn btn-ghost">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                {{ $quickReply->exists ? 'Simpan Perubahan' : 'Tambah Balasan Cepat' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- WhatsApp Preview Section -->
            <div class="card bg-base-100 shadow-2xl border border-base-300">
                <div class="card-body p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-success/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-success" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold">Preview WhatsApp</h2>
                    </div>

                    <div class="bg-gradient-to-b from-green-400 to-green-600 rounded-3xl p-1 shadow-2xl">
                        <div class="bg-green-50 rounded-3xl overflow-hidden">
                            <div class="bg-green-500 text-white px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">Admin Support</h3>
                                        <p class="text-xs font-semibold">online</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-green-50 min-h-80 p-4 space-y-4"
                                style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><circle cx=%2250%22 cy=%2250%22 r=%221%22 fill=%22%23ffffff%22 opacity=%220.1%22/></svg>'); background-size: 20px;">
                                <div class="flex justify-end">
                                    <div class="max-w-[85%]">
                                        <div class="bg-green-200 rounded-2xl rounded-tr-md p-4 shadow-md">
                                            <div id="whatsapp-preview" class="text-sm text-gray-800 leading-relaxed whitespace-pre-wrap">
                                                <em class="text-gray-500">Isi teksnya buat lihat pratinjau...</em>
                                            </div>
                                            <div class="flex justify-end mt-2">
                                                <span class="text-xs text-black" id="preview-time">12:34</span>
                                            </div>
                                        </div>
                                        <div class="text-xs text-center mt-1 text-gray-500">Admin Support</div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-200 p-3 flex items-center gap-3">
                                <div class="flex-1 bg-white rounded-full px-4 py-2">
                                    <span class="text-gray-800 text-sm">Ketik pesan...</span>
                                </div>
                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="toast toast-top toast-end z-50" id="toastContainer"></div>

<script>
    function showToast(type, message) {
        const toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) return;

        const alertClass = type === 'error' ? 'alert-error' : 'alert-success';
        const icon = type === 'error' ?
            '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' :
            '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';

        const toast = document.createElement('div');
        toast.className = `alert ${alertClass} shadow-lg mb-4`;
        toast.innerHTML = `
            <div class="flex items-center gap-3">
                ${icon}
                <span>${message}</span>
                <button class="btn btn-ghost btn-xs" onclick="this.parentElement.parentElement.remove()">✕</button>
            </div>
        `;

        toastContainer.appendChild(toast);

        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 4000);
    }

    const contentInput = document.getElementById('content_input');
    const charCount = document.getElementById('charCount');
    const preview = document.getElementById('whatsapp-preview');

    function escapeHtml(str) {
        return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    // Cuma buat PREVIEW doang -- render syntax WA (*tebal*, _miring_, ~coret~,
    // ```mono```) jadi HTML biar keliatan hasilnya kayak gimana. Teks aslinya
    // di textarea gak disentuh/diubah sama sekali (WYSIWYG beneran: apa yang
    // diketik itu juga persis yang kesimpen & yang dikirim ke WA).
    function waTextToHtml(text) {
        if (!text) return '';
        let html = escapeHtml(text);
        html = html.replace(/```([^`]+?)```/g, function (m, p1) { return '<code>' + p1 + '</code>'; });
        html = html.replace(/\*_(.+?)_\*/g, '<strong><em>$1</em></strong>');
        html = html.replace(/_\*(.+?)\*_/g, '<em><strong>$1</strong></em>');
        html = html.replace(/\*(.+?)\*/g, '<strong>$1</strong>');
        html = html.replace(/_(.+?)_/g, '<em>$1</em>');
        html = html.replace(/~(.+?)~/g, '<s>$1</s>');
        html = html.replace(/\n/g, '<br>');
        return html;
    }

    function updatePreview() {
        const text = contentInput.value;
        charCount.textContent = text.length;
        charCount.parentElement.classList.toggle('text-error', text.length > 2000);

        if (text.trim() === '') {
            preview.innerHTML = '<em class="text-gray-500">Isi teksnya buat lihat pratinjau...</em>';
        } else {
            preview.innerHTML = waTextToHtml(text);
        }
    }

    contentInput.addEventListener('input', updatePreview);

    document.addEventListener('DOMContentLoaded', function () {
        const now = new Date();
        document.getElementById('preview-time').textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

        updatePreview();

        @if (session('error'))
            showToast('error', "{{ session('error') }}");
        @endif
        @if (session('success'))
            showToast('success', "{{ session('success') }}");
        @endif
    });
</script>
@endsection