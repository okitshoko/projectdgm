<?php

namespace App\Http\Controllers;

use App\Models\Visa;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\Notification;

class VisaController extends Controller
{
    public function index() {
        // On récupère les visas avec leurs pays pour gagner en performance
        $visas = Visa::with('country')->get();
        return view('visas.index', compact('visas'));
    }

    public function dashboard() 
{
    $totalVisas = \App\Models\Visa::count();
    
    $expiresBientot = \App\Models\Visa::where('date_expiration', '>', now())
                        ->where('date_expiration', '<=', now()->addDays(7))
                        ->count();

    $expires = \App\Models\Visa::where('date_expiration', '<', now())->count();

    return view('welcome', compact('totalVisas', 'expiresBientot', 'expires'));
}

    public function create() {
        $countries = Country::all();
        return view('visas.create', compact('countries'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'nom_etranger' => 'required|string',
            'numero_passeport' => 'required|unique:visas',
            'type_visa' => 'required',
            'date_entree' => 'required|date',
            'date_expiration' => 'required|date',
            'email_contact' => 'required|email',
            'telephone_contact' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('visas-photos', 'public');
            $data['photo'] = $photoPath;
        }

        Visa::create($data);
        return redirect()->route('visas.index')->with('success', 'Séjour enregistré.');
    }
    public function show(Visa $visa)
    {
        return view('visas.show', compact('visa'));
    }

    public function avertissement(Visa $visa)
{
    return view('visas.avertissement', compact('visa'));
}
public function envoyerAlerte(Visa $visa) 
{
    // 1. On récupère l'adresse email de l'étranger enregistrée en base de données
    $emailDestinataire = $visa->email_contact; 

    // 2. On prépare les données pour le design du mail
    $details = [
        'nom' => $visa->nom_etranger,
        'passeport' => $visa->numero_passeport,
        'expiration' => $visa->date_expiration,
    ];

    // 3. L'ACTION RÉELLE : Envoi vers l'adresse sélectionnée (ex: okit@gmail.com)
    Mail::to($emailDestinataire)->send(new \App\Mail\AlertExpiration($details));

    // 4. On enregistre la trace dans ton historique
    \App\Models\Notification::create([
        'visa_id' => $visa->id,
        'type_alerte' => 'Email',
        'message' => "Alerte envoyée manuellement à " . $emailDestinataire,
        'date_envoi' => now(),
        'statut_envoi' => 'Succès'
    ]);

    return redirect()->route('visas.index')->with('success', "L'alerte a été envoyée avec succès à " . $emailDestinataire);
}
}