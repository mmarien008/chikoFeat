<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class operationController extends Controller
{
     
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


        return View("admin.operation.index",["val"=>$op]);
    
    }


    public function valider($id)
        {
            // Mettre à jour le statut d'une opération spécifique (par exemple, `status = 1`)
                DB::table('operations')
                    ->where('id', $id) // Filtrer par l'ID passé en paramètre
                    ->update(['status' => 1,'status2' => -1]); // Mise à jour du champ `status`

         
                return redirect()->route("admin.operation.index");
                
        }

    public function annuler($id){

                    DB::table('operations')
                    ->where('id', $id) // Filtrer par l'ID passé en paramètre
                    ->update(['status' => -1]); // Mise à jour du champ `status`

            

                // Retourner la vue avec les données mises à jour
                return redirect()->route("admin.operation.index");
    
    }

    
    public function NotificationOperation(){

        $val=  DB::table('operations')
        ->where('status', 0) 
        ->get();

      

        $data = ['message' => 'galerie', 'input' =>$val ];

        return response()->json($data);

    }

    
}
