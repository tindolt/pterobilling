<?php

namespace Extensions;

class ExtensionManager
{
    /**
     * The extensions that manage custom payment gateways.
     */
    public static $gateways = [
        //\Extensions\Gateways\PayPal\Controller::class,
    ];

    /**
     * The extensions that manage server subdomain names.
     */
    public static $subdomains = [
        //\Extensions\Subdomains\Cloudflare\Controller::class,
    ];

    /**
     * The extensions that upload custom softwares to servers.
     */
    public static $softwares = [
        //\Extensions\Softwares\Minecraft\Controller::class,
    ];

    /**
     * The extensions that manage client registrations and/or logins.
     */
    public static $auth = [];

    /**
     * The extensions that manage custom email notifications.
     */
    public static $email = [];

    /**
     * The extensions that are not classified in the above categories.
     */
    public static $general = [];

    public static function getAllExtensions()
    {
        return array_merge(self::$gateways, self::$subdomains, self::$softwares, self::$auth, self::$email, self::$general);
    }

    public static function getAllConfigs()
    {
        $configs = [];
        foreach (self::getAllExtensions() as $extension) if (method_exists($extension, 'config')) $configs[$extension::$display_name] = $extension::config();
        return $configs;
    }

    public static function getAllViews()
    {
        $views = [];
        foreach (self::getAllExtensions() as $extension) if (method_exists($extension, 'view')) array_push($views, $extension::view());
        return $views;
    }

    public static function getAllSeeders()
    {
        $seeders = [];
        foreach (self::getAllExtensions() as $extension) if (method_exists($extension, 'seeder')) array_push($seeders, $extension::seeder());
        return $seeders;
    }

    public static function getAllRoutes()
    {
        $routes = [];
        foreach (self::getAllExtensions() as $extension) if (property_exists($extension, 'routes')) array_push($routes, $extension::$routes);
        return $routes;
    }

    public static function getViewPath($path)
    {
        return realpath(base_path('extensions/' . $path));
    }
}
