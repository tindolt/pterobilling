<?php

use App\Models\AffiliateProgram;

$affiliate_program_model = AffiliateProgram::class;

return [
    'enabled' => $affiliate_program_model::find(1)->value,
    'conversion' => $affiliate_program_model::find(2)->value,
];
