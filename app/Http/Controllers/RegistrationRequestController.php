<?php

namespace App\Http\Controllers;

use App\Models\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegistrationRequestController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|unique:registration_requests',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,agent',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data['password'] = Hash::make($data['password']);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('users-photos', 'public');
            $data['photo'] = $photoPath;
        }

        RegistrationRequest::create($data);

        return redirect()->route('login')->with('success', 'Votre demande de compte a été envoyée. Un administrateur doit l\'approuver avant que vous puissiez vous connecter.');
    }

    public function index()
    {
        $requests = RegistrationRequest::where('statut', 'en_attente')->get();
        return view('admin.requests.index', compact('requests'));
    }

    public function approve($registrationRequest)
    {
        $regRequest = RegistrationRequest::findOrFail($registrationRequest);
        
        User::create([
            'name' => $regRequest->name,
            'email' => $regRequest->email,
            'password' => $regRequest->password,
            'role' => $regRequest->role,
            'photo' => $regRequest->photo,
        ]);

        $regRequest->update(['statut' => 'approuve']);

        return back()->with('success', 'Compte créé et utilisateur ajouté.');
    }

    public function reject(Request $req, $registrationRequest)
    {
        $regRequest = RegistrationRequest::findOrFail($registrationRequest);
        $regRequest->update([
            'statut' => 'rejete',
            'motif_rejet' => $req->motif_rejet,
        ]);

        return back()->with('success', 'Demande rejetée.');
    }

    public function rejected()
    {
        $requests = RegistrationRequest::where('statut', 'rejete')->get();
        return view('admin.requests.rejected', compact('requests'));
    }
}