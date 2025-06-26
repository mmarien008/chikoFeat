<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loyer_autre extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = ['montant', 'date', 'statut', 'id_locataire','id_autre_bien'];
}
