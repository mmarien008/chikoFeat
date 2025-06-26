<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class location_autre extends Model
{
 

    use HasFactory;
    protected $fillable = ['date_debut', 'garantie', 'loyer', 'id_locataire','id_autre_bien'];
}
