<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\operation;
use Illuminate\Support\Facades\DB;

class operationController extends Controller
{

    public function create(){

        return View("operation.create");
    
    }

    
    public function index(){

      $op = DB::table('operations')
                        ->leftJoin('appartements', function ($join) {
                            $join->on('appartements.id', '=', 'operations.id_propriete')
                                 ->where('operations.type', '=', 1);
                        })
                        ->leftJoin('immeubles', 'immeubles.id', '=', 'appartements.id_immeuble')
                        ->leftJoin('autre_biens', function ($join) {
                            $join->on('autre_biens.id', '=', 'operations.id_propriete')
                                 ->where('operations.type', '=', 2);
                        })
                        ->leftJoin('galeries', 'galeries.id', '=', 'autre_biens.id_galerie')
                        ->select(
                            'operations.id',
                            'operations.modif',
                            'operations.type',
                            'operations.montant',
                            'operations.date',
                            'operations.status',
                            'operations.status2',
                            DB::raw("
                                CASE 
                                    WHEN operations.type = 1 THEN CONCAT('Appartement ', appartements.numero, ' immeuble ', immeubles.nom_immeuble)
                                    WHEN operations.type = 2 THEN CONCAT(autre_biens.nom, ' Galerie ', galeries.nom_galerie)
                                    ELSE ''
                                END as numero
                            ")
                        )
                        ->get();

        return View("operation.index",["val"=>$op]);
    
    }

    public function terminer($id){

         // Mettre à jour le statut d'une opération spécifique (par exemple, `status = 1`)
         DB::table('operations')
         ->where('id', $id) // Filtrer par l'ID passé en paramètre
         ->update(['status2' => 1]); // Mise à jour du champ `status`

     // Récupérer toutes les opérations après mise à jour
     $op = DB::table('operations')
         ->select('id', 'modif', 'type', 'montant', 'date', 'status','status2') // Colonnes spécifiques
         ->get();

     // Retourner la vue avec les données mises à jour
     return redirect()->route("operation.index");

    }
   

    public function save(Request $request){

        if($request->input("type_propriete")=="-1"){
            operation::create([
            "modif"=>$request->input("motif"),
            "montant"=>$request->input("montant"),
            "status"=>0,
            "status2"=>0,
            "date"=>date('Y-m-d')]);

        }else{
            operation::create(["id_propriete"=>$request->input("contenue"),
            "type"=>$request->input("type_propriete"),
            "modif"=>$request->input("motif"),
            "montant"=>$request->input("montant"),
            "status"=>0,
            "status2"=>0,
            "date"=>date('Y-m-d')]);


        }
     


        return View("operation.create");
    
    }

    
}
