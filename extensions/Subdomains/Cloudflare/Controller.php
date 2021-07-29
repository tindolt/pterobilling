<?php

namespace Extensions\Subdomains\Cloudflare;

use App\Http\Controllers\Controller as HttpController;
use Extensions\ExtensionManager;
use Illuminate\Http\Request;

class Controller extends HttpController
{
    public static $display_name = 'Cloudflare';

    public static function config() {
        return Config::get();
    }

    public static function view() {
        return ExtensionManager::getViewPath('Subdomains/Cloudflare/views');
    }

    public static function seeder() {
        return Seeder::class;
    }

    public static $routes = __DIR__ . '/routes.php';

    /**
     * Return a list of subdomains
     */
    public static function getSubdomains()
    {
        return [];
    }

    /**
     * Update the subdomain name of the server. Return true if
     * success, an error message if failed.
     */
    public static function updateSubdomain($name, $subdomain, $port)
    {
        return true;
        //return '';
    }

    /**
     * Update the port number of the subdomain name. Return true
     * if success, an error message if failed.
     */
    public static function updatePort($name, $subdomain, $port)
    {
        return true;
        //return '';
    }

    /**
     * Manage GET request to the extension settings page in admin area
     */
    public static function show()
    {
        return view('');
    }

    /**
     * Manage POST request to the extension settings page in amin area
     */
    public static function store(Request $request)
    {
        return view('');
    }
}
