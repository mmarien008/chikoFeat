<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Revenu_externe;

class RevenuExterneController extends Controller
{

     public function index (){

        $revenu_externe= Revenu_externe::all();

        return view('caisse.index',compact("revenu_externe"));

    }
    public function store(Request $request){

         try {

            Revenu_externe::create($request->all());
    
            return View("propriete.create");

        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->with('error', 'erreur lors de l enregistrement');
        }

         

        }
   
}
