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

            Revenu_externe::create($request->all());
    
            return redirect()->back()->with('succes', 'revenu ajoute');

        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->with('error', 'erreur lors de l enregistrement');
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
