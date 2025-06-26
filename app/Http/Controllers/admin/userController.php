<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class userController extends Controller
{
    public function create (){

        return View("admin.user.create");

    }

    public function store (Request $request){

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:6',
        ]);
    
        // Création de l'utilisateur
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'password' => $validatedData['password'],
        ]);
    
        // Redirection avec message de succès
        return redirect()->route('admin.user.index')->with('success', 'Utilisateur créé avec succès.');

    }

    public function index (){

     
        $users = User::all();

    // Passer les utilisateurs à la vue
    return view('admin.user.index', compact('users'));

    }

    public function destroy($id)
    {
        // Vérifie si l'utilisateur existe
        $user = User::findOrFail($id);

        // Supprime l'utilisateur
        $user->delete();

        // Redirige vers la liste des utilisateurs avec un message de succès
        return redirect()->route('admin.user.index')->with('success', 'Utilisateur supprimé avec succès');
    }
        // Afficher le formulaire d'édition de l'utilisateur
        public function edit($id)
        {
            // Récupère l'utilisateur par ID
            $user = User::findOrFail($id);
    
            // Retourne la vue avec l'utilisateur
            return view('admin.user.edit', compact('user'));
        }
    
        // Mettre à jour l'utilisateur
        public function update(Request $request, $id)
        {
            //
    
            // Récupère l'utilisateur
            $user = User::findOrFail($id);
    
            // Mettre à jour les informations de l'utilisateur
            $user->name = $request->input("name");
       
            $user->phone = $request->input("phone");
    
            // Si un mot de passe est fourni, on le hache et le met à jour
            if ($request->password) {
                $user->password = $request->input("password");
            }
    
            // Sauvegarde les modifications
            $user->save();

    
            // Redirige avec un message de succès
            return redirect()->route('admin.user.index')->with('success', 'Utilisateur mis à jour avec succès');
        }




}
