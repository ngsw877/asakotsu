<?php

namespace App\Console\Commands\User;

use App\Services\User\UserServiceInterface;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SoftDeleteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:soft-delete-user {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '指定したアカウントを論理削除します。';

    private UserServiceInterface $userService;

    /**
     * Create a new command instance.
     *
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws Exception
     */
    public function handle(): int
    {
        $userId = $this->argument('userId');

        return DB::transaction(function () use ($userId) {
           $user = $this->userService->delete($userId);

            echo 'アカウント「' . $user->name . '」を論理削除しました。' . PHP_EOL;

            return 0;
        });

    }
}
