<?php

use Illuminate\Http\Request;

app('router')
    ->middleware('auth:sanctum')
    ->get('/user', fn (Request $request) => api_response($request->user()));

app('router')->get('/', fn () => api_response('ok'));
