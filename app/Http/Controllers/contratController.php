<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\immeuble;
use App\Models\locataire;
use Illuminate\Support\Facades\DB;
use App\Models\galerie;
use App\Models\garantie_appart;
use App\Models\garantie_autre;
use App\Models\autre_bien;

use App\Models\location_ap;
use App\Models\location_autre;

use Illuminate\Support\Facades\View;
use App\Models\appartement;

class contratController extends Controller
{
    public function create($id_type_bien,$nom_bien,$bien,$locataire){

        $monBien="";

        if($id_type_bien=="1"){
            $monBien="Immeuble";

        }else{
            $monBien="Galerie";

        }

        if($id_type_bien=="1"){
            $immeuble=immeuble::where('id',$nom_bien )->get()[0];
            $numeroAppart=appartement::where('id',$bien)->get()[0];
            $locatair=locataire::where('id',$locataire)->get()[0];

        
            return View("contrat.create",["donnee"=>[
                "monBien"=>[$monBien,$id_type_bien],
                "immeuble"=>[$immeuble->nom_immeuble,$nom_bien],
                "numeroAppart"=>[$numeroAppart->numero,$bien],
                "locatair"=>[$locatair->nom." ".$locatair->post_nom." ".$locatair->prenom,$locataire]
            ] ]);
        }else{
            $immeuble=galerie::where('id',$nom_bien )->get()[0];

            $numeroAppart=autre_bien::where('id',$bien)->get()[0];
            $locatair=locataire::where('id',$locataire)->get()[0];

        
            return View("contrat.create",["donnee"=>[
                "monBien"=>[$monBien,$id_type_bien],
                "immeuble"=>[$immeuble->nom_galerie,$nom_bien],
                "numeroAppart"=>[$numeroAppart->nom,$bien],
                "locatair"=>[$locatair->nom." ".$locatair->post_nom." ".$locatair->prenom,$locataire]
            ] ]);
          

        }
        

    }

    public function save(Request $request){

        if($request->input("type")=="1"){

            location_ap::create([
                'date_debut'=>date('Y-m-d'),
                'garantie'=>$request->input("garantie"),
                'loyer'=>$request->input("loyer"),
                'id_appartement'=>$request->input("numnom"),
                'id_locataire'=>$request->input("nom")
            ]);
            
            garantie_appart::create([
                "montant_retirer"=>0,
                "montant"=>0,
                "montant_ajouter"=>0,
                "montant_initiale"=>0,
                "date"=>date('Y-m-d'),
                "id_locataire"=>$request->input("nom"),
                "id_appartement"=>$request->input("numnom")


            ]);

            DB::table('appartements')

            ->where('id',$request->input("numnom"))
 
            ->update(['status' =>1 ]);
            



        }else{
            

            location_autre::create([
                'date_debut'=>date('Y-m-d'),
                'garantie'=>$request->input("garantie"),
                'loyer'=>$request->input("loyer"),
                'id_autre_bien'=>$request->input("numnom"),
                'id_locataire'=>$request->input("nom")

            ]);
            $enregistrement = autre_bien::find($request->input("numnom"));
            $enregistrement->nom = $request->input("nom_modifier_autre");
            $enregistrement->save();
              
            garantie_autre::create([
                "montant_retirer"=>0,
                "montant_ajouter"=>0,
                "montant_initiale"=>0,
                "montant"=>0,
                "date"=>date('Y-m-d'),
                "id_locataire"=>$request->input("nom"),
                "id_autre_bien"=>$request->input("numnom")


            ]);
            

            DB::table('autre_biens')

            ->where('id', $request->input("numnom"))
 
            ->update(['status' =>1 ]);



        }

        return redirect()->route("locataire.index");

        

    }

    public function resilier($id_locataire ,$id_bien,$id_type_bien){

       


        if($id_type_bien==1){
           

            DB::table('location_aps')

            ->where('id_locataire',$id_locataire )
            ->where('id_appartement', $id_bien)
            ->update(['date_fin' =>date('Y-m-d') ]);

            DB::table('appartements')

            ->where('id',$id_bien )
 
            ->update(['status' =>0 ]);



        } else  if($id_type_bien==2){

            DB::table('location_autres')

            ->where('id_locataire',$id_locataire )
            ->where('id_autre_bien', $id_bien)
            ->update(['date_fin' =>date('Y-m-d') ]);


            DB::table('autre_biens')

            ->where('id',$id_bien )
 
            ->update(['status' =>0 ]);


        }

        return redirect()->route("locataire.index");



    }

    
}
