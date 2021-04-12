<?php

namespace Extensions;

class ExtensionManager
{
    /**
     * Enable the extensions that manage custom payment gateways.
     */
    public static function gateway_extensions() {
        return [
            PayPal::class,
        ];
    }

    /**
     * Enable the extensions that manage server subdomain names.
     */
    public static function subdomain_extensions() {
        return [
            Cloudflare::class,
            #CPanel::class,
        ];
    }

    /**
     * Enable the extensions that upload custom softwares to servers.
     */
    public static function software_extensions() {
        return [
            Minecraft::class,
        ];
    }

}