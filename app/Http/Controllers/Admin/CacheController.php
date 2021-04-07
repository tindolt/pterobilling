<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class CacheController extends Controller
{
    public function __invoke()
    {
        Artisan::call('config:cache');
        Artisan::call('queue:restart');
        Artisan::call('queue:work --sansdaemon --tries=3');
        
        return back()->with('success_msg', 'Cleared cache files, cached configurations, and restarted queue workers successfully!');
    }
}
