@extends('user.layout2')

@section('title', 'Pegawai')
@section('meta_description',
    'Kelola data pegawai yang bertugas menerima notifikasi otomatis. Pastikan setiap pegawai
    sudah terhubung dengan unit dan tahap yang sesuai.')

@section('og_description',
    'Manajemen data pegawai SITAKU. Tambah, ubah, dan pantau pegawai yang akan menerima pesan
    otomatis dari sistem.')
@section('content')
    <div class="min-h-screen bg-base-200">
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
                        <h1 class="text-3xl font-bold text-base-content">Employee</h1>
                        <p class="text-base-content/70">Configure position for employee</p>
                    </div>
                </div>
            </div>
        </div>

        <dialog id="modal-tambah" class="modal" x-data="{ loading: false }">
            <div class="modal-box">
                <h3 class="text-xl font-semibold text-center text-primary mb-4">Tambah Pegawai</h3>

                <form method="POST" action="{{ route('pegawai.store') }}" class="space-y-4"
                    @submit.prevent="loading = true; $el.submit()">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                    <div>
                        <label for="nama" class="label mb-1">
                            <span class="label-text text-black">Nama Pegawai</span>
                        </label>
                        <input type="text" id="nama" name="nama" placeholder="Ex: Ichsan"
                            class="input input-bordered w-full border-primary focus:border-primary focus:input-primary"
                            required />
                    </div>

                    <div>
                        <label for="no_hp" class="label mb-1">
                            <span class="label-text text-black">Nomor HP</span>
                        </label>
                        <input type="text" id="no_hp" name="no_hp" placeholder="Ex: 0851XXXXXX" pattern="[0-9]+"
                            title="Hanya angka yang diperbolehkan"
                            class="input input-bordered w-full border-primary focus:border-primary focus:input-primary"
                            required />
                    </div>

                    <div>
                        <label for="posisi" class="label mb-1">
                            <span class="label-text text-black">Posisi</span>
                        </label>
                        <input type="text" id="posisi" name="posisi" placeholder="Ex: Entri Data"
                            class="input input-bordered w-full border-primary focus:border-primary focus:input-primary"
                            required />
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="closeModal()" class="btn btn-error">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary" :disabled="loading">
                            <span x-show="!loading">Simpan</span>
                            <span x-show="loading" class="flex items-center gap-1 color1">
                                <span class="loading loading-spinner loading-sm color1"></span>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <form method="dialog" class="modal-backdrop" onclick="closeModal()">
                <button>close</button>
            </form>
        </dialog>
        <dialog id="modal-edit" class="modal" x-data="{ loading: false }">
            <div class="modal-box">
                <h3 class="text-xl font-semibold text-center text-warning mb-4">Edit Pegawai</h3>

                <form method="POST" action="{{ route('pegawai.update') }}" class="space-y-4"
                    @submit.prevent="loading = true; $el.submit()">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                    <div>
                        <label for="edit_nama" class="label mb-1">
                            <span class="label-text text-black">Nama Pegawai</span>
                        </label>
                        <input type="text" id="edit_nama" name="nama"
                            class="input input-bordered w-full focus:input-primary border-primary" required />
                    </div>

                    <div>
                        <label for="edit_no_hp" class="label mb-1">
                            <span class="label-text text-black">Nomor HP</span>
                        </label>
                        <input type="text" id="edit_no_hp" name="no_hp" pattern="[0-9]+"
                            title="Hanya angka yang diperbolehkan"
                            class="input input-bordered w-full focus:input-primary border-primary" required />
                    </div>

                    <div>
                        <label for="edit_posisi" class="label mb-1">
                            <span class="label-text text-black">Posisi</span>
                        </label>
                        <input type="text" id="edit_posisi" name="posisi"
                            class="input input-bordered w-full focus:input-primary border-primary" required />
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="closeModalEdit()" class="btn btn-error">Batal</button>
                        <button type="submit" class="btn btn-warning" :disabled="loading">
                            <span x-show="!loading">Update</span>
                            <span x-show="loading" class="flex items-center gap-1 color1">
                                <span class="loading loading-spinner loading-sm color1"></span>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <form method="dialog" class="modal-backdrop" onclick="closeModalEdit()">
                <button>close</button>
            </form>
        </dialog>

        <div class="max-w-4xl mx-auto px-6 py-8 pt-4">
            <div class="alert alert-warning text-sm mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-4 w-4" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
                <span class="font-semibold">Posisi harus SAMA dengan nama tahapan pemohon (case sensitive). Contoh:
                    <span class="font-mono font-bold">Verifikasi</span>
                    bukan <span class="font-mono font-bold">verifikasi</span></span>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between mb-6">
                <div class="flex-1 max-w-md">
                    <div class="form-control">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 z-50 flex items-center pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass color1"></i>
                            </div>
                            <input type="text" placeholder="Search pegawai..."
                                class="input input-bordered input-primary w-full pl-10 pr-4 text-sm" id="searchInput"
                                onkeyup="searchPegawai()" />
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" onclick="document.getElementById('modal-tambah').showModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Pegawai
                </button>
            </div>
            <div id="searchInfo" class="mb-4 text-sm text-base-content/70 hidden">
                <span id="searchResults"></span>
            </div>
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full mt-8">
                    <thead>
                        <tr class="bg-base-200">
                            <th class="text-left font-semibold text-xs sm:text-sm">Name</th>
                            <th class="text-left font-semibold text-xs sm:text-sm hidden sm:table-cell">Position</th>
                            <th class="text-left font-semibold text-xs sm:text-sm">Contact</th>
                            <th class="text-center font-semibold text-xs sm:text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pegawai as $p)
                            <tr class="hover:bg-base-200/50 transition-colors duration-200">
                                <td class="py-2 sm:py-4">
                                    <div class="flex items-center gap-2 sm:gap-3">
                                        <div class="avatar hidden sm:block">
                                            <div class="mask mask-squircle w-8 h-8 sm:w-12 sm:h-12 bg-primary/20">
                                                <div
                                                    class="w-full h-full flex items-center justify-center text-primary font-semibold text-xs sm:text-base">
                                                    {{ strtoupper(Str::substr($p->nama, 0, 1)) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="font-bold text-base-content text-xs sm:text-base truncate">
                                                {{ $p->nama }}</div>
                                            <div class="text-xs text-base-content/70 sm:hidden">{{ $p->posisi }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden sm:table-cell py-2 sm:py-4">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-base-content text-sm">{{ $p->posisi }}</span>
                                    </div>
                                </td>
                                <td class="py-2 sm:py-4">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-1 sm:gap-2">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-success flex-shrink-0"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-xs sm:text-sm truncate">{{ $p->no_hp }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2 sm:py-4">
                                    <div class="flex items-center justify-center gap-1 sm:gap-2">
                                        <div class="tooltip tooltip-left sm:tooltip-top" data-tip="Edit">
                                            <button class="btn btn-ghost btn-xs text-warning p-1 sm:p-2"
                                                onclick='openModalEdit(@json($p))'>
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="tooltip tooltip-left sm:tooltip-top" data-tip="Delete">
                                            <button onclick="confirmDelete('{{ route('pegawai.destroy', $p->id) }}')"
                                                class="btn btn-ghost btn-xs text-error p-1 sm:p-2">
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="hover:bg-base-200/50 transition-colors duration-200">
                                <td colspan="4" class="text-center align-middle py-6 text-xs sm:text-sm">
                                    Data Not Found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast toast-top toast-end z-50" id="toastContainer"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
        });

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

        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(fieldId + '-eye');

            if (field.type === 'password') {
                field.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                `;
            } else {
                field.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }

        function confirmDelete(url) {
            Swal.fire({
                title: 'Yakin mau dihapus?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus aja!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.action = url;
                    form.method = 'POST';

                    let csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';

                    let method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';

                    form.appendChild(csrf);
                    form.appendChild(method);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function openModalEdit(pegawai) {
            document.getElementById('edit_id').value = pegawai.id;
            document.getElementById('edit_nama').value = pegawai.nama;
            document.getElementById('edit_no_hp').value = pegawai.no_hp;
            document.getElementById('edit_posisi').value = pegawai.posisi;
            document.getElementById('modal-edit').showModal();
        }

        function closeModal() {
            document.getElementById('modal-tambah').close();
        }

        function closeModalEdit() {
            document.getElementById('modal-edit').close();
        }

        function searchPegawai() {
            const searchInput = document.getElementById('searchInput');
            const searchTerm = searchInput.value.toLowerCase().trim();
            const tableRows = document.querySelectorAll('tbody tr');
            const searchInfo = document.getElementById('searchInfo');
            const searchResults = document.getElementById('searchResults');

            let visibleCount = 0;
            let totalCount = 0;

            tableRows.forEach(row => {
                // Skip the "Data Not Found" row
                if (row.querySelector('td[colspan]')) {
                    return;
                }

                totalCount++;

                const nameCell = row.querySelector('td:first-child .font-bold');
                const positionCell = row.querySelector('td:nth-child(2) .font-medium') ||
                    row.querySelector('td:first-child .text-xs.sm\\:hidden');
                const contactCell = row.querySelector('td:nth-child(3) span') ||
                    row.querySelector('td:last-child span');

                if (nameCell) {
                    const name = nameCell.textContent.toLowerCase();
                    const position = positionCell ? positionCell.textContent.toLowerCase() : '';
                    const contact = contactCell ? contactCell.textContent.toLowerCase() : '';

                    const isVisible = searchTerm === '' ||
                        name.includes(searchTerm) ||
                        position.includes(searchTerm) ||
                        contact.includes(searchTerm);

                    if (isVisible) {
                        row.style.display = '';
                        visibleCount++;

                        // Highlight search term
                        if (searchTerm !== '') {
                            highlightText(nameCell, searchTerm);
                            if (positionCell) highlightText(positionCell, searchTerm);
                            if (contactCell) highlightText(contactCell, searchTerm);
                        } else {
                            // Remove highlights
                            removeHighlight(nameCell);
                            if (positionCell) removeHighlight(positionCell);
                            if (contactCell) removeHighlight(contactCell);
                        }
                    } else {
                        row.style.display = 'none';
                    }
                }
            });

            // Show/hide search info
            if (searchTerm === '') {
                searchInfo.classList.add('hidden');
            } else {
                searchInfo.classList.remove('hidden');
                if (visibleCount === 0) {
                    searchResults.innerHTML = `No results found for "<strong>${searchInput.value}</strong>"`;
                } else {
                    searchResults.innerHTML =
                        `Found <strong>${visibleCount}</strong> of <strong>${totalCount}</strong> pegawai for "<strong>${searchInput.value}</strong>"`;
                }
            }

            // Show "Data Not Found" row if no results
            const emptyRow = document.querySelector('td[colspan]')?.parentElement;
            if (emptyRow) {
                if (totalCount === 0 || (searchTerm !== '' && visibleCount === 0)) {
                    emptyRow.style.display = '';
                    if (searchTerm !== '' && totalCount > 0) {
                        emptyRow.querySelector('td').textContent = `No pegawai found matching "${searchInput.value}"`;
                    }
                } else {
                    emptyRow.style.display = 'none';
                }
            }
        }

        function highlightText(element, searchTerm) {
            const originalText = element.getAttribute('data-original-text') || element.textContent;
            element.setAttribute('data-original-text', originalText);

            const regex = new RegExp(`(${escapeRegExp(searchTerm)})`, 'gi');
            const highlightedText = originalText.replace(regex,
                '<mark class="bg-yellow-200 text-yellow-900 rounded px-1">$1</mark>');
            element.innerHTML = highlightedText;
        }

        function removeHighlight(element) {
            const originalText = element.getAttribute('data-original-text');
            if (originalText) {
                element.textContent = originalText;
                element.removeAttribute('data-original-text');
            }
        }

        function escapeRegExp(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        // Clear search when modal is opened
        function clearSearch() {
            const searchInput = document.getElementById('searchInput');
            searchInput.value = '';
            searchPegawai();
        }
        // Add event listener for Enter key
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        searchPegawai();
                    }
                });
            }
        });
    </script>

@endsection
