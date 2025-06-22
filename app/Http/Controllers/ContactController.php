<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Affiche la page du formulaire de contact.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('site.pages.contact');
    }

    /**
     * Traite la soumission du formulaire de contact.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // À faire plus tard :
        // 1. Valider les données ($request->validate(...))
        // 2. Envoyer un email
        // 3. Rediriger avec un message de succès

        // Pour l'instant, on redirige juste en arrière.
        return back()->with('success', 'Votre message a bien été envoyé !');
    }
}
