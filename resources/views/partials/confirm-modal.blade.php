{{-- Modal konfirmasi generik -- pengganti window.confirm() bawaan browser, dipake
     di semua halaman biar tampilannya seragam. Include sekali per layout, terus:

     1) Buat form yang cuma butuh konfirmasi doang (mis. tombol hapus), tinggal kasih
        class "js-confirm-submit" + attribute data-confirm-message, gak perlu JS manual:
        <form ... class="js-confirm-submit" data-confirm-message="Yakin hapus ini?">

     2) Buat logic custom (bukan form submit biasa, mis. ada fetch() dulu), panggil
        langsung dari JS: confirmAction('Yakin mau X?', function () { ...aksinya... }); --}}
<dialog id="modal-confirm-action" class="modal">
    <div class="modal-box">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-full bg-error/20 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-error" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold" id="modal-confirm-title">Konfirmasi</h3>
        </div>
        <p class="text-base-content/70 mb-6" id="modal-confirm-message">Yakin mau lanjut?</p>
        <div class="flex justify-end gap-3">
            <button type="button" class="btn" id="modal-confirm-cancel">Batal</button>
            <button type="button" class="btn btn-error" id="modal-confirm-ok">Ya, Lanjutkan</button>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<script>
    (function () {
        const modal = document.getElementById('modal-confirm-action');
        const okBtn = document.getElementById('modal-confirm-ok');
        const cancelBtn = document.getElementById('modal-confirm-cancel');
        const messageEl = document.getElementById('modal-confirm-message');
        let pendingConfirm = null;

        // window.confirmAction('Yakin mau X?', function () { ...kalau diklik Ya... });
        window.confirmAction = function (message, onConfirm) {
            messageEl.textContent = message;
            pendingConfirm = onConfirm;
            modal.showModal();
        };

        okBtn.addEventListener('click', function () {
            modal.close();
            const cb = pendingConfirm;
            pendingConfirm = null;
            if (cb) cb();
        });

        cancelBtn.addEventListener('click', function () {
            pendingConfirm = null;
            modal.close();
        });

        modal.addEventListener('close', function () {
            pendingConfirm = null;
        });

        // Auto-intercept: form mana aja yang dikasih class "js-confirm-submit" bakal
        // ditahan submit-nya sampai user klik "Ya, Lanjutkan" di modal.
        document.addEventListener('submit', function (e) {
            const form = e.target.closest('.js-confirm-submit');
            if (!form || form.dataset.confirmed === '1') return;

            e.preventDefault();
            window.confirmAction(form.dataset.confirmMessage || 'Yakin mau lanjut?', function () {
                form.dataset.confirmed = '1';
                if (form.requestSubmit) {
                    form.requestSubmit();
                } else {
                    form.submit();
                }
            });
        });
    })();
</script>