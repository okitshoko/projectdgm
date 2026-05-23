<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Liste tous les agents/utilisateurs + sessions actives
     */
    public function index()
    {
        $users = User::latest()->get();

        // Récupérer les user_id ayant une session active (dernière activité < 30 min)
        $activeUserIds = DB::table('sessions')
            ->whereNotNull('user_id')
            ->where('last_activity', '>=', now()->subMinutes(30)->timestamp)
            ->pluck('user_id')
            ->toArray();

        return view('admin.users.index', compact('users', 'activeUserIds'));
    }

    /**
     * Formulaire de création d'un compte
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Enregistre un nouvel agent
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:admin,agent',
            'photo'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data['password'] = Hash::make($data['password']);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('users-photos', 'public');
            $data['photo'] = $photoPath;
        }

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Compte créé avec succès.');
    }

    public function editPassword()
    {
        return view('admin.users.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|min:6|confirmed',
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Mot de passe modifié avec succès.');
    }

    public function editProfile()
    {
        return view('admin.users.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete('public/' . $user->photo);
            }
            $photoPath = $request->file('photo')->store('users-photos', 'public');
            $data['photo'] = $photoPath;
        }

        $user->update($data);

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Supprime un compte utilisateur
     */
    public function destroy(User $user)
    {
        // Empêcher la suppression de son propre compte
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return back()->with('success', 'Compte supprimé avec succès.');
    }
}
