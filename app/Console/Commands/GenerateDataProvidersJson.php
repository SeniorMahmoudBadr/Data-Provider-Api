<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Database\Factories\DataProviderXFactory;
use Database\Factories\DataProviderYFactory;

class GenerateDataProvidersJson extends Command
{
    protected $signature = 'generate:dataproviders-json';
    protected $description = 'Generate data for DataProviderX and DataProviderY and save it to JSON files';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        ini_set('memory_limit', '512M');

        $dataProviderX = DataProviderXFactory::new()->count(50000)->make()->toArray();
        $dataProviderY = DataProviderYFactory::new()->count(25000)->make()->toArray();

        $dataProviderXPath = storage_path('app/DataProviderX.json');
        $dataProviderYPath = storage_path('app/DataProviderY.json');

        File::put($dataProviderXPath, json_encode($dataProviderX, JSON_PRETTY_PRINT));
        File::put($dataProviderYPath, json_encode($dataProviderY, JSON_PRETTY_PRINT));

        $this->info('Data generated and saved to JSON files successfully.');
    }
}
