{{--
    Partial buat nampilin daftar fitur suatu Tier di card pricing/billing.
    Expects: $tier (bisa null kalau Package belum dipasangin tier)

    Aturan render:
    - Fitur type "toggle" cuma ditampilin kalau nyala (pivot value = '1')
    - Fitur type "limit" ditampilin kalau unlimited, ATAU kuotanya > 0
    - Fitur yang mati/kuota 0 sengaja DISEMBUNYIIN (bukan dicoret), biar card gak
      penuh baris "tidak termasuk"
--}}
@if ($tier && $tier->features->isNotEmpty())
    @foreach ($tier->features as $feature)
        @continue($feature->type === 'toggle' && $feature->pivot->value !== '1')
        @continue($feature->type === 'limit' && ! $feature->pivot->is_unlimited && (int) $feature->pivot->value <= 0)
        <div class="flex items-center gap-3">
            <div class="w-5 h-5 rounded-full flex items-center justify-center shrink-0" style="background-color:#e4f9f5;">
                <svg class="w-3 h-3" style="color:#11999e;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <span class="text-sm text-base-content/70">
                @if ($feature->type === 'limit')
                    {{ $feature->pivot->is_unlimited ? 'Unlimited' : number_format((int) $feature->pivot->value) }}
                    {{ $feature->name }}
                @else
                    {{ $feature->name }}
                @endif
            </span>
        </div>
    @endforeach
@else
    <p class="text-sm text-base-content/50 italic">Belum ada fitur diatur untuk paket ini.</p>
@endif