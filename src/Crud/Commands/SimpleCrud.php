<?php

namespace Jrb\Simple\Crud\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SimpleCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simple:crud {name : Class (singular) for example User} {--v : with views}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate crud as simple';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Modal name singular first capital
        $name = $this->argument('name');

        if ($this->option('v')) {
            $this->makeViews($name);
        }

        $this->controller($name);
        $this->model($name);
        $this->request($name);
        $this->migration($name);

        File::append(base_path('routes/api.php'), 'Route::resource(\'' . Str::plural(strtolower($name)) . "', '{$name}Controller');");

        echo "\e[0,32;m {$name} crud generated \e\n";
    }

    /**
     * Get the stubs
     * 
     * Give the type of stub and it will get the content.
     * @example Controller, Model or Request
     * 
     * @return string
     */
    protected function getStub($type)
    {
        return file_get_contents(resource_path("views/simple/crud/stubs/$type.stub"));
    }


    /**
     * Create the Model.php file in /app
     *
     * @param string $name
     * @return void
     */
    protected function model($name)
    {
        $modelTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Model')
        );

        file_put_contents(app_path("/{$name}.php"), $modelTemplate);
    }

    /**
     * Create the Controller.php in Http\Controllers
     *
     * @param string $name
     * @return void
     */
    protected function controller($name)
    {
        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                strtolower(Str::plural($name)),
                strtolower($name)
            ],
            $this->getStub('Controller')
        );

        file_put_contents(app_path("/Http/Controllers/{$name}Controller.php"), $controllerTemplate);
    }

    /**
     * Create the Request file in Http\Requests
     *
     * @param string $name
     * @return void
     */
    protected function request($name)
    {
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Request')
        );

        // we check if folder Http\Requests exists
        // by default laravel don't create this file
        if (!file_exists($path = app_path('/Http/Requests')))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Requests/{$name}Request.php"), $requestTemplate);
    }

    /**
     * Create the migration file
     *
     * @param string $name
     * @return void
     */
    protected function migration($name)
    {
        $migrationTempate = str_replace(
            ['{{modelNamePluralFirstCapital}}', '{{modelNamePluralLowerCase}}'],
            [ucfirst(Str::plural($name)), strtolower(Str::plural($name))],
            $this->getStub('Migration')
        );

        file_put_contents(
            database_path("migrations/" . date('Y_m_d_His') . '_create_' . strtolower($name) . "_table.php"),
            $migrationTempate
        );
    }

    protected function makeViews($name)
    {
    }
}
