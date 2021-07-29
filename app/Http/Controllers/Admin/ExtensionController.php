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
        return $extension::show();
    }

    public function store(Request $request, $id)
    {
        $extension = $this->getExtension($id);
        return $extension::store($request);
    }

    private function getExtension($name)
    {
        foreach (ExtensionManager::getAllExtensions() as $extension) if ($extension::$display_name == urldecode($name)) return $extension;
    }
}
