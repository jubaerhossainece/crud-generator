<?php

namespace Jubaerhossainece\CrudGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CrudGeneratorCommand extends Command
{
    protected $signature = 'crud:generate {table}';
    protected $description = 'Generate a complete CRUD operation for a given table';

    public function handle()
    {
        $table = $this->argument('table');
        // Generate the model
        $this->call('make:model', ['name' => 'Models/' . Str::studly(Str::singular($value)($table))]);

        // Generate the controller
        $this->call('make:controller', ['name' => 'Controllers/' . Str::studly(Str::singular($value)($table)) . 'Controller']);

        // Generate the request
        $this->call('make:request', ['name' => 'Requests/' . Str::studly(Str::singular($value)($table)) . 'Request']);

        // Generate the views
        // You can copy the Blade templates from the package's views directory to the Laravel project's views directory.

        // Generate the migration
        $this->call('make:migration', [
            'name' => 'create_' . Str::plural($table) . '_table',
            '--create' => $table,
        ]);

        // Run the migration
        $this->call('migrate');

        // Append CRUD routes to routes/web.php
        $routes = "Route::resource('" . Str::plural($table) . "', '" . Str::studly(Str::singular($value)($table)) . "Controller');";

        file_put_contents(base_path('routes/web.php'), $routes, FILE_APPEND);

        $this->info('CRUD components generated successfully!');
    }
}
