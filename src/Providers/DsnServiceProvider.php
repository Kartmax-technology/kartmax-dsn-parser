<?php

namespace DsnParser\Providers;

use Illuminate\Support\ServiceProvider;
use DsnParser\DsnParser;

class DsnServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Just call the parser. It will set the environment variables by default.
        DsnParser::parse();
    }
}
