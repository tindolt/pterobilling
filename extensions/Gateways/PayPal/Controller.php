<?php

namespace Extensions\Gateways\PayPal;

use App\Http\Controllers\Controller as HttpController;
use App\Models\Extension;
use Extensions\ExtensionManager;
use Illuminate\Http\Request;

class Controller extends HttpController
{
    public static $display_name = 'PayPal';

    public static function config() {
        return Config::get();
    }

    public static function view() {
        return ExtensionManager::getViewPath('Gateways/PayPal/views');
    }

    public static function seeder() {
        return Seeder::class;
    }

    public static $routes = __DIR__ . '/routes.php';

    /**
     * Called when client checkouts via this payment gateway. The
     * client must be redirected to route 'ordered' after sending
     * payment in order to call `verifyPayment()`. He/she must also
     * be redirected to route 'canceled' after canceling.
     */
    public static function toCheckout()
    {
        return redirect('http://example.com');
    }

    /**
     * Called when the client returns to our store from the payment
     * gateway. Return true if payment received, false if failed.
     */
    public static function verifyPayment()
    {
        return true;
    }

    /**
     * Manage GET request to the extension settings page in admin area
     */
    public static function show()
    {
        return view('admin.extension.paypal', ['title' => 'PayPal', 'settings' => Extension::where('extension', 'PayPal')->get()]);
    }

    /**
     * Manage POST request to the extension settings page in amin area
     */
    public static function store(Request $request)
    {
        return back()->with('success_msg', 'You have updated the PayPal extension settings! Please click \'Reload Config\' above on the navigation bar to apply them.');
    }
}
