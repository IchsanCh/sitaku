@extends('user.layout2')

@section('title', $quickReply->exists ? 'Edit Balasan Cepat' : 'Tambah Balasan Cepat')
@section('meta_description', 'Atur balasan cepat (quick reply) buat admin support di live chat WhatsApp.')
@section('og_description', 'Kelola template balasan cepat SITAKU sesuai kebutuhan instansi Anda.')

@section('content')
<div class="min-h-screen bg-base-100 py-8">
    <div class="max-w-2xl mx-auto px-6">

        <a href="{{ route('quick-reply.index') }}" class="btn btn-ghost btn-sm mb-4">← Kembali</a>

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
                    class="space-y-5">
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
                        <label class="label"><span class="label-text font-medium">Isi Balasan</span></label>
                        <textarea name="content" class="textarea textarea-bordered w-full" rows="6" required
                            maxlength="2000" placeholder="Tulis teks lengkap yang bakal ngisi kotak chat begitu trigger ini dipilih...">{{ old('content', $quickReply->content) }}</textarea>
                        <p class="text-xs text-base-content/50 mt-1">Teks ini bakal langsung ngisi kotak chat admin support -- masih bisa diedit lagi sebelum dikirim.</p>
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
    </div>
</div>
@endsection