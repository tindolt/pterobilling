<?php

use Extensions\ExtensionManager;

foreach (ExtensionManager::getAllRoutes() as $routes) include_once $routes;
