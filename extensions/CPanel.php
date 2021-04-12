<?php

namespace Extensions;

use Illuminate\Http\Request;

class CPanel
{
    /**
     * This name is shown in the admin area
     */
    public static $display_name = 'cPanel Zone';

    /**
     * Return a list of subdomains
     */
    public static function getSubdomains()
    {
        return [];
    }

    /**
     * Create a subdomain name for the server. Return true if
     * success, an error message if failed.
     */
    public static function createSubdomain($name, $subdomain, $port)
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
     * Change a subdomain name of the server. Return true if
     * success, an error message if failed.
     */
    public static function changeSubdomainName($name, $subdomain, $port)
    {
        return true;
        //return '';
    }

    /**
     * Delete a subdomain name of the server. Return true if
     * success, an error message if failed.
     */
    public static function deleteSubdomain($name, $subdomain)
    {
        return true;
        //return '';
    }

    /**
     * Manage GET request to the extension settings page in admin area
     */
    public static function viewSettings()
    {
        return view('');
    }

    /**
     * Manage POST request to the extension settings page in amin area
     */
    public static function saveSettings(Request $request)
    {
        return view('');
    }
}
