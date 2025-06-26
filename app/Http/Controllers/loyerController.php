<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\locataire;
use App\Models\immeuble;
use App\Models\galerie;
use App\Models\loyer_app;
use App\Models\loyer_autre;


use Illuminate\Support\Facades\DB;

class loyerController extends Controller
{
    public function create(){

        return View("loyer.create",["mes_biens" =>["locataires"=>locataire::all()]]);
    }
    public function save(Request $request){

        if($request->input("type")=="1"){

            if($request->input("status_payement")==0){

                $status=0;
                $montant=0;
                    
                if($request->input("montant_loyer") ==null){
                    $status=1;
                    $montant=$request->input("loyer");
                }else{
                    if($request->input("montant_loyer") < $request->input("loyer")){
                        $status=-1;
                        $montant=$request->input("montant_loyer");
                    }

                }

                loyer_app::create(['montant'=> $montant,
                'id_locataire'=>$request->input("id_locataire"),
                'id_appartement'=>$request->input("id_numNom"),
                'statut'=>$status,'date'=>date('Y-m-d')]);

            }else{
             
                DB::table('garantie_apparts')
                ->where('id_appartement', '=', $request->input("id_numNom"))
                ->where('id_locataire', '=', $request->input("id_locataire"))
                ->update([
                    'montant' => DB::raw("montant - " . $request->input("loyer")),
                    'montant_retirer' => DB::raw("montant_retirer + ".$request->input("loyer")),
                    'updated_at' => now()
                ]);


                loyer_app::create(['montant'=> $request->input("loyer"),
                'id_locataire'=>$request->input("id_locataire"),
                'id_appartement'=>$request->input("id_numNom"),
                'statut'=>1,'date'=>date('Y-m-d')]);



            }

        }else{


            if($request->input("status_payement")==0){
                    $status=0;
                    $montant=0;
                        
                    if($request->input("montant_loyer") ==null){
                        $status=1;
                        $montant=$request->input("loyer");
                    }else{
                        if($request->input("montant_loyer") < $request->input("loyer")){
                            $status=-1;
                            $montant=$request->input("montant_loyer");
                        }

                    }

                    loyer_autre::create(['montant'=>$montant,
                    'id_locataire'=>$request->input("id_locataire"),
                    'id_autre_bien'=>$request->input("id_numNom"),
                    'statut'=>$status,
                    'date'=>date('Y-m-d')
                    
                    ]
                );
             }else{

                

                DB::table('garantie_autres')
                ->where('id_autre_bien', '=', $request->input("id_numNom"))
                ->where('id_locataire', '=', $request->input("id_locataire"))
                ->update([
                    'montant' => DB::raw("montant - " . $request->input("loyer")),
                    'montant_retirer' => DB::raw("montant_retirer + ".$request->input("loyer")),
                    'updated_at' => now()
                ]);


                loyer_autre::create(['montant'=> $request->input("loyer"),
                'id_locataire'=>$request->input("id_locataire"),
                'id_autre_bien'=>$request->input("id_numNom"),
                'statut'=>1,'date'=>date('Y-m-d')]);


             }

           

        }

        

        return View("loyer.create",["mes_biens" =>["locataires"=>locataire::all()]]);

    }


