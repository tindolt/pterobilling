<?php

namespace Extensions\Softwares\Minecraft;

use Illuminate\Support\Str;

class Controller
{
    public static $display_name = 'Minecraft';

    /**
     * Return the software names and available versions that can be installed
     */
    public static function getSoftwares()
    {
        return [
            'PaperMC' => ['1.17.1', '1.16.5'],
        ];
    }

    /**
     * Upload the software to the server. **Only the file name** is needed to be
     * returned as our system will automatically search for the file inside the
     * '/path/to/pterobilling/extensions/Softwares/`ClassName`/software/' directory, so please **DON'T
     * provide any directory names or trailing slashes!**
     * 
     * @param string $software
     * The chosen software original name, same as the values in `getSoftwares()`
     * 
     * @param string $version
     * The chosen software original version, same as the values in `getSoftwares()`
     * 
     * @return string
     * A file name without any directory names and trailing slashes
     */
    public static function install($software, $version)
    {
        return Str::lower(($software)) . '_' . Str::lower(($version)) . '.jar';
    }
}
