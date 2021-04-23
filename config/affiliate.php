<?php

use App\Models\AffiliateProgram;

$affiliate_program_model = AffiliateProgram::class;

sleep(3); // To avoid connection errors since this will be the first config file to be processed!

try {
    $enabled = $affiliate_program_model::find(1)->value;
    $conversion = $affiliate_program_model::find(2)->value;
} catch (Throwable $err) {
    $enabled = 'true';
    $conversion = '50';
}

return [
    'enabled' => $enabled,
    'conversion' => $conversion,
];