    public function payer($nom_locataire,$type_bien,$numero,$type){

        if($type=="1"){


          



            $informationImmeuble = DB::table('location_aps')
            ->join('locataires', 'locataires.id', '=', 'location_aps.id_locataire')
            ->join('appartements', 'appartements.id', '=', 'location_aps.id_appartement')
            ->join('immeubles', 'immeubles.id', '=', 'appartements.id_immeuble')
            ->join('garantie_apparts', function ($join) {
                $join->on('appartements.id', '=', 'garantie_apparts.id_appartement')
                     ->on('locataires.id', '=', 'garantie_apparts.id_locataire'); // Ajout de la double condition
            })

            ->leftJoin('loyer_apps', function ($join)  {
                $join->on('locataires.id', '=', 'loyer_apps.id_locataire')
                     ->on('appartements.id', '=', 'loyer_apps.id_appartement');
                   
            })




            ->select(
                'locataires.id',
                'garantie_apparts.id as id_garantie',
                'garantie_apparts.montant',
                'loyer_apps.date',
                'locataires.nom',
                'locataires.post_nom',
                'locataires.prenom',
                'appartements.numero',
                'location_aps.loyer',
                'location_aps.garantie',
                'immeubles.nom_immeuble  as nom_type',
                'location_aps.date_debut',
                DB::raw("'Immeuble' as type")

            )
            ->where('locataires.id', '=', $nom_locataire) 
            ->where('appartements.id', '=', $numero) 
            ->where('immeubles.id', '=', $type_bien) 
            ->get()[0];
           

            return View("loyer.payement",["valeurs"=>[$informationImmeuble,[$nom_locataire,$numero,1]]]);


        }else if($type=="2"){

            $GalerieAvecDetails = DB::table('location_autres')
            ->join('locataires', 'locataires.id', '=', 'location_autres.id_locataire')
            ->join('autre_biens', 'autre_biens.id', '=', 'location_autres.id_autre_bien')
            ->join('galeries', 'galeries.id', '=', 'autre_biens.id_galerie')

            ->join('garantie_autres', function ($join) {
                $join->on('autre_biens.id', '=', 'garantie_autres.id_autre_bien')
                     ->on('locataires.id', '=', 'garantie_autres.id_locataire'); // Ajout de la double condition
            })


            ->leftJoin('loyer_autres', function ($join)   {
                $join->on('locataires.id', '=', 'loyer_autres.id_locataire')
                     ->on('autre_biens.id', '=', 'loyer_autres.id_autre_bien');
                 
            })



            ->select(
                'locataires.nom',
                'garantie_autres.id as id_garantie',
                'garantie_autres.montant',
                'loyer_autres.date',
                'locataires.post_nom',
                'locataires.prenom',
                'autre_biens.nom as numero',
                'location_autres.loyer',
                'location_autres.garantie',
                'location_autres.date_debut',
                'galeries.nom_galerie as nom_type',
                DB::raw("'Galerie' as type")

            )
            ->where('locataires.id', '=', $nom_locataire) 
            ->where('autre_biens.id', '=', $numero) 
            ->where('galeries.id', '=', $type_bien) 
          
            ->get()[0];

           

            return View("loyer.payement",["valeurs"=>[$GalerieAvecDetails,[$nom_locataire,$numero,2]]]);


           

        }

    }

    public function showLocation($id_locataire)  {

     


            $pour_immeuble = DB::table('location_aps')
            ->join('locataires', 'locataires.id', '=', 'location_aps.id_locataire')

            ->join('appartements', 'appartements.id', '=', 'location_aps.id_appartement')
            ->join('immeubles', 'immeubles.id', '=', 'appartements.id_immeuble')
            ->select(
                'immeubles.id as id_immeuble',
                'appartements.id as id_appartement',
                'locataires.id as id_locataire',
                'immeubles.nom_immeuble',
                'locataires.nom',
                'locataires.post_nom',
                'locataires.prenom',
                'appartements.numero',
                'location_aps.loyer',
                'location_aps.garantie',
                'location_aps.date_debut'

            ) 
            ->where('locataires.id', '=', $id_locataire)
            ->get();

           
     
       
            $pour_galerie = DB::table('location_autres')
                ->join('locataires', 'locataires.id', '=', 'location_autres.id_locataire')
                ->join('autre_biens', 'autre_biens.id', '=', 'location_autres.id_autre_bien')
                ->join('galeries', 'galeries.id', '=', 'autre_biens.id_galerie')
                ->select(
                    'galeries.id as id_galerie',
                'autre_biens.id as id_autre_bien',
                'locataires.id as id_locataire',
                    'locataires.nom',
                    'galeries.nom_galerie',
                    'locataires.post_nom',
                    'locataires.prenom',
                    'autre_biens.nom as numero',
                    'location_autres.loyer',
                    'location_autres.garantie',
                    'location_autres.date_debut'
                )
                ->where('locataires.id', '=', $id_locataire) // Condition sur le nom_galerie
                ->get();

return View("loyer.create",["mes_biens" =>["pour_immeubles"=>$pour_immeuble,"locataires"=>locataire::all(),"pour_galerie"=> $pour_galerie]]);

    
    }

    public function show($type)  {
        
   

        if($type=="1"){

            $data = ['message' => 'immeuble', 'input' => immeuble::all()];

        return response()->json($data);

        }else if($type=="2"){
            $data = ['message' => 'galerie', 'input' => galerie::all()];

        return response()->json($data);

        }

    }

