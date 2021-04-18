<?php

namespace Reliese\Command\Blueprint;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Reliese\Analyser\AnalyserFactory;
use Reliese\Coders\Model\Factory;
use Reliese\Command\ConfigurationProfileOptionTrait;
use Reliese\Configuration\RelieseConfigurationFactory;

/**
 * Class ShowBlueprintCommand
 */
class ShowBlueprintCommand extends Command
{
    use ConfigurationProfileOptionTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reliese:blueprint:show
                            {--s|schema= : The name of the MySQL database}
                            {--c|connection= : The name of the connection}
                            {--t|table= : The name of the table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows the information that would be used to generate files after configuration values are applied.';

    /**
     * @var \Reliese\Coders\Model\Factory
     */
    protected $models;

    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * Create a new command instance.
     *
     * @param \Reliese\Coders\Model\Factory $models
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(Factory $models, Repository $config)
    {
        $this->signature .= self::$configurationProfileOptionDescription;
        parent::__construct();

        $this->models = $models;
        $this->config = $config;
    }

    /**
     * Execute the console command.
     *
     * @param AnalyserFactory $analyserFactory
     * @param RelieseConfigurationFactory $relieseConfigurationFactory
     */
    public function handle(
        AnalyserFactory $analyserFactory,
        RelieseConfigurationFactory $relieseConfigurationFactory,
    ) {
        $relieseConfiguration = $relieseConfigurationFactory->getRelieseConfiguration($this->getConfigurationProfileName());
        $connection = $this->getConnection();
        $schema = $this->getSchema($connection);
        $table = $this->getTable();

        /*
         * TODO: allow command line options to modify state of the $relieseConfiguration graph
         */

        /*
         * Create the correct analyser for the configuration profile
         */
        $databaseAnalyser =  $analyserFactory->databaseAnalyser(
            $relieseConfiguration
        );

        /*
         * Allow the $databaseAnalyser to create the Database Blueprint
         */
        $databaseBlueprint = $databaseAnalyser->analyseDatabase($relieseConfiguration->getDatabaseBlueprintConfiguration());

        /*
         * Display the data that would be used to perform code generation
         */
        foreach ($databaseBlueprint->getSchemaBlueprints() as $schemaBlueprint) {
            $this->output->writeln(
                sprintf(
                    $schemaBlueprint->getSchemaName()." has \"%s\" tables",
                    count($schemaBlueprint->getTableBlueprints())
                )
            );
            $tableData = [];
            foreach ($schemaBlueprint->getTableBlueprints() as $tableBlueprint) {
                $tableData[] = [
                    $tableBlueprint->getUniqueName(),
                    \implode(', ', $tableBlueprint->getColumnNames()),
                    \implode(', ', $tableBlueprint->getForeignKeyNames())
                ];
            }
            $this->output->table(
                ['table', 'columns', 'keys'],
                $tableData
            );
        }
    }

    /**
     * @return string
     */
    protected function getConnection()
    {
        return $this->option('connection') ?: $this->config->get('database.default');
    }

    /**
     * @param $connection
     *
     * @return string
     */
    protected function getSchema($connection)
    {
        return $this->option('schema') ?: $this->config->get("database.connections.$connection.database");
    }

    /**
     * @return string
     */
    protected function getTable()
    {
        return $this->option('table');
    }
}
