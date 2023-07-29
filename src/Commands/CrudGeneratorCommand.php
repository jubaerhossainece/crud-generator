<?php

namespace Jubaerhossainece\CrudGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CrudGeneratorCommand extends Command
{
    protected $signature = 'crud:generate {table}';
    protected $description = 'Generate a complete CRUD operation for a given table';

    public function handle()
    {
        $table = $this->argument('table');
        // Generate the model
        $this->call('make:model', ['name' => Str::studly(Str::singular($table))]);

        // Generate the controller
        $this->call('make:controller', ['name' => Str::studly(Str::singular($table)) . 'Controller', '--resource' => true]);

        // Generate the request
        $this->call('make:request', ['name' => Str::studly(Str::singular($table)) . 'Request']);

        // Generate the views
        $viewsPath = base_path('resources/views/') . Str::plural($table);
        File::copyDirectory(__DIR__ . '/../views', $viewsPath);

        // Generate the migration
        $this->call('make:migration', [
            'name' => 'create_' . Str::plural($table) . '_table',
            '--create' => $table,
        ]);

        // Run the migration
        $this->call('migrate');

        // Append CRUD routes to routes/web.php
        $routes = "Route::resource('" . Str::plural($table) . "', '" . Str::studly(Str::singular($table)) . "Controller::class');";

        file_put_contents(base_path('routes/web.php'), $routes, FILE_APPEND);

        $this->info('CRUD components generated successfully!');
    }
}