    public function showdetaille($type,$nom,$dates)  {



        if($type=="1"){

            $immeublesAvecDetails = DB::table('location_aps')
            ->join('locataires', 'locataires.id', '=', 'location_aps.id_locataire')
            ->join('appartements', 'appartements.id', '=', 'location_aps.id_appartement')
            ->join('immeubles', 'immeubles.id', '=', 'appartements.id_immeuble')
            ->leftJoin('loyer_apps', function ($join) use ($dates) {
                $join->on('locataires.id', '=', 'loyer_apps.id_locataire')
                     ->on('appartements.id', '=', 'loyer_apps.id_appartement')
                     ->where('loyer_apps.date', 'LIKE', $dates.'%');
            })
            ->select(
                'loyer_apps.montant as montant',
                'loyer_apps.date',
                'loyer_apps.statut',
                'loyer_apps.id_locataire',
                'loyer_apps.id_appartement',

                'locataires.nom',
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

         

            $data = ['message' => 'immeuble', 'input' => $immeublesAvecDetails];

        return response()->json($data);
     
          
           
        }else if($type=="2"){

            $immeublesAvecDetails = DB::table('location_autres')
            ->join('locataires', 'locataires.id', '=', 'location_autres.id_locataire')

            ->join('autre_biens', 'autre_biens.id', '=', 'location_autres.id_autre_bien')
            ->join('galeries', 'galeries.id', '=', 'autre_biens.id_galerie')
            ->leftJoin('loyer_autres', function ($join) {
                $join->on('locataires.id', '=', 'loyer_autres.id_locataire')
                     ->on('loyer_autres.id', '=', 'loyer_autres.id_autre_bien')
                     ->where('loyer_autres.date', 'LIKE','%' . date('Y-m') ); 
            })
            ->select(
                'loyer_autres.montant as montant',
                'loyer_autres.date',
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
            dd($immeublesAvecDetails);
            
            $data = ['message' => 'galerie', 'input' => $immeublesAvecDetails];

            return response()->json($data);
         
        

        }




    }


    public function  completerLoyer(  $id_propriete,  $id_bien,$mois){

   

       

        if( $id_propriete==1){

      
            $informationImmeuble = DB::table('location_aps')
                ->join('locataires', 'locataires.id', '=', 'location_aps.id_locataire')
                ->join('appartements', 'appartements.id', '=', 'location_aps.id_appartement')
                ->join('immeubles', 'immeubles.id', '=', 'appartements.id_immeuble')
                ->join('loyer_apps', 'appartements.id', '=', 'loyer_apps.id_appartement')

                ->select(
                    
                    'loyer_apps.date',
                    'appartements.id',
                    'loyer_apps.montant',

                    'locataires.nom',
                    'locataires.post_nom',
                    'locataires.prenom',
                    'appartements.numero',
                    'location_aps.loyer',
                    'location_aps.garantie',
                    'immeubles.nom_immeuble  as nom_type',
                   
                    DB::raw("'Immeuble' as type")

                )
            
                ->where('appartements.id', '=', $id_bien) 
                ->where('loyer_apps.date', 'LIKE',$mois.'%' ) 
            
                ->get()[0];

            return View("loyer.completer",["infoComplete"=>[$informationImmeuble,$mois]]);

    }else if($id_propriete==2){
        $GalerieAvecDetails = DB::table('location_autres')
            ->join('locataires', 'locataires.id', '=', 'location_autres.id_locataire')
            ->join('autre_biens', 'autre_biens.id', '=', 'location_autres.id_autre_bien')
            ->join('galeries', 'galeries.id', '=', 'autre_biens.id_galerie')
            ->Leftjoin('loyer_autres', 'autre_biens.id', '=', 'loyer_autres.id_autre_bien')
            ->select(
                'locataires.nom',
                'loyer_autres.id',
                'loyer_autres.montant',
                'loyer_autres.date',
                'locataires.post_nom',
                'locataires.prenom',
                'autre_biens.nom as numero',
                'location_autres.loyer',
                'location_autres.garantie',
                'location_autres.date_debut',
                'galeries.nom_galerie as nom_type',
                DB::raw("'Galerie' as type")

            )
            ->where('autre_biens.id', '=', $id_bien) 
            ->where('loyer_autres.date', 'LIKE',$mois.'%' ) 
          
            ->get()[0];
            return View("loyer.completer",["infoComplete"=>[ $GalerieAvecDetails,$mois]]);

    }

    }


    public function  completerLoyerEnregistrer( Request $request){

        
        if($request->input("id_type_propriete")=="Immeuble"){
            DB::table('loyer_apps')
            ->where('id_appartement','=',$request->input("id_propriete"))
            ->where('date','LIKE',$request->input("date").'%')
            ->increment('montant',$request->input("montant_loyer"),["updated_at"=>now()]);
    
            if($request->input("montant_loyer")+$request->input("loyer_payer_existant")==$request->input("loye_fixer")+0){
                DB::table('loyer_apps')
                ->where('id_appartement','=',$request->input("id_propriete"))
                ->where('date','LIKE',$request->input("date").'%')
                ->update(['statut'=>1]);
               
            }

        }else if($request->input("id_type_propriete")=="Galerie"){
            DB::table('loyer_autres')
            ->where('id_autre_biens','=',$request->input("id_propriete"))
            ->where('date','LIKE',$request->input("date").'%')
            ->increment('montant',$request->input("montant_loyer"),["updated_at"=>now()]);
    
            if($request->input("montant_loyer")+$request->input("loyer_payer_existant")==$request->input("loye_fixer")+0){
                DB::table('loyer_apps')
                ->where('id_autre_biens','=',$request->input("id_propriete"))
                ->where('date','LIKE',$request->input("date").'%')
                ->update(['statut'=>1]);
               
            }

        }

      

        return View('pdf.create');


    }


}
