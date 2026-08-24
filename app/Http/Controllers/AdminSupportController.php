<?php

namespace App\Http\Controllers;

use App\Models\AdminSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminSupportController extends Controller
{
    public function index()
    {
        $user = Auth::guard('user')->user();

        $adminSupports = AdminSupport::where('user_id', $user->id)
            ->orderBy('name')
            ->get();

        return view('user.admin-supports.index', compact('adminSupports'));
    }

    public function create()
    {
        return view('user.admin-supports.form', [
            'adminSupport' => new AdminSupport(),
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::guard('user')->user();
        $validated = $this->validateRequest($request, $user);

        AdminSupport::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin-support.index')->with('success', 'Akun admin support berhasil ditambahkan.');
    }

    public function edit(AdminSupport $adminSupport)
    {
        $this->authorizeOwnership($adminSupport);

        return view('user.admin-supports.form', compact('adminSupport'));
    }

    public function update(Request $request, AdminSupport $adminSupport)
    {
        $user = Auth::guard('user')->user();
        $this->authorizeOwnership($adminSupport);

        $validated = $this->validateRequest($request, $user, $adminSupport);

        $adminSupport->name = $validated['name'];
        $adminSupport->email = $validated['email'];
        if (! empty($validated['password'])) {
            $adminSupport->password = $validated['password'];
        }
        $adminSupport->is_active = $request->boolean('is_active', true);
        $adminSupport->save();

        return redirect()->route('admin-support.index')->with('success', 'Akun admin support berhasil diperbarui.');
    }

    public function destroy(AdminSupport $adminSupport)
    {
        $this->authorizeOwnership($adminSupport);
        $adminSupport->delete();

        return redirect()->route('admin-support.index')->with('success', 'Akun admin support berhasil dihapus.');
    }

    private function authorizeOwnership(AdminSupport $adminSupport): void
    {
        abort_unless($adminSupport->user_id === Auth::guard('user')->id(), 404);
    }

    private function validateRequest(Request $request, $user, ?AdminSupport $current = null): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('admin_supports', 'email')->ignore($current?->id),
            ],
            'password' => [$current?->exists ? 'nullable' : 'required', 'string', 'min:8'],
        ];

        return $request->validate($rules);
    }
}