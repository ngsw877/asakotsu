<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Zoom\MeetingController;

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
    protected $description = '過去のZoomミーティングを削除します';

    private $meetingController;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MeetingController $meetingController)
    {
        parent::__construct();
        $this->meetingController = $meetingController;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 作成済みのミーティングの、「開始日」と「ステータス」をチェックし、過去のミーティングを削除する
        $this->meetingController->checkStartTimeAndStatusOfMeetings();
        \Log::info('バッチ処理が終了しました。');
    }
}
