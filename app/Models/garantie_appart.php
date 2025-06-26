<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class garantie_appart extends Model
{
    
  
    protected $fillable = ['montant_retirer','montant_ajouter', 'montant', 'date', 'id_locataire','id_appartement','montant_initiale'];
}
