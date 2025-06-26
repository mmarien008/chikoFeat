<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class autre_bien extends Model
{
    use HasFactory;
    protected $fillable=["nom","loyer","garantie","id_galerie","type","status"];


     
}
