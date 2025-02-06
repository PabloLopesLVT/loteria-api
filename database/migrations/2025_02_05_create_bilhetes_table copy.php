<?php

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->dropIfExists('bilhetes');

Capsule::schema()->create('bilhetes', function ($table) {
    $table->id();
    $table->json('numeros')->nullable();
    $table->timestamps();
});
