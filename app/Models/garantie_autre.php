<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class garantie_autre extends Model
{
    use HasFactory;
    protected $fillable = ['montant_retirer','montant_ajouter', 'montant', 'date', 'id_locataire','id_autre_bien','montant_initiale'];
}
