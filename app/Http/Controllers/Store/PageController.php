<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class PageController extends Controller
{
    public $pageTitle;
    public $pageBody;

    public function __invoke()
    {
        switch (Route::currentRouteName()) {
            case 'home':
                $this->pageTitle = 'Home';
                $this->pageBody = config('page.home');
                break;
            case 'status':
                $this->pageTitle = 'System Status';
                $this->pageBody = config('page.status');
                break;
            case 'terms':
                $this->pageTitle = 'Terms of Service';
                $this->pageBody = config('page.terms');
                break;
            case 'privacy':
                $this->pageTitle = 'Privacy Policy';
                $this->pageBody = config('page.privacy');
                break;
            default:
                return abort(404);
        }
        
        return view('store.page', ['title' => $this->pageTitle, 'body' => $this->pageBody]);
    }
}
