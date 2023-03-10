<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignat extends Model
{
    use HasFactory;
    protected $fillable=[
        'nom',
        'prenom',
        'adress',
        'image',
        'name_img'
    ];
}
