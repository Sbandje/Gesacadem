<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function register() {
        return view('front.etudiants');
    }

    

    public function login() {
        return view('user.login');
    }

    public function loginPost(Request $request) {
        $connexion = $request->validate([
            'nom' => 'string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Vérifier les identifiants
        if (!auth()->attempt($connexion)) {
            return back()->withErrors(['error' => 'Identifiants invalides.']);
        }else {
            return redirect()->route('front.dashboard')->with('success', 'Connexion réussie.');
        }

    }

        public function logout() {
            auth()->logout();
            return redirect()->route('user.login')->with('success', 'Déconnexion réussie.');
        }
}
    





