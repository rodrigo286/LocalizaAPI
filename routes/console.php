<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('workshop:about', function () {
    $this->info('Localiza Workshop API - ambiente fictício para treinamento.');
});
