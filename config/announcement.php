<?php

use App\Models\Announcement;

$announcement_model = Announcement::class;

return [
    'enabled' => $announcement_model::where('key', 'enabled')->value('value'),
    'subject' => $announcement_model::where('key', 'subject')->value('value'),
    'content' => $announcement_model::where('key', 'content')->value('value'),
    'theme' => $announcement_model::where('key', 'theme')->value('value'),
];
