<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class operation extends Model
{
  
  
    use HasFactory;
    protected $fillable = ['id_propriete','type', 'modif', 'montant', 'status','status2','date'];


}
