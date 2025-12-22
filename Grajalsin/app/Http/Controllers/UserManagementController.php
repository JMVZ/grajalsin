<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Module;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserManagementController extends Controller
{
    /**
     * Mostrar lista de usuarios
     */
    public function index()
    {
        $users = User::with('modules')->paginate(10);
        $modules = Module::active()->ordered()->get();
        
        return view('admin.users.index', compact('users', 'modules'));
    }

    /**
     * Mostrar formulario para crear usuario
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Guardar nuevo usuario
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'is_admin' => 'boolean'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->has('is_admin') ? (bool)$request->is_admin : false,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado exitosamente. Puedes asignar módulos desde "Gestionar Módulos".');
    }

    /**
     * Mostrar formulario para editar usuario
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'is_admin' => 'boolean'
        ]);

        $isAdminChanged = $user->is_admin != ($request->has('is_admin') ? (bool)$request->is_admin : false);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->has('is_admin') ? (bool)$request->is_admin : false,
        ]);

        // Si cambió a admin, limpiar módulos asignados (ya no los necesita)
        if ($isAdminChanged && $user->is_admin) {
            $user->modules()->detach();
        }

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Eliminar usuario
     */
    public function destroy(User $user)
    {
        $user->delete();
        
        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }

    /**
     * Mostrar gestión de módulos por rol
     */
    public function roleModules()
    {
        $roles = Role::with('modules')->get();
        $modules = Module::active()->ordered()->get();
        
        return view('admin.roles.modules', compact('roles', 'modules'));
    }

    /**
     * Actualizar módulos de un rol
     */
    public function updateRoleModules(Request $request, Role $role)
    {
        $request->validate([
            'modules' => 'array',
            'modules.*' => 'exists:modules,id'
        ]);

        // Sincronizar módulos del rol
        $role->modules()->sync($request->modules ?? []);

        return redirect()->route('roles.modules')
            ->with('success', 'Módulos del rol actualizados exitosamente.');
    }

    /**
     * Mostrar gestión de módulos por usuario
     */
    public function userModules(User $user)
    {
        // Si es admin, no necesita asignación de módulos
        if ($user->is_admin) {
            return redirect()->route('users.index')
                ->with('info', 'Los administradores tienen acceso a todos los módulos automáticamente.');
        }
        
        $modules = Module::active()->ordered()->get();
        $userModules = $user->modules->pluck('id')->toArray();
        
        return view('admin.users.modules', compact('user', 'modules', 'userModules'));
    }

    /**
     * Actualizar módulos de un usuario
     */
    public function updateUserModules(Request $request, User $user)
    {
        // Si es admin, no debe asignar módulos
        if ($user->is_admin) {
            return redirect()->route('users.index')
                ->with('error', 'No se pueden asignar módulos a un administrador. Los administradores tienen acceso a todos los módulos.');
        }
        
        $request->validate([
            'modules' => 'array',
            'modules.*' => 'exists:modules,id'
        ]);

        // Sincronizar módulos del usuario
        $user->modules()->sync($request->modules ?? []);

        return redirect()->route('users.index')
            ->with('success', 'Módulos del usuario actualizados exitosamente.');
    }
}
