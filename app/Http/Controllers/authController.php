<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Illuminate\Http\Request;

class authController extends Controller
{
    
    public function login(){

        return View("login.login");
    
    }

    public function Tologin(Request $request)
    {

       



        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        


        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            // Si l'utilisateur est authentifié, régénérer la session pour prévenir la fixation de session
            $request->session()->regenerate();
        
            // Vous pouvez récupérer l'utilisateur connecté via Auth::user()
            $user = Auth::user(); // L'utilisateur actuellement connecté
        
            // Vérifiez le rôle de l'utilisateur et redirigez en fonction
            if ($user->role =="admin") {
                return redirect()->route('admin.dashboard.index');
            } else {
                return redirect()->route('propriete.create');
            } 
        } else {
            // Si l'authentification échoue
            return back()->withErrors(['phone' => 'Les identifiants sont incorrects.']);
        }
        
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
       

      

        return redirect()->route('login') ;
    }




}
