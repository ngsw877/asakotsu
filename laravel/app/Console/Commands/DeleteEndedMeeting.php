<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteEndedMeeting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:delete-ended-meeting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '終了したZoomミーティングを削除します';

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
        //
    }
}
