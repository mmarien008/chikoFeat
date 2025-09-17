<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenu_externe extends Model
{
    use HasFactory;
     protected $fillable = ['motif','montant', 'date','user_id'];
}
