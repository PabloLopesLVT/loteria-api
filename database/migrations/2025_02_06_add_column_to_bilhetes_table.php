<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->table('bilhetes', function (Blueprint $table) {    
    $table->boolean('premiado')->default(false)->after('numeros');
    $table->boolean(('status'))->default(false)->after('premiado');
});
