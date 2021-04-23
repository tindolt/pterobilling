<?php

use App\Models\Announcement;

$announcement_model = Announcement::class;

try {
    $enabled = $announcement_model::where('key', 'enabled')->value('value');
    $subject = $announcement_model::where('key', 'subject')->value('value');
    $content = $announcement_model::where('key', 'content')->value('value');
    $theme = $announcement_model::where('key', 'theme')->value('value');
} catch (\Throwable $th) {
    $enabled = 'true';
    $subject = 'Example Announcement';
    $content = 'You may edit or remove me in the admin area.';
    $theme = '0';
}

return [
    'enabled' => $enabled,
    'subject' => $subject,
    'content' => $content,
    'theme' => $theme,
];
