<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\FetchHackernewsData;

class FetchData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data from hacker news api';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        dispatch(new FetchHackernewsData());

        dd('Data fetched successfully');
    }
}
