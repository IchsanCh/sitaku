@extends('user.layout2')

@section('title', 'Pesan Custom Pemohon')
@section('meta_description',
    'Atur dan sesuaikan pesan notifikasi untuk pemohon. Gunakan variabel dinamis agar isi pesan
    lebih personal dan relevan.')
@section('og_description',
    'Kelola pesan custom untuk pemohon SITAKU. Tambahkan variabel dinamis, pratinjau hasilnya,
    dan simpan template sesuai kebutuhan.')

@section('content')
    <div class="min-h-screen bg-base-100 py-8">
        <div class="bg-base-100 borderbc1">
            <div class="max-w-4xl mx-auto px-6 py-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-primary/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-base-content">Pesan Custom Pemohon</h1>
                        <p class="text-base-content/70">Configure Custom Message for Applicant</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mx-auto px-6 mt-6">
            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Form Section -->
                <div class="card bg-base-100 shadow-2xl border border-base-300">
                    <div class="card-body p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold">Editor Pesan</h2>
                        </div>

                        <!-- Variable Tags -->
                        <div class="bg-gradient-to-r from-info/10 to-success/10 border border-info/20 rounded-2xl p-4 mb-6">
                            <h3 class="font-semibold text-sm mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                </svg>
                                Variabel Dinamis Tersedia
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    class="badge badge-primary badge-lg cursor-pointer hover:scale-105 transition-transform"
                                    onclick="insertVariable('{nama}')">{nama}</span>
                                <span
                                    class="badge badge-primary badge-lg cursor-pointer hover:scale-105 transition-transform"
                                    onclick="insertVariable('{no_permohonan}')">{no_permohonan}</span>
                                <span
                                    class="badge badge-primary badge-lg cursor-pointer hover:scale-105 transition-transform"
                                    onclick="insertVariable('{tahapan}')">{tahapan}</span>
                                <span
                                    class="badge badge-primary badge-lg cursor-pointer hover:scale-105 transition-transform"
                                    onclick="insertVariable('{nama_izin}')">{nama_izin}</span>
                                <span
                                    class="badge badge-primary badge-lg cursor-pointer hover:scale-105 transition-transform"
                                    onclick="insertVariable('{username}')">{username}</span>
                            </div>
                            <p class="text-md mt-2 font-semibold">Klik variabel untuk menambahkan ke pesan</p>
                        </div>

                        <form method="POST" action="{{ route('custom.pesan.pemohon') }}" class="space-y-6"
                            id="messageForm">
                            @csrf
                            <div class="form-control">
                                <label class="flex flex-wrap items-center gap-2">
                                    <span class="font-semibold text-base">Isi Pesan Template</span>
                                    <span class="text-md font-bold">Gunakan \n untuk baris baru</span>
                                </label>
                                <textarea name="isi_pesan" id="isi_pesan" rows="8" maxlength="500"
                                    class="textarea textarea-bordered textarea-lg w-full resize-y focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-200"
                                    placeholder="Halo {nama},\n\nPermohonan Anda dengan nomor {no_permohonan} saat ini berada di tahap {tahapan}.\n\nTerima kasih atas kesabaran Anda.">{{ $user->pesan_pemohon }}</textarea>
                                <label class="label">
                                    <span class="label-text-alt text-md" id="charCountLabel">
                                        <span id="charCount">0</span>/500 karakter
                                        <span id="limitWarning" class="text-error hidden">• Mencapai batas
                                            maksimal!</span>
                                    </span>
                                </label>
                                <!-- Error message for character limit -->
                                <div id="charLimitError" class="text-error text-sm mt-1 hidden">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Pesan tidak boleh lebih dari 500 karakter
                                </div>
                            </div>

                            <div class="flex flex-col flex-wrap sm:flex-row justify-end gap-3 pt-4">
                                <button type="submit" name="reset" class="btn btn-outline">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                    </svg>
                                    Reset Template
                                </button>
                                <button type="submit" id="submitBtn" class="btn btn-primary">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    Simpan Template
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
                                <svg class="w-5 h-5 text-success" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold">Preview WhatsApp</h2>
                        </div>

                        <!-- WhatsApp Mockup -->
                        <div class="bg-gradient-to-b from-green-400 to-green-600 rounded-3xl p-1 shadow-2xl">
                            <div class="bg-green-50 rounded-3xl overflow-hidden">
                                <!-- WhatsApp Header -->
                                <div class="bg-green-500 text-white px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold">SITAKU Official</h3>
                                            <p class="text-xs font-semibold">online</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-green-50 min-h-80 p-4 space-y-4"
                                    style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><circle cx=%2250%22 cy=%2250%22 r=%221%22 fill=%22%23ffffff%22 opacity=%220.1%22/></svg>'); background-size: 20px;">
                                    <div class="flex justify-start">
                                        <div class="w-full">
                                            <div
                                                class="bg-white rounded-2xl rounded-tl-md p-4 shadow-md border border-gray-100">
                                                <div id="whatsapp-preview" class="text-sm text-gray-800 leading-relaxed">
                                                    <em class="text-gray-500">Pratinjau pesan akan muncul di sini...</em>
                                                </div>
                                                <div class="flex justify-end mt-2">
                                                    <span class="text-xs text-black" id="preview-time">12:34</span>
                                                </div>
                                            </div>
                                            <div class="text-xs text-center mt-1 text-gray-500">SITAKU Official</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-200 p-3 flex items-center gap-3">
                                    <div class="flex-1 bg-white rounded-full px-4 py-2 flex flex-row items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                                        </svg>
                                        <span class="text-gray-800 text-sm">Ketik pesan...</span>
                                    </div>
                                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Info -->
                        <div class="mt-4 p-4 bg-info/10 border border-info/20 rounded-xl">
                            <h4 class="font-semibold text-sm flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                </svg>
                                Data Contoh
                            </h4>
                            <div class="text-md space-y-1">
                                <div>Nama: <strong>Sitaku</strong></div>
                                <div>Nomor Permohonan: <strong>REG-2024-001</strong></div>
                                <div>Tahapan: <strong>Verifikasi Dokumen</strong></div>
                                <div>Nama Izin: <strong>Izin Reklame</strong></div>
                                <div>Username: <strong>Instansi Anda</strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="toast toast-top toast-end z-50" id="toastContainer"></div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const textarea = document.getElementById("isi_pesan");
            const preview = document.getElementById("whatsapp-preview");
            const charCount = document.getElementById("charCount");
            const charCountLabel = document.getElementById("charCountLabel");
            const limitWarning = document.getElementById("limitWarning");
            const charLimitError = document.getElementById("charLimitError");
            const submitBtn = document.getElementById("submitBtn");
            const messageForm = document.getElementById("messageForm");
            const previewTime = document.getElementById("preview-time");

            const now = new Date();
            previewTime.textContent = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });

            @if (session('error'))
                showToast('error', "{{ session('error') }}");
            @endif

            @if (session('success'))
                showToast('success', "{{ session('success') }}");
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    showToast('error', "{{ $error }}");
                @endforeach
            @endif

            function validateCharacterLimit() {
                const length = textarea.value.length;
                const isOverLimit = length > 500;

                if (length >= 450) {
                    charCountLabel.classList.remove('text-base-content');
                    charCountLabel.classList.add('text-warning');
                } else if (isOverLimit) {
                    charCountLabel.classList.remove('text-warning');
                    charCountLabel.classList.add('text-error');
                } else {
                    charCountLabel.classList.remove('text-warning', 'text-error');
                    charCountLabel.classList.add('text-base-content');
                }

                if (length >= 490 && length <= 500) {
                    limitWarning.classList.remove('hidden');
                } else {
                    limitWarning.classList.add('hidden');
                }

                if (isOverLimit) {
                    charLimitError.classList.remove('hidden');
                    textarea.classList.add('textarea-error');
                    submitBtn.disabled = true;
                    submitBtn.classList.add('btn-disabled');
                } else {
                    charLimitError.classList.add('hidden');
                    textarea.classList.remove('textarea-error');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('btn-disabled');
                }

                return !isOverLimit;
            }

            function updatePreview() {
                let text = textarea.value.trim();
                const length = textarea.value.length;

                charCount.textContent = length;

                validateCharacterLimit();

                if (!text) {
                    preview.innerHTML = '<em class="text-gray-500">Pratinjau pesan akan muncul di sini...</em>';
                    return;
                }

                text = text.replace(/{nama}/g, "Sitaku");
                text = text.replace(/{no_permohonan}/g, "REG-2024-001");
                text = text.replace(/{tahapan}/g, "Verifikasi Dokumen");
                text = text.replace(/{nama_izin}/g, "Izin Reklame");
                text = text.replace(/{username}/g, "Instansi Anda");

                text = text.replace(/\\n/g, '<br>');
                text = text.replace(/\*_(.*?)_\*/g, '<strong><em>$1</em></strong>');
                text = text.replace(/\*(.*?)\*/g, '<strong>$1</strong>');
                text = text.replace(/_(.*?)_/g, '<em>$1</em>');
                text = text.replace(/```(.*?)```/gs, '<code>$1</code>');
                preview.innerHTML = text;
            }

            function handleInput(e) {
                setTimeout(() => {
                    if (textarea.value.length > 500) {
                        textarea.value = textarea.value.substring(0, 500);
                        showToast('error', 'Pesan tidak boleh lebih dari 500 karakter');
                    }
                    updatePreview();
                }, 0);
            }

            function handlePaste(e) {
                setTimeout(() => {
                    if (textarea.value.length > 500) {
                        textarea.value = textarea.value.substring(0, 500);
                        showToast('error',
                            'Teks yang dipaste terlalu panjang. Dipotong menjadi 500 karakter.');
                    }
                    updatePreview();
                }, 0);
            }

            function handleSubmit(e) {
                if (textarea.value.length > 500) {
                    e.preventDefault();
                    showToast('error', 'Pesan tidak boleh lebih dari 500 karakter');
                    textarea.focus();
                    return false;
                }
                return true;
            }
            updatePreview();
            textarea.addEventListener("input", handleInput);
            textarea.addEventListener("paste", handlePaste);
            messageForm.addEventListener("submit", handleSubmit);
            textarea.addEventListener("keypress", (e) => {
                if (textarea.value.length >= 500 && e.key !== 'Backspace' && e.key !== 'Delete') {
                    e.preventDefault();
                    showToast('warning', 'Batas maksimal 500 karakter tercapai');
                }
            });
        });

        function insertVariable(variable) {
            const textarea = document.getElementById("isi_pesan");
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const text = textarea.value;
            const newText = text.substring(0, start) + variable + text.substring(end);

            if (newText.length > 500) {
                showToast('error',
                    `Tidak dapat menambahkan variabel. Akan melebihi batas 500 karakter (${newText.length} karakter)`);
                return;
            }

            textarea.value = newText;

            textarea.setSelectionRange(start + variable.length, start + variable.length);
            textarea.focus();

            textarea.dispatchEvent(new Event('input'));
        }

        function showToast(type, message) {
            const toastContainer = document.getElementById('toastContainer');
            if (!toastContainer) return;

            let alertClass = 'alert-info';
            let icon =
                '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';

            if (type === 'error') {
                alertClass = 'alert-error';
                icon =
                    '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
            } else if (type === 'success') {
                alertClass = 'alert-success';
                icon =
                    '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
            } else if (type === 'warning') {
                alertClass = 'alert-warning';
                icon =
                    '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>';
            }

            const toast = document.createElement('div');
            toast.className = `alert ${alertClass} shadow-lg mb-4`;
            toast.innerHTML = `
                <div class="flex items-center gap-3">
                    ${icon}
                    <span>${message}</span>
                    <button class="btn btn-ghost btn-xs hover:bg-white/20" onclick="this.parentElement.parentElement.remove()">✕</button>
                </div>
            `;

            toastContainer.appendChild(toast);

            setTimeout(() => {
                if (toast.parentElement) {
                    toast.style.transform = 'translateX(100%)';
                    toast.style.transition = 'transform 0.3s ease-in-out';
                    setTimeout(() => toast.remove(), 300);
                }
            }, 5000);
        }
    </script>
@endsection
