<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class immeuble extends Model
{
    use HasFactory;
    

    protected $fillable = ['nom_immeuble', 'ville', 'province', 'adresse','nombre_appartement'];


}
