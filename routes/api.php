<?php

use Illuminate\Support\Facades\Route;
use Nuwave\Lighthouse\Support\Http\Controllers\GraphQLController;

Route::post('/graphql', [GraphQLController::class, 'query']);
