<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Extensions\ExtensionManager;
use Illuminate\Http\Request;

class ExtensionController extends Controller
{
    public function show($id)
    {
        $extension = $this->getExtension($id);
        return $extension::viewSettings();
    }

    public function store(Request $request, $id)
    {
        $extension = $this->getExtension($id);
        return $extension::saveSettings($request);
    }

    private function getExtension($name)
    {
        foreach (ExtensionManager::gateway_extensions() as $extension) {
            if ($this->endsWith($extension, $name))
                return $extension;
        }
        
        foreach (ExtensionManager::subdomain_extensions() as $extension) {
            if ($this->endsWith($extension, $name))
                return $extension;
        }
        
        foreach (ExtensionManager::software_extensions() as $extension) {
            if ($this->endsWith($extension, $name))
                return $extension;
        }
    }

    private function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if (!$length) {
            return true;
        }
        return substr($haystack, -$length) === $needle;
    }
}
