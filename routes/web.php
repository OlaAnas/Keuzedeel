<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Laravel is alive 🟢';
});
require __DIR__.'/auth.php';