<?php

use Illuminate\Support\Facades\Route;

/**
 * For internal use
 */
// Send an API request to the Pterodactyl panel
Route::get('/pterodactyl/{api_key}/{action}/{method}/{fields?}', 'Api\PterodactylApiController');
