<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Revenu_externe;
use Illuminate\Support\Facades\DB;

class RevenuExterneController extends Controller
{

     public function index (){

       $revenu_externes = Revenu_externe::all();
        $montant_total_externe = Revenu_externe::sum('montant');


        $montant_total_locatif = RevenuExterneController::totalLoyers()+RevenuExterneController::prixGarantie();
       

        return view('caisse.index', compact(
            'revenu_externes',
            'montant_total_externe',
            'montant_total_locatif'
        ));

    }
    public function store(Request $request){

       try {
    // Validation
    $validated = $request->validate([
        'montant' => 'required|numeric|min:0|max:99999999999999999999.99', 
        'motif'   => 'required|string|max:255',
        'date'    => 'required|date',
    ]);

    // Enregistrement
    Revenu_externe::create([
        'montant' => $validated['montant'],
        'motif'   => $validated['motif'],
        'date'    => $validated['date'],
        'user_id' => auth()->id(), // si tu veux lier à l’utilisateur connecté
    ]);

    return redirect()->back()->with('succes', 'Revenu ajouté avec succès ✅');

    } catch (\Throwable $th) {
        // En cas d'erreur
        return redirect()->back()->with('error', 'Erreur lors de l\'enregistrement : '.$th->getMessage());
    }


        }



    public static function totalLoyers() {
    // Somme totale des loyers des immeubles
    $totalImmeublesMontant = DB::table('loyer_apps')->sum('montant');

    // Somme totale des loyers des galeries
    $totalGaleriesMontant = DB::table('loyer_autres')->sum('montant');

    return $totalImmeublesMontant+$totalGaleriesMontant;
   
}



    public static function prixGarantie(){
        $totalMontant = DB::table('garantie_apparts')
                ->sum('montant');
     $totalMontantAutre= DB::table('garantie_autres')
                ->sum('montant');

            
              return   $totalMontant+$totalMontantAutre;
    }



   
}
