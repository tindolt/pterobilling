<?php

namespace App\Http\Middleware;

class DenyInDemo
{
    /**
     * Handle an incoming request.
     * **This middleware should only be used in the demo version!**
     *
     * @return mixed
     */
    public function handle()
    {
        return back()->with('warning_msg', 'This feature is not available in the demo version!');
    }
}
