<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class galerie extends Model
{
    use HasFactory;
    protected $fillable = ['nom_galerie', 'ville', 'province', 'adresse','adresse'];

    
}
