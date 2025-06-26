<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\View;

use Illuminate\Http\Request;

class ajax extends Controller
{
    public function getData(Request $request)
    {
        // Exemple de traitement
        $data = ['message' => 'Données reçues avec succès', 'input' => $request->all()];

        return response()->json($data); // Retourne une réponse JSON
    }

    public function ajax()
    {
        
        return View("testeAjax") ; // Retourne une réponse JSON
    }
}
