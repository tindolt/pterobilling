<?php

namespace App\Http\Middleware;

class ComingSoon
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle()
    {
        return back()->with('warning_msg', 'Sorry, but this feature hasn\'t been released yet.');
    }
}
