<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User; // agrega el modelo User

use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all(); // Obtener todos los usuarios
        $roles = Role::all();  // Obtener todos los roles disponibles
        return view('users.index', compact('users', 'roles')); // Pasar usuarios a la vista
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all(); // Obtener todos los roles disponibles
        return view('users.create', compact('roles')); // Pasar roles a la vista
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validaciones
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20',
            'job_title' => 'required|string|max:255',
            'office' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validación de la imagen
        ]);

        // Manejo de imagen
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('profile-photos', 'public');
        }

        // Crear usuario
        $user = User::create([
            'name' => $validatedData['name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'phone' => $validatedData['phone'],
            'job_title' => $validatedData['job_title'],
            'office' => $validatedData['office'],
            'profile_photo_path' => $picturePath ?? null,  // Guardar el *path* de la imagen si existe
        ]);

        // Asignar rol al usuario (se envía como ID en el formulario)
        $role = Role::findOrFail($request->input('role'));
        $user->assignRole($role->name); // Asigna el rol al usuario

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all(); // Obtener roles
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // Validaciones
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'job_title' => 'required|string|max:255',
            'office' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed', // Validación para la contraseña
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validación para la imagen
        ]);

        // Manejo de la imagen
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('profile-photos', 'public');
            $validatedData['profile_photo_path'] = $picturePath;
        }

        // Actualizar contraseña si es necesario
        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($request->input('password'));
        } else {
            unset($validatedData['password']);
        }

        // Actualizar datos del usuario
        $user->update($validatedData);

        // Actualizar roles
        $role = Role::findOrFail($request->input('role'));
        $user->syncRoles($role->name); // Sincroniza el rol del usuario

        return redirect()->route('users.edit', $user)->with('info', 'Usuario actualizado con éxito.');
    }
}