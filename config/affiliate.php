<?php

use App\Models\AffiliateProgram;

$affiliate_program_model = AffiliateProgram::class;

return [
    'enabled' => $affiliate_program_model::where('key', 'enabled')->value('value'),
];
