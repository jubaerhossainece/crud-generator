<?php

namespace Jubaerhossainece\CrudGenerator;

use Illuminate\Support\ServiceProvider;
use Commands\CrudGeneratorCommand;

class CrudGeneratorServiceProvider extends ServiceProvider{

    public function register()
    {
        $this->commands([
            CrudGeneratorCommand::class,
        ]);
    }

    public function boot()
    {
        // Publish any assets or configuration files if needed.
    }
}

