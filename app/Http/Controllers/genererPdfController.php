<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use App\Models\immeuble;
use App\Models\galerie;

use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class genererPdfController extends Controller
{
    public function create(){

        return View("pdf.create");

    }
    public function generer(){

        $data = [
            'title' => 'Titre de votre PDF',
            'content' => 'Ceci est un exemple de contenu pour le PDF.',
        ];
    
        $pdf = FacadePdf ::loadView('pdf.example', $data);
    
        return $pdf->stream('document.pdf');

    }

    public function show($type){


        if($type=="1"){

            $data = ['message' => 'immeuble', 'input' => immeuble::all()];

        return response()->json($data);

        }else if($type=="2"){
            $data = ['message' => 'galerie', 'input' => galerie::all()];

        return response()->json($data);

        }
    }

    public static function afficherMoisEntre($dateDebut,$date) {

        
        // Convertir la date de début en objet DateTime
        $debut = new DateTime($dateDebut);
        // Obtenir la date actuelle
        $actuel = new DateTime($date);
    
        // Vérifier si la date de début est après la date actuelle
        if ($debut > $actuel) {
            return [""];
        }
    
        // Tableau pour stocker les mois
        $moisEntre = [];
    
        // Parcourir chaque mois entre les deux dates
        while ($debut <= $actuel) {
            // Ajouter le mois et l'année au tableau (format uniforme Y-m-d)
            $moisEntre[] = $debut->format('Y-m');
            // Passer au mois suivant
            $debut->modify('+1 month');
        }
    
        // Retourner le tableau des mois
        return $moisEntre;
    }
    
    
    
    // Appeler la fonction avec la date de départ
  
    
    static function filtrerEtRetourner(Collection $collection) {



        // Grouper par "numero"
        $grouped = $collection->groupBy(function ($item) {
            return $item->numero . '-' . $item->id;
        });

        
       
        
        // Parcourir chaque groupe pour structurer les données
        $result = $grouped->map(function ($items, $numero) {
            // Vérifier si date_debut n'est pas null avant de la convertir
            $dateDebut = optional($items->first()->date_debut, function ($date) {
                return (new DateTime($date))->format('Y-m');
            });
        
            // Récupérer toutes les dates associées à ce numéro (exclure les nulls, format Y-m)
            $dates = $items->pluck('date')
                ->filter() // Supprime les valeurs nulles
                ->map(function ($date) {
                    return (new DateTime($date))->format('Y-m');
                })
                ->values() // Réindexer proprement les résultats
                ->toArray();
        
            // Retourner la structure formatée
            return [
                'date_debut' => $dateDebut,
                'dates' => $dates,
            ];
        });

       
        
        // Transformer en tableau clé-valeur pour le retour
        return $result->toArray();
        
    }
    static function customArrayDiff($array1, $array2) {
        $result = [];
    
        foreach ($array1 as $value) {
            // Si la valeur n'est pas trouvée dans le second tableau
            if (!in_array($value, $array2)) {
                $result[] = $value;
            }
        }

    
        return $result;

    }
    
    



    public function genererRapportLoyerMois($type,$nom,$dates){


        $resultat=[];
        if($type=="1"){

            $passee = DB::table('location_aps')
            ->join('locataires', 'locataires.id', '=', 'location_aps.id_locataire')
            ->join('appartements', 'appartements.id', '=', 'location_aps.id_appartement')
            ->join('immeubles', 'immeubles.id', '=', 'appartements.id_immeuble')
            ->leftJoin('loyer_apps', function ($join)  {
                $join->on('locataires.id', '=', 'loyer_apps.id_locataire')
                     ->on('appartements.id', '=', 'loyer_apps.id_appartement');     
            })
            ->select('loyer_apps.date','location_aps.date_debut','appartements.numero','locataires.id')

            ->where('immeubles.id', '=', $nom) 
            ->get();

      

            $mois_filtre= genererPdfController::filtrerEtRetourner($passee);

            

            
            
           
            foreach ($mois_filtre as $key => $value) {
               
                $a= genererPdfController::afficherMoisEntre($value["date_debut"],$dates);
               
                $aff= $value["dates"];
                $intersection= genererPdfController::customArrayDiff($a, $aff);
               // $intersection = array_diff($a, $aff);
                $resultat[]=$intersection;

            }
            
         

            $immeublesAvecDetails = DB::table('location_aps')
            ->join('locataires', 'locataires.id', '=', 'location_aps.id_locataire')
            ->join('appartements', 'appartements.id', '=', 'location_aps.id_appartement')
            ->join('immeubles','immeubles.id', '=', 'appartements.id_immeuble')
            ->join('garantie_apparts', function ($join) {
                $join->on('appartements.id', '=', 'garantie_apparts.id_appartement')
                     ->on('locataires.id', '=', 'garantie_apparts.id_locataire'); // Ajout de la double condition
            })

            ->leftJoin('loyer_apps', function ($join) use ($dates) {
                $join->on('locataires.id', '=', 'loyer_apps.id_locataire')
                     ->on('appartements.id', '=', 'loyer_apps.id_appartement')
                     ->where('loyer_apps.date', 'LIKE', $dates.'%'  ); 
            })
            ->select(
                
              
                'loyer_apps.date',
                'immeubles.nom_immeuble as nom_bien',
                'location_aps.date_fin',
                'garantie_apparts.montant_initiale',
                'garantie_apparts.montant_ajouter',
                'garantie_apparts.montant_retirer',

                'garantie_apparts.montant as solde_garantie',

                'immeubles.ville',
                'immeubles.province',
                'immeubles.adresse',

                'loyer_apps.montant',
                'loyer_apps.id_locataire',
                'loyer_apps.id_appartement',
                'locataires.nom',
                'appartements.id',
                'locataires.post_nom',
                'locataires.prenom',
                'appartements.numero',
                'location_aps.loyer',
                'location_aps.garantie',
                'location_aps.date_debut',
                DB::raw('CASE 
                WHEN loyer_apps.id_locataire IS NULL  AND loyer_apps.id_appartement IS NULL THEN "0"
                    WHEN loyer_apps.statut = -1 THEN "-1"
                ELSE "1"
             END as statut_loyer')
            )
            ->where('immeubles.id', '=', $nom) 
            ->get();

      



            $data = ['message' => 'immeuble',
             'input' => $immeublesAvecDetails,'dif'=>$resultat,"date"=>$dates ];

            session(['rapport' => $data]);
            return response()->json($data);

           
        }else if($type=="2"){

            $passee = DB::table('location_autres')
            ->join('locataires', 'locataires.id', '=', 'location_autres.id_locataire')
            ->join('autre_biens', 'autre_biens.id', '=', 'location_autres.id_autre_bien')
            ->join('galeries', 'galeries.id', '=', 'autre_biens.id_galerie')

            ->join('garantie_autres', function ($join) {
                $join->on('autre_biens.id', '=', 'garantie_autres.id_autre_bien')
                     ->on('locataires.id', '=', 'garantie_autres.id_locataire'); // Ajout de la double condition
            })


            ->leftJoin('loyer_autres', function ($join) use ($dates)  {
                $join->on('locataires.id', '=', 'loyer_autres.id_locataire')
                     ->on('autre_biens.id', '=', 'loyer_autres.id_autre_bien')
                     ->where('loyer_autres.date', 'LIKE', $dates.'%'  ); ;
                 
            })
            ->select('loyer_autres.date',
            'location_autres.date_debut','autre_biens.nom as numero')
            ->where('galeries.id', '=', $nom) 
            ->get();

            $mois_filtre= genererPdfController::filtrerEtRetourner($passee);
           
            foreach ($mois_filtre as $key => $value) {
                $a= genererPdfController::afficherMoisEntre($value["date_debut"],$dates);
                $aff= $value["dates"];
                
            
              $intersection = array_diff($a, $aff);

              $resultat[]=$intersection;

             
            }

            $immeublesAvecDetails = DB::table('location_autres')
            ->join('locataires', 'locataires.id', '=', 'location_autres.id_locataire')
            ->join('autre_biens', 'autre_biens.id', '=', 'location_autres.id_autre_bien')
            ->join('galeries', 'galeries.id', '=', 'autre_biens.id_galerie')
            ->join('garantie_autres','autre_biens.id', '=', 'garantie_autres.id_autre_bien')

            ->leftJoin('loyer_autres', function ($join) use ($dates)  {
                $join->on('locataires.id', '=', 'loyer_autres.id_locataire')
                     ->on('autre_biens.id', '=', 'loyer_autres.id_autre_bien')
                     ->where('loyer_autres.date', 'LIKE',$dates.'%' ); 
            })
            ->select(
             
                'galeries.nom_galerie as nom_bien ',
                'loyer_autres.date',
                'galeries.ville',
                'galeries.province',
                'galeries.adresse',
                'location_autres.date_fin',
                'garantie_autres.montant_initiale',
                'garantie_autres.montant_ajouter',
                'garantie_autres.montant_retirer',

                'garantie_autres.montant as solde_garantie',

                'autre_biens.id',
                'autre_biens.type',
                'loyer_autres.montant',
                'locataires.nom',
                'locataires.post_nom',
                'locataires.prenom',
                'autre_biens.nom as numero',
                'location_autres.loyer',
                'location_autres.garantie',
                'location_autres.date_debut',
                DB::raw('CASE 
                WHEN loyer_autres.id_locataire IS NULL AND loyer_autres.id_autre_bien IS NULL THEN "0"
                    WHEN loyer_autres.statut = -1 THEN "-1"
                ELSE "1"
             END as statut_loyer')

            )
            ->where('galeries.id', '=', $nom) 
            ->get();

            $data = ['message' => 'galerie', 'input' => $immeublesAvecDetails,
            'dif' =>$resultat,"date"=>$dates ];

         
            session(['rapport' => $data]);
            return response()->json($data);

        }



    }




    public function telecharger(Request $request){
       

        

        $pdf = FacadePdf ::loadView('pdf.example', ["valeur"=>Session::get('rapport')]);

        return $pdf->stream('document.pdf');

    }
}
