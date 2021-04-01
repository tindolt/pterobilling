<?php

use App\Models\Page;

$page_model = Page::class;

return [
    'home' => $page_model::where('name', 'home')->value('content'),
    'contact' => $page_model::where('name', 'contact')->value('content'),
    'status' => $page_model::where('name', 'status')->value('content'),
    'terms' => $page_model::where('name', 'terms')->value('content'),
    'privacy' => $page_model::where('name', 'privacy')->value('content'),
];
