<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class PageController extends Controller
{
    public $pageTitle;

    public function __invoke()
    {
        switch (Route::currentRouteName()) {
            case 'home':
                $this->pageTitle = 'Home';
                break;
            case 'status':
                $this->pageTitle = 'System Status';
                break;
            case 'terms':
                $this->pageTitle = 'Terms of Service';
                break;
            case 'privacy':
                $this->pageTitle = 'Privacy Policy';
                break;
            default:
                return abort(404);
        }
        
        return view('store.page', ['title' => $this->pageTitle, 'body' => config('page.' . Route::currentRouteName())]);
    }
}
