<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class garantieController extends Controller
{


    public function show($id_locataire,$id_type_bien,$id_bien,$type){

        if($type=="1"){

            $informationImmeuble = DB::table('location_aps')
            ->join('locataires', 'locataires.id', '=', 'location_aps.id_locataire')
            ->join('appartements', 'appartements.id', '=', 'location_aps.id_appartement')
            ->join('immeubles', 'immeubles.id', '=', 'appartements.id_immeuble')

            ->join('garantie_apparts', function ($join) {
                $join->on('appartements.id', '=', 'garantie_apparts.id_appartement')
                     ->on('locataires.id', '=', 'garantie_apparts.id_locataire'); // Ajout de la double condition
            })
            

            ->select(
                'locataires.id',
                
                'locataires.nom',
                'location_aps.garantie as garantie',
                'locataires.post_nom',
                'locataires.prenom',
                'appartements.numero',
                'appartements.id as id_bien',
                'garantie_apparts.montant_initiale',
                'garantie_apparts.montant',
                
                'location_aps.garantie',
                'immeubles.nom_immeuble  as nom_type',
                'location_aps.date_debut',
                DB::raw("'Immeuble' as type")

            )
            ->where('locataires.id', '=', $id_locataire) 
            ->where('appartements.id', '=', $id_bien) 
            ->where('immeubles.id', '=', $id_type_bien) 
            ->get()[0];
            return  View("garantie.show",[
                "val"=>$informationImmeuble

            ]);
        
        }else if ($type=="2"){

            $informationImmeuble = DB::table('location_autres')
            ->join('locataires', 'locataires.id', '=', 'location_autres.id_locataire')
            ->join('autre_biens', 'autre_biens.id', '=', 'location_autres.id_autre_bien')
            ->join('galeries', 'galeries.id', '=', 'autre_biens.id_galerie')
            ->join('garantie_autres', function ($join) {
                $join->on('autre_biens.id', '=', 'garantie_autres.id_autre_bien')
                     ->on('locataires.id', '=', 'garantie_autres.id_locataire'); // Ajout de la double condition
            })
            

            ->select(
                'locataires.id',
                'location_autres.garantie',
                'locataires.nom',
                'locataires.post_nom',
                'locataires.prenom',
                'autre_biens.nom as numero',
                'autre_biens.id as id_bien',
                'garantie_autres.montant_initiale',
                'garantie_autres.montant',
                
                'location_autres.garantie',
                'galeries.nom_galerie  as nom_type',
                'location_autres.date_debut',
                DB::raw("'Galerie' as type")

            )
            ->where('locataires.id', '=', $id_locataire) 
            ->where('autre_biens.id', '=', $id_bien) 
            ->where('galeries.id', '=', $id_type_bien) 
            ->get()[0];

            return  View("garantie.show",[
                "val"=>$informationImmeuble

            ]);







        }



    




    }

    public function save(Request $request ){



        if($request->input("type")==1){
            if($request->input("montant_initiale")==0){

                DB::table('garantie_apparts')
                ->where('id_appartement','=',$request->input("id_bien"))
                ->where('id_locataire','=',$request->input("id_locataire"))

                ->update([
                    'montant' => DB::raw("montant + " . $request->input("montant_garantie")),
                    'montant_initiale' => DB::raw("montant_initiale + " . $request->input("montant_garantie")),
                    'updated_at' => now()
                ]);
          
              

               

            }else{
                if($request->input("operation")==1){

                    DB::table('garantie_apparts')
                    ->where('id_appartement', '=', $request->input("id_bien"))
                    ->where('id_locataire', '=', $request->input("id_locataire"))
                    ->update([
                        'montant' => DB::raw("montant + " . $request->input("montant_garantie")),
                        'montant_ajouter' => DB::raw("montant_ajouter + " . $request->input("montant_garantie")),
                        'updated_at' => now()
                    ]);
                    
                }
                else if($request->input("operation")==2){

                    DB::table('garantie_apparts')
                    ->where('id_appartement', '=', $request->input("id_bien"))
                    ->where('id_locataire', '=', $request->input("id_locataire"))
                    ->update([
                        'montant' => DB::raw("montant - " . $request->input("montant_garantie")),
                        'montant_retirer' => DB::raw("montant_retirer + " . $request->input("montant_garantie")),
                        'updated_at' => now()
                    ]);

                }

            }

        }else if($request->input("type")==2){
            if($request->input("montant_initiale")==0){
                DB::table('garantie_autres')
                ->where('id_autre_bien','=',$request->input("id_bien"))
                ->where('id_locataire','=',$request->input("id_locataire"))
                ->update([
                    'montant' => DB::raw("montant + " . $request->input("montant_garantie")),
                    'montant_initiale' => DB::raw("montant_initiale + " . $request->input("montant_garantie")),
                    'updated_at' => now()
                ]);


            }else{

                if($request->input("operation")==1){

                    DB::table('garantie_autres')
                    ->where('id_autre_bien', '=', $request->input("id_bien"))
                    ->where('id_locataire', '=', $request->input("id_locataire"))
                    ->update([
                        'montant' => DB::raw("montant + " . $request->input("montant_garantie")),
                        'montant_ajouter' => DB::raw("montant_ajouter + " . $request->input("montant_garantie")),
                        'updated_at' => now()
                    ]);
                    
                }
                else if($request->input("operation")==2){

                    DB::table('garantie_apparts')
                    ->where('id_autre_bien', '=', $request->input("id_bien"))
                    ->where('id_locataire', '=', $request->input("id_locataire"))
                    ->update([
                        'montant' => DB::raw("montant - " . $request->input("montant_garantie")),
                        'montant_retirer' => DB::raw("montant_retirer + " . $request->input("montant_garantie")),
                        'updated_at' => now()
                    ]);

                }

            }


        }

        return Redirect()->route("loyer.create");

    }
    




}
