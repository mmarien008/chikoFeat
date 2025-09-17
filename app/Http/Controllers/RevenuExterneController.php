<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Revenu_externe;

class RevenuExterneController extends Controller
{

     public function index (){

        $revenu_externes= Revenu_externe::all();
        return view('caisse.index',compact("revenu_externes"));

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
   
}
