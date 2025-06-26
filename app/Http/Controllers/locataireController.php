<?php

namespace App\Http\Controllers;

use App\Models\appartement;
use App\Models\galerie;
use App\Models\immeuble;
use Illuminate\Http\Request;
use App\Models\locataire;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;


class locataireController extends Controller
{

    public function create(){



        return view('locataire.create',[
        
            'locataires' => locataire::all()->sortBy('nom')
        ]);
    }



    public function save(Request $request){
     

        $nom=$request->input('nom');
        $post_nom=$request->input('post_nom');
        $prenom=$request->input('prenom');
        $numero=$request->input('numero');



        locataire::create(["nom"=> $nom,"post_nom"=>$post_nom,"prenom"=>$prenom,"numero"=> $numero]);

        return redirect()->route("locataire.create")->with('success', 'Locataire ajouté avec succès.');;

    }

    public function index(){

        return View("locataire.index");

    }

    public function show( $type){

        session(['type_bien_locataire' => $type]);

        if($type=="1"){

            $data = ['message' => 'immeuble', 'input' => immeuble::all()];

        return response()->json($data);

        }else{
            $data = ['message' => 'galerie', 'input' => galerie::all()];

        return response()->json($data);

        }
    }

    public function showdetaille($type,$id_nom){

        $immeublesAvecDetails="";
    
        if($type=="1"){

            $immeublesAvecDetails = DB::table('location_aps')
            ->join('locataires', 'locataires.id', '=', 'location_aps.id_locataire')
            ->join('appartements', 'appartements.id', '=', 'location_aps.id_appartement')
            ->join('immeubles', 'immeubles.id', '=', 'appartements.id_immeuble')
            ->select(
                'locataires.id as id_locataire',
                'appartements.id as id_bien',
                'locataires.nom',
                'location_aps.date_fin',
                'locataires.post_nom',
                'locataires.prenom',
                'appartements.numero',
                'location_aps.loyer',
                'location_aps.garantie',
                'location_aps.date_debut'
            )
            ->where('immeubles.id', '=', $id_nom) 
          
            ->get();

            $data = ['message' => 'immeuble', 'input' => $immeublesAvecDetails];

        return response()->json($data);
     
           
           
        }else if($type=="2"){

         

            $immeublesAvecDetails = DB::table('location_autres')
            ->join('locataires', 'locataires.id', '=', 'location_autres.id_locataire')

            ->join('autre_biens', 'autre_biens.id', '=', 'location_autres.id_autre_bien')
            ->join('galeries', 'galeries.id', '=', 'autre_biens.id_galerie')
            ->select(
                'locataires.id as id_locataire',
                'autre_biens.id as id_bien',
                'locataires.nom',
                'location_autres.date_fin',
                'locataires.post_nom',
                'locataires.prenom',
                'autre_biens.nom as numero',
                'location_autres.loyer',
                'location_autres.garantie',
                'location_autres.date_debut'

            )
            ->where('galeries.id', '=', $id_nom) 
            ->get();

            
         
          

        

            $data = ['message' => 'galerie', 'input' => $immeublesAvecDetails];

            return response()->json($data);
        

        }


    }


  
  
}
