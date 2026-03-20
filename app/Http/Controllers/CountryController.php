<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index() {
        return view('countries.index', ['countries' => Country::all()]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nom_pays' => 'required|unique:countries',
            'code_iso' => 'required|max:5'
        ]);
        Country::create($validated);
        return back()->with('success', 'Pays ajouté !');
    }
}