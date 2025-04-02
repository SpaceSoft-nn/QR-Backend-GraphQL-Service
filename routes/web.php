<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return view('welcome');
});

Route::get('/graphql', function () {

    $url = url('api/graphql/');  // URL для запросов GraphQL
    $subscriptionUrl = url('/graphql/subscriptions');  // URL для подписок GraphQL, измените по необходимости
    return view('graphql', compact('url', 'subscriptionUrl'));

});

