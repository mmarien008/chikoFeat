<?php

namespace App\Http\Controllers;
use App\Models\appartement;
use App\Models\autre_bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\immeuble;
use Illuminate\Support\Facades\DB;
use App\Models\locataire;
use App\Models\galerie;
use Illuminate\Support\Facades\Session;



class proprieteController extends Controller

{
    public function create(){

        return View("propriete.create");

    }
    public function index (){



        return view('propriete.index');


    }
    

    public function save(Request $request)
    {
        // Validation des données d'entrée
       
    
        $type_bien = $request->input('type_bien');
        $nom = $request->input('nom');
        $adresse = $request->input('adresse');
        $ville = $request->input('ville');
        $province = $request->input('province');
    
        if ($type_bien == "1") {
            // Création de l'immeuble
            $immeuble = Immeuble::create([
                
                'nom_immeuble' => ucfirst(strtolower($nom)),
                'ville' => ucfirst(strtolower($ville)),
                'province' => ucfirst(strtolower($province)),
                'adresse' => ucfirst(strtolower($adresse)),

                'nombre_appartement' => count($request->input('appart', [])),
            ]);
    
            // Création des appartements associés
            foreach ($request->input('appart') as $numero) {
                Appartement::create([
                    
                    'numero' => ucfirst(strtolower($numero)),
                    'status' => "0",
                    'loyer' => 0,
                    'garantie' => 0,
                    'id_immeuble' => $immeuble->id,
                ]);
            }
        } elseif ($type_bien == "2") {
            // Création de la galerie
            $galerie = galerie::create([
                'nom_galerie' => $nom,
                'status' => "0",
                'ville' => $ville,
                'province' => $province,
                'adresse' => $adresse,
            ]);
           
    
            // Types de biens pour la galerie
            $types = ['Magasin', 'Depot', 'Etalage'];
            $autres = $request->input('autre', []);
    
            foreach ($types as $index => $type) {
                if (isset($autres[$index])) {
                    for ($j = 0; $j < (int) $autres[$index]; $j++) {
                        autre_bien::create([
                            'nom' => $type . ($j + 1),
                            'loyer' => 0,
                            'garantie' => 0,
                            'status' => "0",
                            'type' => $type,
                            'id_galerie' => $galerie->id,
                        ]);
                    }
                }
            }
            
        }

        return redirect()->route('propriete.create')->with('success', 'Propriété ajoutée avec succès.');
    }
    



    

    public function show($id){
       


        if($id=="1"){

            $data = ['message' => 'immeuble', 'input' => immeuble::all()];

        return response()->json($data);

        }else{
            $data = ['message' => 'galerie', 'input' => galerie::all()];

        return response()->json($data);

        }

/*
        if($id == 1){
        
            return view('locataire.create',[
                'proprietes' => [
                    'immeubles' => immeuble::all(),
                    'locataires' => locataire::all()
                ]
            ]);
        }else{
            return view('locataire.create',[
                'proprietes' => [
                    'galeries' => galerie::all(),
                    'locataires' => locataire::all()
                ]
            ]);
        }
        */

    }
    public function show_detaille($id,$nom_propriete){

     
        if($id == 1){
        
        $disponibles = DB::table('appartements')
        ->join('immeubles', 'immeubles.id', '=', 'appartements.id_immeuble')



        // Vérifie que l'appartement n'est pas loué
        ->where('immeubles.id', '=', $nom_propriete)
        ->where('appartements.status', '=', "0") // Filtre par l'ID de l'immeuble
        ->select('appartements.*') // Ajouter les colonnes nécessaires
        ->get();

        
        $data = ['message' => 'immeuble', 'input' =>  $disponibles];

        return response()->json($data);

        
        
        }else if($id == 2){
            $disponibles = DB::table('autre_biens')
            ->join('galeries', 'galeries.id', '=', 'autre_biens.id_galerie')
           
             // Vérifie que l'appartement n'est pas loué
             ->where('galeries.id', '=', $nom_propriete)
            ->where('autre_biens.status', '=', "0") // Filtre par l'ID de galerie
            ->select('autre_biens.*') // Ajouter les colonnes nécessaires
            ->get();

        
        

            $data = ['message' => 'galerie', 'input' =>  $disponibles];

            return response()->json($data);

           
        }

    }

    public function show_detaille_all(){

    }



}
