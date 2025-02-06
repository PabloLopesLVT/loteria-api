<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bilhete extends Model
{
    protected $table = 'bilhetes';
    protected $fillable = ['numeros', 'premiado', 'status'];
    public $timestamps = true;
}
