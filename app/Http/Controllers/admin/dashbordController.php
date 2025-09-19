<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashbordController extends Controller
{
    public function index(){
        return View("admin.dashboard.index",["stat"=>[dashbordController::nombre_locataire(),
        dashbordController::prixLoyer(),dashbordController::Status2(),dashbordController::Status(),
        dashbordController::depense(),
        dashbordController::infoBien()[0],
        dashbordController::infoBien()[1]

        ]]);
    }

    public function info_graphique(){
            $immeublesParMois = DB::table('loyer_apps')
            ->select(
                DB::raw(' MONTH( loyer_apps.date) as mois'),
                DB::raw('SUM(loyer_apps.montant) as total_immeubles')
            )
            ->groupBy('mois')
            ->orderBy('mois', 'asc')
            ->get();
            $moisMapping = [
                '1' => 'Janvier', '2' => 'Février', '3' => 'Mars', '4' => 'Avril',
                '5' => 'Mai', '6' => 'Juin', '7' => 'Juillet', '8' => 'Août',
                '9' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre'
            ];
            
            // Tableau final avec tous les mois initialisés à null
            $result = array_fill_keys(array_keys($moisMapping), null);
            
            // Remplir les valeurs existantes
            foreach ($immeublesParMois as $data) {
                $result[$data->mois] = $data->total_immeubles;
            }
            
            // Formater la sortie avec les noms des mois
            $finalResult = [];
            foreach ($moisMapping as $key => $nomMois) {
                $finalResult[] =  $result[$key];
                
            }

                   
            // Ici pour les galerie
            $galeriesParMois = DB::table('loyer_autres')
            ->select(
                DB::raw('MONTH(loyer_autres.date) as mois')
,
                DB::raw('SUM(loyer_autres.montant) as total_galeries')
            )
            ->groupBy('mois')
            ->orderBy('mois', 'asc')
            ->get();
    
        
            $result1 = array_fill_keys(array_keys($moisMapping), null);
            
            // Remplir les valeurs existantes
            foreach ($galeriesParMois as $data) {
                $result1[$data->mois] = $data->total_galeries;
            }
            
            // Formater la sortie avec les noms des mois
            $finalResult1 = [];
            foreach ($moisMapping as $key => $nomMois) {
                $finalResult1[] =  $result1[$key];
                
            }

            $data = ['message' => 'galerie', 'input' =>[$finalResult,$finalResult1]  ];

            return response()->json($data);

    }


    public static function info_graphique_depense(){

        $immeublesParMois = DB::table('operations')
        ->select(
            DB::raw('MONTH(operations.date) as mois')
,
            DB::raw('SUM(operations.montant) as total_immeubles')
        )
        ->groupBy('mois')
        ->orderBy('mois', 'asc')
        ->get();
        $moisMapping = [
            '1' => 'Janvier', '2' => 'Février', '3' => 'Mars', '4' => 'Avril',
            '5' => 'Mai', '6' => 'Juin', '7' => 'Juillet', '8' => 'Août',
            '9' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre'
        ];
        
        // Tableau final avec tous les mois initialisés à null
        $result = array_fill_keys(array_keys($moisMapping), null);
        
        // Remplir les valeurs existantes
        foreach ($immeublesParMois as $data) {
            $result[$data->mois] = $data->total_immeubles;
        }
        
        // Formater la sortie avec les noms des mois
        $finalResult = [];
        foreach ($moisMapping as $key => $nomMois) {
            $finalResult[] =  $result[$key];
            
        }

               
        // Ici pour les galerie
        $galeriesParMois = DB::table('loyer_autres')
        ->select(
            DB::raw('MONTH(loyer_autres.date) as mois')
,
            DB::raw('SUM(loyer_autres.montant) as total_galeries')
        )
        ->groupBy('mois')
        ->orderBy('mois', 'asc')
        ->get();

    
        $result1 = array_fill_keys(array_keys($moisMapping), null);
        
        // Remplir les valeurs existantes
        foreach ($galeriesParMois as $data) {
            $result1[$data->mois] = $data->total_galeries;
        }
        
        // Formater la sortie avec les noms des mois
        $finalResult1 = [];
        foreach ($moisMapping as $key => $nomMois) {
            $finalResult1[] =  $result1[$key];
            
        }

        $data = ['message' => 'galerie', 'input' =>[$finalResult]];



        return response()->json($data);

    } 




    public static function depense(){

        $op = DB::table('operations')
        ->select('date', DB::raw('SUM(montant) as total_montant'))
        ->where('status', '=', 1) // Calcul de la somme de 'montant'
        ->groupBy('date') // Regrouper par 'date'
        ->havingRaw('date LIKE ?', ['2025%']) // Filtrer les dates qui commencent par '2025'
        ->having('total_montant', '>', 1000) // Condition HAVING sur le total du montant
        ->get();
        return $op ;
    }

    public static function nombre_locataire(){

        $informationImmeuble = DB::table('location_aps')
            ->join('locataires', 'locataires.id', '=', 'location_aps.id_locataire')
            ->join('appartements', 'appartements.id', '=', 'location_aps.id_appartement')
            ->join('immeubles', 'immeubles.id', '=', 'appartements.id_immeuble')
            ->select(

                DB::raw("COUNT(*) OVER() as total_count")
            )
            ->where('location_aps.date_debut', 'LIKE', date("Y-m").'%')
            ->get()->count();

            $pour_galerie = DB::table('location_autres')
            ->join('locataires', 'locataires.id', '=', 'location_autres.id_locataire')
            ->join('autre_biens', 'autre_biens.id', '=', 'location_autres.id_autre_bien')
            ->join('galeries', 'galeries.id', '=', 'autre_biens.id_galerie')
            ->select(
                DB::raw("COUNT(*) OVER() as total_count")
            )
          
            ->where('location_autres.date_debut', 'LIKE', date("Y-m").'%')// Condition sur le nom_galerie
            ->get()->count();;

        return [$informationImmeuble, $pour_galerie ];

    }
    public static function prixLoyer(){

        $immeublesAvecDetails = DB::table('loyer_apps')
        ->select(
            'loyer_apps.date',
            DB::raw('SUM(loyer_apps.montant) as total_montant') // Agrégation pour la somme
        )
        ->where('loyer_apps.date', 'LIKE', date("Y-m") . '%')
        ->groupBy('loyer_apps.date') // Regrouper par date
        ->get();
    
    // Calculer la somme totale des immeubles
    $totalImmeublesMontant = $immeublesAvecDetails->isNotEmpty() 
        ? $immeublesAvecDetails->sum('total_montant') 
        : 0;
    
    $galeriesAvecDetails = DB::table('loyer_autres')
        ->select(
            'loyer_autres.date',
            DB::raw('SUM(loyer_autres.montant) as total_montant') // Agrégation pour la somme
        )
        ->where('loyer_autres.date', 'LIKE', date("Y-m") . '%')
        ->groupBy('loyer_autres.date') // Regrouper par date
        ->get();
    
    // Calculer la somme totale des galeries
    $totalGaleriesMontant = $galeriesAvecDetails->isNotEmpty() 
        ? $galeriesAvecDetails->sum('total_montant') 
        : 0;
    
    // Affichage ou utilisation des résultats
    return [
        $totalImmeublesMontant,
         $totalGaleriesMontant,
    ];

    }


    public static function Status(){
        // Identifier les immeubles et leurs appartements
     
    $tousAppartements = DB::table('appartements')
    ->join('immeubles', 'immeubles.id', '=', 'appartements.id_immeuble')
    ->join('location_aps', 'location_aps.id_appartement', '=', 'appartements.id')
    ->join('locataires', 'locataires.id', '=', 'location_aps.id_locataire')
    ->join('loyer_apps', function($join) {
        $join->on('loyer_apps.id_appartement', '=', 'appartements.id')
            ->on('loyer_apps.id_locataire', '=', 'locataires.id');
    })
    ->select(
        'appartements.id as appartement_id',
        'appartements.numero',
        'immeubles.adresse',
        'immeubles.ville',
        'immeubles.province',
        'immeubles.id as immeuble_id',
        'immeubles.nom_immeuble as immeuble_nom',
        'location_aps.id as location_id',
        'location_aps.date_debut',
        'location_aps.date_fin',
        'locataires.id as locataire_id',
        'locataires.nom as locataire_nom',
        'locataires.prenom as locataire_prenom',
        'locataires.numero as locataire_telephone',
        'loyer_apps.id as loyer_id',
        'loyer_apps.date as date_loyer',
        'loyer_apps.montant as loyer_montant',
        'loyer_apps.date as loyer_date',
        'loyer_apps.statut as loyer_statut'
    )
    ->get();
 

        return $tousAppartements;
    }


    public static function Status2()
    {
        // Récupérer tous les biens et leurs galeries associées
       

            $tousBiens = DB::table('autre_biens')
    ->join('galeries', 'galeries.id', '=', 'autre_biens.id_galerie')
    ->join('location_autres', 'location_autres.id_autre_bien', '=', 'autre_biens.id')
    ->join('locataires', 'locataires.id', '=', 'location_autres.id_locataire')
      ->join('loyer_autres', function($join) {
        $join->on('loyer_autres.id_autre_bien', '=', 'autre_biens.id')
            ->on('loyer_autres.id_locataire', '=', 'locataires.id');
    })
    ->select(
        'galeries.id as galerie_id',
        'galeries.nom_galerie as galerie_nom',
        'galeries.adresse',
        'galeries.ville',
        'galeries.province',
        'autre_biens.id as bien_id',
        'autre_biens.nom as bien_nom',
        'autre_biens.type',
        'location_autres.date_debut',
        'location_autres.date_fin',
        'locataires.id as locataire_id',
         'loyer_autres.date as date_loyer',
        'loyer_autres.statut as loyer_statut',
        'locataires.nom as locataire_nom',
        'locataires.prenom as locataire_prenom',
        'locataires.numero as locataire_tel'
    )
    ->get();

        // Retouner les résultats
        return $tousBiens;
    }

    public static function infoBien()
    {
          
    $tousAppartements = DB::table('appartements')
    ->join('immeubles', 'immeubles.id', '=', 'appartements.id_immeuble')
    ->leftJoin('location_aps', 'location_aps.id_appartement', '=', 'appartements.id')
    ->leftJoin('locataires', 'locataires.id', '=', 'location_aps.id_locataire')
    ->select(
        'appartements.id as appartement_id',
        'appartements.numero as numero',
        'immeubles.adresse',
        'immeubles.ville',
        'immeubles.province',
        'immeubles.id as immeuble_id',
        'immeubles.nom_immeuble as immeuble_nom',
        'location_aps.id as location_id',
        'location_aps.date_debut',
        'location_aps.date_fin',
        'locataires.id as locataire_id',
        'locataires.nom as locataire_nom',
        'locataires.prenom as locataire_prenom',
        'locataires.numero as locataire_telephone',
        DB::raw("CASE WHEN location_aps.id IS NULL THEN 'Libre' ELSE 'Occupé' END as statut_appartement")
    )
    ->get();


    
            $autres_bien = DB::table('autre_biens')
    ->leftJoin('galeries', 'galeries.id', '=', 'autre_biens.id_galerie')
    ->leftJoin('location_autres', 'location_autres.id_autre_bien', '=', 'autre_biens.id')
    ->leftJoin('locataires', 'locataires.id', '=', 'location_autres.id_locataire')
    ->select(
        'galeries.id as galerie_id',
        'galeries.nom_galerie as galerie_nom',
        'galeries.adresse',
        'galeries.ville',
        'galeries.province',
        'autre_biens.id as bien_id',
        'autre_biens.nom as bien_nom',
        'autre_biens.type',
        'location_autres.date_debut',
        'location_autres.date_fin',
        'locataires.id as locataire_id',
        'locataires.nom as locataire_nom',
        'locataires.prenom as locataire_prenom',
        'locataires.numero as locataire_tel',
            DB::raw("CASE WHEN location_autres.id IS NULL THEN 'Libre' ELSE 'Occupé' END as statut_appartement")
    )
    ->get();


    return [$tousAppartements,$autres_bien];


    }


    
    
}
