<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MenuItemController extends Controller
{
    /**
     * List menu item di 1 level (menu utama kalau parent null, atau submenu
     * kalau parent diisi). Breadcrumb-nya dibentuk dari rantai parent.
     */
    public function index(Request $request)
    {
        $user = Auth::guard('user')->user();
        $parentId = $request->query('parent');

        $parent = null;
        if ($parentId) {
            $parent = MenuItem::where('user_id', $user->id)->findOrFail($parentId);

            if ($parent->action_type !== 'submenu') {
                abort(404);
            }
        }

        $items = MenuItem::where('user_id', $user->id)
            ->where('parent_id', $parentId)
            ->orderBy('sort_order')
            ->get();

        return view('user.menu-items.index', [
            'items' => $items,
            'parent' => $parent,
            'allowedActions' => $user->allowedMenuActionTypes(),
            'canManageStructure' => $user->hasFeature('state_machine'),
            'quota' => $this->quotaInfo($user, $parentId ? (int) $parentId : null),
        ]);
    }

    public function create(Request $request)
    {
        $user = Auth::guard('user')->user();
        $allowed = $user->allowedMenuActionTypes();

        if (empty($allowed)) {
            return redirect()->route('user.billing')
                ->with('error', 'Fitur custom menu WA tidak tersedia di paket Anda saat ini.');
        }

        $parentId = $request->query('parent');
        $parent = $parentId ? MenuItem::where('user_id', $user->id)->findOrFail($parentId) : null;

        $quota = $this->quotaInfo($user, $parentId ? (int) $parentId : null);
        if ($quota['limit'] !== null && $quota['used'] >= $quota['limit']) {
            return redirect()
                ->route('menu.index', ['parent' => $parentId])
                ->with('error', "Kuota " . ($parentId ? 'submenu' : 'menu utama') . " tambahan udah abis ({$quota['used']}/{$quota['limit']}). Upgrade paket buat nambah lagi.");
        }

        return view('user.menu-items.form', [
            'menuItem' => new MenuItem(['parent_id' => $parentId]),
            'parent' => $parent,
            'allowedActions' => $allowed,
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::guard('user')->user();
        $allowed = $user->allowedMenuActionTypes();

        $validated = $this->validateRequest($request, $user, $allowed);

        $this->enforceQuota($user, $validated['parent_id']);

        MenuItem::create([
            'user_id' => $user->id,
            'is_default' => false,
            ...$validated,
        ]);

        return redirect()
            ->route('menu.index', ['parent' => $validated['parent_id']])
            ->with('success', 'Menu item berhasil ditambahkan.');
    }

    /**
     * Kuota nambah menu BARU (di luar 3 default gratis) -- dicek terpisah
     * antara menu utama (parent_id null) dan submenu (parent_id ada isinya),
     * masing-masing punya limit sendiri via Feature 'max_menu_utama' /
     * 'max_submenu'. null dari featureLimit() artinya unlimited.
     */
    private function quotaInfo($user, ?int $parentId): array
    {
        if ($parentId === null) {
            return [
                'limit' => $user->featureLimit('max_menu_utama'),
                'used' => MenuItem::where('user_id', $user->id)
                    ->whereNull('parent_id')
                    ->where('is_default', false)
                    ->count(),
            ];
        }

        return [
            'limit' => $user->featureLimit('max_submenu'),
            'used' => MenuItem::where('user_id', $user->id)
                ->whereNotNull('parent_id')
                ->count(),
        ];
    }

    private function enforceQuota($user, ?int $parentId): void
    {
        $quota = $this->quotaInfo($user, $parentId);

        if ($quota['limit'] !== null && $quota['used'] >= $quota['limit']) {
            $jenis = $parentId ? 'submenu' : 'menu utama';
            abort(403, "Kuota {$jenis} tambahan udah abis ({$quota['used']}/{$quota['limit']}). Upgrade paket buat nambah lagi.");
        }
    }

    public function edit(MenuItem $menuItem)
    {
        $user = Auth::guard('user')->user();
        $this->authorizeOwnership($menuItem, $user);

        $parent = $menuItem->parent_id
            ? MenuItem::where('user_id', $user->id)->find($menuItem->parent_id)
            : null;

        return view('user.menu-items.form', [
            'menuItem' => $menuItem,
            'parent' => $parent,
            'allowedActions' => $user->allowedMenuActionTypes(),
        ]);
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $user = Auth::guard('user')->user();
        $this->authorizeOwnership($menuItem, $user);

        $allowed = $user->allowedMenuActionTypes();
        $validated = $this->validateRequest($request, $user, $allowed, $menuItem);

        $menuItem->update($validated);

        return redirect()
            ->route('menu.index', ['parent' => $validated['parent_id']])
            ->with('success', 'Menu item berhasil diperbarui.');
    }

    public function destroy(MenuItem $menuItem)
    {
        $user = Auth::guard('user')->user();
        $this->authorizeOwnership($menuItem, $user);

        $parentId = $menuItem->parent_id;
        $menuItem->delete(); // children ikut kehapus otomatis (cascadeOnDelete di migration)

        return redirect()
            ->route('menu.index', ['parent' => $parentId])
            ->with('success', 'Menu item (beserta submenu di dalamnya, kalau ada) berhasil dihapus.');
    }

    private function authorizeOwnership(MenuItem $menuItem, $user): void
    {
        abort_unless($menuItem->user_id === $user->id, 404);
    }

    private function validateRequest(Request $request, $user, array $allowed, ?MenuItem $current = null): array
    {
        $parentId = $request->input('parent_id') ?: null;

        // Kalau punya parent, pastiin parent itu emang milik user ini dan action_type-nya submenu.
        if ($parentId) {
            $parent = MenuItem::where('user_id', $user->id)->find($parentId);
            abort_unless($parent && $parent->action_type === 'submenu', 404);
        }

        $data = $request->validate([
            'trigger' => [
                'required',
                'string',
                'max:50',
                Rule::unique('menu_items', 'trigger')
                    ->where('user_id', $user->id)
                    ->where('parent_id', $parentId)
                    ->ignore($current?->id),
            ],
            'label' => 'required|string|max:255',
            'audience' => ['required', Rule::in(['pemohon', 'pegawai', 'both'])],
            'action_type' => ['required', Rule::in($allowed)],
            'template' => 'nullable|string|max:1500',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $actionConfig = null;
        if ($data['action_type'] === 'pesan_custom') {
            // pesan_custom WAJIB diisi -- dia langsung dikirim apa adanya, gak ada
            // fallback default kayak cek_status/riwayat_tahapan.
            $request->validate(['template' => 'required|string|max:1500']);
            $actionConfig = ['template' => $data['template']];
        } elseif (in_array($data['action_type'], ['cek_status', 'riwayat_tahapan'], true) && filled($data['template'] ?? null)) {
            // Opsional -- kosong = pakai teks default bawaan sistem.
            $actionConfig = ['template' => $data['template']];
        }

        return [
            'parent_id' => $parentId,
            'trigger' => $data['trigger'],
            'label' => $data['label'],
            'audience' => $data['audience'],
            'action_type' => $data['action_type'],
            'action_config' => $actionConfig,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ];
    }
}