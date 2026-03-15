<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function __construct()
    {
        // ✅ MUST match route parameter name: {user}
        $this->authorizeResource(User::class, 'user');
    }

    public function index()
    {
        $users = User::query()
            ->with('roles')
            ->orderBy('name')
            ->paginate(30);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create', [
            'roles' => Role::orderBy('nosaukums')->get(),
        ]);
    }

    public function store(Request $request, AuditLogger $audit)
    {
        $data = $request->validate([
            'name' => ['required','string','min:2','max:150'],
            'email' => ['required','email','max:190','unique:users,email'],
            'password' => ['required','string','min:8','max:255'],
            'is_active' => ['sometimes','boolean'],
            'role_ids' => ['array'],
            'role_ids.*' => ['integer','exists:roles,id'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);

        $user->roles()->sync($data['role_ids'] ?? []);
        $audit->log('admin_users_store', $user);

        return redirect()->route('admin.users.index')->with('status', 'Lietotājs izveidots.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user->load('roles'),
            'roles' => Role::orderBy('nosaukums')->get(),
        ]);
    }

    public function update(Request $request, User $user, AuditLogger $audit)
    {
        $data = $request->validate([
            'name' => ['required','string','min:2','max:150'],
            'email' => ['required','email','max:190', Rule::unique('users','email')->ignore($user->id)],
            'password' => ['nullable','string','min:8','max:255'],
            'is_active' => ['sometimes','boolean'],
            'role_ids' => ['array'],
            'role_ids.*' => ['integer','exists:roles,id'],
        ]);

        $update = [
            'name' => $data['name'],
            'email' => $data['email'],
            'is_active' => (bool) ($data['is_active'] ?? $user->is_active),
        ];

        if (!empty($data['password'])) {
            $update['password'] = Hash::make($data['password']);
        }

        $user->update($update);
        $user->roles()->sync($data['role_ids'] ?? []);

        $audit->log('admin_users_update', $user);

        return redirect()->route('admin.users.index')->with('status', 'Lietotājs atjaunināts.');
    }

    public function destroy(User $user, AuditLogger $audit)
    {
        // Prevent deleting yourself (safe default)
        if (Auth::id() === $user->id) {
            return back()->with('status', 'Nevar dzēst pašu sevi.');
        }

        $user->delete();
        $audit->log('admin_users_delete', $user);

        return redirect()->route('admin.users.index')->with('status', 'Lietotājs dzēsts.');
    }
}