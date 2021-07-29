<?php

function to_page($route, $parameters = [])
{
    $url = route($route, $parameters);
    return "href=\"$url\" onclick=\"return false;\" data-href-no-refresh=\"true\"";
}
